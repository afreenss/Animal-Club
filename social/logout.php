<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="a1style.css">
    <title>Logout - Animal Club</title>
</head>
<body>
    <?php
    //include('db.php');
    include('islogged.php');

    if(!Login::isloggedin())
    {
        die ("Not logged in") ;
    }
    if(isset($_POST['confirm']))
    {
        if(isset($_POST['alldevices']))
        {
            DB::query('DELETE FROM token WHERE userid=:uid', array(':uid'=>Login::isloggedin()));
        }
        else
        {
            if(isset($_COOKIE['SNID']))
            {
                DB::query('DELETE FROM token WHERE token=:token',array(':token'=>sha1($_COOKIE['SID'])));
            }
            setcookie('SID','1',time()-9999);
            setcookie('SID1','1',time()-9999);

        }
    }

    ?>
    <div class="container">
        <div class="class1">
        <h1>Logout</h1>
    <form action="logout.php" method="POST">
    <input type="checkbox" name="alldevices" value="alldevices">Logout of all devices
    <input id="submit" type="submit" name="confirm" value="Submit">
    </form>
    </div>
    
    </div>

    
</body>
</html>