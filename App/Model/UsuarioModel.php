<?php

namespace App\Model;

class UsuarioModel
{
    private $user_cpf;
    private $user_nome;
    private $user_email;
    private $user_senha;
    //private $fk_login_log_id;

    

    public function __set($nome, $valor)
    {
        $this->$nome = $valor;
    }

    public function __get($nome)
    {
        return $this->$nome;
    }
}
