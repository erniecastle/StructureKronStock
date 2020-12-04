<?php

session_start();
include ("../designer/queryLi.php");
$loadQli = new queryLi();
$tbl_name = "users";
$myusername = $_POST['textUsMa'];
$mypassword = $_POST['textPass'];
// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$sql = "SELECT * FROM $tbl_name WHERE (username= ? or email= ?) and password= ?";
$result = $loadQli->select($sql, 'sss', array($myusername, $myusername, $mypassword));
if (isset($result) && !empty($result)) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_object();
        $_SESSION["myusername"] = $row->nombre;
        $_SESSION["iduser"] = $row->id;
//ob_end_flush();
        $sql = "UPDATE $tbl_name SET lastLog = NOW() WHERE id = '$row->id' ";
        $loadQli->updatequery($sql);
        //echo json_encode('ops');
        // header("Location: ../login.html");
        echo "<script language='javascript'>window.location='../mystocks.php'</script>;";
    } else {
        // echo "<script language='javascript'>window.location='../login.html'</script>;";
        $_SESSION["myusername"] = 'empty';
        echo "<script language='javascript'>window.location='../login.html'</script>;";
        // echo json_encode('empty');
    }
}



