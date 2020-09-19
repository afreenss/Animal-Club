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
    if (isset($_POST['login']))
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        if(DB::query('SELECT username FROM Users WHERE username=:username', array(':username'=>$user)))
        {
            if(password_verify($pass, DB::query('SELECT password FROM Users WHERE username=:username', array(':username'=>$user))[0]['password']))
            {
                echo "logged in !!! woop woop";
                $crypto = True ;
                $tokens = bin2hex(openssl_random_pseudo_bytes(64, $crypto));
                $uid = DB::query('SELECT ID FROM Users WHERE username=:username', array(':username'=>$user))[0]['ID'];
                DB::query('INSERT INTO token VALUES (null, :token, :userid)', array(':token'=>sha1($tokens), ':userid'=>$uid));
                
                setcookie("SNID", $tokens, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            }
            else
            {
                echo "incorrect pass !";
            }
        }
        else
        {
            echo "LOL KAHA";
        }
    }

    ?>
    <h1>LOG IN </h1>
    <form name="log" action="login.php" method="post">
        <input type="text" name="username" value="" placeholder="Username ..."><p />
        <input type="password" name="password" value="" placeholder="Password ..."><p />
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>