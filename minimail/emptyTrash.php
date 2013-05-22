<?php
include('../core.php');
include('../includes/session.php');

mysql_query("DELETE FROM cms_minimail WHERE deleted = '1' AND to_id = '".$user->row['id']."'");
$bypass = "true";
$page = "trash";
$message = "Tutti i messaggi sono stati eliminati.";
include('loadMessage.php');
?>