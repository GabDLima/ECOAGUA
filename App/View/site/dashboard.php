<?php
session_start();
if(isset($_SESSION['login_realizado'])){
  if($_SESSION['login_realizado'] == 1){
    echo '<script>alert("Login realizado com sucesso!");</script>';
    $_SESSION['login_realizado'] = 0;
  }
}
?>

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
  <div id="main-content" class="flex-1 pt-16 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">
        Bem-vindo à sua Dashboard, <?= htmlspecialchars($this->view->nome_usuario) ?>!
      </h2>

      <!-- Cards Principais com Dados Reais -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Card: Consumo do Mês Atual -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Consumo do Mês</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">
              <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?> L
            </div>
            <p class="text-gray-600">
              <?php if ($this->view->variacaoPercentual > 0): ?>
                <span class="text-red-600">▲ <?= abs($this->view->variacaoPercentual) ?>%</span> vs mês anterior
              <?php elseif ($this->view->variacaoPercentual < 0): ?>
                <span class="text-green-600">▼ <?= abs($this->view->variacaoPercentual) ?>%</span> vs mês anterior
              <?php else: ?>
                <span class="text-gray-600">Sem variação</span>
              <?php endif; ?>
            </p>
          </div>
        </div>

        <!-- Card: Projeção Mensal -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Projeção do Mês</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">
              <?= number_format($this->view->projecaoMensal, 0, ',', '.') ?> L
            </div>
            <p class="text-gray-600">Estimativa para o fim do mês</p>
          </div>
        </div>

        <!-- Card: Última Fatura -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Última Fatura</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">
              <?php if ($this->view->ultimaFatura): ?>
                R$ <?= number_format($this->view->ultimaFatura['valor'], 2, ',', '.') ?>
              <?php else: ?>
                R$ 0,00
              <?php endif; ?>
            </div>
            <p class="text-gray-600">
              <?php if ($this->view->ultimaFatura): ?>
                <?= date('m/Y', strtotime($this->view->ultimaFatura['mes_da_fatura'])) ?>
              <?php else: ?>
                Sem dados
              <?php endif; ?>
            </p>
          </div>
        </div>

        <!-- Card: Meta do Mês -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Meta do Mês</div>
          <div class="p-4">
            <?php if ($this->view->progressoMeta): ?>
              <div class="text-3xl font-bold mb-2">
                <?= $this->view->progressoMeta['percentual'] ?>%
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: <?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
              </div>
              <p class="text-gray-600 text-sm">
                <?= number_format($this->view->progressoMeta['consumo_atual'], 0) ?> / 
                <?= number_format($this->view->progressoMeta['meta_litros'], 0) ?> L
              </p>
            <?php else: ?>
              <div class="text-xl font-bold mb-2">Sem meta</div>
              <p class="text-gray-600">Defina sua meta em Metas</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Alertas -->
      <?php if (!empty($this->view->alertas)): ?>
        <div class="mb-6">
          <?php foreach ($this->view->alertas as $alerta): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-3 rounded">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-red-800 font-semibold"><?= htmlspecialchars($alerta['mensagem']) ?></p>
                </div>
                <?php if ($alerta['tipo'] == 'meta'): ?>
                  <div class="ml-auto">
                    <button onclick="window.location.href='/metas'" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                      Ver Metas
                    </button>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Dicas de Economia -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-semibold text-blue-900 mb-4">📊 Estatísticas Rápidas</h3>
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
          <div class="bg-blue-900 text-white px-4 py-3">💡 Dicas de Economia</div>
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
          <h3 class="text-lg font-medium text-blue-900 mb-4">📈 Consumo Mensal (Litros)</h3>
          <div style="width: 500px; height: 500px; max-width: 100%;">
            <canvas id="lineChart"></canvas>
          </div>
        </div>

        <!-- Gráfico de Linha: Faturas -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
          <h3 class="text-lg font-medium text-blue-900 mb-4">💰 Valor das Faturas (R$)</h3>
          <div style="width: 500px; height: 500px; max-width: 100%;">
            <canvas id="lineChartFaturas"></canvas>
          </div>
        </div>

        <!-- Gráfico Pizza: Consumo por Tipo -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
          <h3 class="text-lg font-medium text-blue-900 mb-4">🥧 Consumo por Tipo</h3>
          <div style="width: 500px; height: 500px; max-width: 100%;">
            <canvas id="pieChart"></canvas>
          </div>
        </div>

        <!-- Gráfico Rosca: Distribuição Detalhada -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
          <h3 class="text-lg font-medium text-blue-900 mb-4">🍩 Distribuição Detalhada</h3>
          <div style="width: 500px; height: 500px; max-width: 100%;">
            <canvas id="doughnutChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Tabela: Últimos 7 Dias -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-3 bg-blue-900 text-white font-medium">📋 Consumo Diário (Últimos 7 dias)</div>
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
            <div class="text-center py-8 text-gray-500">
              <p>Nenhum consumo registrado nos últimos 7 dias.</p>
              <button onclick="window.location.href='/consumo'" class="mt-4 bg-blue-900 hover:bg-blue-800 text-white px-6 py-2 rounded">
                Registrar Consumo
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