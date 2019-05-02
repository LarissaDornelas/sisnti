document.getElementById('checkPatrimonio').onclick = function () {
    if (document.getElementById('checkPatrimonio').checked) {
        document.getElementById('patrimonio').disabled = true;
    }
    else {
        document.getElementById('patrimonio').disabled = false;
    }
}