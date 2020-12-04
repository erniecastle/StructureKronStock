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
                                    <li><a href="users.php" data-hover="Listado de usuarios">Listado de usuarios</a></li>
                                    <li><a href="mystocks.php" data-hover="Inversiones">Inversiones</a></li>
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
            <h1 id="content" style="margin-left: 5%">Asignación de usuarios</h1>
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
                    <div class="artical-commentbox">
                        <p id="errorComment" class="error-Comment00" style="display: none"></p>
                        <div id="reply00" class="table-form">

                            <form id="commentForm" onsubmit="return  checkData()"  enctype="multipart/form-data" action="designer/userFunctions.php" method="post" name="changer">
                                <input name="MAX_FILE_SIZE" value="" type="hidden">
                                <label>Tipo de usuario:</label>
                                <select id="section" name="section" disabled="true">
                                    <option value=""></option>
                                    <?php
                                    if ($rol < 2) {
                                        echo '<option value="administrator">Administrador</option>';
                                    }
                                    ?>
                                    <option value="investor">Inversionista</option>
                                </select> 
                                <br>
                                <label>Clave: </label>
                                <input id="textKey" title="Clave del post" name="textKey" type="textKey" class="textbox" value="" 
                                       onfocus="if (this.value == 'Clave:') {
                                                   this.value = '';
                                               }"
                                       onblur="if (this.value == '') {
                                                   this.value = 'Clave:';
                                               }
                                       " required>
                                <button id="identifier" title="Busqueda de clave" type="button"  href="javascript:void(0);" onclick="whatDo(1);
                                        return false;"><img src="images/loupe.png" /></button>
                                <br>
                                <input id="textNameUser" name="textNameUser" type="text" class="textbox" value="Nombre completo usuario:" 
                                       onfocus="if (this.value === 'Nombre completo usuario:') {
                                                   this.value = '';
                                               }"
                                       onblur="if (this.value === '') {
                                                   this.value = 'Nombre completo usuario:';
                                               }">
                                <input id="textUser" name="textUser" type="text" class="textbox" value="Usuario:" 
                                       onfocus="if (this.value === 'Usuario:') {
                                                   this.value = '';
                                               }"
                                       onblur="if (this.value === '') {
                                                   this.value = 'Usuario:';
                                               }">
                                <input id="textUserMail" name="textUserMail" type="text" class="textbox" value="Email:" 
                                       onfocus="if (this.value === 'Email:') {
                                                   this.value = '';
                                               }"
                                       onblur="if (this.value === '') {
                                                   this.value = 'Email:';
                                               }">

                                <input id="textUserPass" name="textUserPass" type="password" class="textbox" value="Contraseña:" 
                                       onfocus="if (this.value === 'Contraseña:') {
                                                   this.value = '';
                                               }"
                                       onblur="if (this.value === '') {
                                                   this.value = 'Contraseña:';
                                               }">
                                <br>
                                <div id="kindUp" >
                                    <input id="imageUpload" name="image0" type="file" onchange="readURL(this, 0);" multiple accept='image/*'>
                                    <br>
                                    <img id="imageView" src="images/pic6.png">
                                    <br><br>
                                </div>

                                <input id="workaholic" name="toDo" value="I" type="hidden">
                                <input id="alcoholic" name="alcoholic" value="0" type="hidden">
                                <input id="takeit" name="takeit" value="" type="hidden">
                                <input id="myBtnS"  value="Guardar" class="myButton" type="submit"Guardar>
                                <a class="myButton" href="javascript:void(0);" onclick="pageArticle();
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



