<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesh check</title>
</head>
<body>
    <?php
    //include('db.php');
    include('islogged.php');
    include('post.php');
    $timeline = false ;

    if(Login::isloggedin())
    {
        $uid = Login::isloggedin();
        $timeline = true ;
        //echo 'logged in';
        //echo Login::isloggedin() ;
    }
    else
    {
        echo 'not logged in';
    }

    if(isset($_GET['postid']))
    {
        Post::likepost($_GET['postid'], $uid);
    }
    

    $followposts = DB::query('SELECT post.ID, post.text, post.likes, Users.username
    FROM Users, post, followers 
    WHERE post.user_id = followers.user_id 
    AND Users.ID = post.user_id
    AND followers.follower_id = 28
    ORDER BY post.likes DESC');

    foreach($followposts as $post)
    {
        echo $post['text']." ~ ".$post['username'];
        echo("<form action='index.php?postid=".$post['ID']."' method='post'>
        <input type= 'submit' name='like' value='Like'>
        <span>".$post['likes']." Like</span>
        </form>
        <form action = 'index.php' method = 'post'> 
        <textarea name='commenttext' id='' cols='30' rows='2'></textarea>
        <input type='submit' name='comment' value='COMMENT'>
        </form>
        <hr /> <br />");

    }
    ?>
</body>
</html>