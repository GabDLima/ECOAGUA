<?php
session_start();
if(isset($_SESSION['senha_nao_confere'])){
  if($_SESSION['senha_nao_confere'] == 1){
    mostrarPopup("As senhas não conferem!");
    $_SESSION['senha_nao_confere'] = 0;
  }
}

?>

<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100 px-3">
    <div class="card set-password-card shadow-lg">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Redefinir Senha</h2>
        <form action="/alterasenha" method="POST" id="redefinirSenhaForm">
          <div class="mb-3">
            <label for="novaSenha" class="form-label">Nova senha</label>
            <input name="USER_SENHA" type="password" class="form-control" id="novaSenha" required minlength="6" />
          </div>
          <div class="mb-3">
            <label for="confirmarSenha" class="form-label">Confirmar senha</label>
            <input name="USER_SENHA_2" type="password" class="form-control" id="confirmarSenha" required />
          </div>
          <button type="submit" class="btn btn-primary w-100">Salvar nova senha</button>
        </form>
        <p class="mt-3 text-center">
          Lembrou a senha? <a href="/">Fazer login</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>-->

  <!--
  <script>
    // Bolhas animadas
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

    // Validação simples do formulário de redefinição
    document.getElementById("redefinirSenhaForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const novaSenha = document.getElementById("novaSenha").value;
      const confirmarSenha = document.getElementById("confirmarSenha").value;

      if (novaSenha.length < 6) {
        alert("A nova senha deve ter pelo menos 6 caracteres.");
        return;
      }

      if (novaSenha !== confirmarSenha) {
        alert("As senhas não coincidem.");
        return;
      }

      alert("Senha redefinida com sucesso!");
      // Aqui você pode chamar sua função de redefinição de senha no backend
    });
  </script>-->
</body>
</html>


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