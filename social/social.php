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
    function isloggedin()
    {
        if(isset($_COOKIE['SID']))
        {
            if(DB::query('SELECT userid FROM token WHERE :token=token',array(':token'=>sha1($_COOKIE['SID']))))
            {
                return true ;
            }
        }
        return false ;
    }
    if(isloggedin())
    {
        echo 'logged in';
    }
    else
    {
        echo 'not loggged in';
    }
    ?>
</body>
</html>