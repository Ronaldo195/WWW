<?php
include('../core.php');
include('../includes/session.php');

echo $input->bbcode_format(trim(nl2br(stripslashes($input->FilterText($_POST['body'])))));
?>