<?php
//	****** DATABASE SETTINGS ******
$sqlhostname = "localhost";
$sqlusername = "root";
$sqlpassword = "psw";
$sqldb = "db";

<<<<<<< HEAD
define("PATH", "http://localhost/"); //Inserire url dell'hotel
define("CLOSING", true); //Chiusura hotel dalle 02:00 alle 08:00
define("DATABASE", "phoenix"); //Non modificare, anche se usi la New Crypt
define("PANEL_KEY", "figoo"); //Codice segreto Amministrazione
=======
define("PATH", "http://localhost/"); //Url Hotel
define("CLOSING", true); //Chiusura hotel dalle 02:00 alle 08:00
define("DATABASE", "phoenix"); //Non cambiare, anche se si usa New Crypt
define("PANEL_KEY", "figoo"); //Codice segreto dell'Amministrazione
>>>>>>> Piccole modifiche al client

//  ****** APP ID & SECRET FACEBOOK *********
define("APP_ID", "FACEBOOK.APP.ID.QUI");
define("APP_SECRET", "FACEBOOK.SECRET.QUI");

//  ****** RPX API KEY (FOR GOOGLE) *********
define("RPX_API_KEY", "32df64f50df1d2493a28f239179008e48445e2be");

// ******* SITE SETTINGS *********
define("TWITTER_NAME", "habluxitalia");

//	****** BADGES ******
$cimagesurl = "http://images-eussl.habbo.com/c_images/";
$badgesurl = "album1584/";

//	****** EMAIL VERIFY ******
$email['verify'] = false;
$email['forced_verify'] = false;
$email['reward'] = 500;

date_default_timezone_set("Europe/Rome"); 
?>
