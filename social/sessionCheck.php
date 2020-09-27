<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include('db.php');
    include('islogged.php');
    if(Login::isloggedin())
    {
        echo 'logged in';
        echo Login::isloggedin() ;
    }
    else
    {
        echo 'not logged in';
    }
    ?>
</body>
</html>