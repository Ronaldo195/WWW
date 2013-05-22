<?php
$sql = mysql_query("SELECT * FROM cms_banners WHERE status = '1' ORDER BY id ASC");
while($row = mysql_fetch_assoc($sql))
	if((!isset($incolumn) || $incolumn == 0) && $row['pos'] == '0')
		echo $row['html'];
	elseif((isset($incolumn) && $incolumn == 1) && $row['pos'] == '1')
		echo $row['html'];
?>