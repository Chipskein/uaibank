<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UaiBank</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/global.css">
</head>
<?php
    $session=session();
    $error_msg=$session->getFlashdata('error');
?>
<body>
    <div class='image'></div>
    <div class='Screen'>
    <p class='uaiBank'>UaiBank</p>
    <form class='form' action="/users/register" method="post">
        <h1 class='logar'>Criar Conta<h1>
            <p class='inputTitle'>Nome completo</p>
            <input class='input' type="text" placeholder="Digite seu nome" name="name">
            <p class='inputTitle'>Username</p>
            <input class='input' type="text" placeholder="Digite seu username" name="username">
            <p class='inputTitle'>Senha</p>
            <input class='input' type="password" placeholder="Digite sua senha" name="password">
            <input class='input' type="date" placeholder="Sua data de nascimento" name="birthdate">
            <input class='input' type="number" min="0.0" step='0.1'placeholder="Saldo inicial" name="balance_current"> 
            <div class='submitSpace'>
            <input class='submit' type="submit" value="Criar conta">
            </div>
    </form>
    </div>
</body>
</html>