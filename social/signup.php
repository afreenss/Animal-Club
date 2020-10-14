<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="social.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
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
            if (strlen($user) >= 3 && strlen($user) <= 32) 
            {
                if (preg_match('/[a-zA-Z0-9_]+/', $user)) 
                {
                    if (strlen($pass) >= 6 && strlen($pass) <= 60) 
                    {
                        if (filter_var($e, FILTER_VALIDATE_EMAIL)) 
                        {
                            if (!DB::query('SELECT email FROM Users WHERE email = :email', array(':email'=>$e)))
                            {
                                DB::query('INSERT INTO Users VALUES (null , :username, :password, :email, null)', array(':username'=>$user, ':password'=>password_hash($pass, PASSWORD_BCRYPT), ':email'=>$e));
                                echo "<script> alert('Account created ! ');</script>";
                                echo "<script> location.href='http://localhost:8080/Animal-Club/social/login.html'; </script>";

                            }
                            else
                            {
                                echo "<script> alert('This email is already registered with an account ! ');</script>";
                                echo "<script> location.href='http://localhost:8080/Animal-Club/social/signup.html'; </script>";

                            } 
                        }
                        else 
                        {
                            echo "<script> alert('Please enter a valid email ID ! ');</script>";
                            echo "<script> location.href='http://localhost:8080/Animal-Club/social/signup.html'; </script>";

                        }
                    } 
                    else 
                    {
                        echo "<script> alert('Password must be between 6 to 60 charecters ! ');</script>";
                        echo "<script> location.href='http://localhost:8080/Animal-Club/social/signup.html'; </script>";

                    }
                    } 
                else 
                {
                    echo "<script> alert('Username must only contain alphanumeric charecters and _ ! ');</script>";
                    echo "<script> location.href='http://localhost:8080/Animal-Club/social/signup.html'; </script>";

                }
                } 
            else 
            {
                echo "<script> alert('Username must be between 3 - 32 charecters ! ');</script>";
                echo "<script> location.href='http://localhost:8080/Animal-Club/social/signup.html'; </script>";

            }
        }    
        else
        {
            echo "<script> alert('Username already taken ! ');</script>";
            echo "<script> location.href='http://localhost:8080/Animal-Club/social/signup.html'; </script>";

        }
    }
    ?>
    <!--
            <h1>Register</h1>
    <form name="createacc" onsubmit="return validatecreate()" action="signup.php" method="post">
        <input type="text" name="username" value="" placeholder="Username"><p />
        <input type="password" name="password" value="" placeholder="Password"><p />
        <input type="email" name="email" value="" placeholder="someone@somesite.com"><p />
        <input type="submit" name="createaccount" value="Create Account">
    </form>
    -->


</body>
</html>
