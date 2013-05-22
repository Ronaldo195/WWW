<?php
include('../core.php');
include('../includes/session.php');

$label = isset($_POST['label']) ? $input->FilterText($_POST['label']) : '';
$start = isset($_POST['start']) ? $input->FilterText($_POST['start']) : '';
$conversation = isset($_POST['conversationId']) ? $input->FilterText($_POST['conversationId']) : '';
$id = isset($_POST['messageId']) ? $input->FilterText($_POST['messageId']) : '';

$sql = mysql_query("SELECT * FROM cms_minimail WHERE id = '".$id."' LIMIT 1");
$row = mysql_fetch_assoc($sql);

if($row['deleted'] == "1"){
	mysql_query("DELETE FROM cms_minimail WHERE id = '".$id."' LIMIT 1");
	$bypass = "true";
	$page = "trash";
	$message = "Messaggio eliminato con Successo";
	include('loadMessage.php');
} else {
	mysql_query("UPDATE cms_minimail SET deleted = '1' WHERE id = '".$id."' LIMIT 1");
	$bypass = "true";
	$page = "inbox";
	$message = "Il Messaggio &egrave; stato Spostato Nel Cestino";
	include('loadMessage.php');
} ?>