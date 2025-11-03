<?php

namespace App\Controller;

use FW\Controller\Action;
use App\DAO\DicasDAO;
use App\DAO\ConsumoDiarioDAO;
use App\DAO\ValordaContaDAO;
use App\DAO\MetaConsumoDAO;


class SiteController extends Action{

    public function login(){
        $title = "Login";
        $title_pagina = "Bem vindo ao site";

        

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('login', 'site_login');
    }
    

    public function validaAutenticacao() {

        
    }

    public function menu(){
        session_start();
        
        // Verifica autenticação
        if (!isset($_COOKIE['cookie_id'])) {
            header('Location: /');
            exit;
        }
        else if($_COOKIE['cookie_id']==0){
            header('Location: /');
            exit;
        }
        
        $id_usuario = $_COOKIE['cookie_id'];
        
        $title = "Menu";
        $title_pagina = "Meu Perfil";

        // === BUSCAR DADOS DO USUÁRIO ===
        $usuarioDAO = new \App\DAO\UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorId($id_usuario);
        
        if (!$usuario) {
            // Se não encontrar o usuário, desloga
            setcookie('cookie_id', '', time() - 3600, '/');
            setcookie('cookie_nome', '', time() - 3600, '/');
            setcookie('cookie_cpf', '', time() - 3600, '/');
            header('Location: /');
            exit;
        }

        // === FORMATAR CPF ===
        $cpf_exibir = str_pad($usuario['cpf'], 11, '0', STR_PAD_LEFT);
        $cpf_formatado = substr($cpf_exibir, 0, 3) . '.' . 
                        substr($cpf_exibir, 3, 3) . '.' . 
                        substr($cpf_exibir, 6, 3) . '-' . 
                        substr($cpf_exibir, 9, 2);

        // === VERIFICAR MENSAGENS DE FEEDBACK ===
        $mensagemSucesso = null;
        $mensagemErro = null;
        
        if (isset($_SESSION['perfil_atualizado']) && $_SESSION['perfil_atualizado'] == 1) {
            $mensagemSucesso = 'Perfil atualizado com sucesso!';
            $_SESSION['perfil_atualizado'] = 0;
        }
        
        if (isset($_SESSION['senha_alterada']) && $_SESSION['senha_alterada'] == 1) {
            $mensagemSucesso = 'Senha alterada com sucesso!';
            $_SESSION['senha_alterada'] = 0;
        }
        
        if (isset($_SESSION['erro_edicao'])) {
            $mensagemErro = $_SESSION['erro_edicao'];
            unset($_SESSION['erro_edicao']);
        }

        // === PASSAR DADOS PARA A VIEW ===
        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;
        
        // Dados do usuário
        $this->getView()->usuario = $usuario;
        $this->getView()->cpf_formatado = $cpf_formatado;
        
        // Mensagens de feedback
        $this->getView()->mensagemSucesso = $mensagemSucesso;
        $this->getView()->mensagemErro = $mensagemErro;

        $this->render('menu', 'site');
    }


     public function dashboard() {
        // Verifica autenticação
        if (!isset($_COOKIE['cookie_id'])) {
            header('Location: /');
            exit;
        }
        else if($_COOKIE['cookie_id']==0){
            header('Location: /');
            exit;
        }

        $id_usuario = $_COOKIE['cookie_id'];
        $nome_usuario = $_COOKIE['cookie_nome'];

        // === DICAS ALEATÓRIAS ===
        $dicasDAO = new DicasDAO();
        $dicas = $dicasDAO->randomTips();

        // === CONSUMO DIÁRIO ===
        $consumoDAO = new ConsumoDiarioDAO();
        
        // Últimos 7 dias para a tabela
        $ultimos7dias = $consumoDAO->buscarUltimos7Dias($id_usuario);
        
        // Consumo mensal (últimos 6 meses) para gráfico de linha
        $consumoMensal = $consumoDAO->buscarConsumoMensal($id_usuario, 6);
        
        // Consumo por tipo (para gráfico pizza/rosca)
        $consumoPorTipo = $consumoDAO->buscarConsumoPorTipo($id_usuario);
        
        // Total do mês atual
        $totalMesAtual = $consumoDAO->buscarTotalMesAtual($id_usuario);
        
        // Total do mês anterior (para comparação)
        $totalMesAnterior = $consumoDAO->buscarTotalMesAnterior($id_usuario);

        // === FATURAS ===
        $faturaDAO = new ValordaContaDAO();
        
        // Última fatura
        $ultimaFatura = $faturaDAO->buscarUltimaFatura($id_usuario);
        
        // Faturas recentes (últimos 6 meses)
        $faturasRecentes = $faturaDAO->buscarFaturasRecentes($id_usuario, 6);
        
        // Total gasto no ano
        $totalGastoAno = $faturaDAO->buscarTotalGastoAno($id_usuario);
        
        // Média mensal
        $mediaMensal = $faturaDAO->buscarMediaMensal($id_usuario, 6);

        // === METAS ===
        $metaDAO = new MetaConsumoDAO();
        
        // Meta ativa
        $metaAtiva = $metaDAO->buscarMetaAtiva($id_usuario);
        
        // Progresso da meta (com cálculo automático)
        $progressoMeta = $metaDAO->calcularProgressoMeta($id_usuario);

        // === CÁLCULOS E ALERTAS ===
        
        // Variação percentual vs mês anterior
        $variacaoPercentual = 0;
        if ($totalMesAnterior > 0) {
            $variacaoPercentual = (($totalMesAtual - $totalMesAnterior) / $totalMesAnterior) * 100;
        }
        
        // Projeção para o fim do mês
        $diaAtual = date('d');
        $diasNoMes = date('t');
        $projecaoMensal = $diasNoMes > 0 ? ($totalMesAtual / $diaAtual) * $diasNoMes : 0;

        // Alertas
        $alertas = array();
        
        // Alerta de meta
        if ($progressoMeta && $progressoMeta['alerta']) {
            $alertas[] = array(
                'tipo' => 'meta',
                'mensagem' => 'Você excedeu 90% da sua meta mensal!',
                'percentual' => $progressoMeta['percentual']
            );
        }
        
        // Alerta de aumento de consumo
        if ($variacaoPercentual > 20) {
            $alertas[] = array(
                'tipo' => 'aumento',
                'mensagem' => 'Consumo aumentou ' . round($variacaoPercentual, 1) . '% em relação ao mês anterior.',
                'percentual' => $variacaoPercentual
            );
        }

        // === PREPARAR DADOS PARA GRÁFICOS (formato JSON) ===
        
        // Gráfico de Linha - Consumo Mensal
        $graficoLinhaLabels = array();
        $graficoLinhaData = array();
        foreach ($consumoMensal as $item) {
            $graficoLinhaLabels[] = $item['mes_nome'] ?? $item['mes'];
            $graficoLinhaData[] = round($item['total_litros'], 0);
        }
        
        // Gráfico Pizza/Rosca - Por Tipo
        $graficoPizzaLabels = array();
        $graficoPizzaData = array();
        foreach ($consumoPorTipo as $item) {
            $graficoPizzaLabels[] = $item['tipo'];
            $graficoPizzaData[] = round($item['total_litros'], 0);
        }
        
        // Gráfico de Barra - Faturas
        $graficoBarraLabels = array();
        $graficoBarraData = array();
        foreach ($faturasRecentes as $item) {
            $graficoBarraLabels[] = $item['mes_nome'] ?? $item['mes'];
            $graficoBarraData[] = round($item['valor'], 2);
        }

        // === PASSAR DADOS PARA A VIEW ===
        $this->getView()->title = "Dashboard";
        $this->getView()->title_pagina = "Painel do Usuário";
        $this->getView()->nome_usuario = $nome_usuario;
        
        // Dicas
        $this->getView()->dicas = $dicas;
        
        // Consumo
        $this->getView()->ultimos7dias = $ultimos7dias;
        $this->getView()->totalMesAtual = round($totalMesAtual, 0);
        $this->getView()->totalMesAnterior = round($totalMesAnterior, 0);
        $this->getView()->variacaoPercentual = round($variacaoPercentual, 1);
        $this->getView()->projecaoMensal = round($projecaoMensal, 0);
        
        // Faturas
        $this->getView()->ultimaFatura = $ultimaFatura;
        $this->getView()->totalGastoAno = round($totalGastoAno, 2);
        $this->getView()->mediaMensal = round($mediaMensal, 2);
        
        // Metas
        $this->getView()->metaAtiva = $metaAtiva;
        $this->getView()->progressoMeta = $progressoMeta;
        
        // Alertas
        $this->getView()->alertas = $alertas;
        
        // Dados para gráficos (JSON)
        $this->getView()->graficoLinhaLabels = json_encode($graficoLinhaLabels);
        $this->getView()->graficoLinhaData = json_encode($graficoLinhaData);
        $this->getView()->graficoPizzaLabels = json_encode($graficoPizzaLabels);
        $this->getView()->graficoPizzaData = json_encode($graficoPizzaData);
        $this->getView()->graficoBarraLabels = json_encode($graficoBarraLabels);
        $this->getView()->graficoBarraData = json_encode($graficoBarraData);
        
        // CONSUMO DE HOJE PARA A NAVBAR
        $consumoHoje = $consumoDAO->buscarConsumoHoje($id_usuario);
        $this->getView()->consumoHoje = round($consumoHoje, 0);

        $this->render('dashboard', 'site');
    }

    public function consumo(){
    // Verifica autenticação
    if (!isset($_COOKIE['cookie_id'])) {
        header('Location: /');
        exit;
    }
    else if($_COOKIE['cookie_id']==0){
        header('Location: /');
        exit;
    }

    $id_usuario = $_COOKIE['cookie_id'];

    $title = "Consumo";
    $title_pagina = "Gerenciar Dados de Consumo";

    // === BUSCAR DADOS PARA OS CARDS ===
    
    // Última fatura
    $faturaDAO = new \App\DAO\ValordaContaDAO();
    $ultimaFatura = $faturaDAO->buscarUltimaFatura($id_usuario);
    
    // Meta ativa
    $metaDAO = new \App\DAO\MetaConsumoDAO();
    $metaAtiva = $metaDAO->buscarMetaAtiva($id_usuario);
    $progressoMeta = $metaDAO->calcularProgressoMeta($id_usuario);
    
    // Total de consumos do mês
    $consumoDAO = new \App\DAO\ConsumoDiarioDAO();
    $totalMesAtual = $consumoDAO->buscarTotalMesAtual($id_usuario);

    // === BUSCAR DADOS PARA A TABELA "RESUMO" ===
    
    // Últimas 3 faturas
    $ultimasFaturas = $faturaDAO->buscarFaturasRecentes($id_usuario, 3);
    
    // Últimas 3 metas
    $ultimasMetas = $metaDAO->listarPorUsuario($id_usuario);
    if (count($ultimasMetas) > 3) {
        $ultimasMetas = array_slice($ultimasMetas, 0, 3);
    }
    
    // Últimos 5 consumos
    $ultimosConsumos = $consumoDAO->buscarUltimos7Dias($id_usuario);
    if (count($ultimosConsumos) > 5) {
        $ultimosConsumos = array_slice($ultimosConsumos, 0, 5);
    }

    // === PASSAR DADOS PARA A VIEW ===
    $this->getView()->title = $title;
    $this->getView()->title_pagina = $title_pagina;
    
    // Cards
    $this->getView()->ultimaFatura = $ultimaFatura;
    $this->getView()->metaAtiva = $metaAtiva;
    $this->getView()->progressoMeta = $progressoMeta;
    $this->getView()->totalMesAtual = round($totalMesAtual, 0);
    
    // Tabela resumo
    $this->getView()->ultimasFaturas = $ultimasFaturas;
    $this->getView()->ultimasMetas = $ultimasMetas;
    $this->getView()->ultimosConsumos = $ultimosConsumos;
    
    // CONSUMO DE HOJE PARA A NAVBAR
    $consumoHoje = $consumoDAO->buscarConsumoHoje($id_usuario);
    $this->getView()->consumoHoje = round($consumoHoje, 0);

    $this->render('consumo', 'site');
}

    public function redefinirSenha(){
        if (!isset($_COOKIE['cookie_id'])) {
            header('Location: /');
        }
        else if($_COOKIE['cookie_id']==0){
            header('Location: /');
        }
        
        $title = "Consumo";
        $title_pagina = "Bem vindo ao site";

        $this->getView()->title = $title;
        $this->getView()->title_pagina = $title_pagina;

        $this->render('redefinirSenha', 'site_login');
    }

    public function metas(){
    // Verifica autenticação
    if (!isset($_COOKIE['cookie_id'])) {
        header('Location: /');
        exit;
    }
    else if($_COOKIE['cookie_id']==0){
        header('Location: /');
        exit;
    }

    $id_usuario = $_COOKIE['cookie_id'];

    $title = "Metas";
    $title_pagina = "Metas de Economia";

    // === BUSCAR DADOS ===
    $metaDAO = new \App\DAO\MetaConsumoDAO();
    $consumoDAO = new \App\DAO\ConsumoDiarioDAO();
    
    // Meta ativa
    $metaAtiva = $metaDAO->buscarMetaAtiva($id_usuario);
    $progressoMeta = $metaDAO->calcularProgressoMeta($id_usuario);
    
    // Total do mês atual
    $totalMesAtual = $consumoDAO->buscarTotalMesAtual($id_usuario);
    
    // === HISTÓRICO DE METAS (últimos 6 meses) ===
    $todasMetas = $metaDAO->listarPorUsuario($id_usuario);
    $historicoMetas = array();
    
    // Buscar consumo real de cada meta
    foreach ($todasMetas as $meta) {
        $meta_litros = $meta->__get('meta_mensal');
        $meta_id = $meta->__get('id');
        
        // Para simplificar, vamos pegar os últimos 6 registros
        // Em produção, você pode adicionar uma coluna 'mes_referencia' na tabela meta_consumo
        if (count($historicoMetas) < 6) {
            // Calcular mês de referência (assumindo que a meta foi criada no mês atual)
            // Este é um exemplo - você pode melhorar adicionando data de criação
            $meses_atras = count($historicoMetas);
            $mes = date('n', strtotime("-$meses_atras months"));
            $ano = date('Y', strtotime("-$meses_atras months"));
            
            $consumo_real = $consumoDAO->buscarConsumoPorMes($id_usuario, $mes, $ano);
            $diferenca = $consumo_real - $meta_litros;
            $percentual = $meta_litros > 0 ? ($consumo_real / $meta_litros) * 100 : 0;
            $status = $percentual <= 100 ? 'atingida' : 'nao_atingida';
            
            $historicoMetas[] = array(
                'mes_nome' => date('F/Y', strtotime("-$meses_atras months")),
                'mes' => $mes,
                'ano' => $ano,
                'meta_litros' => $meta_litros,
                'consumo_real' => $consumo_real,
                'diferenca' => $diferenca,
                'percentual' => round($percentual, 1),
                'status' => $status
            );
        }
    }
    
    // Inverter para mostrar do mais antigo ao mais recente
    $historicoMetas = array_reverse($historicoMetas);
    
    // === CONSUMO POR TIPO (para metas por categoria) ===
    $consumoPorTipo = $consumoDAO->buscarConsumoPorTipo($id_usuario);
    
    // Calcular meta proporcional por tipo
    $totalConsumoTipos = 0;
    foreach ($consumoPorTipo as $tipo) {
        $totalConsumoTipos += $tipo['total_litros'];
    }
    
    $metasPorCategoria = array();
    if ($metaAtiva && $totalConsumoTipos > 0) {
        foreach ($consumoPorTipo as $tipo) {
            $proporcao = $tipo['total_litros'] / $totalConsumoTipos;
            $meta_categoria = $metaAtiva['meta_mensal'] * $proporcao;
            $percentual = $meta_categoria > 0 ? ($tipo['total_litros'] / $meta_categoria) * 100 : 0;
            
            $metasPorCategoria[] = array(
                'tipo' => $tipo['tipo'],
                'meta' => round($meta_categoria, 0),
                'consumo' => round($tipo['total_litros'], 0),
                'percentual' => round($percentual, 1),
                'status' => $percentual <= 100 ? 'ok' : 'acima'
            );
        }
    }
    
    // === CALCULAR STATUS GERAL ===
    $statusGeral = 'Sem Meta';
    $economiaEsperada = 0;
    
    if ($progressoMeta) {
        if ($progressoMeta['percentual'] <= 90) {
            $statusGeral = 'Dentro da Meta';
        } elseif ($progressoMeta['percentual'] <= 100) {
            $statusGeral = 'Próximo ao Limite';
        } else {
            $statusGeral = 'Acima da Meta';
        }
        $economiaEsperada = $progressoMeta['meta_reducao'];
    }

    // === PASSAR DADOS PARA A VIEW ===
    $this->getView()->title = $title;
    $this->getView()->title_pagina = $title_pagina;
    
    // Cards resumo
    $this->getView()->metaAtiva = $metaAtiva;
    $this->getView()->progressoMeta = $progressoMeta;
    $this->getView()->totalMesAtual = round($totalMesAtual, 0);
    $this->getView()->statusGeral = $statusGeral;
    $this->getView()->economiaEsperada = $economiaEsperada;
    
    // Histórico e categorias
    $this->getView()->historicoMetas = $historicoMetas;
    $this->getView()->metasPorCategoria = $metasPorCategoria;

    $this->render('metas', 'site');
}

    

}
