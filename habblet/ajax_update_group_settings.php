<?php
include('../core.php');
include('../includes/session.php');

$groupid = $input->FilterText($_POST['groupId']);
if(!is_numeric($groupid)){ exit; }

$check = mysql_query("SELECT member_rank FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND member_rank > 1 LIMIT 1") or die(mysql_error());
$is_member = mysql_num_rows($check);

if($is_member > 0){
	$my_membership = mysql_fetch_assoc($check);
	$member_rank = $my_membership['member_rank'];
} else {
	echo "Modifica Del Gruppo Non Riuscita\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
	exit;
}

$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$valid = mysql_num_rows($check);

if($valid > 0){
	$groupdata = mysql_fetch_assoc($check);
	$ownerid = $groupdata['ownerid'];
} else {
	echo "Modifica Gruppo Non Riuscita\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
	exit;
}

if($ownerid !== $user->row['id']){ exit; }

$name = trim($input->FilterText($_POST['name']));
$description = trim($input->FilterText($_POST['description']));
$type = $input->FilterText($_POST['type']);
$pane = $input->FilterText($_POST['forumType']);
$topic = $input->FilterText($_POST['newTopicPermission']);

if($groupdata['type'] == "3" && $_POST['type'] !== "3"){ echo "L'utente non può modificare il tipo di gruppo, se è impostato su 3."; exit; } // you can't change the group type once you set it to 4, fool
if($type < 0 || $type > 3){ echo "Gruppo Invalido"; exit; } // this naughty user doesn't even deserve an settings update

if(strlen($input->HoloText($name)) > 25){
	echo "Nome Troppo Lungo\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
} elseif(strlen($input->HoloText($description)) > 255){
	echo "Descrizione Troppo Lunga\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
} elseif(strlen($input->HoloText($name)) < 1){
	echo "Perfavore Scrivi il nome\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>OK</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";	
} else {
	mysql_query("UPDATE groups SET name = '".$name."', description = '".$description."', type = '".$type."',pane='".$pane."',topics='".$topic."',roomid='".$_POST['roomId']."' WHERE id = '".$groupid."' AND ownerid = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
	echo "".$_POST['forum_type']." Modifica Del Gruppo Avvenuta con successo\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
}
?>