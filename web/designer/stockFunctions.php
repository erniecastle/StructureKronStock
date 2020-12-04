<?php

include ("query.php");
include ("meYahoo.php");
include ("functions.php");

function restart() {
    $redirec = "";
    $redirecH = "";
//    if (isset($onVerify) && !empty($onVerify)) {
//        $redirec = "<script language='javascript'>window.location='../posteo.php?confirmation=gut'</script>;";
//        $redirecH = "Location: posteo.php?confirmation=gut";
//    } else {
    $redirec = "<script language='javascript'>window.location='../stock.php'</script>;";
    //$redirecH = "Location: ../stock.php";
    
    echo $redirec;
//    }
//    $kindServer = $_SERVER['HTTP_HOST'];
//    if ($kindServer == 'www') {
//        echo $redirec;
//    } else {
//        header($redirecH);
//        //echo $redirec;
//    }
}

if (isset($_REQUEST["toDo"]) && !empty($_REQUEST["toDo"])) {
    $action = $_POST["toDo"];
    $loadQuery = new query();
    $loadYql = new meYahoo();
    if ($action == "R") {
        $value = $_POST["valKey"];
        $query = "select count(*) from `stocks` where stockSymbol = '$value'";
        $result = $loadQuery->getCount($query);
        if ($result > 0) {
            echo json_encode('full');
        } else {
            $rd = $loadYql->getCompany($value);
            if ($rd == null) {
                echo json_encode('empty');
            } else {
                echo json_encode($rd);
            }
        }
    } else if ($action == "I") {
        $key = $_POST["textKey"];
        $key = strtoupper($key);
        $key2 = $_POST["textTitleStock"];
        $key3 = $_POST["actualPrice"];
        if (!empty($key2)) {
            $key2 = specialCharacter($key2);
            $key2 = addslashes($key2);
            $key2 = utf8_decode($key2);
        }
        $keyMi = null;
        $loadQ = new query();
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $tmpName = $_FILES['image']['tmp_name'];
            if (makeThumbnail($tmpName, "../imagesThumb/iconStock.png", 100, 100)) {
                $fp = fopen("../imagesThumb/iconStock.png", "r");
                $keyMi = fread($fp, filesize("../imagesThumb/iconStock.png"));
                $keyMi = addslashes($keyMi);
                fclose($fp);
            }
        }
        $values = array("stockSymbol" => "$key", "stockName" => "$key2", "lastPrice" => "$key3");
        if ($keyMi != null) {//"stockImage", "$keyMi"
            $values = array_push_assoc($values, "stockImage", "$keyMi");
        }
        $data = $loadQ->insert($values, "stocks");
        if ($data === "YES") {
            restart();
        }
    } else if ($action == "MV") {
        $loadQ = new query();
        $value = $_POST["valKey"];
        $sql = "select * from `stocks` where stockSymbol= '$value'";
        $data = $loadQ->select($sql);
        if ($data == false) {
            echo json_encode("Error getdata() :" . mysql_error());
        } else {
            $row = mysql_fetch_assoc($data);
            if (isset($row) && !empty($row)) {
                $nameCorp = htmlspecialchars_decode($row['stockName'], ENT_NOQUOTES);
                $priceStock = htmlspecialchars_decode($row['lastPrice'], ENT_NOQUOTES);
                $ar = array($nameCorp, $priceStock, base64_encode($row['stockImage']));
                echo json_encode($ar);
            } else {
                echo json_encode("");
            }
        }
    } else if ($action == "M") {
        $key = $_POST["textKey"];
        $key = strtoupper($key);
        $key2 = $_POST["textTitleStock"];
        $key3 = $_POST["actualPrice"];
        $keyMi = null;
        if (!empty($key2)) {
            $key2 = specialCharacter($key2);
            $key2 = addslashes($key2);
            $key2 = utf8_decode($key2);
        }
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $tmpName = $_FILES['image']['tmp_name'];
            if (makeThumbnail($tmpName, "../imagesThumb/iconStock.png", 100, 100)) {
                $fp = fopen("../imagesThumb/iconStock.png", "r");
                $keyMi = fread($fp, filesize("../imagesThumb/iconStock.png"));
                $keyMi = addslashes($keyMi);
                fclose($fp);
            }
        }
        $updateData = array('stockName' => "$key2", "lastPrice" => "$key3");
        if ($keyMi == null) {
            if (isset($_FILES['deleted'])) {
                $updateData = array_push_assoc($updateData, "stockImage", NULL);
            }
        } else {
            $updateData = array_push_assoc($updateData, "stockImage", "$keyMi");
        }
        $whereCondition = array('stockSymbol' => "$key");
        $loadQ = new query();
        $data = $loadQ->update("stocks", $updateData, $whereCondition);
        if ($data == false) {
            echo json_encode("Error updateData() :" . mysql_error());
        } else {
            restart();
        }
    } else if ($action == "D") {
        $key = $_POST["valKey"];
        $key = strtoupper($key);
        $loadQ = new query();
        $whereCondition = array('stockSymbol' => "$key");
        $query = "select count(*) from `stocks` where stockSymbol = '$key'";
        $result = $loadQuery->getCount($query);
        if ($result == 0) {
            echo json_encode('empty');
        } else {
            $query = "SELECT count(*) FROM stocks_user INNER JOIN stocks
                ON stocks_user.stock_id = stocks.id WHERE stockSymbol = '$key'";
            $result = $loadQuery->getCount($query);
            if ($result > 0) {
                echo json_encode('invest');
                return;
            } else {
                $data = $loadQ->delete("stocks", $whereCondition);
                if ($data == false) {
                    echo json_encode("Error deleteData() :" . mysql_error());
                } else {
                    echo json_encode("D");
                    //restart();
                }
            }
        }
    }
}
?>