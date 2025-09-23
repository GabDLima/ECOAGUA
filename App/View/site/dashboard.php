<body class="bg-gray-50">
  <div id="main-content" class="flex-1 pt-16 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">Bem-vindo à sua Dashboard, <?= htmlspecialchars($this->view->nome_usuario) ?>!</h2>

      <!-- Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Projeção -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Projeção de Consumo</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">1.200 L</div>
            <p class="text-gray-600">Estimativa para o próximo mês.</p>
          </div>
        </div>
        <!-- Dicas -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Dicas de Economia</div>
          <ul class="list-disc list-inside text-gray-700 space-y-1 p-4">
          <?php if (!empty($this->view->dicas)): ?>
              <?php foreach ($this->view->dicas as $dica): ?>
                  <li><?= htmlspecialchars($dica->__get('dicas_desc')) ?></li>
              <?php endforeach; ?>
          <?php else: ?>
              <li>Nenhuma dica disponível</li>
          <?php endif; ?>

          </ul>
        </div>

        <!-- Alerta -->
        <div class="bg-white shadow rounded-lg overflow-hidden border-2 border-red-500">
          <div class="bg-red-50 text-red-700 px-4 py-3 font-semibold">Consumo Alto</div>
          <div class="p-4">
            <p class="text-red-600 mb-3">Você excedeu 90% da sua meta mensal.</p>
            <button id="btnMetas" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded">Ver Metas</button>
          </div>
        </div>
      </div>

      <!-- Gráficos -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-4">
        <div class="bg-white shadow rounded-lg p-4">
          <h3 class="text-lg font-medium text-blue-900 mb-4">Consumo Mensal</h3>
          <canvas id="lineChart" class="w-full h-64"></canvas>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
          <h3 class="text-lg font-medium text-blue-900 mb-4">Distribuição de Uso</h3>
          <canvas id="pieChart" class="w-full h-64"></canvas>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="text-lg font-medium text-blue-900 mb-4">Consumo Mensal (últimos 6 meses)</h3>
            <canvas id="barChart" class="w-full h-64"></canvas>
          </div>
          <div class="bg-white shadow rounded-lg p-4">
            <h3 class="text-lg font-medium text-blue-900 mb-4">Distribuição por Categoria</h3>
            <canvas id="doughnutChart" class="w-full h-64"></canvas>
          </div>
      </div>

      <!-- Relatórios -->
      <div class="pt-16 px-6 pb-6">
        <h2 class="text-2xl font-semibold text-blue-900 mb-6">Relatórios de Consumo</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
          <div class="px-6 py-3 bg-blue-900 text-white font-medium">Consumo Diário (últimos 7 dias)</div>
          <div class="p-4 overflow-x-auto">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Data</th>
                  <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Consumo (L)</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr><td class="px-4 py-2">01/06/2025</td><td class="px-4 py-2">350</td></tr>
                <tr><td class="px-4 py-2">02/06/2025</td><td class="px-4 py-2">420</td></tr>
                <tr><td class="px-4 py-2">03/06/2025</td><td class="px-4 py-2">390</td></tr>
                <tr><td class="px-4 py-2">04/06/2025</td><td class="px-4 py-2">440</td></tr>
                <tr><td class="px-4 py-2">05/06/2025</td><td class="px-4 py-2">410</td></tr>
                <tr><td class="px-4 py-2">06/06/2025</td><td class="px-4 py-2">380</td></tr>
                <tr><td class="px-4 py-2">07/06/2025</td><td class="px-4 py-2">430</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <!-- Exportar PDF -->
      <div class="pt-16 px-6 pb-6">
        <h2 class="text-2xl font-semibold text-blue-900 mb-6">Exportar Relatório em PDF</h2>
        <div class="max-w-xl mx-auto space-y-6">
          <div id="exportSuccess" class="hidden bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded">
            Relatório gerado com sucesso!
          </div>

          <form id="exportForm" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="startDate" class="block text-gray-700 font-medium mb-1">Data Início</label>
                <input type="date" id="startDate" required class="w-full border border-gray-300 rounded px-3 py-2" />
              </div>
              <div>
                <label for="endDate" class="block text-gray-700 font-medium mb-1">Data Fim</label>
                <input type="date" id="endDate" required class="w-full border border-gray-300 rounded px-3 py-2" />
              </div>
            </div>

            <div>
              <label for="observations" class="block text-gray-700 font-medium mb-1">Observações (opcional)</label>
              <textarea id="observations" rows="4" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Adicione comentários"></textarea>
            </div>

            <div>
              <span class="block mb-2 text-gray-700 font-medium">Orientação</span>
              <div class="flex items-center space-x-6">
                <label class="flex items-center space-x-2">
                  <input type="radio" name="orientation" value="portrait" checked class="h-4 w-4" />
                  <span class="text-gray-700">Retrato</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="radio" name="orientation" value="landscape" class="h-4 w-4" />
                  <span class="text-gray-700">Paisagem</span>
                </label>
              </div>
            </div>

            <div>
              <label for="includeOptions" class="block mb-1 text-gray-700 font-medium">Incluir no PDF</label>
              <select id="includeOptions" multiple class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="table" selected>Tabela de Consumo</option>
                <option value="charts" selected>Gráficos</option>
                <option value="metas">Metas</option>
              </select>
              <p class="text-sm text-gray-500 mt-1">Segure Ctrl (Windows) ou Cmd (Mac) para múltipla seleção.</p>
            </div>

            <div class="relative">
              <button id="exportBtn" type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 rounded">
                <span id="btnText">Gerar PDF</span>
                <svg id="btnSpinner" class="hidden animate-spin absolute right-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-4-3-4v4a8 8 0 00-8 8z"></path>
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Redirecionamento para Metas
      const btnMetas = document.getElementById('btnMetas');
      if (btnMetas) {
        btnMetas.addEventListener('click', () => {
          window.location.href = 'consumo';
        });
      }

      // Chart: Linha - Consumo Mensal
      const ctxLine = document.getElementById('lineChart');
      if (ctxLine) {
        new Chart(ctxLine, {
          type: 'line',
          data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
              label: 'Consumo (L)',
              data: [1100, 950, 1020, 980, 1200, 1150],
              borderColor: 'rgba(30,60,114,1)',
              backgroundColor: 'rgba(30,60,114,0.1)',
              tension: 0.4,
              fill: true
            }]
          },
          options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: false } }
          }
        });
      }

      // Chart: Pizza - Distribuição de Uso
      const ctxPie = document.getElementById('pieChart');
      if (ctxPie) {
        new Chart(ctxPie, {
          type: 'pie',
          data: {
            labels: ['Banho', 'Lavagem de Roupa', 'Limpeza'],
            datasets: [{ data: [45, 30, 25], backgroundColor: ['#1e3c72', '#3c78b4', '#5fa5e5'] }]
          },
          options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
          }
        });
      }

      // Chart: Barra - Últimos 6 meses
      const ctxBar = document.getElementById('barChart');
      if (ctxBar) {
        new Chart(ctxBar, {
          type: 'bar',
          data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
              label: 'Consumo (L)',
              data: [1200, 1350, 1280, 1420, 1500, 1380],
              backgroundColor: 'rgba(30,60,114,0.7)'
            }]
          },
          options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
          }
        });
      }

      // Chart: Rosca - Por Categoria
      const ctxDonut = document.getElementById('doughnutChart');
      if (ctxDonut) {
        new Chart(ctxDonut, {
          type: 'doughnut',
          data: {
            labels: ['Banho', 'Limpeza', 'Cozinha', 'Jardim'],
            datasets: [{
              data: [40, 25, 20, 15],
              backgroundColor: ['#1e3c72', '#3c78b4', '#5fa5e5', '#78b4f0']
            }]
          },
          options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
          }
        });
      }

      // Formulário de exportação (exemplo de uso de spinner)
      const exportForm = document.getElementById('exportForm');
      const exportSuccess = document.getElementById('exportSuccess');
      const btnSpinner = document.getElementById('btnSpinner');
      const btnText = document.getElementById('btnText');

      if (exportForm) {
        exportForm.addEventListener('submit', (e) => {
          e.preventDefault();
          btnSpinner.classList.remove('hidden');
          btnText.textContent = 'Gerando...';

          // Simulação (remover em produção)
          setTimeout(() => {
            btnSpinner.classList.add('hidden');
            btnText.textContent = 'Gerar PDF';
            exportSuccess.classList.remove('hidden');
          }, 2000);
        });
      }
    });
  </script>
</body>
</html>
