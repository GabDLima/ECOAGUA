<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      overflow: hidden;
      background: radial-gradient(circle, #1e3c72, #2a5298);
      height: 100vh;
      position: relative;
    }

    @keyframes rise {
      0% { bottom: -10px; opacity: 0; }
      50% { opacity: 1; }
      100% { bottom: 110vh; opacity: 0; }
    }

    @keyframes wave {
      0% { transform: translateX(0); }
      25% { transform: translateX(-15px); }
      50% { transform: translateX(15px); }
      75% { transform: translateX(-15px); }
      100% { transform: translateX(0); }
    }

    .bubble {
      position: absolute;
      background-color: rgba(255, 255, 255, 0.6);
      border-radius: 50%;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
      animation: rise linear infinite, wave ease-in-out infinite;
      z-index: 0;
    }

    .login-card,
    .cadastro-card,
    .reset-card,
    .set-password-card {
      width: 100%;
      max-width: 420px;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 1rem;
      backdrop-filter: blur(8px);
      z-index: 1;
    }

    .login-card .card-title,
    .cadastro-card .card-title,
    .reset-card .card-title,
    .set-password-card .card-title {
      font-weight: 600;
      color: #1e3c72;
    }

    .login-card .btn-primary,
    .cadastro-card .btn-primary,
    .reset-card .btn-primary,
    .set-password-card .btn-primary {
      background-color: #1e3c72;
      border-color: #1e3c72;
    }

    .login-card .btn-primary:hover,
    .cadastro-card .btn-primary:hover,
    .reset-card .btn-primary:hover,
    .set-password-card .btn-primary:hover {
      background-color: #163558;
      border-color: #163558;
    }

    .login-card a,
    .cadastro-card a,
    .reset-card a,
    .set-password-card a {
      color: #1e3c72;
    }

    .login-card a:hover,
    .cadastro-card a:hover,
    .reset-card a:hover,
    .set-password-card a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100 px-3">
    <div class="card login-card shadow-lg">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Faça seu login</h2>
        <form id="loginForm" novalidate>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" required />
          </div>
          <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" required minlength="6" />
          </div>
          <div class="mb-3 text-end">
            <a href="#" data-bs-toggle="modal" data-bs-target="#modalEsqueciSenha">Esqueci minha senha</a>
          </div>
          <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <p class="mt-3 text-center">
          Não tem conta?
          <a href="#" data-bs-toggle="modal" data-bs-target="#modalCadastro">Cadastre-se</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Modal de Cadastro -->
  <div class="modal fade" id="modalCadastro" tabindex="-1" aria-labelledby="modalCadastroLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content cadastro-card">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCadastroLabel">Crie sua conta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="cadastroForm" novalidate>
            <div class="mb-3">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" class="form-control" id="cpf" maxlength="11" />
            </div>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome completo</label>
              <input type="text" class="form-control" id="nome" required />
            </div>
            <div class="mb-3">
              <label for="cadastroEmail" class="form-label">E-mail</label>
              <input type="email" class="form-control" id="cadastroEmail" required />
            </div>
            <div class="mb-3">
              <label for="cadastroSenha" class="form-label">Senha</label>
              <input type="password" class="form-control" id="cadastroSenha" required minlength="6" />
            </div>
            <div class="mb-3">
              <label for="confirmarSenha" class="form-label">Confirme a senha</label>
              <input type="password" class="form-control" id="confirmarSenha" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Esqueci Minha Senha -->
  <div class="modal fade" id="modalEsqueciSenha" tabindex="-1" aria-labelledby="modalEsqueciSenhaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content reset-card">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEsqueciSenhaLabel">Redefinir Senha</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="resetForm" novalidate>
            <div class="mb-3">
              <label for="resetEmail" class="form-label">E-mail cadastrado</label>
              <input type="email" class="form-control" id="resetEmail" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // fundo.js - bolhas animadas
    function createBubble() {
      const bubble = document.createElement("div");
      bubble.className = "bubble";

      const size = 5 + Math.random() * 20;
      bubble.style.width = bubble.style.height = `${size}px`;
      bubble.style.left = `${Math.random() * window.innerWidth}px`;
      bubble.style.bottom = "-10px";
      bubble.style.animationDuration = `${4 + Math.random() * 6}s`;
      bubble.style.opacity = `${Math.random() * 0.5 + 0.5}`;
      bubble.style.position = "absolute";

      document.body.appendChild(bubble);
      setTimeout(() => bubble.remove(), 10000);
    }
    setInterval(createBubble, 200);

    // login.js (validação simples)
    document.getElementById("loginForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const email = document.getElementById("email").value;
      const senha = document.getElementById("senha").value;
      if (email && senha.length >= 6) {
        alert("Login enviado!");
        // Aqui você pode chamar sua função de autenticação
      } else {
        alert("Preencha os campos corretamente!");
      }
    });

    // cadastro.js (validação simples)
    document.getElementById("cadastroForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const senha = document.getElementById("cadastroSenha").value;
      const confirmar = document.getElementById("confirmarSenha").value;

      if (senha !== confirmar) {
        alert("As senhas não coincidem!");
        return;
      }

      alert("Cadastro enviado!");
      // Aqui você pode chamar sua função de cadastro
    });

    // formularioSenha.js
    document.getElementById("resetForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const email = document.getElementById("resetEmail").value;
      if (email) {
        alert("E-mail para redefinição enviado!");
      } else {
        alert("Informe seu e-mail.");
      }
    });
  </script>
</body>
</html>
