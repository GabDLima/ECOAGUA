<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\AlunosDAO;
use App\Model\AlunosModel;


class SiteController extends Action{

    public function index(){
        $title = "Home";
        $title_pagina = "Bem vindo ao site";

        

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('index', '');
    }
    

    public function validaAutenticacao() {

        
    }

    public function contato(){
        $title = "Contato";
        $title_pagina = "Bem vindo ao site";

        

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('contato', '');
    }

}
