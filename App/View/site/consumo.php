<body class="bg-gray-50">
  <div id="main-content" class="flex-1 pt-5 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">Gerenciar Dados de Consumo</h2>

      <!-- Cards de Ações com Dados Reais -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Card Inserir Valor da Conta -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Inserir Valor da Conta</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">
              <?php if ($this->view->ultimaFatura): ?>
                R$ <?= number_format($this->view->ultimaFatura['valor'], 2, ',', '.') ?>
              <?php else: ?>
                R$ 0,00
              <?php endif; ?>
            </div>
            <p class="text-gray-600 mb-4">
              <?php if ($this->view->ultimaFatura): ?>
                Última fatura: <?= date('m/Y', strtotime($this->view->ultimaFatura['mes_da_fatura'])) ?>
              <?php else: ?>
                Registre o valor da sua fatura mensal.
              <?php endif; ?>
            </p>
            <button id="btnConta" class="w-full bg-blue-900 hover:bg-blue-700 text-white font-medium py-2 rounded">Registrar Fatura</button>
          </div>
        </div>

        <!-- Card Metas de Consumo -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Metas de Consumo</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">
              <?php if ($this->view->metaAtiva): ?>
                <?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?> L
              <?php else: ?>
                -- L
              <?php endif; ?>
            </div>
            <p class="text-gray-600 mb-4">
              <?php if ($this->view->progressoMeta): ?>
                Progresso: <?= $this->view->progressoMeta['percentual'] ?>%
              <?php else: ?>
                Defina suas metas de economia.
              <?php endif; ?>
            </p>
            <button id="btnMetas" class="w-full bg-blue-900 hover:bg-blue-700 text-white font-medium py-2 rounded">Definir Metas</button>
          </div>
        </div>

        <!-- Card Consumo Diário -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Consumo do Mês</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">
              <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?> L
            </div>
            <p class="text-gray-600 mb-4">Total consumido este mês</p>
            <button id="btnConsumo" class="w-full bg-blue-900 hover:bg-blue-700 text-white font-medium py-2 rounded">Registrar Consumo</button>
          </div>
        </div>
      </div>

      <!-- Seção Inserir Valor da Conta -->
      <div id="secaoConta" class="hidden bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-xl font-semibold text-blue-900 mb-4">Inserir Valor da Conta</h3>
        
        <div id="successAlertConta" class="hidden mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
          Valor da conta registrado com sucesso!
        </div>
        <div id="monthError" class="hidden mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"></div>
        <div id="valueError" class="hidden mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"></div>

        <form id="contaForm" action="/InserirValordaConta" method="POST" novalidate class="max-w-md space-y-4">
          <div>
            <label for="MES_DA_FATURA" class="block text-gray-700 font-medium mb-1">Mês da Fatura</label>
            <input name="MES_DA_FATURA" type="month" id="MES_DA_FATURA" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
          </div>
          <div>
            <label for="VALOR" class="block text-gray-700 font-medium mb-1">Valor (R$ ex: 123,45)</label>
            <input name="VALOR" type="text" id="VALOR" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Informe o valor da fatura" required>
          </div>
          <div class="flex space-x-4">
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 px-6 rounded transition">Registrar Valor</button>
            <button type="button" class="cancelBtn bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded transition">Cancelar</button>
          </div>
        </form>
      </div>

      <!-- Seção Metas de Consumo -->
      <div id="secaoMetas" class="hidden bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-xl font-semibold text-blue-900 mb-4">Minhas Metas de Consumo</h3>
        
        <div id="metasAlert" class="hidden mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
          Metas salvas com sucesso!
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Formulário de Metas -->
          <div>
            <form id="metasForm" action="/inserirmetaconsumo" method="POST" class="space-y-4">
              <div>
                <label for="monthlyGoal" class="block text-gray-700 font-medium mb-1">Meta Mensal (L)</label>
                <input name="META_MENSAL" type="number" id="monthlyGoal" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Ex: 10000" required>
              </div>
              <div>
                <label for="reductionGoal" class="block text-gray-700 font-medium mb-1">Meta de Redução (%)</label>
                <input name="META_REDUCAO" type="number" id="reductionGoal" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Ex: 15" required>
              </div>
              <div>
                <label for="periodMonths" class="block text-gray-700 font-medium mb-1">Prazo (meses)</label>
                <input name="PRAZO" type="number" id="periodMonths" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Ex: 3" required>
              </div>
              <div class="flex space-x-4">
                <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 px-6 rounded transition">Salvar Metas</button>
                <button type="button" class="cancelBtn bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded transition">Cancelar</button>
              </div>
            </form>
          </div>

          <!-- Metas Atuais - DINÂMICO -->
          <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-blue-900 mb-4">Metas Atuais</h4>
            <?php if ($this->view->metaAtiva): ?>
              <ul class="space-y-2 text-gray-700">
                <li><strong>Meta Mensal:</strong> <?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?> L</li>
                <li><strong>Meta de Redução:</strong> <?= $this->view->metaAtiva['meta_reducao'] ?>%</li>
                <li><strong>Prazo:</strong> <?= $this->view->metaAtiva['prazo'] ?> meses</li>
              </ul>
              <?php if ($this->view->progressoMeta): ?>
                <div class="mt-4">
                  <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Progresso</span>
                    <span><?= $this->view->progressoMeta['percentual'] ?>%</span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="<?= $this->view->progressoMeta['alerta'] ? 'bg-red-600' : 'bg-green-600' ?> h-3 rounded-full transition-all" 
                         style="width: <?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
                  </div>
                  <p class="text-sm text-gray-600 mt-2">
                    Consumido: <?= number_format($this->view->progressoMeta['consumo_atual'], 0, ',', '.') ?> L
                  </p>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <p class="text-gray-500">Nenhuma meta definida ainda. Preencha o formulário ao lado para criar sua primeira meta!</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Seção Consumo Diário -->
      <div id="secaoConsumo" class="hidden bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-xl font-semibold text-blue-900 mb-4">Registrar Consumo Diário</h3>
        
        <div id="successAlertConsumo" class="hidden mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
          Consumo registrado com sucesso!
        </div>
        <div id="dateError" class="hidden mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"></div>
        <div id="quantityError" class="hidden mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"></div>

        <form id="registroForm" action="/inserirconsumodiario" method="POST" novalidate class="max-w-md space-y-4">
          <div>
            <label for="consumoDate" class="block text-gray-700 font-medium mb-1">Data do Consumo</label>
            <input name="DATA_CONSUMO" type="date" id="consumoDate" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
          </div>
          <div>
            <label for="tipo" class="block text-gray-700 font-medium mb-1">Tipo</label>
            <input name="TIPO" type="text" id="tipo" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Ex: Banho, Louça, Faxina" required>
          </div>
          <div>
            <label for="consumoValue" class="block text-gray-700 font-medium mb-1">Quantidade (ex: 2,5 ou 2.5)</label>
            <input name="QUANTIDADE" type="text" id="consumoValue" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Informe a quantidade" required>
          </div>
          <div>
            <label for="consumoUnit" class="block text-gray-700 font-medium mb-1">Unidade</label>
            <select name="UNIDADE" id="consumoUnit" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
              <option value="L">Litros (L)</option>
              <option value="m³">Metros Cúbicos (m³)</option>
              <option value="mL">Mililitros (mL)</option>
            </select>
          </div>
          <div class="flex space-x-4">
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 px-6 rounded transition">Registrar Consumo</button>
            <button type="button" class="cancelBtn bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded transition">Cancelar</button>
          </div>
        </form>
      </div>

      <!-- Resumo dos Dados Registrados - DINÂMICO -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-3 bg-blue-900 text-white font-medium">📋 Resumo dos Dados Registrados</div>
        <div class="p-4 overflow-x-auto">
          <?php 
          $temDados = !empty($this->view->ultimasFaturas) || 
                      !empty($this->view->ultimasMetas) || 
                      !empty($this->view->ultimosConsumos);
          ?>
          
          <?php if ($temDados): ?>
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tipo</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Data</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Valor</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                
                <!-- Faturas -->
                <?php if (!empty($this->view->ultimasFaturas)): ?>
                  <?php foreach ($this->view->ultimasFaturas as $fatura): ?>
                    <tr>
                      <td class="px-4 py-2">💰 Fatura</td>
                      <td class="px-4 py-2"><?= date('m/Y', strtotime($fatura['mes'])) ?></td>
                      <td class="px-4 py-2">R$ <?= number_format($fatura['valor'], 2, ',', '.') ?></td>
                      <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Registrado</span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>

                <!-- Metas -->
                <?php if (!empty($this->view->ultimasMetas)): ?>
                  <?php foreach ($this->view->ultimasMetas as $meta): ?>
                    <tr>
                      <td class="px-4 py-2">🎯 Meta Mensal</td>
                      <td class="px-4 py-2">--</td>
                      <td class="px-4 py-2"><?= number_format($meta->__get('meta_mensal'), 0, ',', '.') ?> L</td>
                      <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Ativa</span>
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
                    <tr>
                      <td class="px-4 py-2">💧 Consumo (<?= htmlspecialchars($consumo->__get('tipo')) ?>)</td>
                      <td class="px-4 py-2"><?= date('d/m/Y', strtotime($consumo->__get('data_consumo'))) ?></td>
                      <td class="px-4 py-2"><?= number_format($litros, 2, ',', '.') ?> L</td>
                      <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Registrado</span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>

              </tbody>
            </table>
          <?php else: ?>
            <div class="text-center py-8 text-gray-500">
              <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <p class="text-lg font-medium mb-2">Nenhum dado registrado ainda</p>
              <p class="text-sm">Comece registrando sua fatura, meta ou consumo diário!</p>
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