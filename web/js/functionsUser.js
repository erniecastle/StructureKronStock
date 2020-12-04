
$(function() {
    //Menu
    var pull = $('#pull');
    menu = $('nav ul');
    menuHeight = menu.height();

    $(pull).on('click', function(e) {

        menu.slideToggle();
        e.preventDefault();
    });
    $(window).resize(function() {
        var w = $(window).width();
        if (w > 320 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });
});



function ChangeOn(kindSolution) {
    var divMain = document.getElementById('mode');
    var text = document.getElementById('textKey');
    var text2 = document.getElementById('textNameUser');
    var text4 = document.getElementById('textUser');
    var text5 = document.getElementById('textUserMail');
    var text6 = document.getElementById('textUserPass');
    var ident = document.getElementById('identifier');
    selectItemByValue(document.getElementById('section'), "");
    if (document.getElementById('textKey').disabled) {
        document.getElementById("textKey").disabled = false;
        document.getElementById("identifier").disabled = false;
    }

    if (kindSolution === 1) {
        divMain.innerHTML = "Modo: Agregar";
        divMain.setAttribute("value", "a");
        document.getElementById("textKey").disabled = true;
        whatDo(1);
        text.disabled;
        text2.value = "Nombre completo usuario:";
        text4.value = "Usuario:";
        text5.value = "Email:";
        text6.value = "Contraseña:";
        $("#imageUpload").val("");
        $('#imageView').attr('src', "images/pic6.png");
        ident.setAttribute("onclick", "whatDo(1);");
        document.getElementById('alcoholic').setAttribute("value", 0);
        document.getElementById('workaholic').setAttribute("value", "I");
        document.getElementById('takeit').setAttribute("value", "");
        document.getElementById("section").disabled = false;
        document.getElementById("identifier").disabled = false;
    }

    else if (kindSolution === 2) {
        divMain.innerHTML = "Modo: Modificar";
        divMain.setAttribute("value", "m");
        text.value = "Clave:";
        text.focus();
        text2.value = "Nombre completo usuario:";
        text4.value = "Usuario:";
        text5.value = "Email:";
        text6.value = "Contraseña:";
        $("#imageUpload").val("");
        $('#imageView').attr('src', "images/pic6.png");
        ident.setAttribute("onclick", "whatDo(2);");
        document.getElementById('alcoholic').setAttribute("value", 0);
        document.getElementById('takeit').setAttribute("value", "");
        document.getElementById("section").disabled = true;
    }
    else if (kindSolution === 3) {
        divMain.innerHTML = "Modo: Eliminar";
        divMain.setAttribute("value", "e");
        text.value = "Clave:";
        text.focus();
        text2.value = "Nombre completo usuario:";
        text4.value = "Usuario:";
        text5.value = "Email:";
        text6.value = "Contraseña:";
        $("#imageUpload").val("");
        $('#imageView').attr('src', "images/pic6.png");
        ident.setAttribute("onclick", "whatDo(3);");
        document.getElementById('alcoholic').setAttribute("value", 0);
        document.getElementById('takeit').setAttribute("value", "");
    }
}



function whatDo(dealer) {
    var text = document.getElementById('textKey');

    if (text.value === "Clave:" && dealer !== 1) {
        alert("Introduzca una Clave:");
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
                url: "designer/userFunctions.php",
                data: data
            }).done(function(msg) {
                if (msg !== null) {
                    text.value = msg;
                }

            });
        }
        else if (dealer === 2) {
            data = {toDo: "MV", valKey: text.value};
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: "designer/userFunctions.php",
                data: data,
                success: function(data) {
                    if (typeof data === 'string') {
                        alert("Esta clave no existe");
                    } else {
                        var select = data[0];
                        document.getElementById("section").disabled = false;
                        if (select === '1') {
                            select = "administrator";
                        } else if (select === '2') {
                            select = "investor";
                        }
                        selectItemByValue(document.getElementById("section"), select);

                        var text1 = document.getElementById('textNameUser');
                        text1.value = data[1];
//
                        var text2 = document.getElementById('textUser');
                        text2.value = data[2];
//
                        var text3 = document.getElementById('textUserMail');
                        text3.value = data[3];
//
                        var text4 = document.getElementById('textUserPass');
                        text4.value = data[4];
//
                        $('#imageView').attr('src', "data:image/jpeg;base64," + data[5])
                                .width(250)
                                .height(235);
                        document.getElementById("workaholic").setAttribute("value", "M");
                        text1.focus();
                    }
                }
            });
        }
        else if (dealer === 3) {
            data = {"toDo": "CU", valKey: text.value};
            $.ajax({
                async: true,
                cache: false,
                type: "POST",
                dataType: "json",
                url: "designer/userFunctions.php",
                data: data
            }).done(function(data) {
                if (data === "nouser") {
                    alert("Este usuario no existe");
                }
                if (data === "empty") {
                    inside();
                }
                else if (data === "full") {
                    outSide();
                }

            });
        }
        else if (dealer === 4) {
            data = {toDo: "D", valKey: text.value};
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: "designer/userFunctions.php",
                data: data,
                success: function(data) {
                    if (data === "play") {
                        alert("El usuario ha sido eliminado");
                        document.getElementById('textKey').value = "";
                        document.getElementById('textKey').focus();
                    } else {
                        alert("No se pudo eliminar el usuario");
                    }
                }
            });
        }
    }
}



function checkData() {
    var text = document.getElementById('textUser');
    var data = "";
    var exits = true;
    var garcon = document.getElementById('mode');
    if (garcon.getAttribute("value") === "m") {
        document.getElementById("textKey").disabled = false;
    }
    else {
        if (getEmpty() === true) {
            data = {"toDo": "LT", "senderUs": text.value};
            $.ajax({
                async: false,
                type: "POST",
                dataType: "json",
                url: "designer/userFunctions.php",
                data: data,
                success: function(data) {
                    if (data === 'user') {
                        exits = false;
                        text.focus();
                        alert("Este usuario ya existe verifique");
                    }
                    else if (data === '') {
                        exits = true;
                        document.getElementById("textKey").disabled = false;
                    }
                }
            });
        }
        else {
            exits = false;
        }
    }
    return exits;
}


function getEmpty() {
    var notEmpty = true;
    var textTheme = document.getElementById("section");
    var text = document.getElementById('textKey');
    var text2 = document.getElementById('textNameUser');
    var text4 = document.getElementById('textUser');
    var text5 = document.getElementById('textUserMail');
    var text6 = document.getElementById('textUserPass');
    var garcon = document.getElementById('mode');
    var onMsg = false;

    if (textTheme.value === null || textTheme.value === "") {
        notEmpty = false;
        textTheme.focus();
    }
    else if (text.value === "Clave:" || text.value === "") {
        if (garcon.getAttribute("value") === "a") {
            alert("Ingrese campo clave");
            onMsg = true;
        } else if (garcon.getAttribute("value") === "m") {
            alert("Seleccione clave usuario a modificar");
            onMsg = true;
        }
        notEmpty = false;
        text.focus();
    }
    else if (text2.value === "Nombre completo usuario:" | text2.value === "") {
        notEmpty = false;
        text2.focus();
    }
    else if (text4.value === "Usuario:" || text4.value === "") {
        notEmpty = false;
        text4.focus();
    }
    else if (text5.value === "Email:" || text5.value === "") {
        notEmpty = false;
        text5.focus();
    }
    else if (text6.value === "Contraseña:" || text6.value === "") {
        notEmpty = false;
        text6.focus();
    }

    if (!notEmpty && !onMsg) {
        alert("Ingrese todos los datos necesarios para agregar");
    }

    return notEmpty;

}


function ListenMe() {//Aqui validar todas las cajas de texto
    $("#textKey").keydown(function(event) {
        if (event.keyCode === 13) {
            var text = document.getElementById('textKey');
            var garcon = document.getElementById('mode');
            if (garcon.getAttribute("value") === "a") {
                if (text.value !== "Clave:" || text.value !== "") {
                    whatDo(3);
                }
            }
            if (garcon.getAttribute("value") === "m") {
                if (text.value !== "Clave:" || text.value !== "") {
                    document.getElementById("textKey").disabled = true;
                    document.getElementById("identifier").disabled = true;
                    whatDo(2);
                }
            }
            if (garcon.getAttribute("value") === "e") {
                if (text.value !== "Clave:" || text.value !== "") {
                    whatDo(3);
                }
            }
            event.preventDefault();
        }
    });

    $('#elegible').click(function() {
        if (document.getElementById('elegible').checked) {
            mainNecklace();
        } else {
            var divKindUp = document.getElementById('kindUp');
            while (divKindUp.firstChild) {
                divKindUp.removeChild(divKindUp.firstChild);
            }
            var imageDetail = document.createElement("input");
            imageDetail.setAttribute("id", "imageUpload0");
            imageDetail.setAttribute("name", "image0");
            imageDetail.setAttribute("type", "file");
            imageDetail.setAttribute("onchange", "readURL(this,0);");
            imageDetail.setAttribute("multipleaccept", "'image/*'");
            divKindUp.appendChild(imageDetail);
            divKindUp.appendChild(document.createElement("br"));
            divKindUp.appendChild(document.createElement("br"));
            var imageView = document.createElement("img");
            imageView.setAttribute("id", "imageView0");
            imageView.setAttribute("src", "images/selectedpic.jpg");
            imageView.setAttribute("name", "image");
            divKindUp.appendChild(imageView);
            divKindUp.appendChild(document.createElement("br"));
            divKindUp.appendChild(document.createElement("br"));
        }

    });

}

function inside()
{
    if (confirm("Deseas Eliminar este usuario")) {
        whatDo(4);
    }
}

function outSide()
{
    if (confirm("Este usuario tiene inversiones asignadas ¿Deseas eliminar?")) {
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


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imageView')
                    .attr('src', e.target.result)
                    .width(250)
                    .height(235);
        };
        reader.readAsDataURL(input.files[0]);
    }
}


function refreshPage() {
    window.location.reload();
}

function pageArticle() {
    window.location.href = 'articulos.php';
}

function pageComentarios() {
    window.location.href = 'comentarios.php';
}

function pageSms() {
    window.location.href = 'gensms.php';
}