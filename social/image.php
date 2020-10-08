<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    class Image 
    {
        public static function upload($formname, $query, $params) 
        {
            $image = base64_encode(file_get_contents($_FILES[$formname]['tmp_name']));
            $options = array('http'=>array(
            'method'=>"POST",
            'header'=>"Authorization: Bearer 03c833a20f530d889f692df92ae74498b63bac99\n".
            "Content-Type: application/x-www-form-urlencoded",
            'content'=>$image
            ));

            $context = stream_context_create($options);

            $imgurURL = "https://api.imgur.com/3/image";

            if ($_FILES[$formname]['size'] > 10240000) 
            {
                die('Image too big, must be 10MB or less!');
            }

            $response = file_get_contents($imgurURL, false, $context);
            $response = json_decode($response);

            $preparams = array($formname=>$response->data->link);
            $params = $preparams + $params;

            DB::query($query, $params);

        }

    }
    ?>
</body>
</html>