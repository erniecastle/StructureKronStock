<?php

session_start();
include ("query.php");
include ("meYahoo.php");
include ("functions.php");
$keyUser = $_SESSION["iduser"];

function restart() {
    $redirec = "";
    $redirecH = "";
//    if (isset($onVerify) && !empty($onVerify)) {
//        $redirec = "<script language='javascript'>window.location='../posteo.php?confirmation=gut'</script>;";
//        $redirecH = "Location: posteo.php?confirmation=gut";
//    } else {
    $redirec = "<script language='javascript'>window.location='../notifier.php'</script>;";
    echo $redirec;
    //$redirecH = "Location: ../notifier.php";
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
    if ($action == "C") {
        $query = "select MAX(clave) from `stocks_user` WHERE `stocks_user`.user_id = '$keyUser' ";
        $result = $loadQuery->select($query);
        $row = mysql_result($result, 0);
        if (isset($row) && !empty($row)) {
            $row+=1;
        } else if ($row === NULL) {
            $row = 1;
        }
        echo json_encode($row);
    } else if ($action == "VI") {
        $value = $_POST["valKey"];
        $query = "select count(*) from `stocks` where stockSymbol = '$value'";
        $result = $loadQuery->getCount($query);
        if ($result > 0) {
            $query = "select id,stockName,lastPrice from `stocks` where stockSymbol = '$value'";
            $result = $loadQuery->select($query);
            if ($result == false) {
                echo json_encode("Error getdata() :" . mysql_error());
            } else {
                $name = mysql_fetch_object($result);
                $values = array($name->id, $name->stockName, $name->lastPrice);
                echo json_encode($values);
            }
        } else {//LastTradePriceOnly
            $rd = $loadYql->getCompany($value);
            if ($rd == null) {
                echo json_encode('empty');
            } else {
                $value = strtoupper($value);
                $values = array("stockSymbol" => "$value", "stockName" => "$rd[0]",
                    "lastPrice" => "$rd[1]");
                $data = $loadQuery->insert($values, "stocks");
                if ($data === "YES") {
                    $getstock = mysql_insert_id();
                    $values = array($getstock, $rd[0], $rd[1]);
                    echo json_encode($values);
                } else {
                    echo json_encode('not');
                }
            }
        }
    } else if ($action == "I") {
        $key = $_POST["textKey"];
        $key2 = $_POST["stockcold"];
        $key3 = $_POST["textBoughtStocks"];
        $key4 = $_POST["textBuyLimit"];
        $key5 = $_POST["textSellsLimit"];
        $key6 = null;
        if (isset($_POST["notifierBuy"]) && !empty($_POST["notifierBuy"])) {
            $key6 = 1;
        } else {
            $key6 = 0;
        }
        $key7 = null;
        if (isset($_POST["notifierSell"]) && !empty($_POST["notifierSell"])) {
            $key7 = 1;
        } else {
            $key7 = 0;
        }
        $key8 = $keyUser;
        $key9 = $_POST["priceStock"];
        $key10 = $_POST["percentageBuy"];
        $key11 = $_POST["percentageSell"];
        $key12 = null;
        if (isset($_POST["notifierAppBuy"]) && !empty($_POST["notifierAppBuy"])) {
            $key12 = 1;
        } else {
            $key12 = 0;
        }
        $key13 = null;
        if (isset($_POST["notifierAppSell"]) && !empty($_POST["notifierAppSell"])) {
            $key13 = 1;
        } else {
            $key13 = 0;
        }


        $loadQ = new query();
        //$current_date = date("Y-m-d H:i:s"); //'$current_date'
        $fecha = "NOW()";
        $values = array("clave" => "$key", "stock_id" => "$key2",
            "date" => $fecha, "quantity" => "$key3", "buyLimit" => "$key4",
            "sellLimit" => "$key5", "notBuy" => "$key6", "notSell" => "$key7",
            "user_id" => "$key8", "purchase" => "$key9", "appBuy" => "$key10", "appSell" => "$key11",
            "notAppBuy" => "$key12", "notAppSell" => "$key13");

        $data = $loadQ->insert($values, "stocks_user");
        if ($data === "YES") {
            restart();
        }
    } else if ($action == "MV") {
        $loadQ = new query();
        $value = $_POST["valKey"];
        $sql = "SELECT st.id,st.stockSymbol,st.stockName,su.purchase,su.quantity,
        su.buyLimit,su.sellLimit,su.appBuy,su.appSell,su.notBuy,su.notSell,
        notAppBuy,su.notAppSell,st.lastPrice FROM `stocks` st INNER JOIN `stocks_user` su
        ON st.id=su.stock_id WHERE su.user_id = '$keyUser' AND su.clave ='$value'";
        $data = $loadQ->select($sql);
        if ($data == false) {
            echo json_encode("Error getdata() :" . mysql_error());
        } else {
            $row = mysql_fetch_assoc($data);
            if (isset($row) && !empty($row)) {
                $compName = htmlspecialchars_decode($row['stockName'], ENT_NOQUOTES);
                $ar = array($row['id'], $row['stockSymbol'], $compName, $row['purchase'], $row['quantity'],
                    $row['buyLimit'], $row['sellLimit'], $row['appBuy'], $row['appSell'],
                    $row['notBuy'], $row['notSell'], $row['notAppBuy'], $row['notAppSell'],
                    $row['lastPrice']);
                echo json_encode($ar);
            } else {
                echo json_encode("");
            }
        }
    } else if ($action == "M") {
        $key = $_POST["textKey"];
        $key2 = $_POST["takeit"];
        $key3 = $_POST["textBoughtStocks"];

//        if (!empty($key3)) {
//            $key3 = floatval($key3);
//        }
        $key4 = $_POST["textBuyLimit"];
        $key5 = $_POST["textSellsLimit"];
        $key6 = null;
        if (isset($_POST["notifierBuy"]) && !empty($_POST["notifierBuy"])) {
            $key6 = 1;
        } else {
            $key6 = 0;
        }
        $key7 = null;
        if (isset($_POST["notifierSell"]) && !empty($_POST["notifierSell"])) {
            $key7 = 1;
        } else {
            $key7 = 0;
        }
        $key8 = $keyUser;
        $key9 = $_POST["priceStock"];
        $key10 = $_POST["percentageBuy"];
        $key11 = $_POST["percentageSell"];
        $key12 = null;
        if (isset($_POST["notifierAppBuy"]) && !empty($_POST["notifierAppBuy"])) {
            $key12 = 1;
        } else {
            $key12 = 0;
        }
        $key13 = null;
        if (isset($_POST["notifierAppSell"]) && !empty($_POST["notifierAppSell"])) {
            $key13 = 1;
        } else {
            $key13 = 0;
        }
        $updateData = array('stock_id' => "$key2", 'purchase' => "$key9", 'quantity' => "$key3",
            'buyLimit' => "$key4", 'sellLimit' => "$key5", 'appBuy' => "$key10", 'appSell' => "$key11",
            'notBuy' => "$key6", 'notSell' => "$key7", 'notAppBuy' => "$key12", 'notAppSell' => "$key13");

        $whereCondition = array('clave' => "$key");
        $loadQ = new query();
        $data = $loadQ->update("stocks_user", $updateData, $whereCondition);
        if ($data == false) {
            echo json_encode("Error updateData() :" . mysql_error());
        } else {
            restart();
        }
    } else if ($action == "D") {
        $key = $_POST["valKey"];
        $key = strtoupper($key);
        $loadQ = new query();
        $whereCondition = array('clave' => "$key",'user_id' => "$keyUser");
        $query = "select count(*) from `stocks_user` where clave = '$key' AND `stocks_user`.user_id = '$keyUser'";
        $result = $loadQuery->getCount($query);
        if ($result == 0) {
            echo json_encode('empty');
        } else {
            $data = $loadQ->delete("stocks_user", $whereCondition);
            if ($data == false) {
                echo json_encode("Error deleteData() :" . mysql_error());
            } else {
                echo json_encode("D");
                restart();
            }
        }
    }
}
?>
