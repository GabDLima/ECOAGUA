<?php
namespace App\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    private static string $secret;

    public static function init(): void
    {
        self::$secret = $_ENV['JWT_SECRET'] ?? 'secret';
    }

    public static function gerar(array $payload): string
    {
        self::init();
        $payload['iat'] = time();
        $payload['exp'] = time() + (60 * 60 * 24); // 24 horas
        return JWT::encode($payload, self::$secret, 'HS256');
    }

    public static function validar(): array
    {
        self::init();

        $headers = getallheaders();
        $auth = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        if (!$auth || !str_starts_with($auth, 'Bearer ')) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Token não fornecido.']);
            exit;
        }

        $token = substr($auth, 7);

        try {
            $decoded = JWT::decode($token, new Key(self::$secret, 'HS256'));
            return (array) $decoded;
        } catch (ExpiredException $e) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Token expirado.']);
            exit;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Token inválido.']);
            exit;
        }
    }

    public static function json(int $status, array $data): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
