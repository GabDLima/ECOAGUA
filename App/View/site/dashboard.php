<?php include __DIR__ . '/../includes/mensagens.php'; ?>

<style>
  @keyframes countUp {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .stat-value { animation: countUp 0.5s ease-out both; }
</style>

<body class="bg-gray-50">
<div id="main-content" class="flex-1 pt-20 transition-[margin] duration-300">
  <main class="px-6 py-6" style="max-width: 1400px; margin: 0 auto;">

    <!-- ── Cabeçalho da página ── -->
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-2xl font-bold text-blue-900">
          Olá, <?= htmlspecialchars(explode(' ', $this->view->nome_usuario)[0]) ?>! 👋
        </h1>
        <p class="text-gray-400 text-sm mt-1">
          <i class="fas fa-calendar-day mr-1"></i>
          <?php
            $dias   = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
            $meses  = ['','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
            echo $dias[date('w')] . ', ' . date('d') . ' de ' . $meses[date('n')] . ' de ' . date('Y');
          ?>
        </p>
      </div>
      <a href="/consumo" class="btn-eco btn-eco-primary" style="padding: 0.6rem 1.2rem; font-size:0.9rem;">
        <i class="fas fa-plus mr-2"></i>Registrar consumo
      </a>
    </div>

    <!-- ── Cards principais ── -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

      <!-- Card: Consumo do Mês -->
      <div class="eco-card animate-fade-in" style="animation-delay:0s;">
        <div class="flex items-center gap-2 mb-3">
          <i class="fas fa-tint text-blue-500"></i>
          <?php if ($this->view->variacaoPercentual < 0): ?>
            <span class="text-sm font-semibold text-green-600">
              <i class="fas fa-arrow-down"></i> <?= abs($this->view->variacaoPercentual) ?>% abaixo
            </span>
          <?php elseif ($this->view->variacaoPercentual > 0): ?>
            <span class="text-sm font-semibold text-red-600">
              <i class="fas fa-arrow-up"></i> <?= abs($this->view->variacaoPercentual) ?>% acima
            </span>
          <?php else: ?>
            <span class="text-sm font-semibold text-blue-600">Estável</span>
          <?php endif; ?>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Consumo do Mês</p>
        <p class="text-3xl font-bold text-gray-800 stat-value mb-1">
          <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?> <span class="text-lg font-medium text-gray-400">L</span>
        </p>
        <p class="text-xs <?= $this->view->variacaoPercentual > 0 ? 'text-red-500' : ($this->view->variacaoPercentual < 0 ? 'text-green-500' : 'text-gray-400') ?>">
          <?php if ($this->view->variacaoPercentual > 0): ?>Alta vs mês anterior
          <?php elseif ($this->view->variacaoPercentual < 0): ?>Queda vs mês anterior
          <?php else: ?>Sem variação<?php endif; ?>
        </p>
      </div>

      <!-- Card: Projeção Mensal -->
      <div class="eco-card animate-fade-in" style="animation-delay:0.08s;">
        <div class="flex items-center gap-2 mb-3">
          <i class="fas fa-chart-line text-indigo-500"></i>
          <span class="text-sm font-semibold text-indigo-600">Projeção</span>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Projeção do Mês</p>
        <p class="text-3xl font-bold text-gray-800 stat-value mb-1">
          <?= number_format($this->view->projecaoMensal, 0, ',', '.') ?> <span class="text-lg font-medium text-gray-400">L</span>
        </p>
        <p class="text-xs text-gray-400">Estimativa para o fim do mês</p>
      </div>

      <!-- Card: Última Fatura -->
      <div class="eco-card animate-fade-in" style="animation-delay:0.16s;">
        <div class="flex items-center gap-2 mb-3">
          <i class="fas fa-file-invoice-dollar text-green-500"></i>
          <?php if ($this->view->ultimaFatura): ?>
            <span class="text-sm font-semibold text-green-600">Registrada</span>
          <?php else: ?>
            <span class="text-sm font-semibold text-gray-400">Sem dados</span>
          <?php endif; ?>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Última Fatura</p>
        <p class="text-3xl font-bold text-gray-800 stat-value mb-1">
          <span class="text-lg font-medium text-gray-400">R$</span><?= $this->view->ultimaFatura ? number_format($this->view->ultimaFatura['valor'], 2, ',', '.') : '0,00' ?>
        </p>
        <p class="text-xs text-gray-400">
          <?= $this->view->ultimaFatura ? date('m/Y', strtotime($this->view->ultimaFatura['mes_da_fatura'])) : 'Sem dados' ?>
        </p>
      </div>

      <!-- Card: Meta do Mês -->
      <div class="eco-card animate-fade-in" style="animation-delay:0.24s;">
        <div class="flex items-center gap-2 mb-3">
          <i class="fas fa-bullseye text-amber-500"></i>
          <?php if ($this->view->progressoMeta): ?>
            <span class="text-sm font-semibold <?= $this->view->progressoMeta['alerta'] ? 'text-red-600' : 'text-amber-600' ?>">
              <?= $this->view->progressoMeta['percentual'] ?>%
            </span>
          <?php endif; ?>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Meta do Mês</p>
        <?php if ($this->view->progressoMeta): ?>
          <p class="text-3xl font-bold text-gray-800 stat-value mb-2">
            <?= number_format($this->view->progressoMeta['consumo_atual'], 0) ?><span class="text-lg font-medium text-gray-400"> /<?= number_format($this->view->progressoMeta['meta_litros'], 0) ?>L</span>
          </p>
          <div class="eco-progress">
            <div class="eco-progress-bar <?= $this->view->progressoMeta['alerta'] ? 'eco-progress-danger' : ($this->view->progressoMeta['percentual'] > 80 ? 'eco-progress-warning' : 'eco-progress-success') ?>"
                 style="width: <?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
          </div>
        <?php else: ?>
          <p class="text-xl font-bold text-gray-800 mb-2">Sem meta</p>
          <a href="/metas" class="btn-eco btn-eco-primary" style="padding:0.4rem 0.9rem; font-size:0.8rem;">
            <i class="fas fa-bullseye"></i>Definir meta
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- ── Alertas ── -->
    <?php if (!empty($this->view->alertas)): ?>
      <div class="mb-8 space-y-3">
        <?php foreach ($this->view->alertas as $alerta): ?>
          <div class="eco-alert eco-alert-danger animate-slide-in-right">
            <i class="fas fa-exclamation-triangle flex-shrink-0 mt-0.5"></i>
            <div class="flex-1">
              <p class="font-semibold text-sm">
                <?= $alerta['tipo'] == 'meta' ? 'Meta Ultrapassada' : 'Alerta de Consumo' ?>
              </p>
              <p class="text-sm mt-0.5"><?= htmlspecialchars($alerta['mensagem']) ?></p>
            </div>
            <?php if ($alerta['tipo'] == 'meta'): ?>
              <a href="/metas" class="btn-eco btn-eco-danger flex-shrink-0" style="padding:0.4rem 0.9rem; font-size:0.8rem; white-space:nowrap;">
                <i class="fas fa-arrow-right"></i>Ver Metas
              </a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- ── Estatísticas rápidas + Dicas ── -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

      <!-- Estatísticas -->
      <div class="lg:col-span-2 eco-card">
        <div class="flex items-center gap-3 mb-5">
          <div class="eco-card-icon bg-blue-100" style="margin-bottom:0; width:2.5rem; height:2.5rem; font-size:1rem;">
            <i class="fas fa-chart-bar text-blue-600"></i>
          </div>
          <h3 class="text-base font-bold text-blue-900">Estatísticas Rápidas</h3>
        </div>
        <div class="grid grid-cols-3 gap-4">
          <div class="rounded-xl p-4" style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
            <p class="text-xs text-blue-500 font-semibold uppercase tracking-wide mb-1">Média Mensal</p>
            <p class="text-xl font-bold text-blue-900">R$ <?= number_format($this->view->mediaMensal, 2, ',', '.') ?></p>
          </div>
          <div class="rounded-xl p-4" style="background: linear-gradient(135deg,#f0fdf4,#dcfce7);">
            <p class="text-xs text-green-600 font-semibold uppercase tracking-wide mb-1">Total no Ano</p>
            <p class="text-xl font-bold text-green-800">R$ <?= number_format($this->view->totalGastoAno, 2, ',', '.') ?></p>
          </div>
          <div class="rounded-xl p-4" style="background: linear-gradient(135deg,#faf5ff,#ede9fe);">
            <p class="text-xs text-purple-500 font-semibold uppercase tracking-wide mb-1">Mês Anterior</p>
            <p class="text-xl font-bold text-purple-800"><?= number_format($this->view->totalMesAnterior, 0, ',', '.') ?> L</p>
          </div>
        </div>
      </div>

      <!-- Dicas -->
      <div class="eco-card">
        <div class="flex items-center gap-3 mb-4">
          <div class="eco-card-icon bg-amber-100" style="margin-bottom:0; width:2.5rem; height:2.5rem; font-size:1rem;">
            <i class="fas fa-lightbulb text-amber-500"></i>
          </div>
          <h3 class="text-base font-bold text-blue-900">Dicas de Economia</h3>
        </div>
        <ul class="space-y-2">
          <?php if (!empty($this->view->dicas)): ?>
            <?php foreach ($this->view->dicas as $dica): ?>
              <li class="flex items-start gap-2 text-sm text-gray-600">
                <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                <?= htmlspecialchars($dica->__get('dicas_desc')) ?>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="flex items-start gap-2 text-sm text-gray-600">
              <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
              Reduza o tempo do banho para 5 minutos e economize até 90 litros por dia.
            </li>
            <li class="flex items-start gap-2 text-sm text-gray-600">
              <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
              Feche a torneira ao escovar os dentes e economize até 12 litros por vez.
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <!-- ── Gráficos ── -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

      <div class="eco-card">
        <div class="flex items-center gap-2 mb-4">
          <i class="fas fa-chart-line text-blue-600"></i>
          <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wide">Consumo Mensal (L)</h3>
        </div>
        <div style="width:100%; height:260px;">
          <canvas id="lineChart"></canvas>
        </div>
      </div>

      <div class="eco-card">
        <div class="flex items-center gap-2 mb-4">
          <i class="fas fa-dollar-sign text-green-600"></i>
          <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wide">Valor das Faturas (R$)</h3>
        </div>
        <div style="width:100%; height:260px;">
          <canvas id="lineChartFaturas"></canvas>
        </div>
      </div>

      <div class="eco-card">
        <div class="flex items-center gap-2 mb-4">
          <i class="fas fa-chart-pie text-purple-600"></i>
          <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wide">Consumo por Tipo</h3>
        </div>
        <div style="width:100%; height:260px;">
          <canvas id="pieChart"></canvas>
        </div>
      </div>

      <div class="eco-card">
        <div class="flex items-center gap-2 mb-4">
          <i class="fas fa-chart-pie text-orange-600"></i>
          <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wide">Distribuição Detalhada</h3>
        </div>
        <div style="width:100%; height:260px;">
          <canvas id="doughnutChart"></canvas>
        </div>
      </div>
    </div>

    <!-- ── Tabela: Últimos 7 dias ── -->
    <div class="eco-card">
      <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
          <div class="eco-card-icon bg-blue-100" style="margin-bottom:0; width:2.5rem; height:2.5rem; font-size:1rem;">
            <i class="fas fa-list text-blue-600"></i>
          </div>
          <h3 class="text-base font-bold text-blue-900">Consumo dos Últimos 7 dias</h3>
        </div>
        <a href="/consumo" class="btn-eco btn-eco-primary" style="padding:0.4rem 0.9rem; font-size:0.8rem;">
          <i class="fas fa-plus mr-1"></i>Registrar
        </a>
      </div>

      <?php if (!empty($this->view->ultimos7dias)): ?>
        <div class="overflow-x-auto">
          <table class="eco-table">
            <thead>
              <tr>
                <th>Data</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Em Litros</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($this->view->ultimos7dias as $consumo): ?>
                <?php
                  $quantidade = $consumo->__get('quantidade');
                  $unidade    = $consumo->__get('unidade');
                  $litros     = $quantidade;
                  if ($unidade == 'mL') $litros = $quantidade / 1000;
                  elseif ($unidade == 'm³') $litros = $quantidade * 1000;
                ?>
                <tr class="transition-colors hover:bg-blue-50">
                  <td class="py-3 px-4 text-gray-700">
                    <i class="fas fa-calendar text-blue-300 mr-2"></i>
                    <?= date('d/m/Y', strtotime($consumo->__get('data_consumo'))) ?>
                  </td>
                  <td class="py-3 px-4">
                    <span class="eco-badge eco-badge-info"><?= htmlspecialchars($consumo->__get('tipo')) ?></span>
                  </td>
                  <td class="py-3 px-4 text-gray-600">
                    <?= number_format($quantidade, 2, ',', '.') ?> <?= $unidade ?>
                  </td>
                  <td class="py-3 px-4 font-semibold text-blue-700">
                    <?= number_format($litros, 2, ',', '.') ?> L
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="eco-empty-state">
          <div class="eco-empty-icon"><i class="fas fa-tint-slash"></i></div>
          <h3 class="eco-empty-title">Nenhum consumo registrado</h3>
          <p class="eco-empty-text">Comece registrando seu consumo diário</p>
          <a href="/consumo" class="btn-eco btn-eco-primary">
            <i class="fas fa-plus mr-2"></i>Registrar Consumo
          </a>
        </div>
      <?php endif; ?>
    </div>

  </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const graficoLinhaLabels = <?= $this->view->graficoLinhaLabels ?>;
  const graficoLinhaData   = <?= $this->view->graficoLinhaData ?>;
  const graficoPizzaLabels = <?= $this->view->graficoPizzaLabels ?>;
  const graficoPizzaData   = <?= $this->view->graficoPizzaData ?>;
  const graficoBarraLabels = <?= $this->view->graficoBarraLabels ?>;
  const graficoBarraData   = <?= $this->view->graficoBarraData ?>;

  const paleta = ['#1e3a8a','#2563eb','#3b82f6','#60a5fa','#93c5fd','#bfdbfe','#dbeafe'];
  const baseOpts = { responsive: true, maintainAspectRatio: false };

  // Linha: Consumo
  const ctxLine = document.getElementById('lineChart');
  if (ctxLine && graficoLinhaLabels.length) {
    new Chart(ctxLine, {
      type: 'line',
      data: { labels: graficoLinhaLabels, datasets: [{
        label: 'Consumo (L)', data: graficoLinhaData,
        borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,0.08)',
        tension: 0.4, fill: true, pointRadius: 5, pointHoverRadius: 7,
        pointBackgroundColor: '#2563eb'
      }]},
      options: { ...baseOpts, plugins: { legend: { display: false },
        tooltip: { callbacks: { label: c => 'Consumo: ' + c.parsed.y.toLocaleString('pt-BR') + ' L' }}},
        scales: { y: { beginAtZero: false, ticks: { callback: v => v.toLocaleString('pt-BR') + ' L' }}}}
    });
  }

  // Linha: Faturas
  const ctxFat = document.getElementById('lineChartFaturas');
  if (ctxFat && graficoBarraLabels.length) {
    new Chart(ctxFat, {
      type: 'line',
      data: { labels: graficoBarraLabels, datasets: [{
        label: 'Valor (R$)', data: graficoBarraData,
        borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.08)',
        tension: 0.4, fill: true, pointRadius: 5, pointHoverRadius: 7,
        pointBackgroundColor: '#10b981'
      }]},
      options: { ...baseOpts, plugins: { legend: { display: false },
        tooltip: { callbacks: { label: c => 'R$ ' + c.parsed.y.toLocaleString('pt-BR', {minimumFractionDigits:2}) }}},
        scales: { y: { beginAtZero: true, ticks: { callback: v => 'R$ ' + v.toLocaleString('pt-BR') }}}}
    });
  }

  // Pizza
  const ctxPie = document.getElementById('pieChart');
  if (ctxPie && graficoPizzaLabels.length) {
    new Chart(ctxPie, {
      type: 'pie',
      data: { labels: graficoPizzaLabels, datasets: [{ data: graficoPizzaData, backgroundColor: paleta }]},
      options: { ...baseOpts, plugins: { legend: { position: 'bottom' },
        tooltip: { callbacks: { label: c => c.label + ': ' + c.parsed.toLocaleString('pt-BR') + ' L' }}}}
    });
  }

  // Rosca
  const ctxDonut = document.getElementById('doughnutChart');
  if (ctxDonut && graficoPizzaLabels.length) {
    new Chart(ctxDonut, {
      type: 'doughnut',
      data: { labels: graficoPizzaLabels, datasets: [{ data: graficoPizzaData, backgroundColor: paleta, hoverOffset: 8 }]},
      options: { ...baseOpts, plugins: { legend: { position: 'bottom' },
        tooltip: { callbacks: { label: c => {
          const total = c.dataset.data.reduce((a,b) => a+b, 0);
          return c.label + ': ' + c.parsed.toLocaleString('pt-BR') + ' L (' + ((c.parsed/total)*100).toFixed(1) + '%)';
        }}}}}
    });
  }
});
</script>
</body>
</html>
