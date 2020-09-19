<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="social.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include('db.php');

    if (isset($_POST['createaccount'])) 
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $e = $_POST['email'];

        if (!DB::query('SELECT username FROM Users WHERE username = :username', array(':username'=>$user)))
        {
            DB::query('INSERT INTO Users VALUES (null , :username, :password, :email)', array(':username'=>$user, ':password'=>password_hash($pass, PASSWORD_BCRYPT), ':email'=>$e));
            echo "Success!" ;
        }
        else
        {
            echo "User exists!!!" ;
        }
    }
    ?>
    <h1>Register</h1>
    <form name="createacc" onsubmit="return validatecreate()" action="social.php" method="post">
        <input type="text" name="username" value="" placeholder="Username ..."><p />
        <input type="password" name="password" value="" placeholder="Password ..."><p />
        <input type="email" name="email" value="" placeholder="someone@somesite.com"><p />
        <input type="submit" name="createaccount" value="Create Account">
    </form>

</body>
</html>
