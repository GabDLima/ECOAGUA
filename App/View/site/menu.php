<?php
include __DIR__ . '/../includes/mensagens.php';
$cpf_exibir = isset($this->view->cpf_formatado) ? $this->view->cpf_formatado : '';
$nome       = isset($this->view->usuario['nome'])  ? $this->view->usuario['nome']  : '';
$email      = isset($this->view->usuario['email']) ? $this->view->usuario['email'] : '';
$inicial    = $nome ? strtoupper(mb_substr($nome, 0, 1, 'UTF-8')) : '?';
?>

<body class="bg-gray-50">
<div id="main-content" class="flex-1 pt-20 transition-[margin] duration-300">
  <main class="px-6 py-6" style="max-width: 960px; margin: 0 auto;">

    <!-- Cabeçalho -->
    <div class="mb-8">
      <h1 class="text-2xl font-bold text-blue-900">Meu Perfil</h1>
      <p class="text-gray-400 text-sm mt-1">Gerencie suas informações e preferências</p>
    </div>

    <!-- ── Banner do usuário ── -->
    <div class="eco-card mb-8 animate-fade-in overflow-hidden" style="padding:0;">
      <div class="h-24 w-full" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);"></div>
      <div class="px-6 pb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4" style="margin-top:-2.5rem;">
          <!-- Avatar -->
          <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-3xl font-bold flex-shrink-0"
               style="background: linear-gradient(135deg, #1e3a8a, #2563eb); border: 4px solid white; box-shadow: 0 4px 12px rgba(30,58,138,0.3);">
            <?= $inicial ?>
          </div>
          <div class="flex-1 pt-2">
            <h2 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($nome) ?></h2>
            <p class="text-gray-400 text-sm"><?= htmlspecialchars($email) ?></p>
            <?php if (isset($this->view->usuario['created_at'])): ?>
              <p class="text-xs text-gray-300 mt-1">
                <i class="fas fa-calendar-check mr-1 text-blue-400"></i>
                Membro desde <?= date('d/m/Y', strtotime($this->view->usuario['created_at'])) ?>
              </p>
            <?php endif; ?>
          </div>
          <a href="/dashboard" class="btn-eco btn-eco-primary" style="padding:0.5rem 1rem; font-size:0.85rem;">
            <i class="fas fa-home mr-2"></i>Dashboard
          </a>
        </div>
      </div>
    </div>

    <?php if (isset($this->view->mensagemErro) && $this->view->mensagemErro): ?>
      <div class="eco-card mb-6 animate-fade-in" style="border-left: 4px solid #ef4444; padding: 1rem 1.25rem;">
        <div class="flex items-center gap-3">
          <i class="fas fa-times-circle text-red-500 text-lg flex-shrink-0"></i>
          <p class="text-red-700 text-sm"><?= htmlspecialchars($this->view->mensagemErro) ?></p>
        </div>
      </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- ── Coluna principal (2/3) ── -->
      <div class="lg:col-span-2 space-y-6">

        <!-- Dados Pessoais -->
        <div class="eco-card animate-fade-in" style="animation-delay:0.05s;">
          <div class="flex items-center gap-3 mb-5 pb-4" style="border-bottom:1px solid #f3f4f6;">
            <div class="eco-card-icon bg-blue-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
              <i class="fas fa-user text-blue-600"></i>
            </div>
            <div>
              <h3 class="text-base font-bold text-blue-900">Dados Pessoais</h3>
              <p class="text-xs text-gray-400">Atualize seu nome e email</p>
            </div>
          </div>

          <form action="/editarusuario" method="POST" class="space-y-4">
            <div>
              <label class="eco-label"><i class="fas fa-user-circle mr-2 text-blue-400"></i>Nome Completo</label>
              <input name="USER_NOME" type="text" class="eco-input"
                     value="<?= htmlspecialchars($nome) ?>"
                     placeholder="Seu nome completo" required>
            </div>
            <div>
              <label class="eco-label"><i class="fas fa-id-card mr-2 text-blue-400"></i>CPF</label>
              <input type="text" class="eco-input" value="<?= htmlspecialchars($cpf_exibir) ?>"
                     style="background:#f9fafb; color:#9ca3af; cursor:not-allowed;" readonly>
              <p class="eco-help-text"><i class="fas fa-lock mr-1"></i>O CPF não pode ser alterado</p>
            </div>
            <div>
              <label class="eco-label"><i class="fas fa-envelope mr-2 text-blue-400"></i>Email</label>
              <input name="USER_EMAIL" type="email" class="eco-input"
                     value="<?= htmlspecialchars($email) ?>"
                     placeholder="seu@email.com" required>
            </div>
            <div class="pt-2">
              <button type="submit" class="btn-eco btn-eco-success">
                <i class="fas fa-save mr-2"></i>Salvar Alterações
              </button>
            </div>
          </form>
        </div>

        <!-- Notificações -->
        <div class="eco-card animate-fade-in" style="animation-delay:0.1s;">
          <div class="flex items-center gap-3 mb-5 pb-4" style="border-bottom:1px solid #f3f4f6;">
            <div class="eco-card-icon bg-amber-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
              <i class="fas fa-bell text-amber-500"></i>
            </div>
            <div>
              <h3 class="text-base font-bold text-blue-900">Notificações</h3>
              <p class="text-xs text-gray-400">Gerencie seus alertas</p>
            </div>
          </div>
          <div class="space-y-3">
            <label class="flex items-center justify-between p-4 rounded-xl cursor-pointer transition-colors hover:bg-gray-50"
                   style="border:1px solid #e5e7eb;">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#dbeafe;">
                  <i class="fas fa-envelope text-blue-600 text-sm"></i>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-700">Alerta de consumo alto</p>
                  <p class="text-xs text-gray-400">Receba e-mail quando ultrapassar a meta</p>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <span class="eco-badge eco-badge-success">Ativo</span>
                <input type="checkbox" checked class="w-4 h-4" style="accent-color:#1e3a8a;">
              </div>
            </label>
            <label class="flex items-center justify-between p-4 rounded-xl cursor-pointer transition-colors hover:bg-gray-50"
                   style="border:1px solid #e5e7eb;">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#ede9fe;">
                  <i class="fas fa-chart-bar text-purple-600 text-sm"></i>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-700">Resumo semanal</p>
                  <p class="text-xs text-gray-400">Relatório por e-mail toda segunda-feira</p>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <span class="eco-badge eco-badge-info">Em breve</span>
                <input type="checkbox" disabled class="w-4 h-4" style="accent-color:#1e3a8a;">
              </div>
            </label>
          </div>
        </div>

      </div><!-- /col principal -->

      <!-- ── Coluna lateral (1/3) ── -->
      <div class="space-y-6">

        <!-- Segurança -->
        <div class="eco-card animate-fade-in" style="animation-delay:0.15s;">
          <div class="flex items-center gap-3 mb-5 pb-4" style="border-bottom:1px solid #f3f4f6;">
            <div class="eco-card-icon bg-red-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
              <i class="fas fa-shield-alt text-red-500"></i>
            </div>
            <div>
              <h3 class="text-base font-bold text-blue-900">Segurança</h3>
              <p class="text-xs text-gray-400">Proteja sua conta</p>
            </div>
          </div>
          <div class="p-4 rounded-xl mb-4" style="background:#fff7ed; border-left:3px solid #f59e0b;">
            <p class="text-xs text-amber-700">
              <i class="fas fa-exclamation-circle mr-1"></i>
              Atualize sua senha periodicamente para maior segurança.
            </p>
          </div>
          <a href="/redefinirSenha" class="btn-eco btn-eco-primary w-full">
            <i class="fas fa-key mr-2"></i>Redefinir Senha
          </a>
        </div>

        <!-- Preferências -->
        <div class="eco-card animate-fade-in" style="animation-delay:0.2s;">
          <div class="flex items-center gap-3 mb-5 pb-4" style="border-bottom:1px solid #f3f4f6;">
            <div class="eco-card-icon bg-purple-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
              <i class="fas fa-sliders-h text-purple-600"></i>
            </div>
            <div>
              <h3 class="text-base font-bold text-blue-900">Preferências</h3>
              <p class="text-xs text-gray-400">Personalize a experiência</p>
            </div>
          </div>
          <div class="space-y-3">
            <div>
              <label class="eco-label text-xs"><i class="fas fa-ruler mr-1 text-purple-400"></i>Unidade padrão</label>
              <select class="eco-input" style="appearance:auto; font-size:0.875rem; padding:0.5rem 0.75rem;">
                <option value="L">Litros (L)</option>
                <option value="m³">Metros cúbicos (m³)</option>
              </select>
            </div>
            <label class="flex items-center justify-between p-3 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors"
                   style="border:1px solid #e5e7eb;">
              <div class="flex items-center gap-2">
                <i class="fas fa-moon text-purple-500 text-sm"></i>
                <span class="text-sm text-gray-700">Modo Escuro</span>
              </div>
              <input type="checkbox" id="darkModeToggle" class="w-4 h-4" style="accent-color:#1e3a8a;">
            </label>
          </div>
        </div>

        <!-- Sobre -->
        <div class="eco-card animate-fade-in" style="animation-delay:0.25s;">
          <div class="flex items-center gap-3 mb-4 pb-4" style="border-bottom:1px solid #f3f4f6;">
            <div class="eco-card-icon bg-cyan-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
              <i class="fas fa-info-circle text-cyan-600"></i>
            </div>
            <h3 class="text-base font-bold text-blue-900">Sobre</h3>
          </div>
          <div class="space-y-2">
            <div class="flex items-center justify-between py-2" style="border-bottom:1px solid #f9fafb;">
              <span class="text-xs text-gray-400">Versão</span>
              <span class="text-sm font-bold text-blue-600">3.0.0</span>
            </div>
            <div class="flex items-center justify-between py-2" style="border-bottom:1px solid #f9fafb;">
              <span class="text-xs text-gray-400">Instituição</span>
              <span class="text-xs font-medium text-gray-600">IFSP SJC</span>
            </div>
            <div class="flex items-center justify-between py-2">
              <span class="text-xs text-gray-400">© <?= date('Y') ?></span>
              <span class="text-xs text-gray-400">EcoÁgua</span>
            </div>
          </div>
        </div>

        <!-- Sair -->
        <button onclick="confirmarLogout(event)"
                class="btn-eco w-full" style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca;">
          <i class="fas fa-sign-out-alt mr-2"></i>Sair da Conta
        </button>

      </div><!-- /col lateral -->
    </div><!-- /grid -->

  </main>
</div>

<script>
  function confirmarLogout(event) {
    event.preventDefault();
    EcoAlert.confirm(
      'Deseja sair?',
      'Você será desconectado da sua conta',
      'Sim, sair',
      'Cancelar'
    ).then(r => { if (r.isConfirmed) window.location.href = '/sair'; });
  }
</script>
</body>
</html>
