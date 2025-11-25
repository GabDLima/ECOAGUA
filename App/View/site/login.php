<?php include __DIR__ . '/../includes/mensagens.php'; ?>

<style>
  @keyframes float {
    0%, 100% { transform: translateY(0) translateX(0); }
    25% { transform: translateY(-20px) translateX(10px); }
    50% { transform: translateY(-10px) translateX(-10px); }
    75% { transform: translateY(-30px) translateX(5px); }
  }

  @keyframes rise {
    0% { bottom: -100px; opacity: 0; }
    10% { opacity: 0.8; }
    90% { opacity: 0.8; }
    100% { bottom: 100vh; opacity: 0; }
  }

  .bubble {
    position: absolute;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(147, 197, 253, 0.5));
    border-radius: 50%;
    animation: rise linear infinite;
    box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2);
  }

  .droplet {
    position: absolute;
    animation: float ease-in-out infinite;
  }

  .split-bg {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  }
</style>

<body class="overflow-hidden">
  <div class="d-flex min-vh-100">

    <!-- Left Side - Animated Background -->
    <div class="d-none d-lg-flex col-lg-6 split-bg position-relative align-items-center justify-content-center overflow-hidden">
      <!-- Bubbles Animation -->
      <div class="w-100 h-100 position-absolute">
        <div class="bubble" style="width: 80px; height: 80px; left: 10%; animation-duration: 15s; animation-delay: 0s;"></div>
        <div class="bubble" style="width: 60px; height: 60px; left: 20%; animation-duration: 12s; animation-delay: 2s;"></div>
        <div class="bubble" style="width: 100px; height: 100px; left: 50%; animation-duration: 18s; animation-delay: 1s;"></div>
        <div class="bubble" style="width: 70px; height: 70px; left: 70%; animation-duration: 14s; animation-delay: 3s;"></div>
        <div class="bubble" style="width: 90px; height: 90px; left: 85%; animation-duration: 16s; animation-delay: 4s;"></div>
        <div class="bubble" style="width: 50px; height: 50px; left: 35%; animation-duration: 10s; animation-delay: 5s;"></div>
      </div>

      <!-- Floating Droplets -->
      <div class="droplet" style="left: 15%; top: 20%; animation-duration: 6s;">
        <i class="fas fa-tint text-white" style="font-size: 3rem; opacity: 0.3;"></i>
      </div>
      <div class="droplet" style="left: 75%; top: 30%; animation-duration: 8s; animation-delay: 1s;">
        <i class="fas fa-tint text-white" style="font-size: 2.5rem; opacity: 0.4;"></i>
      </div>
      <div class="droplet" style="left: 45%; top: 60%; animation-duration: 7s; animation-delay: 2s;">
        <i class="fas fa-tint text-white" style="font-size: 2rem; opacity: 0.3;"></i>
      </div>

      <!-- Logo and Text -->
      <div class="text-center position-relative z-1">
        <div class="mb-4">
          <i class="fas fa-tint text-white" style="font-size: 5rem; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));"></i>
        </div>
        <h1 class="text-white fw-bold mb-3" style="font-size: 3rem; text-shadow: 2px 2px 10px rgba(0,0,0,0.3);">ECOÁGUA</h1>
        <p class="text-white fs-5" style="text-shadow: 1px 1px 5px rgba(0,0,0,0.2);">Economize água, preserve o futuro</p>
        <div class="mt-4">
          <div class="d-flex justify-content-center gap-4 text-white" style="font-size: 0.9rem;">
            <span><i class="fas fa-chart-line me-2"></i>Monitore</span>
            <span><i class="fas fa-bullseye me-2"></i>Economize</span>
            <span><i class="fas fa-leaf me-2"></i>Sustentável</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center p-4 bg-light">
      <div class="w-100" style="max-width: 480px;">
        <div class="card border-0 shadow-lg">
          <div class="card-body p-5">

            <!-- Mobile Logo (only visible on small screens) -->
            <div class="text-center mb-4 d-lg-none">
              <i class="fas fa-tint text-blue-600" style="font-size: 3rem;"></i>
              <h2 class="fw-bold text-blue-900 mt-2">ECOÁGUA</h2>
            </div>

            <div class="text-center mb-4">
              <h2 class="fw-bold mb-2" style="font-size: 1.75rem; color: #1e3a8a;">Bem-vindo de volta!</h2>
              <p class="text-muted">Entre com suas credenciais para continuar</p>
            </div>

            <form action="/login" method="POST" id="loginForm">
              <div class="mb-3">
                <label for="email" class="eco-label">
                  <i class="fas fa-envelope mr-2"></i>E-mail
                </label>
                <input name="EMAIL" type="email" class="eco-input form-control" id="email" placeholder="seu@email.com" required />
              </div>
              <div class="mb-3">
                <label for="senha" class="eco-label">
                  <i class="fas fa-lock mr-2"></i>Senha
                </label>
                <input name="SENHA" type="password" class="eco-input form-control" id="senha" placeholder="••••••••" required minlength="6" />
              </div>
              <div class="mb-3 text-end">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalEsqueciSenha" class="text-decoration-none small">
                  <i class="fas fa-question-circle me-1"></i>Esqueci minha senha
                </a>
              </div>
              <button type="submit" class="btn-eco btn-eco-primary w-100 mb-3" style="padding: 0.75rem;">
                <i class="fas fa-sign-in-alt me-2"></i>Entrar
              </button>
            </form>

            <div class="text-center pt-3 border-top mt-3">
              <p class="mb-3 text-muted small">Não tem uma conta?</p>
              <button data-bs-toggle="modal" data-bs-target="#modalCadastro" class="btn btn-outline-primary w-100">
                <i class="fas fa-user-plus me-2"></i>Criar conta gratuita
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Cadastro -->
  <div class="modal modal-centered fade" id="modalCadastro" tabindex="-1" aria-labelledby="modalCadastroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content cadastro-card">
        <div class="modal-header border-bottom-0 pb-0">
          <div class="w-100">
            <div class="text-center mb-3">
              <div class="eco-card-icon bg-green-100 mx-auto" style="width: 3.5rem; height: 3.5rem; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-user-plus text-green-600" style="font-size: 1.75rem;"></i>
              </div>
            </div>
            <h5 class="modal-title text-center w-100" id="modalCadastroLabel" style="font-size: 1.5rem; font-weight: 700;">Crie sua conta</h5>
            <p class="text-center text-gray-600 mt-2">Junte-se ao ECOÁGUA e economize água!</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body pt-3">
          <form id="cadastroForm" action="/inserirusuario" method="POST">
            <div class="mb-3">
              <label for="cpf" class="eco-label">
                <i class="fas fa-id-card mr-2"></i>CPF
              </label>
              <input name="USER_CPF" type="text" pattern="\d{11}" maxlength="11" minlength="11" oninput="this.value=this.value.replace(/\D/g,'')" class="eco-input form-control" id="cpf" placeholder="00000000000" required />
              <p class="eco-help-text">Apenas números, sem pontos ou traços</p>
            </div>
            <div class="mb-3">
              <label for="nome" class="eco-label">
                <i class="fas fa-user mr-2"></i>Nome completo
              </label>
              <input name="USER_NOME" type="text" class="eco-input form-control" id="nome" placeholder="Seu nome completo" required />
            </div>
            <div class="mb-3">
              <label for="cadastroEmail" class="eco-label">
                <i class="fas fa-envelope mr-2"></i>E-mail
              </label>
              <input name="USER_EMAIL" type="email" class="eco-input form-control" id="cadastroEmail" placeholder="seu@email.com" required />
            </div>
            <div class="mb-3">
              <label for="cadastroSenha" class="eco-label">
                <i class="fas fa-lock mr-2"></i>Senha
              </label>
              <input name="USER_SENHA" type="password" class="eco-input form-control" id="cadastroSenha" placeholder="••••••••" required minlength="6" />
              <p class="eco-help-text">Mínimo 6 caracteres</p>
            </div>
            <div class="mb-4">
              <label for="confirmarSenha" class="eco-label">
                <i class="fas fa-lock mr-2"></i>Confirme a senha
              </label>
              <input name="USER_SENHA_2" type="password" class="eco-input form-control" id="confirmarSenha" placeholder="••••••••" required />
            </div>
            <button type="submit" class="btn-eco btn-eco-success w-100" style="padding: 0.75rem;">
              <i class="fas fa-check-circle mr-2"></i>Cadastrar
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Esqueci Minha Senha -->
  <div class="modal fade" id="modalEsqueciSenha" tabindex="-1" aria-labelledby="modalEsqueciSenhaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content reset-card">
        <div class="modal-header border-bottom-0 pb-0">
          <div class="w-100">
            <div class="text-center mb-3">
              <div class="eco-card-icon bg-orange-100 mx-auto" style="width: 3.5rem; height: 3.5rem; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-key text-orange-600" style="font-size: 1.75rem;"></i>
              </div>
            </div>
            <h5 class="modal-title text-center w-100" id="modalEsqueciSenhaLabel" style="font-size: 1.5rem; font-weight: 700;">Redefinir Senha</h5>
            <p class="text-center text-gray-600 mt-2">Enviaremos um link para recuperação</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body pt-3">
          <form id="resetForm" novalidate>
            <div class="mb-4">
              <label for="resetEmail" class="eco-label">
                <i class="fas fa-envelope mr-2"></i>E-mail cadastrado
              </label>
              <input type="email" class="eco-input form-control" id="resetEmail" placeholder="seu@email.com" required />
              <p class="eco-help-text">Digite o e-mail associado à sua conta</p>
            </div>
            <button type="submit" class="btn-eco btn-eco-primary w-100" style="padding: 0.75rem;">
              <i class="fas fa-paper-plane mr-2"></i>Enviar Link de Recuperação
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>