
document.addEventListener('DOMContentLoaded', function() {
    
    const filterSelect = document.getElementById('genreFilter');
    const songCards = document.querySelectorAll('.song-card');

    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            const selectedGenreId = this.value;

            songCards.forEach(card => {
            
                const cardGenreId = card.getAttribute('data-genre-id');

                // Se escolheu "all" OU se o ID for igual, mostra. Senão, esconde.
                if (selectedGenreId === 'all' || selectedGenreId === cardGenreId) {
                    card.style.display = 'block';
                    card.style.opacity = '1'; 
                } else {
                    card.style.display = 'none';
                    card.style.opacity = '0';
                }
            });
        });
    }
});



function toggleForm() {
    var form = document.getElementById('form-container');
    if (form) {
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
            form.scrollIntoView({behavior: "smooth"});
        } else {
            form.style.display = 'none';
        }
    }
}

function toggleDeleteMode() {
    var btns = document.querySelectorAll('.delete-overlay');
    var mainBtn = document.getElementById('btnRemove');
    
    var isHidden = true;
    if (btns.length > 0) {
        // Vê se o primeiro botão está escondido para decidir o estado
        isHidden = (btns[0].style.display === 'none' || btns[0].style.display === '');
    }

    // Mostra ou esconde todos os "X" vermelhos
    btns.forEach(function(btn) {
        btn.style.display = isHidden ? 'block' : 'none';
    });

    // Muda o texto e a cor do botão principal
    if (mainBtn) {
        if (isHidden) {
            mainBtn.textContent = "Cancel";
            mainBtn.style.background = "#777";
        } else {
            mainBtn.textContent = "Remove Music";
            mainBtn.style.background = "#FF3D00";
        }
    }
}