<?php


include('../core.php');
include('../includes/session.php');

$groupid = $input->FilterText($_POST['groupId']);
$page = isset($_POST['pageNumber']) ? $input->FilterText($_POST['pageNumber']) : 0;
$searchString = isset($_POST['searchString']) ? $input->FilterText($_POST['searchString']) : "";
$pending = isset($_POST['pending']) ? $input->FilterText($_POST['pending']) : false;

if($pending == "true"){ $pending = true; } else { $pending = false; }
if(!is_numeric($groupid)){ exit; }

$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$valid = mysql_num_rows($check);


if($valid > 0){ $groupdata = mysql_fetch_assoc($check); } else {exit; }

if($groupdata['ownerid'] != $user->row['id'])
exit;
$members = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE groupid = '".$groupid."'") or die(); // There have to be members; die if not
$members_pending = $input->mysql_evaluate("SELECT COUNT(*) FROM group_requests WHERE groupid = '".$groupid."'");

$pages = ceil($members / 12);
$pages_pending = ceil($members_pending / 12);

$page = isset($_POST['pageNumber']) ? $input->FilterText($_POST['pageNumber']) : "";

if($pending == true){
        $totalPagesMemberList = $pages_pending;
        $totalMembers = $members_pending;
        if($page < 1 || empty($page) || $page > $pages_pending){ $page = 1; }
} else {
        $totalPagesMemberList = $pages;
        $totalMembers = $members;
        if($page < 1 || empty($page) || $page > $pages){ $page = 1; }
}

$queryLimitMin = ($page * 12) - 12;
$queryLimit = $queryLimitMin . ",12";

header("X-JSON: {\"pending\":\"Membri in attesa  (" . $members_pending . ")\",\"members\":\"Membri (" . $members . ")\"}");

echo "<div id=\"group-memberlist-members-list\">

<form method=\"post\" action=\"#\" onsubmit=\"return false;\">
<ul class=\"habblet-list two-cols clearfix\">\n";

	$counter = 0;

	if($pending == true){
		if($members_pending < 1){
			echo "Nessun Membro in attesa ora.";
		} else {
			$lefts = 0;
			$rights = 0;
			$get_memberships = mysql_query("SELECT * FROM group_requests WHERE groupid = '".$groupid."'") or die(mysql_error());
			while($membership = mysql_fetch_assoc($get_memberships)){
				if(!is_numeric($membership['userid'])){ exit; }
				$get_userdata = mysql_query("SELECT * FROM users WHERE id = '".$membership['userid']."' LIMIT 1") or die(mysql_error());
				$valid_user = mysql_num_rows($get_userdata);
				if($valid_user > 0){
					$counter++;
					$userdata = mysql_fetch_assoc($get_userdata);
					if($input->IsEven($counter)){ $pos = "right"; $rights++; } else { $pos = "left"; $lefts++; }
					if($input->IsEven($lefts)){ $oddeven = "odd"; } else { $oddeven = "even"; }
					echo "<li class=\"".$oddeven." online ".$pos."\">
    	<div class=\"item\" style=\"padding-left: 5px; padding-bottom: 4px;\">
    		<div style=\"float: right; width: 16px; height: 16px; margin-top: 1px\">\n";
				if($membership['userid'] == $groupdata['ownerid']){ echo "<img src=\"".PATH."web-gallery/images/groups/owner_icon.gif\" width=\"15\" height=\"15\" alt=\"Owner\" title=\"Owner\" />\n"; }
			echo "</div>
				<input id=\"group-memberlist-m-".$userdata['id']."\" type=\"radio\""; if($membership['userid'] == $groupdata['ownerid'] || $membership['userid'] == $user->row['id']){ echo " disabled=\"disabled\""; } echo " style=\"margin: 0; padding: 0; vertical-align: middle\"  name=\"members\"/>
    	    <a class=\"home-page-link\" href=\"".PATH."home/".$userdata['username']."\"><span>".$userdata['username']."</span></a>
        </div>
    </li>";
				}
			}
		}
	} else {
		if($members < 1){
			echo "Nessun membri in attesa.";
		} else {
			$get_memberships = mysql_query("SELECT * FROM ".$site['memberships']." WHERE groupid = '".$groupid."' LIMIT ".$queryLimit."") or die(mysql_error());
			$lefts = 0;
			$rights = 0;
			while($membership = mysql_fetch_assoc($get_memberships)){
                                $tinyrank = "m";
				if(!is_numeric($membership['userid'])){ exit; }
				$get_userdata = mysql_query("SELECT * FROM users WHERE id = '".$membership['userid']."' LIMIT 1") or die(mysql_error());
				$valid_user = mysql_num_rows($get_userdata);
				if($valid_user > 0){
					$counter++;
					$userdata = mysql_fetch_assoc($get_userdata);
					if($input->IsEven($counter)){ $pos = "right"; $rights++; } else { $pos = "left"; $lefts++; }
					if($input->IsEven($lefts)){ $oddeven = "odd"; } else { $oddeven = "even"; }
					echo "<li class=\"".$oddeven." online ".$pos."\">
    	<div class=\"item\" style=\"padding-left: 5px; padding-bottom: 4px;\">
    		<div style=\"float: right; width: 16px; height: 16px; margin-top: 1px\">\n";
				if($membership['userid'] == $groupdata['ownerid']){ $tinyrank = "a"; echo "<img src=\"".PATH."web-gallery/images/groups/owner_icon.gif\" width=\"15\" height=\"15\" alt=\"Owner\" title=\"Dueño\" />\n"; }
			echo "</div>
				<input id=\"group-memberlist-".$tinyrank."-".$userdata['id']."\" type=\"radio\""; if($membership['userid'] == $groupdata['ownerid']){ echo " disabled=\"disabled\""; } echo " style=\"margin: 0; padding: 0; vertical-align: middle\" name=\"members\"/>
    	    <a class=\"home-page-link\" href=\"".PATH."home/".$userdata['username']."\"><span>".$userdata['username']."</span></a>
        </div>
    </li>";
				}
			}
		}
	}
        
        $results = @mysql_num_rows($get_memberships);
		
echo "</ul>

</form>



</div>
<div id=\"member-list-pagenumbers\">
".($queryLimitMin + 1)." - ".($results + $queryLimitMin)." / ".$totalMembers."
</div>
<div id=\"member-list-paging\" >";
if($page > 1){ echo "<a href=\"#\" class=\"avatar-list-paging-link\" id=\"memberlist-search-first\" >Primo</a>"; } else { echo "Primo"; }
echo " | ";
if($page > 1){ echo "<a href=\"#\" class=\"avatar-list-paging-link\" id=\"memberlist-search-previous\" >&lt;&lt;</a>"; } else { echo "&lt;&lt;"; }
echo " | ";
if($page < $totalPagesMemberList){ echo "<a href=\"#\" class=\"avatar-list-paging-link\" id=\"memberlist-search-next\" >&gt;&gt;</a>"; } else { echo "&gt;&gt;"; }
echo " | ";
if($page < $totalPagesMemberList){ echo "<a href=\"#\" class=\"avatar-list-paging-link\" id=\"memberlist-search-last\" >Ultimo</a>"; } else { echo "Ultimo"; }
echo "<input type=\"hidden\" id=\"pageNumberMemberList\" value=\"".$page."\"/>
<input type=\"hidden\" id=\"totalPagesMemberList\" value=\"".$totalPagesMemberList."\"/>
</div>";
?>