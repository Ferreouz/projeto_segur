<?php
require_once 'login/verificaLogin.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Segurança do Trabalho</title>
</head>

<body>

    <img id="menuButton" class="menu-img" src="img/menu.png">
    <div id="drawer" class="drawer sumir">
        <div class="drawer-son">
            <label for="data1">Inicial:</label>
            <input type="date" id="data1_excel" name="data1">
            <label for="data2">Final:</label>
            <input type="date" id="data2_excel" name="data2">
            <label for="equipe">Equipe:</label>
            <input type="number" id="equipe_excel" name="equipe">
            <button id="excel" onclick="imprimirExcel()">Imprimir Excel</button>
        </div>
    </div>

    <div id="container">
        <p id="resposta"></p>
        <form id="form">
            <label for="diretoria">Diretoria:</label>
            <input type="text" id="diretoria" name="diretoria">
            <label for="data1">Data:</label>
            <input type="date" id="data1" name="data1">
            <label for="time1">Hora:</label>
            <input type="time" id="time1" name="time1">
            <label for="responsavel">Responsavel:</label>
            <input type="text" id="responsavel" name="responsavel">
            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa">
            <label for="equipe">Nr. Equipe:</label>
            <input type="number" id="equipe" name="equipe">


            <div id="divRisco">
                <label for="risco">Risco:</label>
                <input type="text" id="risco" name="risco" placeholder="RADIO BOTAO">
                <label for="gradacao">Gradação:</label>
                <input type="text" id="gradacao" name="gradacao" placeholder="RADIO BOTAO">
                <label for="fator_risco">Fator Risco:</label>
                <input type="text" id="fator_risco" name="fator_risco">
                <label for="descricao">Descricao do Risco:</label>
                <input type="text" id="descricao" name="descricao" placeholder="CAIXA DE TEXTO GRANDE">
                <label for="medidas">Medidas de correção:</label>
                <input type="text" id="medidas" name="medidas" placeholder="CAIXA DE TEXTO GRANDE">
                <input type="file" name="f[]" id="f" accept="image/*" multiple>
                <label for="desc_foto">Descrição das fotos:</label>
                <input type="text" id="desc_foto" name="desc_foto" placeholder="CAIXA DE TEXTO GRANDE">
            </div>
            <button type="submit" id="maisItem">+ITEM</button>
        </form>

        <button onclick="novaOS()" id="resetar">NOVA OS</button>

        <script src="./js/funs.js"></script>
        <script src="./js/form.js"></script>
    </div>
</body>

</html>