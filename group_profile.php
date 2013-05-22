<?php
$allow_guests = false;
require_once('core.php');
require_once('includes/session.php');
/*if($my_row['rank'] >5)
die();*/
// Search function
if(isset($_POST['searchString']) && $input->FilterText($_POST['searchString'])){
	$searchString = $input->FilterText($_POST['searchString']);
	$check = mysql_query("SELECT id FROM groups WHERE name LIKE %'".$searchString."'% LIMIT 1") or die(mysql_error());
	$found = mysql_num_rows($check);
	if($found > 0){
		$tmp = mysql_fetch_assoc($check);
		header("Location: ".PATH."groups/".$tmp['id']);
		exit;
	}
}

if(isset($_GET['id']) && is_numeric($_GET['id'])){
	$check = mysql_query("SELECT * FROM groups WHERE id = '".$_GET['id']."' LIMIT 1");
	$newcr=0;
	$exists = mysql_num_rows($check);
	if($exists > 0){
			
		$groupid = $input->FilterText($_GET['id']);

		$error = false;
		$groupdata = mysql_fetch_assoc($check);
		
		if(!isset($groupdata['name']))
			$newcr = 1;
			
		$pagename = $newcr == 0 ? $input->FilterText($groupdata['name']) : $input->FilterText($groupdata['Name']);
		$ownerid = $newcr == 0 ? $input->FilterText($groupdata['ownerid']) : $input->FilterText($groupdata['OwnerId']);
		
		if($newcr == 1){
			if($groupdata['Typee'] == 0)
				$groupdata['locked'] = "open";
			else if($groupdata['Typee'] == 1)
				$groupdata['locked'] = "locked";
			else if($groupdata['Typee'] == 2)
				$groupdata['locked'] = "closed";
		
			$groupdata['created'] = $groupdata['DateCreated'];
			$groupdata['roomid'] = $groupdata['RoomId'];
			$groupdata['desc'] = $groupdata['Description'];
			$groupdata['badge'] = $groupdata['Image'];
		} else {
			$groupdata['created'] = date('d/m/Y',$groupdata['created']);
		}
		$members = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE groupid = '".$groupid."'");

		$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1");
		$is_member = mysql_num_rows($check);

		if($is_member > 0 && $logged_in){

			$is_member = true;
			$my_membership = mysql_fetch_assoc($check);

		} else {

			$is_member = false;

		}

	} else {

		$error = true;

	}

} else {

	$error = true;

}


if(isset($_GET['do']) && $_GET['do'] == "edit" && $logged_in){

	if($ownerid == $user->row['id']){

		$edit_mode = true;

		$check = mysql_query("SELECT * FROM cms_homes_group_linker WHERE userid = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
		$linkers = mysql_num_rows($check);

		if($linkers > 0){

			mysql_query("UPDATE cms_homes_group_linker SET active = '1', groupid = '".$groupid."' WHERE userid = '".$user->row['id']."' LIMIT 1") or die(mysql_error());

		} else {

			mysql_query("INSERT INTO cms_homes_group_linker (userid,groupid,active) VALUES ('".$user->row['id']."','".$groupid."','1')") or die(mysql_error());

		}

	} else {

		header("location: ".PATH."groups/".$groupid."&do=bounce");
		$edit_mode = false;

	}

} else {

	$edit_mode = false;

}

if(!$error){

	$body_id = "viewmode";

	if($edit_mode){

		$body_id = "editmode";

	}

} else {

	$body_id = "home";

}

$pageid = "profile";

if($groupdata['locked'] !== "locked" && $is_member !== true){
	// If the group type is NOT exclusive/moderated, we have to delete any pending requests
	// this user has, simply because there's no longer need to put the user in the waiting list.
	$remove_pending = mysql_query("DELETE FROM group_requests WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1") or die(mysql_error());
}

$viewtools = "	<div class=\"myhabbo-view-tools\">\n";

if($logged_in && !$is_member && $groupdata['locked'] != "closed"){ $viewtools = $viewtools . "<a href=\"joingroup.php?groupId=".$groupid."\" id=\"join-group-button\">"; if($groupdata['locked'] == "open"){ $viewtools = $viewtools . "Entra"; } else { $viewtools = $viewtools . "Invia Richiesta"; } $viewtools = $viewtools . "</a>"; }
if($logged_in && $input->GetUserGroup($user->row['id']) != $groupid && $is_member){ $viewtools = $viewtools . "<a href=\"#\" id=\"select-favorite-button\">&Egrave il mio preferito </a>\n"; }
if($logged_in && $input->GetUserGroup($user->row['id']) == $groupid && $is_member){ $viewtools = $viewtools . "<a href=\"#\" id=\"deselect-favorite-button\">Non &egrave il mio preferito</a>"; }
if($logged_in && $is_member && $user->row['id'] != $ownerid){ $viewtools = $viewtools . "<a href=\"leavegroup.php?groupId=".$groupid."\" id=\"leave-group-button\">Esci Dal Gruppo</a>\n"; }

$viewtools = $viewtools . "	</div>\n";


$bg_fetch = mysql_query("SELECT data FROM cms_homes_stickers WHERE type = '4' AND groupid = '".$groupid."' LIMIT 1");
$bg_exists = mysql_num_rows($bg_fetch);

	if($bg_exists < 1){ // if there's no background override for this user set it to the standard
		$bg = "b_bg_pattern_abstract2";
	} else {
		$bg = mysql_fetch_array($bg_fetch);
		$bg = "b_" . $bg[0];
	}

if(!$error){
include('templates/hsubheader.php');
include('templates/header.php');
//mysql_query("UPDATE groups SET views = views+'1' WHERE id='".$groupid."' LIMIT 1");
?>

<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="mypage-wrapper" class="cbb blue">
<div class="box-tabs-container box-tabs-left clearfix">
	<?php if($ownerid == $user->row['id'] && !$edit_mode){ ?><a href="#" id="myhabbo-group-tools-button" class="new-button dark-button edit-icon" style="float:left"><b><span></span>Modifica</b><i></i></a><?php } ?>
	<?php if(!$edit_mode){ echo $viewtools; } ?>
    <h2 class="page-owner">
<?php echo $pagename; ?>&nbsp;
<?php if($groupdata['locked'] == "closed"){ ?><img src='<?php echo PATH; ?>web-gallery/images/status_closed_big.gif' alt='Gruppo Chiuso' title='Gruppo Chiuso'><?php } ?>
<?php if($groupdata['locked'] == "locked"){ ?><img src='<?php echo PATH; ?>web-gallery/images/status_exclusive_big.gif' alt='Gruppo Moderatori' title='Gruppo Moderatori'><?php } ?></h2>
</h2>
    <ul class="box-tabs">
        <li class="selected"><a href="<?php echo PATH."groups/".$_GET['id']; ?>">Home gruppo</a><span class="tab-spacer"></span></li>
        <li class="tab-spacer"><a href="<?php echo PATH."discussions/".$_GET['id']; ?>">Forum Discussione</a><span class="tab-spacer"></span></li>
    </ul>
</div>
	<div id="mypage-content">
<?php 	if($edit_mode == true){ ?>
<div id="top-toolbar" class="clearfix">
	<ul>
		<li><a href="#" id="inventory-button">Inventario</a></li>
		<li><a href="#" id="webstore-button">Webstore</a></li>
		
	</ul>

	<form action="#" method="get" style="width: 50%;">
		<a id="cancel-button" class="new-button red-button cancel-icon" href="#"><b><span></span>Annulla Modifiche</b><i></i></a>
		<a id="save-button" class="new-button green-button save-icon" href="#"><b><span></span>Salva Modifiche</b><i></i></a>
	</form>
</div>
<?php 	} ?>
		<div id="mypage-bg" class="<?php echo $bg; ?>">
			<div id="playground-outer">
				<div id="playground">

<?php
$get_em = mysql_query("SELECT id,type,x,y,z,data,skin,subtype,var FROM cms_homes_stickers WHERE groupid = '".$groupid."' and type < 6 LIMIT 200") or die(mysql_error());

while ($row = mysql_fetch_array($get_em, MYSQL_NUM)) {

	switch($row[1]){
	case 1: $type = "sticker"; break;
	case 2: $type = "widget"; break;
	case 3: $type = "stickie"; break;
	case 4: $type = "ignore"; break;
	case 5: $type = "html"; break;
	}

	if($edit_mode == true){
	$edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"" . $type . "-" . $row[0] . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"".$type."-".$row[0]."-edit\", \"click\", function(e) { openEditMenu(e, ".$row[0].", \"".$type."\", \"".$type."-".$row[0]."-edit\"); }, false);
</script>\n";
	}else {
	$edit = " ";
	}
	if($edit_mode == true && $type == 'html')
	{
	$edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"stickie-" . $row[0] . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"stickie-".$row[0]."-edit\", \"click\", function(e) { openEditMenu(e, ".$row[0].", \"stickie\", \"stickie-".$row[0]."-edit\"); }, false);
</script>\n";
	}

	if($type == "stickie"){
	printf("<div class=\"movable stickie n_skin_%s-c\" style=\" left: %spx; top: %spx; z-index: %s;\" id=\"stickie-%s\">
	<div class=\"n_skin_%s\" >
		<div class=\"stickie-header\">
			<h3>%s</h3>
			<div class=\"clear\"></div>
		</div>
		<div class=\"stickie-body\">
			<div class=\"stickie-content\">
				<div class=\"stickie-markup\">%s</div>
				<div class=\"stickie-footer\">
				</div>
			</div>
		</div>
	</div>
</div>",$row[6],$row[2],$row[3],$row[4],$row[0],$row[6],$edit,$input->bbcode_format(nl2br($input->HoloText($row[5]))));
	} elseif($type == "sticker"){
	printf("<div class=\"movable sticker s_%s\" style=\"left: %spx; top: %spx; z-index: %s;\" id=\"sticker-%s\">\n%s\n</div>", $row[5], $row[2], $row[3], $row[4], $row[0], $edit);
	} elseif($type == "html"){
		printf("<div class=\"movable stickie n_skin_%s-c\" style=\" left: %spx; top: %spx; z-index: %s;\" id=\"stickie-%s\">
	<div class=\"n_skin_%s\" >
		<div class=\"stickie-header\">
			<h3>%s</h3>
			<div class=\"clear\"></div>
		</div>
		<div class=\"stickie-body\">
			<div class=\"stickie-content\">
				<div class=\"stickie-markup\">%s</div>
				<div class=\"stickie-footer\">
				</div>
			</div>
		</div>
	</div>
</div>",$row[6],$row[2],$row[3],$row[4],$row[0],$row[6],$edit,$row[5]);
	} elseif($type == "widget"){

		switch($row[7]){
		case "1": $subtype = "Profilewidget"; break;
		case "3": $subtype = "MemberWidget"; break;
		case "4": $subtype = "GuestbookWidget"; break;
		case "5": $subtype = "TraxPlayerWidget";
		}

		if($subtype == "Profilewidget"){

		$found_profile = true;

		echo "<div class=\"movable widget GroupInfoWidget\" id=\"widget-".$row[0]."\" style=\" left: ".$row[2]."px; top: ".$row[3]."px; z-index: ".$row[4].";\">
<div class=\"w_skin_".$row[6]."\">
	<div class=\"widget-corner\" id=\"widget-".$row[0]."-handle\">
		<div class=\"widget-headline\"><h3><span class=\"header-left\">&nbsp;</span><span class=\"header-middle\">Gruppo</span><span class=\"header-right\">".$edit."</span></h3>
		</div>
	</div>
	<div class=\"widget-body\">
		<div class=\"widget-content\">";
			?>

<div class=\"group-info-icon\"><img src='<?php echo PATH; ?>habbo-imaging/<?php if(!isset($_GET['x'])) { echo "badge.php?badge=".$groupdata['badge'].".gif"; }else{ echo "badge.php?badge=".$groupdata['badge'].""; } ?>' /></div>
<?php echo "
<h4 style=\"color:black\">".$input->HoloText($pagename)."</h4>

<p>
Creato il: <strong>".$groupdata['created']."</strong>
</p>

<p>
Numero di membri: <strong>".$members."</strong>
</p>";
if($groupdata['roomid'] != 0 OR $groupdata['roomid'] != "" OR $groupdata['roomid'] != " ") {
$sql = mysql_query("SELECT caption FROM rooms WHERE id='".$groupdata['roomid']."' LIMIT 1");
$roominfo = mysql_fetch_assoc($sql); ?>
<?php if($groupdata['roomid'] <> 0){ ?><p><a href="client.php?forwardId=2&amp;roomId=<?php echo $groupdata['roomid']; ?>" onclick="HabboClient.roomForward(this, '<?php echo $groupdata['roomid']; ?>', 'private'); return false;" target="client" class="group-info-room"><?php echo $input->HoloText($roominfo['caption']); ?></a></p>
<?php } ?>
<?php
}

echo "\n<div class=\"group-info-description\">".$input->HoloText($groupdata['desc'])."</div>

<script type=\"text/javascript\">
    document.observe(\"dom:loaded\", function() {
        new GroupInfoWidget('".$groupid."', '".$row[0]."');
    });
</script>

		<div class=\"clear\"></div>
		</div>
	</div>
</div>
</div>";
		} elseif($subtype == "MemberWidget"){
			echo "<div class=\"movable widget MemberWidget\" id=\"widget-".$row[0]."\" style=\" left: ".$row[2]."px; top: ".$row[3]."px; z-index: ".$row[4].";\">
<div class=\"w_skin_".$row[6]."\">
	<div class=\"widget-corner\" id=\"widget-".$row[0]."-handle\">
		<div class=\"widget-headline\"><h3><span class=\"header-left\">&nbsp;</span><span class=\"header-middle\">Membri del gruppo (<span id=\"avatar-list-size\">".$members."</span>)</span><span class=\"header-right\">".$edit."</span></h3>
		</div>
	</div>
	<div class=\"widget-body\">
		<div class=\"widget-content\">

<div id=\"avatar-list-search\">
<input type=\"text\" style=\"float:left;\" id=\"avatarlist-search-string\"/>
<a class=\"new-button\" style=\"float:left;\" id=\"avatarlist-search-button\"><b>Cerca</b><i></i></a>
</div>
<br clear=\"all\"/>

<div id=\"avatarlist-content\">\n";

$bypass = true;
$widgetid = $row['0'];
include('./myhabbo/avatarlist_membersearchpaging.php');

echo "<script type=\"text/javascript\">
document.observe(\"dom:loaded\", function() {
	window.widget".$row[0]." = new MemberWidget('".$groupid."', '".$row[0]."');
});
</script>

</div>
		<div class=\"clear\"></div>
		</div>
	</div>
</div>
</div>";
	} elseif($subtype == "GuestbookWidget"){
	$sql = mysql_query("SELECT * FROM cms_guestbook WHERE widget_id = '".$row['0']."' ORDER BY id DESC");
	$count = mysql_num_rows($sql);
		$status = "Publico";
	?>
	<div class="movable widget GuestbookWidget" id="widget-<?php echo $row['0']; ?>" style=" left: <?php echo $row['2']; ?>px; top: <?php echo $row['3']; ?>px; z-index: <?php echo $row['4']; ?>;">
<div class="w_skin_<?php echo $row['6']; ?>">
	<div class="widget-corner" id="widget-<?php echo $row['0']; ?>-handle">
		<div class="widget-headline"><h3>
		<?php echo $edit; ?>
		<span class="header-left">&nbsp;</span><span class="header-middle">Il mio Guestbook(<span id="guestbook-size"><?php echo $count; ?></span>) <span id="guestbook-type" class="<?php echo $status; ?>"><img src="<?php echo PATH; ?>web-gallery/images/groups/status_exclusive.gif" title="Friends only" alt="Friends only"/></span></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<div id="guestbook-wrapper" class="gb-public">
<ul class="guestbook-entries" id="guestbook-entry-container">
	<?php if($count == 0){ ?>
	<div id="guestbook-empty-notes">Non ci sono messaggi in questo guestbook.</div>
	<?php } else { ?>
			<?php 
			$sql123 = mysql_query("SELECT * FROM groups WHERE id = '".$_GET['id']."' LIMIT 1");
			$grouprrow = mysql_fetch_assoc($sql123);
			$i = 0;
			while ($row1 = mysql_fetch_assoc($sql)) {
				$i++;
				$userrow = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = '".$row1['userid']."' LIMIT 1"));
				if($user->row['id'] == $row1['userid']){
					$owneronly = "<img src=\"".PATH."web-gallery/images/myhabbo/buttons/delete_entry_button.gif\" id=\"gbentry-delete-".$row1['id']."\" class=\"gbentry-delete\" style=\"cursor:pointer\" alt=\"\"/><br/>";
				} elseif($grouprrow['ownerid'] == $user->row['id']) {
					$owneronly = "<img src=\"".PATH."web-gallery/images/myhabbo/buttons/delete_entry_button.gif\" id=\"gbentry-delete-".$row1['id']."\" class=\"gbentry-delete\" style=\"cursor:pointer\" alt=\"\"/><br/>";
				} else {
					$owneronly = "";
				}
				if($input->IsUserOnline($row1['userid'])){ $useronline = "online"; } else { $useronline = "offline"; }
				printf("	<li id=\"guestbook-entry-%s\" class=\"guestbook-entry\">
		<div class=\"guestbook-author\">
			<img src=\"http://www.habbo.it/habbo-imaging/avatarimage?figure=%s&direction=2&head_direction=2&gesture=sml&size=s\" alt=\"%s\" title=\"%s\"/>
		</div>
			<div class=\"guestbook-actions\">
					$owneronly
			</div>
		<div class=\"guestbook-message\">
			<div class=\"%s\">
				<a href=\"".PATH."home/%s\">%s</a>
			</div>
			<p>%s</p>
		</div>
		<div class=\"guestbook-cleaner\">&nbsp;</div>
		<div class=\"guestbook-entry-footer metadata\">%s</div>
	</li>",$userrow['username'], $userrow['look'], $userrow['username'], $userrow['username'], $useronline, $userrow['username'], $userrow['username'], $input->HoloText($row1['message'],false ,true), $row1['time']);
			}
	} ?>
</ul></div>
<?php if($edit_mode == false){ ?>
	<div class="guestbook-toolbar clearfix">
	<a href="#" class="new-button envelope-icon" id="guestbook-open-dialog">
	<b><span></span>Posta un Messaggio</b><i></i>
	</a>
	</div>
<?php } ?>
<script type="text/javascript">	
	document.observe("dom:loaded", function() {
		var gb<?php echo $row['0']; ?> = new GuestbookWidget('17570', '<?php echo $row['0']; ?>', 500);
		var editMenuSection = $('guestbook-privacy-options');
		if (editMenuSection) {
			gb<?php echo $row['0']; ?>.updateOptionsList('public');
		}
	});
</script>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
	} elseif($subtype == "TraxPlayerWidget"){ 
		$sql123 = mysql_query("SELECT * FROM groups WHERE id = '".$_GET['id']."' LIMIT 1");
		$grouprrow = mysql_fetch_assoc($sql123);?>
		<div class="movable widget TraxPlayerWidget" id="widget-<?php echo $row['0']; ?>" style=" left: <?php echo $row['2']; ?>px; top: <?php echo $row['3']; ?>px; z-index: <?php echo $row['4']; ?>;">
<div class="w_skin_<?php echo $row['6']; ?>">
	<div class="widget-corner" id="widget-<?php echo $row['0']; ?>-handle">
		<div class="widget-headline"><h3><?php echo $edit; ?><span class="header-left">&nbsp;</span><span class="header-middle">TRAXPLAYER</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<?php 
if($row['8'] == ""){ $songselected = false; }else{ $songselected = true; }
if($edit_mode == true){ ?>
<div id="traxplayer-content" style="text-align: center;">
	<img src="./web-gallery/images/traxplayer/player.png"/>
</div>

<div id="edit-menu-trax-select-temp" style="display:none">
    <select id="trax-select-options-temp">
    <option value="">- Choose song -</option>
	<?php
	$mysql = mysql_query("SELECT * FROM furniture WHERE ownerid = '".$grouprrow['ownerid']."'");
	$i = 0;
	while($machinerow = mysql_fetch_assoc($mysql)){
		$i++;
		$sql = mysql_query("SELECT * FROM soundtracks WHERE id = '".$machinerow['id']."'");
		$n = 0;
		while($songrow = mysql_fetch_assoc($sql)){
			$n++;
			if($songrow['id'] <> ""){ echo "		<option value=\"".$songrow['id']."\">".trim(nl2br($input->HoloText($songrow['title'])))."</option>\n"; }
		}
	} ?>
    </select>

</div>
<?php } ?>

		<div class="clear"></div>
		</div>
	</div>
</div>
</div><?php
	}

	}

}

if(isset($found_profile) && $found_profile != true){

	mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,type,subtype,x,y,z,skin) VALUES ('-1','".$groupid."','2','1','25','25','5','defaultskin')") or die(mysql_error());

		echo "<div class=\"movable widget GroupInfoWidget\" id=\"widget-".$row[0]."\" style=\" left: 25px; top: 25px; z-index: 5;\">
<div class=\"w_skin_defaultskin\">
	<div class=\"widget-corner\" id=\"widget-1994412-handle\">
		<div class=\"widget-headline\"><h3><span class=\"header-left\">&nbsp;</span><span class=\"header-middle\">Informazioni Gruppo</span><span class=\"header-right\">&nbsp;</span></h3>
		</div>
	</div>
	<div class=\"widget-body\">
		<div class=\"widget-content\">

<div class=\"group-info-icon\"><img src='./habbo-imaging/badge.php?badge=".$groupdata['badge']."' /></div>

<h4 style=\"color:black\">".$input->HoloText($groupdata['name'])."</h4>

<p>
Creato il: <strong>".$groupdata['created']."</strong>
</p>

<p>
<strong>".$members."</strong> Membri
</p>\n";

// <p><a href=\"http://www.habbo.nl/client?forwardId=2&amp;roomId=13303122\" onclick=\"roomForward(this, '13303122', 'private'); return false;\" target=\"client\" class=\"group-info-room\">The church of bobbaz</a></p>

echo "\n<div class=\"group-info-description\">".$input->HoloText($groupdata['desc'])."</div>

<script type=\"text/javascript\">
    document.observe(\"dom:loaded\", function() {
        new GroupInfoWidget('55918', '1478728');
    });
</script>

		<div class=\"clear\"></div>
		</div>
	</div>
</div>
</div>";

}
?>
				</div>
			</div>
			<div id="mypage-ad">
    <div class="habblet ">
<div class="ad-container">
&nbsp;
</div>
    </div>
			</div>

		</div>
	</div>
</div>

<script language="JavaScript" type="text/javascript">
initEditToolbar();
initMovableItems();
document.observe("dom:loaded", initDraggableDialogs);
</script>


<div id="edit-save" style="display:none;"></div>
    </div>
<div id="footer">
	<p class="copyright"><a href="index.php" target="_self"><font color="green">Homepage</a> <font color="black">|</font> <a href="./disclaimer.php" target="_self"><font color="black"><font color="black">Termini Di Servizio</a> | <a href="./privacy.php" target="_self"><font color="red">Privacy Policy</a></p>
	<?php /*@@* DO NOT EDIT OR REMOVE THE LINE BELOW WHATSOEVER! *@@*/ ?>
	<font color="black"><p>Powered by HoloCMS &copy 2008 Meth0d & Parts by Yifan, sisija and edited by <b>Donatello (DnT)</b>.<br />HABBO is a registered trademark of Sulake Corporation. All rights reserved to their respective owner(s).<br />We are not endorsed, affiliated, or sponsered by Sulake Corporation Oy.</p> </div></div>
	<?php /*@@* DO NOT EDIT OR REMOVE THE LINE ABOVE WHATSOEVER! *@@*/ ?>
</div></div>

</div>

<?php if($edit_mode){ ?>
<div id="edit-menu" class="menu">
	<div class="menu-header">
		<div class="menu-exit" id="edit-menu-exit"><img src="./web-gallery/images/dialogs/menu-exit.gif" alt="" width="11" height="11" /></div>
		<h3>Modifica</h3>
	</div>
	<div class="menu-body">
		<div class="menu-content">
			<form action="#" onsubmit="return false;">
				<div id="edit-menu-skins">
	<select id="edit-menu-skins-select">
			<option value="1" id="edit-menu-skins-select-defaultskin">Tradizionale</option>
			<option value="6" id="edit-menu-skins-select-goldenskin">Oro</option>
			<option value="8" id="edit-menu-skins-select-hc_pillowskin">HC Bling</option>
			<option value="7" id="edit-menu-skins-select-hc_machineskin">HC Scifi</option>
<?php if($user->row['rank'] > 5){ ?>
			<option value="9" id="edit-menu-skins-select-nakedskin">Staff</option>
<?php } ?>
			<option value="3" id="edit-menu-skins-select-metalskin">Metallo</option>
			<option value="5" id="edit-menu-skins-select-notepadskin">Notepad</option>
			<option value="2" id="edit-menu-skins-select-speechbubbleskin">Bolla</option>
			<option value="4" id="edit-menu-skins-select-noteitskin">Post-IT</option>
	</select>
				</div>
				<div id="edit-menu-stickie">
					<p>Se Clicchi Su Rimuovi Si rimuovera automaticamente .</p>
				</div>
				<div id="rating-edit-menu">
					<input type="button" id="ratings-reset-link"
						value="Reset rating" />
				</div>
				<div id="highscorelist-edit-menu" style="display:none">
					<select id="highscorelist-game">
						<option value="">Seleziona gioco</option>
						<option value="1">Battle Ball!</option>
						<option value="2">SnowStorm</option>
						<option value="0">Wobble Squabble</option>
					</select>
				</div>
				<div id="edit-menu-remove-group-warning">
					<p>Questa voce appartiene a un altro utente. Se  si rimuove, tornera al loro inventario.</p>
				</div>
				<div id="edit-menu-gb-availability">
					<select id="guestbook-privacy-options">
						<option value="private">Membri Solo</option>
						<option value="public">Pubblico</option>
					</select>
				</div>
				<div id="edit-menu-trax-select">
					<select id="trax-select-options"></select>
				</div>
				<div id="edit-menu-remove">
					<input type="button" id="edit-menu-remove-button" value="Rimuovi" />
				</div>
			</form>
			<div class="clear"></div>
		</div>
	</div>
	<div class="menu-bottom"></div>
</div>
<script language="JavaScript" type="text/javascript">
Event.observe(window, "resize", function() { if (editMenuOpen) closeEditMenu(); }, false);
Event.observe(document, "click", function() { if (editMenuOpen) closeEditMenu(); }, false);
Event.observe("edit-menu", "click", Event.stop, false);
Event.observe("edit-menu-exit", "click", function() { closeEditMenu(); }, false);
Event.observe("edit-menu-remove-button", "click", handleEditRemove, false);
Event.observe("edit-menu-skins-select", "click", Event.stop, false);
Event.observe("edit-menu-skins-select", "change", handleEditSkinChange, false);
Event.observe("guestbook-privacy-options", "click", Event.stop, false);
Event.observe("guestbook-privacy-options", "change", handleGuestbookPrivacySettings, false);
Event.observe("trax-select-options", "click", Event.stop, false);
Event.observe("trax-select-options", "change", handleTraxplayerTrackChange, false);
</script>
<?php } else { ?>
<div class="cbb topdialog" id="guestbook-form-dialog">
	<h2 class="title dialog-handle">Posta un Messaggio</h2>

	<a class="topdialog-exit" href="#" id="guestbook-form-dialog-exit">X</a>
	<div class="topdialog-body" id="guestbook-form-dialog-body">
<div id="guestbook-form-tab">
<form method="post" id="guestbook-form">
    <p>
        NB: il messaggio non deve superare i 500 caratteri        <input type="hidden" name="ownerId" value="441794" />
	</p>
	<div>
	    <textarea cols="15" rows="5" name="message" id="guestbook-message"></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("guestbook-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Rosso"],
            "orange" : ["#fe6301", "Arancione"],
            "yellow" : ["#ffce00", "Giallo"],
            "green" : ["#6cc800", "Verde"],
            "cyan" : ["#00c6c4", "Grigio"],
            "blue" : ["#0070d7", "Blu"],
            "gray" : ["#828282", "Grigio"],
            "black" : ["#000000", "Nero"]
        };
        bbcodeToolbar.addColorSelect("Colori", colors, true);
    </script>
    </div>

	<div class="guestbook-toolbar clearfix">
		<a href="#" class="new-button" id="guestbook-form-cancel"><b>Annulla</b><i></i></a>
		<a href="#" class="new-button" id="guestbook-form-preview"><b>Anteprima</b><i></i></a>
	</div>
</form>
</div>
<div id="guestbook-preview-tab">&nbsp;</div>
	</div>
</div>
<div class="cbb topdialog" id="guestbook-delete-dialog">
	<h2 class="title dialog-handle">	Cancella Messaggio</h2>

	<a class="topdialog-exit" href="#" id="guestbook-delete-dialog-exit">X</a>
	<div class="topdialog-body" id="guestbook-delete-dialog-body">
<form method="post" id="guestbook-delete-form">
	<input type="hidden" name="entryId" id="guestbook-delete-id" value="" />
	<p>Sei sicuro di voler eliminare questo messaggio?</p>
	<p>
		<a href="#" id="guestbook-delete-cancel" class="new-button"><b>Annulla</b><i></i></a>
		<a href="#" id="guestbook-delete" class="new-button"><b>Elimina</b><i></i></a>
	</p>
</form>
	</div>
</div>
<div id="group-tools" class="bottom-bubble">
	<div class="bottom-bubble-t"><div></div></div>
	<div class="bottom-bubble-c">
<h3>MODIFICA GRUPPO</h3>
<?php
	$requests = mysql_query("SELECT * FROM group_requests WHERE groupid = ".$groupid) or die();
	$requests = mysql_num_rows($requests) > 0 ? "<b>".mysql_num_rows($requests)."</b>" : mysql_num_rows($requests);
?>
<ul>
	<li><a href="<?php echo PATH; ?>groups/<?php echo $groupid; ?>&do=edit" id="group-tools-style">Modifica pagina</a></li>
	<?php if($ownerid == $user->row['id']){ ?><li><a href="#" id="group-tools-settings">Impostazioni</a></li><?php } ?>
	<li><a href="#" id="group-tools-badge">Distintivo</a></li>
	<li><a href="#" id="group-tools-members">Membri (<?php echo $requests; ?>)</a></li>
</ul>

	</div>
	<div class="bottom-bubble-b"><div></div></div>
</div>

<div class="cbb topdialog black" id="dialog-group-settings">

	<div class="box-tabs-container">
<ul class="box-tabs">
	<li class="selected" id="group-settings-link-group"><a href="#">Gruppo</a><span class="tab-spacer"></span></li>
		<li id="group-settings-link-room"><a href="#">Stanze</a><span class="tab-spacer"></span></li>
<li id="group-settings-link-forum"><a href="#">Forum</a><span class="tab-spacer"></span></li>

</ul>
</div>

	<a class="topdialog-exit" href="#" id="dialog-group-settings-exit">X</a>
	<div class="topdialog-body" id="dialog-group-settings-body">
	<p style="text-align:center"><img src="<?php echo PATH; ?>web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></p>
	</div>
</div>

<script language="JavaScript" type="text/javascript">
Event.observe("dialog-group-settings-exit", "click", function(e) {
    Event.stop(e);
    closeGroupSettings();
}, false);
</script><div class="cbb topdialog black" id="group-memberlist">

	<div class="box-tabs-container">
<ul class="box-tabs">
	<li class="selected" id="group-memberlist-link-members"><a href="#">Membri Attuali</a><span class="tab-spacer"></span></li>
	<li id="group-memberlist-link-pending"><a href="#">Membri in attesa</a><span class="tab-spacer"></span></li>
</ul>
</div>

	<a class="topdialog-exit" href="#" id="group-memberlist-exit">X</a>
	<div class="topdialog-body" id="group-memberlist-body">
<div id="group-memberlist-members-search" class="clearfix" style="display:none">

    <a id="group-memberlist-members-search-button" href="#" class="new-button"><b>Cerca</b><i></i></a>
    <input type="text" id="group-memberlist-members-search-string"/>
</div>
<div id="group-memberlist-members" style="clear: both"></div>
<div id="group-memberlist-members-buttons" class="clearfix">
	<!--<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-give-rights"><b>Dai Diritti</b><i></i></a>
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-revoke-rights"><b>Rimuovi Diritti</b><i></i></a>-->
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-remove"><b>Rimuovi</b><i></i></a>
	<a href="#" class="new-button group-memberlist-button" id="group-memberlist-button-close"><b>Chiudi</b><i></i></a>
</div>
<div id="group-memberlist-pending" style="clear: both"></div>
<div id="group-memberlist-pending-buttons" class="clearfix">
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-accept"><b>Accetta</b><i></i></a>
	<a href="#" class="new-button group-memberlist-button-disabled" id="group-memberlist-button-decline"><b>Rifiuta</b><i></i></a>
	<a href="#" class="new-button group-memberlist-button" id="group-memberlist-button-close2"><b>Chiudi</b><i></i></a>
</div>
	</div>
</div>
<?php } ?>

<script type="text/javascript">
HabboView.run();
</script>

<?php echo $site['analytics']; ?>
</body>
</html>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else {
$pagename = "Pagina Non Trovata";
include('templates/subheader.php');
include('templates/header.php');
?>

<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix red ">

							<h2 class="title">Pagina Non trovata!
							</h2>
						<div id="notfound-content" class="box-content">
    <p class="error-text">Ci Dispiace Pagina Non trovata.</p> <img id="error-image" src="./web-gallery/v2/images/error.gif" />
    <p class="error-text">Usa Indietro Per tornare alla pagina precedente.</p>
    <p class="error-text"><b>Cerca i gruppi</b></p>
    <?php if($input->FilterText($searchString)){ echo "<p class=\"error-text\">Nessun Risultato Trovato <strong>'".$searchString."'.</strong></p>"; } ?>
    <p class="error-text">
	<form method='post'>
		Nome Gruppo:<br />
		<input type='text' name='searchString' maxlength='25' size='25' value='<?php echo $input->FilterText($_POST['searchString']); ?>'>
		<input type='submit' class='Invia' value='Invia'>
	</form>
    </p>
</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<div id="column2" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix green ">

						<h2 class="title">Forse Cercavi...
							</h2>
						<div id="notfound-looking-for" class="box-content">
    <p><b>I Miei Amici?</b><br/>
   Scopri se è elencata nella lista che trovi nella pagina <a href="community.php">Community</a> 

    <p><b>Stanze Raccomandate?</b><br/>
   Vai Qui <a href="community.php">Stanze Raccomandate</a> list.</p>

    <p><b>Tag Degli Utenti?</b><br/>
    Clicca qua per vedere <a href="tags.php">Le Tag Migliori</a></p>

     <p><b>Vuoi Ricaricarti?</b><br/>
   Prova a guardare qua<a href="credits.php">Crediti</a> Pagina.</p>
</div>



					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>

<?php
include('templates/footer.php');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
