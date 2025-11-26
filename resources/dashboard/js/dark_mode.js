/**
 * Dark Mode Global - ECOÁGUA
 * Sistema de tema escuro aplicável em todas as páginas
 */

(function() {
    'use strict';

    // Aplicar dark mode baseado na sessão (já aplicado via PHP no header)
    function initDarkMode() {
        // Verifica se o body ou documentElement já tem a classe (aplicada pelo PHP)
        const isDarkMode = document.body.classList.contains('dark-mode') ||
                          document.documentElement.classList.contains('dark-mode');

        // Sincronizar a classe entre documentElement e body
        if (isDarkMode) {
            document.documentElement.classList.add('dark-mode');
            document.body.classList.add('dark-mode');
        }

        // Verificar se existe o toggle na página
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            // Sincronizar o estado do checkbox com o tema atual
            darkModeToggle.checked = isDarkMode;

            // Adicionar listener apenas se o toggle existir
            darkModeToggle.addEventListener('change', toggleDarkMode);
        }
    }

    // Função para alternar dark mode
    function toggleDarkMode(event) {
        const checkbox = event.target;
        const darkModeValue = checkbox.checked ? 1 : 0;

        // Aplicar/remover classe imediatamente em ambos os elementos
        if (darkModeValue) {
            document.documentElement.classList.add('dark-mode');
            document.body.classList.add('dark-mode');
        } else {
            document.documentElement.classList.remove('dark-mode');
            document.body.classList.remove('dark-mode');
        }

        // Salvar preferência no servidor
        fetch('/toggledarkmode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'dark_mode=' + darkModeValue
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Erro ao salvar preferência:', data.message);
                // Reverter em caso de erro
                checkbox.checked = !checkbox.checked;
                document.documentElement.classList.toggle('dark-mode');
                document.body.classList.toggle('dark-mode');
            }
            // Não recarrega a página - o tema já foi aplicado instantaneamente
        })
        .catch(error => {
            console.error('Erro:', error);
            // Reverter em caso de erro
            checkbox.checked = !checkbox.checked;
            document.documentElement.classList.toggle('dark-mode');
            document.body.classList.toggle('dark-mode');
        });
    }

    // Inicializar quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDarkMode);
    } else {
        initDarkMode();
    }
})();
