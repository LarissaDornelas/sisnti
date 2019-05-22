document.getElementById('checkPatrimony').onclick = function () {
    if (document.getElementById('checkPatrimony').checked) {
        document.getElementById('patrimony').disabled = true;
    }
    else {
        document.getElementById('patrimony').disabled = false;
    }
}