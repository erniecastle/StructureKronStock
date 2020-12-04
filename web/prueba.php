<?php

//include ("designer/compareFunctions.php");
//
//$iSell = compareFloatNumbers(190.15, 190.16, '>=');
//
//var_dump($iSell);
require_once('Thread.php');

class writerThread extends Thread {

    public function __construct($type = "error", $message = '') {
        $this->type = $type;
        $this->message = $message;
    }

    public function run() {
        file_put_contents($filename, $this->type . $this->message);
    }

}

$writer = new WriterThread("testing done");
$writer->start();
?>
