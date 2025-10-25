<?php

namespace App\DAO;

use App\DAO;
use App\Model\ValordaContaModel;
use FW\Controller\FuncoesGlobais;

class ValordaContaDAO extends DAO{

    public function inserir($obj) {
        try{
            $mes_da_fatura = $obj->__get('mes_da_fatura');
            $valor = $obj->__get('valor');
            $id_usuario = $obj->__get('id_usuario');

            $sql = "INSERT INTO valordaconta (
                        mes_da_fatura,
                        valor,
                        id_usuario                 
                    ) VALUES (
                        :mes_da_fatura,
                        :valor,
                        :id_usuario
                    )";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':mes_da_fatura', $mes_da_fatura);   
            $stmt->bindValue(':valor', $valor);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->execute();
        }
        catch(\PDOException $ex){
            header('Location:/error104');
            die();
        }
    }

    /**
     * Busca a última fatura registrada do usuário
     */
    public function buscarUltimaFatura($id_usuario) {
        try {
            $sql = "SELECT 
                        mes_da_fatura,
                        valor
                    FROM 
                        valordaconta
                    WHERE
                        id_usuario = :id_usuario
                    ORDER BY 
                        mes_da_fatura DESC
                    LIMIT 1
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $ex){
            return null;
        }    
    }

    /**
     * Busca faturas dos últimos meses
     */
    public function buscarFaturasRecentes($id_usuario, $meses = 6) {
        try {
            $sql = "SELECT 
                        DATE_FORMAT(mes_da_fatura, '%b') as mes_nome,
                        DATE_FORMAT(mes_da_fatura, '%Y-%m') as mes,
                        valor
                    FROM 
                        valordaconta
                    WHERE
                        id_usuario = :id_usuario
                        AND mes_da_fatura >= DATE_SUB(CURDATE(), INTERVAL :meses MONTH)
                    ORDER BY 
                        mes_da_fatura ASC
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
     * Calcula o total gasto no ano
     */
    public function buscarTotalGastoAno($id_usuario, $ano = null) {
        try {
            if (!$ano) {
                $ano = date('Y');
            }
            
            $sql = "SELECT 
                        SUM(valor) as total_gasto
                    FROM 
                        valordaconta
                    WHERE
                        id_usuario = :id_usuario
                        AND YEAR(mes_da_fatura) = :ano
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':ano', $ano, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result['total_gasto'] ?? 0;
        }
        catch(\PDOException $ex){
            return 0;
        }    
    }

    /**
     * Busca a média de gasto mensal
     */
    public function buscarMediaMensal($id_usuario, $meses = 6) {
        try {
            $sql = "SELECT 
                        AVG(valor) as media_valor
                    FROM 
                        valordaconta
                    WHERE
                        id_usuario = :id_usuario
                        AND mes_da_fatura >= DATE_SUB(CURDATE(), INTERVAL :meses MONTH)
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':meses', $meses, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result['media_valor'] ?? 0;
        }
        catch(\PDOException $ex){
            return 0;
        }    
    }

    public function listar(){
        try{
            $faturas = array();
            $sql = "SELECT * FROM valordaconta ORDER BY mes_da_fatura DESC";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $row){
                $faturaModel = new ValordaContaModel();
                $global = new FuncoesGlobais();
                $global->popularModel($faturaModel, $row);
                array_push($faturas, $faturaModel);
            }
            return $faturas;
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