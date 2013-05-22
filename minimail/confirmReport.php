<?php
include('../core.php');
include('../includes/session.php');

$id = $input->FilterText($_POST['messageId']);

$sql = mysql_query("SELECT * FROM cms_minimail WHERE id = '".$id."' LIMIT 1");
$row = mysql_fetch_assoc($sql);

$error = 0;
if($row['senderid'] == $user->row['id']){
	$error = 1;
	$message = "Non Puoi Reportare il tuo Messaggio.";
}

if($error == 1){
?>
<ul class="error">
	<li><?php echo $message; ?></li>
</ul>

<p>
<a href="#" class="new-button cancel-report"><b>Annulla</b><i></i></a>
</p>
<?php
} else {
$sql = mysql_query("SELECT * FROM users WHERE id = '".$row['senderid']."' LIMIT 1");
$senderrow = mysql_fetch_assoc($sql);
?>
<p>
Sei sicuro di voler segnalare  <b><?php echo $row['subject']; ?></b> ai Moderatori?
</p>

<p>
<a href="#" class="new-button cancel-report"><b>Annulla</b><i></i></a>
<a href="#" class="new-button send-report"><b>Segnala</b><i></i></a>
</p>
<?php } ?>