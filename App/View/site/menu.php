<?php 
session_start();

// Formatar CPF do cookie
$cpf_exibir = isset($this->view->cpf_formatado) ? $this->view->cpf_formatado : '';

// Função para mostrar popup
function mostrarPopup($mensagem, $tipo = "sucesso") {
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');
    $tipo = ($tipo === "erro") ? "erro" : "sucesso";

    echo <<<HTML
    <div id="popupMensagem" class="popup {$tipo}">
        <div class="popup-conteudo">
            <span id="fecharPopup" class="fechar">&times;</span>
            <p>{$mensagem}</p>
        </div>
    </div>

    <style>
    .popup {
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
    }
    .popup-conteudo {
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 8px;
        text-align: center;
        min-width: 300px;
        max-width: 90%;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
        position: relative;
    }
    .fechar {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
    }
    .popup.sucesso .popup-conteudo {
        border-left: 5px solid #2b3f9bff;
    }
    .popup.erro .popup-conteudo {
        border-left: 5px solid #dc3545;
    }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var popup = document.getElementById("popupMensagem");
        if (popup) {
            var fechar = document.getElementById("fecharPopup");
            fechar.onclick = function() {
                popup.style.display = "none";
            }
            setTimeout(function() {
                popup.style.display = "none";
            }, 10000);
        }
    });
    </script>
HTML;
}

// Mostrar popups se houver mensagens
if(isset($_SESSION['senha_alterada'])){
  if($_SESSION['senha_alterada'] == 1){
    mostrarPopup("Senha alterada com sucesso!");
    $_SESSION['senha_alterada'] = 0;
  }
}

if(isset($_SESSION['perfil_atualizado'])){
  if($_SESSION['perfil_atualizado'] == 1){
    mostrarPopup("Perfil atualizado com sucesso!");
    $_SESSION['perfil_atualizado'] = 0;
  }
}
?>
<body class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 min-h-screen">

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        
        <!-- Page Title -->
        <div class="text-center mb-6">
            <h2 class="text-4xl font-bold text-gray-800 mb-3">Meu Perfil</h2>
            <p class="text-gray-600 text-lg">Gerencie suas informações pessoais e preferências</p>
        </div>

        <!-- Mensagens de Erro -->
        <?php if (isset($this->view->mensagemErro) && $this->view->mensagemErro): ?>
            <div class="max-w-2xl mx-auto mb-6">
                <div class="bg-red-50 border-l-4 border-red-400 text-red-800 p-4 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-red-500 mr-2">❌</span>
                        <?= htmlspecialchars($this->view->mensagemErro) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Profile Form Section -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white text-xl">👤</span>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">Informações Pessoais</h3>
                </div>

                <form id="perfilForm" action="/editarusuario" method="POST" class="space-y-4">
                    <div>
                        <label for="nome" class="block text-gray-700 font-medium mb-1">Nome Completo</label>
                        <input name="USER_NOME" 
                               type="text" 
                               id="nome" 
                               value="<?= isset($this->view->usuario['nome']) ? htmlspecialchars($this->view->usuario['nome']) : '' ?>"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               required>
                    </div>
                    
                    <div>
                        <label for="cpf" class="block text-gray-700 font-medium mb-1">CPF</label>
                        <input type="text" 
                               id="cpf" 
                               value="<?= htmlspecialchars($cpf_exibir) ?>"
                               class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                        <p class="text-xs text-gray-500 mt-1">O CPF não pode ser alterado</p>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-1">E-mail</label>
                        <input name="USER_EMAIL" 
                               type="email" 
                               id="email" 
                               value="<?= isset($this->view->usuario['email']) ? htmlspecialchars($this->view->usuario['email']) : '' ?>"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                               required>
                    </div>

                    <?php if (isset($this->view->usuario['created_at'])): ?>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Membro desde</label>
                        <p class="text-gray-600">
                            <?= date('d/m/Y', strtotime($this->view->usuario['created_at'])) ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-800 text-white font-medium py-2 rounded transition">
                        💾 Salvar Alterações
                    </button>
                </form>
            </div>
        </div>

        <!-- Settings Sections -->
        <div class="max-w-4xl mx-auto">
            
            <!-- Security Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-8">
                <div class="w-full bg-blue-600 px-8 py-4">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <span class="mr-3">🔒</span>
                        Conta e Segurança
                    </h3>
                </div>
                <div class="p-8">
                    <button type="button"
                            onclick="location.href='/redefinirSenha'"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-all transform hover:scale-105 shadow-lg">
                        🔑 Redefinir Senha
                    </button>
                </div>
            </div>

            <!-- Notifications Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-8">
                <div class="bg-blue-600 shadow-lg px-8 py-4">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <span class="mr-3">🔔</span>
                        Notificações
                    </h3>
                </div>
                <div class="p-8 space-y-6">
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <input id="notifyAlerts" 
                               type="checkbox" 
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                               checked>
                        <label for="notifyAlerts" class="ml-4 text-gray-700 font-medium">
                            📧 E-mail de alerta de consumo alto
                        </label>
                    </div>
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <input id="weeklySummary" 
                               type="checkbox" 
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="weeklySummary" class="ml-4 text-gray-700 font-medium">
                            📊 Resumo semanal por e-mail
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 italic">
                        * As preferências de notificação serão implementadas em breve
                    </p>
                </div>
            </div>

            <!-- Preferences Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-8">
                <div class="bg-blue-600 shadow-lg px-8 py-4">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <span class="mr-3">⚙️</span>
                        Preferências
                    </h3>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <label for="unitSelect" class="block text-gray-700 font-medium mb-3">
                            📏 Unidade de medida padrão
                        </label>
                        <select id="unitSelect" 
                                class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="L">Litros (L)</option>
                            <option value="m³">Metros cúbicos (m³)</option>
                        </select>
                    </div>
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg opacity-50 cursor-not-allowed">
                        <input id="darkMode" 
                               type="checkbox" 
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               disabled>
                        <label for="darkMode" class="ml-4 text-gray-700 font-medium">
                            🌙 Modo Escuro (Em breve)
                        </label>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-8">
                <div class="bg-blue-600 shadow-lg px-8 py-4">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <span class="mr-3">ℹ️</span>
                        Sobre o EcoÁgua
                    </h3>
                </div>
                <div class="p-8 bg-gradient-to-r from-gray-50 to-blue-50">
                    <div class="grid md:grid-cols-2 gap-6 text-gray-700">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📱</span>
                            <div>
                                <p class="font-medium">Versão do sistema</p>
                                <p class="text-blue-600 font-bold text-lg">1.0.0</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">©️</span>
                            <div>
                                <p class="font-medium">© 2025 EcoÁgua</p>
                                <p class="text-sm text-gray-500">Todos os direitos reservados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-y-4">
                <button onclick="window.location.href='/dashboard'"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-12 rounded-full transition-all transform hover:scale-105 shadow-xl text-lg">
                    🏠 Voltar ao Dashboard
                </button>
                
                <button onclick="if(confirm('Tem certeza que deseja sair?')) window.location.href='/sair'"
                        class="block mx-auto bg-red-500 hover:bg-red-600 text-white font-medium py-3 px-8 rounded-lg transition-all">
                    🚪 Sair da Conta
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-600">
                <p class="flex items-center justify-center mb-2">
                    <span class="text-blue-500 mr-2">💧</span>
                    Economize água, preserve o futuro
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animação suave ao carregar
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>