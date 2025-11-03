<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\UsuarioDAO;
use App\Model\UsuarioModel;

class UsuarioController extends Action{

    /**
     * Editar informações do usuário (nome e email)
     */
    public function editar(){
        session_start();
        
        // Verifica autenticação
        if (!isset($_COOKIE['cookie_id']) || $_COOKIE['cookie_id'] == 0) {
            header('Location: /');
            exit;
        }

        $id_usuario = $_COOKIE['cookie_id'];
        
        // Pega dados do POST
        $nome = $_POST['USER_NOME'] ?? '';
        $email = $_POST['USER_EMAIL'] ?? '';

        // Validações básicas
        if (empty($nome) || empty($email)) {
            $_SESSION['erro_edicao'] = 'Nome e email são obrigatórios';
            header('Location: /menu');
            exit;
        }

        // Valida email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro_edicao'] = 'Email inválido';
            header('Location: /menu');
            exit;
        }

        $usuarioDAO = new UsuarioDAO();
        
        // Verifica se o email já existe (em outro usuário)
        if ($usuarioDAO->emailExiste($email, $id_usuario)) {
            $_SESSION['erro_edicao'] = 'Este email já está sendo usado por outro usuário';
            header('Location: /menu');
            exit;
        }

        // Cria o model e popula
        $usuario = new UsuarioModel();
        $usuario->__set('id', $id_usuario);
        $usuario->__set('nome', $nome);
        $usuario->__set('email', $email);

        // Atualiza no banco
        $sucesso = $usuarioDAO->alterar($usuario);

        if ($sucesso) {
            // Atualiza o cookie do nome
            setcookie('cookie_nome', $nome, time() + (86400 * 30), '/');
            
            $_SESSION['perfil_atualizado'] = 1;
            header('Location: /menu');
        } else {
            $_SESSION['erro_edicao'] = 'Erro ao atualizar perfil';
            header('Location: /menu');
        }
        
        exit;
    }

    /**
     * Alterar senha do usuário
     */
    public function alteraSenha(){
        session_start();
        
        // Verifica autenticação
        if (!isset($_COOKIE['cookie_id']) || $_COOKIE['cookie_id'] == 0) {
            header('Location: /');
            exit;
        }

        $id_usuario = $_COOKIE['cookie_id'];
        
        // Pega dados do POST
        $senhaAtual = $_POST['SENHA_ATUAL'] ?? '';
        $novaSenha = $_POST['NOVA_SENHA'] ?? '';
        $confirmarSenha = $_POST['CONFIRMAR_SENHA'] ?? '';

        // Validações
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
        
        // Busca usuário atual
        $usuarioAtual = $usuarioDAO->buscarPorId($id_usuario);
        
        if (!$usuarioAtual) {
            $_SESSION['erro_senha'] = 'Usuário não encontrado';
            header('Location: /redefinirSenha');
            exit;
        }

        // Verifica senha atual
        // NOTA: Ajuste aqui se você usa hash (password_verify)
        // Por enquanto está comparando direto como no seu banco
        if ($usuarioAtual['senha'] !== $senhaAtual) {
            $_SESSION['erro_senha'] = 'Senha atual incorreta';
            header('Location: /redefinirSenha');
            exit;
        }

        // Atualiza senha
        // NOTA: Você pode adicionar hash aqui: password_hash($novaSenha, PASSWORD_DEFAULT)
        $sucesso = $usuarioDAO->alterarSenha($id_usuario, $novaSenha);

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

    $user_cpf = $_POST['USER_CPF'];
    $user_nome = $_POST['USER_NOME'];
    $user_email = $_POST['USER_EMAIL'];
    $user_senha = $_POST['USER_SENHA'];
    $user_senha_2 = $_POST['USER_SENHA_2'];

    if($user_senha == $user_senha_2){
        $usuario = new UsuarioModel();
        $usuario->__set("user_cpf",$user_cpf);
        $usuario->__set("user_nome",$user_nome);
        $usuario->__set("user_email",$user_email);
        $usuario->__set("user_senha",$user_senha);


        $usuariodao = new UsuarioDAO();
        $usuariodao->inserir($usuario);

        session_start();
        $_SESSION['usuario_cadastrado'] = 1;

    }
    else{
        session_start();
        $_SESSION['senhas_nao_conferem'] = 1;
    }

    header('Location: /');

    }


    public function validaAutenticacao() {

        
    }

    public function login(){

        //var_dump($_POST);
        //exit;
        //echo "ablueblue";
        $usuarioDAO = new \App\DAO\UsuarioDAO();
        $senha = $usuarioDAO->procurar_login($_POST['EMAIL']);
        $user_senha = $_POST['SENHA'];
        //echo $senha['senha']
        if($user_senha == $senha['senha']){
            $usuario_logado = $usuarioDAO->puxar_login($_POST['EMAIL']);
            $_SESSION['cookie_id'] = $usuario_logado['id'];
            $_SESSION['cookie_nome'] = $usuario_logado['nome'];
            setcookie("cookie_id", $usuario_logado['id'], 2147483647, "/");
            setcookie("cookie_nome", $usuario_logado['nome'], 2147483647, "/");
            setcookie("cookie_cpf", $usuario_logado['cpf'], 2147483647, "/");
            //echo $_SESSION['cookie_id'];
            //echo $_COOKIE['cookie_nome'];
            session_start();
            $_SESSION['login_realizado'] = 1;
            header('Location: /dashboard');         }
        else{
            //echo $user_senha;
            //echo $senha;
            //ho $senha['senha'];
            //alert('Mensagem aqui');  
            //$link = "/";
            //echo "<script>alert('Email ou senha incorreta.'); location.href='{$link}';</script>";
            session_start();
            $_SESSION['mensagem_login_incorreto'] = 1;
            header('Location: /');
        }


        //header('Location: /'); 
    }

    public function logout(){

        setcookie('cookie_id', '', time() - 3600, '/');
        setcookie('cookie_nome', '', time() - 3600, '/');

        //echo $_COOKIE['cookie_nome'];
        //echo $_COOKIE['cookie_id'];
        //exit;
        session_start();
        $_SESSION['usuario_desconectado'] = 1;
        header('Location: /'); 

    }

    public function alterarUsuario(){

        $user_cpf = $_POST['USER_CPF'];
        $user_nome = $_POST['USER_NOME'];
        $user_email = $_POST['USER_EMAIL'];

        $usuario = new UsuarioModel();
        $usuario->__set("user_cpf",$user_cpf);
        $usuario->__set("user_nome",$user_nome);
        $usuario->__set("user_email",$user_email);

        $usuariodao = new UsuarioDAO();
        $usuariodao->alterar($usuario);

        header('Location: /dashboard'); 

    }
    
}