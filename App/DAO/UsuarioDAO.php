<?php

namespace App\DAO;

use App\DAO;
use App\Model\UsuarioModel;
use FW\Controller\FuncoesGlobais;

class UsuarioDAO extends DAO {

    /**
     * Insere um novo usuário
     */
    public function inserir($obj) {
        try {
            $user_cpf   = $obj->__get('user_cpf');
            $user_nome  = $obj->__get('user_nome');
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
        catch(\PDOException $ex) {
            header('Location:/error103');
            die();
        }
    }

    /**
     * Atualiza informações do usuário (nome e email)
     */
    public function alterar($obj) {
        try {
            $user_id    = $obj->__get('user_id');
            $user_nome  = $obj->__get('user_nome');
            $user_email = $obj->__get('user_email');

            $sql = "UPDATE usuarios 
                    SET 
                        nome = :user_nome,
                        email = :user_email,
                        updated_at = NOW()
                    WHERE id = :id";

            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':user_nome', $user_nome);
            $stmt->bindValue(':user_email', $user_email);
            $stmt->bindValue(':id', $user_id, \PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }
        catch(\PDOException $ex) {
            return false;
        }
    }

    /**
     * Busca usuário por ID
     */
    public function buscarPorId($id) {
        try {
            $sql = "SELECT 
                        id,
                        cpf,
                        nome,
                        email,
                        created_at
                    FROM 
                        usuarios
                    WHERE
                        id = :id
                    LIMIT 1";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $ex){
            return null;
        }    
    }

    /**
     * Busca usuário por email (para login)
     */
    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT 
                        id,
                        cpf,
                        nome,
                        email,
                        senha
                    FROM 
                        usuarios
                    WHERE
                        email = :email
                    LIMIT 1";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $ex){
            return null;
        }    
    }

    /**
     * Verifica se email já existe (para evitar duplicatas)
     */
    public function emailExiste($email, $excluirId = null) {
        try {
            $sql = "SELECT COUNT(*) as total FROM usuarios WHERE email = :email";
            
            if ($excluirId) {
                $sql .= " AND id != :id";
            }
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':email', $email);
            
            if ($excluirId) {
                $stmt->bindValue(':id', $excluirId, \PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result['total'] > 0;
        }
        catch(\PDOException $ex){
            return false;
        }    
    }

    /**
     * Altera a senha do usuário
     */
    public function alterarSenha($obj) {
        try {
            $user_id    = $obj->__get('user_id');
            $user_senha = $obj->__get('user_senha');

            $sql = "UPDATE usuarios
                    SET 
                        senha = :user_senha,
                        updated_at = NOW()
                    WHERE id = :id";
            
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':user_senha', $user_senha);
            $stmt->bindValue(':id', $user_id, \PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }
        catch(\PDOException $ex) {
            return false;
        } 
    }

    /**
     * Método usado no login (retorna hash da senha)
     */
    public function procurar_login($email) {
        try {
            $sql = "SELECT senha FROM usuarios WHERE email = :email";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ?: null;
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }    
    }

    /**
     * Retorna dados do usuário logado (ID, nome, CPF)
     */
    public function puxar_login($email) {
        try {
            $sql = "SELECT id, nome, cpf FROM usuarios WHERE email = :email";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ?: null;
        }
        catch(\PDOException $ex){
            header('Location:/error103');
            die();
        }    
    }

    /**
     * Lista todos os usuários cadastrados
     */
    public function listar() {
        try {
            $usuarios = [];
            $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $row){
                $usuarioModel = new UsuarioModel();
                $global = new FuncoesGlobais();
                $global->popularModel($usuarioModel, $row);
                array_push($usuarios, $usuarioModel);
            }
            return $usuarios;
        }
        catch(\PDOException $ex){
            return [];
        }    
    }

    /**
     * Retorna dados do usuário logado (por ID)
     */
    public function buscarPorLogado($id) {
        return $this->buscarPorId($id);
    }

    public function excluir($obj) {
        // Implementar se necessário
    }
}
