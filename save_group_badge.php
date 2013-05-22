<?php 
include('core.php');
include('./includes/session.php');

$groupid = $input->FilterText($_POST['groupId']);
$badge = $input->FilterText($_POST['code']);

if(!is_numeric($groupid)){ echo "aa"; exit; }

$badge = str_replace("NaN", "", $badge); // NaN = invalid stuff

$check = mysql_query("SELECT member_rank FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1") or die(mysql_error());
$is_member = mysql_num_rows($check);

if($is_member > 0){
    $my_membership = mysql_fetch_assoc($check);
    $member_rank = $my_membership['member_rank'];
    if($member_rank < 2){ exit; }
} else {
    exit;
}

$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$valid = mysql_num_rows($check);
$row = mysql_fetch_assoc($check);
if($valid > 0){ $groupdata = mysql_fetch_assoc($check); } else { exit; }
if($badge != $row[badge]) {
if($row[badge] != b0503Xs09114s05013s05015) {
$image = "habbo-imaging/badge.php?badge=$row[badge].gif";
if(file_exists($image)) {
unlink($image);
}
} else {
if($site['memberships'] == "groups_memberships")
	mysql_query("UPDATE groups SET Image = '".$input->FilterText($badge)."' WHERE Id = '".$groupid."' LIMIT 1");
else
	mysql_query("UPDATE groups SET badge = '".$input->FilterText($badge)."' WHERE id = '".$groupid."' LIMIT 1");
	
header("Location: ".PATH."groups/".$groupid."&x=BadgeUpdated"); exit;
}
}
if($site['memberships'] == "groups_memberships")
	mysql_query("UPDATE groups SET Image = '".$input->FilterText($badge)."' WHERE Id = '".$groupid."' LIMIT 1");
else
	mysql_query("UPDATE groups SET badge = '".$input->FilterText($badge)."' WHERE id = '".$groupid."' LIMIT 1");
	
header("Location: ".PATH."groups/".$groupid."&x=BadgeUpdated"); exit;

?> 