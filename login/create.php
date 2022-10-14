<?php
/////////////////////////////////////TODO: ENTIRE THING
include '../include/functions.php';
$r = createRandom();
echo $r .'<br>';
echo hashIt("mat",$r);