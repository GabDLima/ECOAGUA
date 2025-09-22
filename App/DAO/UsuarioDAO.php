<?php

namespace App\DAO;

use App\DAO;
use App\Model\UsuarioModel;
use FW\Controller\FuncoesGlobais;


class UsuarioDAO extends DAO{

    public function inserir($obj) {
        try{

            $user_cpf = $obj->__get('user_cpf');
            $user_nome = $obj->__get('user_nome');
            $user_email = $obj->__get('user_email');
            $user_senha = $obj->__get('user_senha');

            $sql = "INSERT INTO usuarios (
                        cpf,
                        nome,
                        email,
                        senha
                    ) VALUES (
                        :user_cpf,
                        :user_nome,
                        :user_email,
                        :user_senha
                    )";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':user_cpf', $user_cpf);   
            $stmt->bindValue(':user_nome', $user_nome);
            $stmt->bindValue(':user_email', $user_email);
            $stmt->bindValue(':user_senha', $user_senha);
            $stmt->execute();
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }
    }

    public function alterar($obj) {
        try{

            $user_cpf = $obj->__get('user_cpf');
            $user_nome = $obj->__get('user_nome');
            $user_email = $obj->__get('user_email');

            $sql = "UPDATE usuarios
                    SET (
                        cpf,
                        nome,
                        email
                    ) VALUES (
                        :user_cpf,
                        :user_nome,
                        :user_email
                    )
                    WHERE id=";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':user_cpf', $user_cpf);   
            $stmt->bindValue(':user_nome', $user_nome);
            $stmt->bindValue(':user_email', $user_email);
            $stmt->execute();
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }
    }

    public function procurar_login($email){
           
        try{
            $sql = "SELECT senha FROM `usuarios` WHERE email='$email'";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach($result as $row){
                $senha = $row;
            }
            return $senha;
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }    
    }

    public function puxar_login($email){
           
        try{
            $sql = "SELECT id, nome FROM `usuarios` WHERE email='$email'";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach($result as $row){
                $usuario_logado = $row;
            }
            return $usuario_logado;
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
    public function buscarPorId($id){ }
    public function buscarPorLogado($id){}
}
