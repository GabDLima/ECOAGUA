<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\UsuarioDAO;
use App\Model\UsuarioModel;


class SiteController extends Action{

    public function login(){
        $title = "Login";
        $title_pagina = "Bem vindo ao site";

        

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('login', 'site_login');
    }
    

    public function validaAutenticacao() {

        
    }

    public function menu(){
        $title = "Menu";
        $title_pagina = "Bem vindo ao site";

        

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('menu', 'site');
    }

    public function inserirUsuario(){

        /*$user_cpf = $obj->__get('user_cpf');
        $user_nome = $obj->__get('user_nome');
        $user_email = $obj->__get('user_email');
        $user_senha = $obj->__get('user_senha');*/

        $usuario = new UsuarioModel();
        $usuario->__set("user_cpf",$_POST['USER_CPF']);
        $usuario->__set("user_nome",$_POST['USER_NOME']);
        $usuario->__set("user_email",$_POST['USER_EMAIL']);
        $usuario->__set("user_senha",$_POST['USER_SENHA']);


        $usuariodao = new UsuarioDAO();
        $usuariodao->inserir($usuario);

        header('Location: /'); 
    }

    public function dashboard(){
        $title = "Dashboard";
        $title_pagina = "Bem vindo ao site";

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('dashboard', 'site');
    }

    public function consumo(){
        $title = "Consumo";
        $title_pagina = "Bem vindo ao site";

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('consumo', 'site');
    }

    public function redefinirSenha(){
        $title = "Consumo";
        $title_pagina = "Bem vindo ao site";

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('redefinirSenha', 'site_login');
    }

}
