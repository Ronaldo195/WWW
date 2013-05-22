<?php
$allow_guests = false;

require_once('core.php');
require_once('includes/session.php');

$my_id = $user->row['id'];

if(isset($_GET['name']) || isset($_POST['name']) || isset($_GET['id'])){
	if(isset($_GET['name'])){
        $searchname = $input->FilterText($_GET['name']);
	} else if(isset($_POST['name'])){
        $searchname = $input->FilterText($_POST['name']);
	} else if(isset($_GET['id'])){
        $searchname = $input->FilterText($_GET['id']);
	} else {
        $error = true;
	}
	
	$user_sql = mysql_query("SELECT * FROM users WHERE username = '".$searchname."' OR id = '".$searchname."' LIMIT 1") or die(mysql_error());
	$user_exists = mysql_num_rows($user_sql);

	if($user_exists == "1"){
        $error = false;
        $user_row = mysql_fetch_assoc($user_sql);
        $pagename = $user_row['username'];
	} else {
        $error = true;
	}

} else {
    $error = true;
}

if(isset($_GET['do']) && $_GET['do'] == "edit" && $logged_in){
	if($user_row['username'] == $user->row['username']){
        $edit_mode = true;
        mysql_query("UPDATE cms_homes_group_linker SET active = '0' WHERE userid = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
	} else {
        header("location: ".PATH."home/".$user_row['username']."&do=bounce"); exit;
        $edit_mode = false;
	}
} else {
    $edit_mode = false;
}



if(($searchname == $user->row['username'] || $searchname == $user->row['id']) && $logged_in){
    $pageid = "myprofile";
} else {
    $pageid = "profile";
}


if($searchname == "")
    $error = true;

if(!isset($user_row))
	header("location: ".PATH."error");
	
$bg_fetch = mysql_query("SELECT data FROM cms_homes_stickers WHERE type = '4' AND userid = '".$user_row['id']."' AND groupid = '-1' LIMIT 1");
$bg_exists = mysql_num_rows($bg_fetch);

if($bg_exists < 1){
	$bg = "b_bg_pattern_abstract2";
} else {
	$bg = mysql_fetch_array($bg_fetch);
	$bg = "b_" . $bg[0];
}

	if($pageid == "profile" && $input->GetUserInfo($user_row['id'], 'home_show') == 0)
		header("Location: ".PATH."error");
		
if((isset($error) && $error == false) && !$input->IsUserBanned($user_row['username'])){
	include('templates/hsubheader.php');
	include('templates/header.php');
?>

<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="mypage-wrapper" class="cbb blue">
	<div class="box-tabs-container box-tabs-left clearfix">
	<?php if($user_row['username'] == $user->row['username'] && $edit_mode != true){ ?><a href="<?php echo PATH."home/".$searchname; ?>&do=edit" id="edit-button" class="new-button dark-button edit-icon" style="float:left"><b><span></span>Modifica</b><i></i></a><?php } ?>
		<h2 class="page-owner"><?php echo $user_row['username']; ?></h2>
		<ul class="box-tabs"></ul>
	</div>
	<div id="mypage-content">
	<?php if($edit_mode == true){ ?>
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
	<?php } ?>
		<div id="mypage-bg" class="<?php echo $bg; ?>">
			<div id="playground-outer">
				<div id="playground">

<?php
$get_em = mysql_query("SELECT id,type,x,y,z,data,skin,subtype,var FROM cms_homes_stickers WHERE userid = '".$user_row['id']."' AND groupid = '-1' AND type < 4 LIMIT 200") or die(mysql_error());

while ($row = mysql_fetch_array($get_em, MYSQL_NUM)) {

	switch($row[1]){
        default: $type = "sticker"; break;
        case 1: $type = "sticker"; break;
        case 2: $type = "widget"; break;
        case 3: $type = "stickie"; break;
        case 4: $type = "ignore"; break;
	}

	if($edit_mode == true){
        $edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"" . $type . "-" . $row[0] . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"".$type."-".$row[0]."-edit\", \"click\", function(e) { openEditMenu(e, ".$row[0].", \"".$type."\", \"".$type."-".$row[0]."-edit\"); }, false);
</script>\n";
	} else {
        $edit = " ";
	}

	$content = $input->bbcode_format(nl2br($input->HoloText($row[5])));

	if($type == "stickie"){
        printf("<div class=\"movable stickie n_skin_%s-c\" style=\"".($edit_mode == true ? "cursor:move;" : "")." left: %spx; top: %spx; z-index: %s;\" id=\"stickie-%s\">
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
</div>",$row[6],$row[2],$row[3],$row[4],$row[0],$row[6],$edit,$content);
	} elseif($type == "sticker"){
        printf("<div class=\"movable sticker s_%s\" style=\"".($edit_mode == true ? "cursor:move;" : "")."left: %spx; top: %spx; z-index: %s\" id=\"sticker-%s\">\n%s\n</div>", $row[5], $row[2], $row[3], $row[4], $row[0], $edit);
	} elseif($type == "widget"){

		switch($row[7]){
            case 1: $subtype = "Profilewidget"; break;
            case 2: $subtype = "GroupsWidget"; break;
            case 3: $subtype = "RoomsWidget"; break;
            case 4: $subtype = "GuestbookWidget"; break;
            case 5: $subtype = "FriendsWidget"; break;
            case 9: $subtype = "RatingWidget"; break;
            case 8: $subtype = "BadgesWidget";
		}
		
		if($subtype == "RatingWidget"){
		?>
		<div class="movable widget RatingWidget" id="widget-<?php echo $row[0]; ?>" style=" left: <?php echo $row[2]; ?>px; top: <?php echo $row[3]; ?>px; z-index: <?php echo $row[4]; ?>;">
<div class="w_skin_<?php echo $row[6]; ?>">
	<div class="widget-corner" <?php echo $edit_mode == true ? 'style="cursor:move"' : ''; ?> id="widget-<?php echo $row[0]; ?>-handle">
		<div class="widget-headline"><h3>
<?php if($edit_mode == true){ ?>
<img src="<?php echo PATH; ?>/web-gallery/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="widget-<?php echo $row[0]; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("widget-<?php echo $row[0]; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $row[0]; ?>, "widget", "widget-<?php echo $row[0]; ?>-edit"); }, false);
</script>
<?php } ?>
		<span class="header-left">&nbsp;</span><span class="header-middle">Il mio voto</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
	<div id="rating-main">
<?php
$myvote = mysql_query("SELECT COUNT(*) FROM cms_ratings WHERE raterid = '".$my_id."' AND userid = '".$user_row['id']."'");
$myvote = mysql_num_rows($myvote) > 0 ? mysql_result($myvote,0) : 0;
$totalvotes = mysql_query("SELECT COUNT(*) FROM cms_ratings WHERE userid = '".$user_row['id']."'");
$totalvotes = mysql_num_rows($totalvotes) > 0 ? mysql_result($totalvotes,0) : 0;
$highvotes = mysql_query("SELECT COUNT(*) FROM cms_ratings WHERE userid = '".$user_row['id']."' AND rating > 3");
$highvotes = mysql_num_rows($highvotes) > 0 ? mysql_result($highvotes,0) : 0;

if($user_row['id'] == $my_id || $myvote > 0){
	$bypass = true;
	$ownerid = $user_row['id'];
	$widgetid = $row[0];
	$rate = 0;
	require_once('./myhabbo/rating_rate.php');
}else{
?>
<script type="text/javascript">	
	var ratingWidget;
	document.observe("dom:loaded", function() { 
		ratingWidget = new RatingWidget(<?php echo $user_row['id']; ?>, <?php echo $row[0]; ?>);
	}); 
</script><div class="rating-average">
		<b>Votami</b>
	<div id="rating-stars" class="rating-stars" >
				<ul id="rating-unit_ul1" class="rating-unit-rating">
				<li class="rating-current-rating" style="width:0px;" />
					<li><a href="#"   class="r1-unit rater">1</a></li>
					<li><a href="#"   class="r2-unit rater">2</a></li>
					<li><a href="#"   class="r3-unit rater">3</a></li>
					<li><a href="#"   class="r4-unit rater">4</a></li>
					<li><a href="#"   class="r5-unit rater">5</a></li>
	
			</ul>	
	</div>
	<?php echo $totalvotes; ?> Voti totali
	
	<br/>
	(<?php echo $highvotes; ?> Voti alti)
</div>
<?php } ?>

	</div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
		<?php
		}else if($subtype == "GroupsWidget"){
            $groups = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE userid = ".$user_row['id']);

			echo "<div class=\"movable widget GroupsWidget\" id=\"widget-".$row[0]."\" style=\" left: ".$row[2]."px; top: ".$row[3]."px; z-index: ".$row[4].";\">
<div class=\"w_skin_".$row[6]."\">
	<div class=\"widget-corner\" ".($edit_mode == true ? "style=\"cursor:move\"" : "")." id=\"widget-".$row[0]."-handle\">
		<div class=\"widget-headline\"><h3><span class=\"header-left\">&nbsp;</span><span class=\"header-middle\">Miei Gruppi (<span id=\"groups-list-size\">".$groups."</span>)</span><span class=\"header-right\">".$edit."</span></h3>
		</div>
	</div>
	<div class=\"widget-body\">
		<div class=\"widget-content\">

<div class=\"groups-list-container\">
<ul class=\"groups-list\">";

            $get_groups = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid = ".$user_row['id']) or die(mysql_error());
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
				
                echo "	<li title=\"".$grouprow['name']."\" id=\"groups-list-".$row[0]."-".$grouprow['id']."\"><div class=\"groups-list-icon\"><a href=\"".PATH."groups/".$grouprow['id']."\"><img src='".PATH."habbo-imaging/badge.php?badge=".$grouprow['badge'].".gif'/></a></div><div class=\"groups-list-open\"></div><h4><a href=\"".PATH."groups/".$membership_row['groupid']."\">".$grouprow['name']."</a></h4><p>Gruppo Creato Il:<br />";
                $prova = mysql_query("SELECT * FROM user_stats WHERE id = '".$membership_row['userid']."' LIMIT 1");
                $prova2 = mysql_fetch_Assoc($prova);
                if($prova2['groupid'] == $membership_row['groupid']) { echo "<div class=\"favourite-group\" title=\"Preferito\"></div>\n"; }
                if($membership_row['member_rank'] > 1 && $grouprow['ownerid'] !== $user_row['id']){ echo "<div class=\"admin-group\" title=\"Admin\"></div>\n"; }
                if($grouprow['ownerid'] == $user_row['id'] && $membership_row['member_rank'] > 1){ echo "<div class=\"owned-group\" title=\"Proprietario\"></div>\n"; }
                echo "<strong>".$grouprow['created']."</strong></p><div class=\"clear\"></div></li>";

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
	new GroupsWidget('".$user_row['id']."', '".$row[0]."');
});
</script>";
		} elseif($subtype == "Profilewidget"){

            $found_profile = true;

            $info = mysql_query("SELECT * FROM users WHERE username = '".$searchname."' OR id = '".$searchname."' LIMIT 1") or die(mysql_error());
            $userdata = mysql_fetch_assoc($info);
            $valid = mysql_num_rows($info);

			if($valid > 0){
                echo "<div class=\"movable widget ProfileWidget\" id=\"widget-".$row[0]."\" style=\" left: ".$row[2]."px; top: ".$row[3]."px; z-index: ".$row[4].";\">
<div class=\"w_skin_".$row[6]."\">
	<div class=\"widget-corner\" ".($edit_mode == true ? "style=\"cursor:move\"" : "")." id=\"widget-".$row[0]."-handle\">
		<div class=\"widget-headline\"><h3>" . $edit . "
<span class=\"header-left\">&nbsp;</span><span class=\"header-middle\">Mio ".strtoupper($site['short'])."</span><span class=\"header-right\">&nbsp;</span></h3>
		</div>
	</div>
	<div class=\"widget-body\">
		<div class=\"widget-content\">
	<div class=\"profile-info\">

		<div class=\"name\" style=\"float: left\">
			<span class=\"name-text\">".$userdata['username']."</span>
		</div>

		<br class=\"clear\" />";

                if($input->IsUserOnline($userdata['id'])){ echo "<img alt=\"online\" src=\"".PATH."web-gallery/images/myhabbo/habbo_online_anim_big.gif\" />"; } else { echo "<img alt=\"offline\" src=\"".PATH."web-gallery/images/myhabbo/habbo_offline_big.gif\" />"; }

                echo "<div class=\"birthday text\">
			Creato il:
		</div>
		<div class=\"birthday date\">
			".date('d-M-Y',$userdata['account_created'])." 
			
		</div>
		<div>";
                $groupbadge = $input->GetUserGroupBadge($userdata['id']);
                $badge = $input->GetUserBadge($userdata['id']);

                if($groupbadge !== false){
                    echo "<a href='".PATH."groups/".$input->GetUserGroup($userdata['id'])."'><img src='".PATH."habbo-imaging/badge.php?badge=".$groupbadge.".gif'></a>";
                }

                if($badge !== false){
                    echo "<img src=\"".$cimagesurl.$badgesurl.$badge.".gif\" /></a>";
                }
                echo "
        </div>
	</div>
	<div class=\"profile-figure\">
			<img alt=\"".$userdata['username']."\" src=\"http://www.habbo.com/habbo-imaging/avatarimage?figure=".$userdata['look']."&size=b&direction=4&head_direction=4&gesture=sml\" />
	</div>";
                if($userdata['motto'] != null){
                    echo "<div class=\"profile-motto\">
			".$input->HoloText($userdata['motto'])."
			<div class=\"clear\"></div>
		</div>";
                }
                if($userdata['id'] != $my_id && $logged_in == true){ ?>
		<div class="profile-friend-request clearfix">
			<a class="new-button" id="add-friend" style="float: left"><b>Aggiungi come Amico</b><i></i></a>
		</div>
	<?php } 
                echo "
    <script type=\"text/javascript\">
		document.observe(\"dom:loaded\", function() {
			new ProfileWidget('".$userdata['id']."', '".$my_id."', {
				headerText: \"Sei Sicuro?\",
				messageText: \"Sei Sicuro Voler aggiungere <strong\>".$userdata['username']."</strong\> ai tuoi amici?\",
				buttonText: \"OK\",
				cancelButtonText: \"Annulla\"
			});
		});
	</script>
		<div class=\"clear\"></div>
		</div>
	</div>
</div></div>";
            }
		} elseif($subtype == "RoomsWidget"){
		 ?>
		<div class="movable widget RoomsWidget" id="widget-<?php echo $row['0']; ?>" style=" left: <?php echo $row['2']; ?>px; top: <?php echo $row['3']; ?>px; z-index: <?php echo $row['4']; ?>;">
<div class="w_skin_<?php echo $row['6']; ?>">
	<div class="widget-corner" <?php echo $edit_mode == true ? "style=\"cursor:move\"" : ""; ?> id="widget-<?php echo $row['0']; ?>-handle">
		<div class="widget-headline"><h3>
<?php echo $edit; ?>
</script>
		<span class="header-left">&nbsp;</span><span class="header-middle">Mie Stanze</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
		<?php 			
            $roomsql = mysql_query("SELECT * FROM rooms WHERE owner = '".$user_row['username']."'");
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
                    if($roomrow['state'] == 'password'){
                        $qwer = "password";
                        $zxcv = "Con password";
                    } elseif($roomrow['state'] == 'open'){
                        $qwer = "open";
                        $zxcv = "Entra in stanza";
                    } elseif($roomrow['state'] == 'locked'){
                        $qwer = "locked";
                        $zxcv = "Chiusa a chiave ";
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
        } elseif($subtype == "GuestbookWidget"){
            $sql = mysql_query("SELECT * FROM cms_guestbook WHERE widget_id = '".$row['0']."' ORDER BY id DESC");
            $count = mysql_num_rows($sql);
            
            $status = "public";
	?>
	<div class="movable widget GuestbookWidget" id="widget-<?php echo $row['0']; ?>" style=" left: <?php echo $row['2']; ?>px; top: <?php echo $row['3']; ?>px; z-index: <?php echo $row['4']; ?>;">
<div class="w_skin_<?php echo $row['6']; ?>">
	<div class="widget-corner" <?php echo $edit_mode == true ? "style=\"cursor:move\"" : ""; ?> id="widget-<?php echo $row['0']; ?>-handle">
		<div class="widget-headline"><h3>
		<?php echo $edit; ?>
		<span class="header-left">&nbsp;</span><span class="header-middle">Mio Guestbook(<span id="guestbook-size"><?php echo $count; ?></span>) <span id="guestbook-type" class="<?php echo $status; ?>"><img src="<?php echo PATH; ?>web-gallery/images/groups/status_exclusive.gif" title="Solo Amici" alt="Solo Amici"/></span></span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
<div id="guestbook-wrapper" class="gb-public">
<ul class="guestbook-entries" id="guestbook-entry-container">
	<?php if($count == 0){ ?>
	<div id="guestbook-empty-notes">Il Tuo Guestbook &egrave; vuoto.</div>
	<?php } else { ?>
			<?php 
              $i = 0;
              while ($row1 = mysql_fetch_assoc($sql)) {
                  $i++;
                  $userrow = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = '".$row1['userid']."' LIMIT 1"));
                  if($my_id == $row1['userid']){
                      $owneronly = "<img src=\"".PATH."web-gallery/images/myhabbo/buttons/delete_entry_button.gif\" id=\"gbentry-delete-".$row1['id']."\" class=\"gbentry-delete\" style=\"cursor:pointer\" alt=\"\"/><br/>";
                  } elseif($user_row['id'] == $my_id) {
                      $owneronly = "<img src=\"".PATH."web-gallery/images/myhabbo/buttons/delete_entry_button.gif\" id=\"gbentry-delete-".$row1['id']."\" class=\"gbentry-delete\" style=\"cursor:pointer\" alt=\"\"/><br/>";
                  } else {
                      $owneronly = "";
                  }
                  if($input->IsUserOnline($row1['userid'])){ $useronline = "online"; } else { $useronline = "offline"; }
                  printf("	<li id=\"guestbook-entry-%s\" class=\"guestbook-entry\">
		<div class=\"guestbook-author\">
			<img src=\"http://www.habbo.com/habbo-imaging/avatarimage?figure=%s&direction=2&head_direction=2&gesture=sml&size=s\" alt=\"%s\" title=\"%s\"/>
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
	<b><span></span>Nuovo Messaggio</b><i></i>
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
        } elseif($subtype == "FriendsWidget"){ 
			if($site['memberships'] == "groups_memberships")
				$sql = mysql_query("SELECT * FROM messenger_friendships WHERE sender = '".$user_row['id']."' OR receiver = '".$user_row['id']."'");
			else
				$sql = mysql_query("SELECT * FROM messenger_friendships WHERE user_one_id = '".$user_row['id']."'");
				
            $count = mysql_num_rows($sql);
	?>
<div class="movable widget FriendsWidget" id="widget-<?php echo $row['0']; ?>" style=" left: <?php echo $row['2']; ?>px; top: <?php echo $row['3']; ?>px; z-index: <?php echo $row['4']; ?>;">
<div class="w_skin_<?php echo $row['6']; ?>">
	<div class="widget-corner" <?php echo $edit_mode == true ? "style=\"cursor:move\"" : ""; ?> id="widget-<?php echo $row['0']; ?>-handle">
		<div class="widget-headline"><h3><?php echo $edit; ?><span class="header-left">&nbsp;</span><span class="header-middle">Miei Amici (<?php echo $count; ?>)</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">

<div id="avatar-list-search">
<input type="text" style="float:left;" id="avatarlist-search-string"/>
<a class="new-button" style="float:left;" id="avatarlist-search-button"><b>Cerca</b><i></i></a>
</div>
<br clear="all"/>

<div id="avatarlist-content">

<?php
            $bypass = true;
            $widgetid = $row['0'];
            include('myhabbo/avatarlist_friendsearchpaging.php');
?>

<script type="text/javascript">
document.observe("dom:loaded", function() {
	window.widget<?php echo $row['0']; ?> = new FriendsWidget('<?php echo $user_row['id']; ?>', '<?php echo $row['0']; ?>');
});
</script>

</div>
		<div class="clear"></div>
		</div>
	</div>
</div>
</div>
<?php
        } elseif($subtype == "BadgesWidget"){
            $sql = mysql_query("SELECT * FROM user_badges WHERE user_id = '".$user_row['id']."' ORDER BY badge_id ASC");
            $count = mysql_num_rows($sql);
	?>
<div class="movable widget BadgesWidget" id="widget-<?php echo $row['0']; ?>" style=" left: <?php echo $row['2']; ?>px; top: <?php echo $row['3']; ?>px; z-index: <?php echo $row['4']; ?>;">
<div class="w_skin_<?php echo $row['6']; ?>">
	<div class="widget-corner" <?php echo $edit_mode == true ? "style=\"cursor:move\"" : ""; ?> id="widget-<?php echo $row['0']; ?>-handle">
		<div class="widget-headline"><h3><?php echo $edit; ?><span class="header-left">&nbsp;</span><span class="header-middle">Distintivi</span><span class="header-right">&nbsp;</span></h3>
		</div>	
	</div>
	<div class="widget-body">
		<div class="widget-content">
    <div id="badgelist-content">
	<?php if($count == 0){
              echo "Non hai nessun distintivo"; 
          } else {
              $bypass1 = true;
              $widgetid = $row['0'];
              include('./myhabbo/badgelist_badgepaging.php');
          } ?>
        <script type="text/javascript">
        document.observe("dom:loaded", function() {
            window.badgesWidget<?php echo $row['0']; ?> = new BadgesWidget('<?php echo $user_row['id']; ?>', '<?php echo $row['0']; ?>');
        });
        </script>
    </div>
		<div class="clear"></div>
		</div>
	</div>

</div>
</div>
	<?php
        }
    }
}
?>
				</div>
			</div>
			<div id="mypage-ad">
    <div class="habblet ">
<div class="ad-container">

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
</div>

</div>

<div id="edit-menu" class="menu">
	<div class="menu-header">
		<div class="menu-exit" id="edit-menu-exit"><img src="<?php echo PATH; ?>web-gallery/images/dialogs/menu-exit.gif" alt="" width="11" height="11" /></div>
		<h3>Modifica</h3>
	</div>
	<div class="menu-body">
		<div class="menu-content">
			<form action="#" onsubmit="return false;">
				<div id="edit-menu-skins">
	<select id="edit-menu-skins-select">
			<option value="1" id="edit-menu-skins-select-defaultskin">Tradizionale</option>
			<option value="6" id="edit-menu-skins-select-goldenskin">Oro</option>
			<option value="3" id="edit-menu-skins-select-metalskin">Metallo</option>
			<option value="5" id="edit-menu-skins-select-notepadskin">Blocco Note</option>
			<option value="2" id="edit-menu-skins-select-speechbubbleskin">Fumettato</option>
			<option value="4" id="edit-menu-skins-select-noteitskin">Post it</option>
			<option value="8" id="edit-menu-skins-select-hc_pillowskin">HC Bling</option>
			<option value="7" id="edit-menu-skins-select-hc_machineskin">HC Scifi</option>
<?php if($user->row['rank'] > 5){ ?>
			<option value="9" id="edit-menu-skins-select-nakedskin">Staff - Trasparente</option>
<?php } ?>
	</select>
				</div>
				<div id="edit-menu-stickie">
					<p>Attenzione  Se Lo Rimuovi verra eliminato permanentemente.</p>
				</div>
				<div id="rating-edit-menu">
					<!--<input type="button" id="ratings-reset-link" name="ratings-reset-link" value="Resetta voti">-->
				</div>
				<div id="highscorelist-edit-menu" style="display:none">
					<select id="highscorelist-game">
						<option value="">Seleziona Gioco</option>
						<option value="1">Battle Ball!</option>
						<option value="2">SnowStorm</option>
						<option value="0">Wobble Squabble</option>
					</select>
				</div>
				<div id="edit-menu-remove-group-warning">
					<p>Questa voce appartiene a un altro utente. Se si rimuove, tornera al suo inventario.</p>
				</div>
				<div id="edit-menu-gb-availability">
					<select id="guestbook-privacy-options">
						<option value="private">Privato</option>
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

<div class="cbb topdialog" id="guestbook-form-dialog">
	<h2 class="title dialog-handle">Modifica GuestBook</h2>
	
	<a class="topdialog-exit" href="#" id="guestbook-form-dialog-exit">X</a>
	<div class="topdialog-body" id="guestbook-form-dialog-body">
<div id="guestbook-form-tab">
<form method="post" id="guestbook-form">
    <p>
        Max 200 Caratteri
        <input type="hidden" name="ownerId" value="<?php echo $user_row['id']; ?>" />
	</p>
	<div>
	    <textarea cols="15" rows="5" name="message" id="guestbook-message"></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("guestbook-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Red"],
            "orange" : ["#fe6301", "Orange"],
            "yellow" : ["#ffce00", "Yellow"],
            "green" : ["#6cc800", "Green"],
            "cyan" : ["#00c6c4", "Cyan"],
            "blue" : ["#0070d7", "Blue"],
            "gray" : ["#828282", "Gray"],
            "black" : ["#000000", "Black"]
        };
        bbcodeToolbar.addColorSelect("Color", colors, true);
    </script>
<!--<div id="linktool">
    <div id="linktool-scope">
        <label for="linktool-query-input">Crea Link</label>
        <input type="radio" name="scope" class="linktool-scope" value="1" checked="checked"/><?php echo $site['short']; ?>
        <input type="radio" name="scope" class="linktool-scope" value="2"/>Stanze
        <input type="radio" name="scope" class="linktool-scope" value="3"/>Gruppi    </div>
    <input id="linktool-query" type="text" name="query" value=""/>
    <a href="#" class="new-button" id="linktool-find"><b>Cerca</b><i></i></a>
    <div class="clear" style="height: 0;"></div>
    <div id="linktool-results" style="display: none">
    </div>
    <script type="text/javascript">
        linkTool = new LinkTool(bbcodeToolbar.textarea);
    </script>
</div>-->
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
	<h2 class="title dialog-handle">Elimina</h2>
	
	<a class="topdialog-exit" href="#" id="guestbook-delete-dialog-exit">X</a>
	<div class="topdialog-body" id="guestbook-delete-dialog-body">
<form method="post" id="guestbook-delete-form">
	<input type="hidden" name="entryId" id="guestbook-delete-id" value="" />
	<p>Vuoi Davvero Eliminare Questo Testo?</p>
	<p>
		<a href="#" id="guestbook-delete-cancel" class="new-button"><b>Annulla</b><i></i></a>
		<a href="#" id="guestbook-delete" class="new-button"><b>Elimina</b><i></i></a>
	</p>
</form>
	</div>
</div>	
					
<script type="text/javascript">
HabboView.run();
</script>

<?php echo $site['analytics']; ?>
</body>
</html>

<?php
} elseif($error){
    $cored = true;
    include('./error.php');
} else {
    $pagename = "Utente Bannato";
    include('templates/subheader.php');
    include('templates/header.php');
?>

<div id="container">
	<div id="content" style="position: relative" class="clearfix">
		<div id="column1" class="column">
			<div class="habblet-container ">
				<div class="cbb clearfix red ">
					<h2 class="title">Utente Bannato</h2>
					<div id="notfound-content" class="box-content">
						<p class="error-text">Siamo spiacenti, ma la pagina che cercate non &egrave; al momento disponibile, Perch&egrave; l'utente &egrave; stato <b>Bannato</b>. Prova pi&ugrave; tardi.</p> <img id="error-image" src="<?php echo PATH; ?>web-gallery/v2/images/error.gif" />
						<p class="error-text">Si prega di utilizzare il tasto 'Indietro' per tornare al punto di partenza.</p>
					</div>
				</div>
			</div>
			<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
		</div>
	</div>

<?php
    include('templates/footer.php');
}
?>
</div>