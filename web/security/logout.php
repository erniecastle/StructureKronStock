<?php
session_start();
session_destroy();
echo"<script language='javascript'> window.setTimeout(function(){window.location.href = '../login.html';}, 1000);</script>";
?>


