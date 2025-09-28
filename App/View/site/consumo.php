<body class="bg-gray-50">
  <div id="main-content" class="flex-1 pt-16 transition-[margin] duration-300">
    <main class="px-6 py-4">
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">Gerenciar Dados de Consumo</h2>

      <!-- Cards de Ações -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card Inserir Valor da Conta -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Inserir Valor da Conta</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">R$ 0,00</div>
            <p class="text-gray-600 mb-4">Registre o valor da sua fatura mensal.</p>
            <button id="btnConta" class="w-full bg-blue-900 hover:bg-blue-700 text-white font-medium py-2 rounded">Registrar Fatura</button>
          </div>
        </div>

        <!-- Card Metas de Consumo -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Metas de Consumo</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">10.000 L</div>
            <p class="text-gray-600 mb-4">Defina suas metas de economia.</p>
            <button id="btnMetas" class="w-full bg-blue-900 hover:bg-blue-700 text-white font-medium py-2 rounded">Definir Metas</button>
          </div>
        </div>

        <!-- Card Consumo Diário -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="bg-blue-900 text-white px-4 py-3">Consumo Diário</div>
          <div class="p-4">
            <div class="text-3xl font-bold mb-2">0 L</div>
            <p class="text-gray-600 mb-4">Registre seu consumo do dia.</p>
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

          <!-- Metas Atuais -->
          <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-blue-900 mb-4">Metas Atuais</h4>
            <ul class="space-y-2 text-gray-700">
              <li><strong>Meta Mensal:</strong> <span id="displayMonthlyGoal">—</span> L</li>
              <li><strong>Meta de Redução:</strong> <span id="displayReductionGoal">—</span> %</li>
              <li><strong>Prazo:</strong> <span id="displayPeriodMonths">—</span> meses</li>
            </ul>
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
        <div id="duplicateError" class="hidden mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded">
          Você já registrou consumo para esta data.
        </div>

        <form id="registroForm" action="/inserirconsumodiario" method="POST" novalidate class="max-w-md space-y-4">
          <div>
            <label for="consumoDate" class="block text-gray-700 font-medium mb-1">Data do Consumo</label>
            <input name="DATA_CONSUMO" type="date" id="consumoDate" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
          </div>
          <div>
            <label for="consumoUnit" class="block text-gray-700 font-medium mb-1">Tipo</label>
            <input name="TIPO" type="text" id="tipo" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Informe o tipo" required>
          </div>
          <div>
            <label for="consumoValue" class="block text-gray-700 font-medium mb-1">Quantidade (ex: 2,5 ou 2.5)</label>
            <input name="QUANTIDADE" type="text" id="consumoValue" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Informe a quantidade" required>
          </div>
          <!--<div>
            <label for="consumoUnit" class="block text-gray-700 font-medium mb-1">Tipo</label>
            <input name="TIPO" id="tipo" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" requiredtype="text" name="TIPO"></label>
          </div>-->
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

      <!-- Resumo dos Dados Registrados -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-3 bg-blue-900 text-white font-medium">Resumo dos Dados Registrados</div>
        <div class="p-4 overflow-x-auto">
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
              <tr><td class="px-4 py-2">Fatura</td><td class="px-4 py-2">Maio/2025</td><td class="px-4 py-2">R$ 85,90</td><td class="px-4 py-2"><span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Registrado</span></td></tr>
              <tr><td class="px-4 py-2">Meta Mensal</td><td class="px-4 py-2">Junho/2025</td><td class="px-4 py-2">10.000 L</td><td class="px-4 py-2"><span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Ativa</span></td></tr>
              <tr><td class="px-4 py-2">Consumo</td><td class="px-4 py-2">22/09/2025</td><td class="px-4 py-2">350 L</td><td class="px-4 py-2"><span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Registrado</span></td></tr>
              <tr><td class="px-4 py-2">Consumo</td><td class="px-4 py-2">21/09/2025</td><td class="px-4 py-2">420 L</td><td class="px-4 py-2"><span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Registrado</span></td></tr>
            </tbody>
          </table>
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

      // Função para esconder todas as seções
      function hideAllSections() {
        secaoConta.classList.add('hidden');
        secaoMetas.classList.add('hidden');
        secaoConsumo.classList.add('hidden');
      }

      // Botão Conta
      btnConta.addEventListener('click', () => {
        hideAllSections();
        secaoConta.classList.remove('hidden');
        secaoConta.scrollIntoView({ behavior: 'smooth' });
      });

      // Botão Metas
      btnMetas.addEventListener('click', () => {
        hideAllSections();
        secaoMetas.classList.remove('hidden');
        secaoMetas.scrollIntoView({ behavior: 'smooth' });
      });

      // Botão Consumo
      btnConsumo.addEventListener('click', () => {
        hideAllSections();
        secaoConsumo.classList.remove('hidden');
        secaoConsumo.scrollIntoView({ behavior: 'smooth' });
      });

      // Botões de Cancelar
      cancelBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          hideAllSections();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      });
/*
      // Form de Conta
      const contaForm = document.getElementById('contaForm');
      const successAlertConta = document.getElementById('successAlertConta');
      
      contaForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const mes = document.getElementById('MES_DA_FATURA').value;
        const valor = document.getElementById('VALOR').value;
        
        if (mes && valor) {
          successAlertConta.classList.remove('hidden');
          contaForm.reset();
          setTimeout(() => {
            successAlertConta.classList.add('hidden');
          }, 3000);
        }
      });

      // Form de Metas
      const metasForm = document.getElementById('metasForm');
      const metasAlert = document.getElementById('metasAlert');
      
      metasForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const metaMensal = document.getElementById('monthlyGoal').value;
        const metaReducao = document.getElementById('reductionGoal').value;
        const prazo = document.getElementById('periodMonths').value;
        
        if (metaMensal && metaReducao && prazo) {
          // Atualizar displays
          document.getElementById('displayMonthlyGoal').textContent = metaMensal;
          document.getElementById('displayReductionGoal').textContent = metaReducao;
          document.getElementById('displayPeriodMonths').textContent = prazo;
          
          metasAlert.classList.remove('hidden');
          setTimeout(() => {
            metasAlert.classList.add('hidden');
          }, 3000);
        }
      });

      // Form de Consumo
      const registroForm = document.getElementById('registroForm');
      const successAlertConsumo = document.getElementById('successAlertConsumo');
      
      registroForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const data = document.getElementById('consumoDate').value;
        const quantidade = document.getElementById('consumoValue').value;
        const unidade = document.getElementById('consumoUnit').value;
        
        if (data && quantidade && unidade) {
          successAlertConsumo.classList.remove('hidden');
          registroForm.reset();
          setTimeout(() => {
            successAlertConsumo.classList.add('hidden');
          }, 3000);
        }
      });
*/
      // Definir data atual como padrão
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('consumoDate').value = today;
    });
  </script>
</body>
</html>