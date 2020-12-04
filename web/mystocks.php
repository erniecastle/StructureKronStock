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
        <script type="text/javascript" src="js/loadMyStocks.js"></script>

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
                                    <li><a href="mystocks.php" data-hover="Mis inversiones">Mis inversiones</a></li>
                                    <li><a href="stocks.php" data-hover="Acciones">Acciones</a></li>
                                    <li><a href="notifier.php" data-hover="Alertas">Alertas</a></li>
                                    <li><a href="security/logout.php" data-hover="Cerrar Sesión">Cerrar Sesión</a></li>
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
            <h1 id="content" style="margin-left: 5%">Vista preeliminar de mis acciones</h1>
            <br>
            <div class="container">
                <div class="row">
                    <input type="search" id="keyPost" name="keyPost" onkeypress="handle(event)" placeholder="Simbolo/Nombre stock">
                    <br>
                    <br>
                </div>
                <div id="getStocks">
                    <img src="images/loadVisits.gif" alt="..." class="img-responsive center-block" />
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




