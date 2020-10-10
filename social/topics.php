<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>topics</title>
</head>
<body>
    <?php
    //include('db.php');
    include('islogged.php');
    include('post.php');
    include('image.php');

    if(isset($_GET['topic']))
    {
        if (DB::query("SELECT topics FROM post WHERE FIND_IN_SET(:topic, topics)", array(':topic'=>$_GET['topic']))) 
        {
            $posts= DB::query("SELECT * FROM post WHERE FIND_IN_SET(:topic, topics)", array(':topic'=>$_GET['topic']));
            foreach ($posts as $po)
            {
                echo($po['text']).'</br>';

            }

        }
    }
    ?>
</body>
</html>