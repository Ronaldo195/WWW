<?php
include('./core.php');
include('./includes/session.php');

// simple check to avoid most direct access
$refer = $input->FilterText($_SERVER['HTTP_REFERER']);
$pos = strrpos($refer, "groups/");
if ($pos === false) { exit; }

$groupid = $input->FilterText($_POST['groupId']);
if(!is_numeric($groupid)){ exit; }

$errnew=0;
$check = mysql_query("SELECT member_rank FROM group_memberships WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND member_rank > 1 LIMIT 1") or $errnew=1;
if($errnew==1)
	$check = mysql_query("SELECT member_rank FROM groups_memberships WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND member_rank > 1 LIMIT 1") or die(mysql_error());
$is_member = mysql_num_rows($check);

if($is_member > 0){
    $my_membership = mysql_fetch_assoc($check);
    $member_rank = $my_membership['member_rank'];
} else {
    exit;
}

$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$valid = mysql_num_rows($check);

if($valid > 0){
    $groupdata = mysql_fetch_assoc($check);
    $ownerid = $groupdata['ownerid'];
} else {
    exit;
}

if($ownerid !== $user->row['id']){
    exit;
} elseif($ownerid == $user->row['id']){

error_reporting(0);
$image = "habbo-imaging/badge.php?badge=$groupdata[badge].gif";
if(file_exists($image)) {
unlink($image);
}
error_reporting(1);
    mysql_query("DELETE FROM groups WHERE id = '".$groupid."' LIMIT 1");
    mysql_query("DELETE FROM group_memberships WHERE groupid = '".$groupid."'") or die();
	mysql_query("DELETE FROM groups_memberships WHERE groupid = '".$groupid."'") or die();
    mysql_query("DELETE FROM cms_homes_group_linker WHERE groupid = '".$groupid."'");
    mysql_query("DELETE FROM cms_homes_stickers WHERE groupid = '".$groupid."'");
    echo "<p>\nGruppo Eliminato con successo.\n</p>\n\n<p>\n<a href=\"me.php\" class=\"new-button\"><b>OK</b><i></i></a>\n</p>\n\n<div class=\"clear\"></div>";
}

?>