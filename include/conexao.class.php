<?php
$host = "";
$user = "";
$senha = "";
$db = "segur";
$port = "";


//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //p/ debugar
$mysqli = new mysqli($host, $user, $senha, $db, $port);
$mysqli->set_charset("utf8mb4");