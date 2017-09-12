<?php session_start(); ?> <!DOCTYPE html> 
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
if (filter_input(INPUT_POST, 'submit')){
	
	$n = filter_input(INPUT_POST, 'brugernavn')
		or die('Missing username parameter');
	$p = filter_input(INPUT_POST, 'password')
		or die('Missing password parameter');
	
    
	require_once('db_con.php');
	$sql = 'SELECT bruger_id, password_hash FROM bruger WHERE brugernavn=?';
	$stmt = $con->prepare($sql);
	$stmt->bind_param('s', $n);
	$stmt->execute();
	$stmt->bind_result($bid, $pwhash);
	
	while($stmt->fetch()) {}
	
	if (password_verify($p, $pwhash)){
		$_SESSION['bid'] = $bid;
            echo '<meta http-equiv="refresh" content="0; url=kalender.php?bruger_id=' . $bid . '" />';
    }
	else {
		echo 'Kunne ikke logge ind, brugernavn eller password er forkert';
	}
}                           
?>
    
    
    
    
    
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="login_container">
            <label>LOGIN</label><br><br>
            
            <input type="text" placeholder="Brugernavn" name="brugernavn" required><br><br>

            <input type="password" placeholder="Password" name="password" required><br><br>
        
            <button name="submit" type="submit" value="submit">LOGIN</button>
            
            <h3>Hvis du ikke har en bruger kan du oprette dig <a href="opret.php">her</a></h3>
        </div>
    </form>
    
    
    
    
</body>
</html>
