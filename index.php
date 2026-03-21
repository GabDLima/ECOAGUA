<?php
// Servidor embutido do PHP (php -S): serve arquivos estáticos diretamente
if (php_sapi_name() === 'cli-server') {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $uri;
    if (is_file($file)) {
        return false; // PHP serve o arquivo estático com o MIME type correto
    }
}

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$route = new \App\Route();
