<?php
include('../core.php');

$entryid = $input->FilterText($_POST['entryId']);
$widgetid = $input->FilterText($_POST['widgetId']);

mysql_query("DELETE FROM cms_guestbook WHERE id = '".$entryid."' LIMIT 1");

?>