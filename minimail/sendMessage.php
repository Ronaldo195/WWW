<?php
if(!isset($bypass1) || $bypass1 != "true"){
	include('../core.php');
	include('../includes/session.php');

	$messageid = isset($_POST['messageId']) ? $input->FilterText($_POST['messageId']) : '';
	$recipientids = isset($_POST['recipientIds']) ? $input->FilterText($_POST['recipientIds']) : '';
	$subject = isset($_POST['subject']) ? $input->Filtertext($_POST['subject']) : '';
	$body = isset($_POST['body']) ? $input->FIlterText($_POST['body']) : '';
}

$body = stripslashes(mysql_real_escape_string(htmlspecialchars($body)));

$ids = explode(",", $recipientids);
$numofids = count($ids);

if(isset($_POST['messageId'])){
	$sql = mysql_query("SELECT * FROM cms_minimail WHERE id = '".$messageid."'");
	$row = mysql_fetch_assoc($sql);
	if($row['conversationid'] == "0"){
		$sql = mysql_query("SELECT MAX(conversationid) FROM cms_minimail");
		$conid = mysql_result($sql, 0);
		$conid = $conid + 1;
		mysql_query("UPDATE cms_minimail SET conversationid = '".$conid."' WHERE id = '".$row['id']."'");
	} else {
		$conid = $row['conversationid'];
	}
	$subject = "Re: ".$row['subject'];
	$ids[0] = $row['senderid'];
} else {
	$conid = "0";
}

$elements = count($ids);
$elements = $elements - 1;
$i = -1;
while ($elements <> $i){
	$i++;
    mysql_query("INSERT INTO cms_minimail (senderid,to_id,subject,date,message,conversationid) VALUES ('".$user->row['id']."','".$ids[$i]."','".$subject."','".date('d-m-Y H:i:s')."','".$body."','".$conid."')");
}
$bypass = "true";
$page = "inbox";
$message = "Messaggio Inviato.";
if(!isset($bypass1) || $bypass1 != "true"){ include('loadMessage.php'); }
?>