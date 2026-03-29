<?php

namespace FW\DB;

class Connection
{

    private $conn;
    private $dbname;
    private $host;
    private $user;
    private $pass;

    public function __construct()
    {

        $this->dbname = $_ENV['DB_NAME'];
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        try {
            $this->conn = new \PDO(
                "mysql:dbname=" . $this->dbname . ";host=" . $this->host . ";charset=utf8mb4",
                $this->user,
                $this->pass
            );
            $this->conn->exec("SET NAMES 'utf8mb4'");
        } catch (\PDOException $ex) {
            echo "Ocorreu erro: " . $ex->getMessage();
            die();
        }
    }

    public function getConn()
    {
        return $this->conn;
    }
}
