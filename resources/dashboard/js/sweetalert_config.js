/**
 * SweetAlert2 Configuration - ECOÁGUA
 * Configuração global e funções helper para notificações
 */

const EcoAlert = {
    // Configuração padrão
    defaultConfig: {
        confirmButtonColor: '#1e3a8a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'eco-alert-popup',
            confirmButton: 'eco-alert-confirm',
            cancelButton: 'eco-alert-cancel'
        }
    },

    // Sucesso
    success(title, text = '') {
        return Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            confirmButtonColor: '#10b981',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    },

    // Erro
    error(title, text = '') {
        return Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Entendi'
        });
    },

    // Aviso
    warning(title, text = '') {
        return Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            confirmButtonColor: '#f59e0b',
            confirmButtonText: 'OK'
        });
    },

    // Info
    info(title, text = '') {
        return Swal.fire({
            icon: 'info',
            title: title,
            text: text,
            confirmButtonColor: '#3b82f6',
            confirmButtonText: 'OK'
        });
    },

    // Confirmação
    confirm(title, text, confirmText = 'Sim', cancelText = 'Não') {
        return Swal.fire({
            icon: 'question',
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonColor: '#1e3a8a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            reverseButtons: true
        });
    },

    // Toast (notificação pequena)
    toast(icon, title) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        return Toast.fire({
            icon: icon,
            title: title
        });
    },

    // Loading
    loading(title = 'Carregando...') {
        return Swal.fire({
            title: title,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    },

    // Fechar loading
    close() {
        Swal.close();
    }
};

// Disponibilizar globalmente
window.EcoAlert = EcoAlert;
