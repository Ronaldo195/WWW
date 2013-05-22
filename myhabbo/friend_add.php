<?php
include('../core.php');

$id = $input->FilterText($_POST['accountId']);
$sql = mysql_query("SELECT * FROM messenger_friendships WHERE user_two_id = '".$id."' AND user_one_id = '".$user->row['id']."'");
$rows = mysql_num_rows($sql);
if($rows > 0){
$error = 1;
$message = "&egrave tuo Amico.";
}

$sql = mysql_query("SELECT * FROM messenger_friendships WHERE user_one_id = '".$user->row['id']."' AND user_two_id = '".$id."'");
$rows = mysql_num_rows($sql);
if($rows > 0){
$error = 1;
$message = "&egrave tuo Amico.";
}

$sql = mysql_query("SELECT * FROM messenger_requests WHERE from_id = '".$user->row['id']."' AND to_id = '".$id."'");
$rows = mysql_num_rows($sql);
if($rows > 0){
$error = 1;
$message = "Sei Stato Richiesto Da Questa Persona.";
}

$sql = mysql_query("SELECT * FROM messenger_requests WHERE to_id = '".$user->row['id']."' AND from_id = '".$id."'");
$rows = mysql_num_rows($sql);
if($rows > 0){
$error = 1;
$message = "Questa Persona ti ha gia richiesto come amico.";
}

if($id == $user->row['id']){
$error = 1;
$message = "Non Puoi Fare Amico te Stesso.";
}

if($error < 1){
$sql = mysql_query("SELECT MAX(id) FROM messenger_requests WHERE to_id = '".$id."'");
$requestid = mysql_result($sql, 0);
$requestid = $requestid + 1;

mysql_query("INSERT INTO messenger_requests (from_id,to_id,id) VALUES ('".$user->row['id']."','".$id."','".$requestid."')");

$message = "Richiesta inviata correttamente!";
} ?>
	Dialog.showInfoDialog("add-friend-messages",  
		"<?php echo $message; ?>",
		"OK");