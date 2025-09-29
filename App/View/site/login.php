<?php
$mensagem = "Operação concluída com sucesso!";
?>

<body>
<?php
session_start();
//echo $_SESSION['mensagem_login_incorreto'];
//exit;
if(isset($_SESSION['mensagem_login_incorreto'])){
  if($_SESSION['mensagem_login_incorreto'] == 1){
    mostrarPopup("E-mail ou senha incorretos!");
    $_SESSION['mensagem_login_incorreto'] = 0;
  }
}
else{
  //mostrarPopup("Login realizado com sucesso!");
}
if(isset($_SESSION['usuario_desconectado'])){
  if($_SESSION['usuario_desconectado'] == 1){
    mostrarPopup("Usuário desconectado!");
    $_SESSION['usuario_desconectado'] = 0;
  }
}
else{
  //mostrarPopup("Login realizado com sucesso!");
}

?>
  <div class="d-flex justify-content-center align-items-center min-vh-100 px-3">
    <div class="card login-card shadow-lg">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Faça seu login</h2>
        <form action="/login" method="POST" id="loginForm">
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input name="EMAIL" type="email" class="form-control" id="email" required />
          </div>
          <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input name="SENHA" type="password" class="form-control" id="senha" required minlength="6" />
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
  <div class="modal modal-centered fade" id="modalCadastro" tabindex="-1" aria-labelledby="modalCadastroLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered d-flex justify-content-center ">
    <div class="modal-content cadastro-card">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCadastroLabel">Crie sua conta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="cadastroForm" action="/inserirusuario" method="POST">
          <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input name="USER_CPF" type="text" pattern="\d{11}" maxlength="11" minlength="11" oninput="this.value=this.value.replace(/\D/g,'')" class="form-control" id="cpf" />
          </div>
          <div class="mb-3">
            <label for="nome" class="form-label">Nome completo</label>
            <input name="USER_NOME" type="text" class="form-control" id="nome" required />
          </div>
          <div class="mb-3">
            <label for="cadastroEmail" class="form-label">E-mail</label>
            <input name="USER_EMAIL" type="email" class="form-control" id="cadastroEmail" required />
          </div>
          <div class="mb-3">
            <label for="cadastroSenha" class="form-label">Senha</label>
            <input name="USER_SENHA" type="password" class="form-control" id="cadastroSenha" required minlength="6" />
          </div>
          <div class="mb-3">
            <label for="confirmarSenha" class="form-label">Confirme a senha</label>
            <input name="USER_SENHA_2" type="password" class="form-control" id="confirmarSenha" required />
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
  <!--<script>
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
  </script>-->

</body>

<?php
function mostrarPopup($mensagem, $tipo = "sucesso") {
    // Escapa o conteúdo para evitar problemas de segurança
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');
    $tipo = ($tipo === "erro") ? "erro" : "sucesso";

    echo <<<HTML
    <div id="popupMensagem" class="popup $tipo">
        <div class="popup-conteudo">
            <span id="fecharPopup" class="fechar">&times;</span>
            <p>$mensagem</p>
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
?>