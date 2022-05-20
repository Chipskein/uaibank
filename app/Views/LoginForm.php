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
<body>
    <div class='image'></div>
    <div class='Screen'>
    <p class='uaiBank'>UaiBank</p>
    <form class='form' action="/users/login" method="post">
        <h1 class='logar'>Entrar agora<h1>
            <p class='inputTitle'>Username</p>
            <input class='input' type="text" placeholder="Digite seu username" name="username">
            <p class='inputTitle'>Senha</p>
            <input class='input' type="password" placeholder="Digite sua senha" name="password">
            <div class='submitSpace'>
            <input class='submit' type="submit" value="Logar">
            <a href='/users/register' class='submitInverted'>Criar Conta</a>
            </div>
    </form>
    </div>
</body>
</html>