
<body class="bg-gray-50">
  <!-- Top bar e Sidebar (injetados via JS presumivelmente) -->
  <div id="nav-container"></div>
  <div class="flex">
    <div id="sidebar-container"></div>

    <!-- Conteúdo Principal -->
    <div id="main-content" class="flex-1 pt-16 px-6 pb-6 transition-[margin] duration-300 content-wrapper">

      <h2 class="text-2xl font-semibold text-blue-900 mb-6">Menu</h2>

      <div class="max-w-md mx-auto bg-white shadow rounded-lg p-6 space-y-6 card">
        <div id="successAlert"
             class="hidden bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded">
          Perfil atualizado com sucesso!
        </div>

        <form id="perfilForm" action="/editarusuario" method="POST" class="space-y-4">
          <div>
            <label for="nome" class="block text-gray-700 font-medium mb-1">Nome Completo</label>
            <input name="USER_NOME" type="text" id="nome" value="João da Silva"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                   required>
          </div>
          <div>
            <label for="cpf" class="block text-gray-700 font-medium mb-1">CPF</label>
            <input type="text" id="cpf" value="<?php echo htmlspecialchars($_COOKIE['cookie_cpf']); ?>"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                   required readonly>
          </div>
          <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">E-mail</label>
            <input name="USER_EMAIL" type="email" id="email" value="joao@email.com"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                   required>
          </div>
          <button type="submit"
                  class="w-full bg-blue-900 hover:bg-blue-800 text-white font-medium py-2 rounded transition">
            Salvar Alterações
          </button>
        </form>
      </div>

      <div class="mt-12 max-w-3xl mx-auto perfil-wrapper">
        <form id="configForm" class="space-y-8 max-w-2xl mx-auto">
          <div class="bg-white shadow rounded-lg overflow-hidden card">
            <div class="px-6 py-3 bg-blue-900 text-white font-medium card-header">Conta e Segurança</div>
            <div class="p-6">
              <button type="button"
                      onclick="location.href='redefinirSenha'"
                      class="bg-blue-800 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
                Redefinir Senha
              </button>
            </div>
          </div>

          <div class="bg-white shadow rounded-lg overflow-hidden card">
            <div class="px-6 py-3 bg-blue-900 text-white font-medium card-header">Notificações</div>
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

          <div class="bg-white shadow rounded-lg overflow-hidden card">
            <div class="px-6 py-3 bg-blue-900 text-white font-medium card-header">Preferências</div>
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

          <div class="bg-white shadow rounded-lg overflow-hidden card">
            <div class="px-6 py-3 bg-blue-900 text-white font-medium card-header">Sobre o EcoÁgua</div>
            <div class="p-6 space-y-2 text-gray-700">
              <p>Versão do sistema: <strong>1.0.0</strong></p>
              <p>© 2025 EcoÁgua. Todos os direitos reservados.</p>
            </div>
          </div>

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

  <!--
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Formulário de perfil
      const perfilForm = document.getElementById('perfilForm');
      const successAlert = document.getElementById('successAlert');
      if (perfilForm && successAlert) {
        perfilForm.addEventListener('submit', (e) => {
          e.preventDefault();
          successAlert.classList.remove('hidden');
        });
      }

      // Formulário de configurações
      const configForm = document.getElementById('configForm');
      const configAlert = document.getElementById('configAlert');
      const darkModeCheckbox = document.getElementById('darkMode');

      if (configForm && configAlert) {
        configForm.addEventListener('submit', (e) => {
          e.preventDefault();
          configAlert.classList.remove('hidden');
        });
      }

      // Alternar modo escuro
      if (darkModeCheckbox) {
        darkModeCheckbox.addEventListener('change', () => {
          document.documentElement.classList.toggle('dark', darkModeCheckbox.checked);
          localStorage.setItem('ecoagua-dark-mode', darkModeCheckbox.checked);
        });

        // Restaurar preferência de modo escuro
        const savedDarkMode = localStorage.getItem('ecoagua-dark-mode');
        if (savedDarkMode === 'true') {
          darkModeCheckbox.checked = true;
          document.documentElement.classList.add('dark');
        }
      }
    });
  </script>-->
</body>
</html>
