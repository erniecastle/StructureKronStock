<?php

include ("query.php");
//include ("functions.php");
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

//$member = $_SESSION["iduser"];
$memberAppend = "";
//if (!empty($_SESSION["iduser"])) {
//    $member = $_SESSION['iduser'];
//}
if (!empty($key)) {
    $appendData .= " AND (`stocks`.stockSymbol LIKE " . "'%" . $key . "%'" .
            " OR `stocks`.stockName LIKE" . "'%" . $key . "%') ";
}


$sql = "SELECT `stocks`.stockImage,`stocks`.stockSymbol,`stocks`.stockName,`stocks`.lastPrice
         FROM `stocks`  
          where 1 = 1 " . $appendData .
        " order by `stocks`.stockSymbol limit " . "$limite, $paginado";


$loadQ = new query();
$registros = $loadQ->select($sql);

$queryCount = "select count(*) FROM `stocks` where 1 = 1 " . $memberAppend;
$total = $loadQ->getCount($queryCount);


echo '<div class="row">';
if ($limite > 0) {
    $limit = $limite - $paginado;
    if ($limit < 0) {
        $limit = 0;
        echo "<button onclick=\"loadStocks(" . $limit . ");\" class=\"btn btn-info\" >";
        echo'<';
        echo'</button>';
    } else {
        echo "<button onclick=\"loadStocks(" . $limit . ");\" class=\"btn btn-info\" >";
        echo'◄';
        echo'</button>';
    }
} else {
    echo '<button class="btn btn-info" >';
    echo'◄';
    echo'</button>';
}
echo '&nbsp&nbsp&nbsp';


if ($limite < $total - $paginado) {
    $limit = $limite + $paginado;
    echo "<button onclick=\"loadStocks(" . $limit . ");\" class=\"btn btn-info\" >";
    echo'►';
    echo'</button>';
} else {
    echo '<button class="btn btn-info" >';
    echo'►';
    echo'</button>';
}

echo '&nbsp&nbsp&nbsp';
echo "<button onclick=\"loadStocks(0);\" class=\"btn btn-primary\" >Buscar</button>";
echo '<br>';

echo '<table class="table table-striped table-bordered"><br>' .
 '<thead>' .
 '<tr>' .
 '<th>Numero°</th>' .
 '<th>Simbolo</th>' .
 '<th align="left">Logo</th>' .
 '<th>Nombre de compañia</th>' .
 '<th>Ultima actualización</th>' .
 '<th>Ver stock (actual)</th>' .
 '</tr>' .
 '</thead>' .
 '<tbody>';

$var = $limite + 1;
while ($row = mysql_fetch_array($registros)) {
    echo '<tr>';
    echo '<td>' . $var++ . '</td>';
    echo '<td>' . $row['stockSymbol'] . '</td>';
    if ($row['stockImage'] == null) {
        echo '<td align="center"><img src="images/defaultStock.png"/  height="42" width="42"></td>';
    } else {
        echo '<td align="center"><img src="data:image/jpeg;base64,' . base64_encode($row['stockImage']) . '"/  height="42" width="42"></td>';
    }
    echo '<td>' . $row['stockName'] . '</td>';
    echo '<td>' . $row['lastPrice'] . '</td>';
    echo '<td width=90>';
    echo '<a class="btn btn-primary" target="_blank" href="https://finance.yahoo.com/quote/' . $row['stockSymbol'] . '">Visualizar</a>';
    echo '&nbsp;';
    echo '</td>';
    echo '</tr>';
}
echo '</tbody>' . '</table>';
echo '</div> ';





