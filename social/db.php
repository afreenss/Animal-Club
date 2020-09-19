<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    class DB {
        private static function connect() 
        {
            $pd = new PDO('mysql:host=127.0.0.1;dbname=AnimalClub;charset=utf8mb4', 'root', '');
            $pd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pd;
        }
        public static function query($query, $para = array()) 
        {
            $statement = self::connect()->prepare($query);
            $statement->execute($para);
            if (explode(' ', $query)[0] == 'SELECT')
            {
                $data = $statement-> fetchAll();
                return $data;
            }
        }
        
    }
    ?>
</body>
</html>

