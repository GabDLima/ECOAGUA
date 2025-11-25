<?php
/**
 * Componente Global de Mensagens
 * Sistema de notificações usando SweetAlert2
 */

function exibirMensagens() {
    $mensagens = [
        'login_realizado' => ['mensagem' => 'Login realizado com sucesso!', 'tipo' => 'sucesso'],
        'usuario_desconectado' => ['mensagem' => 'Você saiu da sua conta', 'tipo' => 'info'],
        'usuario_cadastrado' => ['mensagem' => 'Conta criada com sucesso!', 'tipo' => 'sucesso'],
        'senhas_nao_conferem' => ['mensagem' => 'As senhas digitadas não conferem', 'tipo' => 'erro'],
        'mensagem_login_incorreto' => ['mensagem' => 'E-mail ou senha incorretos', 'tipo' => 'erro'],
        'senha_alterada' => ['mensagem' => 'Senha alterada com sucesso!', 'tipo' => 'sucesso'],
        'perfil_atualizado' => ['mensagem' => 'Perfil atualizado com sucesso!', 'tipo' => 'sucesso'],
        'senha_nao_confere' => ['mensagem' => 'As senhas não conferem!', 'tipo' => 'erro'],
        'erro_cadastro' => ['mensagem' => $_SESSION['erro_cadastro'] ?? 'Erro ao cadastrar', 'tipo' => 'erro'],
        'erro_edicao' => ['mensagem' => $_SESSION['erro_edicao'] ?? 'Erro ao editar', 'tipo' => 'erro'],
        'erro_senha' => ['mensagem' => $_SESSION['erro_senha'] ?? 'Erro ao alterar senha', 'tipo' => 'erro']
    ];

    foreach ($mensagens as $chave => $dados) {
        if (isset($_SESSION[$chave]) && $_SESSION[$chave] == 1) {
            mostrarNotificacaoSweetAlert($dados['mensagem'], $dados['tipo']);
            $_SESSION[$chave] = 0;
            break;
        }
    }
}

function mostrarNotificacaoSweetAlert($mensagem, $tipo = "sucesso") {
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');

    $iconMap = [
        'sucesso' => 'success',
        'erro' => 'error',
        'info' => 'info',
        'alerta' => 'warning'
    ];

    $icon = $iconMap[$tipo] ?? 'info';

    echo "<script src='/resources/dashboard/js/sweetalert_config.js'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            EcoAlert.toast('{$icon}', '{$mensagem}');
        });
    </script>";
}

function mostrarNotificacao($mensagem, $tipo = "sucesso") {
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');

    $icons = [
        'sucesso' => '<i class="fas fa-check-circle"></i>',
        'erro' => '<i class="fas fa-exclamation-circle"></i>',
        'info' => '<i class="fas fa-info-circle"></i>',
        'alerta' => '<i class="fas fa-exclamation-triangle"></i>'
    ];

    $colors = [
        'sucesso' => '#2b3f9bff',
        'erro' => '#dc3545',
        'info' => '#17a2b8',
        'alerta' => '#ffc107'
    ];

    $icon = $icons[$tipo] ?? $icons['info'];
    $borderColor = $colors[$tipo] ?? $colors['info'];

    echo <<<HTML
    <div id="notificacaoGlobal" class="notificacao-overlay">
        <div class="notificacao-conteudo">
            <span id="fecharNotificacao" class="fechar">&times;</span>
            <div class="notificacao-icon">
                {$icon}
            </div>
            <p>{$mensagem}</p>
        </div>
    </div>

    <style>
    .notificacao-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease-in;
    }

    .notificacao-conteudo {
        background-color: #fff;
        padding: 25px 35px;
        border-radius: 10px;
        text-align: center;
        min-width: 320px;
        max-width: 90%;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        position: relative;
        border-left: 5px solid {$borderColor};
        animation: slideDown 0.3s ease-out;
    }

    .fechar {
        position: absolute;
        top: 12px;
        right: 18px;
        font-size: 22px;
        cursor: pointer;
        color: #999;
        transition: color 0.2s;
    }

    .fechar:hover {
        color: #333;
    }

    .notificacao-icon {
        font-size: 48px;
        color: {$borderColor};
        margin-bottom: 15px;
    }

    .notificacao-conteudo p {
        margin: 0;
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var notificacao = document.getElementById("notificacaoGlobal");
        if (notificacao) {
            var fechar = document.getElementById("fecharNotificacao");

            fechar.onclick = function() {
                notificacao.style.opacity = '0';
                setTimeout(function() {
                    notificacao.style.display = "none";
                }, 300);
            }

            setTimeout(function() {
                notificacao.style.opacity = '0';
                setTimeout(function() {
                    notificacao.style.display = "none";
                }, 300);
            }, 5000);

            // Fechar ao clicar fora
            notificacao.onclick = function(e) {
                if (e.target === notificacao) {
                    fechar.click();
                }
            }
        }
    });
    </script>
HTML;
}

// Chamar automaticamente
exibirMensagens();
?>
