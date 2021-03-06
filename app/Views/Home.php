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
    $userLastLogin= count($lastLogin)>0 ? $lastLogin:false;
    $birthdate= date("d-m-Y",strtotime($birthdate));
    if($userLastLogin){
        $userLastLogin= substr($userLastLogin[0]['logged_at'],0,16);
        $userLastLogin= date("d-m-Y",strtotime($userLastLogin));
    } 
    $error_msg=$session->getFlashdata('error');
    $success_msg=$session->getFlashdata('success');
?>

<body style='background-color:#A060DE; margin:50px'>
    <p class='uaiBank'>UaiBank</p>
    <a class='logout' href="/users/logoff">Logout</a>
    <div align=center>
        <?php
            if($error_msg) echo "<p class=error>$error_msg</p>";
            if($success_msg) echo "<p class=success>$success_msg</p>";
        ?>
    </div>
    <div class='grid'>
        <div class='grid-big'>
            <p class='ContainerTitle'>Perfil</p>
            <div class='Container2'>
                <div class='Container2Inside'>
                    <div class='rowProfile'>
                        <div class='image'></div>
                        <div>
                            <p class='accountBold'>Conta <?php echo $accounts[0]['id'];?></p>
                            <p class='name'><?php echo $name;?></p>
                            <p class='birthday'><?php echo $birthdate;?></p>
                        </div>
                    </div>
                    <div class='contaCorrente'>
                        <p>Saldo da conta corrente</p>
                        <input disabled class='inputSaldo' value='R$ <?php echo $accounts[0]['balance']?>'>
                        <p>Saldo da poupan??a</p>
                        <input disabled class='inputSaldo' value='R$ <?php echo $accounts[1]['balance']?>'>
                    </div>
                    <?php
                        if($userLastLogin) echo "<p>??ltimo acesso em: $userLastLogin </p>";
                    ?>

                </div>
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
                            foreach($accounts as $acc){
                                if($acc['type']=='current') $currentAccId=$acc['id'];
                            }
                            echo "<input type=hidden placeholder=\"N??mero da conta\" name=from value=$currentAccId>";
                        ?>
                            <input class='input' type="number" placeholder="N??mero da conta" name="to">
                        </div>
                    </div>
                    <input type='submit' value='Transferir' class='button'>
                </form>
            </div>
        </div>
        <div class='grid-normal'>
            <p class='ContainerTitle'>Hist??rico</p>
            <div class='Container2'>
                <div align=center style='padding-top:10px;overflow-y:scroll;height:90%;'>
                    <?php
                    if(count($transfers)>0){
                        foreach($transfers as $transfer){
                            $data= substr($transfer['transfer_date'],0,16);
                            $data= date("d-m-Y",strtotime($data));
                            echo "<div class=transDiv>";
                                echo "<div>";
                                    if($transfer['type']=='normal') echo  $transfer['from']==$currentAccId ? "<p class='title'>Transferencia enviada</p>":"<p class='title'>Transferencia recebida</p>";                                
                                    else echo  $transfer['from']==$currentAccId ? "<p class='title'>Pagamento enviado</p>":"<p class='title'>Pagamento recebido</p>";                              
                                    echo "<p class='transfersDetails'>$transfer[name]</p>";
                                    echo "<p class='transfersDetails'>R$ $transfer[value]</p>";
                                    echo "<p class='transfersDetails'>$transfer[type]</p>";
                                echo "</div>";
                                echo "<p class='transfersData'>$data</p>";
                            echo "</div>";
                        }
                    } else{
                        echo "<div class=transDiv>";
                            echo "<p>Sem Transa????es</p>";
                        echo "</div>";
                    }
                ?>

                </div>
            </div>
        </div>
        <div class='grid-normal2'>
            <p class='ContainerTitle'>Sua aplica????o da poupan??a</p>
            <div class='Container'>
                <div align=center style='padding-top:10px'>
                    <div class=poupancDiv>
                        <p>Valor Investido</p>
                        <p>R$ <?php echo $savingAccInfo['appliedValue']; ?></p>
                    </div>
                    <div class=poupancDiv>
                        <p>Rendimento (Mensal)</p>
                        <p>+ R$ <?php echo $savingAccInfo['monthYeld']; ?></p>
                    </div>
                    <div class=poupancDiv>
                        <p>Valor Acumulado</p>
                        <p>R$ <?php echo $accounts[1]['balance']?></p>
                    </div>
                    <div style='padding-top:10px'>
                        <form method="post" action="/transfers/saving/rescue">
                            <input class='input' type="number" placeholder="Digite valor do resgate" name="value">
                            <input type="hidden" name="to" value="<?php echo $accounts[0]['id']; ?>">
                            <input type="hidden" name="from" value="<?php echo $accounts[1]['id']; ?>">
                            <input type='submit' value='Resgatar' class='button'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class='grid-small3'>
            <p class='ContainerTitle'>Fa??a pagamentos</p>
            <div class='Container'>
                <form align=center action="/transfers/payment" method="post">
                    <div style='padding:10px;'>
                        <div class="custom-select" style="width:230px;margin-left:12px">
                            <select name='type'>
                                <option>Selecione forma de pagamento:</option>
                                <option>Pix</option>
                                <option>Cart??o</option>
                                <option>Boleto</option>
                            </select>
                        </div>
                        <?php echo "<input type=hidden placeholder=\"N??mero da conta\" name=from value=$currentAccId>"; ?>
                        <div align=center style='margin-top:20px'>
                            <input class='input' type="number" name="value" placeholder="value">
                            <input type="submit" value='Pagar' class='button'>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class='grid-small4'>
            <p class='ContainerTitle'>Receber dinheiro</p>
            <div class='Container'>
                <form class='alignCenter' action="/transfers/require" method="post">
                    <div style='padding:10px'>
                        <?php echo "<input type=hidden placeholder=\"N??mero da conta\" name=from value=$currentAccId>"; ?>
                        <input class='input' type="number" name="value" placeholder="R$0,00">
                        <input type="submit" class='button' value='receber'>
                    </div>
                </form>
            </div>
        </div>
        <div class='grid-small5'>
            <p class='ContainerTitle'>Aplique na poupan??a</p>
            <div class='Container'>
                <form class='alignCenter' action="/transfers/saving/apply" method="post">
                    <div style='padding:10px'>

                        <input class='input' type="number" name="value" placeholder="R$0,00">
                        <input type="hidden" name="from" value="<?php echo $accounts[0]['id']; ?>">
                        <input type="hidden" name="to" value="<?php echo $accounts[1]['id']; ?>">
                        <input type="submit" class='button' value='Aplicar'>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>
    <script>
        var x, i, j, l, ll, selElmnt, a, b, c;
        /* Look for any elements with the class "custom-select": */
        x = document.getElementsByClassName("custom-select");
        l = x.length;
        for (i = 0; i < l; i++) {
            selElmnt = x[i].getElementsByTagName("select")[0];
            ll = selElmnt.length;
            /* For each element, create a new DIV that will act as the selected item: */
            a = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
            x[i].appendChild(a);
            /* For each element, create a new DIV that will contain the option list: */
            b = document.createElement("DIV");
            b.setAttribute("class", "select-items select-hide");
            for (j = 1; j < ll; j++) {
                /* For each option in the original select element,
                create a new DIV that will act as an option item: */
                c = document.createElement("DIV");
                c.innerHTML = selElmnt.options[j].innerHTML;
                c.addEventListener("click", function (e) {
                    /* When an item is clicked, update the original select box,
                    and the selected item: */
                    var y, i, k, s, h, sl, yl;
                    s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                    sl = s.length;
                    h = this.parentNode.previousSibling;
                    for (i = 0; i < sl; i++) {
                        if (s.options[i].innerHTML == this.innerHTML) {
                            s.selectedIndex = i;
                            h.innerHTML = this.innerHTML;
                            y = this.parentNode.getElementsByClassName("same-as-selected");
                            yl = y.length;
                            for (k = 0; k < yl; k++) {
                                y[k].removeAttribute("class");
                            }
                            this.setAttribute("class", "same-as-selected");
                            break;
                        }
                    }
                    h.click();
                });
                b.appendChild(c);
            }
            x[i].appendChild(b);
            a.addEventListener("click", function (e) {
                /* When the select box is clicked, close any other select boxes,
                and open/close the current select box: */
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }

        function closeAllSelect(elmnt) {
            /* A function that will close all select boxes in the document,
            except the current select box: */
            var x, y, i, xl, yl, arrNo = [];
            x = document.getElementsByClassName("select-items");
            y = document.getElementsByClassName("select-selected");
            xl = x.length;
            yl = y.length;
            for (i = 0; i < yl; i++) {
                if (elmnt == y[i]) {
                    arrNo.push(i)
                } else {
                    y[i].classList.remove("select-arrow-active");
                }
            }
            for (i = 0; i < xl; i++) {
                if (arrNo.indexOf(i)) {
                    x[i].classList.add("select-hide");
                }
            }
        }

        /* If the user clicks anywhere outside the select box,
        then close all select boxes: */
        document.addEventListener("click", closeAllSelect);
    </script>
</body>

</html