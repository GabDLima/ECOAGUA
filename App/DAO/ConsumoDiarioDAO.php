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

            $sql = "INSERT INTO consumo_diario (
                        data_consumo,
                        quantidade,
                        unidade,
                        id_usuario
                    ) VALUES (
                        :data_consumo,
                        :quantidade,
                        :unidade,
                        :id_usuario
                    )";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':data_consumo', $data_consumo);   
            $stmt->bindValue(':quantidade', $quantidade);
            $stmt->bindValue(':unidade', $unidade);   
            $stmt->bindValue(':id_usuario', $id_usuario);
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
