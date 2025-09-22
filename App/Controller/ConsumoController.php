<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\ValordaContaDAO;
use App\Model\ValordaContaModel;
use App\DAO\MetaConsumoDAO;
use App\Model\MetaConsumoModel;
use App\DAO\ConsumoDiarioDAO;
use App\Model\ConsumoDiarioModel;


class ConsumoController extends Action{

    public function inserirValordaConta(){

    //var_dump($_POST);
    //exit;

    //$mes_da_fatura = '0001-01-01';
    $mes_da_fatura = $_POST['MES_DA_FATURA'];
    $mes_da_fatura = $mes_da_fatura . '-01';
    //echo $mes_da_fatura;
    $valor = $_POST['VALOR'];
    $id_usuario = $_COOKIE['cookie_id'];
    //echo $id_usuario;
    //exit;

    $valordaconta = new ValordaContaModel();
    $valordaconta->__set("mes_da_fatura",$mes_da_fatura);
    $valordaconta->__set("valor",$valor);
    $valordaconta->__set("id_usuario",$id_usuario);
    //echo $valordaconta->__get("id_usuario");
    //xit;


    $valordacontadao = new ValordaContaDAO();
    $valordacontadao->inserir($valordaconta);

    header('Location: /consumo'); 
    }

    public function validaAutenticacao() {

        
    }

    public function inserirMetaConsumo(){

        //var_dump($_POST);
        //exit;
    
        $meta_mensal = $_POST['META_MENSAL'];
        $meta_reducao = $_POST['META_REDUCAO'];
        $prazo = $_POST['PRAZO'];
        $usuario_id = $_COOKIE['cookie_id'];
    
        $metaconsumo = new MetaConsumoModel();
        $metaconsumo->__set("meta_mensal",$meta_mensal);
        $metaconsumo->__set("meta_reducao",$meta_reducao);
        $metaconsumo->__set("prazo",$prazo);
        $metaconsumo->__set("usuario_id",$usuario_id);
    
    
        $metaconsumodao = new MetaConsumoDAO();
        $metaconsumodao->inserir($metaconsumo);
    
        header('Location: /consumo'); 
    }

    public function inserirConsumoDiario(){

        //var_dump($_POST);
        //exit;

        $data_consumo = $_POST['DATA_CONSUMO'];
        $quantidade = $_POST['QUANTIDADE'];
        $unidade = $_POST['UNIDADE'];
        $id_usuario = $_COOKIE['cookie_id'];
    
        $consumodiario = new ConsumoDiarioModel();
        $consumodiario->__set("data_consumo",$data_consumo);
        $consumodiario->__set("quantidade",$quantidade);
        $consumodiario->__set("unidade",$unidade);
        $consumodiario->__set("id_usuario",$id_usuario);
    
    
        $consumodiariodao = new ConsumoDiarioDAO();
        $consumodiariodao->inserir($consumodiario);
    
        header('Location: /consumo'); 
    }
    
}