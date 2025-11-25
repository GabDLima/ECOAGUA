<?php
include __DIR__ . '/../includes/mensagens.php';

// Formatar CPF do cookie
$cpf_exibir = isset($this->view->cpf_formatado) ? $this->view->cpf_formatado : '';
?>
<body class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 min-h-screen">

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6 pt-20">
        
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
                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                        <?= htmlspecialchars($this->view->mensagemErro) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Profile Form Section -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="eco-card animate-fade-in">
                <div class="flex items-center mb-6">
                    <div class="eco-card-icon bg-blue-100 mr-4">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">Informações Pessoais</h3>
                </div>

                <form id="perfilForm" action="/editarusuario" method="POST" class="space-y-4">
                    <div>
                        <label for="nome" class="eco-label">
                            <i class="fas fa-user-circle mr-2"></i>Nome Completo
                        </label>
                        <input name="USER_NOME"
                               type="text"
                               id="nome"
                               value="<?= isset($this->view->usuario['nome']) ? htmlspecialchars($this->view->usuario['nome']) : '' ?>"
                               class="eco-input"
                               placeholder="Seu nome completo"
                               required>
                        <p class="eco-help-text">Digite seu nome completo como aparece nos documentos</p>
                    </div>

                    <div>
                        <label for="cpf" class="eco-label">
                            <i class="fas fa-id-card mr-2"></i>CPF
                        </label>
                        <input type="text"
                               id="cpf"
                               value="<?= htmlspecialchars($cpf_exibir) ?>"
                               class="eco-input bg-gray-100 cursor-not-allowed"
                               readonly>
                        <p class="eco-help-text"><i class="fas fa-lock mr-1"></i>O CPF não pode ser alterado por questões de segurança</p>
                    </div>

                    <div>
                        <label for="email" class="eco-label">
                            <i class="fas fa-envelope mr-2"></i>E-mail
                        </label>
                        <input name="USER_EMAIL"
                               type="email"
                               id="email"
                               value="<?= isset($this->view->usuario['email']) ? htmlspecialchars($this->view->usuario['email']) : '' ?>"
                               class="eco-input"
                               placeholder="seu@email.com"
                               required>
                        <p class="eco-help-text">E-mail usado para login e notificações</p>
                    </div>

                    <?php if (isset($this->view->usuario['created_at'])): ?>
                    <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-check text-blue-600 mr-3 text-xl"></i>
                            <div>
                                <p class="text-sm font-medium text-blue-800">Membro desde</p>
                                <p class="text-lg font-semibold text-blue-900">
                                    <?= date('d/m/Y', strtotime($this->view->usuario['created_at'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="btn-eco btn-eco-success w-full">
                        <i class="fas fa-save mr-2"></i>Salvar Alterações
                    </button>
                </form>
            </div>
        </div>

        <!-- Settings Sections -->
        <div class="max-w-4xl mx-auto">
            
            <!-- Security Section -->
            <div class="eco-card animate-fade-in mb-8" style="animation-delay: 0.1s;">
                <div class="flex items-center mb-6">
                    <div class="eco-card-icon bg-red-100 mr-4">
                        <i class="fas fa-lock text-red-600"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">Conta e Segurança</h3>
                </div>
                <div>
                    <button type="button"
                            onclick="location.href='/redefinirSenha'"
                            class="btn-eco btn-eco-primary w-full">
                        <i class="fas fa-key mr-2"></i>Redefinir Senha
                    </button>
                    <p class="eco-help-text text-center mt-3">
                        <i class="fas fa-shield-alt mr-1"></i>Mantenha sua conta segura atualizando sua senha regularmente
                    </p>
                </div>
            </div>

            <!-- Notifications Section -->
            <div class="eco-card animate-fade-in mb-8" style="animation-delay: 0.2s;">
                <div class="flex items-center mb-6">
                    <div class="eco-card-icon bg-yellow-100 mr-4">
                        <i class="fas fa-bell text-yellow-600"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">Notificações</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100 hover:shadow-md transition-all">
                        <input id="notifyAlerts"
                               type="checkbox"
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               checked>
                        <label for="notifyAlerts" class="ml-4 text-gray-800 font-medium flex-1 cursor-pointer">
                            <i class="fas fa-envelope text-blue-600 mr-2"></i>E-mail de alerta de consumo alto
                        </label>
                        <span class="eco-badge eco-badge-success">Ativo</span>
                    </div>
                    <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-gray-200 hover:shadow-md transition-all">
                        <input id="weeklySummary"
                               type="checkbox"
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="weeklySummary" class="ml-4 text-gray-800 font-medium flex-1 cursor-pointer">
                            <i class="fas fa-chart-bar text-purple-600 mr-2"></i>Resumo semanal por e-mail
                        </label>
                        <span class="eco-badge eco-badge-info">Em breve</span>
                    </div>
                    <p class="eco-help-text text-center italic">
                        <i class="fas fa-info-circle mr-1"></i>As preferências de notificação serão implementadas em breve
                    </p>
                </div>
            </div>

            <!-- Preferences Section -->
            <div class="eco-card animate-fade-in mb-8" style="animation-delay: 0.3s;">
                <div class="flex items-center mb-6">
                    <div class="eco-card-icon bg-purple-100 mr-4">
                        <i class="fas fa-cog text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">Preferências</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label for="unitSelect" class="eco-label">
                            <i class="fas fa-ruler mr-2"></i>Unidade de medida padrão
                        </label>
                        <select id="unitSelect" class="eco-input">
                            <option value="L">Litros (L)</option>
                            <option value="m³">Metros cúbicos (m³)</option>
                        </select>
                        <p class="eco-help-text">Escolha a unidade que você prefere visualizar</p>
                    </div>
                    <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-purple-50 rounded-xl border border-purple-100 hover:shadow-md transition-all">
                        <input id="darkModeToggle"
                               type="checkbox"
                               class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="darkModeToggle" class="ml-4 text-gray-800 font-medium flex-1 cursor-pointer">
                            <i class="fas fa-moon text-purple-600 mr-2"></i>Modo Escuro
                        </label>
                        <span class="eco-badge eco-badge-info">
                            <i class="fas fa-palette mr-1"></i>Tema
                        </span>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="eco-card animate-fade-in mb-8" style="animation-delay: 0.4s;">
                <div class="flex items-center mb-6">
                    <div class="eco-card-icon bg-cyan-100 mr-4">
                        <i class="fas fa-info-circle text-cyan-600"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">Sobre o EcoÁgua</h3>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-100">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                            <div class="eco-card-icon bg-blue-100 mr-4" style="width: 3rem; height: 3rem;">
                                <i class="fas fa-mobile-alt text-blue-600" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Versão do sistema</p>
                                <p class="text-blue-600 font-bold text-xl">3.0.0</p>
                            </div>
                        </div>
                        <div class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all">
                            <div class="eco-card-icon bg-green-100 mr-4" style="width: 3rem; height: 3rem;">
                                <i class="fas fa-copyright text-green-600" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">© 2025 EcoÁgua</p>
                                <p class="text-xs text-gray-500">Todos os direitos reservados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-y-4 animate-fade-in" style="animation-delay: 0.5s;">
                <button onclick="window.location.href='/dashboard'"
                        class="btn-eco btn-eco-primary px-12 py-4 text-lg">
                    <i class="fas fa-home mr-2"></i>Voltar ao Dashboard
                </button>

                <button onclick="confirmarLogout(event)"
                        class="btn-eco bg-red-500 hover:bg-red-600 text-white mx-auto block">
                    <i class="fas fa-sign-out-alt mr-2"></i>Sair da Conta
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-600">
                <p class="flex items-center justify-center mb-2">
                    <i class="fas fa-tint text-blue-500 mr-2"></i>
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

            // Dark Mode já é gerenciado pelo dark_mode.js global
        });

        // Confirmação de logout com SweetAlert
        function confirmarLogout(event) {
            event.preventDefault();
            EcoAlert.confirm(
                'Deseja sair?',
                'Você será desconectado da sua conta',
                'Sim, sair',
                'Cancelar'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/sair';
                }
            });
        }
    </script>
</body>
</html>