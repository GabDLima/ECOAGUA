<?php

namespace App\DAO;

use App\DAO;
use App\Model\ConsumoDiarioModel;
use FW\Controller\FuncoesGlobais;

class ConsumoDiarioDAO extends DAO{

    public function inserir($obj) {
        try{
            $data_consumo = $obj->__get('data_consumo');
            $quantidade = $obj->__get('quantidade');
            $unidade = $obj->__get('unidade');
            $id_usuario = $obj->__get('id_usuario');
            $tipo = $obj->__get('tipo');

            $sql = "INSERT INTO consumo_diario (
                        data_consumo,
                        quantidade,
                        unidade,
                        id_usuario,
                        tipo
                    ) VALUES (
                        :data_consumo,
                        :quantidade,
                        :unidade,
                        :id_usuario,
                        :tipo
                    )";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':data_consumo', $data_consumo);   
            $stmt->bindValue(':quantidade', $quantidade);
            $stmt->bindValue(':unidade', $unidade);   
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':tipo', $tipo);
            $stmt->execute();
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }
    }

    /**
     * Busca os últimos 7 dias de consumo do usuário
     */
    public function buscarUltimos7Dias($id_usuario) {
        try {
            $consumos = array();
            $sql = "SELECT 
                        data_consumo,
                        quantidade,
                        unidade,
                        tipo
                    FROM 
                        consumo_diario
                    WHERE
                        id_usuario = :id_usuario
                    ORDER BY 
                        data_consumo DESC
                    LIMIT 7
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $row){
                $consumoModel = new ConsumoDiarioModel();
                $global = new FuncoesGlobais();
                $global->popularModel($consumoModel, $row);
                array_push($consumos, $consumoModel);
            }
            return $consumos;
        }
        catch(\PDOException $ex){
            return array();
        }    
    }

    /**
     * Busca consumo mensal agrupado (soma total)
     */
    public function buscarConsumoMensal($id_usuario, $meses = 6) {
        try {
            $sql = "SELECT 
                        DATE_FORMAT(data_consumo, '%Y-%m') as mes,
                        DATE_FORMAT(data_consumo, '%b') as mes_nome,
                        SUM(
                            CASE 
                                WHEN unidade = 'L' THEN quantidade
                                WHEN unidade = 'mL' THEN quantidade / 1000
                                WHEN unidade = 'm³' THEN quantidade * 1000
                                ELSE quantidade
                            END
                        ) as total_litros
                    FROM 
                        consumo_diario
                    WHERE
                        id_usuario = :id_usuario
                        AND data_consumo >= DATE_SUB(CURDATE(), INTERVAL :meses MONTH)
                    GROUP BY 
                        DATE_FORMAT(data_consumo, '%Y-%m'),
                        DATE_FORMAT(data_consumo, '%b')
                    ORDER BY 
                        mes ASC
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':meses', $meses, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $ex){
            return array();
        }    
    }

    /**
     * Busca consumo por tipo (Pizza/Doughnut chart)
     */
    public function buscarConsumoPorTipo($id_usuario, $mes = null, $ano = null) {
        try {
            $sql = "SELECT 
                        tipo,
                        SUM(
                            CASE 
                                WHEN unidade = 'L' THEN quantidade
                                WHEN unidade = 'mL' THEN quantidade / 1000
                                WHEN unidade = 'm³' THEN quantidade * 1000
                                ELSE quantidade
                            END
                        ) as total_litros
                    FROM 
                        consumo_diario
                    WHERE
                        id_usuario = :id_usuario
                   ";
            
            if ($mes && $ano) {
                $sql .= " AND MONTH(data_consumo) = :mes AND YEAR(data_consumo) = :ano";
            }
            
            $sql .= " GROUP BY tipo ORDER BY total_litros DESC";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            
            if ($mes && $ano) {
                $stmt->bindValue(':mes', $mes, \PDO::PARAM_INT);
                $stmt->bindValue(':ano', $ano, \PDO::PARAM_INT);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $ex){
            return array();
        }    
    }

    /**
     * Busca total de consumo do mês atual em litros
     */
    public function buscarTotalMesAtual($id_usuario) {
        try {
            $sql = "SELECT 
                        SUM(
                            CASE 
                                WHEN unidade = 'L' THEN quantidade
                                WHEN unidade = 'mL' THEN quantidade / 1000
                                WHEN unidade = 'm³' THEN quantidade * 1000
                                ELSE quantidade
                            END
                        ) as total_litros
                    FROM 
                        consumo_diario
                    WHERE
                        id_usuario = :id_usuario
                        AND MONTH(data_consumo) = MONTH(CURDATE())
                        AND YEAR(data_consumo) = YEAR(CURDATE())
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result['total_litros'] ?? 0;
        }
        catch(\PDOException $ex){
            return 0;
        }    
    }

    /**
     * Busca consumo do mês anterior
     */
    public function buscarTotalMesAnterior($id_usuario) {
        try {
            $sql = "SELECT 
                        SUM(
                            CASE 
                                WHEN unidade = 'L' THEN quantidade
                                WHEN unidade = 'mL' THEN quantidade / 1000
                                WHEN unidade = 'm³' THEN quantidade * 1000
                                ELSE quantidade
                            END
                        ) as total_litros
                    FROM 
                        consumo_diario
                    WHERE
                        id_usuario = :id_usuario
                        AND MONTH(data_consumo) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                        AND YEAR(data_consumo) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result['total_litros'] ?? 0;
        }
        catch(\PDOException $ex){
            return 0;
        }    
    }

    /**
     * Busca consumo por mês específico (para comparar com meta)
     */
    public function buscarConsumoPorMes($id_usuario, $mes, $ano) {
        try {
            $sql = "SELECT 
                        SUM(
                            CASE 
                                WHEN unidade = 'L' THEN quantidade
                                WHEN unidade = 'mL' THEN quantidade / 1000
                                WHEN unidade = 'm³' THEN quantidade * 1000
                                ELSE quantidade
                            END
                        ) as total_litros
                    FROM 
                        consumo_diario
                    WHERE
                        id_usuario = :id_usuario
                        AND MONTH(data_consumo) = :mes
                        AND YEAR(data_consumo) = :ano
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':mes', $mes, \PDO::PARAM_INT);
            $stmt->bindValue(':ano', $ano, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result['total_litros'] ?? 0;
        }
        catch(\PDOException $ex){
            return 0;
        }    
    }

    public function listar(){
        try{
            $consumos = array();
            $sql = "SELECT * FROM consumo_diario ORDER BY data_consumo DESC";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $row){
                $consumoModel = new ConsumoDiarioModel();
                $global = new FuncoesGlobais();
                $global->popularModel($consumoModel, $row);
                array_push($consumos, $consumoModel);
            }
            return $consumos;
        }
        catch(\PDOException $ex){
            return array();
        }    
    }

    public function excluir($obj) {}
    public function alterar($obj) {}
    public function buscarPorId($id){ }
    public function buscarPorLogado($id){}
}