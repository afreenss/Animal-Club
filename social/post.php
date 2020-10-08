<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    class Post
    {
        public static function createpost($posttext, $loggedinuser, $profileid)
        {
            if (strlen($posttext) > 300 || strlen($posttext) < 1)
            {
                die('Post length must be between between 1 to 300 charecters !');
            }
            if($loggedinuser == $profileid)
            {
                DB::query('INSERT INTO post VALUES (null, :posttext, :uid, 0, NOW(), null)', array(':posttext'=>$posttext , ':uid'=>$profileid));
            }
            else
            {
                die("incorrect page ! ");
            }
        }
        public static function createimgpost($posttext, $loggedinuser, $profileid)
        {
            if (strlen($posttext) > 300)
            {
              die('Incorrect lenght!');
            }
            if($loggedinuser == $profileid)
            {
                DB::query('INSERT INTO post VALUES (null, :posttext, :uid, 0, NOW(), null)', array(':posttext'=>$posttext , ':uid'=>$profileid));
                $postid = DB::query('SELECT ID FROM post WHERE user_id=:uid ORDER BY ID DESC LIMIT 1', array(':uid'=>$loggedinuser))[0]['ID'];
                return $postid ;
            }
            else
            {
                die("incorrect page ! ");
            }
        }
        public static function likepost($postid, $likerid)
        {
            if(!DB::query('SELECT user_id FROM postlikes WHERE post_id=:postid AND user_id=:uid', array(':postid'=>$postid, ':uid'=>$likerid)))
            {
                DB::query('UPDATE post SET likes=likes+1 WHERE ID=:postid', array(':postid'=>$postid));
                DB::query('INSERT INTO postlikes VALUES (null, :postid, :uid)',array(':postid'=>$postid, ':uid'=>$likerid));
            }
            else
            {
                echo ('already liked !');
            }
        }
        public static function display($uid, $user)
        {
            $allposts = DB::query('SELECT * FROM post WHERE user_id = :uid ORDER BY ID DESC', array(':uid'=>$uid));
            $posts ="";
            foreach($allposts as $p) 
            {
                $posts .= "<img src='".$p['postimg']."'>".htmlspecialchars($p['text'])."
                <form action='profile.php?username=$user&postid=".$p['ID']."' method='post'>
                <input type= 'submit' name='like' value='Like'>
                <span>".$p['likes']." Like</span>
                </form>
                <hr /></br />
                ";
            }
            return $posts ;
        }
    }
    ?>
</body>
</html>