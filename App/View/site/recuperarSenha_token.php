<div class="min-h-screen flex items-center justify-center py-12 px-4" style="background: linear-gradient(135deg, #f3f4f6 0%, #eff6ff 100%);">
  <div class="w-full" style="max-width: 440px;">
    <div class="eco-card animate-fade-in" style="padding: 2.5rem;">

      <div class="text-center mb-8">
        <div class="eco-card-icon bg-amber-100 text-amber-600 mx-auto mb-4">
          <i class="fas fa-key fa-lg"></i>
        </div>
        <h1 class="text-2xl font-bold text-blue-900">Recuperar Senha</h1>
      </div>

      <?php if (!$this->view->token): ?>

        <div class="mb-6 p-4 rounded-xl" style="background:#fef2f2; border-left:3px solid #ef4444;">
          <p class="text-sm text-red-700">
            <i class="fas fa-exclamation-circle mr-2"></i>
            Link de recuperação inválido ou não fornecido.
          </p>
        </div>
        <a href="/" class="btn-eco btn-eco-primary w-full">
          <i class="fas fa-arrow-left mr-2"></i>Voltar ao login
        </a>

      <?php elseif (!$this->view->tokenValido): ?>

        <div class="mb-6 p-4 rounded-xl" style="background:#fef2f2; border-left:3px solid #ef4444;">
          <p class="text-sm text-red-700">
            <i class="fas fa-times-circle mr-2"></i>
            Link inválido ou expirado. Solicite um novo link de recuperação.
          </p>
        </div>
        <a href="/" class="btn-eco btn-eco-primary w-full">
          <i class="fas fa-arrow-left mr-2"></i>Solicitar novo link
        </a>

      <?php else: ?>

        <?php if ($this->view->erroRecuperacao): ?>
          <div class="mb-4 p-4 rounded-xl" style="background:#fef2f2; border-left:3px solid #ef4444;">
            <p class="text-sm text-red-700">
              <i class="fas fa-exclamation-circle mr-2"></i>
              <?= htmlspecialchars($this->view->erroRecuperacao) ?>
            </p>
          </div>
        <?php endif; ?>

        <p class="text-sm text-gray-500 mb-6 text-center">
          <i class="fas fa-user mr-1 text-blue-400"></i>
          Redefinindo senha para: <strong class="text-blue-700"><?= htmlspecialchars($this->view->tokenDados['email']) ?></strong>
        </p>

        <form action="/confirmarrecuperacao" method="POST">
          <input type="hidden" name="token" value="<?= htmlspecialchars($this->view->token) ?>">

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

          <button type="submit" class="btn-eco btn-eco-success w-full" style="padding:0.85rem;">
            <i class="fas fa-check mr-2"></i>Redefinir Senha
          </button>
        </form>

      <?php endif; ?>

      <div class="text-center mt-5">
        <a href="/" class="text-sm text-blue-500 hover:text-blue-700">
          <i class="fas fa-arrow-left mr-1"></i>Voltar ao login
        </a>
      </div>

    </div>
  </div>
</div>
