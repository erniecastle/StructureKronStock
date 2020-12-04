$(document).ready(function() {
    loadUsers(0);
    //$("#datepicker").datepicker();
    $('#datepicker').datepicker({dateFormat: 'dd/mm/yy'}).val();
});
$(window).load(function() {
    //downloadJq();
});


function loadUsers(limite) {
    var text = document.getElementById('keyPost');
    var ckbox = $('#a');
    var ckbox2 = $('#b');
    var ckbox3 = $('#c');
    var obj = new Object();
    obj.limite = limite;
    if (text.value !== null || text.value !== "") {
        obj.key = text.value;
    }
    if (ckbox.is(':checked')) {
        obj.show = '1';
    } else if (ckbox2.is(':checked')) {
        obj.show = '2';
    }
    else if (ckbox3.is(':checked')) {
        obj.show = '3';
    }
    var data = $.param(obj);
    var url = "designer/loadUsers.php";
    $.post(url, data, function(responsetext) {
        $("#getUsers").html(responsetext);
    });
}

function handle(e) {
    if (e.keyCode === 13) {
       loadUsers(0);
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









