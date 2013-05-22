<?php

require_once('../core.php');
require_once('../includes/session.php');

$key = $input->FilterText($_GET['key']);

switch($key){
	case "friends_all": $mode = 1; break;
	case "groups": $mode = 2; break;
	case "rooms": $mode = 3; break;
}

if(!isset($mode) || !isset($key)){ $mode = 1; }

switch($mode){
	case 1:
		$str = "friends";
		$error=0;
		$get_em = mysql_query("SELECT * FROM messenger_friendships WHERE user_one_id = '".$user->row['id']."'") or $error=1;
		if($error==1)
			$get_em = mysql_query("SELECT * FROM messenger_friendships WHERE (sender = '".$user->row['id']."' OR receiver = '".$user->row['id']."')");
		break;
	case 2:
		$str = "groups";
		$get_em = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."'") or die(mysql_error());
		break;
	case 3:
		$str = "rooms";
		$get_em = mysql_query("SELECT * FROM rooms WHERE owner = '".$user->row['username']."' ORDER BY caption ASC LIMIT 50") or die(mysql_error());
		break;
}

$results = mysql_num_rows($get_em);
$oddeven = 0;

	if($str == "groups" || $results > 0){
		if($mode == 1){
		echo "<ul id=\"online-friends\">\n";
			while ($row = mysql_fetch_assoc($get_em)){
			if($error==1){
				$one = $row['sender'];
				$two = $row['receiver'];
			} else {
				$one = $row['user_one_id'];
				$two = $row['user_two_id'];
			}
			if($one == $user->row['id']){
				$userdatasql = mysql_query("SELECT username FROM users WHERE id = '".$two."' LIMIT 1") or die(mysql_error());
			} else {
				$userdatasql = mysql_query("SELECT username FROM users WHERE id = '".$one."' LIMIT 1") or die(mysql_error());
			}
			$user_exists = mysql_num_rows($userdatasql);
				if($user_exists > 0){
					$userrow = mysql_fetch_assoc($userdatasql);
					$oddeven++;
					if($input->IsEven($oddeven)){ $even = "odd"; } else { $even = "even"; }
					printf("        <li class=\"%s\"><a href=\"".PATH."home/%s\">%s</a></li>\n",$even,$userrow['username'],$userrow['username']);
				}
			}
		echo "\n</ul>";
		} elseif($mode == 2){
		echo "<ul id=\"quickmenu-groups\">\n";

		$num = 0;
			
			if($site['memberships'] == "groups_memberships"){
				$mygroups = mysql_query("SELECT * FROM groups WHERE OwnerId = '".$user->row['id']."'");
				while($row = mysql_fetch_assoc($mygroups)){
					$num++;
					
					echo "<li class=\"";
					if($input->IsEven($num)){ echo "odd"; } else { echo "even"; }
					echo "\">";
					$fav = mysql_fetch_array(mysql_query("SELECT groupid FROM user_stats WHERE id = ".$user->row['id']));
					if($row['Id'] == $fav[0]){ echo "<div class=\"favourite-group\" title=\"Favorito\"></div>\n"; }
					echo "<div class=\"owned-group\" title=\"Proprietario\"></div>\n";
					echo "\n<a href=\"".PATH."groups/".$row['Id']."\">".$input->HoloText($row['Name'])."</a>\n</li>";
				}
			}
			
			while($row = mysql_fetch_assoc($get_em)){

				$group_id = $row['groupid'];

				$check = mysql_query("SELECT id,name,ownerid FROM groups WHERE id = '".$group_id."' LIMIT 1") or die(mysql_error());
				$groupdata = mysql_fetch_assoc($check);
				
				if($groupdata['ownerid'] != $user->row['id']){
				$num++;
				echo "<li class=\"";
				if($input->IsEven($num)){ echo "odd"; } else { echo "even"; }
				echo "\">";
				$fav = mysql_fetch_array(mysql_query("SELECT groupid FROM user_stats WHERE id = ".$user->row['id']));
				if($groupdata['id'] == $fav[0]){ echo "<div class=\"favourite-group\" title=\"Favorito\"></div>\n"; }
				if($row['member_rank'] > 1 && $groupdata['ownerid'] !== $user->row['id']){ echo "<div class=\"admin-group\" title=\"Admin\"></div>\n"; }
				if($groupdata['ownerid'] == $user->row['id'] && $row['member_rank'] > 1){ echo "<div class=\"owned-group\" title=\"Proprietario\"></div>\n"; }

				echo "\n<a href=\"".PATH."groups/".$group_id."\">".$input->HoloText($groupdata['name'])."</a>\n</li>";
				}
			}

		echo "\n</ul>";
		} elseif($mode == 3){
		echo "<ul id=\"quickmenu-rooms\">\n";
			while ($row = mysql_fetch_assoc($get_em)){
			$oddeven++;
			if($input->IsEven($oddeven)){ $even = "odd"; } else { $even = "even"; }
			printf("        <li class=\"%s\"><a href=\"client.php?forwardId=2&amp;roomId=%s\" onclick=\"roomForward(this, '%s', 'private'); return false;\" target=\"client\" id=\"room-navigation-link_%s\">%s</a></li>\n",$even,$row['id'],$row['id'],$row['id'],$row['caption']);
			}
		echo "\n</ul>";
		} else {
		echo "Invalito";
		}
	} else {
		echo "<ul id=\"quickmenu-" . $str . "\">\n	<li class=\"odd\">Nessun dato trovato </li>\n</ul>";
	}

	if($mode == "3"){
	echo "<p class=\"create-room\"><a href=\"client.php?shortcut=roomomatic\" onclick=\"HabboClient.openShortcut(this, 'roomomatic'); return false;\" target=\"client\">Crea Una Nuova Stanza</a></p>";
	} elseif($mode == "2"){
	echo $site['memberships'] != "groups_memberships" ? "<p class=\"create-group\"><a href=\"#\" onclick=\"GroupPurchase.open(); return false;\">Crea un Gruppo</a></p>" : "";
	} elseif($mode == "1"){
	echo "<p class=\"manage-friends\"><a href=\"".PATH."profile/friendsmanagement?tab=6\">Lista Amici</a></p>";
	}
?>