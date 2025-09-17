<?php
namespace App\Model;

class DicasModel {

    private $ID_DICAS;
    private $DICAS_DESC;

    // GET
    public function __get($nome) {
        return $this->$nome;
    }

    // SET
    public function __set($nome, $valor) {
        $this->$nome = $valor;
    }
}
