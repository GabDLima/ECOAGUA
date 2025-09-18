<?php

namespace App\Model;

class MetaConsumoModel
{
    private $meta_mensal;
    private $meta_reducao;
    private $prazo;
    private $usuario_id;
    

    public function __set($nome, $valor)
    {
        $this->$nome = $valor;
    }

    public function __get($nome)
    {
        return $this->$nome;
    }
}
