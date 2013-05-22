<?php
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
		mysql_query("UPDATE ".$site['memberships']." SET is_current = '0' WHERE userid = '".$user->row['id']."'");
			mysql_query("UPDATE ".$site['memberships']." SET is_current = '1' WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1");
			mysql_query("UPDATE user_stats SET groupid = '".$groupid."' WHERE id = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
		} else { exit; }

	} else {

		exit;

	}

}

?>