<?php

mysql_connect($sqlhostname, $sqlusername, $sqlpassword)or die("<br><font size='2' face='Tahoma'><b>Errore del CMS:</b><br><em>Non Riesco a connettermi al database MySQL!</em></font>");
mysql_select_db($sqldb)or die("<br><font size='2' face='Tahoma'>Non connesso al Database MySQL</font>");

?>