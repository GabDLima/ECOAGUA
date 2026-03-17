<?php
namespace App\Controller;

use App\Middleware\JwtMiddleware;
use App\DAO\UsuarioDAO;
use App\DAO\ConsumoDiarioDAO;
use App\DAO\MetaConsumoDAO;
use App\DAO\ValordaContaDAO;
use App\Model\UsuarioModel;
use App\Model\ConsumoDiarioModel;
use App\Model\MetaConsumoModel;
use App\Model\ValordaContaModel;

class ApiController extends \FW\Controller\Action
{
    private function cors(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }

    private function body(): array
    {
        $raw = file_get_contents('php://input');
        return json_decode($raw, true) ?? [];
    }

    /**
     * Converte um ConsumoDiarioModel para array simples (json_encode não acessa propriedades privadas).
     */
    private function consumoToArray($model): array
    {
        return [
            'data_consumo' => $model->__get('data_consumo'),
            'quantidade'   => $model->__get('quantidade'),
            'unidade'      => $model->__get('unidade'),
            'tipo'         => $model->__get('tipo'),
        ];
    }

    public function validaAutenticacao(): void {}

    // -------------------------------------------------------
    // POST /api/auth/login
    // Body: { "email": "...", "senha": "..." }
    // -------------------------------------------------------
    public function login(): void
    {
        $this->cors();
        $body = $this->body();

        $email = trim($body['email'] ?? '');
        $senha = trim($body['senha'] ?? '');

        if (!$email || !$senha) {
            JwtMiddleware::json(400, ['success' => false, 'message' => 'Email e senha são obrigatórios.']);
        }

        $dao     = new UsuarioDAO();
        $usuario = $dao->buscarPorEmail($email);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            JwtMiddleware::json(401, ['success' => false, 'message' => 'Credenciais inválidas.']);
        }

        $token = JwtMiddleware::gerar([
            'id'    => $usuario['id'],
            'nome'  => $usuario['nome'],
            'email' => $usuario['email'],
        ]);

        JwtMiddleware::json(200, [
            'success' => true,
            'token'   => $token,
            'usuario' => [
                'id'    => $usuario['id'],
                'nome'  => $usuario['nome'],
                'email' => $usuario['email'],
            ],
        ]);
    }

    // -------------------------------------------------------
    // POST /api/auth/register
    // Body: { "cpf": "...", "nome": "...", "email": "...", "senha": "..." }
    // -------------------------------------------------------
    public function register(): void
    {
        $this->cors();
        $body = $this->body();

        $cpf   = trim($body['cpf']   ?? '');
        $nome  = trim($body['nome']  ?? '');
        $email = trim($body['email'] ?? '');
        $senha = trim($body['senha'] ?? '');

        if (!$cpf || !$nome || !$email || !$senha) {
            JwtMiddleware::json(400, ['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            JwtMiddleware::json(400, ['success' => false, 'message' => 'Email inválido.']);
        }

        $dao = new UsuarioDAO();

        if ($dao->emailExiste($email)) {
            JwtMiddleware::json(409, ['success' => false, 'message' => 'Email já cadastrado.']);
        }

        // UsuarioModel usa __set/__get com chaves: user_cpf, user_nome, user_email, user_senha
        $model = new UsuarioModel();
        $model->__set('user_cpf',   $cpf);
        $model->__set('user_nome',  $nome);
        $model->__set('user_email', $email);
        $model->__set('user_senha', $senha);

        $dao->inserir($model);

        JwtMiddleware::json(201, ['success' => true, 'message' => 'Usuário criado com sucesso.']);
    }

    // -------------------------------------------------------
    // GET  /api/consumo  → lista consumo do usuário
    // POST /api/consumo  → registra novo consumo
    // Header: Authorization: Bearer {token}
    // POST Body: { "data_consumo": "YYYY-MM-DD", "quantidade": 10, "unidade": "L", "tipo": "Banho" }
    // -------------------------------------------------------
    public function consumo(): void
    {
        $this->cors();
        $payload = JwtMiddleware::validar();
        $id      = $payload['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $body = $this->body();

            $unidades_validas = ['L', 'mL', 'm³'];
            $unidade = $body['unidade'] ?? 'L';

            if (!in_array($unidade, $unidades_validas)) {
                JwtMiddleware::json(400, ['success' => false, 'message' => 'Unidade inválida. Use L, mL ou m³.']);
            }

            // ConsumoDiarioModel usa __set/__get com chaves: data_consumo, quantidade, unidade, id_usuario, tipo
            $model = new ConsumoDiarioModel();
            $model->__set('id_usuario',   $id);
            $model->__set('data_consumo', $body['data_consumo'] ?? date('Y-m-d'));
            $model->__set('quantidade',   $body['quantidade']   ?? 0);
            $model->__set('unidade',      $unidade);
            $model->__set('tipo',         $body['tipo']         ?? 'Geral');

            $dao = new ConsumoDiarioDAO();
            $dao->inserir($model);

            JwtMiddleware::json(201, ['success' => true, 'message' => 'Consumo registrado com sucesso.']);
        }

        // GET
        $dao      = new ConsumoDiarioDAO();
        $ultimos7 = array_map([$this, 'consumoToArray'], $dao->buscarUltimos7Dias($id));
        $totalMes = $dao->buscarTotalMesAtual($id);
        $consumoHoje = $dao->buscarConsumoHoje($id);

        JwtMiddleware::json(200, [
            'success'        => true,
            'consumo_hoje'   => $consumoHoje ?? 0,
            'total_mes'      => $totalMes    ?? 0,
            'ultimos_7_dias' => $ultimos7,
        ]);
    }

    // -------------------------------------------------------
    // GET  /api/metas  → meta ativa + progresso
    // POST /api/metas  → cria nova meta
    // Header: Authorization: Bearer {token}
    // POST Body: { "meta_mensal": 5000, "meta_reducao": 10, "prazo": 3 }
    // -------------------------------------------------------
    public function metas(): void
    {
        $this->cors();
        $payload = JwtMiddleware::validar();
        $id      = $payload['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $body = $this->body();

            // MetaConsumoModel usa __set/__get com chaves: meta_mensal, meta_reducao, prazo, id_usuario
            $model = new MetaConsumoModel();
            $model->__set('id_usuario',  $id);
            $model->__set('meta_mensal', $body['meta_mensal'] ?? 0);
            $model->__set('meta_reducao',$body['meta_reducao'] ?? 0);
            $model->__set('prazo',       $body['prazo']       ?? 1);

            $dao = new MetaConsumoDAO();
            $dao->inserir($model);

            JwtMiddleware::json(201, ['success' => true, 'message' => 'Meta criada com sucesso.']);
        }

        // GET
        $dao      = new MetaConsumoDAO();
        $meta     = $dao->buscarMetaAtiva($id);
        $progresso = $meta ? $dao->calcularProgressoMeta($id) : null;

        JwtMiddleware::json(200, [
            'success'   => true,
            'meta'      => $meta,
            'progresso' => $progresso,
        ]);
    }

    // -------------------------------------------------------
    // GET  /api/faturas  → faturas recentes
    // POST /api/faturas  → registra nova fatura
    // Header: Authorization: Bearer {token}
    // POST Body: { "mes_da_fatura": "YYYY-MM", "valor": 89.90 }
    // -------------------------------------------------------
    public function faturas(): void
    {
        $this->cors();
        $payload = JwtMiddleware::validar();
        $id      = $payload['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $body = $this->body();

            $mes = ($body['mes_da_fatura'] ?? date('Y-m')) . '-01';

            // ValordaContaModel usa __set/__get com chaves: mes_da_fatura, valor, id_usuario
            $model = new ValordaContaModel();
            $model->__set('id_usuario',    $id);
            $model->__set('mes_da_fatura', $mes);
            $model->__set('valor',         $body['valor'] ?? 0);

            $dao = new ValordaContaDAO();
            $dao->inserir($model);

            JwtMiddleware::json(201, ['success' => true, 'message' => 'Fatura registrada com sucesso.']);
        }

        // GET
        $dao      = new ValordaContaDAO();
        $ultima   = $dao->buscarUltimaFatura($id);
        $recentes = $dao->buscarFaturasRecentes($id, 6);
        $totalAno = $dao->buscarTotalGastoAno($id, date('Y'));
        $media    = $dao->buscarMediaMensal($id, 6);

        JwtMiddleware::json(200, [
            'success'       => true,
            'ultima_fatura' => $ultima,
            'faturas'       => $recentes,
            'total_ano'     => $totalAno ?? 0,
            'media_mensal'  => $media    ?? 0,
        ]);
    }

    // -------------------------------------------------------
    // GET /api/dashboard
    // Header: Authorization: Bearer {token}
    // -------------------------------------------------------
    public function getDashboard(): void
    {
        $this->cors();
        $payload = JwtMiddleware::validar();
        $id      = $payload['id'];

        $consumoDAO = new ConsumoDiarioDAO();
        $metaDAO    = new MetaConsumoDAO();
        $faturaDAO  = new ValordaContaDAO();

        $totalMesAtual    = $consumoDAO->buscarTotalMesAtual($id)   ?? 0;
        $totalMesAnterior = $consumoDAO->buscarTotalMesAnterior($id) ?? 1;
        $consumoHoje      = $consumoDAO->buscarConsumoHoje($id)     ?? 0;
        $ultimos7Dias     = array_map([$this, 'consumoToArray'], $consumoDAO->buscarUltimos7Dias($id));

        $variacao = $totalMesAnterior > 0
            ? round((($totalMesAtual - $totalMesAnterior) / $totalMesAnterior) * 100, 1)
            : 0;

        $diaAtual  = (int) date('j');
        $diasNoMes = (int) date('t');
        $projecao  = $diaAtual > 0
            ? round(($totalMesAtual / $diaAtual) * $diasNoMes, 2)
            : 0;

        $metaAtiva = $metaDAO->buscarMetaAtiva($id);
        $progresso = $metaAtiva ? $metaDAO->calcularProgressoMeta($id) : null;

        $ultimaFatura = $faturaDAO->buscarUltimaFatura($id);
        $totalAno     = $faturaDAO->buscarTotalGastoAno($id, date('Y')) ?? 0;

        $alerta = ($progresso && $progresso['alerta']) || $variacao > 20;

        JwtMiddleware::json(200, [
            'success'          => true,
            'consumo_hoje'     => $consumoHoje,
            'total_mes_atual'  => $totalMesAtual,
            'variacao_percent' => $variacao,
            'projecao_mensal'  => $projecao,
            'ultima_fatura'    => $ultimaFatura,
            'total_ano'        => $totalAno,
            'meta'             => $metaAtiva,
            'progresso_meta'   => $progresso,
            'alerta'           => $alerta,
            'ultimos_7_dias'   => $ultimos7Dias,
        ]);
    }
}
