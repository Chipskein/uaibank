<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/home.css">
</head>
<?php
    $session=session();
    $id=$session->id;
    $username=$session->username;
    $name=$session->name;
    $birthdate=$session->birthdate;
    $password=$session->password;
?>
<body style='background-color:#A060DE; margin:50px'>
    <p class='uaiBank'>UaiBank</p>
    <a class='logout' href="/users/logoff">Logout</a>
    <div class='grid'>
    <div class='BigContainer'>
    <p>Perfil</p>

    </div>
    <div class='SmallContainer'>
    <p>Perfil</p>
        
    </div>
    <div class='SmallContainer2'>
        
    </div>
    <p>Perfil</p>
    <div class='Container'>

    </div>
    <div class='Container2'>
        
    </div>
    <div class='Container3'>
        
    </div>
    <div class='SmallContainer3'>

    </div>
    <div class='SmallContainer4'>
        
    </div>
    <div class='SmallContainer5'>
        
    </div>
    </div>
    <?php
  //      $session = session();
 //       var_dump($_SESSION);
    ?>
</body>
</html>