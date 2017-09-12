<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Sedgwick+Ave" rel="stylesheet">
    <title>Min Kalender</title>
</head>

<body>
    <?php require('menu.php'); ?>
    
        
    <?php
    session_start();

    session_unset();

    session_destroy();

    echo '<div class="logud"><h3>Du er nu logget ud</h3></div>';

    exit();       
?>
</body>
</html>