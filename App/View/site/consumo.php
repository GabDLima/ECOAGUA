<body class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 min-h-screen">
  <div id="main-content" class="flex-1 pt-20 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <h2 class="text-3xl font-bold text-gray-800 mb-8">Gerenciar Dados de Consumo</h2>

      <!-- Cards de Ações com Dados Reais -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

        <!-- Card Inserir Valor da Conta -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0s;">
          <div class="flex items-center justify-between mb-4">
            <div class="eco-card-icon bg-green-100">
              <i class="fas fa-dollar-sign text-green-600"></i>
            </div>
            <?php if ($this->view->ultimaFatura): ?>
              <span class="eco-badge eco-badge-success">
                <i class="fas fa-check"></i> Registrada
              </span>
            <?php endif; ?>
          </div>
          <p class="text-sm text-gray-600 font-medium mb-1">Valor da Conta</p>
          <div class="text-3xl font-bold text-gray-800 mb-2">
            <?php if ($this->view->ultimaFatura): ?>
              R$ <?= number_format($this->view->ultimaFatura['valor'], 2, ',', '.') ?>
            <?php else: ?>
              R$ 0,00
            <?php endif; ?>
          </div>
          <p class="text-sm text-gray-500 mb-4">
            <?php if ($this->view->ultimaFatura): ?>
              <i class="fas fa-calendar-alt mr-1"></i>
              Última fatura: <?= date('m/Y', strtotime($this->view->ultimaFatura['mes_da_fatura'])) ?>
            <?php else: ?>
              Registre o valor da sua fatura mensal
            <?php endif; ?>
          </p>
          <button id="btnConta" class="btn-eco btn-eco-primary w-full">
            <i class="fas fa-file-invoice-dollar mr-2"></i>Registrar Fatura
          </button>
        </div>

        <!-- Card Metas de Consumo -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0.1s;">
          <div class="flex items-center justify-between mb-4">
            <div class="eco-card-icon bg-blue-100">
              <i class="fas fa-bullseye text-blue-600"></i>
            </div>
            <?php if ($this->view->metaAtiva): ?>
              <span class="eco-badge eco-badge-info">
                <i class="fas fa-target"></i> Ativa
              </span>
            <?php endif; ?>
          </div>
          <p class="text-sm text-gray-600 font-medium mb-1">Meta Mensal</p>
          <div class="text-3xl font-bold text-gray-800 mb-2">
            <?php if ($this->view->metaAtiva): ?>
              <?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?> L
            <?php else: ?>
              -- L
            <?php endif; ?>
          </div>
          <?php if ($this->view->progressoMeta): ?>
            <div class="mb-4">
              <div class="eco-progress">
                <div class="eco-progress-bar <?= $this->view->progressoMeta['alerta'] ? 'eco-progress-danger' : 'eco-progress-success' ?>"
                     style="width: <?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
              </div>
              <p class="text-xs text-gray-500 mt-1">
                Progresso: <?= $this->view->progressoMeta['percentual'] ?>%
              </p>
            </div>
          <?php else: ?>
            <p class="text-sm text-gray-500 mb-4">
              Defina suas metas de economia
            </p>
          <?php endif; ?>
          <button id="btnMetas" class="btn-eco btn-eco-primary w-full">
            <i class="fas fa-chart-line mr-2"></i>Definir Metas
          </button>
        </div>

        <!-- Card Consumo Diário -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0.2s;">
          <div class="flex items-center justify-between mb-4">
            <div class="eco-card-icon bg-cyan-100">
              <i class="fas fa-tint text-cyan-600"></i>
            </div>
            <span class="eco-badge eco-badge-info">
              <i class="fas fa-calendar-day"></i> Mês Atual
            </span>
          </div>
          <p class="text-sm text-gray-600 font-medium mb-1">Consumo do Mês</p>
          <div class="text-3xl font-bold text-gray-800 mb-2">
            <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?> L
          </div>
          <p class="text-sm text-gray-500 mb-4">
            <i class="fas fa-chart-bar mr-1"></i>
            Total consumido este mês
          </p>
          <button id="btnConsumo" class="btn-eco btn-eco-primary w-full">
            <i class="fas fa-plus-circle mr-2"></i>Registrar Consumo
          </button>
        </div>
      </div>

      <!-- Seção Inserir Valor da Conta -->
      <div id="secaoConta" class="hidden eco-card animate-fade-in mb-8">
        <div class="flex items-center mb-6">
          <div class="eco-card-icon bg-green-100 mr-4">
            <i class="fas fa-file-invoice-dollar text-green-600"></i>
          </div>
          <h3 class="text-2xl font-semibold text-gray-800">Inserir Valor da Conta</h3>
        </div>

        <div id="successAlertConta" class="hidden mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg flex items-center">
          <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
          <span>Valor da conta registrado com sucesso!</span>
        </div>
        <div id="monthError" class="hidden mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg flex items-center">
          <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
          <span></span>
        </div>
        <div id="valueError" class="hidden mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg flex items-center">
          <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
          <span></span>
        </div>

        <form id="contaForm" action="/InserirValordaConta" method="POST" novalidate class="max-w-md space-y-4">
          <div>
            <label for="MES_DA_FATURA" class="eco-label">
              <i class="fas fa-calendar-alt mr-2"></i>Mês da Fatura
            </label>
            <input name="MES_DA_FATURA" type="month" id="MES_DA_FATURA" class="eco-input" required>
            <p class="eco-help-text">Selecione o mês de referência da fatura</p>
          </div>
          <div>
            <label for="VALOR" class="eco-label">
              <i class="fas fa-dollar-sign mr-2"></i>Valor (R$)
            </label>
            <input name="VALOR" type="text" id="VALOR" class="eco-input" placeholder="Ex: 123,45" required>
            <p class="eco-help-text">Informe o valor da fatura em reais</p>
          </div>
          <div class="flex space-x-4">
            <button type="submit" class="btn-eco btn-eco-success">
              <i class="fas fa-save mr-2"></i>Registrar Valor
            </button>
            <button type="button" class="cancelBtn btn-eco bg-gray-500 hover:bg-gray-600 text-white">
              <i class="fas fa-times mr-2"></i>Cancelar
            </button>
          </div>
        </form>
      </div>

      <!-- Seção Metas de Consumo -->
      <div id="secaoMetas" class="hidden eco-card animate-fade-in mb-8">
        <div class="flex items-center mb-6">
          <div class="eco-card-icon bg-blue-100 mr-4">
            <i class="fas fa-bullseye text-blue-600"></i>
          </div>
          <h3 class="text-2xl font-semibold text-gray-800">Minhas Metas de Consumo</h3>
        </div>

        <div id="metasAlert" class="hidden mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg flex items-center">
          <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
          <span>Metas salvas com sucesso!</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Formulário de Metas -->
          <div>
            <form id="metasForm" action="/inserirmetaconsumo" method="POST" class="space-y-4">
              <div>
                <label for="monthlyGoal" class="eco-label">
                  <i class="fas fa-tint mr-2"></i>Meta Mensal (L)
                </label>
                <input name="META_MENSAL" type="number" id="monthlyGoal" class="eco-input" placeholder="Ex: 10000" required>
                <p class="eco-help-text">Defina o consumo máximo mensal em litros</p>
              </div>
              <div>
                <label for="reductionGoal" class="eco-label">
                  <i class="fas fa-percentage mr-2"></i>Meta de Redução (%)
                </label>
                <input name="META_REDUCAO" type="number" id="reductionGoal" class="eco-input" placeholder="Ex: 15" required>
                <p class="eco-help-text">Percentual de economia desejado</p>
              </div>
              <div>
                <label for="periodMonths" class="eco-label">
                  <i class="fas fa-calendar mr-2"></i>Prazo (meses)
                </label>
                <input name="PRAZO" type="number" id="periodMonths" class="eco-input" placeholder="Ex: 3" required>
                <p class="eco-help-text">Tempo para atingir a meta</p>
              </div>
              <div class="flex space-x-4">
                <button type="submit" class="btn-eco btn-eco-success">
                  <i class="fas fa-save mr-2"></i>Salvar Metas
                </button>
                <button type="button" class="cancelBtn btn-eco bg-gray-500 hover:bg-gray-600 text-white">
                  <i class="fas fa-times mr-2"></i>Cancelar
                </button>
              </div>
            </form>
          </div>

          <!-- Metas Atuais - DINÂMICO -->
          <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-100">
            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <i class="fas fa-chart-line text-blue-600 mr-2"></i>Metas Atuais
            </h4>
            <?php if ($this->view->metaAtiva): ?>
              <ul class="space-y-3 text-gray-700 mb-4">
                <li class="flex items-start">
                  <i class="fas fa-tint text-blue-600 mr-2 mt-1"></i>
                  <span><strong>Meta Mensal:</strong> <?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?> L</span>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-chart-line text-green-600 mr-2 mt-1"></i>
                  <span><strong>Meta de Redução:</strong> <?= $this->view->metaAtiva['meta_reducao'] ?>%</span>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-calendar-alt text-orange-600 mr-2 mt-1"></i>
                  <span><strong>Prazo:</strong> <?= $this->view->metaAtiva['prazo'] ?> meses</span>
                </li>
              </ul>
              <?php if ($this->view->progressoMeta): ?>
                <div class="mt-4">
                  <div class="flex justify-between text-sm text-gray-700 font-medium mb-2">
                    <span><i class="fas fa-tasks mr-1"></i>Progresso</span>
                    <span class="<?= $this->view->progressoMeta['alerta'] ? 'text-red-600' : 'text-green-600' ?>">
                      <?= $this->view->progressoMeta['percentual'] ?>%
                    </span>
                  </div>
                  <div class="eco-progress">
                    <div class="eco-progress-bar <?= $this->view->progressoMeta['alerta'] ? 'eco-progress-danger' : 'eco-progress-success' ?>"
                         style="width: <?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
                  </div>
                  <p class="text-sm text-gray-600 mt-2 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Consumido: <?= number_format($this->view->progressoMeta['consumo_atual'], 0, ',', '.') ?> L
                  </p>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div class="eco-empty-state py-6">
                <div class="eco-empty-icon text-blue-400">
                  <i class="fas fa-clipboard-list"></i>
                </div>
                <p class="eco-empty-title">Nenhuma meta definida</p>
                <p class="eco-empty-text">Preencha o formulário ao lado para criar sua primeira meta de economia!</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Seção Consumo Diário -->
      <div id="secaoConsumo" class="hidden eco-card animate-fade-in mb-8">
        <div class="flex items-center mb-6">
          <div class="eco-card-icon bg-cyan-100 mr-4">
            <i class="fas fa-tint text-cyan-600"></i>
          </div>
          <h3 class="text-2xl font-semibold text-gray-800">Registrar Consumo Diário</h3>
        </div>

        <div id="successAlertConsumo" class="hidden mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg flex items-center">
          <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
          <span>Consumo registrado com sucesso!</span>
        </div>
        <div id="dateError" class="hidden mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg flex items-center">
          <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
          <span></span>
        </div>
        <div id="quantityError" class="hidden mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg flex items-center">
          <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
          <span></span>
        </div>

        <form id="registroForm" action="/inserirconsumodiario" method="POST" novalidate class="max-w-md space-y-4">
          <div>
            <label for="consumoDate" class="eco-label">
              <i class="fas fa-calendar-day mr-2"></i>Data do Consumo
            </label>
            <input name="DATA_CONSUMO" type="date" id="consumoDate" class="eco-input" required>
            <p class="eco-help-text">Selecione a data do registro</p>
          </div>
          <div>
            <label for="tipo" class="eco-label">
              <i class="fas fa-tag mr-2"></i>Tipo
            </label>
            <input name="TIPO" type="text" id="tipo" class="eco-input" placeholder="Ex: Banho, Louça, Faxina" required>
            <p class="eco-help-text">Informe o tipo de uso da água</p>
          </div>
          <div>
            <label for="consumoValue" class="eco-label">
              <i class="fas fa-water mr-2"></i>Quantidade
            </label>
            <input name="QUANTIDADE" type="text" id="consumoValue" class="eco-input" placeholder="Ex: 2,5 ou 2.5" required>
            <p class="eco-help-text">Digite o valor da quantidade consumida</p>
          </div>
          <div>
            <label for="consumoUnit" class="eco-label">
              <i class="fas fa-balance-scale mr-2"></i>Unidade
            </label>
            <select name="UNIDADE" id="consumoUnit" class="eco-input" required>
              <option value="L">Litros (L)</option>
              <option value="m³">Metros Cúbicos (m³)</option>
              <option value="mL">Mililitros (mL)</option>
            </select>
            <p class="eco-help-text">Selecione a unidade de medida</p>
          </div>
          <div class="flex space-x-4">
            <button type="submit" class="btn-eco btn-eco-success">
              <i class="fas fa-save mr-2"></i>Registrar Consumo
            </button>
            <button type="button" class="cancelBtn btn-eco bg-gray-500 hover:bg-gray-600 text-white">
              <i class="fas fa-times mr-2"></i>Cancelar
            </button>
          </div>
        </form>
      </div>

      <!-- Resumo dos Dados Registrados - DINÂMICO -->
      <div class="eco-card animate-fade-in" style="animation-delay: 0.3s;">
        <div class="flex items-center mb-6">
          <div class="eco-card-icon bg-gray-100 mr-4">
            <i class="fas fa-list text-gray-600"></i>
          </div>
          <h3 class="text-2xl font-semibold text-gray-800">Resumo dos Dados Registrados</h3>
        </div>
        <div class="overflow-x-auto">
          <?php
          $temDados = !empty($this->view->ultimasFaturas) ||
                      !empty($this->view->ultimasMetas) ||
                      !empty($this->view->ultimosConsumos);
          ?>

          <?php if ($temDados): ?>
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-gradient-to-r from-blue-50 to-cyan-50">
                <tr>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-tag mr-2"></i>Tipo
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-calendar mr-2"></i>Data
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-chart-bar mr-2"></i>Valor
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-info-circle mr-2"></i>Status
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">

                <!-- Faturas -->
                <?php if (!empty($this->view->ultimasFaturas)): ?>
                  <?php foreach ($this->view->ultimasFaturas as $fatura): ?>
                    <tr class="hover:bg-blue-50 transition-colors">
                      <td class="px-4 py-3">
                        <i class="fas fa-dollar-sign text-green-600 mr-2"></i>
                        <span class="font-medium">Fatura</span>
                      </td>
                      <td class="px-4 py-3 text-gray-700"><?= date('m/Y', strtotime($fatura['mes'])) ?></td>
                      <td class="px-4 py-3 font-semibold text-gray-800">R$ <?= number_format($fatura['valor'], 2, ',', '.') ?></td>
                      <td class="px-4 py-3">
                        <span class="eco-badge eco-badge-success">
                          <i class="fas fa-check"></i> Registrado
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>

                <!-- Metas -->
                <?php if (!empty($this->view->ultimasMetas)): ?>
                  <?php foreach ($this->view->ultimasMetas as $meta): ?>
                    <tr class="hover:bg-blue-50 transition-colors">
                      <td class="px-4 py-3">
                        <i class="fas fa-bullseye text-blue-600 mr-2"></i>
                        <span class="font-medium">Meta Mensal</span>
                      </td>
                      <td class="px-4 py-3 text-gray-700">--</td>
                      <td class="px-4 py-3 font-semibold text-gray-800"><?= number_format($meta->__get('meta_mensal'), 0, ',', '.') ?> L</td>
                      <td class="px-4 py-3">
                        <span class="eco-badge eco-badge-info">
                          <i class="fas fa-flag"></i> Ativa
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>

                <!-- Consumos -->
                <?php if (!empty($this->view->ultimosConsumos)): ?>
                  <?php foreach ($this->view->ultimosConsumos as $consumo): ?>
                    <?php
                      $quantidade = $consumo->__get('quantidade');
                      $unidade = $consumo->__get('unidade');

                      // Conversão para litros
                      $litros = $quantidade;
                      if ($unidade == 'mL') {
                        $litros = $quantidade / 1000;
                      } elseif ($unidade == 'm³') {
                        $litros = $quantidade * 1000;
                      }
                    ?>
                    <tr class="hover:bg-blue-50 transition-colors">
                      <td class="px-4 py-3">
                        <i class="fas fa-tint text-cyan-600 mr-2"></i>
                        <span class="font-medium">Consumo</span>
                        <span class="text-xs text-gray-500">(<?= htmlspecialchars($consumo->__get('tipo')) ?>)</span>
                      </td>
                      <td class="px-4 py-3 text-gray-700"><?= date('d/m/Y', strtotime($consumo->__get('data_consumo'))) ?></td>
                      <td class="px-4 py-3 font-semibold text-gray-800"><?= number_format($litros, 2, ',', '.') ?> L</td>
                      <td class="px-4 py-3">
                        <span class="eco-badge eco-badge-success">
                          <i class="fas fa-check"></i> Registrado
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>

              </tbody>
            </table>
          <?php else: ?>
            <div class="eco-empty-state py-12">
              <div class="eco-empty-icon">
                <i class="fas fa-inbox"></i>
              </div>
              <h3 class="eco-empty-title">Nenhum dado registrado ainda</h3>
              <p class="eco-empty-text">Comece registrando sua fatura, meta ou consumo diário usando os cards acima!</p>
              <button onclick="document.getElementById('btnConsumo').click()" class="btn-eco btn-eco-primary mt-4">
                <i class="fas fa-plus-circle mr-2"></i>Registrar Primeiro Consumo
              </button>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const btnConta = document.getElementById('btnConta');
      const btnMetas = document.getElementById('btnMetas');
      const btnConsumo = document.getElementById('btnConsumo');
      
      const secaoConta = document.getElementById('secaoConta');
      const secaoMetas = document.getElementById('secaoMetas');
      const secaoConsumo = document.getElementById('secaoConsumo');

      const cancelBtns = document.querySelectorAll('.cancelBtn');

      function hideAllSections() {
        secaoConta.classList.add('hidden');
        secaoMetas.classList.add('hidden');
        secaoConsumo.classList.add('hidden');
      }

      btnConta.addEventListener('click', () => {
        hideAllSections();
        secaoConta.classList.remove('hidden');
        secaoConta.scrollIntoView({ behavior: 'smooth' });
      });

      btnMetas.addEventListener('click', () => {
        hideAllSections();
        secaoMetas.classList.remove('hidden');
        secaoMetas.scrollIntoView({ behavior: 'smooth' });
      });

      btnConsumo.addEventListener('click', () => {
        hideAllSections();
        secaoConsumo.classList.remove('hidden');
        secaoConsumo.scrollIntoView({ behavior: 'smooth' });
      });

      cancelBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          hideAllSections();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      });

      // Definir data atual como padrão
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('consumoDate').value = today;
    });
  </script>
</body>
</html>