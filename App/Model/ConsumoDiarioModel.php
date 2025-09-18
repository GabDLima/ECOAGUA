<?php

namespace App\Model;

class ConsumoDiarioModel
{
    private $data_consumo;
    private $quantidade;
    private $unidade;
    private $id_usuario;
    

    public function __set($nome, $valor)
    {
        $this->$nome = $valor;
    }

    public function __get($nome)
    {
        return $this->$nome;
    }
}
