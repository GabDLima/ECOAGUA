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
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] == 0) {
            header('Location: /');
            exit;
        }

        $mes_da_fatura = trim($_POST['MES_DA_FATURA'] ?? '');
        $valor = trim($_POST['VALOR'] ?? '');
        $id_usuario = $_SESSION['usuario_id'];

        if (empty($mes_da_fatura) || empty($valor)) {
            $_SESSION['erro_fatura'] = 'Mês e valor são obrigatórios';
            header('Location: /consumo');
            exit;
        }

        if (!is_numeric($valor) || $valor <= 0) {
            $_SESSION['erro_fatura'] = 'Valor inválido';
            header('Location: /consumo');
            exit;
        }

        $mes_da_fatura = $mes_da_fatura . '-01';

        $valordaconta = new ValordaContaModel();
        $valordaconta->__set("mes_da_fatura", $mes_da_fatura);
        $valordaconta->__set("valor", $valor);
        $valordaconta->__set("id_usuario", $id_usuario);

        $valordacontadao = new ValordaContaDAO();
        $valordacontadao->inserir($valordaconta);

        $_SESSION['sucesso_fatura'] = 'Fatura cadastrada com sucesso!';
        header('Location: /consumo');
        exit;
    }

    public function validaAutenticacao() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] == 0) {
            header('Location: /');
            exit;
        }
    }

    public function inserirMetaConsumo(){
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] == 0) {
            header('Location: /');
            exit;
        }

        $meta_mensal = trim($_POST['META_MENSAL'] ?? '');
        $meta_reducao = trim($_POST['META_REDUCAO'] ?? '');
        $prazo = trim($_POST['PRAZO'] ?? '');
        $id_usuario = $_SESSION['usuario_id'];

        if (empty($meta_mensal) || empty($meta_reducao) || empty($prazo)) {
            $_SESSION['erro_meta'] = 'Todos os campos são obrigatórios';
            header('Location: /consumo');
            exit;
        }

        if (!is_numeric($meta_mensal) || $meta_mensal <= 0) {
            $_SESSION['erro_meta'] = 'Meta mensal inválida';
            header('Location: /consumo');
            exit;
        }

        if (!is_numeric($meta_reducao) || $meta_reducao <= 0) {
            $_SESSION['erro_meta'] = 'Meta de redução inválida';
            header('Location: /consumo');
            exit;
        }

        $metaconsumo = new MetaConsumoModel();
        $metaconsumo->__set("meta_mensal", $meta_mensal);
        $metaconsumo->__set("meta_reducao", $meta_reducao);
        $metaconsumo->__set("prazo", $prazo);
        $metaconsumo->__set("id_usuario", $id_usuario);

        $metaconsumodao = new MetaConsumoDAO();
        $metaconsumodao->inserir($metaconsumo);

        $_SESSION['sucesso_meta'] = 'Meta cadastrada com sucesso!';
        header('Location: /consumo');
        exit;
    }

    public function inserirConsumoDiario(){
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] == 0) {
            header('Location: /');
            exit;
        }

        $data_consumo = trim($_POST['DATA_CONSUMO'] ?? '');
        $quantidade = trim($_POST['QUANTIDADE'] ?? '');
        $unidade = trim($_POST['UNIDADE'] ?? '');
        $tipo = trim($_POST['TIPO'] ?? '');
        $id_usuario = $_SESSION['usuario_id'];

        if (empty($data_consumo) || empty($quantidade) || empty($unidade) || empty($tipo)) {
            $_SESSION['erro_consumo'] = 'Todos os campos são obrigatórios';
            header('Location: /consumo');
            exit;
        }

        if (!is_numeric($quantidade) || $quantidade <= 0) {
            $_SESSION['erro_consumo'] = 'Quantidade inválida';
            header('Location: /consumo');
            exit;
        }

        $unidades_validas = ['L', 'mL', 'm³'];
        if (!in_array($unidade, $unidades_validas)) {
            $_SESSION['erro_consumo'] = 'Unidade inválida';
            header('Location: /consumo');
            exit;
        }

        $consumodiario = new ConsumoDiarioModel();
        $consumodiario->__set("data_consumo", $data_consumo);
        $consumodiario->__set("quantidade", $quantidade);
        $consumodiario->__set("unidade", $unidade);
        $consumodiario->__set("id_usuario", $id_usuario);
        $consumodiario->__set("tipo", $tipo);

        $consumodiariodao = new ConsumoDiarioDAO();
        $consumodiariodao->inserir($consumodiario);

        $_SESSION['sucesso_consumo'] = 'Consumo cadastrado com sucesso!';
        header('Location: /consumo');
        exit;
    }
    
}