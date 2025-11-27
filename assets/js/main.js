document.addEventListener('DOMContentLoaded', function() {
    
    // Confirmação de Logout
    const logoutBtn = document.getElementById('logout-button');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            const ok = confirm('Tem a certeza que pretende terminar a sessão?');
            if (!ok) {
                e.preventDefault(); // Cancela o clique se disser "Não"
            }
        });
    }

    //Aqui desfoca os botões de login/logout ao carregar em Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { 
            const active = document.activeElement;
            if (active && (active.id === 'login-button' || active.id === 'logout-button')) {
                active.blur();
            }
        }
    });
});