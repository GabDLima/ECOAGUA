<?php include __DIR__ . '/../includes/mensagens.php'; ?>

<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100 px-3">
    <div class="card set-password-card shadow-lg animate-fade-in">
      <div class="card-body p-5">
        <div class="text-center mb-4">
          <div class="eco-card-icon bg-purple-100 mx-auto mb-3" style="width: 4rem; height: 4rem; display: inline-flex; align-items: center; justify-content: center;">
            <i class="fas fa-lock text-purple-600" style="font-size: 2rem;"></i>
          </div>
          <h2 class="card-title mb-2" style="font-size: 2rem; font-weight: 700;">Redefinir Senha</h2>
          <p class="text-gray-600">Crie uma nova senha segura para sua conta</p>
        </div>

        <form action="/alterasenha" method="POST" id="redefinirSenhaForm">
          <div class="mb-4">
            <label for="novaSenha" class="eco-label">
              <i class="fas fa-key mr-2"></i>Nova senha
            </label>
            <input name="USER_SENHA" type="password" class="eco-input form-control" id="novaSenha" placeholder="••••••••" required minlength="6" />
            <p class="eco-help-text">Mínimo 6 caracteres</p>
          </div>
          <div class="mb-4">
            <label for="confirmarSenha" class="eco-label">
              <i class="fas fa-check-circle mr-2"></i>Confirmar senha
            </label>
            <input name="USER_SENHA_2" type="password" class="eco-input form-control" id="confirmarSenha" placeholder="••••••••" required />
            <p class="eco-help-text">Digite a mesma senha para confirmar</p>
          </div>

          <div class="p-3 mb-4 bg-blue-50 border-l-4 border-blue-500 rounded">
            <div class="flex items-center">
              <i class="fas fa-info-circle text-blue-600 mr-2"></i>
              <p class="text-sm text-blue-800 mb-0">
                <strong>Dica:</strong> Use uma senha forte com letras, números e símbolos
              </p>
            </div>
          </div>

          <button type="submit" class="btn-eco btn-eco-success w-100 mb-3" style="padding: 0.75rem;">
            <i class="fas fa-save mr-2"></i>Salvar Nova Senha
          </button>
        </form>

        <div class="text-center pt-3 border-top">
          <p class="mb-0 text-gray-600">
            <i class="fas fa-arrow-left mr-2"></i>
            Lembrou a senha? <a href="/" class="text-decoration-none">Fazer login</a>
          </p>
        </div>
      </div>
    </div>
  </div>

</body>
</html>