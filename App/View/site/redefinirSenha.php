
<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100 px-3">
    <div class="card set-password-card shadow-lg">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Redefinir Senha</h2>
        <form id="redefinirSenhaForm" novalidate>
          <div class="mb-3">
            <label for="novaSenha" class="form-label">Nova senha</label>
            <input type="password" class="form-control" id="novaSenha" required minlength="6" />
          </div>
          <div class="mb-3">
            <label for="confirmarSenha" class="form-label">Confirmar senha</label>
            <input type="password" class="form-control" id="confirmarSenha" required />
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
  </script>
</body>
</html>
