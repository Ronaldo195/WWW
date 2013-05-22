<?php
include('../core.php');
include('../includes/session.php');

$groupid = $input->FilterText($_POST['groupId']);

if(is_numeric($groupid) && $groupid > 0){
	$newcr=0;
	$check = mysql_query("SELECT locked FROM groups WHERE id = '".$groupid."' LIMIT 1") or $newcr=1;
	if($newcr==1)
		$check = mysql_query("SELECT Typee FROM groups WHERE Id = '".$groupid."' LIMIT 1") or $newcr=1;
		
	$exists = mysql_num_rows($check);

	if($exists > 0){

		$check2 = mysql_query("SELECT groupid FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1") or die(mysql_errors());
		$already_member = mysql_num_rows($check2);
		
		$check3 = mysql_query("SELECT groupid FROM group_requests WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1") or die(mysql_errors());
		$already_request = mysql_num_rows($check3);

		
		$memberships = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."'");
		if($memberships >= 50){
			echo "<p>\nSei Gia membro di 50 gruppi.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a>\n</p>\n\n\n<div class=\"clear\"></div>";
			exit;			
		}

		if($already_member > 0){

			echo "<p>\nSei Gia Membro DI Questo Gruppo.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a>\n</p>\n\n\n<div class=\"clear\"></div>";
			exit;
		}
		elseif($already_request > 0){

			echo "<p>\nHai gia inviato la tua richiesta.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a>\n</p>\n\n\n<div class=\"clear\"></div>";
			exit;

		} else {

			$groupdata = mysql_fetch_assoc($check);
			
			if($newcr == 1){
				if($groupdata['Typee'] == 0)
					$type = "open";
				else if($groupdata['Typee'] == 1)
					$type = "locked";
				else if($groupdata['Typee'] == 2)
					$type = "closed";
			} else
				$type = $groupdata['locked'];
				
			$members = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE groupid = '".$groupid."'");

			if($type == "open"){ // we're free to join
					echo "<p>\nSei Entrato Nel Gruppo.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a>\n</p>\n\n\n<div class=\"clear\"></div>";
					mysql_query("INSERT INTO ".$site['memberships']." (userid,groupid) VALUES ('".$user->row['id']."','".$groupid."')") or die(mysql_error());
					exit;
			} elseif($type == "locked"){ // we need to request join
				echo "<p>\nRichiesta Inviata Con Successo.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a>\n</p>\n\n\n<div class=\"clear\"></div>";
				mysql_query("INSERT INTO group_requests (userid,groupid) VALUES ('".$user->row['id']."','".$groupid."')") or die(mysql_error());
				exit;
			} elseif($type == "closed"){ // noone can join
				echo "<p>\nNon Puoi Entrare nel gruppo e privato!\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" id=\"group-action-ok\"><b>OK</b><i></i></a>\n</p>\n\n\n<div class=\"clear\"></div>";
				exit;
			}

		}

	} else {

		echo "1";
		exit;

	}

}

?>