<?php

include ("query.php");
include ("functions.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$limite = $_POST["limite"];
$key = $_POST["key"];
$paginado = 10;
$appendData = "";

$rol = 0;
if (!empty($_SESSION['rol'])) {
    $rol = $_SESSION['rol'];
}
$member = $_SESSION["iduser"];
$memberAppend = "";


if (!empty($_SESSION["iduser"])) {
    $member = $_SESSION['iduser'];
}

if (!empty($key)) {
    $appendData .= " AND (`users`.clave LIKE " . "'%" . $key . "%'" .
            " OR `users`.nombre LIKE" . "'%" . $key . "%' OR `users`.email LIKE" . "'%" . $key . "%') ";
}

if (!empty($_POST['show'])) {
    $show = $_POST['show'];
    if ($show == '2') {
        $appendData .= "AND `users`.active = 1";
    } else if ($show == '3') {
        $appendData .= "AND `users`.active = 0";
    }
}

$sql = "SELECT `users`.clave,`users`.nombre,`users`.username,
        `users`.email,`users`.rol,`users`.lastLog,`users`.image
         FROM `users`  
          where 1 = 1 " . $appendData .
        " order by `users`.id desc limit " . "$limite, $paginado";
$loadQ = new query();
$registros = $loadQ->select($sql);

$queryCount = "select count(*) FROM `users` where 1 = 1 " . $memberAppend;
$total = $loadQ->getCount($queryCount);


echo '<div class="row">';
if ($limite > 0) {
    $limit = $limite - $paginado;
    if ($limit < 0) {
        $limit = 0;
        echo "<button onclick=\"loadUsers(" . $limit . ");\" class=\"btn btn-info\" >";
        echo'<';
        echo'</button>';
    } else {
        echo "<button onclick=\"loadUsers(" . $limit . ");\" class=\"btn btn-info\" >";
        echo'<';
        echo'</button>';
    }
} else {
    echo '<button class="btn btn-info" >';
    echo'<';
    echo'</button>';
}
echo '&nbsp&nbsp&nbsp';


if ($limite < $total - $paginado) {
    $limit = $limite + $paginado;
    echo "<button onclick=\"loadUsers(" . $limit . ");\" class=\"btn btn-info\" >";
    echo'>';
    echo'</button>';
} else {
    echo '<button class="btn btn-info" >';
    echo'>';
    echo'</button>';
}


echo '&nbsp&nbsp&nbsp';
echo "<button onclick=\"loadUsers(0);\" class=\"btn btn-primary\" >Buscar</button>";
echo '<br>';

echo '<table class="table table-striped table-bordered"><br>' .
 '<thead>' .
 '<tr>' .
 '<th>Clave</th>' .
 '<th>Foto</th>' .
 '<th>Nombre</th>' .
 '<th>Usuario</th>' .
 '<th>Email</th>' .
 '<th>Tipo</th>' .
 ($rol == 1 ? '<th>En linea</th>' : "") .
 '</tr>' .
 '</thead>' .
 '<tbody>';

while ($row = mysql_fetch_array($registros)) {
    echo '<tr>';
    echo '<td>' . $row['clave'] . '</td>';
    if ($row['image'] == null) {
        echo '<td height="42" width="42">sin foto</td>';
    } else {
        echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '"/  height="42" width="42"></td>';
    }
    echo '<td>' . $row['nombre'] . '</td>';
    echo '<td>' . $row['username'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    if ($row['rol'] == 1) {
        echo '<td>Administrador</td>';
    } else if ($row['rol'] == 2) {
        echo '<td>Inversionista</td>';
    } else{
        echo '<td></td>';
    }
    if ($rol == 1) {
        if ($row['lastLog'] != null) {
            $newDate = date("d/m/Y h:i:A", strtotime($row['lastLog']) - 7200);
            echo "<td>" . $newDate . "</td>";
        } else {
            echo '<td>--</td>';
        }
    }
    echo '</tr>';
}
echo '</tbody>' .
 '</table>';
echo '</div> ';




