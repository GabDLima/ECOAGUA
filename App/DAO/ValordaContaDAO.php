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

            $sql = "INSERT INTO valordaconta (
                        mes_da_fatura,
                        valor
                    ) VALUES (
                        :mes_da_fatura,
                        :valor
                    )";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':mes_da_fatura', $mes_da_fatura);   
            $stmt->bindValue(':valor', $valor);
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
