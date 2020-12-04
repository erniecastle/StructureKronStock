<?php
include ("designer/query.php");
$loadQ = new query();
$tbl_name = "users";
if (isset($_POST['textUsMa']) && isset($_POST['textPass'])) {
    $myusername = $_POST['textUsMa'];
    $mypassword = $_POST['textPass'];
    $sql = "SELECT * FROM $tbl_name WHERE (username= " . $myusername . " or email= " . $myusername . ") and password= " . $mypassword . "";
    $result = $loadQ->select($sql);
    if ($result) {
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            $_SESSION["myusername"] = $row["nombre"];
            $_SESSION["iduser"] = $row["id"];
            $sql = "UPDATE $tbl_name SET lastLog = NOW() WHERE id = " . $row['id'] . " ";
            $fecha = "NOW()";
            $loadQ->select($sql);
//        $fields = array('lastLog' => $fecha);
//        $loadQ->update($tbl_name, array('lastLog' => $fecha), array('id' => $row["id"]));
            echo"<script language='javascript'> window.setTimeout(function(){window.location.href = 'mystocks.php';}, 0000);</script>";
            //header("Location: mystocks.php");
        } else {
            echo '<script type="text/javascript">notValidUser();</script>';
            echo"<script language='javascript'> window.setTimeout(function(){window.location.href = 'login.html';}, 1000);</script>";
        }
    }
}
?>














<!--echo date("h:i:s A");
$cars = array
(
array("Volvo", 22, 18),
array("BMW", 15, 13),
array("Land Rover", 17, 15),
array("Saab", 5, 2),
array("Land Rover", 17, 15),
);




$S1 = array("Aston", 80, 40);

array_push($cars, $S1);

sort($cars); //Ordenaria por usuario

$kindStock = "";
for ($row = 0; $row < count($cars); $row++) {

if ($kindStock != $cars[$row][0]) {
echo "<p><b>Stock de" . $cars[$row][0] . " </b></p>";
}

// echo "<ul>";
    for ($col = 0; $col < 3; $col++) {
    echo "<li>" . $cars[$row][$col] . "</li>";
    }
    }
    //echo "</ul>";


//$values = array_push_assoc($values, "stockImage", "$keyMi");
//echo date("h:i:s A");
//echo '<pre>';
//print_r($cars);
//echo '</pre>';-->

