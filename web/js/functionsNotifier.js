var posicion = null;
var onMessage = false;
jQuery(document).ready(function () {
    //  alert(screen.width + " x " + screen.height);
    //alert("left: " + posicion.left + ", top: " + posicion.top); // con eso coges la posición del elemento
    if (document.getElementById("pull")) {

        var pull = $('#pull');
        menu = $('nav ul');
        menuHeight = menu.height();

        $(pull).on('click', function (e) {
            menu.slideToggle();
            e.preventDefault();
        });
        $(window).resize(function () {
            var w = $(window).width();
            if (w > 320 && menu.is(':hidden')) {
                menu.removeAttr('style');
            }
        });
    }

    $('#commentForm').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $('#commentForm').submit(function () {
        //Rest of code
        if (!onMessage) {
            $("#textTitleStock").prop('disabled', false);
        }
        onMessage = false;

    });


    if (document.getElementById("notificationLink")) {
        $("#notificationLink").click(function ()
        {
            $("#notificationContainer").fadeToggle(300);
            $("#notification_count").fadeOut("slow");
            return false;
        });

        //Document Click
        $(document).click(function ()
        {
            $("#notificationContainer").hide();
        });
        //Popup Click
        $("#notificationContainer").click(function ()
        {
            return false
        });
    }

});


$(window).scroll(function () {
    //var mq = window.matchMedia("(min-width: 540px)");
    if (document.getElementById("block_banner")) {
        if (posicion !== null) {
            if (posicion.top !== null) {
                if (document.getElementById("circular")) {
                    var img = document.getElementById('circular');
                    if ($(window).scrollTop() > posicion.top + 130)
                    {
                        if (window.matchMedia("(min-width: 800px)").matches) {
                            //img.style.display = 'block';
                            $("#block_banner").css("position", "fixed");
                            $("#block_banner").css("width", "30%");
                            $("#block_banner").css("top", 3);
                            if ($("#block_banner").offset().top + 280 >=
                                    $("#contentRandom").offset().top) {
                                $("#block_banner").css("position", "relative");
                            }
                        } else {
                            img.style.display = 'none';
                        }
                    } else {
                        //lock it back into place
                        $("#block_banner").css("position", "relative");
                        $("#block_banner").css("width", "100%");
                    }
                }
            }
        }
    }
});

$(window).load(function () {
//    if (document.getElementById("randomDownEntries")) {
//        randomPs();
//    }
    // downloadJq();
});

$(window).onbeforeunload = function () {
    // Do something
    //callFunction();
};

function loadList(limite) {
    var url = "designer/loadMainListMore.php";
    data = {limite: limite};
    $.post(url, data, function (responsetext) {
        $(".posts").append(responsetext);
    });
    //setTimeout(window.scrollTo(0, 0), 100);
    if ($('#entriesList').length) {//if exists

        if (document.getElementById("load-more")) {
            $('body,html').animate({
                scrollTop: $('#load-more').offset().top
            }, 1500);
        }
    }
    $("#load-more").remove();
}

function senderValidation(key) {

    var name = document.getElementById("commentFormName").value;

    if (name === "" || name === "Name/Nombre:")
    {
        document.getElementById("commentFormName").focus();
        $(".error-Comment" + key.toString()).fadeIn(1700).text("Es necesario un nombre.");
        return false;
    }

    var email = document.getElementById("commentFormEmail").value;
    if (email === "" || email === "Email:")
    {
        document.getElementById("commentFormEmail").focus();
        $(".error-Comment" + key.toString()).fadeIn(1700).text("Es necesario un email");
        return false;
    }

    if (revisaremail(email) === "error") {
        document.getElementById("commentFormEmail").focus();
        $(".error-Comment" + key.toString()).fadeIn(1700).text("Email no válido");
        return false;
    }

    $(".error-Comment" + key.toString()).text("");
    // var comment = document.forms["commentForm"]["comment"].value;
    var comment = document.getElementById("commentFormComment").value;

    if (comment === "")
    {
        document.getElementById("commentFormComment").focus();
        $(".error-Comment" + key.toString()).fadeIn(1700).text("Escriba algun comentario");
        return false;
    }

    var web = document.getElementById("commentFormWeb").value;
    if (web === "Web: (Opcional/Optional)")
    {
        web = "";
    }
    //VERIFICAR AQUI SI ENCRIPTAMOS

    var keyMaster = window.location.pathname.split('/').slice(1);
    keyMaster = keyMaster[keyMaster.length - 1];


    //getUrlVars()["chapter"];

    //Use :window.location.href  change
    //or document.URL No change 
    var wisi = document.URL;

    var data = {name: name, email: email, web: web, comment: comment, keyPerson: key,
        inside: keyMaster, wisi: wisi};

//    var dataString = 'name=' + name
//            + '&email=' + email
//            + '&web=' + web
//            + '&comment=' + comment
//            + '&keyPerson=' + key
//            + '&inside=' + keyMaster
//            + '&url=' + wysiwyg_clean;

    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        url: "insertNotification.php",
        data: data,
        success: success()
    });

    function success() {
        //$(".error-Comment"+keyError).fadeOut();
        $("#reply" + key.toString()).fadeOut();
        if (key === "00") {
            var divEle = document.getElementById("00");
            divEle.innerHTML = "Gracias por tu comentario";

        } else {
            document.getElementById("aReply" + key.toString()).innerHTML = "Gracias por tu comentario";
            document.getElementById("aReply" + key.toString()).onclick = null;
        }

    }
}

function ListenMe() {//Aqui validar todas las cajas de texto
    $("#textKey").keydown(function (event) {
        if (event.keyCode === 13) {
            var text = document.getElementById('textKey');
            var garcon = document.getElementById('mode');
            if (garcon.getAttribute("value") === "a") {
                if (text.value !== "Clave:" || text.value !== "") {
                    whatDo(1);
                }
            }
            if (garcon.getAttribute("value") === "m") {
                if (text.value !== "Clave:" || text.value !== "") {
                    // document.getElementById("textKey").disabled = true;
                    //document.getElementById("textTitleStock").disabled = true;
                    // document.getElementById("identifier").disabled = true;
                    whatDo(2);
                }
            }
            if (garcon.getAttribute("value") === "e") {
                if (text.value !== "Clave:" || text.value !== "") {
                    whatDo(3);
                }
            }
            event.preventDefault();
            document.getElementById('textKeyStock').focus();

        }
    });


    $("#textKeyStock").keydown(function (event) {
        if (event.keyCode === 13) {
            var text = document.getElementById('textKeyStock');
            if (text.value !== "Simbolo de stock" || text.value !== "") {
                whatDo(15);
            }
            event.preventDefault();
            //document.getElementById('textKey').focus();
        }
    });

}

function getEmpty() {
    var notEmpty = true;
    var text = document.getElementById('textKey');
    var text2 = document.getElementById('textTitleStock');
    var text3 = document.getElementById('textKeyStock');
    var text4 = document.getElementById('textBuyLimit');
    var text5 = document.getElementById('textSellsLimit');
    var text6 = document.getElementById('priceStock');
    var garcon = document.getElementById('mode');
    if (text.value === "Clave:" || text.value === "") {
        if (garcon.getAttribute("value") === "a") {
            alert("Ingrese el número de inversión");
        } else if (garcon.getAttribute("value") === "m") {
            alert("Ingrese el número de inversión a modificar");
        }
        notEmpty = false;
        text.focus();
    } else if (text2.value === "" || text2.value === "Nombre de la compañia") {
        notEmpty = false;
        alert("Es necesario agregar un simbolo de stock");
        text2.setAttribute("disabled", true);
        text3.focus();
    } else if (text4.value === "" || text4.value === "Notificador valor de compra") {
        notEmpty = false;
        alert("Es necesario agregar un valor de compra en el stock");
        text4.focus();
    } else if (text5.value === "" || text5.value === "Notificador valor de venta") {
        notEmpty = false;
        alert("Es necesario agregar un valor de venta en el stock");
        text5.focus();
    } else if (text6.value === "" || text6.value === "Precio de compra") {
        notEmpty = false;
        alert("Es necesario agregar un valor e precio de compra al stock");
        text6.focus();
    }

    if (!notEmpty) {
        onMessage = true;
    }

    return notEmpty;
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function ChangeOn(kindSolution) {
    var divMain = document.getElementById('mode');
    var text = document.getElementById('textKey');
    var sto = document.getElementById('textKeyStock');
    var text2 = document.getElementById('textTitleStock');
    var text3 = document.getElementById('textBoughtStocks');
    var text4 = document.getElementById('textBuyLimit');
    var text5 = document.getElementById('textSellsLimit');
    var text6 = document.getElementById('priceStock');
    var rangeInpbuy = document.getElementById('percentageBuy');
    var rangeBuy = document.getElementById('amountB');
    var rangeInpSell = document.getElementById('percentageSell');
    var rangeSell = document.getElementById('amountS');
    var chkBuy = document.getElementById('notifierBuy');
    var chkSell = document.getElementById('notifierSell');
    var chkAppBuy = document.getElementById('notifierAppBuy');
    var chkAppSell = document.getElementById('notifierAppSell');
    var ident = document.getElementById('identifier');
    var valAproxOutB = document.getElementById('outputB');
    var valAproxOutS = document.getElementById('outputS');
    var varLasprice = document.getElementById('lastPr');

    if (kindSolution === 1) {
        divMain.innerHTML = "Modo: Agregar";
        divMain.setAttribute("value", "a");
        text.disabled = true;
        sto.value = "Simbolo de stock";
        text2.value = "Nombre de la compañia";
        text3.value = "0";
        text4.value = "Notificador valor de compra";
        text5.value = "Notificador valor de venta";
        text6.value = "Precio de compra";
        rangeInpbuy.value = "100"
        rangeBuy.innerHTML = "100";
        rangeInpSell.value = "100"
        rangeSell.innerHTML = "100";
        valAproxOutB.innerHTML = "";
        valAproxOutS.innerHTML = "";
        varLasprice.innerHTML = "";
        chkBuy.checked = true;
        chkSell.checked = true;
        chkAppBuy.checked = true;
        chkAppSell.checked = true;
        whatDo(1);
        ident.setAttribute("onclick", "whatDo(1);");
        document.getElementById('stockcold').setAttribute("value", "");
        document.getElementById('workaholic').setAttribute("value", "I");
        document.getElementById('takeit').setAttribute("value", "");
        document.getElementById("identifier").disabled = false;
    } else if (kindSolution === 2) {
        divMain.innerHTML = "Modo: Modificar";
        divMain.setAttribute("value", "m");
        text.disabled = false;
        text.value = "No. inversión";
        text.focus();
        sto.value = "Simbolo de stock";
        text2.value = "Nombre de la compañia";
        text3.value = "0";
        text4.value = "Notificador valor de compra";
        text5.value = "Notificador valor de venta";
        text6.value = "Precio de compra";
        rangeInpbuy.value = "100"
        rangeBuy.innerHTML = "100";
        rangeInpSell.value = "100"
        rangeSell.innerHTML = "100";
        valAproxOutB.innerHTML = "";
        valAproxOutS.innerHTML = "";
        varLasprice.innerHTML = "";
        chkBuy.checked = true;
        chkSell.checked = true;
        chkAppBuy.checked = true;
        chkAppSell.checked = true;
        ident.setAttribute("onclick", "whatDo(2);");
        document.getElementById('workaholic').setAttribute("value", "M");
        document.getElementById('stockcold').setAttribute("value", "");
        document.getElementById('takeit').setAttribute("value", "");

    } else if (kindSolution === 3) {
        divMain.innerHTML = "Modo: Eliminar";
        divMain.setAttribute("value", "e");
        text.disabled = false;
        text.value = "No. inversión";
        text.focus();
        sto.value = "Simbolo de stock";
        text2.value = "Nombre de la compañia";
        text3.value = "0";
        text4.value = "Notificador valor de compra";
        text5.value = "Notificador valor de venta";
        text6.value = "Precio de compra";
        rangeInpbuy.value = "100"
        rangeBuy.innerHTML = "100";
        rangeInpSell.value = "100"
        rangeSell.innerHTML = "100";
        chkBuy.checked = true;
        chkSell.checked = true;
        chkAppBuy.checked = true;
        chkAppSell.checked = true;
        ident.setAttribute("onclick", "whatDo(3);");
        document.getElementById("identifier").disabled = false;
        document.getElementById('stockcold').setAttribute("value", "");
        document.getElementById('takeit').setAttribute("value", "");
    }
}

var editor = null;
var componentEditor = null;
function addEditor(component) {
    if (editor === null) {

        editor = new nicEditor({fullPanel: true}).panelInstance(component);
        document.getElementById(component + 'A').style.display = "none";
        document.getElementById(component + 'B').style.display = "block";
        componentEditor = component;
    } else {
        alert("solo debe mantener activo un editor a la vez");
    }

}
function removeEditor(component) {
    editor.removeInstance(component);
    document.getElementById(component + 'A').style.display = "block";
    document.getElementById(component + 'B').style.display = "none";
    editor = null;
    componentEditor = null;
}

function whatDo(dealer) {
    var text = document.getElementById('textKey');
    var text2 = document.getElementById('textTitleStock');
    var text3 = document.getElementById('textKeyStock');
    var text4 = document.getElementById('priceStock');
    if (text.value === "" && dealer !== 1) {
        alert("Introduzca un número de inversión:");
        text.focus();
    } else {
        var data = "";
        if (dealer === 1) {
            data = {"toDo": "C"};
            $.ajax({
                async: false,
                cache: false,
                type: "POST",
                dataType: "json",
                url: "./designer/notifierFunctions.php",
                data: data
            }).done(function (msg) {
                if (msg !== null) {
                    text.value = msg;
                }
            });
        } else if (dealer === 2) {
            showLoading("");
            data = {toDo: "MV", valKey: text.value};
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: "./designer/notifierFunctions.php",
                data: data,
                success: function (data) {
                    if (data === null || isEmpty(data)) {
                        alert("Esta inversión no existe");
                    } else {
                        document.getElementById('takeit').value = data[0];
                        text3.value = data[1];//textKeyStock
                        text2.value = data[2];//textTitleStock
                        text4.value = data[3];//priceStock
                        document.getElementById('textBoughtStocks').value = data[4];
                        document.getElementById('textBuyLimit').value = data[5];
                        document.getElementById('textSellsLimit').value = data[6];
                        document.getElementById('percentageBuy').value = data[7];
                        document.getElementById('amountB').innerHTML = data[7];
                        document.getElementById('percentageSell').value = data[8];
                        document.getElementById('amountS').innerHTML = data[8];
                        var notBuy = document.getElementById('notifierBuy');
                        if (typeof (notBuy) != 'undefined' && notBuy != null)
                        {
                            if (data[9] === null || data[9] === '0') {
                                notBuy.checked = false;
                            } else {
                                notBuy.checked = true;
                            }
                        }
                        var notSell = document.getElementById('notifierSell');
                        if (typeof (notSell) != 'undefined' && notSell != null)
                        {
                            if (data[10] === null || data[10] === '0') {
                                notSell.checked = false;
                            } else {
                                notSell.checked = true;
                            }
                        }
                        var notAppBuy = document.getElementById('notifierAppBuy');
                        if (typeof (notAppBuy) != 'undefined' && notAppBuy != null)
                        {
                            if (data[11] === null || data[11] === '0') {
                                notAppBuy.checked = false;
                            } else {
                                notAppBuy.checked = true;
                            }
                        }
                        var notAppSell = document.getElementById('notifierAppSell');
                        if (typeof (notAppSell) != 'undefined' && notAppSell != null)
                        {
                            if (data[12] === null || data[12] === '0') {
                                notAppSell.checked = false;
                            } else {
                                notAppSell.checked = true;
                            }
                        }
                        document.getElementById('lastPr').innerText = data[13];
                    }
                    removeLoading();
                }
            });
        } else if (dealer === 3) {
            showLoading("");
            if (confirm("Deseas eliminar esta inversión")) {
                data = {toDo: "D", valKey: text.value};
                $.ajax({
                    async: false,
                    cache: false,
                    type: "POST",
                    dataType: "json",
                    url: "./designer/notifierFunctions.php",
                    data: data,
                    success: function (data) {
                        if (data === 'D') {
                            text.value = "";
                            alert("La inversión ha sido eliminada")
                        } else if (data === "empty") {
                            alert("Esta inversión no existe");
                        } else {
                            alert(data);
                        }
                    }
                });
                removeLoading();
            }
        } else if (dealer === 15) {
            showLoading("");
            data = {"toDo": "VI", valKey: text3.value};
            $.ajax({
                async: false,
                cache: false,
                type: "POST",
                dataType: "json",
                url: "./designer/notifierFunctions.php",
                data: data
            }).done(function (msg) {
                if (msg !== null) {
                    if (msg === 'empty') {
                        text2.value = "Nombre de la compañia";
                        text4.value = "Precio de compra";
                        alert("Este stock no existe");
                    } else if (msg === 'not') {
                        alert("No fue posible asignar el stock");
                    } else {
                        document.getElementById('stockcold').setAttribute("value", msg[0]);
                        document.getElementById("textBuyLimit").focus();
                        text2.value = msg[1];
                        text4.value = msg[2];
                        document.getElementById('lastPr').innerText = msg[2];
                    }
                }
                removeLoading();
            });

        }
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imageView')
                    .attr('src', e.target.result)
                    .width(250)
                    .height(150);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function deleteFile() {
    $("#imageUpload").val("");
    $('#imageView').attr('src', "imagesDesign/defaultImage.png")
            .width(250)
            .height(150);
    document.getElementById("imageUpload").name = "deleted";
}


function checkData() {
//    showLoading("IN");
    document.getElementById("textKey").disabled = false;
    var text = document.getElementById('textKey');
    var text2 = document.getElementById('textTitleStock');
//    var data = "";
    var exits = false;
    var garcon = document.getElementById('mode');
    if (garcon.getAttribute("value") === "m")
    {
        exits = true;
//        document.getElementById("textKey").disabled = false;
//        if (getEmpty() === true) {
//            data = {"toDo": "LA", "senderK": text2.value};
//            $.ajax({
//                async: false,
//                type: "POST",
//                dataType: "json",
//                url: "inserts.php",
//                data: data,
//                success: function(data) {
//                    if (data === 'true') {
//                        exits = true;
//                    } else if (data === "permission") {
//                        alert("No tiene permisos para modificar este articulo");
//                    } else {
//                        exits = false;
//                        alert("No puedes modificar un articulo con antiguedad");
//                        text.focus();
//                    }
//                    removeLoading();
//                }
//            });
//        }
    } else if (getEmpty() === true) {
        exits = true;
//        var data = "";
//        data = {"toDo": "R", valKey: text.value};
//        $.ajax({
//            async: false,
//            cache: false,
//            type: "POST",
//            dataType: "json",
//            url: "/invest/web/designer/stockFunctions.php",
//            data: data,
//            success: function(data) {
//                if (data !== null) {
//                    if (data === 'full') {
//                        alert("Este stock ya existe");
//                        exits = false;
//                    } else if (data === 'empty') {
//                        alert("Este stock no existe");
//                        exits = false;
//                    } else {
//
//                    }
//                }
////                //removeLoading();
//            }
//        });
    }
    return exits;
}

function isArray(o) {
    return Object.prototype.toString.call(o) === '[object Array]';
}

function showLoading(icon) {
    var div = document.createElement('div');
    div.setAttribute("id", "loadingPost");
    var img = document.createElement('img');
    if (icon === "MOD") {
        img.src = 'images/loaderModify.gif';
    } else {
        img.src = 'images/loadingStock.gif';
    }

    div.style.cssText = 'position: fixed; top: 50%; left: 50%; z-index: 5000;\n\
 -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%);';
    //div.style.cssText = 'position: fixed; top: 50%; left: 50%; z-index: 5000; width: 422px; text-align: center;';
    div.appendChild(img);
    document.body.appendChild(div);
    // These 2 lines cancel form submission, so only use if needed.
    //window.event.cancelBubble = true;
    //e.stopPropagation();
}

function removeLoading() {
    document.getElementById("loadingPost").remove();

}
//Te enviaremos un correo de notificación
function showMessage() {
    $('<div>')
            .attr('id', "popupmail")
            .attr('class', "popupmail")
            .attr('data-popup', 'popup-1')
            .append(createDiv('popupmail-inner', 'popupmail-inner')
                    .append('Tu articulo ha sido enviado, espere unos\n\
         momentos para que su artículo sea publicado. De ser necesario le enviaremos una notificación a su correo.<br>')
                    .append('<a id="close-popupmail" class="popupmail-close" data-popup-close="popup-1">x</a>')
                    .append('<p id="close-popupmail2" ><a class="popupmail-ok" data-popup-close="popup-1">Aceptar</a></p>')
                    )
            .fadeIn('fast')
            .appendTo('body')
            .animate({opacity: 1.0}, 74000) //<== wait 3 sec before fading out
            .fadeOut('slow', function ()
            {
                $(this).remove();
            });

    $('#close-popupmail,#close-popupmail2').click(function (e) {
        document.getElementById("popupmail").remove();
        e.preventDefault();
    });

    //Remove parametrs
    var query = window.location.search.substring(1)
    if (query.length) {
        if (window.history != undefined && window.history.pushState != undefined) {
            window.history.pushState({}, document.title, window.location.pathname);
        }
    }

}

var createDiv = function (newid, newclass) {
    return $('<div/>', {
        id: newid,
        class: newclass
    });
}

function notice(text, style) {
    style = style || 'notice'; //<== default style if it's not set
    //create message and show it
    $('<div>')
            .attr('class', style)
            .html(text)
            .fadeIn('slow')
            .insertAfter($('#content'))  //<== wherever you want it to show
            .animate({opacity: 1.0}, 3000)     //<== wait 3 sec before fading out
            .fadeOut('slow', function ()
            {
                $(this).remove();
            });

}

function sendMailcontact() {
    var text = document.getElementById('textName');
    var text2 = document.getElementById('textMail');
    var text3 = document.getElementById('textSubject');
    var noEmptyData = true;
    if (text.value === null || text.value === "") {
        noEmptyData = false;
        text.focus();
    } else if (text2.value === null || text2.value === "") {
        noEmptyData = false;
        text2.focus();
    } else if (text3.value === null || text3.value === "") {
        noEmptyData = false;
        text3.focus();
    }

    if (noEmptyData) {
        if (revisaremail(text2.value) === "error") {
            alert("El email no es válido");
            noEmptyData = false;
        }
    } else {
        alert("Ingrese todos los datos necesarios para agregar");

    }
    if (noEmptyData) {
        var button = document.getElementById("sendButtonContact");
        button.style.backgroundImage = "url(images/loading.gif)";
        button.style.backgroundRepeat = "no-repeat";
        button.style.backgroundPosition = "right 0px center";
        button.value = "Cargando  ";
        var data = {"textName": text.value, "textMail": text2.value, "textSubject": text3.value};
        $.ajax({
            async: false,
            cache: false,
            type: "POST",
            dataType: "json",
            url: "sendContactMail.php",
            data: data,
        }).done(function (msg) {
            if (msg === 'I') {
                $('.popup').fadeIn(350);
                button.style.backgroundImage = "";
                button.value = "Enviar";
                text.value = "";
                text2.value = "";
                text3.value = "";
            } else {
                alert("Error al enviar el mensaje por favor intenta más tarde");
            }
        });
    }
}

function sendMailSuscriberDown() {
    var text = document.getElementById('subscribe-fieldDown');
    var mail = text.value.toString();
    var noEmptyData = true;
    if (text.value === "") {
        noEmptyData = false;
        alert("Introduzca un email:");
        text.focus();
    } else {
        if (revisaremail(text.value) === "error") {
            noEmptyData = false;
            alert("El email no es válido");
        }
    }
    if (noEmptyData) {
        var button = document.getElementById("sendButtonInviteDown");
        button.style.backgroundImage = "url(images/loading.gif)";
        button.style.backgroundRepeat = "no-repeat";
        button.style.backgroundPosition = "right 0px center";
        button.value = "enviando  ";
        text.disabled = true;
        var data = ""; //Verificar si ya existe este subsriptor
        data = {"toDo": "EM", "mail": text.value};
        $.ajax({
            async: false,
            cache: false,
            type: "POST",
            dataType: "json",
            url: "inserts.php",
            data: data
        }).done(function (msg) {
            if (msg === 'I') {
                text.innerHTML = "";
                document.getElementById("iniSubs").textContent = '¡Gracias por suscribirte!';
                document.getElementById('iniBrief').textContent = "Un email ha sido enviado a la dirección de: "
                        + mail
                        + ", \n para confirmar tu subscripción " +
                        "verifica tu email, de no recibir el correo electrónico\n\
                        verifica también tu bandeja de correo electrónico no deseado\n\
                        y disfruta de nuestros últimos post más relevantes.";
                $('.popup').fadeIn(350);
            } else if (msg === 'full') {
                document.getElementById("iniSubs").textContent = 'Email ya registrado';
                document.getElementById('iniBrief').textContent = "Este email ya fue registrado, comunícate con nosotros si tienes algún inconveniente.";
                $('.popup').fadeIn(350);
            } else if (msg === 'Error') {
                document.getElementById("iniSubs").textContent = 'Error';
                document.getElementById('iniBrief').textContent = "Oh, oh, algo salió mal. Hubo un error inesperado. Vuelve a cargar la página e inténtalo de nuevo.";
                $('.popup').fadeIn(350);
            }
            button.style.backgroundImage = "";
            button.value = "Suscribirse";
            text.disabled = false;
        });
    }
}

function inside()

{
    if (confirm("Deseas Eliminar este post")) {
        whatDo(4);
    }
}

function selectItemByValue(elmnt, value) {
    for (var i = 0; i < elmnt.options.length; i++)
    {
        if (elmnt.options[i].value === value) {
            elmnt.selectedIndex = i;
            break;
        }
    }
}

function revisaremail(elemento) {
    if (elemento !== "") {
        var dato = elemento;
        var expresion = /^([a-zA-Z0-9_.-])+@(([a-zA-z0-9-])+.)+([a-zA-Z0-9-]{2,4})+$/;
        if (!expresion.test(dato)) {
            return "error";
        } else {
            return "good";
        }
    }
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    return vars;
}

function ellipsizeTextBox(namele) {
    var el = document.getElementById(namele);
    var keep = el.innerHTML;
    while (el.scrollHeight > el.offsetHeight) {
        el.innerHTML = keep;
        el.innerHTML = el.innerHTML.substring(0, el.innerHTML.length - 1);
        keep = el.innerHTML;
        el.innerHTML = el.innerHTML + "...";
    }
}

function enableGroup() {
    $('input[type="checkbox"]').on('change', function () {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);
    });
}

function overlay() {
    el = document.getElementById("overlay");
    el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
}

$(function () {
    //----- OPEN
    $('[data-popup-open]').on('click', function (e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

        e.preventDefault();
    });

    //----- CLOSE
    $('[data-popup-close]').on('click', function (e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

        e.preventDefault();
    });
});

var cursorFocus = function (elem) {
    var x = window.scrollX, y = (window.scrollY) - 100;
    elem.focus();
    window.scrollTo(x, y);
}









//var VL = VL || (function() {
//    var _args = {}; // private
//
//    return {
//        init: function(Args) {
//            _args = Args;
//            // some other initialising
//        },
//        get: function() {
//            return _args[0];
//        }
//    };
//}());


//function countToSocial(social, uriP, getdata) {
//    var url = "designer/accounts.php";
//    var uri = encodeURI(uriP);
//    var toSocial;
//    if (social === "gplus") {
//        toSocial = "shareGp";
//    } else if (social === "tw") {
//        toSocial = "shareTw";
//    }
//    else if (social === "fb") {
//        toSocial = "shareFa";
//    }
//
//    data = {toDo: social, pic: toSocial, pic2: getdata, pic3: uri};
//    //data = $(this).serialize() + "&" + $.param(data);
//
////    $.ajax({
////        async: true,
////        type: "POST",
////        dataType: "json",
////        url: url, //Relative or absolute path to response.php file
////        data: data,
////        success: function(data) {
////            if (data) {
////                alert(responsetext);
////                var x = document.getElementById(social);
////               // x.innerHTML = responsetext;
////
////            }
////        }
////    });
//
//
//
//    $.post(url, {toDo: social, pic: toSocial, pic2: getdata, pic3: uri},
//    function(responsetext) {
//        if (responsetext) {
//            alert(responsetext);
//            var x = document.getElementById(social);
//            x.innerHTML = responsetext;
//        }
//    });
//}


//function confirmationVerification()
//{
//    if (checkData()) {
//        $('<div>')
//                .attr('id', "popupmail")
//                .attr('class', "popupmail")
//                .attr('data-popup', 'popup-1')
//                .append(createDiv('popupmail-inner', 'popupmail-inner')
//                        .append('¿Deseas realmente enviar este articulo a ser verificado?<br> <span>una vez verificado tu articulo\n\
//         ya no podrás realizar ningun cambio.</span>')
//                        .append('<a id="close" class="popupmail-close" data-popup-close="popup-1">x</a>')
//                        .append('<p id="close-cancel" ><a class="popupmail-ok" data-popup-close="popup-1">Cancelar</a></p>')
//                        .append('<p id="close-ok" ><a class="popupmail-ok" data-popup-close="popup-1">Aceptar</a></p>')
//                        )
//                .fadeIn('fast')
//                .appendTo('body');
//        //.animate({opacity: 1.0}, 74000) //<== wait 3 sec before fading out
////                .fadeOut('slow', function()
////                {
////                    $(this).remove();
////                });
//
//        $('#close-ok').click(function(e) {
//            document.getElementById("popupmail").remove();
//
//            document.form.submit();
//                $("#commentForm").submit();
//            
//
//            e.preventDefault();
//        });
//
//        $('#close,#close-cancel').click(function(e) {
//            document.getElementById("popupmail").remove();
//            e.preventDefault();
//
//        });
//
//
////        if (confirm("Deseas realmente enviar este articulo a ser verificado")) {
////            document.form.submit();
////        }
//    }
//
//}

