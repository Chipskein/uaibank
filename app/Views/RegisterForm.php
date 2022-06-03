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
            <h1 class='logar'>Criar Conta</h1>
            <div>
                <p class='inputTitle'>Nome completo</p>
                <input class='input' type="text" placeholder="Digite seu nome" name="name">
            </div>
            <div>
                <p class='inputTitle'>Username</p>
                <input class='input' type="text" placeholder="Digite seu username" name="username">
            </div>
            <div>
                <p class='inputTitle'>Senha</p>
                <input class='input' type="password" placeholder="Digite sua senha" name="password">
            </div>
            <div>
                <p class='inputTitle'>Data de nascimento</p>
                <input class='input' type="date" placeholder="Sua data de nascimento" name="birthdate">
            </div>
            <div>
                <p class='inputTitle'>Saldo inicial</p>
                <input class='input' type="number" min="0.0" step='0.1' placeholder="R$ 1.000,00" name="balance_current">
            </div>

            <div class='submitSpace'>
                <input class='submit' type="submit" value="Criar conta">
                <a href='/users/login'>
                    <div class='submitInverted'>Login</div>
                </a>
            </div>
        </form>
    </div>
</body>

</html>