<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright � 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include('../core.php');
include('../includes/session.php');

$check = mysql_query("SELECT groupid,active FROM cms_homes_group_linker WHERE userid = '".$user->row['id']."' AND active = '1' LIMIT 1") or die(mysql_error());
$linked = mysql_num_rows($check);

if($linked > 0){
	$linkdata = mysql_fetch_assoc($check);
	$groupid = $input->FilterText($linkdata['groupid']);
}

	// Collect variables
	$newskin = $input->FilterText($_POST['skinId']);
	$widget = $input->FilterText($_POST['widgetId']);

	if($newskin == 1){ $skin = "defaultskin"; }
	else if($newskin == 2){ $skin = "speechbubbleskin"; }
	else if($newskin == 3){ $skin = "metalskin"; }
	else if($newskin == 4){ $skin = "noteitskin"; }
	else if($newskin == 5){ $skin = "notepadskin"; }
	else if($newskin == 6){ $skin = "goldenskin"; }
	else if($newskin == 7){ $skin = "hc_machineskin"; }
	else if($newskin == 8){ $skin = "hc_pillowskin"; }
	else if($newskin == 9 && $user->row['rank'] > 5){ $skin = "nakedskin"; }
	else { $skin = "defaultskin"; }

	if(is_numeric($widget)){
		if($linked > 0){
			$sql = mysql_query("SELECT * FROM cms_homes_stickers WHERE groupid = '".$groupid."' AND type = '2' AND id = '".$widget."' LIMIT 1") or die(mysql_error());
		} else {
			$sql = mysql_query("SELECT * FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND id = '".$widget."' LIMIT 1") or die(mysql_error());
		}
	} else {
		exit;
	}

	$num = mysql_num_rows($sql);

	if($num > 0){
		$dat = mysql_fetch_assoc($sql);
		if($linked > 0){
			mysql_query("UPDATE cms_homes_stickers SET skin = '".$skin."' WHERE groupid = '".$groupid."' AND type = '2' AND id = '".$widget."' LIMIT 1");
		} else {
			mysql_query("UPDATE cms_homes_stickers SET skin = '".$skin."' WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND id = '".$widget."' LIMIT 1");
		}
		header("X-JSON: {\"cssClass\":\"w_skin_" . $skin . "\",\"type\":\"widget\",\"id\":\"" . $widget . "\"}");
		echo "SUCCESS";
	} else {
		echo "ERROR";
	}

?>