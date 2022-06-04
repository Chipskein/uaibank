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
        <form class='form' action="/users/login" method="post">
            <h1 class='logar'>Entrar agora</h1>
            <?php
                if($error_msg){
                    echo "<p class=error>$error_msg</p>";
                }
            ?>
            <div>
                <p class='inputTitle'>Username</p>
                <input class='input' type="text" placeholder="Digite seu username" name="username">
            </div>
            <div>
                <p class='inputTitle'>Senha</p>
                <input class='input' type="password" placeholder="Digite sua senha" name="password">
            </div>
            <div class='submitSpace'>
                <input class='submit' type="submit" value="Logar">
                <a href='/users/register'>
                    <div class='submitInverted'>Criar Conta</div>
                </a>
            </div>
        </form>
    </div>
</body>
</html>