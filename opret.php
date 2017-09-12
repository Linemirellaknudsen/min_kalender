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
  
        if(filter_input(INPUT_POST, 'submit')){
            
            $n = filter_input(INPUT_POST, 'brugernavn')
                or die ('missing brugernavn parameter');
            
            $p = filter_input(INPUT_POST,'password')
                or die ('missing password parameter');
            
            $p = password_hash($p, PASSWORD_DEFAULT);
            
            
            require_once('db_con.php');
            $sql = 'INSERT INTO bruger(brugernavn, password_hash) VALUES (?, ?)';
            $stmt = $con->prepare($sql);
            $stmt -> bind_param('ss', $n, $p);
            $stmt -> execute();
            
            if ($stmt -> affected_rows > 0){
                echo '<div class="logud">Du er nu oprette som bruger</div>';
            }
            else {
                echo 'Kunne ikke oprette dig som bruger. <br>Prøv med et andet brugernavn';
            }
        }
    ?>
    
    
    
    
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="login_container">
            <label>OPRET</label><br><br>
            
            <input type="text" placeholder="Brugernavn" name="brugernavn" required><br><br>

            <input type="password" placeholder="Password" name="password" required><br><br>
        
            <button name="submit" type="submit" value="submit">OPRET</button>
            
            <h3>Hvis du allerede har en bruger kan du logge ind <a href="index.php">her</a></h3>
        </div>
    </form>

</body>
</html>