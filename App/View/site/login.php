<style>
  /* ── Painel esquerdo ── */
  .split-bg {
    background: linear-gradient(160deg, #1e3a8a 0%, #2563eb 55%, #3b82f6 100%);
  }
  .bubble {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    animation: bubbleRise linear infinite;
  }
  @keyframes bubbleRise {
    0%   { transform: translateY(110vh) scale(0.5); opacity: 0; }
    8%   { opacity: 1; }
    92%  { opacity: 0.6; }
    100% { transform: translateY(-10vh) scale(1.1); opacity: 0; }
  }
  @keyframes dropFloat {
    0%, 100% { transform: translateY(0) rotate(-3deg); }
    50%       { transform: translateY(-18px) rotate(3deg); }
  }
  .drop-float { animation: dropFloat 4s ease-in-out infinite; }

  /* ── Sistema de painéis ── */
  .auth-panel {
    display: none;
    animation: panelIn 0.28s cubic-bezier(0.4,0,0.2,1);
  }
  .auth-panel.active { display: block; }
  @keyframes panelIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── Separador ── */
  .eco-divider {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #9ca3af;
    font-size: 0.8rem;
    margin: 1.25rem 0;
  }
  .eco-divider::before,
  .eco-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
  }

  /* ── Stats do painel esquerdo ── */
  .stat-pill {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 999px;
    padding: 0.5rem 1.25rem;
    backdrop-filter: blur(4px);
  }
</style>

<?php include_once 'App/View/includes/mensagens.php'; ?>

<div class="flex min-h-screen">

  <!-- ══ PAINEL ESQUERDO ══ -->
  <div class="hidden lg:flex lg:w-1/2 split-bg relative overflow-hidden items-center justify-center">

    <!-- Bolhas de fundo -->
    <div class="bubble w-20 h-20" style="left:8%;  animation-duration:11s; animation-delay:0s;"></div>
    <div class="bubble w-32 h-32" style="left:25%; animation-duration:14s; animation-delay:3s;"></div>
    <div class="bubble w-14 h-14" style="left:55%; animation-duration:9s;  animation-delay:1.5s;"></div>
    <div class="bubble w-24 h-24" style="left:72%; animation-duration:13s; animation-delay:5s;"></div>
    <div class="bubble w-10 h-10" style="left:42%; animation-duration:8s;  animation-delay:2s;"></div>
    <div class="bubble w-16 h-16" style="left:88%; animation-duration:12s; animation-delay:4s;"></div>

    <!-- Conteúdo central — totalmente centralizado -->
    <div class="relative z-10 flex flex-col items-center justify-center text-center text-white px-10 w-full">

      <!-- Ícone principal animado -->
      <div class="drop-float mb-6" style="filter: drop-shadow(0 8px 24px rgba(0,0,0,0.3));">
        <i class="fas fa-tint" style="font-size: 5.5rem; opacity: 0.95;"></i>
      </div>

      <h1 class="font-bold tracking-widest uppercase" style="font-size: 2.8rem; letter-spacing: 0.15em; text-shadow: 0 2px 12px rgba(0,0,0,0.25);">
        ECOÁGUA
      </h1>

      <p class="mt-3 text-lg opacity-85 font-light">
        Monitore · Economize · Preserve
      </p>

      <!-- Linha divisória decorativa -->
      <div class="my-8 flex items-center gap-3 w-full max-w-xs">
        <div style="flex:1; height:1px; background:rgba(255,255,255,0.25);"></div>
        <i class="fas fa-leaf text-sm opacity-60"></i>
        <div style="flex:1; height:1px; background:rgba(255,255,255,0.25);"></div>
      </div>

      <!-- Estatísticas em pílulas -->
      <div class="flex flex-wrap justify-center gap-3">
        <div class="stat-pill text-white">
          <span class="font-bold text-lg">37%</span>
          <span class="text-xs opacity-80 ml-1">água desperdiçada</span>
        </div>
        <div class="stat-pill text-white">
          <span class="font-bold text-lg">200 L</span>
          <span class="text-xs opacity-80 ml-1">por pessoa/dia</span>
        </div>
      </div>

      <!-- Features -->
      <div class="mt-10 grid grid-cols-3 gap-4 w-full max-w-sm">
        <div class="flex flex-col items-center gap-2 opacity-80">
          <div style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-chart-line text-sm"></i>
          </div>
          <span class="text-xs">Monitore</span>
        </div>
        <div class="flex flex-col items-center gap-2 opacity-80">
          <div style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-bullseye text-sm"></i>
          </div>
          <span class="text-xs">Metas</span>
        </div>
        <div class="flex flex-col items-center gap-2 opacity-80">
          <div style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-file-invoice-dollar text-sm"></i>
          </div>
          <span class="text-xs">Faturas</span>
        </div>
      </div>
    </div>
  </div>

  <!-- ══ PAINEL DIREITO ══ -->
  <div class="w-full lg:w-1/2 flex items-center justify-center min-h-screen p-6"
       style="background: linear-gradient(160deg, #f9fafb 0%, #eff6ff 100%);">
    <div class="w-full" style="max-width: 400px;">

      <!-- Logo mobile -->
      <div class="lg:hidden text-center mb-8">
        <i class="fas fa-tint text-blue-700 mb-2" style="font-size:2.5rem;"></i>
        <h1 class="text-3xl font-bold text-blue-900 tracking-widest uppercase">ECOÁGUA</h1>
      </div>

      <!-- ── PAINEL: LOGIN (padrão) ── -->
      <div class="auth-panel active" id="painelLogin">
        <div class="eco-card" style="padding: 2rem;">

          <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-blue-900">Bem-vindo de volta!</h2>
            <p class="text-gray-400 text-sm mt-1">Acesse sua conta para continuar</p>
          </div>

          <form action="/login" method="POST">
            <div class="mb-4">
              <label class="eco-label">
                <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
              </label>
              <input type="email" name="EMAIL" class="eco-input"
                     placeholder="seu@email.com" required autocomplete="email">
            </div>
            <div class="mb-2">
              <label class="eco-label">
                <i class="fas fa-lock mr-2 text-blue-500"></i>Senha
              </label>
              <input type="password" name="SENHA" class="eco-input"
                     placeholder="••••••••" required autocomplete="current-password">
            </div>

            <div class="text-right mb-5">
              <button type="button" onclick="trocarPainel('painelLogin','painelRecuperar')"
                      class="text-xs text-blue-500 hover:text-blue-700 bg-transparent border-none cursor-pointer transition-colors">
                <i class="fas fa-key mr-1"></i>Esqueci minha senha
              </button>
            </div>

            <button type="submit" class="btn-eco btn-eco-primary w-full" style="padding:0.85rem;">
              <i class="fas fa-sign-in-alt mr-2"></i>Entrar na conta
            </button>
          </form>

          <div class="eco-divider">ou</div>

          <button type="button" onclick="trocarPainel('painelLogin','painelCadastro')"
                  class="btn-eco btn-eco-secondary w-full">
            <i class="fas fa-user-plus"></i>Criar conta gratuita
          </button>
        </div>

        <p class="text-center text-xs text-gray-400 mt-5">
          EcoÁgua © <?= date('Y') ?> · IFSP São João da Boa Vista
        </p>
      </div>

      <!-- ── PAINEL: CADASTRO ── -->
      <div class="auth-panel" id="painelCadastro">
        <div class="eco-card" style="padding: 2rem;">

          <!-- Header do painel -->
          <div class="flex items-center gap-3 mb-6 pb-4" style="border-bottom:1px solid #e5e7eb;">
            <button type="button" onclick="trocarPainel('painelCadastro','painelLogin')"
                    class="w-9 h-9 rounded-full flex items-center justify-center transition-colors hover:bg-gray-100 border-none bg-transparent cursor-pointer"
                    title="Voltar ao login">
              <i class="fas fa-arrow-left text-gray-500"></i>
            </button>
            <div>
              <h2 class="text-xl font-bold text-blue-900">Criar Nova Conta</h2>
              <p class="text-gray-400 text-xs mt-0.5">Preencha os dados abaixo</p>
            </div>
            <div class="ml-auto">
              <div class="eco-card-icon bg-blue-100" style="width:2.5rem;height:2.5rem;font-size:1rem;margin-bottom:0;">
                <i class="fas fa-user-plus text-blue-600"></i>
              </div>
            </div>
          </div>

          <form action="/inserirusuario" method="POST">
            <div class="mb-3">
              <label class="eco-label"><i class="fas fa-id-card mr-2 text-blue-500"></i>CPF</label>
              <input type="text" name="USER_CPF" class="eco-input"
                     placeholder="00000000000" required maxlength="11"
                     pattern="\d{11}" oninput="this.value=this.value.replace(/\D/g,'')">
              <p class="eco-help-text">Somente números, sem pontos ou traços</p>
            </div>
            <div class="mb-3">
              <label class="eco-label"><i class="fas fa-user mr-2 text-blue-500"></i>Nome Completo</label>
              <input type="text" name="USER_NOME" class="eco-input" placeholder="Seu nome completo" required>
            </div>
            <div class="mb-3">
              <label class="eco-label"><i class="fas fa-envelope mr-2 text-blue-500"></i>Email</label>
              <input type="email" name="USER_EMAIL" class="eco-input" placeholder="seu@email.com" required>
            </div>
            <div class="mb-3">
              <label class="eco-label"><i class="fas fa-lock mr-2 text-blue-500"></i>Senha</label>
              <input type="password" name="USER_SENHA" class="eco-input"
                     placeholder="Mínimo 6 caracteres" required minlength="6">
            </div>
            <div class="mb-5">
              <label class="eco-label"><i class="fas fa-check-circle mr-2 text-blue-500"></i>Confirmar Senha</label>
              <input type="password" name="USER_SENHA_2" class="eco-input"
                     placeholder="Repita a senha" required minlength="6">
            </div>
            <button type="submit" class="btn-eco btn-eco-success w-full" style="padding:0.85rem;">
              <i class="fas fa-user-plus mr-2"></i>Criar conta
            </button>
          </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-5">
          EcoÁgua © <?= date('Y') ?> · IFSP São João da Boa Vista
        </p>
      </div>

      <!-- ── PAINEL: RECUPERAR SENHA ── -->
      <div class="auth-panel" id="painelRecuperar">
        <div class="eco-card" style="padding: 2rem;">

          <!-- Header do painel -->
          <div class="flex items-center gap-3 mb-6 pb-4" style="border-bottom:1px solid #e5e7eb;">
            <button type="button" onclick="trocarPainel('painelRecuperar','painelLogin')"
                    class="w-9 h-9 rounded-full flex items-center justify-center transition-colors hover:bg-gray-100 border-none bg-transparent cursor-pointer"
                    title="Voltar ao login">
              <i class="fas fa-arrow-left text-gray-500"></i>
            </button>
            <div>
              <h2 class="text-xl font-bold text-blue-900">Recuperar Senha</h2>
              <p class="text-gray-400 text-xs mt-0.5">Informe seu email cadastrado</p>
            </div>
            <div class="ml-auto">
              <div class="eco-card-icon bg-amber-100" style="width:2.5rem;height:2.5rem;font-size:1rem;margin-bottom:0;">
                <i class="fas fa-key text-amber-600"></i>
              </div>
            </div>
          </div>

          <div class="mb-5 p-4 rounded-xl" style="background:#eff6ff; border-left:3px solid #3b82f6;">
            <p class="text-sm text-blue-700">
              <i class="fas fa-info-circle mr-2"></i>
              Entre em contato com o administrador do sistema para redefinir sua senha. A recuperação automática está em desenvolvimento.
            </p>
          </div>

          <div class="mb-5">
            <label class="eco-label"><i class="fas fa-envelope mr-2 text-blue-500"></i>Email cadastrado</label>
            <input type="email" class="eco-input" placeholder="seu@email.com">
          </div>

          <button type="button" onclick="trocarPainel('painelRecuperar','painelLogin')"
                  class="btn-eco w-full" style="background:#f3f4f6; color:#6b7280; padding:0.85rem;">
            <i class="fas fa-arrow-left mr-2"></i>Voltar ao login
          </button>
        </div>
      </div>

    </div><!-- /max-width -->
  </div><!-- /painel direito -->
</div><!-- /flex min-h-screen -->

<script>
  function trocarPainel(origem, destino) {
    document.getElementById(origem).classList.remove('active');
    // Pequeno delay para a animação de entrada funcionar corretamente
    setTimeout(function() {
      document.getElementById(destino).classList.add('active');
    }, 20);
  }
</script>
