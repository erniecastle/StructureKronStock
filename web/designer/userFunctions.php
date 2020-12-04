<?php

include ("../kernel/conexion.php");
include ("functions.php");
$conn = mysql_connect(host, glb::get('userdb'), pw);
if (isset($_REQUEST["toDo"]) && !empty($_REQUEST["toDo"])) {
    if (!$conn) {
        die('Could not connect to Data: %s\n' . mysqli_connect_error());
        exit();
    } else {
        $action = $_POST["toDo"];
        mysql_query("SET character_set_results=utf8", $conn);
        mysql_select_db(db, $conn) or die("Problems to conect db");

        if ($action == "C") {
            $query = 'select MAX(clave) from `users`';
            $maxer = mysql_query($query) or die("Problems in query1:" . mysql_error());
            $row = mysql_result($maxer, 0);
            if (isset($row) && !empty($row)) {
                $row+=1;
            } else if ($row === NULL) {
                $row = 1;
            }
            echo $row;
        } else if ($action == "LT") {
            $validate = $_POST["senderUs"];
            $exits = '';
            if (isset($validate) && !empty($validate)) {
                $sql = "select case username when '" . $validate . "' then '1' else  '0'
                end as user from `users` where username='" . $validate . "' ";
                $resultado = mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_assoc($resultado);
                if (isset($row) && !empty($row)) {
                    if ($row['user'] == '1') {
                        $exits = 'user';
                    }
                } else {
                    $exits = '';
                }
            } else {
                $exits = '';
            }
            echo json_encode($exits);
        } else if ($action == "I") {
            $keySelect = $_POST['section'];
            if ($keySelect == 'administrator') {
                $keySelect = 1;
            } else if ($keySelect == 'investor') {
                $keySelect = 2;
            }
            $key = $_POST["textKey"];
            $key1 = $_POST["textNameUser"];
            if (!empty($key1)) {
                $key1 = specialCharacter($key1);
                $key1 = addslashes($key1);
                $key1 = utf8_decode($key1);
            }

            $key2 = $_POST["textUser"];
            if (!empty($key2)) {
                $key2 = specialCharacter($key2);
                $key2 = addslashes($key2);
                $key2 = utf8_decode($key2);
            }

            $key3 = $_POST["textUserMail"];
            if (!empty($key3)) {
                $key3 = specialCharacter($key3);
                $key3 = addslashes($key3);
                $key3 = utf8_decode($key3);
            }

            $key4 = $_POST["textUserPass"];
            if (!empty($key4)) {
                $key4 = specialCharacter($key4);
                $key4 = addslashes($key4);
                $key4 = utf8_decode($key4);
            }

            $key5 = null;
            if (isset($_FILES['image0']) && $_FILES['image0']['size'] > 0) {
                $tmpName = $_FILES['image0']['tmp_name']; //Temporary file name stored on the server
                $size = getimagesize($tmpName);
                $imageWidth = $size[0];
                $imageHeight = $size[1];
                $toWidht = 590;
                $toHeight = 390;
                if ($imageWidth < $imageHeight) {
                    $toWidht = 390;
                    $toHeight = 590;
                }
                if (makeThumbnail($tmpName, "../imagesThumb/imageUser.png", $toWidht, $toHeight)) {
                    $fp = fopen("../imagesThumb/imageUser.png", "r");
                    $key5 = fread($fp, filesize("../imagesThumb/imageUser.png"));
                    $key5 = addslashes($key5);
                    fclose($fp);
                }
            }

            $sql = "INSERT INTO `users` (id, clave,nombre, username, email,password,rol,image)
                VALUES (NULL, '$key','$key1','$key2','$key3','$key4','$keySelect','$key5')";
            $retval = mysql_query($sql, $conn);
            if ($retval) {
                echo"<script language='javascript'>window.location='../user.php'</script>;";
            } else {
                die('Could not insert data: ' . mysql_error());
            }
        } else if ($action == "MV") {
            $value = $_POST["valKey"];
            $sql = "select * from `users` where clave=" . mysql_real_escape_string($value);
            $resultado = mysql_query($sql) or die(mysql_error());
            $row = mysql_fetch_assoc($resultado);
            if (isset($row) && !empty($row)) {
                $ar = array($row['rol'], $row['nombre'],
                    $row['username'], $row['email'], $row['password'],
                    base64_encode($row['image']));
                echo json_encode($ar);
            } else {
                echo json_encode("");
            }
        } else if ($action == "M") {
            $key = $_POST["textKey"];
            $keySelect = $_POST['section'];
            if ($keySelect == 'administrator') {
                $keySelect = 1;
            } else if ($keySelect == 'investor') {
                $keySelect = 2;
            }
            $key2 = $_POST["textNameUser"];
            if (!empty($key2)) {
                $key2 = specialCharacter($key2);
                $key2 = addslashes($key2);
                $key2 = utf8_decode($key2);
            }


            $key3 = $_POST["textUser"];
            if (!empty($key3)) {
                $key3 = specialCharacter($key3);
                $key3 = addslashes($key3);
                $key3 = utf8_decode($key3);
            }

            $key4 = $_POST["textUserMail"];
            if (!empty($key4)) {
                $key4 = specialCharacter($key4);
                $key4 = addslashes($key4);
                $key4 = utf8_decode($key4);
            }

            $key5 = $_POST["textUserPass"];
            if (!empty($key5)) {
                $key5 = specialCharacter($key5);
                $key5 = addslashes($key5);
                $key5 = utf8_decode($key5);
            }


            $key6 = null;
            if (isset($_FILES['image0']) && $_FILES['image0']['size'] > 0) {
                $tmpName = $_FILES['image0']['tmp_name']; //Temporary file name stored on the server
                $size = getimagesize($tmpName);
                $imageWidth = $size[0];
                $imageHeight = $size[1];
                $toWidht = 590;
                $toHeight = 390;
                if ($imageWidth < $imageHeight) {
                    $toWidht = 390;
                    $toHeight = 590;
                }
                if (makeThumbnail($tmpName, "../imagesThumb/imageUser.png", $toWidht, $toHeight)) {
                    $fp = fopen("../imagesThumb/imageUser.png", "r");
                    $key6 = fread($fp, filesize("../imagesThumb/imageUser.png"));
                    $key6 = addslashes($key6);
                    fclose($fp);
                }
            }
            $merge = "";
            if (isset($key6) && !empty($key6)) {
                $merge = ",image='$key6'";
            }

            $sql = "UPDATE `users` SET rol='$keySelect', nombre = '$key2', username='$key3',"
                    . "email='$key4',password='$key5'" . $merge
                    . " where clave =" . mysql_real_escape_string($key) . "";
            $retval = mysql_query($sql);
            if ($retval) {
                echo"<script language='javascript'>window.location='../user.php'</script>;";
            } else {
                die('Could not update data: ' . mysql_error());
            }
        } else if ($action == "CU") {
            $value = $_POST["valKey"];
            $sql = "SELECT id  FROM `users` where `users`.clave=" . mysql_real_escape_string($value);
            $resultado = mysql_query($sql) or die(mysql_error());
            $row = mysql_fetch_assoc($resultado);
            if (isset($row) && !empty($row)) {
                $sql = "SELECT count(*) as invest FROM `users` INNER JOIN `stocks_user` ON `users`.id= `stocks_user`.user_id where `users`.clave=" . mysql_real_escape_string($value);
                $resultado = mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_assoc($resultado);
                $total = $row['invest'];
                if ($total > 0) {
                    echo json_encode('full');
                } else {
                    echo json_encode("empty");
                }
            } else {
                echo json_encode('nouser');
            }
        } else if ($action == "D") {
            $value = $_POST["valKey"];
            $result = mysql_query("delete from `users` WHERE clave ='$value'");
            if (!$result) {
                echo json_encode('noPlay');
                die('Could not delete data: ' . mysql_error());
            } else {
                echo json_encode('play');
            }
        }
    }
}
?>
