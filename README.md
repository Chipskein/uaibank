# uaibank
Trabalho de CodeIgniter
Para uso de login e mensagens de erro entre telas, use sessoes e flashmessages;
Ex: https://github.com/ewbriao1978/proj-session
Desenvolver um sistema bancário, cadastrando usuário e gerando aleatoriamente um número de conta e um username. Neste cadastro, deve se ter um depósito inicial na conta, nome do cliente, senha. O usuário deverá entrar no sistema via login e senha. O Sistema DEVERÁ ARMAZENAR A DATA DE LOGIN E LOGOUT DE CADA USUÁRIO EM UMA TABELA para Auditoria. Seu login é seu username e a senha. Ao entrar no sistema, o usuário tem alguns menus como EXTRATO, POUPANÇA, PAGAMENTOS E TRANSFERÊNCIAS.

No EXTRATO tem todo o detalhamento de compras via débito, transferências, boletos, e crédito (salário, ou transferência realizada). Deve ter um campo data para armazenar a data em que foram realizadas as transações. Cada transação deve ter uma descrição pequena (ex: aplicação poup; resgate poup. pag. boleto, pag pix. etc).

No menu POUPANÇA, deve ter dois submenus: Aplicação e Resgate e apresentar o Saldo. Aplicação é colocar algum valor da conta corrente para a poupança. Regate é remover o valor definido pelo usuário para a conta corrente. A cada dia, deve-se aumentar o saldo da poupança de acordo com o juro anual.Taxa anual de juro é de 6.20% :'-(

!!!!!!Analisar toda e qualquer inconsistência (ex: comprar sem saldo, etc).!!!!!!!

No Menu de PAGAMENTOS , deve ter opções para escolher pagamento via pix, boletos, debito. (no nosso sistema não tem diferença entre eles, apenas irá aparecer no extrato se foi pago com boleto, pix, etc).
Cada vez que ocorre pagamento, o valor do saldo é diminuído com o valor a ser pago.


Por último, o menu TRANSFERÊNCIA, o usuário irá transferir uma quantia para uma conta destino. ( deve-se saber o numero desta conta).
A quanta deve ser diminuída do saldo atual e somada ao saldo da conta destino).
Cada Cliente tem login e senha.
TRIOS!! Era isso!! Abraço
SUGESTÃO: 1 aluno fica responsável pela tela, 1 aluno implementa o BD/ ajustes no controller, e o outro desenvolve o controller/rotas/validação.
