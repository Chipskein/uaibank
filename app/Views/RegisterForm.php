<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UaiBank</title>
</head>
<body>
    <form action="/users/register" method="post">
        <input type="text" placeholder="username" name="username">
        <input type="password" placeholder="password" name="password">
        <input type="text" placeholder="name" name="name">
        <input type="date" placeholder="birthdate" name="birthdate">
        <input type="number" min="0.0" step='0.1'placeholder="balance current R$0,0" name="balance_current">        
        <input type="number" min="0.0" step='0.1'placeholder="balance saving R$0,0" name="balance_saving">        
        <input type="submit" value="Sign in">
    </form>
</body>
</html>