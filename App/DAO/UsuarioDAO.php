<?php

namespace App\DAO;

use App\DAO;
use App\Model\UsuarioModel;
use FW\Controller\FuncoesGlobais;

class UsuarioDAO extends DAO {

    public function inserir($obj) {
        try {
            $user_cpf   = $obj->__get('user_cpf');
            $user_nome  = $obj->__get('user_nome');
            $user_email = $obj->__get('user_email');
            $user_senha = $obj->__get('user_senha');
            $senha_hash = password_hash($user_senha, PASSWORD_DEFAULT);

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
            $stmt->bindValue(':user_senha', $senha_hash);
            $stmt->execute();
        }
        catch(\PDOException $ex) {
            error_log("Erro ao inserir usuário: " . $ex->getMessage());
            return false;
        }
        return true;
    }

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
            error_log("Erro ao alterar usuário: " . $ex->getMessage());
            return false;
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT
                        id,
                        cpf,
                        nome,
                        email,
                        dark_mode,
                        unidade_padrao,
                        notif_alerta_meta,
                        notif_lembrete_fatura,
                        notif_dicas,
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
            error_log("Erro ao buscar usuário por ID: " . $ex->getMessage());
            return null;
        }
    }

    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT
                        id,
                        cpf,
                        nome,
                        email,
                        senha,
                        dark_mode
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
            error_log("Erro ao buscar usuário por email: " . $ex->getMessage());
            return null;
        }
    }

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
            error_log("Erro ao verificar email existente: " . $ex->getMessage());
            return false;
        }
    }

    public function alterarSenha($obj) {
        try {
            $user_id    = $obj->__get('user_id');
            $user_senha = $obj->__get('user_senha');
            $senha_hash = password_hash($user_senha, PASSWORD_DEFAULT);

            $sql = "UPDATE usuarios
                    SET
                        senha = :user_senha,
                        updated_at = NOW()
                    WHERE id = :id";

            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':user_senha', $senha_hash);
            $stmt->bindValue(':id', $user_id, \PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }
        catch(\PDOException $ex) {
            error_log("Erro ao alterar senha: " . $ex->getMessage());
            return false;
        }
    }

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
            error_log("Erro ao procurar login: " . $ex->getMessage());
            return null;
        }
    }

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
            error_log("Erro ao puxar login: " . $ex->getMessage());
            return null;
        }
    }

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
            error_log("Erro ao listar usuários: " . $ex->getMessage());
            return [];
        }
    }

    public function buscarPorLogado($id) {
        return $this->buscarPorId($id);
    }

    public function alterarDarkMode($id, $dark_mode) {
        try {
            $sql = "UPDATE usuarios
                    SET dark_mode = :dark_mode,
                        updated_at = NOW()
                    WHERE id = :id";

            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':dark_mode', $dark_mode, \PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }
        catch(\PDOException $ex) {
            error_log("Erro ao alterar dark mode: " . $ex->getMessage());
            return false;
        }
    }

    public function excluir($obj) {
    }

    public function atualizarPreferenciasNotificacao($id, $alertaMeta, $lembreteFatura, $dicas) {
        try {
            $sql = "UPDATE usuarios SET notif_alerta_meta = ?, notif_lembrete_fatura = ?, notif_dicas = ? WHERE id = ?";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute([(int)$alertaMeta, (int)$lembreteFatura, (int)$dicas, (int)$id]);
            return $stmt->rowCount() > 0;
        } catch(\PDOException $ex) {
            error_log("Erro ao atualizar preferências de notificação: " . $ex->getMessage());
            return false;
        }
    }

    public function atualizarUnidadePadrao($id, $unidade) {
        try {
            $sql = "UPDATE usuarios SET unidade_padrao = ? WHERE id = ?";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute([$unidade, (int)$id]);
            return $stmt->rowCount() > 0;
        } catch(\PDOException $ex) {
            error_log("Erro ao atualizar unidade padrão: " . $ex->getMessage());
            return false;
        }
    }
}
