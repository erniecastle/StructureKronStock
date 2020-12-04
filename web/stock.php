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
        <meta name="keywords" content="" />
        <link rel="icon" type="image/png" href="imagesDesign/favicon.png" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //for-mobile-apps -->
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <!-- js -->
        <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="js/functions.js"></script>

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
                                    <li><a href="mystocks.php" data-hover="Inversiones">Inversiones</a></li>
                                    <li><a href="notifier.php" data-hover="Alertas">Alertas</a></li>
                                    <li><a href="security/logout.php" data-hover="Cerrar Sesión">Cerrar Sesión</a></li>
                                    <li><a href="readstocks.php" data-hover=".."></a>..</li>
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
            <h1 id="content" style="margin-left: 5%">Asignación de acciones</h1>
            <br>
            <div class="container">
                <div class="grids_of_2">
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
                        <div class="artical-commentbox" > <p id="errorComment" class="error-Comment00" style="display: none"></p>
                        <div id="reply00" class="table-form">
                            <form id="commentForm" onsubmit="return checkData();"
                                  enctype="multipart/form-data"
                                  action="designer/stockFunctions.php" method="post" name="changer">
                                <input name="MAX_FILE_SIZE" value="" type="hidden">
                                <label>Simbolo de stock: </label>
                                <input id="textKey" title="Simbolo de stock" name="textKey" type="textKey" class="textbox" value="" 
                                       onfocus="if (this.value == 'Clave:') {
                                                   this.value = '';
                                               }"
                                       onblur="if (this.value == '') {
                                                   this.value = 'Clave:';
                                               }
                                       " >
                                <button id="identifier" title="Busqueda de accion" type="button"  href="javascript:void(0);" onclick="whatDo(1);
                                        return false;"><img src="images/loupe.png" /></button>
                                <br>
                                <input id="textTitleStock" name="textTitleStock" type="text" class="textbox" value="Nombre de la compañia" disabled="disabled"
                                       onfocus="if (this.value === 'Nombre de la compañia') {
                                                   this.value = '';
                                               }"
                                       onblur="if (this.value === '') {
                                                   this.value = 'Nombre de la compañia';
                                               }"><br>
                                <label class="checks">Precio de stock:</label>        
                                <input id="actualPrice" name="actualPrice" type="text" title="El precio actual de la acción" class="textsmallbox" value="Precio actual" disabled="disabled"
                                       onfocus="if (this.value === 'Precio actual') {
                                                   this.value = '';
                                               }"
                                       onblur="if (this.value === '') {
                                                   this.value = 'Precio actual';
                                               }"><br><br>
                                <div id="kindUp" >
                                    <input id="imageUpload" name="image" type="file" onchange="readURL(this);" multiple accept='image/*'>
                                    <br>
                                    <button title="Elimina la imagen" type="button" onclick="deleteFile();">Eliminar imagen</button>
                                    <br><br>
                                    <img id="imageView" src="imagesDesign/defaultImage.png">
                                </div>
                                <br>
                                <input id="workaholic" name="toDo" value="I" type="hidden">
                                <input id="alcoholic" name="alcoholic" value="0" type="hidden">
                                <input id="takeit" name="takeit" value="" type="hidden">
                                <?php
                                if ($rol < 3) {
                                    echo '<input id="myBtnS"  value="Guardar" class="myButton" type="submit"Guardar>';
                                }
                                ?>
                                <a class="myButton" href="javascript:void(0);" onclick="ChangeOn(1);
                                        return false;">Cancelar</a>
                            </form>
                        </div>
                        <div class="clear"></div>
                    </div>			
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


