<body class="bg-gray-50">
  <!-- Top bar -->
  <div id="nav-container"></div>

  <div class="flex">
    <!-- Sidebar -->
    <div id="sidebar-container"></div>

    <!-- Conteúdo Principal -->
    <div id="main-content" class="flex-1 pt-16 px-6 pb-6 transition-[margin] duration-300">

      <!-- Edição de Dados Pessoais -->
      <h2 class="text-2xl font-semibold text-blue-900 mb-6">Menu</h2>

      <div class="max-w-md mx-auto bg-white shadow rounded-lg p-6 space-y-6">
        <div id="successAlert"
             class="hidden bg-green-100 border-l-4 border-green-500 text-green-800 p-4">
          Perfil atualizado com sucesso!
        </div>

        <form id="perfilForm" class="space-y-4">
          <div>
            <label for="nome" class="block text-gray-700 font-medium mb-1">
              Nome Completo
            </label>
            <input type="text" id="nome" value="João da Silva"
                   class="w-full border border-gray-300 rounded px-3 py-2 
                          focus:outline-none focus:ring-2 focus:ring-blue-300" required>
          </div>
          <div>
            <label for="cpf" class="block text-gray-700 font-medium mb-1">
              CPF
            </label>
            <input type="text" id="cpf" value="123.456.789-00"
                   class="w-full border border-gray-300 rounded px-3 py-2 
                          focus:outline-none focus:ring-2 focus:ring-blue-300" required>
          </div>
          <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">
              E-mail
            </label>
            <input type="email" id="email" value="joao@email.com"
                   class="w-full border border-gray-300 rounded px-3 py-2 
                          focus:outline-none focus:ring-2 focus:ring-blue-300" required>
          </div>
          <button type="submit"
                  class="w-full bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 rounded transition">
            Salvar Alterações
          </button>
        </form>

        <div class="pt-4 border-t border-gray-200">
          <a href="formularioSenha.html"
             class="block text-center text-blue-900 hover:underline font-medium">
            Redefinir Senha
          </a>
        </div>
      </div>

      <div class="mt-12 max-w-3xl mx-auto">

      <form id="configForm" class="space-y-8 max-w-2xl mx-auto">
        <!-- Conta e Segurança -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-6 py-3 bg-blue-900 text-white font-medium">
            Conta e Segurança
          </div>
          <div class="p-6">
            <button type="button"
                    onclick="location.href='formularioSenha.html'"
                    class="bg-blue-800 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
              Redefinir Senha
            </button>
          </div>
        </div>

        <!-- Notificações -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-6 py-3 bg-blue-900 text-white font-medium">
            Notificações
          </div>
          <div class="p-6 space-y-4">
            <div class="flex items-center">
              <input id="notifyAlerts" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
              <label for="notifyAlerts" class="ml-3 text-gray-700">E-mail de alerta de consumo alto</label>
            </div>
            <div class="flex items-center">
              <input id="weeklySummary" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="weeklySummary" class="ml-3 text-gray-700">Resumo semanal por e-mail</label>
            </div>
          </div>
        </div>

        <!-- Preferências -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-6 py-3 bg-blue-900 text-white font-medium">
            Preferências
          </div>
          <div class="p-6 space-y-4">
            <div>
              <label for="unitSelect" class="block text-gray-700 font-medium mb-1">Unidade de medida</label>
              <select id="unitSelect" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="L">Litros (L)</option>
                <option value="m³">Metros cúbicos (m³)</option>
              </select>
            </div>
            <div class="flex items-center">
              <input id="darkMode" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="darkMode" class="ml-3 text-gray-700">Modo Escuro</label>
            </div>
          </div>
        </div>

        <!-- Sobre -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
          <div class="px-6 py-3 bg-blue-900 text-white font-medium">
            Sobre o EcoÁgua
          </div>
          <div class="p-6 space-y-2 text-gray-700">
            <p>Versão do sistema: <strong>1.0.0</strong></p>
            <p>© 2025 EcoÁgua. Todos os direitos reservados.</p>
          </div>
        </div>

        <!-- Salvar e feedback -->
        <div class="space-y-4">
          <button type="submit"
                  class="w-full bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 rounded transition">
            Salvar Configurações
          </button>
          <div id="configAlert"
               class="hidden bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded">
            Configurações salvas com sucesso!
          </div>
        </div>
      </form>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="js/navegacao.js"></script>
  <script src="js/sidebar.js"></script>
  <script src="js/perfil.js"></script>
</body>