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
            //$usuario_id = $obj->__get('usuario_id');

            $sql = "INSERT INTO meta_consumo (
                        meta_mensal,
                        meta_reducao,
                        prazo
                    ) VALUES (
                        :meta_mensal,
                        :meta_reducao,
                        :prazo
                    )";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':meta_mensal', $meta_mensal);   
            $stmt->bindValue(':meta_reducao', $meta_reducao);
            $stmt->bindValue(':prazo', $prazo);   
            //$stmt->bindValue(':usuario_id', $usuario_id);
            $stmt->execute();
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }
    }

    public function listar(){
           
        try{
            $alunos = array();
            $sql = "SELECT 
                            a.*, 
                            l.log_email 
                        FROM 
                            alunos a,
                            login l
                        WHERE
                            ad.fk_login_log_id = l.log_id
                    ";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $row){
                $alunosModel = new AlunosModel();
                
                $global = new FuncoesGlobais();
                $global->popularModel($alunosModel, $row);

                array_push($alunos, $alunosModel);
            }
            return $alunos;
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }    
    }

    public function excluir($obj) {}
    public function alterar($obj) {}
    public function buscarPorId($id){ }
    public function buscarPorLogado($id){}
}
