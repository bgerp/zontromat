<?php

// Входна точка и рутер на системата

require dirname(__DIR__) . '/lib/boot.php';



require dirname(__DIR__) . '/html/Header.php';

// Вземаме класа от параметъра клас
$ctr = isset($_REQUEST['Ctr']) ? $_REQUEST['Ctr'] : false;
$act = isset($_REQUEST['Act']) ? $_REQUEST['Act'] : 'Default';

$res = '';

if($ctr) {
    loadClass($ctr);
    $obj = new $ctr();
    $act = 'act_' . $act;
    $res = $obj->$act();
}

echo $res;

require dirname(__DIR__) . '/html/Footer.php';

