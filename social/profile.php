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
   include('post.php');
    $user ="";
    $isfollowing = False ;
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
            $uid = DB::query('SELECT ID FROM Users WHERE username=:username', array(':username'=>$_GET['username']))[0]['ID'];
            $fid = Login::isloggedin();

            if (isset($_POST['follow'])) 
            {
                if($uid!=$fid)
                {
                    if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:uid AND follower_id=:fid', array(':uid'=>$uid, ':fid'=>$fid))) 
                    {
                        DB::query('INSERT INTO followers VALUES (null, :uid, :fid)', array(':uid'=>$uid, ':fid'=>$fid));
                    } 
                    else 
                    {
                        echo 'Already following!';
                    }
                    $isfollowing = True ;
                }
            }
            if (isset($_POST['unfollow'])) 
            {
                if($uid!=$fid)
                {
                    if (DB::query('SELECT follower_id FROM followers WHERE user_id=:uid AND follower_id=:fid', array(':uid'=>$uid, ':fid'=>$fid)));
                    {
                        DB::query('DELETE FROM followers WHERE user_id=:uid AND follower_id=:fid', array(':uid'=>$uid, ':fid'=>$fid));
                    } 
                    $isfollowing = False ;
                }
            }
            if (DB::query('SELECT follower_id FROM followers WHERE user_id=:uid AND follower_id=:fid', array(':uid'=>$uid, ':fid'=>$fid))); 
                {
                    $isfollowing = True ;
                }
            if(isset($_POST['post']))
            {
                Post::createpost($_POST['posttext'], Login::isloggedin(), $uid);
            }
        }

        if(isset($_GET['postid']))
        {
            Post::likepost($_GET['postid'], $fid);
        }
        $posts = Post::display($uid, $user);

    }
    else
    {
        die('user not found ');
    }
    
    ?>
    <h1><?php echo $user;?>'s Profile</h1>
    <form action="profile.php?username=<?php echo $user; ?>" method="post">
    <?php 
    if($uid!=$fid)
    {
        if($isfollowing)
        {
            echo '<input type="submit" name="unfollow" value="Unfollow ! ">';
        }
        else
        {
            echo '<input type="submit" name="follow" value="Follow ! ">';
        }
    }
    ?>
    </form>
    <form action="profile.php?username=<?php echo $user; ?>" method="post">
    <textarea name="posttext" id="" cols="30" rows="10"></textarea>
    <input type="submit" name="post" value="POST">
    </form>
    
    <div class="posts">
        <?php echo $posts ;?>
    </div>
</body>
</html>