<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\AlunosDAO;
use App\Model\AlunosModel;


class SiteController extends Action{

    public function login(){
        $title = "Login";
        $title_pagina = "Bem vindo ao site";

        

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('login', '');
    }
    

    public function validaAutenticacao() {

        
    }

    public function menu(){
        $title = "Menu";
        $title_pagina = "Bem vindo ao site";

        

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('menu', '');
    }

    public function dashboard(){
        $title = "Dashboard";
        $title_pagina = "Bem vindo ao site";

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('dashboard', '');
    }

    public function consumo(){
        $title = "Consumo";
        $title_pagina = "Bem vindo ao site";

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('consumo', '');
    }

}
