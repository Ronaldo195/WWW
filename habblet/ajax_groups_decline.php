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

$refer = $input->FilterText($_SERVER['HTTP_REFERER']); $pos = strrpos($refer, "groups/"); if ($pos === false) { exit; }
$groupid = $input->FilterText($_POST['groupId']);

$targets = $input->FilterText($_POST['targetIds']);  
$targets = explode(",", $targets);

if(!is_numeric($groupid)){ exit; }

$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$valid = mysql_num_rows($check);
if($valid < 1){ exit; }
$groupdata = mysql_fetch_assoc($check);
if($groupdata['ownerid'] != $user->row['id'])
exit;

// Loop through all the members
foreach($targets as $member){
        header("X-Whatever: \"Test ".$member."\"");
        if(is_numeric($member)){
                $valid = $input->mysql_evaluate("SELECT COUNT(*) FROM users WHERE id = '".$member."' LIMIT 1");
                if($valid > 0){
                        mysql_query("DELETE FROM group_requests WHERE userid = '".$member."' AND groupid = '".$groupid."'");
                }
        }
}

echo "OK";

?>