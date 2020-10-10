<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="social.js"></script>
    <title>Document</title>
</head>
<body>
    <?php
    include('islogged.php');
    if(Login::isloggedin())
    {
        if(isset($_POST['changepass']))
        {
            $oldp = $_POST['oldpass'];
            $newp = $_POST['newpass'];
            $newp1 = $_POST['newpass1'];

            $uid = Login::isloggedin();
            if(password_verify($oldp, DB::query('SELECT password FROM Users WHERE id=:userid', array(':userid'=>$uid))[0]['password']))
            {
                if($newp==$newp1)
                {
                    DB::query('UPDATE Users SET password=:newpass WHERE id=:userid',array(':newpass'=>password_hash($newp, PASSWORD_BCRYPT), ':userid'=>$uid));
                    echo "<script> alert('Password changed successfully ! ');</script>";
                }
                else
                {
                    echo "<script> alert('New passwords dont match eachother ! ');</script>";
                }
            }
            else
            {
                echo "<script> alert('Incorrect old password ! ');</script>";
            }

        }
    }
    else
    {
        die ('not logged in');
    }
    ?>

    <form name="changepassword" onsubmit="return validatepass()" action="changepass.php" method="post">
    <input type="password" name="oldpass" value= "" placeholder="old password"><br>
    <input type="password" name="newpass" value= "" placeholder="new password"><br>
    <input type="password" name="newpass1" value= "" placeholder="retype new password"><br>
    <input type="submit" name="changepass" value="Change Password">
    </form>
</body>
</html>