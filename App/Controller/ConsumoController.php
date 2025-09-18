<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\MetaConsumoDAO;
use App\Model\MetaConsumoModel;

class ConsumoController extends Action{

    public function inserirValordaConta(){

    //var_dump($_POST);
    //exit;

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

    public function inserirMetaConsumo(){

        //var_dump($_POST);
        //exit;
    
        $meta_mensal = $_POST['META_MENSAL'];
        $meta_reducao = $_POST['META_REDUCAO'];
        $prazo = $_POST['PRAZO'];
        //$usuario_id = $obj->__get('USUARIO_ID');
    
        $metaconsumo = new MetaConsumoModel();
        $metaconsumo->__set("meta_mensal",$meta_mensal);
        $metaconsumo->__set("meta_reducao",$meta_reducao);
        $metaconsumo->__set("prazo",$prazo);
        //$metaconsumo->__set("usuario_id",$usuario_id);
    
    
        $metaconsumodao = new MetaConsumoDAO();
        $metaconsumodao->inserir($metaconsumo);
    
        header('Location: /'); 
        }
    
}