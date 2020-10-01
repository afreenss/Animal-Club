<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php
   // include('db.php');
   include('islogged.php');
    $user ="";
    /*if(Login::isloggedin())
    {
        echo 'logged in';
        echo Login::isloggedin() ;
    }
    else
    {
        echo 'not logged in';
    }*/
    if(isset($_GET['username']))
    {
        if(DB::query('SELECT username FROM Users WHERE username=:username',array(':username'=>$_GET['username'])))
        {
            $user = DB::query('SELECT username FROM Users WHERE username=:username',array(':username'=>$_GET['username']))[0]['username'];
            if (isset($_POST['follow'])) 
            {
                $uid = DB::query('SELECT ID FROM Users WHERE username=:username', array(':username'=>$_GET['username']))[0]['ID'];
                $fid = Login::isloggedin();

                if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:uid', array(':uid'=>$uid))) 
                {
                    DB::query('INSERT INTO followers VALUES (null, :uid, :fid)', array(':uid'=>$uid, ':fid'=>$fid));
                } 
                else 
                {
                    echo 'Already following!';
                }
            }
        }

    }
    else
    {
        die('user not found ');
    }
    
    ?>
    <h1><?php echo $user;?>'s Profile</h1>
    <form action="profile.php?username=<?php echo $user; ?>" method="post">
    <input type="submit" name="follow" value="Follow!">
    </form>
</body>
</html>