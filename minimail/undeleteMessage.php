<?php
include('../core.php');
include('../includes/session.php');

$label = isset($_POST['label']) ? $input->FilterText($_POST['label']) : '';
$start = isset($_POST['start']) ? $input->FilterText($_POST['start']) : '';
$id = isset($_POST['messageId']) ? $input->FilterText($_POST['messageId']) : '';

mysql_query("UPDATE cms_minimail SET deleted = '0' WHERE id = '".$id."'");

$bypass = "true";
$page = "inbox";
$message = "Messaggio Salvato.";
include('loadMessage.php');
?>