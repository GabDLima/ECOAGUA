<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\UsuarioDAO;
use App\Model\UsuarioModel;
use App\DAO\DicasDAO;


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


    public function dashboard() {
            $title = "Dashboard";
            $title_pagina = "Painel do Usuário";

            $dicasDAO = new \App\DAO\DicasDAO();
            $dicas = $dicasDAO->randomTips();

            $nome_usuario = $_COOKIE['cookie_nome'];

            $this->getView()->title = $title;
            $this->getView()->title_pagina = $title_pagina;
            $this->getView()->dicas = $dicas;
            $this->getView()->nome_usuario = $nome_usuario;

            // opcional: para garantir compatibilidade
            $this->dicas = $dicas;

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
