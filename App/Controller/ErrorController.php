<?php

    namespace App\Controller;
    
    use FW\Controller\Action;
    
    class ErrorController extends Action{

        public function login(){             
            echo "Página não encontrada!";
        }        

        public function inserirUsuario(){
            echo "Não foi possível inserir o usuário";
        }
        
        
        public function error404(){             
            echo "Página não encontrada!";
        }        

        

        public function validaAutenticacao() {
            if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
                header('Location: /login');
                die();
            }
        }



    }
    
?>