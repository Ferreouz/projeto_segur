<?php
/*
Buscar no banco pelo cookie e retorna JSON para o javascript
 */
require_once 'include/conexao.class.php';
require_once 'include/response.class.php';
require_once 'include/functions.php';

$resposta = new response($mysqli);
if(isset($_COOKIE['os'])){
    $resposta->id = $_COOKIE['os'];
    $resposta->osBanco();
    $mysqli->close();
}else $resposta->erro .= "Erro Inesperado";

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($resposta);
unset($resposta);
exit;