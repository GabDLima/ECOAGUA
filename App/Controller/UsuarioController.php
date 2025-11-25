<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\UsuarioDAO;
use App\Model\UsuarioModel;

class UsuarioController extends Action{

    public function editar(){
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] == 0) {
            header('Location: /');
            exit;
        }

        $id_usuario = $_SESSION['usuario_id'];
        $nome = trim($_POST['USER_NOME'] ?? '');
        $email = trim($_POST['USER_EMAIL'] ?? '');

        if (empty($nome) || empty($email)) {
            $_SESSION['erro_edicao'] = 'Nome e email são obrigatórios';
            header('Location: /menu');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro_edicao'] = 'Email inválido';
            header('Location: /menu');
            exit;
        }

        $usuarioDAO = new UsuarioDAO();

        if ($usuarioDAO->emailExiste($email, $id_usuario)) {
            $_SESSION['erro_edicao'] = 'Este email já está sendo usado por outro usuário';
            header('Location: /menu');
            exit;
        }

        $usuario = new UsuarioModel();
        $usuario->__set('user_id', $id_usuario);
        $usuario->__set('user_nome', $nome);
        $usuario->__set('user_email', $email);

        $sucesso = $usuarioDAO->alterar($usuario);

        if ($sucesso) {
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['perfil_atualizado'] = 1;
            header('Location: /menu');
        } else {
            $_SESSION['erro_edicao'] = 'Erro ao atualizar perfil';
            header('Location: /menu');
        }

        exit;
    }

    public function alteraSenha(){
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] == 0) {
            header('Location: /');
            exit;
        }

        $id_usuario = $_SESSION['usuario_id'];
        $senhaAtual = $_POST['SENHA_ATUAL'] ?? '';
        $novaSenha = $_POST['NOVA_SENHA'] ?? '';
        $confirmarSenha = $_POST['CONFIRMAR_SENHA'] ?? '';

        if (empty($senhaAtual) || empty($novaSenha) || empty($confirmarSenha)) {
            $_SESSION['erro_senha'] = 'Todos os campos são obrigatórios';
            header('Location: /redefinirSenha');
            exit;
        }

        if ($novaSenha !== $confirmarSenha) {
            $_SESSION['erro_senha'] = 'As senhas não coincidem';
            header('Location: /redefinirSenha');
            exit;
        }

        if (strlen($novaSenha) < 6) {
            $_SESSION['erro_senha'] = 'A senha deve ter no mínimo 6 caracteres';
            header('Location: /redefinirSenha');
            exit;
        }

        $usuarioDAO = new UsuarioDAO();
        $usuarioAtual = $usuarioDAO->buscarPorId($id_usuario);

        if (!$usuarioAtual) {
            $_SESSION['erro_senha'] = 'Usuário não encontrado';
            header('Location: /redefinirSenha');
            exit;
        }

        if ($usuarioAtual['senha'] !== $senhaAtual) {
            $_SESSION['erro_senha'] = 'Senha atual incorreta';
            header('Location: /redefinirSenha');
            exit;
        }

        $usuario = new UsuarioModel();
        $usuario->__set('user_id', $id_usuario);
        $usuario->__set('user_senha', $novaSenha);

        $sucesso = $usuarioDAO->alterarSenha($usuario);

        if ($sucesso) {
            $_SESSION['senha_alterada'] = 1;
            header('Location: /menu');
        } else {
            $_SESSION['erro_senha'] = 'Erro ao alterar senha';
            header('Location: /redefinirSenha');
        }

        exit;
    }

    public function inserirUsuario(){
        $user_cpf = trim($_POST['USER_CPF'] ?? '');
        $user_nome = trim($_POST['USER_NOME'] ?? '');
        $user_email = trim($_POST['USER_EMAIL'] ?? '');
        $user_senha = $_POST['USER_SENHA'] ?? '';
        $user_senha_2 = $_POST['USER_SENHA_2'] ?? '';

        if (empty($user_cpf) || empty($user_nome) || empty($user_email) || empty($user_senha)) {
            $_SESSION['erro_cadastro'] = 'Todos os campos são obrigatórios';
            header('Location: /');
            exit;
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro_cadastro'] = 'Email inválido';
            header('Location: /');
            exit;
        }

        if ($user_senha !== $user_senha_2) {
            $_SESSION['senhas_nao_conferem'] = 1;
            header('Location: /');
            exit;
        }

        if (strlen($user_senha) < 6) {
            $_SESSION['erro_cadastro'] = 'A senha deve ter no mínimo 6 caracteres';
            header('Location: /');
            exit;
        }

        $usuarioDAO = new UsuarioDAO();

        if ($usuarioDAO->emailExiste($user_email)) {
            $_SESSION['erro_cadastro'] = 'Este email já está cadastrado';
            header('Location: /');
            exit;
        }

        $usuario = new UsuarioModel();
        $usuario->__set("user_cpf", $user_cpf);
        $usuario->__set("user_nome", $user_nome);
        $usuario->__set("user_email", $user_email);
        $usuario->__set("user_senha", $user_senha);

        $usuarioDAO->inserir($usuario);
        $_SESSION['usuario_cadastrado'] = 1;

        header('Location: /');
        exit;
    }


    public function validaAutenticacao() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] == 0) {
            header('Location: /');
            exit;
        }
    }

    public function login(){
        $email = trim($_POST['EMAIL'] ?? '');
        $senha = $_POST['SENHA'] ?? '';

        if (empty($email) || empty($senha)) {
            $_SESSION['mensagem_login_incorreto'] = 1;
            header('Location: /');
            exit;
        }

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorEmail($email);

        if (!$usuario || $usuario['senha'] !== $senha) {
            $_SESSION['mensagem_login_incorreto'] = 1;
            header('Location: /');
            exit;
        }

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_cpf'] = $usuario['cpf'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['dark_mode'] = $usuario['dark_mode'] ?? 0;
        $_SESSION['login_realizado'] = 1;

        header('Location: /dashboard');
        exit;
    }

    public function logout(){
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        session_start();
        $_SESSION['usuario_desconectado'] = 1;

        header('Location: /');
        exit;
    }

    public function toggleDarkMode(){
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] == 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Não autorizado']);
            exit;
        }

        $id_usuario = $_SESSION['usuario_id'];
        $dark_mode = isset($_POST['dark_mode']) ? (int)$_POST['dark_mode'] : 0;

        $usuarioDAO = new UsuarioDAO();
        $sucesso = $usuarioDAO->alterarDarkMode($id_usuario, $dark_mode);

        if ($sucesso) {
            $_SESSION['dark_mode'] = $dark_mode;
            echo json_encode(['success' => true, 'dark_mode' => $dark_mode]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar preferência']);
        }
        exit;
    }

}