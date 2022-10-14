<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="css/index.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .erro {
        color: red;
        margin: 0;
        top :80%;
        font-size: 1rem;
        display: flex;
        position: absolute;
        justify-content: center;
}
    </style>
</head>

<body>
    <div id="container">
        <form class="center" action="login/login.php" method="post">
            <div class="center">
                <input type="text" name="usuario" id="usuario" placeholder="Digite seu usuario">
            </div>
            <div class="center">


                <input class="password" name="senha" id="senha" placeholder="Digite sua senha">

            </div>
            <div class="center">
                <input type="submit" class="submit" value="Login">
            </div>
        </form>

        <?php
        include_once 'include/functions.php';
        if(isset($_GET['erro']))
        echo "<p class='erro'>Erro:".clean($_GET['erro'])."</p>" ; 
        ?>
    </div>
</body>

</html>