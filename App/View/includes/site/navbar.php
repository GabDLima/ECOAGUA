<!-- NAVBAR -->
<nav class="fixed top-0 left-0 right-0 h-16 bg-white shadow-md flex items-center px-6 z-50">

  <!-- Logo / Marca -->
  <span class="text-xl font-bold text-blue-900 tracking-wide">ECOÁGUA</span>

  <!-- Links de navegação principais -->
  <div class="ml-8 space-x-4 hidden sm:flex">
    <a href="dashboard" class="text-blue-900 hover:text-blue-600 font-medium">Dashboard</a>
    <a href="consumo" class="text-blue-900 hover:text-blue-600 font-medium">Consumo</a>
  </div>

  <!-- Menu de perfil -->
  <div class="ml-auto relative">
    <button id="perfilToggle" class="px-4 py-2 text-blue-900 hover:bg-gray-100 rounded transition duration-150">
      Menu ▾
    </button>
    <div id="perfilDropdown"
         class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 shadow-lg rounded-md overflow-hidden z-50">
      <a href="menu" class="block px-4 py-2 text-sm text-blue-900 hover:bg-gray-100">👤 Menu</a>
      <a href="/" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">🚪 Sair</a>
    </div>
  </div>
</nav>

<script>
  document.getElementById("perfilToggle").addEventListener("click", function () {
    const dropdown = document.getElementById("perfilDropdown");
    dropdown.classList.toggle("hidden");
  });

  // Opcional: fechar o dropdown ao clicar fora
  window.addEventListener("click", function (e) {
    const perfilToggle = document.getElementById("perfilToggle");
    const perfilDropdown = document.getElementById("perfilDropdown");
    if (!perfilToggle.contains(e.target) && !perfilDropdown.contains(e.target)) {
      perfilDropdown.classList.add("hidden");
    }
  });
</script>
