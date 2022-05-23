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

    $userAccounts=$accounts;
    $userTransfers=$transfers;
    $userLastLogin=$lastLogin;
?>
<body style='background-color:#A060DE; margin:50px'>
    <p class='uaiBank'>UaiBank</p>
    <a class='logout' href="/users/logoff">Logout</a>
    <div class='grid'>
    <div class='grid-big'>
        <p class='ContainerTitle'>Perfil</p>
        <div class='Container2'>

        </div>

    </div>
    <div class='grid-small'>
        <p class='ContainerTitle'>Regras para transferencias</p>
        <div class='Container'>
            <p style='padding-top:20px'>- Disponível em dias úteis das 10h às 17h, sem taxas.</p>
            <p>- Você só pode transferir dinheiro menor ou igual ao seu saldo na conta corrente.</p>
        </div>
    </div>
    <div class='grid-small2'>
        <p class='ContainerTitle'>Transfira agora!</p>
        <div class='Container'>
            <form action="/transfers" method="post">
                <div class='row'>
                    <div class='marginInput'>
                        <p class='inputTitle'>Valor</p>
                        <input class='input' type="number" placeholder="R$0,00" name="value">
                    </div>
                    <div>
                    <p class='inputTitle'>Destino</p>
                        <?php
                            $currentAccId;
                            foreach($userAccounts as $acc){
                                if($acc['type']=='current') $currentAccId=$acc['id'];
                            }
                            echo "<input type=hidden placeholder=\"Número da conta\" name=from value=$currentAccId>";
                        ?>    
                        <input class='input' type="number" placeholder="Número da conta" name="to">
                        </div>
                </div>
                <input type='submit' value='Transferir' class='button'>
            </form>
        </div>
    </div>
    <div class='grid-normal'>
        <p class='ContainerTitle'>Histórico</p>
        <div class='Container'>

        </div>
    </div>
    <div class='grid-normal2'>
        <p class='ContainerTitle'>Sua aplicação da poupança</p>
        <div class='Container'>

        </div>
    </div>
    <div class='grid-small3'>
    <p class='ContainerTitle'>Faça pagamentos</p>
        <div class='Container'>
            <div style='padding:10px'>
        <nav>
<label for="touch"><span>Pix</span></label>               
<input type="checkbox" id="touch"> 

<ul class="slide">
  <li><a href="#">Cartão</a></li> 
  <li><a href="#">Boleto</a></li>
</ul>

</nav> 
</div>
        </div>
    </div>
    <div class='grid-small4'>
    <p class='ContainerTitle'>Receber dinheiro</p>
        <div class='Container'>

        </div>
    </div>
    <div class='grid-small5'>
    <p class='ContainerTitle'>Aplique na poupança</p>
        <div class='Container'>

        </div>
    </div>
    </div>
</body>
</html>