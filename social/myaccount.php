<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    include('islogged.php');
    include('image.php');


    if(Login::isloggedin())
    {
        $uid = Login::isloggedin();
        //echo 'logged in';
        //echo Login::isloggedin() ;
    }
    else
    {
        die ('not logged in');
    }
    if (isset($_POST['uploadprofileimg'])) 
    {
        Image::upload('profileimg', "UPDATE Users SET profileimg = :profileimg WHERE ID=:uid", array(':uid'=>$uid));
    }
    ?>
    <h1>My Account</h1>
    <form action="myaccount.php" method="post" enctype="multipart/form-data">
        Upload a profile image:
        <input type="file" name="profileimg">
        <input type="submit" name="uploadprofileimg" value="Upload Image">
    </form>
</body>
</html>