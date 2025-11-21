function toggleForm() {
    var form = document.getElementById('form-container');
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        form.scrollIntoView({behavior: "smooth"});
    } else {
        form.style.display = 'none';
    }
}

function toggleDeleteMode() {
    var btns = document.querySelectorAll('.delete-overlay');
    var mainBtn = document.getElementById('btnRemove');
    
    var isHidden = true;
    if (btns.length > 0) {
        isHidden = (btns[0].style.display === 'none' || btns[0].style.display === '');
    }

    btns.forEach(function(btn) {
        btn.style.display = isHidden ? 'block' : 'none';
    });

    if (isHidden) {
        mainBtn.textContent = "Cancel";
        mainBtn.style.background = "#777";
    } else {
        mainBtn.textContent = "Remover Música";
        mainBtn.style.background = "#FF3D00";
    }
}