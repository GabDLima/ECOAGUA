<?php

namespace App\Model;

class ValordaContaModel
{
    private $mes_da_fatura;
    private $valor;
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
