<?php

include (__DIR__ . "/../kernel/conexion.php");
//require_once __DIR__ . "/../kernel/conexion.php";
setlocale(LC_ALL, "es_ES");

/**
 * Description of query
 *
 * @author Invest
 */
class query {

    private function openCxn() {
        $conn = mysql_connect(host, user, pw) or die("<br/>Could not connect to MySQL server");
        mysql_select_db(db, $conn) or die("<br/>Could not select the indicated database");
        return $conn;
    }

    function select($query) {
        $this->openCxn();
        $res = mysql_query($query);
        return $res;
    }

    function getCount($query) {
        $this->openCxn();
        $registro = mysql_query($query) or die("Problems in query: getCount()" . mysql_error());
        $total = mysql_fetch_array($registro);
        mysql_close();
        return $total[0];
    }

    public function insert($values, $table) {//Dynamic Insert
        if (empty($values) || empty($table)) {
            return "";
        }
        $this->openCxn();
        $list = array();
        foreach ($values as $k => $v)
            $list[] = "`" . $k . "` = " . ($v == 'NOW()' ? 'NOW()' : " '" . $v . "'");
        $list = implode(",", $list);
        $query = "INSERT INTO `" . $table . "` SET " . $list;
        $retval = mysql_query($query);
        if (!$retval) {
            die('Could not insert data: ' . mysql_error());
            return "NO";
        } else {
            return "YES";
        }
        mysql_close();
    }

    public function update($table_name, $fields, $where) {
        $this->openCxn();
        $query = '';
        $condition = '';
        foreach ($fields as $key => $value) {
            if (is_null($value)) {
                $query .= $key . "=NULL, ";
            } else {
                $query .= $key . "='" . $value . "', ";
            }
        }
        $query = substr($query, 0, -2);
        foreach ($where as $key => $value) {
            $condition .= $key . "='" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);
        $query = "UPDATE " . $table_name . " SET " . $query . " WHERE " . $condition . "";
        $res = mysql_query($query);
        return $res;
    }

    public function delete($table_name, $where) {
        $this->openCxn();
        $condition = '';
        foreach ($where as $key => $value) {
            $condition .= $key . "='" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);
        $query = "DELETE FROM " . $table_name . " WHERE " . $condition . "";
        $res = mysql_query($query);
        return $res;
    }

}
