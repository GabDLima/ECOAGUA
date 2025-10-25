<?php

namespace App\DAO;

use App\DAO;
use App\Model\MetaConsumoModel;
use FW\Controller\FuncoesGlobais;

class MetaConsumoDAO extends DAO{

    public function inserir($obj) {
        try{
            $meta_mensal = $obj->__get('meta_mensal');
            $meta_reducao = $obj->__get('meta_reducao');
            $prazo = $obj->__get('prazo');
            $usuario_id = $obj->__get('usuario_id');

            $sql = "INSERT INTO meta_consumo (
                        meta_mensal,
                        meta_reducao,
                        prazo,
                        usuario_id
                    ) VALUES (
                        :meta_mensal,
                        :meta_reducao,
                        :prazo,
                        :usuario_id
                    )";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':meta_mensal', $meta_mensal);   
            $stmt->bindValue(':meta_reducao', $meta_reducao);
            $stmt->bindValue(':prazo', $prazo);   
            $stmt->bindValue(':usuario_id', $usuario_id);
            $stmt->execute();
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }
    }

    /**
     * Busca a meta mais recente do usuário (considera como "ativa")
     */
    public function buscarMetaAtiva($id_usuario) {
        try {
            $sql = "SELECT 
                        meta_mensal,
                        meta_reducao,
                        prazo,
                        id
                    FROM 
                        meta_consumo
                    WHERE
                        usuario_id = :usuario_id
                    ORDER BY 
                        id DESC
                    LIMIT 1
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':usuario_id', $id_usuario);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $ex){
            return null;
        }    
    }

    /**
     * Calcula o progresso da meta (% consumido)
     * Retorna array com informações completas
     */
    public function calcularProgressoMeta($id_usuario) {
        try {
            // Busca meta ativa
            $meta = $this->buscarMetaAtiva($id_usuario);
            
            if (!$meta) {
                return null;
            }
            
            // Busca consumo do mês atual
            $consumoDAO = new ConsumoDiarioDAO();
            $consumo_atual = $consumoDAO->buscarTotalMesAtual($id_usuario);
            
            $meta_litros = $meta['meta_mensal'];
            $percentual = $meta_litros > 0 ? ($consumo_atual / $meta_litros) * 100 : 0;
            $restante = $meta_litros - $consumo_atual;
            
            return array(
                'meta_litros' => $meta_litros,
                'consumo_atual' => $consumo_atual,
                'percentual' => round($percentual, 1),
                'restante' => $restante,
                'meta_reducao' => $meta['meta_reducao'],
                'prazo' => $meta['prazo'],
                'alerta' => $percentual >= 90 // True se passou de 90%
            );
        }
        catch(\PDOException $ex){
            return null;
        }    
    }

    /**
     * Busca todas as metas do usuário (histórico)
     */
    public function listarPorUsuario($id_usuario) {
        try {
            $metas = array();
            $sql = "SELECT 
                        *
                    FROM 
                        meta_consumo
                    WHERE
                        usuario_id = :usuario_id
                    ORDER BY 
                        id DESC
                   ";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':usuario_id', $id_usuario);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $row){
                $metaModel = new MetaConsumoModel();
                $global = new FuncoesGlobais();
                $global->popularModel($metaModel, $row);
                array_push($metas, $metaModel);
            }
            return $metas;
        }
        catch(\PDOException $ex){
            return array();
        }    
    }

    public function listar(){
        try{
            $metas = array();
            $sql = "SELECT * FROM meta_consumo ORDER BY id DESC";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $row){
                $metaModel = new MetaConsumoModel();
                $global = new FuncoesGlobais();
                $global->popularModel($metaModel, $row);
                array_push($metas, $metaModel);
            }
            return $metas;
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