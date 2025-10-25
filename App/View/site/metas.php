<body class="bg-gray-50">
  <div id="main-content" class="flex-1 pt-16 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-blue-900">Metas de Economia</h2>
        <button onclick="window.location.href='/dashboard'" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
          ← Voltar ao Dashboard
        </button>
      </div>

      <!-- Resumo das Metas com Dados Reais -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        
        <!-- Card: Meta Atual -->
        <div class="bg-white shadow rounded-lg p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Meta Atual</p>
              <p class="text-2xl font-bold text-blue-900">
                <?php if ($this->view->metaAtiva): ?>
                  <?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?> L
                <?php else: ?>
                  -- L
                <?php endif; ?>
              </p>
            </div>
            <div class="text-blue-500">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
              </svg>
            </div>
          </div>
        </div>

        <!-- Card: Consumo Atual -->
        <div class="bg-white shadow rounded-lg p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Consumo Atual</p>
              <p class="text-2xl font-bold <?= $this->view->progressoMeta && $this->view->progressoMeta['alerta'] ? 'text-red-600' : 'text-orange-600' ?>">
                <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?> L
              </p>
            </div>
            <div class="<?= $this->view->progressoMeta && $this->view->progressoMeta['alerta'] ? 'text-red-500' : 'text-orange-500' ?>">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
            </div>
          </div>
        </div>

        <!-- Card: Economia Esperada -->
        <div class="bg-white shadow rounded-lg p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Economia Esperada</p>
              <p class="text-2xl font-bold text-green-600">
                <?= $this->view->economiaEsperada ?>%
              </p>
            </div>
            <div class="text-green-500">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
              </svg>
            </div>
          </div>
        </div>

        <!-- Card: Status -->
        <div class="bg-white shadow rounded-lg p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Status</p>
              <p class="text-lg font-bold <?php 
                if ($this->view->statusGeral == 'Dentro da Meta') echo 'text-green-600';
                elseif ($this->view->statusGeral == 'Próximo ao Limite') echo 'text-yellow-600';
                elseif ($this->view->statusGeral == 'Acima da Meta') echo 'text-red-600';
                else echo 'text-gray-600';
              ?>">
                <?= $this->view->statusGeral ?>
              </p>
            </div>
            <div class="<?php 
              if ($this->view->statusGeral == 'Dentro da Meta') echo 'text-green-500';
              elseif ($this->view->statusGeral == 'Próximo ao Limite') echo 'text-yellow-500';
              elseif ($this->view->statusGeral == 'Acima da Meta') echo 'text-red-500';
              else echo 'text-gray-500';
            ?>">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Progress Bar da Meta Atual -->
      <?php if ($this->view->progressoMeta): ?>
        <div class="bg-white shadow rounded-lg p-6 mb-6">
          <h3 class="text-lg font-medium text-blue-900 mb-4">📊 Progresso da Meta Atual</h3>
          <div>
            <div class="flex justify-between mb-2">
              <span class="text-sm font-medium text-gray-700">
                Meta do Mês (<?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?>L)
              </span>
              <span class="text-sm text-gray-600">
                <?= number_format($this->view->progressoMeta['consumo_atual'], 0, ',', '.') ?>L / 
                <?= $this->view->progressoMeta['percentual'] ?>%
              </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
              <div class="<?= $this->view->progressoMeta['alerta'] ? 'bg-red-500' : ($this->view->progressoMeta['percentual'] > 80 ? 'bg-yellow-500' : 'bg-green-500') ?> h-4 rounded-full transition-all duration-500" 
                   style="width: <?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
            </div>
            <div class="mt-2 text-sm text-gray-600">
              <?php if ($this->view->progressoMeta['restante'] > 0): ?>
                <span class="text-green-600">✓ Restam <?= number_format($this->view->progressoMeta['restante'], 0, ',', '.') ?>L para atingir a meta</span>
              <?php else: ?>
                <span class="text-red-600">⚠ Você ultrapassou a meta em <?= number_format(abs($this->view->progressoMeta['restante']), 0, ',', '.') ?>L</span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Histórico de Metas Mensais -->
      <?php if (!empty($this->view->historicoMetas)): ?>
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
          <div class="px-6 py-3 bg-blue-900 text-white font-medium">📅 Histórico de Metas Mensais</div>
          <div class="p-4 overflow-x-auto">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Mês/Ano</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Meta (L)</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Consumo Real (L)</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Diferença (L)</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">% Atingida</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php foreach ($this->view->historicoMetas as $index => $historico): ?>
                  <tr class="hover:bg-gray-50 <?= $index == count($this->view->historicoMetas) - 1 ? 'bg-blue-50' : '' ?>">
                    <td class="px-4 py-2 <?= $index == count($this->view->historicoMetas) - 1 ? 'font-semibold' : '' ?>">
                      <?= ucfirst($historico['mes_nome']) ?>
                    </td>
                    <td class="px-4 py-2 <?= $index == count($this->view->historicoMetas) - 1 ? 'font-semibold' : '' ?>">
                      <?= number_format($historico['meta_litros'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-2 <?= $index == count($this->view->historicoMetas) - 1 ? 'font-semibold' : '' ?>">
                      <?= number_format($historico['consumo_real'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-2 <?= $historico['diferenca'] > 0 ? 'text-red-600' : 'text-green-600' ?> <?= $index == count($this->view->historicoMetas) - 1 ? 'font-semibold' : '' ?>">
                      <?= $historico['diferenca'] > 0 ? '+' : '' ?><?= number_format($historico['diferenca'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-2 <?= $historico['percentual'] > 100 ? 'text-red-600' : 'text-green-600' ?> <?= $index == count($this->view->historicoMetas) - 1 ? 'font-semibold' : '' ?>">
                      <?= $historico['percentual'] ?>%
                    </td>
                    <td class="px-4 py-2">
                      <?php if ($index == count($this->view->historicoMetas) - 1): ?>
                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">Em Andamento</span>
                      <?php elseif ($historico['status'] == 'atingida'): ?>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Atingida</span>
                      <?php else: ?>
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Não Atingida</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>

      <!-- Metas por Categoria -->
      <?php if (!empty($this->view->metasPorCategoria)): ?>
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
          <div class="px-6 py-3 bg-blue-900 text-white font-medium">📂 Metas por Categoria de Uso</div>
          <div class="p-4 overflow-x-auto">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Categoria</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Meta Estimada (L)</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Consumo Atual (L)</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">% da Meta</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Progresso</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php 
                $cores = ['bg-blue-900', 'bg-blue-700', 'bg-blue-500', 'bg-blue-400', 'bg-blue-300'];
                $cor_index = 0;
                ?>
                <?php foreach ($this->view->metasPorCategoria as $categoria): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">
                      <div class="flex items-center">
                        <div class="w-3 h-3 <?= $cores[$cor_index % count($cores)] ?> rounded mr-2"></div>
                        <?= htmlspecialchars($categoria['tipo']) ?>
                      </div>
                    </td>
                    <td class="px-4 py-2"><?= number_format($categoria['meta'], 0, ',', '.') ?></td>
                    <td class="px-4 py-2"><?= number_format($categoria['consumo'], 0, ',', '.') ?></td>
                    <td class="px-4 py-2 <?= $categoria['status'] == 'acima' ? 'text-red-600' : 'text-green-600' ?>">
                      <?= $categoria['percentual'] ?>%
                    </td>
                    <td class="px-4 py-2">
                      <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="<?= $categoria['status'] == 'acima' ? 'bg-red-500' : 'bg-green-500' ?> h-2 rounded-full" 
                             style="width: <?= min($categoria['percentual'], 100) ?>%"></div>
                      </div>
                    </td>
                    <td class="px-4 py-2">
                      <?php if ($categoria['status'] == 'ok'): ?>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">No Alvo</span>
                      <?php else: ?>
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Acima</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php $cor_index++; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>

      <!-- Mensagem se não houver metas -->
      <?php if (!$this->view->metaAtiva): ?>
        <div class="bg-white shadow rounded-lg p-8 text-center">
          <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma meta definida</h3>
          <p class="text-gray-600 mb-6">Comece definindo sua primeira meta de economia de água!</p>
          <button onclick="window.location.href='/consumo'" class="bg-blue-900 hover:bg-blue-800 text-white px-6 py-3 rounded-lg">
            Definir Primeira Meta
          </button>
        </div>
      <?php endif; ?>

    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Animação das progress bars
      const progressBars = document.querySelectorAll('.progress-bar, [class*="bg-"][class*="-500"]');
      progressBars.forEach(bar => {
        if (bar.style.width) {
          const width = bar.style.width;
          bar.style.width = '0%';
          setTimeout(() => {
            bar.style.width = width;
            bar.classList.add('transition-all', 'duration-1000');
          }, 100);
        }
      });
    });
  </script>
</body>
</html>