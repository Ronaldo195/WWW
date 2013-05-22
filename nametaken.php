<?php
include("core.php");
$username = $input->EscapeString($_GET['habbo_name']);
$password = $input->EscapeString($_GET['password']);
$mail = $input->EscapeString($_GET['mail']);

if($username != ""){
	if($input->ValidName($username) && !$input->NameTaken($username) && strlen($username) > 2 && strlen($username) < 25)
		echo 1;
	else
		echo 0;
}else if($password != ""){
	if($input->ValidPass($password) && strlen($password) > 5)
		echo 1;
	else
		echo 0;
}else if($mail != ""){
	if($input->ValidMail($mail, true))
		echo 1;
	else
		echo 0;
}
?>