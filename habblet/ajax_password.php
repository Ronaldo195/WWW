<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include('../core.php');

$password = $input->FilterText($_POST['password']);

if(strlen($password) < 6){
	echo "La Password deve essere almeno di 6 caratteri.";
} else {
	header("X-JSON: \"charOk\"");
	echo "La password e sicura!";
}

?>

