<!-- NAVBAR MELHORADA -->
<nav class="fixed top-0 left-0 right-0 h-16 bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 shadow-lg flex items-center px-6 z-50 backdrop-blur-sm bg-opacity-95">

  <!-- Logo / Marca com ícone -->
  <div class="flex items-center space-x-2">
    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">
      <span class="text-2xl">💧</span>
    </div>
    <span class="text-2xl font-bold text-white tracking-wide hover:text-blue-200 transition-colors cursor-pointer" onclick="window.location.href='/dashboard'">
      ECOÁGUA
    </span>
  </div>

  <!-- Links de navegação principais -->
  <div class="ml-8 space-x-1 hidden md:flex">
    <a href="/dashboard" class="nav-link px-4 py-2 text-white hover:bg-white hover:bg-opacity-20 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2">
      <span>📊</span>
      <span>Dashboard</span>
    </a>
    <a href="/consumo" class="nav-link px-4 py-2 text-white hover:bg-white hover:bg-opacity-20 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2">
      <span>💧</span>
      <span>Consumo</span>
    </a>
    <a href="/metas" class="nav-link px-4 py-2 text-white hover:bg-white hover:bg-opacity-20 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2">
      <span>🎯</span>
      <span>Metas</span>
    </a>
  </div>

  <!-- Menu mobile (hamburguer) -->
  <button id="mobileMenuToggle" class="ml-auto md:hidden text-white p-2 hover:bg-white hover:bg-opacity-20 rounded-lg transition-all">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <!-- Indicador de consumo (opcional - pode esconder em mobile) -->
  <div class="ml-auto mr-4 hidden lg:flex items-center space-x-2 bg-white bg-opacity-10 px-4 py-2 rounded-full">
    <span class="text-white text-sm">Consumo hoje:</span>
    <span class="text-green-300 font-bold text-sm">
      <?php 
        if (isset($this->view->consumoHoje)) {
          echo number_format($this->view->consumoHoje, 0, ',', '.') . ' L';
        } else {
          echo '-- L';
        }
      ?>
    </span>
  </div>

  <!-- Menu de perfil (desktop) -->
  <div class="ml-auto md:ml-4 relative hidden md:block">
    <button id="perfilToggle" class="flex items-center space-x-3 px-4 py-2 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all duration-200 group">
      <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
        <span class="text-lg">👤</span>
      </div>
      <div class="text-left hidden xl:block">
        <span class="block text-sm font-medium"><?= htmlspecialchars($_COOKIE['cookie_nome']) ?></span>
        <span class="block text-xs text-blue-200">Ver perfil</span>
      </div>
      <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
      </svg>
    </button>
    
    <!-- Dropdown do perfil -->
    <div id="perfilDropdown"
         class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 shadow-2xl rounded-xl overflow-hidden z-50 animate-fadeIn">
      <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-4 py-3 text-white">
        <p class="font-semibold"><?= htmlspecialchars($_COOKIE['cookie_nome']) ?></p>
        <p class="text-xs text-blue-200"><?= htmlspecialchars($_COOKIE['cookie_email'] ?? 'usuario@email.com') ?></p>
      </div>
      <div class="py-2">
        <a href="/menu" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors">
          <span class="text-xl">👤</span>
          <div>
            <p class="font-medium text-sm">Meu Perfil</p>
            <p class="text-xs text-gray-500">Configurações da conta</p>
          </div>
        </a>
        <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors">
          <span class="text-xl">📊</span>
          <div>
            <p class="font-medium text-sm">Dashboard</p>
            <p class="text-xs text-gray-500">Visão geral</p>
          </div>
        </a>
        <div class="border-t border-gray-200 my-2"></div>
        <a href="/sair" onclick="return confirm('Tem certeza que deseja sair?')" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
          <span class="text-xl">🚪</span>
          <div>
            <p class="font-medium text-sm">Sair</p>
            <p class="text-xs text-red-400">Encerrar sessão</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Menu Mobile (slide-in) -->
<div id="mobileMenu" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden">
  <div class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl transform translate-x-full transition-transform duration-300" id="mobileMenuPanel">
    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-900 to-blue-800">
      <span class="text-white font-bold text-lg">Menu</span>
      <button id="closeMobileMenu" class="text-white p-2 hover:bg-white hover:bg-opacity-20 rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    
    <div class="p-4 border-b border-gray-200">
      <div class="flex items-center space-x-3">
        <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center">
          <span class="text-2xl">👤</span>
        </div>
        <div>
          <p class="font-semibold text-gray-800"><?= htmlspecialchars($_COOKIE['cookie_nome']) ?></p>
          <p class="text-xs text-gray-500">Ver perfil</p>
        </div>
      </div>
    </div>

    <nav class="p-4 space-y-2">
      <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">
        <span class="text-xl">📊</span>
        <span class="font-medium">Dashboard</span>
      </a>
      <a href="/consumo" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">
        <span class="text-xl">💧</span>
        <span class="font-medium">Consumo</span>
      </a>
      <a href="/metas" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">
        <span class="text-xl">🎯</span>
        <span class="font-medium">Metas</span>
      </a>
      <a href="/menu" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">
        <span class="text-xl">⚙️</span>
        <span class="font-medium">Configurações</span>
      </a>
      <div class="border-t border-gray-200 my-2"></div>
      <a href="/sair" onclick="return confirm('Tem certeza que deseja sair?')" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
        <span class="text-xl">🚪</span>
        <span class="font-medium">Sair</span>
      </a>
    </nav>
  </div>
</div>

<style>
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
  }

  /* Highlight da página atual */
  .nav-link.active {
    background-color: rgba(255, 255, 255, 0.2);
    border-bottom: 2px solid white;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Desktop dropdown
    const perfilToggle = document.getElementById("perfilToggle");
    const perfilDropdown = document.getElementById("perfilDropdown");

    if (perfilToggle) {
      perfilToggle.addEventListener("click", function (e) {
        e.stopPropagation();
        perfilDropdown.classList.toggle("hidden");
      });
    }

    // Fechar dropdown ao clicar fora
    window.addEventListener("click", function (e) {
      if (perfilDropdown && !perfilDropdown.classList.contains("hidden")) {
        if (!perfilToggle.contains(e.target) && !perfilDropdown.contains(e.target)) {
          perfilDropdown.classList.add("hidden");
        }
      }
    });

    // Mobile menu
    const mobileMenuToggle = document.getElementById("mobileMenuToggle");
    const mobileMenu = document.getElementById("mobileMenu");
    const mobileMenuPanel = document.getElementById("mobileMenuPanel");
    const closeMobileMenu = document.getElementById("closeMobileMenu");

    function openMobileMenu() {
      mobileMenu.classList.remove("hidden");
      setTimeout(() => {
        mobileMenuPanel.classList.remove("translate-x-full");
      }, 10);
    }

    function closeMobileMenuFunc() {
      mobileMenuPanel.classList.add("translate-x-full");
      setTimeout(() => {
        mobileMenu.classList.add("hidden");
      }, 300);
    }

    if (mobileMenuToggle) {
      mobileMenuToggle.addEventListener("click", openMobileMenu);
    }

    if (closeMobileMenu) {
      closeMobileMenu.addEventListener("click", closeMobileMenuFunc);
    }

    if (mobileMenu) {
      mobileMenu.addEventListener("click", function(e) {
        if (e.target === mobileMenu) {
          closeMobileMenuFunc();
        }
      });
    }

    // Highlight da página atual
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
      }
    });

    // Opcional: Buscar consumo do dia (exemplo)
    // Você pode implementar uma chamada AJAX aqui
    const consumoHoje = document.getElementById('consumoHoje');
    if (consumoHoje) {
      // Exemplo estático - substituir por chamada real ao backend
      setTimeout(() => {
        consumoHoje.textContent = '85 L';
      }, 1000);
    }
  });
</script>