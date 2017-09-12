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
    <?php require('menu.php'); 
    
    
    $bid = filter_input(INPUT_GET, 'bruger_id', FILTER_VALIDATE_INT);
    
    
    
    
    if($cmd = filter_input(INPUT_POST, 'cmd')) {
        
        if ($cmd == 'opret_begivenhed') {
            $dato = filter_input(INPUT_POST, 'dato', FILTER_VALIDATE_INT)
                or die('missing dato parameter');
            $månede = filter_input(INPUT_POST, 'månede')
                or die('missing månede parameter');
            $tekst = filter_input(INPUT_POST, 'tekst')
                or die('missing tekst parameter');
            $kategori = filter_input(INPUT_POST, 'kategori')
                or die('billede_id parameter');
            $bid = filter_input(INPUT_POST, 'bruger_id', FILTER_VALIDATE_INT)
                or die('missing bruger_id parameter');
            
            require_once('db_con.php');
            $sql = 'INSERT INTO begivenhed (dato, månede, tekst, billede_id, bruger_id) VALUES (?, ?, ?, ?, ?)';
            $stmt = $con -> prepare($sql);
            $stmt -> bind_param('isssi', $dato, $månede, $tekst, $kategori, $bid);
            $stmt -> execute();
            
            if ($stmt->affected_rows > 0) {
                echo '<meta http-equiv="refresh" content="0; url=kalender.php?bruger_id=' . $bid . '" />';
            }
            else {
                echo $stmt->error;
            }
        }
        
        
        
        elseif ($cmd == 'slet_begivenhed') {
            $beid = filter_input(INPUT_POST, 'begivenhed_id', FILTER_VALIDATE_INT)
                or die('missing begivenhed_id parameter');
            
            require_once('db_con.php');
            $sql = 'DELETE FROM begivenhed WHERE begivenhed_id=?';
            $stmt = $con -> prepare($sql);
            $stmt -> bind_param('i', $beid);
            $stmt -> execute();
            
            if ($stmt->affected_rows > 0) {
                echo '<script>history.go(-1);</script>';
            }
            else {
                echo $stmt->error;
            }
        }
    }
?>
    
    
    
    

    
    
    <?php
	if(empty($_SESSION['bid'])) {
        echo '<div class="login"><h3>Du skal være logget ind for at se indeholdet.<br> Hvis du ikke har en bruger kan du oprette en lige <a href="opret.php">HER</a></div>';
	}
	else {
?>  
        <div class="wrapper">
            <div class="opret">
                <h4>Opret begivenhed</h4><br>
                
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
                
                <button name="cmd" value="opret_begivenhed" type="submit">OPRET</button>
                    
                </form>
            </div>
            

            
            
            
            
            
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "Januar"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="din_kalender"><h2>DIN KALENDER</h2></div>
        <div class="manede"><h2>JANUAR</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
            
            
            

            
            
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "Februar"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>FEBRUAR</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
            
            
            
            
            
            
            
        
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "Marts"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>MARTS</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
            
            
            
            
            
            
            
            
            
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "April"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>APRIL</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
            
            
            
            
            
            
            
            
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "Maj"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>MAJ</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
            
            
            
            
            
            
            
            
            
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "Juni"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>JUNI</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
            
            
            
            
            
            
            
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "Juli"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>JULI</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
            
            
            
            
            
            
            
            
            
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "August"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>AUGUST</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
            
            
            
            
            
            
            
            
            
<?php
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "September"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>SEPTEMBER</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }

  
            
            
            
            
    
            
            
            
  
            require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "Oktober"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
            
            <div class="manede"><h2>OKTOBER</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }

        
        
        
        
 
          
          

        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "November"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>NOVEMBER</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
        
        
        
        
        
        
        
        require_once('db_con.php');
        $sql = 'SELECT begivenhed.begivenhed_id, begivenhed.dato,                           begivenhed.månede, begivenhed.tekst, billede.billede
                FROM bruger, begivenhed, billede
                WHERE billede.billede_id = begivenhed.billede_id
                AND bruger.bruger_id = begivenhed.bruger_id
                AND månede = "December"
                AND bruger.bruger_id = ?
                ORDER BY dato asc';
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $stmt->bind_result($beid, $dato, $månede, $tekst, $billede);
?>
        <div class="manede"><h2>December</h2></div>
<?php
        while($stmt->fetch()) {
?>
            <div class="begivenhed_boks">
                <div class="begivenheds_billede"><img src="<?=$billede?>"></div>
                <div class="datoen"><p><?=$dato?> . <?=$månede?></p></div>
                <div class="streg">-</div>
                <div class="teksten"><p><?=$tekst?></p></div>
                
                <div class="slet_rediger">
                    <div class="slet"><form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="begivenhed_id" value="<?=$beid?>">
                        <button type="submit" name="cmd" value="slet_begivenhed">Slet</button>
                    </form></div>
                    <div class="rediger">
                        <a href="rediger.php?begivenhed_id=<?=$beid?>"><button>Rediger</button></a>
                    </div>
                </div>
            </div>
    
<?php
        }
?>
        </div>
<?php
	}
?>
</body>
</html>