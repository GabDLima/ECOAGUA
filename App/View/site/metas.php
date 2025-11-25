<body class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 min-h-screen">
  <div id="main-content" class="flex-1 pt-20 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Metas de Economia</h2>
        <button onclick="window.location.href='/dashboard'" class="btn-eco bg-gray-600 hover:bg-gray-700 text-white">
          <i class="fas fa-arrow-left mr-2"></i>Voltar ao Dashboard
        </button>
      </div>

      <!-- Resumo das Metas com Dados Reais -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

        <!-- Card: Meta Atual -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0s;">
          <div class="flex items-center justify-between mb-4">
            <div class="eco-card-icon bg-blue-100">
              <i class="fas fa-bullseye text-blue-600"></i>
            </div>
          </div>
          <p class="text-sm text-gray-600 font-medium mb-1">Meta Atual</p>
          <p class="text-3xl font-bold text-gray-800">
            <?php if ($this->view->metaAtiva): ?>
              <?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?> L
            <?php else: ?>
              -- L
            <?php endif; ?>
          </p>
        </div>

        <!-- Card: Consumo Atual -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0.1s;">
          <div class="flex items-center justify-between mb-4">
            <div class="eco-card-icon <?= $this->view->progressoMeta && $this->view->progressoMeta['alerta'] ? 'bg-red-100' : 'bg-orange-100' ?>">
              <i class="fas fa-tint <?= $this->view->progressoMeta && $this->view->progressoMeta['alerta'] ? 'text-red-600' : 'text-orange-600' ?>"></i>
            </div>
            <?php if ($this->view->progressoMeta && $this->view->progressoMeta['alerta']): ?>
              <span class="eco-badge eco-badge-danger">
                <i class="fas fa-exclamation-triangle"></i> Alerta
              </span>
            <?php endif; ?>
          </div>
          <p class="text-sm text-gray-600 font-medium mb-1">Consumo Atual</p>
          <p class="text-3xl font-bold <?= $this->view->progressoMeta && $this->view->progressoMeta['alerta'] ? 'text-red-600' : 'text-orange-600' ?>">
            <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?> L
          </p>
        </div>

        <!-- Card: Economia Esperada -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0.2s;">
          <div class="flex items-center justify-between mb-4">
            <div class="eco-card-icon bg-green-100">
              <i class="fas fa-arrow-down text-green-600"></i>
            </div>
          </div>
          <p class="text-sm text-gray-600 font-medium mb-1">Economia Esperada</p>
          <p class="text-3xl font-bold text-green-600">
            <?= $this->view->economiaEsperada ?>%
          </p>
        </div>

        <!-- Card: Status -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0.3s;">
          <div class="flex items-center justify-between mb-4">
            <div class="eco-card-icon <?php
              if ($this->view->statusGeral == 'Dentro da Meta') echo 'bg-green-100';
              elseif ($this->view->statusGeral == 'Próximo ao Limite') echo 'bg-yellow-100';
              elseif ($this->view->statusGeral == 'Acima da Meta') echo 'bg-red-100';
              else echo 'bg-gray-100';
            ?>">
              <i class="fas fa-flag <?php
                if ($this->view->statusGeral == 'Dentro da Meta') echo 'text-green-600';
                elseif ($this->view->statusGeral == 'Próximo ao Limite') echo 'text-yellow-600';
                elseif ($this->view->statusGeral == 'Acima da Meta') echo 'text-red-600';
                else echo 'text-gray-600';
              ?>"></i>
            </div>
          </div>
          <p class="text-sm text-gray-600 font-medium mb-1">Status</p>
          <p class="text-xl font-bold <?php
            if ($this->view->statusGeral == 'Dentro da Meta') echo 'text-green-600';
            elseif ($this->view->statusGeral == 'Próximo ao Limite') echo 'text-yellow-600';
            elseif ($this->view->statusGeral == 'Acima da Meta') echo 'text-red-600';
            else echo 'text-gray-600';
          ?>">
            <?= $this->view->statusGeral ?>
          </p>
        </div>
      </div>

      <!-- Progress Bar da Meta Atual -->
      <?php if ($this->view->progressoMeta): ?>
        <div class="eco-card animate-fade-in mb-8" style="animation-delay: 0.4s;">
          <div class="flex items-center mb-6">
            <div class="eco-card-icon bg-blue-100 mr-4">
              <i class="fas fa-chart-bar text-blue-600"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-800">Progresso da Meta Atual</h3>
          </div>
          <div>
            <div class="flex justify-between mb-3">
              <span class="text-sm font-semibold text-gray-700">
                <i class="fas fa-bullseye mr-2 text-blue-600"></i>
                Meta do Mês: <?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?>L
              </span>
              <span class="text-sm font-semibold <?= $this->view->progressoMeta['alerta'] ? 'text-red-600' : 'text-green-600' ?>">
                <?= number_format($this->view->progressoMeta['consumo_atual'], 0, ',', '.') ?>L /
                <?= $this->view->progressoMeta['percentual'] ?>%
              </span>
            </div>
            <div class="eco-progress">
              <div class="eco-progress-bar <?= $this->view->progressoMeta['alerta'] ? 'eco-progress-danger' : ($this->view->progressoMeta['percentual'] > 80 ? 'eco-progress-warning' : 'eco-progress-success') ?>"
                   style="width: <?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
            </div>
            <div class="mt-4 p-4 rounded-lg <?= $this->view->progressoMeta['restante'] > 0 ? 'bg-green-50 border-l-4 border-green-500' : 'bg-red-50 border-l-4 border-red-500' ?>">
              <?php if ($this->view->progressoMeta['restante'] > 0): ?>
                <p class="text-green-800 font-medium flex items-center">
                  <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                  <span>Restam <strong><?= number_format($this->view->progressoMeta['restante'], 0, ',', '.') ?>L</strong> para atingir a meta</span>
                </p>
              <?php else: ?>
                <p class="text-red-800 font-medium flex items-center">
                  <i class="fas fa-exclamation-triangle text-red-500 mr-3 text-xl"></i>
                  <span>Você ultrapassou a meta em <strong><?= number_format(abs($this->view->progressoMeta['restante']), 0, ',', '.') ?>L</strong></span>
                </p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Histórico de Metas Mensais -->
      <?php if (!empty($this->view->historicoMetas)): ?>
        <div class="eco-card animate-fade-in mb-8" style="animation-delay: 0.5s;">
          <div class="flex items-center mb-6">
            <div class="eco-card-icon bg-purple-100 mr-4">
              <i class="fas fa-calendar-alt text-purple-600"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-800">Histórico de Metas Mensais</h3>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-gradient-to-r from-blue-50 to-cyan-50">
                <tr>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-calendar mr-2"></i>Mês/Ano
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-bullseye mr-2"></i>Meta (L)
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-tint mr-2"></i>Consumo Real (L)
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-chart-line mr-2"></i>Diferença (L)
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-percentage mr-2"></i>% Atingida
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-flag mr-2"></i>Status
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php foreach ($this->view->historicoMetas as $index => $historico): ?>
                  <tr class="hover:bg-blue-50 transition-colors <?= $index == count($this->view->historicoMetas) - 1 ? 'bg-blue-50' : '' ?>">
                    <td class="px-4 py-3 <?= $index == count($this->view->historicoMetas) - 1 ? 'font-semibold text-gray-800' : 'text-gray-700' ?>">
                      <?= ucfirst($historico['mes_nome']) ?>
                    </td>
                    <td class="px-4 py-3 <?= $index == count($this->view->historicoMetas) - 1 ? 'font-semibold text-gray-800' : 'text-gray-700' ?>">
                      <?= number_format($historico['meta_litros'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-3 <?= $index == count($this->view->historicoMetas) - 1 ? 'font-semibold text-gray-800' : 'text-gray-700' ?>">
                      <?= number_format($historico['consumo_real'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-3 <?= $historico['diferenca'] > 0 ? 'text-red-600' : 'text-green-600' ?> font-semibold">
                      <?= $historico['diferenca'] > 0 ? '+' : '' ?><?= number_format($historico['diferenca'], 0, ',', '.') ?>
                    </td>
                    <td class="px-4 py-3 <?= $historico['percentual'] > 100 ? 'text-red-600' : 'text-green-600' ?> font-semibold">
                      <?= $historico['percentual'] ?>%
                    </td>
                    <td class="px-4 py-3">
                      <?php if ($index == count($this->view->historicoMetas) - 1): ?>
                        <span class="eco-badge eco-badge-warning">
                          <i class="fas fa-clock"></i> Em Andamento
                        </span>
                      <?php elseif ($historico['status'] == 'atingida'): ?>
                        <span class="eco-badge eco-badge-success">
                          <i class="fas fa-check-circle"></i> Atingida
                        </span>
                      <?php else: ?>
                        <span class="eco-badge eco-badge-danger">
                          <i class="fas fa-times-circle"></i> Não Atingida
                        </span>
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
        <div class="eco-card animate-fade-in mb-8" style="animation-delay: 0.6s;">
          <div class="flex items-center mb-6">
            <div class="eco-card-icon bg-cyan-100 mr-4">
              <i class="fas fa-folder-open text-cyan-600"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-800">Metas por Categoria de Uso</h3>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-gradient-to-r from-blue-50 to-cyan-50">
                <tr>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-tag mr-2"></i>Categoria
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-bullseye mr-2"></i>Meta Estimada (L)
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-tint mr-2"></i>Consumo Atual (L)
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-percentage mr-2"></i>% da Meta
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-chart-bar mr-2"></i>Progresso
                  </th>
                  <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                    <i class="fas fa-flag mr-2"></i>Status
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php
                $cores = ['bg-blue-900', 'bg-blue-700', 'bg-blue-500', 'bg-blue-400', 'bg-blue-300'];
                $cor_index = 0;
                ?>
                <?php foreach ($this->view->metasPorCategoria as $categoria): ?>
                  <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-4 py-3">
                      <div class="flex items-center font-medium text-gray-800">
                        <div class="w-3 h-3 <?= $cores[$cor_index % count($cores)] ?> rounded mr-3"></div>
                        <?= htmlspecialchars($categoria['tipo']) ?>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-gray-700"><?= number_format($categoria['meta'], 0, ',', '.') ?></td>
                    <td class="px-4 py-3 font-semibold text-gray-800"><?= number_format($categoria['consumo'], 0, ',', '.') ?></td>
                    <td class="px-4 py-3 <?= $categoria['status'] == 'acima' ? 'text-red-600' : 'text-green-600' ?> font-semibold">
                      <?= $categoria['percentual'] ?>%
                    </td>
                    <td class="px-4 py-3">
                      <div class="eco-progress" style="height: 0.5rem;">
                        <div class="eco-progress-bar <?= $categoria['status'] == 'acima' ? 'eco-progress-danger' : 'eco-progress-success' ?>"
                             style="width: <?= min($categoria['percentual'], 100) ?>%"></div>
                      </div>
                    </td>
                    <td class="px-4 py-3">
                      <?php if ($categoria['status'] == 'ok'): ?>
                        <span class="eco-badge eco-badge-success">
                          <i class="fas fa-check"></i> No Alvo
                        </span>
                      <?php else: ?>
                        <span class="eco-badge eco-badge-danger">
                          <i class="fas fa-exclamation-triangle"></i> Acima
                        </span>
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
        <div class="eco-card animate-fade-in">
          <div class="eco-empty-state py-12">
            <div class="eco-empty-icon text-blue-400">
              <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 class="eco-empty-title">Nenhuma meta definida</h3>
            <p class="eco-empty-text">Comece definindo sua primeira meta de economia de água e acompanhe seu progresso!</p>
            <button onclick="window.location.href='/consumo'" class="btn-eco btn-eco-primary mt-6">
              <i class="fas fa-plus-circle mr-2"></i>Definir Primeira Meta
            </button>
          </div>
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