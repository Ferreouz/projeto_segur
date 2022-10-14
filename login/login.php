<?php
session_start();
require_once '../include/functions.php';
require_once '../include/conexao.class.php';

function outError($error){
    if($mysqli)
        $mysqli->close();
    header("Location: ../index?erro=$error");
    exit;
}

if(empty($_POST['usuario']) || empty($_POST['senha']))
    outError("Usuario%20e%20Senha%20Nao%20Fornecido");

$usuario = clean($_POST['usuario'],false);

$stmt = $mysqli->prepare("SELECT * from tabela_login WHERE matricula = ? LIMIT 1");
$stmt->bind_param("i", $usuario);
if(!$stmt->execute())
    outError("Credenciais%20Erradas");


//Pegando o resultado
$result = $stmt->get_result();
//Numero of linhas
$count = $result->num_rows;
if($count !== 1){
    //P/ nao indicar que o usuario nao existe
    hashIt("Haribeterte","salt");
    outError("Credenciais%20Erradas");
}else{
    $result = $result->fetch_assoc();
    $salt = $result['random'];
    $nome = $result['nome'];
    $senha = clean($_POST['senha']);
    $senha = hashIt($senha,$salt);

    $stmt = $mysqli->prepare("SELECT * from tabela_login WHERE matricula = ? AND senha = ? LIMIT 1");
    $stmt->bind_param("is", $usuario, $senha);
    if(!$stmt->execute())
        outError("Credenciais%20Erradas");
    $result = $stmt->get_result();
    $count = $result->num_rows;
    if($count !== 1)
        outError("Credenciais%20Erradas");
    else {
        $_SESSION['usuario'] = array($nome,$usuario);
        $mysqli->close();
        header("Location: ../home");
        exit;
    }
}