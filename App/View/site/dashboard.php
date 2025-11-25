<?php include __DIR__ . '/../includes/mensagens.php'; ?>

<style>
  @keyframes bounce-subtle {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
  }
  .bounce-subtle { animation: bounce-subtle 2s infinite; }
  
  @keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 20px rgba(30, 58, 138, 0.4); }
    50% { box-shadow: 0 0 30px rgba(30, 58, 138, 0.6), 0 0 40px rgba(30, 58, 138, 0.3); }
  }
  .pulse-glow { animation: pulse-glow 2s infinite; }
</style>

<body class="bg-gray-50">
  <div id="main-content" class="flex-1 pt-20 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">
        Bem-vindo à sua Dashboard, <?= htmlspecialchars($this->view->nome_usuario) ?>!
      </h2>

      <!-- Cards Principais com Dados Reais -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">

        <!-- Card: Consumo do Mês Atual -->
        <div class="eco-card animate-fade-in">
          <div class="flex items-center justify-between mb-4">
            <div class="eco-card-icon bg-blue-100">
              <i class="fas fa-tint text-blue-600"></i>
            </div>
            <?php if ($this->view->variacaoPercentual < 0): ?>
              <span class="eco-badge eco-badge-success">
                <i class="fas fa-arrow-down mr-1"></i><?= abs($this->view->variacaoPercentual) ?>%
              </span>
            <?php elseif ($this->view->variacaoPercentual > 0): ?>
              <span class="eco-badge eco-badge-danger">
                <i class="fas fa-arrow-up mr-1"></i><?= abs($this->view->variacaoPercentual) ?>%
              </span>
            <?php endif; ?>
          </div>
          <p class="text-sm text-gray-500 font-medium mb-1">Consumo do Mês</p>
          <p class="text-3xl font-bold text-gray-800 mb-2 counter" data-target="<?= $this->view->totalMesAtual ?>">
            <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?> L
          </p>
          <div class="flex items-center text-sm">
            <?php if ($this->view->variacaoPercentual > 0): ?>
              <span class="text-red-600">
                <i class="fas fa-arrow-up mr-1"></i>vs mês anterior
              </span>
            <?php elseif ($this->view->variacaoPercentual < 0): ?>
              <span class="text-green-600">
                <i class="fas fa-arrow-down mr-1"></i>vs mês anterior
              </span>
            <?php else: ?>
              <span class="text-gray-600">Sem variação</span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Card: Projeção Mensal -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0.1s;">
          <div class="eco-card-icon bg-purple-100 mb-4">
            <i class="fas fa-chart-line text-purple-600"></i>
          </div>
          <p class="text-sm text-gray-500 font-medium mb-1">Projeção do Mês</p>
          <p class="text-3xl font-bold text-gray-800 mb-2">
            <?= number_format($this->view->projecaoMensal, 0, ',', '.') ?> L
          </p>
          <p class="text-sm text-gray-600">Estimativa para o fim do mês</p>
        </div>

        <!-- Card: Última Fatura -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0.2s;">
          <div class="eco-card-icon bg-green-100 mb-4">
            <i class="fas fa-dollar-sign text-green-600"></i>
          </div>
          <p class="text-sm text-gray-500 font-medium mb-1">Última Fatura</p>
          <p class="text-3xl font-bold text-gray-800 mb-2">
            <?php if ($this->view->ultimaFatura): ?>
              R$ <?= number_format($this->view->ultimaFatura['valor'], 2, ',', '.') ?>
            <?php else: ?>
              R$ 0,00
            <?php endif; ?>
          </p>
          <p class="text-sm text-gray-600">
            <?php if ($this->view->ultimaFatura): ?>
              <?= date('m/Y', strtotime($this->view->ultimaFatura['mes_da_fatura'])) ?>
            <?php else: ?>
              Sem dados
            <?php endif; ?>
          </p>
        </div>

        <!-- Card: Meta do Mês -->
        <div class="eco-card animate-fade-in" style="animation-delay: 0.3s;">
          <div class="eco-card-icon bg-orange-100 mb-4">
            <i class="fas fa-bullseye text-orange-600"></i>
          </div>
          <p class="text-sm text-gray-500 font-medium mb-1">Meta do Mês</p>
          <?php if ($this->view->progressoMeta): ?>
            <p class="text-3xl font-bold text-gray-800 mb-3">
              <?= $this->view->progressoMeta['percentual'] ?>%
            </p>
            <div class="eco-progress mb-2">
              <div class="eco-progress-bar <?= $this->view->progressoMeta['alerta'] ? 'eco-progress-danger' : ($this->view->progressoMeta['percentual'] > 80 ? 'eco-progress-warning' : 'eco-progress-success') ?>"
                   style="width: <?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
            </div>
            <p class="text-sm text-gray-600">
              <?= number_format($this->view->progressoMeta['consumo_atual'], 0) ?> /
              <?= number_format($this->view->progressoMeta['meta_litros'], 0) ?> L
            </p>
          <?php else: ?>
            <p class="text-xl font-bold mb-2">Sem meta</p>
            <p class="text-sm text-gray-600 mb-3">Defina sua meta em Metas</p>
            <a href="/metas" class="btn-eco btn-eco-primary text-sm py-2">
              <i class="fas fa-bullseye mr-2"></i>Definir Meta
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Alertas Melhorados -->
      <?php if (!empty($this->view->alertas)): ?>
        <div class="mb-8 space-y-4">
          <?php foreach ($this->view->alertas as $alerta): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-r-lg animate-slide-in-right">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                  </div>
                </div>
                <div class="ml-4 flex-1">
                  <h4 class="font-semibold text-red-800 mb-1">
                    <?= $alerta['tipo'] == 'meta' ? 'Meta Ultrapassada' : 'Alerta de Consumo' ?>
                  </h4>
                  <p class="text-red-700 text-sm"><?= htmlspecialchars($alerta['mensagem']) ?></p>
                  <?php if ($alerta['tipo'] == 'meta'): ?>
                    <button onclick="window.location.href='/metas'" class="mt-3 text-sm text-red-600 hover:text-red-800 font-medium underline inline-flex items-center">
                      <i class="fas fa-arrow-right mr-1"></i>Ver Metas
                    </button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Dicas de Economia -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-semibold text-blue-900 mb-4"><i class="fas fa-chart-bar"></i> Estatísticas Rápidas</h3>
          <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded">
              <div class="text-2xl font-bold text-blue-900">
                R$ <?= number_format($this->view->mediaMensal, 2, ',', '.') ?>
              </div>
              <div class="text-sm text-gray-600">Média Mensal</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded">
              <div class="text-2xl font-bold text-green-900">
                R$ <?= number_format($this->view->totalGastoAno, 2, ',', '.') ?>
              </div>
              <div class="text-sm text-gray-600">Total no Ano</div>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded">
              <div class="text-2xl font-bold text-purple-900">
                <?= number_format($this->view->totalMesAnterior, 0, ',', '.') ?> L
              </div>
              <div class="text-sm text-gray-600">Mês Anterior</div>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3"><i class="fas fa-lightbulb"></i> Dicas de Economia</div>
          <ul class="list-disc list-inside text-gray-700 space-y-1 p-4">
            <?php if (!empty($this->view->dicas)): ?>
              <?php foreach ($this->view->dicas as $dica): ?>
                <li class="text-sm"><?= htmlspecialchars($dica->__get('dicas_desc')) ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li>Nenhuma dica disponível</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <!-- Gráficos com Dados Reais -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        
        <!-- Gráfico de Linha: Consumo Mensal -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
          <h3 class="text-lg font-medium text-blue-900 mb-4"><i class="fas fa-chart-line"></i> Consumo Mensal (Litros)</h3>
          <div style="width: 500px; height: 500px; max-width: 100%;">
            <canvas id="lineChart"></canvas>
          </div>
        </div>

        <!-- Gráfico de Linha: Faturas -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
          <h3 class="text-lg font-medium text-blue-900 mb-4"><i class="fas fa-dollar-sign"></i> Valor das Faturas (R$)</h3>
          <div style="width: 500px; height: 500px; max-width: 100%;">
            <canvas id="lineChartFaturas"></canvas>
          </div>
        </div>

        <!-- Gráfico Pizza: Consumo por Tipo -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
          <h3 class="text-lg font-medium text-blue-900 mb-4"><i class="fas fa-chart-pie"></i> Consumo por Tipo</h3>
          <div style="width: 500px; height: 500px; max-width: 100%;">
            <canvas id="pieChart"></canvas>
          </div>
        </div>

        <!-- Gráfico Rosca: Distribuição Detalhada -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
          <h3 class="text-lg font-medium text-blue-900 mb-4"><i class="fas fa-chart-donut"></i> Distribuição Detalhada</h3>
          <div style="width: 500px; height: 500px; max-width: 100%;">
            <canvas id="doughnutChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Tabela: Últimos 7 Dias -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-3 bg-blue-900 text-white font-medium"><i class="fas fa-list"></i> Consumo Diário (Últimos 7 dias)</div>
        <div class="p-4 overflow-x-auto">
          <?php if (!empty($this->view->ultimos7dias)): ?>
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Data</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tipo</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Quantidade</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Em Litros</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php foreach ($this->view->ultimos7dias as $consumo): ?>
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
                    <td class="px-4 py-2">
                      <?= date('d/m/Y', strtotime($consumo->__get('data_consumo'))) ?>
                    </td>
                    <td class="px-4 py-2"><?= htmlspecialchars($consumo->__get('tipo')) ?></td>
                    <td class="px-4 py-2">
                      <?= number_format($quantidade, 2, ',', '.') ?> <?= $unidade ?>
                    </td>
                    <td class="px-4 py-2 font-semibold">
                      <?= number_format($litros, 2, ',', '.') ?> L
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <div class="eco-empty-state">
              <div class="eco-empty-icon">
                <i class="fas fa-droplet-slash"></i>
              </div>
              <h3 class="eco-empty-title">Nenhum consumo registrado</h3>
              <p class="eco-empty-text">Comece registrando seu consumo diário para acompanhar seus gastos de água</p>
              <button onclick="window.location.href='/consumo'" class="btn-eco btn-eco-primary">
                <i class="fas fa-plus mr-2"></i>Registrar Primeiro Consumo
              </button>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      
      // === DADOS DO PHP PARA JAVASCRIPT ===
      const graficoLinhaLabels = <?= $this->view->graficoLinhaLabels ?>;
      const graficoLinhaData = <?= $this->view->graficoLinhaData ?>;
      const graficoPizzaLabels = <?= $this->view->graficoPizzaLabels ?>;
      const graficoPizzaData = <?= $this->view->graficoPizzaData ?>;
      const graficoBarraLabels = <?= $this->view->graficoBarraLabels ?>;
      const graficoBarraData = <?= $this->view->graficoBarraData ?>;

      // === GRÁFICO DE LINHA: Consumo Mensal ===
      const ctxLine = document.getElementById('lineChart');
      if (ctxLine && graficoLinhaLabels.length > 0) {
        new Chart(ctxLine, {
          type: 'line',
          data: {
            labels: graficoLinhaLabels,
            datasets: [{
              label: 'Consumo (L)',
              data: graficoLinhaData,
              borderColor: 'rgba(30,60,114,1)',
              backgroundColor: 'rgba(30,60,114,0.1)',
              tension: 0.4,
              fill: true,
              pointRadius: 5,
              pointHoverRadius: 7
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
              legend: { display: true },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    return 'Consumo: ' + context.parsed.y.toLocaleString('pt-BR') + ' L';
                  }
                }
              }
            },
            scales: { 
              y: { 
                beginAtZero: false,
                ticks: {
                  callback: function(value) {
                    return value.toLocaleString('pt-BR') + ' L';
                  }
                }
              } 
            }
          }
        });
      }

      // === GRÁFICO PIZZA: Consumo por Tipo ===
      const ctxPie = document.getElementById('pieChart');
      if (ctxPie && graficoPizzaLabels.length > 0) {
        new Chart(ctxPie, {
          type: 'pie',
          data: {
            labels: graficoPizzaLabels,
            datasets: [{
              data: graficoPizzaData,
              backgroundColor: [
                '#1e3c72', '#3c78b4', '#5fa5e5', '#78b4f0', 
                '#91c4ff', '#aad4ff', '#c3e4ff'
              ]
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
              legend: { position: 'bottom' },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    return context.label + ': ' + context.parsed.toLocaleString('pt-BR') + ' L';
                  }
                }
              }
            }
          }
        });
      }

      // === GRÁFICO DE LINHA: Faturas ===
      const ctxLineFaturas = document.getElementById('lineChartFaturas');
      if (ctxLineFaturas && graficoBarraLabels.length > 0) {
        new Chart(ctxLineFaturas, {
          type: 'line',
          data: {
            labels: graficoBarraLabels,
            datasets: [{
              label: 'Valor (R$)',
              data: graficoBarraData,
              borderColor: 'rgba(220, 38, 38, 1)',
              backgroundColor: 'rgba(220, 38, 38, 0.1)',
              tension: 0.4,
              fill: true,
              pointRadius: 5,
              pointHoverRadius: 7,
              pointBackgroundColor: 'rgba(220, 38, 38, 1)'
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
              legend: { display: true },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    return 'R$ ' + context.parsed.y.toLocaleString('pt-BR', {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2
                    });
                  }
                }
              }
            },
            scales: { 
              y: { 
                beginAtZero: true,
                ticks: {
                  callback: function(value) {
                    return 'R$ ' + value.toLocaleString('pt-BR');
                  }
                }
              } 
            }
          }
        });
      }

      // === GRÁFICO ROSCA: Mesmos dados da pizza ===
      const ctxDonut = document.getElementById('doughnutChart');
      if (ctxDonut && graficoPizzaLabels.length > 0) {
        new Chart(ctxDonut, {
          type: 'doughnut',
          data: {
            labels: graficoPizzaLabels,
            datasets: [{
              data: graficoPizzaData,
              backgroundColor: [
                '#1e3c72', '#3c78b4', '#5fa5e5', '#78b4f0',
                '#91c4ff', '#aad4ff', '#c3e4ff'
              ]
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
              legend: { position: 'bottom' },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percent = ((context.parsed / total) * 100).toFixed(1);
                    return context.label + ': ' + context.parsed.toLocaleString('pt-BR') + ' L (' + percent + '%)';
                  }
                }
              }
            }
          }
        });
      }

    });
  </script>
</body>
</html>