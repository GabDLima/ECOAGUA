<div class="min-h-screen flex items-center justify-center py-12 px-4" style="background: linear-gradient(135deg, #f3f4f6 0%, #eff6ff 100%);">
    <div class="w-full" style="max-width: 440px;">

        <div class="eco-card animate-fade-in" style="padding: 2.5rem;">

            <div class="text-center mb-8">
                <div class="eco-card-icon bg-blue-100 text-blue-600 mx-auto mb-4">
                    <i class="fas fa-lock fa-lg"></i>
                </div>
                <h1 class="text-2xl font-bold text-blue-900">Redefinir Senha</h1>
                <p class="text-gray-500 mt-2 text-sm">Digite sua nova senha abaixo</p>
            </div>

            <?php include_once 'App/View/includes/mensagens.php'; ?>

            <form action="/alterasenha" method="POST">
                <div class="mb-4">
                    <label class="eco-label">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>Nova Senha
                    </label>
                    <input type="password" name="nova_senha" class="eco-input"
                           placeholder="Mínimo 6 caracteres" required minlength="6">
                </div>

                <div class="mb-6">
                    <label class="eco-label">
                        <i class="fas fa-check-circle mr-2 text-blue-600"></i>Confirmar Nova Senha
                    </label>
                    <input type="password" name="confirmar_senha" class="eco-input"
                           placeholder="Repita a nova senha" required minlength="6">
                </div>

                <div class="mb-6 p-3 rounded-lg" style="background: #eff6ff; border-left: 4px solid #3b82f6;">
                    <p class="text-sm" style="color: #1e40af;">
                        <i class="fas fa-info-circle mr-2"></i>
                        Use pelo menos 6 caracteres combinando letras e números.
                    </p>
                </div>

                <button type="submit" class="btn-eco btn-eco-success w-full">
                    <i class="fas fa-check mr-2"></i>Salvar Nova Senha
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="/" class="text-sm" style="color: #3b82f6; text-decoration: none;">
                    <i class="fas fa-arrow-left me-1"></i>Voltar ao login
                </a>
            </div>

        </div>
    </div>
</div>
