<?php
namespace App\DAO;

use FW\DB\Connection;

class PasswordResetDAO {

    private $conn;

    public function __construct() {
        $connObj = new Connection();
        $this->conn = $connObj->getConn();
    }

    public function criarToken($usuarioId) {
        // Invalida tokens anteriores
        $sql = "UPDATE password_resets SET usado = 1 WHERE usuario_id = ? AND usado = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuarioId]);

        // Gera novo token
        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $sql = "INSERT INTO password_resets (usuario_id, token, expira_em) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuarioId, $token, $expira]);

        return $token;
    }

    public function validarToken($token) {
        $sql = "SELECT pr.*, u.email, u.nome FROM password_resets pr
                JOIN usuarios u ON u.id = pr.usuario_id
                WHERE pr.token = ? AND pr.usado = 0 AND pr.expira_em > NOW()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function marcarUsado($token) {
        $sql = "UPDATE password_resets SET usado = 1 WHERE token = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$token]);
    }
}
