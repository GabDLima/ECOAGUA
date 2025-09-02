<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\ValordaContaDAO;
use App\Model\ValordaContaModel;

class ConsumoController extends Action{

    public function inserirValordaConta(){

    $mes_da_fatura = $_POST['MES_DA_FATURA'];
    $valor = $_POST['VALOR'];

    $valordaconta = new ValordaContaModel();
    $valordaconta->__set("mes_da_fatura",$mes_da_fatura);
    $valordaconta->__set("valor",$valor);


    $valordacontadao = new ValordaContaDAO();
    $valordacontadao->inserir($valordaconta);

    header('Location: /'); 
    }

    public function validaAutenticacao() {

        
    }
    
}