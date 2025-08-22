<!-- navegacao.html -->
<nav id="nav" class="fixed top-0 left-0 right-0 h-16 bg-white shadow flex items-center px-6 z-50">
  <!-- Toggle da sidebar -->
  <button id="toggle-sidebar"
          class="text-blue-900 text-2xl focus:outline-none">
    ☰
  </button>

  <!-- Marca -->
  <span class="ml-4 text-xl font-semibold text-blue-900">ECOÁGUA</span>

  <!-- Perfil -->
  <div id="perfilMenu" class="ml-auto relative">
    <button id="perfilToggle"
            class="px-4 py-2 text-blue-900 hover:bg-gray-100 rounded">
      Menu ▾
    </button>
    <div id="perfilDropdown"
         class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded overflow-hidden">
      <a href="menu.html"           class="block px-4 py-2 hover:bg-gray-100">👤 Menu</a>
      <a href="tela_login.html"            class="block px-4 py-2 hover:bg-gray-100">🚪 Sair</a>
    </div>
  </div>
</nav>
