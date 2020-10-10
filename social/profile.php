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
   include('image.php');

    $user ="";
    $isfollowing = false ;
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
                        echo "<script> alert('Already following ! ');</script>";
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
                if($_FILES['postimg']['size']==0)
                {
                    Post::createpost($_POST['posttext'], Login::isloggedin(), $uid);
                }
                else
                {
                    $postid = Post::createimgpost($_POST['posttext'], Login::isloggedin(), $uid);
                    Image::upload('postimg','UPDATE post SET postimg=:postimg WHERE ID=:postid', array(':postid'=>$postid));

                }
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
        if($isfollowing == true)
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

    <?php
    if(Login::isloggedin()==$uid)
    {
        echo("
        <form action=profile.php?username=$user method='post' enctype='multipart/form-data'>
            <textarea name='posttext' cols='30' rows='10'></textarea>
            <br>
            Upload an image:
            <input type='file' name='postimg'>
            <input type='submit' name='post' value='POST'>
        </form>
        ");
    }
    ?>
    <div class="posts">
        <?php 
        echo $posts ;
        ?>
    </div>
</body>
</html>