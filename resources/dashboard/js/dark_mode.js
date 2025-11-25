/**
 * Dark Mode Global - ECOÁGUA
 * Sistema de tema escuro aplicável em todas as páginas
 */

(function() {
    'use strict';

    // Aplicar dark mode baseado na sessão (já aplicado via PHP no header)
    function initDarkMode() {
        // Verifica se o body já tem a classe (aplicada pelo PHP)
        const isDarkMode = document.body.classList.contains('dark-mode');

        // Verificar se existe o toggle na página
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            darkModeToggle.checked = isDarkMode;

            // Adicionar listener apenas se o toggle existir
            darkModeToggle.addEventListener('change', toggleDarkMode);
        }
    }

    // Função para alternar dark mode
    function toggleDarkMode() {
        const darkModeValue = this.checked ? 1 : 0;

        // Aplicar/remover classe imediatamente
        if (darkModeValue) {
            document.body.classList.add('dark-mode');
        } else {
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
            if (data.success) {
                // Recarregar a página para aplicar em todos os elementos
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            } else {
                console.error('Erro ao salvar preferência:', data.message);
                // Reverter em caso de erro
                this.checked = !this.checked;
                document.body.classList.toggle('dark-mode');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            // Reverter em caso de erro
            this.checked = !this.checked;
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
