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

    $usuario = new UsuarioModel();
    $usuario->__set("user_cpf",$user_cpf);
    $usuario->__set("user_nome",$user_nome);
    $usuario->__set("user_email",$user_email);
    $usuario->__set("user_senha",$user_senha);


    $usuariodao = new UsuarioDAO();
    $usuariodao->inserir($usuario);

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
            //echo $_SESSION['cookie_id'];
            //echo $_COOKIE['cookie_nome'];
            header('Location: /dashboard'); 
        }
        else{
            //echo $user_senha;
            //echo $senha;
            echo $senha['senha'];
        }


        //header('Location: /'); 
    }

    public function logout(){

        $_COOKIE['cookie_id'] = 0;
        $_COOKIE['cookie_nome'] = "";

        //echo $_COOKIE['cookie_nome'];
        //echo $_COOKIE['cookie_id'];
        //exit;
        header('Location: /'); 

    }
    
}