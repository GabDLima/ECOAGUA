<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\UsuarioDAO;
use App\Model\UsuarioModel;

class UsuarioController extends Action{

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

    public function editar(){

        $user_nome = $_POST['USER_NOME'];
        $user_email = $_POST['USER_EMAIL'];
        $user_id = $_COOKIE['cookie_id'];
    
        $usuario = new UsuarioModel();
        $usuario->__set("user_nome",$user_nome);
        $usuario->__set("user_email",$user_email);
        $usuario->__set("user_id",$user_id);
    
        $usuariodao = new UsuarioDAO();
        $usuariodao->editar($usuario);
    
        header('Location: /menu'); 
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

    public function alteraSenha(){

        $user_senha = $_POST['USER_SENHA'];
        $user_senha_2 = $_POST['USER_SENHA_2'];
        $user_id = $_COOKIE['cookie_id'];

        if($user_senha == $user_senha_2){
            $usuario = new UsuarioModel();
            $usuario->__set("user_senha",$user_senha);
            $usuario->__set("user_id",$user_id);

            $usuariodao = new UsuarioDAO();
            $usuariodao->alterarSenha($usuario);
            session_start();
            $_SESSION['senha_alterada'] = 1;
            header('Location: /menu'); 
        }
        else{

            session_start();
            $_SESSION['senha_nao_confere'] = 1;
            header('Location: /redefinirSenha'); 

        }

    }
    
}