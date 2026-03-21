<body class="bg-gray-50">
<div id="main-content" class="flex-1 pt-20 transition-[margin] duration-300">
  <main class="px-6 py-6" style="max-width:1200px; margin:0 auto;">

    <!-- Cabeçalho -->
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-2xl font-bold text-blue-900">Metas de Economia</h1>
        <p class="text-gray-400 text-sm mt-1">Acompanhe seus objetivos de consumo hídrico</p>
      </div>
      <a href="/consumo" class="btn-eco btn-eco-primary" style="padding:0.6rem 1.2rem; font-size:0.9rem;">
        <i class="fas fa-plus mr-2"></i>Nova Meta
      </a>
    </div>

    <!-- ── Cards de resumo ── -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

      <!-- Meta Atual -->
      <div class="eco-card animate-fade-in" style="animation-delay:0s;">
        <div class="flex items-center justify-between mb-4">
          <div class="eco-card-icon bg-blue-100" style="margin-bottom:0;">
            <i class="fas fa-bullseye text-blue-600"></i>
          </div>
          <?php if ($this->view->metaAtiva): ?>
            <span class="eco-badge eco-badge-info">Ativa</span>
          <?php endif; ?>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Meta Atual</p>
        <p class="text-3xl font-bold text-gray-800">
          <?= $this->view->metaAtiva ? number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') : '--' ?>
          <span class="text-lg font-medium text-gray-400">L</span>
        </p>
        <?php if ($this->view->metaAtiva): ?>
          <p class="text-xs text-gray-400 mt-1">Prazo: <?= $this->view->metaAtiva['prazo'] ?> meses</p>
        <?php endif; ?>
      </div>

      <!-- Consumo Atual -->
      <div class="eco-card animate-fade-in" style="animation-delay:0.08s;">
        <div class="flex items-center justify-between mb-4">
          <div class="eco-card-icon <?= ($this->view->progressoMeta && $this->view->progressoMeta['alerta']) ? 'bg-red-100' : 'bg-orange-100' ?>" style="margin-bottom:0;">
            <i class="fas fa-tint <?= ($this->view->progressoMeta && $this->view->progressoMeta['alerta']) ? 'text-red-600' : 'text-orange-600' ?>"></i>
          </div>
          <?php if ($this->view->progressoMeta && $this->view->progressoMeta['alerta']): ?>
            <span class="eco-badge eco-badge-danger"><i class="fas fa-exclamation-triangle mr-1"></i>Alerta</span>
          <?php endif; ?>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Consumo Atual</p>
        <p class="text-3xl font-bold <?= ($this->view->progressoMeta && $this->view->progressoMeta['alerta']) ? 'text-red-600' : 'text-orange-600' ?>">
          <?= number_format($this->view->totalMesAtual, 0, ',', '.') ?>
          <span class="text-lg font-medium text-gray-400">L</span>
        </p>
        <p class="text-xs text-gray-400 mt-1">Neste mês</p>
      </div>

      <!-- Economia Esperada -->
      <div class="eco-card animate-fade-in" style="animation-delay:0.16s;">
        <div class="flex items-center justify-between mb-4">
          <div class="eco-card-icon bg-green-100" style="margin-bottom:0;">
            <i class="fas fa-leaf text-green-600"></i>
          </div>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Economia Esperada</p>
        <p class="text-3xl font-bold text-green-600">
          <?= $this->view->economiaEsperada ?>
          <span class="text-lg font-medium text-green-400">%</span>
        </p>
        <p class="text-xs text-gray-400 mt-1">Meta de redução</p>
      </div>

      <!-- Status -->
      <?php
        $statusBg    = 'bg-gray-100';
        $statusColor = 'text-gray-600';
        $statusIcon  = 'fa-minus-circle';
        if ($this->view->statusGeral == 'Dentro da Meta')    { $statusBg = 'bg-green-100';  $statusColor = 'text-green-600';  $statusIcon = 'fa-check-circle'; }
        if ($this->view->statusGeral == 'Próximo ao Limite') { $statusBg = 'bg-yellow-100'; $statusColor = 'text-yellow-600'; $statusIcon = 'fa-exclamation-circle'; }
        if ($this->view->statusGeral == 'Acima da Meta')     { $statusBg = 'bg-red-100';    $statusColor = 'text-red-600';    $statusIcon = 'fa-times-circle'; }
      ?>
      <div class="eco-card animate-fade-in" style="animation-delay:0.24s;">
        <div class="flex items-center justify-between mb-4">
          <div class="eco-card-icon <?= $statusBg ?>" style="margin-bottom:0;">
            <i class="fas <?= $statusIcon ?> <?= $statusColor ?>"></i>
          </div>
        </div>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Status Geral</p>
        <p class="text-xl font-bold <?= $statusColor ?>">
          <?= $this->view->statusGeral ?>
        </p>
      </div>
    </div>

    <!-- ── Progresso da Meta Atual ── -->
    <?php if ($this->view->progressoMeta): ?>
      <div class="eco-card animate-fade-in mb-8" style="animation-delay:0.3s;">
        <div class="flex items-center gap-3 mb-6">
          <div class="eco-card-icon bg-blue-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
            <i class="fas fa-chart-bar text-blue-600"></i>
          </div>
          <h3 class="text-base font-bold text-blue-900">Progresso da Meta Atual</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-5">
          <div class="rounded-xl p-4 text-center" style="background:#eff6ff;">
            <p class="text-xs text-blue-500 font-semibold uppercase tracking-wide mb-1">Meta</p>
            <p class="text-2xl font-bold text-blue-900"><?= number_format($this->view->metaAtiva['meta_mensal'], 0, ',', '.') ?> L</p>
          </div>
          <div class="rounded-xl p-4 text-center" style="background:#f0fdf4;">
            <p class="text-xs text-green-600 font-semibold uppercase tracking-wide mb-1">Consumido</p>
            <p class="text-2xl font-bold text-green-800"><?= number_format($this->view->progressoMeta['consumo_atual'], 0, ',', '.') ?> L</p>
          </div>
          <div class="rounded-xl p-4 text-center" style="background:<?= $this->view->progressoMeta['restante'] > 0 ? '#f0fdf4' : '#fef2f2' ?>;">
            <p class="text-xs <?= $this->view->progressoMeta['restante'] > 0 ? 'text-green-600' : 'text-red-500' ?> font-semibold uppercase tracking-wide mb-1">
              <?= $this->view->progressoMeta['restante'] > 0 ? 'Restante' : 'Excedido' ?>
            </p>
            <p class="text-2xl font-bold <?= $this->view->progressoMeta['restante'] > 0 ? 'text-green-800' : 'text-red-700' ?>">
              <?= number_format(abs($this->view->progressoMeta['restante']), 0, ',', '.') ?> L
            </p>
          </div>
        </div>

        <!-- Barra de progresso grande -->
        <div class="mb-3">
          <div class="flex justify-between text-sm font-semibold mb-2">
            <span class="text-gray-600">Progresso</span>
            <span class="<?= $this->view->progressoMeta['alerta'] ? 'text-red-600' : 'text-green-600' ?>">
              <?= $this->view->progressoMeta['percentual'] ?>% da meta
            </span>
          </div>
          <div class="eco-progress" style="height: 1rem; border-radius:999px;">
            <div class="eco-progress-bar <?= $this->view->progressoMeta['alerta'] ? 'eco-progress-danger' : ($this->view->progressoMeta['percentual'] > 80 ? 'eco-progress-warning' : 'eco-progress-success') ?>"
                 style="width:<?= min($this->view->progressoMeta['percentual'], 100) ?>%"></div>
          </div>
        </div>

        <!-- Mensagem de status -->
        <div class="<?= $this->view->progressoMeta['restante'] > 0 ? 'eco-alert eco-alert-success' : 'eco-alert eco-alert-danger' ?>">
          <i class="fas <?= $this->view->progressoMeta['restante'] > 0 ? 'fa-check-circle' : 'fa-exclamation-triangle' ?> flex-shrink-0 mt-0.5"></i>
          <p class="font-medium text-sm">
            <?php if ($this->view->progressoMeta['restante'] > 0): ?>
              Você ainda pode consumir <strong><?= number_format($this->view->progressoMeta['restante'], 0, ',', '.') ?>L</strong> para manter-se dentro da meta.
            <?php else: ?>
              Meta ultrapassada em <strong><?= number_format(abs($this->view->progressoMeta['restante']), 0, ',', '.') ?>L</strong>. Reduza o consumo nos próximos dias.
            <?php endif; ?>
          </p>
        </div>
      </div>
    <?php endif; ?>

    <!-- ── Histórico de Metas ── -->
    <?php if (!empty($this->view->historicoMetas)): ?>
      <div class="eco-card animate-fade-in mb-8" style="animation-delay:0.4s;">
        <div class="flex items-center gap-3 mb-5">
          <div class="eco-card-icon bg-purple-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
            <i class="fas fa-calendar-alt text-purple-600"></i>
          </div>
          <h3 class="text-base font-bold text-blue-900">Histórico de Metas</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="eco-table">
            <thead>
              <tr>
                <th>Mês/Ano</th>
                <th>Meta (L)</th>
                <th>Real (L)</th>
                <th>Diferença</th>
                <th>% Atingida</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $total = count($this->view->historicoMetas); ?>
              <?php foreach ($this->view->historicoMetas as $i => $h): ?>
                <tr class="transition-colors hover:bg-blue-50 <?= $i == $total-1 ? '' : '' ?>"
                    style="<?= $i == $total-1 ? 'background:#eff6ff;' : '' ?>">
                  <td class="py-3 px-4 font-medium text-gray-700"><?= ucfirst($h['mes_nome']) ?></td>
                  <td class="py-3 px-4 text-gray-600"><?= number_format($h['meta_litros'], 0, ',', '.') ?></td>
                  <td class="py-3 px-4 font-semibold text-gray-800"><?= number_format($h['consumo_real'], 0, ',', '.') ?></td>
                  <td class="py-3 px-4 font-semibold <?= $h['diferenca'] > 0 ? 'text-red-600' : 'text-green-600' ?>">
                    <?= $h['diferenca'] > 0 ? '+' : '' ?><?= number_format($h['diferenca'], 0, ',', '.') ?>
                  </td>
                  <td class="py-3 px-4">
                    <div class="flex items-center gap-2">
                      <div class="eco-progress" style="width:60px; height:6px;">
                        <div class="eco-progress-bar <?= $h['percentual'] > 100 ? 'eco-progress-danger' : 'eco-progress-success' ?>"
                             style="width:<?= min($h['percentual'],100) ?>%"></div>
                      </div>
                      <span class="font-semibold text-xs <?= $h['percentual'] > 100 ? 'text-red-600' : 'text-green-600' ?>">
                        <?= $h['percentual'] ?>%
                      </span>
                    </div>
                  </td>
                  <td class="py-3 px-4">
                    <?php if ($i == $total-1): ?>
                      <span class="eco-badge eco-badge-warning"><i class="fas fa-clock mr-1"></i>Em andamento</span>
                    <?php elseif ($h['status'] == 'atingida'): ?>
                      <span class="eco-badge eco-badge-success"><i class="fas fa-check-circle mr-1"></i>Atingida</span>
                    <?php else: ?>
                      <span class="eco-badge eco-badge-danger"><i class="fas fa-times-circle mr-1"></i>Não atingida</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <!-- ── Metas por Categoria ── -->
    <?php if (!empty($this->view->metasPorCategoria)): ?>
      <div class="eco-card animate-fade-in mb-8" style="animation-delay:0.5s;">
        <div class="flex items-center gap-3 mb-5">
          <div class="eco-card-icon bg-cyan-100" style="margin-bottom:0; width:2.5rem;height:2.5rem;font-size:1rem;">
            <i class="fas fa-folder-open text-cyan-600"></i>
          </div>
          <h3 class="text-base font-bold text-blue-900">Consumo por Categoria</h3>
        </div>
        <?php
          $paleta = ['#1e3a8a','#2563eb','#3b82f6','#60a5fa','#93c5fd'];
          $ci = 0;
        ?>
        <div class="space-y-4">
          <?php foreach ($this->view->metasPorCategoria as $cat): ?>
            <div>
              <div class="flex items-center justify-between mb-1">
                <div class="flex items-center gap-2">
                  <div class="w-3 h-3 rounded-full flex-shrink-0" style="background:<?= $paleta[$ci % count($paleta)] ?>;"></div>
                  <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($cat['tipo']) ?></span>
                </div>
                <div class="flex items-center gap-3">
                  <span class="text-xs text-gray-400"><?= number_format($cat['consumo'], 0, ',', '.') ?> / <?= number_format($cat['meta'], 0, ',', '.') ?> L</span>
                  <span class="text-xs font-bold <?= $cat['status'] == 'acima' ? 'text-red-600' : 'text-green-600' ?>">
                    <?= $cat['percentual'] ?>%
                  </span>
                  <?php if ($cat['status'] == 'acima'): ?>
                    <span class="eco-badge eco-badge-danger" style="font-size:0.65rem; padding:0.15rem 0.5rem;">Acima</span>
                  <?php else: ?>
                    <span class="eco-badge eco-badge-success" style="font-size:0.65rem; padding:0.15rem 0.5rem;">OK</span>
                  <?php endif; ?>
                </div>
              </div>
              <div class="eco-progress" style="height:8px;">
                <div class="eco-progress-bar <?= $cat['status'] == 'acima' ? 'eco-progress-danger' : 'eco-progress-success' ?>"
                     style="width:<?= min($cat['percentual'],100) ?>%"></div>
              </div>
            </div>
            <?php $ci++; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- ── Empty state ── -->
    <?php if (!$this->view->metaAtiva): ?>
      <div class="eco-card animate-fade-in text-center py-16">
        <div class="eco-card-icon bg-blue-100 mx-auto mb-4" style="width:5rem;height:5rem;font-size:2rem;">
          <i class="fas fa-bullseye text-blue-400"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">Nenhuma meta definida</h3>
        <p class="text-gray-400 text-sm mb-6 max-w-sm mx-auto">
          Defina sua primeira meta de economia de água e comece a monitorar seu progresso.
        </p>
        <a href="/consumo" class="btn-eco btn-eco-primary">
          <i class="fas fa-plus mr-2"></i>Definir Primeira Meta
        </a>
      </div>
    <?php endif; ?>

  </main>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Anima as progress bars na entrada
    document.querySelectorAll('.eco-progress-bar').forEach(bar => {
      const w = bar.style.width;
      bar.style.width = '0%';
      setTimeout(() => {
        bar.style.transition = 'width 1s cubic-bezier(0.4,0,0.2,1)';
        bar.style.width = w;
      }, 200);
    });
  });
</script>
</body>
</html>
