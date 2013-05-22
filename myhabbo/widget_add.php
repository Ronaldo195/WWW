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

require_once('../core.php');
require_once('../includes/session.php');

$check = mysql_query("SELECT groupid,active FROM cms_homes_group_linker WHERE userid = '".$user->row['id']."' AND active = '1' LIMIT 1") or die(mysql_error());
$linked = mysql_num_rows($check);
if($linked > 0){
    $link_info = mysql_fetch_assoc($check);
    $groupid = $link_info['groupid'];
    if(!is_numeric($groupid)){ exit; }
    $check = mysql_query("SELECT ownerid FROM groups WHERE id = '".$groupid."' LIMIT 1");
    $exists = mysql_num_rows($check);
        if($exists < 1){
            $linked = 0;
            $groupid = -1;
        } else {
            $tmp = mysql_fetch_assoc($check);
            $ownerid = $tmp['ownerid'];
            $linked = 1;
        }
}

$widgetid = $input->FilterText($_POST['widgetId']);
$zindex = $input->FilterText($_POST['zindex']); if(!is_numeric($zindex)){ exit; }
$privileged = $input->FilterText($_POST['privileged']); // dunno what it is, but it's always either true or false

if(!empty($widgetid)){
    if($widgetid == "1"){ exit; } // User Profile / Group Profile; system default; can't be placed
    elseif($widgetid == "2" && $linked < 1){ $widget = "2"; }
    elseif($widgetid == "3" && $linked > 0){ $widget = "3"; }
    elseif($widgetid == "3" && $linked < 1){ $widget = "3"; }
    elseif($widgetid == "4" && $linked < 1){ $widget = "4"; }
    elseif($widgetid == "4" && $linked > 0){ $widget = "4"; }
    elseif($widgetid == "5" && $linked < 1){ $widget = "5"; }
    elseif($widgetid == "5" && $linked > 0){ $widget = "5"; }
    elseif($widgetid == "6" && $linked < 1){ $widget = "6"; }
    elseif($widgetid == "7" && $linked < 1){ $widget = "7"; }
    elseif($widgetid == "8" && $linked < 1){ $widget = "8"; }
	elseif($widgetid == "9" && $linked < 1){ $widget = "9"; }
    else { exit; }
	
	if($widget == "9" && $linked < 1){
		mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,skin,x,y,z) VALUES ('".$user->row['id']."','-1','2','9','defaultskin','20','20','".$zindex."')") or die(mysql_error());
		$ret_sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $ret_row = mysql_fetch_assoc($ret_sql);
        $saved_id = $ret_row['id'];
	?>
	
	<div class="movable widget RatingWidget" id="widget-<?php echo $saved_id; ?>" style=" left: 20px; top: 20px; z-index: <?php echo $zindex; ?>;">
<div class="w_skin_defaultskin">
	<div class="widget-corner" id="widget-<?php echo $saved_id; ?>-handle">
		<div class="widget-headline"><h3>
<img src="<?php echo PATH; ?>web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $saved_id; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $saved_id; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $saved_id; ?>, "widget", "widget-<?php echo $saved_id; ?>-edit"); }, false);
</script>
		<span class="header-left">&nbsp;</span><span class="header-middle">Il mio voto</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
	<div id="rating-main">
	<?php
		$bypass = true;
		$ownerid = $user->row['id'];
		$my_id = $user->row['id'];
		$rate = 0;
		require_once('rating_rate.php');
	?>
	</div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
	<?php
    }elseif($widget == "2" && $linked < 1){

        mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,skin,x,y,z) VALUES ('".$user->row['id']."','-1','2','2','defaultskin','20','20','".$zindex."')") or die(mysql_error());

        $ret_sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $ret_row = mysql_fetch_assoc($ret_sql);
        $saved_id = $ret_row['id'];

        $edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"widget-" . $saved_id . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"widget-".$saved_id."-edit\", \"click\", function(e) { openEditMenu(e, ".$saved_id.", \"widget\", \"widget-".$saved_id."-edit\"); }, false);
</script>\n";

        $groups = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' LIMIT 1");

			echo "<div class=\"movable widget GroupsWidget\" id=\"widget-".$saved_id."\" style=\" left: 20px; top: 20px; z-index: ".$zindex.";\">
<div class=\"w_skin_defaultskin\">
	<div class=\"widget-corner\" id=\"widget-".$saved_id."-handle\">
		<div class=\"widget-headline\"><h3><span class=\"header-left\">&nbsp;</span><span class=\"header-middle\">Miei Gruppi (<span id=\"groups-list-size\">".$groups."</span>)</span><span class=\"header-right\">".$edit."</span></h3>
		</div>
	</div>
	<div class=\"widget-body\">
		<div class=\"widget-content\">

<div class=\"groups-list-container\">
<ul class=\"groups-list\">";

$get_groups = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."'") or die(mysql_error());
while($membership_row = mysql_fetch_assoc($get_groups)){
	$get_groupdata = mysql_query("SELECT * FROM groups WHERE id = '".$membership_row['groupid']."' LIMIT 1") or die(mysql_error());
	$grouprow = mysql_fetch_assoc($get_groupdata);
	
	if($site['memberships'] == "groups_memberships"){
		$grouprow['id'] = $grouprow['Id'];
		$grouprow['name'] = $grouprow['Name'];
		$grouprow['ownerid'] = $grouprow['OwnerId'];
		$grouprow['created'] = $grouprow['DateCreated'];
	} else {
		$grouprow['created'] = date('d-m-Y',$grouprow['created']);
	}
	echo "	<li title=\"".$grouprow['name']."\" id=\"groups-list-".$saved_id."-".$grouprow['id']."\">
		<div class=\"groups-list-icon\"><a href=\"".PATH."groups/".$grouprow['id']."\"><img src=\"".PATH."habbo-imaging/badge.php?badge=".$grouprow['badge']."\"/></a></div>
		<div class=\"groups-list-open\"></div>
		<h4>
		<a href=\"".PATH."groups/".$membership_row['groupid']."\">".$grouprow['name']."</a>
		</h4>
		<p>
		Gruppo creato:<br />";
		
		if($membership_row['member_rank'] > 1 && $grouprow['ownerid'] !== $user->row['id']){ echo "<div class=\"admin-group\" title=\"Admin\"></div>\n"; }
		if($grouprow['ownerid'] == $user->row['id'] && $membership_row['member_rank'] > 1){ echo "<div class=\"owned-group\" title=\"Proprietario\"></div>\n"; }
		echo "<b>".$grouprow['created']."</b>
		</p>
		<div class=\"clear\"></div>
	</li>";

}

echo "</ul></div>

<div class=\"groups-list-loading\"><div><a href=\"#\" class=\"groups-loading-close\"></a></div><div class=\"clear\"></div><p style=\"text-align:center\"><img src=\"".PATH."web-gallery/images/progress_bubbles.gif\" alt=\"\" width=\"29\" height=\"6\" /></p></div>
<div class=\"groups-list-info\"></div>

		<div class=\"clear\"></div>
		</div>
	</div>
</div>
</div>

<script type=\"text/javascript\">
document.observe(\"dom:loaded\", function() {
	new GroupsWidget('".$user->row['id']."', '".$saved_id."');
});
</script>";
    } elseif($widget == "3" && $linked > 0){

        mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,skin,x,y,z) VALUES ('".$user->row['id']."','".$groupid."','2','3','defaultskin','20','20','".$zindex."')") or die(mysql_error());

        $ret_sql = mysql_query("SELECT * FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND type = '2' AND subtype = '3' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $ret_row = mysql_fetch_assoc($ret_sql);
        $saved_id = $ret_row['id'];

        $edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"widget-" . $saved_id . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"widget-".$saved_id."-edit\", \"click\", function(e) { openEditMenu(e, ".$saved_id.", \"widget\", \"widget-".$saved_id."-edit\"); }, false);
</script>\n";

        $members = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE groupid = '".$groupid."'");

        echo "<div class=\"movable widget MemberWidget\" id=\"widget-".$saved_id."\" style=\" left: 20px; top: 20px; z-index: ".$zindex.";\">
<div class=\"w_skin_defaultskin\">
	<div class=\"widget-corner\" id=\"widget-".$saved_id."-handle\">
		<div class=\"widget-headline\"><h3><span class=\"header-left\">&nbsp;</span><span class=\"header-middle\">Membri Di Questo Gruppo (<span id=\"avatar-list-size\">".$members."</span>)</span><span class=\"header-right\">".$edit."</span></h3>
		</div>
	</div>
	<div class=\"widget-body\">
		<div class=\"widget-content\">

<div id=\"avatar-list-search\">
<input type=\"text\" style=\"float:left;\" id=\"avatarlist-search-string\"/>
<a class=\"new-button\" style=\"float:left;\" id=\"avatarlist-search-button\"><b>Search</b><i></i></a>
</div>
<br clear=\"all\"/>

<div id=\"avatarlist-content\">\n";

$bypass = true;
$widgetid = $saved_id;
include('../myhabbo/avatarlist_membersearchpaging.php');

echo "<script type=\"text/javascript\">
document.observe(\"dom:loaded\", function() {
	window.widget = new MemberWidget('".$groupid."', '0');
});
</script>

</div>
		<div class=\"clear\"></div>
		</div>
	</div>
</div>
</div>";
    } elseif($widget == "3" && $linked < 1){ 
	mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,skin,x,y,z) VALUES ('".$user->row['id']."','-1','2','3','defaultskin','20','20','".$zindex."')") or die(mysql_error());

        $ret_sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $ret_row = mysql_fetch_assoc($ret_sql);
        $saved_id = $ret_row['id'];

        $edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"widget-" . $saved_id . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"widget-".$saved_id."-edit\", \"click\", function(e) { openEditMenu(e, ".$saved_id.", \"widget\", \"widget-".$saved_id."-edit\"); }, false);
</script>\n";
	?>
			<div class="movable widget RoomsWidget" id="widget-<?php echo $saved_id ?>" style=" left: 20px; top: 20px; z-index: <?php echo $zindex; ?>;">
<div class="w_skin_defaultskin">
	<div class="widget-corner" id="widget-<?php echo $saved_id ?>-handle">
		<div class="widget-headline"><h3>
<?php echo $edit; ?>
</script>
		<span class="header-left">&nbsp;</span><span class="header-middle">Mie Stanze</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
		<?php 			
		$roomsql = mysql_query("SELECT * FROM rooms WHERE owner = '".$user->row['username']."'");
		$count = mysql_num_rows($roomsql);
		if($count <> 0){ 
		?>

<div id="room_wrapper">
<table border="0" cellpadding="0" cellspacing="0">
			<?php 
			$i = 0;
			while ($roomrow = mysql_fetch_assoc($roomsql)) {
				$i++;
				if($count == $i){
					$asdf = " ";
				} else {
					$asdf = "class=\"dotted-line\"";
				}
				if($roomrow['state'] == 2){
					$qwer = "password";
					$zxcv = "Protetto da password";
				} elseif($roomrow['state'] == 0){
					$qwer = "open";
					$zxcv = "Entra in Stanza";
				} elseif($roomrow['state'] == 1){
					$qwer = "locked";
					$zxcv = "Chiuso";
				}
				printf("<tr>
<td valign=\"top\" $asdf>
		<div class=\"room_image\">
				<img src=\"".PATH."web-gallery/images/myhabbo/rooms/room_icon_%s.gif\" alt=\"\" align=\"middle\"/>
		</div>
</td>
<td $asdf>
        	<div class=\"room_info\">
        		<div class=\"room_name\">
        			%s
        		</div>
					<img id=\"room-%s-report\" class=\"report-button report-r\"
						alt=\"report\"
						src=\"".PATH."web-gallery/images/myhabbo/buttons/report_button.gif\"
						style=\"display: none;\" />
				<div class=\"clear\"></div>
        		<div>%s
        		</div>
					<a href=\"/client.php?forwardId=2&amp;roomId=%s\"
					   target=\"\"
					   id=\"room-navigation-link_%s\"
					   onclick=\"HabboClient.roomForward(this, '%s', 'private', true); return false;\">
					 %s
					 </a>
        	</div>
		<br class=\"clear\" />

</td>
</tr>",$qwer, $roomrow['caption'], $roomrow['id'], $roomrow['description'], $roomrow['id'], $roomrow['id'], $roomrow['id'], $zxcv);
			} ?>
		<br class="clear" />

</td>
</tr>
</table>
</div> <?php
		} else {
			echo "Tu Non Hai Stanze";
		} ?>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php 
    } elseif($widget == "4" && $linked < 1){
		mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,skin,x,y,z) VALUES ('".$user->row['id']."','-1','2','4','defaultskin','20','20','".$zindex."')") or die(mysql_error());

        $ret_sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $ret_row = mysql_fetch_assoc($ret_sql);
        $saved_id = $ret_row['id'];

        $edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"widget-" . $saved_id . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"widget-".$saved_id."-edit\", \"click\", function(e) { openEditMenu(e, ".$saved_id.", \"widget\", \"widget-".$saved_id."-edit\"); }, false);
</script>\n";
	?>
	<div class="movable widget GuestbookWidget" id="widget-<?php echo $saved_id ?>" style=" left: 20px; top: 20px; z-index: <?php echo $zindex; ?>;">
<div class="w_skin_defaultskin">
	<div class="widget-corner" id="widget-<?php echo $saved_id ?>-handle">
		<div class="widget-headline"><h3>
		<?php echo $edit; ?>
		<span class="header-left">&nbsp;</span><span class="header-middle">Mio GuestBook(<span id="guestbook-size">0</span>) <span id="guestbook-type" class="public"><img src="<?php echo PATH; ?>images/groups/status_exclusive.gif" title="Friends only" alt="Solo Amici"/></span></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<div id="guestbook-wrapper" class="gb-public">
<ul class="guestbook-entries" id="guestbook-entry-container">
	<div id="guestbook-empty-notes">Il tuo Guestbook non contiene Messaggi.</div>
</ul></div>
<script type="text/javascript">	
	document.observe("dom:loaded", function() {
		var gb81481 = new GuestbookWidget('17570', '<?php echo $saved_id ?>', 500);
		var editMenuSection = $('guestbook-privacy-options');
		if (editMenuSection) {
			gb81481.updateOptionsList('public');
		}
	});
</script>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
    } elseif($widget == "5" && $linked < 1){
		mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,skin,x,y,z,var) VALUES ('".$user->row['id']."','-1','2','5','defaultskin','20','20','".$zindex."','0')") or die(mysql_error());

        $ret_sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $ret_row = mysql_fetch_assoc($ret_sql);
        $saved_id = $ret_row['id'];

        $edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"widget-" . $saved_id . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"widget-".$saved_id."-edit\", \"click\", function(e) { openEditMenu(e, ".$saved_id.", \"widget\", \"widget-".$saved_id."-edit\"); }, false);
</script>\n";
	if($site['memberships'] != "groups_memberships"){
		$sql1 = mysql_query("SELECT * FROM messenger_friendships WHERE user_one_id = '".$user->row['id']."'");
		$count = mysql_num_rows($sql1);
	} else {
		$sql1 = mysql_query("SELECT * FROM messenger_friendships WHERE sender = '".$user->row['id']."'");
		$sql2 = mysql_query("SELECT * FROM messenger_friendships WHERE receiver = '".$user->row['id']."'");
		$count = mysql_num_rows($sql1) + mysql_num_rows($sql2);
	}
			echo "<div class=\"movable widget FriendsWidget\" id=\"widget-".$saved_id."\" style=\" left: 20px; top: 20px; z-index: ".$zindex.";\">
<div class=\"w_skin_defaultskin\">
	<div class=\"widget-corner\" id=\"widget-".$saved_id."-handle\">
		<div class=\"widget-headline\"><h3><span class=\"header-left\">&nbsp;</span><span class=\"header-middle\">Miei Amici (<span id=\"avatar-list-size\">".$count."</span>)</span><span class=\"header-right\">".$edit."</span></h3>
		</div>
	</div>
	<div class=\"widget-body\">
		<div class=\"widget-content\">\n";
?>

<div id="avatar-list-search">
<input type="text" style="float:left;" id="avatarlist-search-string"/>
<a class="new-button" style="float:left;" id="avatarlist-search-button"><b>Cerca</b><i></i></a>
</div>
<br clear="all"/>

<div id="avatarlist-content">

<?php
$bypass = true;
$widgetid = $saved_id;
include('../myhabbo/avatarlist_friendsearchpaging.php');
?>

<script type="text/javascript">
document.observe("dom:loaded", function() {
	window.widget = new FriendsWidget('<?php echo $user_row['id']; ?>', '');
});
</script>

</div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
    } elseif($widget == "8" && $linked < 1){
	mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,skin,x,y,z) VALUES ('".$user->row['id']."','-1','2','8','defaultskin','20','20','".$zindex."')") or die(mysql_error());

        $ret_sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $ret_row = mysql_fetch_assoc($ret_sql);
        $saved_id = $ret_row['id'];

        $edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"widget-" . $saved_id . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"widget-".$saved_id."-edit\", \"click\", function(e) { openEditMenu(e, ".$saved_id.", \"widget\", \"widget-".$saved_id."-edit\"); }, false);
</script>\n";
	?>
<div class="movable widget BadgesWidget" id="widget-<?php echo $saved_id ?>" style=" left: 20px; top: 20px; z-index: <?php echo $zindex; ?>;">
<div class="w_skin_defaultskin">
	<div class="widget-corner" id="widget-<?php echo $saved_id ?>-handle">
		<div class="widget-headline"><h3><?php echo $edit; ?><span class="header-left">&nbsp;</span><span class="header-middle">Distintivi </span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
    <div id="badgelist-content">
	<?php
	$sql = mysql_query("SELECT * FROM user_badges WHERE user_id = '".$user->row['id']."' ORDER BY badge_id ASC");
	$count = mysql_num_rows($sql);
	if($count == 0){
		echo "Non Hai Distintivi.";
	}else{
	?>
    <?php
	$bypass1 = true;
	include('badgelist_badgepaging.php');
	?>
	<?php } ?>

    </div>
		<div class="clear"></div>
		</div>
	</div>

</div>
</div>
<?php
    } elseif($widget == "4" && $linked > 0){
        mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,skin,x,y,z) VALUES ('".$user->row['id']."','".$groupid."','2','4','defaultskin','20','20','".$zindex."')") or die(mysql_error());

        $ret_sql = mysql_query("SELECT * FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND type = '2' AND subtype = '5' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $ret_row = mysql_fetch_assoc($ret_sql);
        $saved_id = $ret_row['id'];

        $edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"widget-" . $saved_id . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"widget-".$saved_id."-edit\", \"click\", function(e) { openEditMenu(e, ".$saved_id.", \"widget\", \"widget-".$saved_id."-edit\"); }, false);
</script>\n";
	?>
	<div class="movable widget GuestbookWidget" id="widget-<?php echo $saved_id ?>" style=" left: 20px; top: 20px; z-index: <?php echo $zindex; ?>;">
<div class="w_skin_defaultskin">
	<div class="widget-corner" id="widget-<?php echo $saved_id ?>-handle">
		<div class="widget-headline"><h3>
		<?php echo $edit; ?>
		<span class="header-left">&nbsp;</span><span class="header-middle">Mio Guestbook(<span id="guestbook-size">0</span>) <span id="guestbook-type" class="public"><img src="./images/groups/status_exclusive.gif" title="Friends only" alt="Friends only"/></span></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<div id="guestbook-wrapper" class="gb-public">
<ul class="guestbook-entries" id="guestbook-entry-container">
	<div id="guestbook-empty-notes">Il Tuo GuestBook Non Contiene Messaggi.</div>
</ul></div>
<script type="text/javascript">	
	document.observe("dom:loaded", function() {
		var gb81481 = new GuestbookWidget('17570', '<?php echo $saved_id ?>', 500);
		var editMenuSection = $('guestbook-privacy-options');
		if (editMenuSection) {
			gb81481.updateOptionsList('public');
		}
	});
</script>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
    }
} else { exit; }

?>