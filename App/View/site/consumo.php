<body class="bg-gray-50">

  <style>
    .content-wrapper {
      margin-top: calc(var(--nav-height) + 1rem);
    }

    .conta-card,
    .metas-card,
    .current-metas-card,
    .registro-card {
      border-radius: 0.75rem;
      overflow: hidden;
    }

    #successAlert,
    #monthError,
    #valueError,
    #dateError,
    #quantityError,
    #duplicateError {
      font-size: 0.95rem;
      margin-bottom: 1rem;
    }
  </style>

  <div class="flex">
    <!-- Conteúdo principal -->
    <div class="flex-1 pt-16 px-6 pb-6 transition-[margin] duration-300">
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">Inserir Valor da Conta</h2>

      <div class="max-w-md mx-auto">
        <!--<div id="successAlert" class="hidden mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
          Valor da conta registrado com sucesso!
        </div>
        <div id="monthError" class="hidden mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"></div>
        <div id="valueError" class="hidden mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"></div>-->

        <form id="contaForm" action="/InserirValordaConta" method="POST" novalidate class="space-y-5">
          <div>
            <label for="contaMonth" class="block text-gray-700 font-medium mb-1">Mês da Fatura</label>
            <input name="MES_DA_FATURA" type="month" id="MES_DA_FATURA" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
          </div>
          <div>
            <label for="contaValue" class="block text-gray-700 font-medium mb-1">Valor (R$ ex: 123,45)</label>
            <input name="VALOR" type="text" id="VALOR" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Informe o valor da fatura" required>
          </div>
          <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 rounded transition">Registrar Valor</button>
        </form>
      </div>
    </div>

    <div class="flex-1 pt-16 px-6 pb-6 transition-[margin] duration-300">
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">Minhas Metas de Consumo</h2>
      <div class="max-w-lg mx-auto">
        <div id="metasAlert" class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg hidden">
          Metas salvas com sucesso!
        </div>

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
          <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 rounded transition">Salvar Metas</button>
        </form>
      </div>

      <div class="mt-10 max-w-lg mx-auto bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold text-blue-900 mb-4">Metas Atuais</h3>
        <ul class="space-y-2 text-gray-700">
          <li><strong>Meta Mensal:</strong> <span id="displayMonthlyGoal">—</span> L</li>
          <li><strong>Meta de Redução:</strong> <span id="displayReductionGoal">—</span> %</li>
          <li><strong>Prazo:</strong> <span id="displayPeriodMonths">—</span> meses</li>
        </ul>
      </div>
    </div>

    <div class="flex-1 pt-16 px-6 pb-6 transition-[margin] duration-300">
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">Registrar Consumo Diário</h2>

      <div class="max-w-md mx-auto">
        <div id="successAlert" class="hidden mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">Consumo registrado com sucesso!</div>
        <div id="dateError" class="hidden mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"></div>
        <div id="quantityError" class="hidden mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded"></div>
        <div id="duplicateError" class="hidden mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded">Você já registrou consumo para esta data.</div>

        <form id="registroForm" action="/inserirconsumodiario" method="POST" novalidate class="space-y-5">
          <div>
            <label for="consumoDate" class="block text-gray-700 font-medium mb-1">Data do Consumo</label>
            <input name="DATA_CONSUMO" type="date" id="consumoDate" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
          </div>
          <div>
            <label for="consumoUnit" class="block text-gray-700 font-medium mb-1">Tipo</label>
            <input name="TIPO" type="text" id="tipoTIPO" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Informe o tipo" required>
          </div>
          <div>
            <label for="consumoValue" class="block text-gray-700 font-medium mb-1">Quantidade (ex: 2,5 ou 2.5)</label>
            <input name="QUANTIDADE" type="text" id="consumoValue" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Informe a quantidade" required>
          </div>
          <div>
            <label for="consumoUnit" class="block text-gray-700 font-medium mb-1">Tipo</label>
            <input name="TIPO" id="tipoTIPO" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" requiredtype="text" name="TIPO"></label>
          </div>
          <div>
            <label for="consumoUnit" class="block text-gray-700 font-medium mb-1">Unidade</label>
            <select name="UNIDADE" id="consumoUnit" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
              <option value="L">Litros (L)</option>
              <option value="m³">Metros Cúbicos (m³)</option>
              <option value="mL">Mililitros (mL)</option>
            </select>
          </div>
          <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 rounded transition">Registrar Consumo</button>
        </form>
      </div>
    </div>
  </div>
  
</body>
</html>
