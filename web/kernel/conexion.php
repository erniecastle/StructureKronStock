<?php
include (__DIR__ . "/../kernelU/US.php");
$userdb = US;
define('paginado', 10);
define('paginadoSection', 5); //para la pagina de secciones
define('host', 'localhost'); 
define('user', $userdb); //ernesto
define('pw', 'adminadmin');
define('db', 'datainvest'); //blogtest
define('port', '3306');
define('modifyArticle', false); //para que editor modifique articulos
define('metaMes', 1500);

class glb {

    static public function set($name, $value) {
        $GLOBALS[$name] = $value;
    }

    static public function get($name) {
        return $GLOBALS[$name];
    }

}
?>

