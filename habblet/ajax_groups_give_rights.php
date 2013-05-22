<?php
include('../core.php');
include('../includes/session.php');

$refer = $input->FilterText($_SERVER['HTTP_REFERER']); $pos = strrpos($refer, "groups/"); if ($pos === false) { exit; }
$groupid = $input->FilterText($_POST['groupId']);

$targets = $input->FilterText($_POST['targetIds']);  
$targets = explode(",", $targets);

if(!is_numeric($groupid)){ exit; }

$check = mysql_query("SELECT member_rank FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND member_rank > 1 LIMIT 1") or die(mysql_error());
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
if($valid < 1){ exit; }

// Loop through all the members
foreach($targets as $member){
        if(is_numeric($member)){
                $valid = $input->mysql_evaluate("SELECT COUNT(*) FROM users WHERE id = '".$member."' LIMIT 1");
                if($valid > 0){
                        mysql_query("UPDATE ".$site['memberships']." SET member_rank = '2' WHERE userid = '".$member."' AND groupid = '".$groupid."' LIMIT 1") or die(mysql_error());
                }
        }
}

echo "OK"; exit;

?>