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
    class Login
    {
        public static function isloggedin()
        {
            if(isset($_COOKIE['SID']))
            {
                if(DB::query('SELECT userid FROM token WHERE :token=token',array(':token'=>sha1($_COOKIE['SID']))))
                {
                    $uid = DB::query('SELECT userid FROM token WHERE :token=token',array(':token'=>sha1($_COOKIE['SID'])))[0]['userid'];
                    if(isset($_COOKIE['SID1']))
                    {
                        return $uid;
                    }
                    else
                    {
                    $crypto = True ;
                    $tokens = bin2hex(openssl_random_pseudo_bytes(64, $crypto));
                    DB::query('INSERT INTO token VALUES (null, :token, :userid)', array(':token'=>sha1($tokens), ':userid'=>$uid));
                    DB::query('DELETE FROM token WHERE token=:token', array(':token'=>sha1($_COOKIE['SID'])));
                    setcookie("SID", $tokens, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                    setcookie("SID1", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                    return $uid ;
                    }
                }
            }
            return false ;
        }
    }
    ?>
</body>
</html>