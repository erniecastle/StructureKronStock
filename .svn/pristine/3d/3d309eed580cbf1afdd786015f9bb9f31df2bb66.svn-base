$(document).ready(function() {
    loadMyStocks(0);
});


function loadMyStocks(limite) {
    var text = document.getElementById('keyPost');
    var obj = new Object();
    obj.limite = limite;
    if (text.value !== null || text.value !== "") {
        obj.key = text.value;
    }

    var data = $.param(obj);
    var url = "designer/loadMyStocks.php";
    $.post(url, data, function(responsetext) {
        $("#getStocks").html(responsetext);
    });
}

function handle(e) {
    if (e.keyCode === 13) {
        loadMyStocks(0);
    }
    return false;
}














