<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tstyle.css">
    <title>Document</title>
</head>
<body>
    <?php
    class Comment
    {
        public static function createcomment($commenttext, $postId, $userId)
        {
            if (strlen($commenttext) > 200 || strlen($commenttext) < 1)
            {
                die('Post length must be between between 1 to 200 charecters !');
            }
            if(!DB::query('SELECT ID FROM post WHERE ID=:postid', array(':postid'=>$postId)))
            {
                echo "<script> alert('Invalid post ID ! ');</script>";
            }
            else
            {
                DB::query('INSERT INTO comments VALUES (null, :comment, :userid, NOW(), :postid)', array(':comment'=>$commenttext, ':userid'=>$userId, ':postid'=>$postId));
            }
            
        }

        public static function displayComments($postId) 
        {
            $comments = DB::query('SELECT comments.comment, Users.username FROM comments, Users WHERE post_id = :postid AND comments.user_id = Users.ID', array(':postid'=>$postId));
            foreach($comments as $comment) 
            {
                echo "<div class='comm'>".$comment['comment']." ~ ".$comment['username']."</div>";
            }
        }
    }
    ?>
</body>
</html>