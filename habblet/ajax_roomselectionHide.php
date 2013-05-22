<?php
include('../core.php');
//rivedere
mysql_query("UPDATE users SET noob='0' WHERE id='".$user->row['id']."' LIMIT 1") or die(mysql_error());
?>