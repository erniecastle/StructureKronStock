<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['myusername'])) {
    header("location:login.html");
}
include ("designer/query.php");
include ("designer/functions.php");
include ("./kernel/config.php");
$rol = 0;
$verify = 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Kron Stock | El inspector de tus inversiones</title>
        <!-- for-mobile-apps -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Barter Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
              Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
        <link rel="icon" type="image/png" href="imagesDesign/favicon.png" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //for-mobile-apps -->
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <!-- js -->
        <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="js/functionsNotifier.js"></script>

        <!-- start-smoth-scrolling -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {
            $(".scroll").click(function(event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
            });
            });
        </script>
        <!-- start-smoth-scrolling -->
        <script type="text/javascript">
            $(window).load(function() {
            ChangeOn(1);
            ListenMe();
            });

            function sliderChangeApBuy(val) {
            if (val < 100) {
            var pr = document.getElementById('priceStock');
            if (pr.value === "") {

            }
            var pcd = document.getElementById('textBuyLimit');
            var percentage = (val / 100);
            var priceAPPB = parseFloat(pr.value) - ((parseFloat(pr.value) - parseFloat(pcd.value)) * (parseFloat(percentage)));
            document.getElementById('outputB').innerHTML = "✓ " + priceAPPB.toFixed(2);

            } else {
            document.getElementById('outputB').innerHTML = "";
            }
            document.getElementById('amountB').innerHTML = val;
            }


            function sliderChangeApSell(val) {
            if (val < 100) {
            var pr = document.getElementById('priceStock');
            var pvd = document.getElementById('textSellsLimit');
            var percentage = (val / 100);
            var priceAPPS = parseFloat(pr.value) - ((parseFloat(pr.value) - parseFloat(pvd.value)) * (parseFloat(percentage)));
            document.getElementById('outputS').innerHTML = "✓ " + priceAPPS.toFixed(2);

            } else {
            document.getElementById('outputS').innerHTML = "";
            }
            document.getElementById('amountS').innerHTML = val;
            }
        </script>
    </head>

    <body>
        <!-- header -->
        <div class="header" id="ban">
            <div class="container">
                <div class="w3l_social_icons">
                    <ul>
                        <li><a href="#" class="facebook"></a></li>
                        <li><a href="#" class="twitter"></a></li>
                        <li><a href="#" class="google_plus"></a></li>
                        <li><a href="#" class="pinterest"></a></li>
                        <li><a href="#" class="instagram"></a></li>
                    </ul>
                </div>
                <div class="w3ls_logo">
                    <a href="index.html"></a>
                </div>
                <div class="header_right">
                    <nav class="navbar navbar-default">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
                            <nav class="link-effect-7" id="link-effect-7">
                                <ul class="nav navbar-nav">
                                    <li><a href="stocks.php" data-hover="Acciones">Acciones</a></li>
                                    <li class="active act"><a href="stock.php" data-hover="Asignar acción">Asignar acción</a></li>
                                    <li><a href="mystocks.php" data-hover="Inversiones">Inversiones</a></li>
                                    <li><a href="security/logout.php" data-hover="Cerrar Sesión">Cerrar Sesión</a></li>
                                    <li><a href="readstocks.php" data-hover="..">..</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- /.navbar-collapse -->
                    </nav>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <!-- //header -->
        <!-- about -->
        <div>
            <br>
            <h1 id="content" style="margin-left: 5%">Condiciones de alerta</h1>
            <br>
            <div class="container">
                <div class="artical-commentbox">
                    <a class="myButton" style="margin-right: 3%;" href="javascript:void(0);" onclick="ChangeOn(1);
                            return false;" >Agregar</a>
                    <a class="myButton" style="margin-right: 3%;" href="javascript:void(0);" onclick="ChangeOn(2);
                            return false;" >Modificar</a>
                    <a class="myButton" style="margin-right: 3%;" href="javascript:void(0);" onclick="ChangeOn(3);
                            return false;" >Eliminar</a>
                    <br><br><br>
                </div>
                <a id="mode" value="a">Modo: Agregar</a>
                <div class="artical-commentbox" >
                    <p id="errorComment" class="error-Comment00" style="display: none"></p>
                    <div id="reply00" class="table-form">
                        <form id="commentForm" onsubmit="return checkData();"
                              enctype="multipart/form-data"
                              action="designer/notifierFunctions.php" method="post" name="changer">
                            <input name="MAX_FILE_SIZE" value="" type="hidden">
                            <label>No. de inversión:</label>
                            <input id="textKey" title="No. inversión" name="textKey" type="textKey" class="textbox" value="" 
                                   onfocus="if (this.value == 'No. inversión') {
                                               this.value = '';
                                           }"
                                   onblur="if (this.value == '') {
                                               this.value = 'No. inversión';
                                           }" >
                            <button id="identifier" title="Busqueda de inversión" type="button"  href="javascript:void(0);" onclick="whatDo(1);
                                    return false;"><img src="images/loupe.png" /></button>
                            <br>
                            <label>Simbolo de stock: </label>
                            <input id="textKeyStock" title="Simbolo de stock" name="textKeyStock" type="textKey" class="textbox" value="Simbolo de stock" 
                                   onfocus="if (this.value == 'Simbolo de stock') {
                                               this.value = '';
                                           }"
                                   onblur="if (this.value == '') {
                                               this.value = 'Simbolo de stock';
                                           }
                                   " >
                            <button id="identifierStock" title="Busqueda de accion" type="button"  href="javascript:void(0);" onclick="whatDo(15);
                                    return false;"><img src="images/loupe.png" /></button>
                            <br></br>
                            <label>Precio actual de stock:</label><label id="lastPr" class="lblPrice" name="lastPr"> 0.0</label>
                            <br><br>
                            <label>Precio de compra:</label>
                            <input id="priceStock" name="priceStock" type="number" step="0.01"
                                   title="El precio actual al que compraste la acción" class="textsmallbox" value="Precio de compra">
                            <input id="textTitleStock" name="textTitleStock" type="text" class="textbox" value="Nombre de la compañia" disabled="disabled"
                                   onfocus="if (this.value === 'Nombre de la compañia') {
                                               this.value = '';
                                           }"
                                   onblur="if (this.value === '') {
                                               this.value = 'Nombre de la compañia';
                                           }">
                            <br>
                            <label>Cantidad de stocks (opcional): </label>
                            <input id="textBoughtStocks" name="textBoughtStocks" type="number"  min="0" step="1" value="0">
                            <br>
                            <input id="textBuyLimit" name="textBuyLimit" type="text" title="El precio de compra en el cuál recibiras notificación" class="textLimit" value="Notificador valor de compra" 
                                   onfocus="if (this.value === 'Notificador valor de compra') {
                                               this.value = '';
                                           }"
                                   onblur="if (this.value === '') {
                                               this.value = 'Notificador valor de compra';
                                           }">
                            <label>◄►</label>
                            <input id="textSellsLimit" name="textSellsLimit" title="El precio de venta en el cuál recibiras notificación" type="text" class="textSellsLimit" value="Notificador valor de venta" 
                                   onfocus="if (this.value === 'Notificador valor de venta') {
                                               this.value = '';
                                           }"
                                   onblur="if (this.value === '') {
                                               this.value = 'Notificador valor de venta';
                                           }">
                            <br><br>
                            <label class="checks">Aproximaciones (opcional):</label><br>
                            <label>A la compra</label>
                            <input id="percentageBuy"  name="percentageBuy" type="range"  min="0" max="100" value="1" oninput="sliderChangeApBuy(this.value)">
                            <output id="amountB" name="amountB" id="amountB" for="percentageBuy">100</output>% 
                            <output class="aproximation" id="outputB"></output>
                            <br>
                            <label>A la venta</label>
                            <input id="percentageSell"  name="percentageSell" type="range"  min="0" max="100" value="1"
                                   oninput="sliderChangeApSell(this.value)">                                                       
                            <output id="amountS" name="amountS" id="amountS" for="percentageSell">100</output>%
                            <output class="aproximation" id="outputS"></output>
                            <br>
                            <br>
                            <label class="checks">Recibir notificación valor de compra</label>
                            <input id="notifierBuy" name="notifierBuy" type="checkbox" checked>&nbsp;&nbsp;
                            <label class="checks">Recibir notificación valor de venta</label>
                            <input id="notifierSell" name="notifierSell" type="checkbox" checked>
                            <br><br>
                            <label class="checks">Recibir notificación aproximación de compra</label>
                            <input id="notifierAppBuy" name="notifierAppBuy" type="checkbox" checked>&nbsp;&nbsp;
                            <label class="checks">Recibir notificacion aproximación de venta</label>
                            <input id="notifierAppSell" name="notifierAppSell" type="checkbox" checked>
                            <br>
                            <input id="workaholic" name="toDo" value="I" type="hidden">
                            <input id="stockcold" name="stockcold" value="" type="hidden">
                            <input id="takeit" name="takeit" value="" type="hidden">

                            <?php
                            if ($rol < 3) {
                                echo '<input id="myBtnS"  value="Guardar" class="myButton" type="submit"Guardar>';
                            }
                            ?>
                        </form>
                    </div>
                    <div class="clear"></div>
                </div>	
            </div>
        </div>
        <!-- //about -->

        <!-- footer -->
        <div class="footer-copy">
            <div class="container">

            </div>
        </div>
        <div class="copy-right-social">
            <div class="container">
                <div class="footer-pos">
                    <a href="#ban" class="scroll"><img src="images/arrow.png" alt=" " class="img-responsive" /></a>
                </div>
                <div class="copy-right">
                    <p>Copyright &copy; 2017 KronStock.</p>
                </div>
                <div class="copy-right-social1">
                    <div class="w3l_social_icons w3l_social_icons1">
                        <ul>
                            <li><a href="#" class="facebook"></a></li>
                            <li><a href="#" class="twitter"></a></li>
                            <li><a href="#" class="google_plus"></a></li>
                            <li><a href="#" class="pinterest"></a></li>
                            <li><a href="#" class="instagram"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <!-- //footer -->
        <!-- for bootstrap working -->
        <script src="js/bootstrap.js"></script>
        <!-- //for bootstrap working -->
    </body>
</html>

