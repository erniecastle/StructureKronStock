<?php

//include (__DIR__ . "/conexion.php");
include (__DIR__ . "/../kernel/conexion.php");
//require_once __DIR__ . "/../kernel/conexion.php";
setlocale(LC_ALL, "es_ES");

function get($query) {
    openCxn();
    $registro = mysql_query($query) or die("Problems in query:" . mysql_error());
    $resultset = array();
    while ($row = mysql_fetch_arraY($registro)) {
        $resultset[] = $row;
    }
    mysql_close();
    return $resultset;
}

function getCount($query) {
    openCxn();
    $registro = mysql_query($query) or die("Problems in query:" . mysql_error());
    $total = mysql_fetch_array($registro);
    mysql_close();
    return $total[0];
}

function getUnique($query) {
    openCxn();
    $registro = mysql_query($query) or die("Problems in query:" . mysql_error());
    $row = mysql_fetch_assoc($registro);
    mysql_close();
    return $row;
}

function getRegisters($query) {
    openCxn();
    $registros = mysql_query($query) or die("Problems in query:" . mysql_error());
    mysql_close();
    return $registros;
}

function update($query) {
    openCxn();
    $retval = mysql_query($query);
    if (!$retval) {
        die('Could not insert new data: ' . mysql_error());
    }
    mysql_close();
    return $retval;
}

function delete($query) {
    openCxn();
    $retval = mysql_query($query);
    if (!$retval) {
        die('Could not insert new data: ' . mysql_error());
    }
    mysql_close();
    return $retval;
}

function openCxn() {
    if (!textCxn()) {
        glb::set('userdb', 'administrador');
        if (!textCxn()) {
            glb::set('userdb', 'administrador2');
            if (!textCxn()) {
                die("Problems to coneect Server" . mysql_error());
                //die('Problems to coneect db: ' . mysql_error());
            }
        }
    }
}

function textCxn() {
    $conn = mysql_connect(host, glb::get('userdb'), pw);
    if ($conn) {
        mysql_query("SET character_set_results=utf8", $conn);
        $db = mysql_select_db(db, $conn);
        if ($db) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    return true;
}

?>