<?php 
    session_start();
    $cpf_exibir = strval($_COOKIE['cookie_cpf']);
    while(strlen($cpf_exibir) < 11){
        $cpf_exibir = "0". $cpf_exibir;
    }
    $cpf_exibir = substr_replace($cpf_exibir, ".", 3, 0);
    $cpf_exibir = substr_replace($cpf_exibir, ".", 7, 0);
    $cpf_exibir = substr_replace($cpf_exibir, "-", 11, 0);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoÁgua - Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'eco-blue': {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">💧</span>
                    </div>
                    <h1 class="text-2xl font-bold bg-blue-600 bg-clip-text text-transparent">
                        EcoÁgua
                    </h1>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Dashboard</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">Relatórios</a>
                    <a href="#" class="text-blue-600 font-medium">Perfil</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-4">
        <!-- Page Title -->
        <div class="text-center mb-6">
            <h2 class="text-4xl font-bold text-gray-800 mb-3">Meu Perfil</h2>
            <p class="text-gray-600 text-lg">Gerencie suas informações pessoais e preferências</p>
        </div>

        <!-- Profile Form Section -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white text-xl">👤</span>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800">Informações Pessoais</h3>
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
            <input type="text" id="cpf" value="<?php echo htmlspecialchars($cpf_exibir); ?>"
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
                  class="w-full bg-blue-600 hover:bg-blue-800 text-white font-medium py-2 rounded transition">
            💾 Salvar Alterações
          </button>
        </form>
      </div>

                <div id="successAlert" class="hidden mb-6 bg-green-50 border-l-4 border-green-400 text-green-800 p-4 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-green-500 mr-2">✅</span>
                        Perfil atualizado com sucesso!
                    </div>
                </div>

                
            </div>
        </div>

        <!-- Settings Sections -->
        <div class="max-w-4xl mx-auto">
            <form id="configForm" class="space-y-8">
                
                <!-- Security Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="w-full bg-blue-600 px-8 py-4">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <span class="mr-3">🔒</span>
                            Conta e Segurança
                        </h3>
                    </div>
                    <div class="p-8">
                        <button type="button"
                                onclick="location.href='redefinirSenha'"
                                class="w-full bg-blue-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold py-3 rounded-lg transition-all transform hover:scale-105 shadow-lg">
                            🔑 Redefinir Senha
                        </button>
                    </div>
                </div>

                <!-- Notifications Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-blue-600 shadow-lg px-8 py-4">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <span class="mr-3">🔔</span>
                            Notificações
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <input id="notifyAlerts" type="checkbox" 
                                   class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                            <label for="notifyAlerts" class="ml-4 text-gray-700 font-medium">
                                📧 E-mail de alerta de consumo alto
                            </label>
                        </div>
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <input id="weeklySummary" type="checkbox" 
                                   class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="weeklySummary" class="ml-4 text-gray-700 font-medium">
                                📊 Resumo semanal por e-mail
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Preferences Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-blue-600 shadow-lg px-8 py-4">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <span class="mr-3">⚙️</span>
                            Preferências
                        </h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label for="unitSelect" class="block text-gray-700 font-medium mb-3">
                                📏 Unidade de medida
                            </label>
                            <select id="unitSelect" 
                                    class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option value="L">Litros (L)</option>
                                <option value="m³">Metros cúbicos (m³)</option>
                            </select>
                        </div>
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <input id="darkMode" type="checkbox" 
                                   class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="darkMode" class="ml-4 text-gray-700 font-medium">
                                🌙 Modo Escuro
                            </label>
                        </div>
                    </div>
                </div>

                <!-- About Section -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-blue-600 shadow-lg px-8 py-4">
                        <h3 class="text-xl font-semibold text-white flex items-center">
                            <span class="mr-3">ℹ️</span>
                            Sobre o EcoÁgua
                        </h3>
                    </div>
                    <div class="p-8 bg-gradient-to-r from-gray-50 to-blue-50">
                        <div class="grid md:grid-cols-2 gap-6 text-gray-700">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">📱</span>
                                <div>
                                    <p class="font-medium">Versão do sistema</p>
                                    <p class="text-blue-600 font-bold text-lg">1.0.0</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">©️</span>
                                <div>
                                    <p class="font-medium">© 2025 EcoÁgua</p>
                                    <p class="text-sm text-gray-500">Todos os direitos reservados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="text-center">
                    <button type="submit"
                            class="bg-blue-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold py-4 px-12 rounded-full transition-all transform hover:scale-105 shadow-xl text-lg">
                        💾 Salvar Todas as Configurações
                    </button>
                    <div id="configAlert"
                         class="hidden mt-6 bg-green-50 border-l-4 border-green-400 text-green-800 p-4 rounded-lg mx-auto max-w-md">
                        <div class="flex items-center justify-center">
                            <span class="text-green-500 mr-2">✅</span>
                            Configurações salvas com sucesso!
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-600">
                <p class="flex items-center justify-center mb-2">
                    <span class="text-blue-500 mr-2">💧</span>
                    Economize água, preserve o futuro
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Formulário de perfil
            const perfilForm = document.getElementById('perfilForm');
            const successAlert = document.getElementById('successAlert');
            if (perfilForm && successAlert) {
                perfilForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    successAlert.classList.remove('hidden');
                    setTimeout(() => {
                        successAlert.classList.add('hidden');
                    }, 3000);
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
                    setTimeout(() => {
                        configAlert.classList.add('hidden');
                    }, 3000);
                });
            }

            // Alternar modo escuro
            if (darkModeCheckbox) {
                darkModeCheckbox.addEventListener('change', () => {
                    document.documentElement.classList.toggle('dark', darkModeCheckbox.checked);
                    // Simula salvamento local (não funciona em artifacts)
                    console.log('Modo escuro:', darkModeCheckbox.checked);
                });
            }

<<<<<<< HEAD
            // Animação suave ao carregar
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
=======
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
>>>>>>> 5d937d036beaa8cde43e456bdeadb6f336aea347
        });

        // Função para detectar quando chegar perto do fim da página
        function checkScrollPosition() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            
            // Calcula se está nos últimos 20% da página
            const scrollPercentage = (scrollTop + windowHeight) / documentHeight;
            const pdfButton = document.getElementById('pdfButton');
            const tooltip = document.getElementById('pdfTooltip');
            
            if (scrollPercentage >= 0.8) { // 80% da página
                // Mostra o botão com animação
                pdfButton.classList.remove('opacity-0', 'invisible');
                pdfButton.classList.add('opacity-100', 'visible', 'bounce-subtle');
            } else {
                // Esconde o botão
                pdfButton.classList.add('opacity-0', 'invisible');
                pdfButton.classList.remove('opacity-100', 'visible', 'bounce-subtle');
                tooltip.classList.add('opacity-0', 'invisible');
            }
        }
<<<<<<< HEAD
        
        // Função para gerar PDF (placeholder)
        function generatePDF() {
            // Aqui você colocaria sua lógica real de geração de PDF
            alert('🎉 Gerando relatório PDF!\n\nEm uma implementação real, aqui seria chamada a função para gerar o PDF.');
            
            // Exemplo de como poderia ser:
            // window.print(); // Para impressão
            // ou
            // fetch('/api/generate-pdf', { method: 'POST' })...
        }
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const pdfButton = document.getElementById('pdfButton');
            const tooltip = document.getElementById('pdfTooltip');
            
            // Listener para scroll
            window.addEventListener('scroll', checkScrollPosition);
            
            // Tooltip no hover
            pdfButton.addEventListener('mouseenter', function() {
                tooltip.classList.remove('opacity-0', 'invisible');
                tooltip.classList.add('opacity-100', 'visible');
            });
            
            pdfButton.addEventListener('mouseleave', function() {
                tooltip.classList.add('opacity-0', 'invisible');
                tooltip.classList.remove('opacity-100', 'visible');
            });
            
            // Feedback visual no click
            pdfButton.addEventListener('click', function() {
                this.classList.add('animate-ping');
                setTimeout(() => {
                    this.classList.remove('animate-ping');
                }, 600);
            });
        });
    </script>
=======
      }
    });
  </script>-->
>>>>>>> 5d937d036beaa8cde43e456bdeadb6f336aea347
</body>
</html>