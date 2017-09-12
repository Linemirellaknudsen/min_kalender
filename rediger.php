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
<?php require('menu.php');

    
    
    if ($cmd = filter_input(INPUT_POST, 'cmd')) {
        if($cmd == 'rediger_begivenhed') {
            $bid = filter_input(INPUT_POST, 'bruger_id', FILTER_VALIDATE_INT)
                or die('Missing bruger_id parameter');
            
            $beid = filter_input(INPUT_POST, 'begivenhed_id', FILTER_VALIDATE_INT)
                or die('Missing begivenhed_id parameter');
            
            $dato = filter_input(INPUT_POST, 'dato')
                or die('Missing dato parameter');
            
            $månede = filter_input(INPUT_POST, 'månede')
                or die('Missing månede parameter');
            
            $kategori = filter_input(INPUT_POST, 'kategori')
                or die('Missing kategori parameter');
            
            $tekst = filter_input(INPUT_POST, 'tekst')
                or die('Missing tekst parameter');
            
            require_once('db_con.php');
            $sql = 'UPDATE begivenhed 
                    SET  bruger_id=?, dato=?, månede=?, billede_id=?, tekst=?  
                    WHERE begivenhed_id=?';
            $stmt = $con -> prepare($sql);
            $stmt -> bind_param('iisssi', $bid, $dato, $månede, $kategori, $tekst, $beid);
            $stmt -> execute();
        
            if($stmt -> affected_rows > 0) {
                echo '<meta http-equiv="refresh" content="0; url=kalender.php?bruger_id=' . $bid . '" />';
            } 
            else {
                echo '<div class="tekst2"><h1>Error</h1></div>';
            }
            
        }
    }
    
    
/*if(empty($beid)){    
    $beid = filter_input(INPUT_GET, 'begivenhed_id', FILTER_VALIDATE_INT)
        or die ('Missing begivenhed parameter');
}*/
  
    


$beid = filter_input(INPUT_GET, 'begivenhed_id', FILTER_VALIDATE_INT);

    
    
    
    
require_once('db_con.php');
    $sql = 'SELECT bruger_id FROM begivenhed WHERE begivenhed_id=?';
    $stmt = $con -> prepare($sql);
    $stmt -> bind_param('i', $beid);
    $stmt -> execute();
    $stmt -> bind_result($bid);
        while($stmt -> fetch()) {}
    
    
    

 
?>
    
    <div class="opret">
            <h4>Rediger begivenhed</h4><br>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                   
                <input name="dato" type="number" min="1" max="31" placeholder="Dato" required>
                
                <select name="månede">
                    <option disabled selected>Månede</option>
                    <option value="Januar">Januar</option>
                    <option value="Februar">Februar</option>
                    <option value="Marts">Marts</option>
                    <option value="April">April</option>
                    <option value="Maj">Maj</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select><br>
                    
                <select name="kategori">
                    <option disabled selected>Kategori</option>
                    <option value="Fødselsdag">Fødselsdag</option>
                    <option value="Arbejde">Arbejde</option>
                    <option value="Fritid">Fritid</option>
                    <option value="Mærkedag">Mærkedag</option>
                </select><br>
                 
                <textarea rows="6" cols="45" name="tekst" placeholder="Beskrivelse" required></textarea><br>
                    
                <input type="hidden" name="bruger_id" value="<?=$bid?>">
                    
                <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                
                <button name="cmd" value="rediger_begivenhed" type="submit">OPRET</button>
                    
                </form>
        </div>
    
    <div class="login">Gå tilbage til <a href="kalender.php?bruger_id=<?=$bid?>">DIN KALENDER</a></div>
</body>
</html>
