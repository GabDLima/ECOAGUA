<body class="bg-gray-50">
  <div id="main-content" class="flex-1 pt-16 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-blue-900">Metas de Economia</h2>
        <button id="btnVoltar" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
          ← Voltar ao Dashboard
        </button>
      </div>

      <!-- Resumo das Metas -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-4 meta-card">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Meta Atual</p>
              <p class="text-2xl font-bold text-blue-900">1.000 L</p>
            </div>
            <div class="text-blue-500">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg p-4 meta-card">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Consumo Atual</p>
              <p class="text-2xl font-bold text-orange-600">1.200 L</p>
            </div>
            <div class="text-orange-500">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg p-4 meta-card">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Economia Esperada</p>
              <p class="text-2xl font-bold text-green-600">15%</p>
            </div>
            <div class="text-green-500">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg p-4 meta-card">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">Status</p>
              <p class="text-lg font-bold text-red-600">Acima da Meta</p>
            </div>
            <div class="text-red-500">
              <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Progress Bars das Metas -->
      <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-blue-900 mb-4">Progresso das Metas Mensais</h3>
        <div class="space-y-4">
          <div>
            <div class="flex justify-between mb-2">
              <span class="text-sm font-medium text-gray-700">Meta de Janeiro (1.000L)</span>
              <span class="text-sm text-gray-600">1.100L / 110%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
              <div class="bg-red-500 h-3 rounded-full progress-bar" style="width: 110%"></div>
            </div>
          </div>
          
          <div>
            <div class="flex justify-between mb-2">
              <span class="text-sm font-medium text-gray-700">Meta de Fevereiro (950L)</span>
              <span class="text-sm text-gray-600">950L / 100%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
              <div class="bg-yellow-500 h-3 rounded-full progress-bar" style="width: 100%"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between mb-2">
              <span class="text-sm font-medium text-gray-700">Meta de Março (1.020L)</span>
              <span class="text-sm text-gray-600">1.020L / 100%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
              <div class="bg-green-500 h-3 rounded-full progress-bar" style="width: 100%"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between mb-2">
              <span class="text-sm font-medium text-gray-700">Meta Atual - Junho (1.000L)</span>
              <span class="text-sm text-gray-600">1.200L / 120%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
              <div class="bg-red-500 h-3 rounded-full progress-bar" style="width: 120%"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabela de Metas Mensais -->
      <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-3 bg-blue-900 text-white font-medium">Histórico de Metas Mensais</div>
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
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">Janeiro/2025</td>
                <td class="px-4 py-2">1.000</td>
                <td class="px-4 py-2">1.100</td>
                <td class="px-4 py-2 text-red-600">+100</td>
                <td class="px-4 py-2 text-red-600">110%</td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Não Atingida</span>
                </td>
              </tr>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">Fevereiro/2025</td>
                <td class="px-4 py-2">950</td>
                <td class="px-4 py-2">950</td>
                <td class="px-4 py-2 text-green-600">0</td>
                <td class="px-4 py-2 text-green-600">100%</td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Atingida</span>
                </td>
              </tr>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">Março/2025</td>
                <td class="px-4 py-2">1.020</td>
                <td class="px-4 py-2">1.020</td>
                <td class="px-4 py-2 text-green-600">0</td>
                <td class="px-4 py-2 text-green-600">100%</td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Atingida</span>
                </td>
              </tr>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">Abril/2025</td>
                <td class="px-4 py-2">980</td>
                <td class="px-4 py-2">980</td>
                <td class="px-4 py-2 text-green-600">0</td>
                <td class="px-4 py-2 text-green-600">100%</td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Atingida</span>
                </td>
              </tr>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">Maio/2025</td>
                <td class="px-4 py-2">1.200</td>
                <td class="px-4 py-2">1.200</td>
                <td class="px-4 py-2 text-green-600">0</td>
                <td class="px-4 py-2 text-green-600">100%</td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Atingida</span>
                </td>
              </tr>
              <tr class="hover:bg-gray-50 bg-blue-50">
                <td class="px-4 py-2 font-semibold">Junho/2025</td>
                <td class="px-4 py-2 font-semibold">1.000</td>
                <td class="px-4 py-2 font-semibold">1.200</td>
                <td class="px-4 py-2 text-red-600 font-semibold">+200</td>
                <td class="px-4 py-2 text-red-600 font-semibold">120%</td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">Em Andamento</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tabela de Metas por Categoria -->
      <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-3 bg-blue-900 text-white font-medium">Metas por Categoria de Uso</div>
        <div class="p-4 overflow-x-auto">
          <table class="min-w-full table-auto divide-y divide-gray-200">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Categoria</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Meta Mensal (L)</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Consumo Atual (L)</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">% da Meta</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Progresso</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">
                  <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-900 rounded mr-2"></div>
                    Banho
                  </div>
                </td>
                <td class="px-4 py-2">450</td>
                <td class="px-4 py-2">540</td>
                <td class="px-4 py-2 text-red-600">120%</td>
                <td class="px-4 py-2">
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 120%"></div>
                  </div>
                </td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Acima</span>
                </td>
              </tr>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">
                  <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-600 rounded mr-2"></div>
                    Lavagem de Roupa
                  </div>
                </td>
                <td class="px-4 py-2">300</td>
                <td class="px-4 py-2">360</td>
                <td class="px-4 py-2 text-red-600">120%</td>
                <td class="px-4 py-2">
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 120%"></div>
                  </div>
                </td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Acima</span>
                </td>
              </tr>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">
                  <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-400 rounded mr-2"></div>
                    Limpeza
                  </div>
                </td>
                <td class="px-4 py-2">200</td>
                <td class="px-4 py-2">250</td>
                <td class="px-4 py-2 text-red-600">125%</td>
                <td class="px-4 py-2">
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 125%"></div>
                  </div>
                </td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Acima</span>
                </td>
              </tr>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">
                  <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-300 rounded mr-2"></div>
                    Cozinha
                  </div>
                </td>
                <td class="px-4 py-2">50</td>
                <td class="px-4 py-2">50</td>
                <td class="px-4 py-2 text-green-600">100%</td>
                <td class="px-4 py-2">
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                  </div>
                </td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">No Alvo</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Botão voltar
      const btnVoltar = document.getElementById('btnVoltar');
      if (btnVoltar) {
        btnVoltar.addEventListener('click', () => {
          // Simula voltar à página anterior ou dashboard
          window.history.back();
        });
      }

      // Gráfico de tendência
      const ctxTrend = document.getElementById('trendChart');
      if (ctxTrend) {
        new Chart(ctxTrend, {
          type: 'line',
          data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
              label: 'Meta (L)',
              data: [1000, 950, 1020, 980, 1200, 1000],
              borderColor: 'rgba(30,60,114,1)',
              backgroundColor: 'rgba(30,60,114,0.1)',
              tension: 0.4,
              fill: false
            }, {
              label: 'Consumo Real (L)',
              data: [1100, 950, 1020, 980, 1200, 1200],
              borderColor: 'rgba(239,68,68,1)',
              backgroundColor: 'rgba(239,68,68,0.1)',
              tension: 0.4,
              fill: false
            }]
          },
          options: {
            responsive: true,
            plugins: { 
              legend: { display: true, position: 'top' } 
            },
            scales: { 
              y: { 
                beginAtZero: false,
                title: {
                  display: true,
                  text: 'Consumo (Litros)'
                }
              },
              x: {
                title: {
                  display: true,
                  text: 'Mês'
                }
              }
            }
          }
        });
      }

      // Form de nova meta
      const metaForm = document.getElementById('metaForm');
      if (metaForm) {
        metaForm.addEventListener('submit', (e) => {
          e.preventDefault();
          
          const mesAno = document.getElementById('mesAno').value;
          const metaConsumo = document.getElementById('metaConsumo').value;
          const categoria = document.getElementById('categoria').value;
          const observacoes = document.getElementById('observacoes').value;
          
          if (mesAno && metaConsumo) {
            alert(Meta definida com sucesso!\n\nMês: ${mesAno}\nMeta: ${metaConsumo}L\nCategoria: ${categoria});
            metaForm.reset();
          }
        });
      }

      // Animação das progress bars
      const progressBars = document.querySelectorAll('.progress-bar');
      progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
          bar.style.width = width;
        }, 500);
      });
    });
  </script>
</body>
</html>