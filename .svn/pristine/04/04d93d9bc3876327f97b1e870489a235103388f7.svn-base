$(document).ready(function() {
    loadStocks(0);
});


function loadStocks(limite) {
    var text = document.getElementById('keyPost');
    var obj = new Object();
    obj.limite = limite;
    if (text.value !== null || text.value !== "") {
        obj.key = text.value;
    }
   
    var data = $.param(obj);
    var url = "designer/loadStocks.php";
    $.post(url, data, function(responsetext) {
        $("#getStocks").html(responsetext);
    });
}

function handle(e) {
    if (e.keyCode === 13) {
        loadStocks(0);
    }
    return false;
}


var ND = ND || (function() {
    var _args = {}; // private

    return {
        init: function(Args) {
            _args = Args;
            // some other initialising
        },
        sick: function() {
            return _args[0];
        }
    };
}());











