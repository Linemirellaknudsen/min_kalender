<?php
	// Forbindelse til MySQL server med mysqli metoden

	//1. Konstanter til forbindelsesdata TIL LOCALHOST
	const HOSTNAME = 'linemirellaknudsen.dk.mysql'; 	//Servernavn
	const MYSQLUSER = 'linemirellaknudsen_dk_min_kalender'; 	  	// Super bruger (remote har særskilte databaser brugere)
	const MYSQLPASS = 'kalender';		// Bruger password
	const MYSQLDB = 'linemirellaknudsen_dk_min_kalender';		// Database navn

	// 2. Opretteforbindelsen vi mysqli objekt
	$con = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

		// Definere et character-set (utf 8) for forbindelsen
		$con->set_charset('utf8');
	
	//3. forbindelses-tjek
	/*if($con->connect_error){
		die($con->connect_error);
	}
	else {
		echo '<h2>JUHU jeg kan se databasen!</h2>';
	}*/


// Hvis filen kun indeholder PHP kan slut-tagget undlades
?>