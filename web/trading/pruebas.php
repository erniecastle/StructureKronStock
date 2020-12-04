<?php

$collection = array();

$collection['aa'] = array('title' => 'good', 'artist' => 'dsfsdf');
$collection['bb'] = array('title' => 'dsfsdfs', 'artist' => 'dswdf');
$collection[] = array('title' => 'ssdfsf', 'artist' => 'dwer');
$collection[] = array('title' => 'sdsdfsd', 'artist' => 'dewrwedf');



echo $collection['aa']['title'];

//foreach ($collection as $cd) {
//    echo $cd['title'], ' by ', $cd['artist'], "<br>";
//}
// or
//for($i=0,$j=count($collection); $i<$j, ++$i) {
//  echo $collection[$i]['title'], ' by ', $collection[$i]['artist'], "<br>";
//}
//$s = new SplObjectStorage;
//$o1 = new stdClass;
//$o2 = new stdClass;
//$o2->foo = 'bar';
//$o2->asthom = 'bari';
//
//$s[$o1] = 'baz';
//$s[$o2] = 'bingo';
//
//echo $s[$o1]; // 'baz'
//echo $o2->foo; // 'bingo'
//echo $o2->asthom; // 'bingo'
?>



