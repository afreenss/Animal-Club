<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tstyle.css">
    <title>My Feed - Animal Club</title>
</head>
<body>
    <?php
    //include('db.php');
    include('islogged.php');
    include('post.php');
    include('comment.php');
    $timeline = false ;
    //$uid = Login::isloggedin();

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

    if(isset($_POST['comment']))
    {
        Comment::createcomment($_POST['commenttext'], $_GET['postid'], $uid);
    }

    if (isset($_POST['searchbox'])) 
    {
        $tosearch = explode(" ", $_POST['searchbox']);
        if (count($tosearch) == 1) {
            $tosearch = str_split($tosearch[0], 2);
        }
        $whereclause = "";
        $paramsarray = array(':username'=>'%'.$_POST['searchbox'].'%');
        for ($i = 0; $i < count($tosearch); $i++) {
                $whereclause .= " OR username LIKE :u$i ";
                $paramsarray[":u$i"] = $tosearch[$i];
        }
        $users = DB::query('SELECT Users.username FROM Users WHERE Users.username LIKE :username '.$whereclause.'', $paramsarray);
        print_r($users);

        $whereclause = "";
        $paramsarray = array(':text'=>'%'.$_POST['searchbox'].'%');
        for ($i = 0; $i < count($tosearch); $i++) {
            if ($i % 2) {
            $whereclause .= " OR text LIKE :p$i ";
            $paramsarray[":p$i"] = $tosearch[$i];
            }
        }
        $posts = DB::query('SELECT post.text FROM post WHERE post.text LIKE :text '.$whereclause.'', $paramsarray);
        echo '<pre>';
        print_r($posts);
        echo '</pre>';
    } 
      
    ?>
    <!--<form action="index.php" method="post">
        <input type="text" name="searchbox" value="">
        <input type="submit" name="search" value="Search">
    </form>-->
    <div class="navbar">
    <a href="http://localhost:8080/Animal-Club/social/social.html" class="btn">Go Back</a>

    </div>
		<img id='stic2' style="position:fixed; left:0; bottom:0px" width="300px" src='images/p5.png' >
		<img id='stic3' style="position:fixed; right:0; top:10px" width="300px" src='images/giraffe.png'>
    <h1>MY FEED</h1>
    <?php
    $followposts = DB::query('SELECT post.ID, post.text, post.likes, post.postimg, Users.username
    FROM Users, post, followers 
    WHERE post.user_id = followers.user_id 
    AND Users.ID = post.user_id
    AND followers.follower_id = :uid
    ORDER BY post.likes DESC', array(':uid'=>$uid));

    foreach($followposts as $post)
    {
        echo "<div class='onepost'>".$post['text']."<br><br> ~ Posted by ".$post['username']."";
        echo("<form action='index.php?postid=".$post['ID']."' method='post'>
        <img src='".$post['postimg']."'><br>
        <input type= 'submit' name='like' value='Like'>
        <span>".$post['likes']." Like</span>
        </form>
        <form action = 'index.php?postid=".$post['ID']."' method = 'post'> 
        <textarea name='commenttext' cols='30' rows='2'></textarea>
        <input type='submit' name='comment' value='COMMENT'>
        <hr />
        </form>
        <h3>Comments</h3>
        ");
        Comment::displayComments($post['ID']);
        echo "<br /></div>";
    }
    ?>
</body>
</html>