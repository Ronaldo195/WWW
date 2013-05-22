<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright © 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include('../core.php');
include('../includes/session.php');

$groupid = $input->FilterText($_POST['groupId']);

if(is_numeric($groupid) && $groupid > 0){

	$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
	$exists = mysql_num_rows($check);

	if($exists > 0){
		$check2 = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1") or die(mysql_errors());
		$already_member = mysql_num_rows($check2);

		if($already_member > 0){
			mysql_query("DELETE FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1") or die(mysql_error());
			if($input->GetUserGroup($user->row['id']) == $groupid)
			mysql_query("UPDATE user_stats SET groupid = '0' WHERE id = '".$user->row['id']."'"); 
			echo "<script type=\"text/javascript\">\nlocation.href = habboReqPath + \"".PATH."groups/".$groupid."\";\n</script>";
			echo "<p>Sei uscito con successo dal gruppo.</p>";
			echo "<p>Attendi mentre vieni reindirizzato..</p>";

		} else { exit; }

	} else {

		exit;

	}

}

?>