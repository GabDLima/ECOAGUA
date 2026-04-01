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
use App\DAO\DicasDAO;
use App\DAO\PasswordResetDAO;

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
    // -------------------------------------------------------
    // GET  /api/preferencias  → retorna preferências do usuário
    // POST /api/preferencias  → atualiza preferências
    // Header: Authorization: Bearer {token}
    // POST Body: { unidade_padrao?, notif_alerta_meta?, notif_lembrete_fatura?, notif_dicas? }
    // -------------------------------------------------------
    public function preferencias(): void
    {
        $this->cors();
        $payload = JwtMiddleware::validar();
        $id      = $payload['id'];

        $dao = new UsuarioDAO();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $body = $this->body();

            if (isset($body['unidade_padrao'])) {
                $unidades = ['L', 'mL', 'm³'];
                if (in_array($body['unidade_padrao'], $unidades)) {
                    $dao->atualizarUnidadePadrao($id, $body['unidade_padrao']);
                }
            }

            if (isset($body['notif_alerta_meta']) || isset($body['notif_lembrete_fatura']) || isset($body['notif_dicas'])) {
                $atual = $dao->buscarPorId($id);
                $alertaMeta     = isset($body['notif_alerta_meta'])     ? (int)$body['notif_alerta_meta']     : ($atual['notif_alerta_meta']     ?? 1);
                $lembreteFatura = isset($body['notif_lembrete_fatura']) ? (int)$body['notif_lembrete_fatura'] : ($atual['notif_lembrete_fatura'] ?? 1);
                $dicas          = isset($body['notif_dicas'])           ? (int)$body['notif_dicas']           : ($atual['notif_dicas']           ?? 1);
                $dao->atualizarPreferenciasNotificacao($id, $alertaMeta, $lembreteFatura, $dicas);
            }

            if (isset($body['dark_mode'])) {
                $dao->alterarDarkMode($id, (int)$body['dark_mode']);
            }

            JwtMiddleware::json(200, ['success' => true, 'message' => 'Preferências atualizadas.']);
        }

        // GET
        $usuario = $dao->buscarPorId($id);

        JwtMiddleware::json(200, [
            'success'      => true,
            'preferencias' => [
                'unidade_padrao'        => $usuario['unidade_padrao']        ?? 'L',
                'notif_alerta_meta'     => (bool)($usuario['notif_alerta_meta']     ?? 1),
                'notif_lembrete_fatura' => (bool)($usuario['notif_lembrete_fatura'] ?? 1),
                'notif_dicas'           => (bool)($usuario['notif_dicas']           ?? 1),
                'dark_mode'             => (bool)($usuario['dark_mode']             ?? 0),
            ],
        ]);
    }

    // -------------------------------------------------------
    // POST /api/auth/forgot-password
    // Body: { "email": "..." }
    // -------------------------------------------------------
    public function forgotPassword(): void
    {
        $this->cors();
        $body  = $this->body();
        $email = trim($body['email'] ?? '');

        if (!$email) {
            JwtMiddleware::json(400, ['success' => false, 'message' => 'Email é obrigatório.']);
        }

        $usuarioDAO = new UsuarioDAO();
        $usuario    = $usuarioDAO->buscarPorEmail($email);

        $token = null;
        if ($usuario) {
            $resetDAO = new PasswordResetDAO();
            $token    = $resetDAO->criarToken($usuario['id']);
        }

        // Sempre retorna sucesso (não revelar se email existe)
        JwtMiddleware::json(200, [
            'success' => true,
            'message' => 'Se o email estiver cadastrado, você receberá instruções.',
            'token'   => $token, // apenas para demo do TCC
        ]);
    }

    // -------------------------------------------------------
    // POST /api/auth/reset-password
    // Body: { "token": "...", "nova_senha": "..." }
    // -------------------------------------------------------
    public function resetPassword(): void
    {
        $this->cors();
        $body      = $this->body();
        $token     = trim($body['token']     ?? '');
        $novaSenha = trim($body['nova_senha'] ?? '');

        if (!$token || !$novaSenha) {
            JwtMiddleware::json(400, ['success' => false, 'message' => 'Token e nova senha são obrigatórios.']);
        }

        if (strlen($novaSenha) < 6) {
            JwtMiddleware::json(400, ['success' => false, 'message' => 'A senha deve ter no mínimo 6 caracteres.']);
        }

        $resetDAO = new PasswordResetDAO();
        $dados    = $resetDAO->validarToken($token);

        if (!$dados) {
            JwtMiddleware::json(400, ['success' => false, 'message' => 'Token inválido ou expirado.']);
        }

        $usuarioDAO = new UsuarioDAO();
        $model      = new UsuarioModel();
        $model->__set('user_id',    $dados['usuario_id']);
        $model->__set('user_senha', $novaSenha);
        $usuarioDAO->alterarSenha($model);

        $resetDAO->marcarUsado($token);

        JwtMiddleware::json(200, ['success' => true, 'message' => 'Senha redefinida com sucesso.']);
    }

    // -------------------------------------------------------
    // GET /api/dicas
    // -------------------------------------------------------
    public function getDicas(): void
    {
        $this->cors();

        $dao        = new DicasDAO();
        $dicas      = $dao->randomTips();
        $dicasArray = [];

        foreach ($dicas as $dica) {
            $dicasArray[] = [
                'id'       => $dica->__get('id_dicas'),
                'descricao'=> $dica->__get('dicas_desc'),
            ];
        }

        JwtMiddleware::json(200, ['success' => true, 'dicas' => $dicasArray]);
    }

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
