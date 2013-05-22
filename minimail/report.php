<?php
include('../core.php');
include('../includes/session.php');

$label = isset($_POST['label']) ? $input->FilterText($_POST['label']) : '';
$start = isset($_POST['start']) ? $input->FilterText($_POST['start']) : '';
$id = isset($_POST['messageId']) ? $input->FilterText($_POST['messageId']) : '';

$sql = mysql_query("SELECT NOW()");
$date = mysql_result($sql, 0);

$sql = mysql_query("SELECT * FROM cms_minimail WHERE id = '".$id."' LIMIT 1");
$row = mysql_fetch_assoc($sql);

mysql_query("INSERT INTO cms_reports (username,ip,message,date,picked_up,subject,roomid) VALUES ('".$user->row['username']."', '".$remote_ip."','Minimail: ".$row['message']."','".time()."','0','Segnalazione MiniMail: ".$row['subject']."','0')");
mysql_query("DELETE FROM messenger_friendships WHERE user_one_id = '".$user->row['id']."' AND user_two_id = '".$row['senderid']."' LIMIT 1");
mysql_query("DELETE FROM messenger_friendships WHERE user_two_id = '".$user->row['id']."' AND user_one_id = '".$row['senderid']."' LIMIT 1");
mysql_query("DELETE FROM cms_minimail WHERE id = '".$id."' LIMIT 1");

$bypass = "true";
$page = $label;
$startpage = $start;
$message = "Messaggio segnalato con successo e amico rimosso.";
include('loadMessage.php');
?>