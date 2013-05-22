<?php
include('../core.php');

$allow_guests = false;


$id = $input->FilterText($_POST['accountId']);
$erroro=0;

$sql = mysql_query("SELECT * FROM messenger_friendships WHERE user_one_id = '".$user->row['id']."' AND user_two_id = '".$id."'") or $erroro=1;
if($erroro==1)
	$sql = mysql_query("SELECT * FROM messenger_friendships WHERE (sender = '".$user->row['id']."' AND receiver = '".$id."') OR (receiver = '".$user->row['id']."' AND sender = '".$id."')");
$rows = mysql_num_rows($sql);
$error = 0;
if($rows <> 0){
$error = 1;
$message = "Questa persona &egrave; già tua amica.";
}

if($erroro==1){
	$sql = mysql_query("SELECT * FROM messenger_requests WHERE sender = '".$user->row['id']."' AND receiver = '".$id."'");
} else
	$sql = mysql_query("SELECT * FROM messenger_requests WHERE from_id = '".$user->row['id']."' AND to_id = '".$id."'");
$rows = mysql_num_rows($sql);
if($rows <> 0){
$error = 1;
$message = "Hai gi&agrave; una richiesta di amicizia in sospeso.";
}
if($erroro==1)
	$sql = mysql_query("SELECT * FROM messenger_requests WHERE receiver = '".$user->row['id']."' AND sender = '".$id."'");
else	
	$sql = mysql_query("SELECT * FROM messenger_requests WHERE to_id = '".$user->row['id']."' AND from_id = '".$id."'");
$rows = mysql_num_rows($sql);
if($rows <> 0){
$error = 1;
$message = "Hai gi&agrave; una richiesta di amicizia in sospeso.";
}

if($id == $user->row['id']){
$error = 1;
$message = "Non puoi chiedere a te stesso di essere tuo amico!";
}

if($error <> 1){
if($erroro==1)
	mysql_query("INSERT INTO messenger_requests (sender,receiver) VALUES ('".$user->row['id']."','".$id."')");
else {
	$sql = mysql_query("SELECT MAX(id) FROM messenger_requests");
	$requestid = mysql_result($sql, 0);
	$requestid = $requestid + 1;
	mysql_query("INSERT INTO messenger_requests (from_id,to_id,id) VALUES ('".$user->row['id']."','".$id."','".$requestid."')");
}
$message = "Richiesta inviata correttamente.";
} ?>

<div id="avatar-habblet-dialog-body" class="topdialog-body"><ul>
	<li><?php echo $message; ?></li>
</ul>


<p>
<a href="#" class="new-button done"><b>Ok!</b><i></i></a>
</p></div>