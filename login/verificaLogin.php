<?php
session_start();
if(!isset($_SESSION['usuario']) || !is_array($_SESSION['usuario'])){
    header("Location: /segur/index?erro=Nao%20Autenticado");
    exit;
}