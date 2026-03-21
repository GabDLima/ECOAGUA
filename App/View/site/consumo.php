<style>
  .secao-form {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4,0,0.2,1), opacity 0.3s ease;
    opacity: 0;
  }
  .secao-form.open {
    max-height: 900px;
    opacity: 1;
  }
  .action-card {
    cursor: pointer;
    transition: all 0.2s;
  }
  .action-card:hover { transform: translateY(-3px); }
  .action-card.selected {
    border: 2px solid #1e3a8a;
    box-shadow: 0 0 0 4px rgba(30,58,138,0.08);
  }
</style>

<body class="bg-gray-50">
<div id="main-content" class="flex-1 pt-20 transition-[margin] duration-300">
  <main class="px-6 py-6" style="max-width:1200px; margin:0 auto;">

    <!-- Cabeçalho -->
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-2xl font-bold text-blue-900">Gerenciar Consumo</h1>
        <p class="text-gray-400 text-sm mt-1">Registre faturas, metas e consumo diário</p>
      </div>
    </div>

    <!-- ── Cards de ação ── -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

      <!-- Fatura -->
      <div class="eco-card action-card animate-fade-in" id="cardConta" style="animation-delay:0s;"
           onclick="abrirSecao('secaoConta','cardConta')">
        <div class="flex items-center justify-between mb-4">
          <div class="eco-card-icon bg-green-100" style="margin-bottom:0;">
            <i class="fas fa-file-invoice-dollar text-green-600"></i>
          </div>
          <?php if ($this->view->ultimaFatura): ?>
            <span class="eco-badge eco-badge-success"><i class="fas fa-check mr-1"></i>Registrada</span>
          <?php else: ?>
            <span class="eco-badge eco-badge-warning">Pendente</span>
          <?php endif; ?>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Fatura Mensal</p>
        <p class="text-2xl font-bold text-gray-800 mb-1">
          R$ <?= $this->view->ultimaFatura ? number_format($this->view->ultimaFatura['valor'], 2, ',', '.') : '0,00' ?>
        </p>
        <p class="text-xs text-gray-400 mb-4">
          <?= $this->view->ultimaFatura
              ? '<i class="fas fa-calendar-alt mr-1"></i>' . date('m/Y', strtotime($this->view->ultimaFatura['mes_da_fatura']))
              : 'Nenhuma fatura registrada' ?>
        </p>
        <div class="btn-eco btn-eco-success w-full text-center" style="pointer-events:none;">
          <i class="fas fa-plus mr-2"></i>Registrar Fatura
        </div>
      </div>

      <!-- Metas -->
      <div class="eco-card action-card animate-fade-in" id="cardMetas" style="animation-delay:0.08s;"
           onclick="abrirSecao('secaoMetas','cardMetas')">
        <div class="flex items-center justify-between mb-4">
          <div class="eco-card-icon bg-blue-100" style="margin-bottom:0;">
            <i class="fas fa-bullseye text-blue-600"></i>
          </div>
          <?php if ($this->view->metaAtiva): ?>
            <span class="eco-badge eco-badge-info"><i class="fas fa-bullseye mr-1"></i>Ativa</span>
          <?php endif; ?>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Meta Mensal</p>
        <p class="text-2xl font-bold text-gray-800 mb-1">
          <?= $this->view->metaAtiva ? number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') . ' L' : '-- L' ?>
        </p>
        <?php if ($this->view->progressoMeta): ?>
          <div class="mb-4">
            <div class="eco-progress" style="height:6px;">
              <div class="eco-progress-bar <?= $this->view->progressoMeta['alerta'] ? 'eco-progress-danger' : 'eco-progress-success' ?>"
                   style="width:<?= min($this->view->progressoMeta['percentual'],100) ?>%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1"><?= $this->view->progressoMeta['percentual'] ?>% da meta</p>
          </div>
        <?php else: ?>
          <p class="text-xs text-gray-400 mb-4">Nenhuma meta definida</p>
        <?php endif; ?>
        <div class="btn-eco btn-eco-primary w-full text-center" style="pointer-events:none;">
          <i class="fas fa-chart-line mr-2"></i>Definir Metas
        </div>
      </div>

      <!-- Consumo Diário -->
      <div class="eco-card action-card animate-fade-in" id="cardConsumo" style="animation-delay:0.16s;"
           onclick="abrirSecao('secaoConsumo','cardConsumo')">
        <div class="flex items-center justify-between mb-4">
          <div class="eco-card-icon bg-cyan-100" style="margin-bottom:0;">
            <i class="fas fa-tint text-cyan-600"></i>
          </div>
          <span class="eco-badge eco-badge-info">Mês Atual</span>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Consumo do Mês</p>
        <p class="text-2xl font-bold text-gray-800 mb-1">
          <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?> L
        </p>
        <p class="text-xs text-gray-400 mb-4">Total consumido neste mês</p>
        <div class="btn-eco btn-eco-primary w-full text-center" style="pointer-events:none;">
          <i class="fas fa-plus-circle mr-2"></i>Registrar Consumo
        </div>
      </div>
    </div>

    <!-- ── SEÇÃO: Fatura ── -->
    <div class="secao-form" id="secaoConta">
      <div class="eco-card mb-6">
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="eco-card-icon bg-green-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
              <i class="fas fa-file-invoice-dollar text-green-600"></i>
            </div>
            <div>
              <h3 class="text-lg font-bold text-blue-900">Registrar Fatura</h3>
              <p class="text-xs text-gray-400">Informe o valor da sua conta de água</p>
            </div>
          </div>
          <button onclick="fecharSecao('secaoConta','cardConta')"
                  class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors border-none bg-transparent cursor-pointer">
            <i class="fas fa-times text-gray-400"></i>
          </button>
        </div>

        <form id="contaForm" action="/InserirValordaConta" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="eco-label"><i class="fas fa-calendar-alt mr-2 text-green-600"></i>Mês da Fatura</label>
            <input name="MES_DA_FATURA" type="month" class="eco-input" required>
            <p class="eco-help-text">Mês de referência da fatura</p>
          </div>
          <div>
            <label class="eco-label"><i class="fas fa-dollar-sign mr-2 text-green-600"></i>Valor (R$)</label>
            <input name="VALOR" type="text" class="eco-input" placeholder="Ex: 123,45" required>
            <p class="eco-help-text">Valor em reais conforme a fatura</p>
          </div>
          <div class="md:col-span-2 flex gap-3 pt-2">
            <button type="submit" class="btn-eco btn-eco-success">
              <i class="fas fa-save mr-2"></i>Salvar Fatura
            </button>
            <button type="button" onclick="fecharSecao('secaoConta','cardConta')"
                    class="btn-eco" style="background:#f3f4f6; color:#6b7280;">
              <i class="fas fa-times mr-2"></i>Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ── SEÇÃO: Metas ── -->
    <div class="secao-form" id="secaoMetas">
      <div class="eco-card mb-6">
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="eco-card-icon bg-blue-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
              <i class="fas fa-bullseye text-blue-600"></i>
            </div>
            <div>
              <h3 class="text-lg font-bold text-blue-900">Definir Metas</h3>
              <p class="text-xs text-gray-400">Configure seus objetivos de economia</p>
            </div>
          </div>
          <button onclick="fecharSecao('secaoMetas','cardMetas')"
                  class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors border-none bg-transparent cursor-pointer">
            <i class="fas fa-times text-gray-400"></i>
          </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <form id="metasForm" action="/inserirmetaconsumo" method="POST" class="space-y-4">
            <div>
              <label class="eco-label"><i class="fas fa-tint mr-2 text-blue-500"></i>Meta Mensal (L)</label>
              <input name="META_MENSAL" type="number" class="eco-input" placeholder="Ex: 10000" required>
              <p class="eco-help-text">Consumo máximo que deseja atingir por mês</p>
            </div>
            <div>
              <label class="eco-label"><i class="fas fa-percentage mr-2 text-blue-500"></i>Meta de Redução (%)</label>
              <input name="META_REDUCAO" type="number" class="eco-input" placeholder="Ex: 15" required>
              <p class="eco-help-text">Percentual de economia desejado</p>
            </div>
            <div>
              <label class="eco-label"><i class="fas fa-calendar mr-2 text-blue-500"></i>Prazo (meses)</label>
              <input name="PRAZO" type="number" class="eco-input" placeholder="Ex: 3" required>
              <p class="eco-help-text">Tempo para atingir a meta</p>
            </div>
            <div class="flex gap-3 pt-2">
              <button type="submit" class="btn-eco btn-eco-success">
                <i class="fas fa-save mr-2"></i>Salvar Metas
              </button>
              <button type="button" onclick="fecharSecao('secaoMetas','cardMetas')"
                      class="btn-eco" style="background:#f3f4f6; color:#6b7280;">
                <i class="fas fa-times mr-2"></i>Cancelar
              </button>
            </div>
          </form>

          <!-- Estado atual das metas -->
          <div class="rounded-2xl p-5" style="background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1px solid #bfdbfe;">
            <h4 class="text-sm font-bold text-blue-900 mb-4 flex items-center gap-2">
              <i class="fas fa-chart-line text-blue-600"></i>Metas Atuais
            </h4>
            <?php if ($this->view->metaAtiva): ?>
              <div class="space-y-3 mb-4">
                <div class="flex items-center justify-between p-3 bg-white rounded-xl">
                  <span class="text-sm text-gray-600"><i class="fas fa-tint mr-2 text-blue-400"></i>Meta Mensal</span>
                  <span class="font-bold text-blue-900"><?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?> L</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white rounded-xl">
                  <span class="text-sm text-gray-600"><i class="fas fa-percentage mr-2 text-green-400"></i>Redução</span>
                  <span class="font-bold text-green-700"><?= $this->view->metaAtiva['meta_reducao'] ?>%</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white rounded-xl">
                  <span class="text-sm text-gray-600"><i class="fas fa-calendar mr-2 text-orange-400"></i>Prazo</span>
                  <span class="font-bold text-gray-800"><?= $this->view->metaAtiva['prazo'] ?> meses</span>
                </div>
              </div>
              <?php if ($this->view->progressoMeta): ?>
                <div>
                  <div class="flex justify-between text-xs font-semibold mb-2">
                    <span class="text-gray-600">Progresso</span>
                    <span class="<?= $this->view->progressoMeta['alerta'] ? 'text-red-600' : 'text-green-600' ?>">
                      <?= $this->view->progressoMeta['percentual'] ?>%
                    </span>
                  </div>
                  <div class="eco-progress">
                    <div class="eco-progress-bar <?= $this->view->progressoMeta['alerta'] ? 'eco-progress-danger' : 'eco-progress-success' ?>"
                         style="width:<?= min($this->view->progressoMeta['percentual'],100) ?>%"></div>
                  </div>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div class="eco-empty-state py-6">
                <p class="eco-empty-title text-base">Sem metas definidas</p>
                <p class="eco-empty-text text-xs">Preencha o formulário para criar sua primeira meta</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- ── SEÇÃO: Consumo Diário ── -->
    <div class="secao-form" id="secaoConsumo">
      <div class="eco-card mb-6">
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="eco-card-icon bg-cyan-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
              <i class="fas fa-tint text-cyan-600"></i>
            </div>
            <div>
              <h3 class="text-lg font-bold text-blue-900">Registrar Consumo</h3>
              <p class="text-xs text-gray-400">Informe o consumo de água do dia</p>
            </div>
          </div>
          <button onclick="fecharSecao('secaoConsumo','cardConsumo')"
                  class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors border-none bg-transparent cursor-pointer">
            <i class="fas fa-times text-gray-400"></i>
          </button>
        </div>

        <form id="registroForm" action="/inserirconsumodiario" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="eco-label"><i class="fas fa-calendar-day mr-2 text-cyan-500"></i>Data do Consumo</label>
            <input name="DATA_CONSUMO" type="date" id="consumoDate" class="eco-input" required>
            <p class="eco-help-text">Data em que o consumo ocorreu</p>
          </div>
          <div>
            <label class="eco-label"><i class="fas fa-tag mr-2 text-cyan-500"></i>Tipo de Uso</label>
            <select name="TIPO" class="eco-input" style="appearance:auto;" required>
              <option value="">Selecione o tipo...</option>
              <option value="Banho">🚿 Banho</option>
              <option value="Cozinha">🍽️ Cozinha</option>
              <option value="Lavanderia">👕 Lavanderia</option>
              <option value="Jardim">🌱 Jardim</option>
              <option value="Limpeza">🧹 Limpeza</option>
              <option value="Outros">📦 Outros</option>
            </select>
            <p class="eco-help-text">Selecione a categoria do consumo</p>
          </div>
          <div>
            <label class="eco-label"><i class="fas fa-water mr-2 text-cyan-500"></i>Quantidade</label>
            <input name="QUANTIDADE" type="text" class="eco-input" placeholder="Ex: 2,5 ou 2.5" required>
            <p class="eco-help-text">Valor numérico da quantidade consumida</p>
          </div>
          <div>
            <label class="eco-label"><i class="fas fa-balance-scale mr-2 text-cyan-500"></i>Unidade</label>
            <select name="UNIDADE" class="eco-input" style="appearance:auto;" required>
              <option value="L">Litros (L)</option>
              <option value="m³">Metros Cúbicos (m³)</option>
              <option value="mL">Mililitros (mL)</option>
            </select>
          </div>
          <div class="md:col-span-2 flex gap-3 pt-2">
            <button type="submit" class="btn-eco btn-eco-success">
              <i class="fas fa-save mr-2"></i>Registrar Consumo
            </button>
            <button type="button" onclick="fecharSecao('secaoConsumo','cardConsumo')"
                    class="btn-eco" style="background:#f3f4f6; color:#6b7280;">
              <i class="fas fa-times mr-2"></i>Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ── Tabela de resumo ── -->
    <div class="eco-card animate-fade-in" style="animation-delay:0.3s;">
      <div class="flex items-center gap-3 mb-5">
        <div class="eco-card-icon bg-gray-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
          <i class="fas fa-table text-gray-600"></i>
        </div>
        <h3 class="text-base font-bold text-blue-900">Dados Registrados</h3>
      </div>

      <?php $temDados = !empty($this->view->ultimasFaturas) || !empty($this->view->ultimasMetas) || !empty($this->view->ultimosConsumos); ?>

      <?php if ($temDados): ?>
        <div class="overflow-x-auto">
          <table class="eco-table">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($this->view->ultimasFaturas as $fatura): ?>
                <tr class="hover:bg-green-50 transition-colors">
                  <td class="py-3 px-4"><span class="eco-badge eco-badge-success"><i class="fas fa-file-invoice-dollar mr-1"></i>Fatura</span></td>
                  <td class="py-3 px-4 text-gray-500"><?= date('m/Y', strtotime($fatura['mes'])) ?></td>
                  <td class="py-3 px-4 font-semibold text-gray-800">R$ <?= number_format($fatura['valor'], 2, ',', '.') ?></td>
                  <td class="py-3 px-4"><span class="eco-badge eco-badge-success"><i class="fas fa-check mr-1"></i>OK</span></td>
                </tr>
              <?php endforeach; ?>

              <?php foreach ($this->view->ultimasMetas as $meta): ?>
                <tr class="hover:bg-blue-50 transition-colors">
                  <td class="py-3 px-4"><span class="eco-badge eco-badge-info"><i class="fas fa-bullseye mr-1"></i>Meta</span></td>
                  <td class="py-3 px-4 text-gray-500">—</td>
                  <td class="py-3 px-4 font-semibold text-gray-800"><?= number_format($meta->__get('meta_mensal'), 0, ',', '.') ?> L</td>
                  <td class="py-3 px-4"><span class="eco-badge eco-badge-info"><i class="fas fa-flag mr-1"></i>Ativa</span></td>
                </tr>
              <?php endforeach; ?>

              <?php foreach ($this->view->ultimosConsumos as $consumo): ?>
                <?php
                  $qt = $consumo->__get('quantidade');
                  $un = $consumo->__get('unidade');
                  $lt = $qt;
                  if ($un == 'mL') $lt = $qt / 1000;
                  elseif ($un == 'm³') $lt = $qt * 1000;
                ?>
                <tr class="hover:bg-cyan-50 transition-colors">
                  <td class="py-3 px-4">
                    <span class="eco-badge" style="background:#cffafe; color:#164e63;">
                      <i class="fas fa-tint mr-1"></i><?= htmlspecialchars($consumo->__get('tipo')) ?>
                    </span>
                  </td>
                  <td class="py-3 px-4 text-gray-500"><?= date('d/m/Y', strtotime($consumo->__get('data_consumo'))) ?></td>
                  <td class="py-3 px-4 font-semibold text-blue-700"><?= number_format($lt, 2, ',', '.') ?> L</td>
                  <td class="py-3 px-4"><span class="eco-badge eco-badge-success"><i class="fas fa-check mr-1"></i>OK</span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="eco-empty-state">
          <div class="eco-empty-icon"><i class="fas fa-inbox"></i></div>
          <h3 class="eco-empty-title">Nenhum dado registrado ainda</h3>
          <p class="eco-empty-text">Clique em um dos cards acima para começar</p>
        </div>
      <?php endif; ?>
    </div>

  </main>
</div>

<script>
  const secoes  = ['secaoConta','secaoMetas','secaoConsumo'];
  const botoes  = ['cardConta','cardMetas','cardConsumo'];

  function abrirSecao(secaoId, cardId) {
    const jaAberta = document.getElementById(secaoId).classList.contains('open');

    // Fecha tudo
    secoes.forEach(s => document.getElementById(s).classList.remove('open'));
    botoes.forEach(b => document.getElementById(b).classList.remove('selected'));

    if (!jaAberta) {
      document.getElementById(secaoId).classList.add('open');
      document.getElementById(cardId).classList.add('selected');
      setTimeout(() => {
        document.getElementById(secaoId).scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 100);
    }
  }

  function fecharSecao(secaoId, cardId) {
    document.getElementById(secaoId).classList.remove('open');
    document.getElementById(cardId).classList.remove('selected');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  // Data padrão = hoje
  document.addEventListener('DOMContentLoaded', () => {
    const d = document.getElementById('consumoDate');
    if (d) d.value = new Date().toISOString().split('T')[0];
  });
</script>
</body>
</html>
