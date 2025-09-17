<?php
namespace App\DAO;

use App\Model\DicasModel;
use FW\Controller\FuncoesGlobais;
use FW\DB\Connection;

class DicasDAO {

    private $conn;

    public function __construct() {
        $connObj = new Connection();
        $this->conn = $connObj->getConn(); // chama o método de instância
    }

    private function getConn() {
        return $this->conn;
    }

    public function randomTips() {
    $dicas = [];
    try {
        $sql = "SELECT ID_DICAS, DICAS_DESC FROM dicas ORDER BY RAND() LIMIT 3";
        $stmt = $this->getConn()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $dica = new \App\Model\DicasModel();
            $dica->__set('id_dicas', $row['ID_DICAS']);
            $dica->__set('dicas_desc', $row['DICAS_DESC']);
            $dicas[] = $dica;
        }
    } catch (\PDOException $ex) {
        error_log($ex->getMessage());
    }
    return $dicas;
}

}
