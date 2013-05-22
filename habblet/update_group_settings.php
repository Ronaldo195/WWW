<?php
include('../core.php');
include('../includes/session.php');

$groupid = isset($_POST['groupId']) ? $input->FilterText($_POST['groupId']) : 0;
if(!is_numeric($groupid)){
	echo "Gruppo Non Salvato Con Successo\n\n<p>\n<a href=\"".PATH."me\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
	exit;
}
$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$valid = mysql_num_rows($check);

if($valid > 0){
	$groupdata = mysql_fetch_assoc($check);
	$ownerid = $groupdata['ownerid'];
} else {
	echo "Gruppo Non Salvato Con Successo\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
	exit;
}

if($ownerid != $user->row['id']){ 
	echo "Gruppo Non Salvato Con Successo\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
	exit;
}

$name = isset($_POST['name']) ? trim($input->FilterText($_POST['name'])) : '';
$description = isset($_POST['description']) ? trim($input->FilterText($_POST['description'])) : '';
$type = isset($_POST['type']) ? $input->FilterText($_POST['type']) : "open";
$forum_type = isset($_POST['forumType']) ? $input->FilterText($_POST['forumType']) : 0;
$topic_permission = isset($_POST['newTopicPermission']) ? $input->FilterText($_POST['newTopicPermission']) : 0;

if(is_numeric($_POST['roomId']))
$roomid = $input->FilterText($_POST['roomId']);
else
$roomid = 0;

if($type != "locked" AND $type != "open" AND $type != "closed"){
	echo "Gruppo Non Salvato Con Successo\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
	exit;
}

if(strlen($input->HoloText($name)) > 25){
	echo "Nome Troppo Lungo\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
} elseif(strlen($input->HoloText($description)) > 200){
	echo "Descrizione troppo lunga\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
} elseif(strlen($input->HoloText($name)) < 1){
	echo "Perfavore inserisci un Nome\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";	
} else {
	mysql_query("UPDATE groups SET name = '".$name."', `desc` = '".$description."', locked = '".$type."', roomid = '".$roomid."', forum = '".$forum_type."', topics = '".$topic_permission."' WHERE id = '".$groupid."' AND ownerid = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
	echo "Modifiche Salvate Con Successo\n\n<p>\n<a href=\"".PATH."groups/".$groupid."\" class=\"new-button\"><b>Ok</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
}
?>