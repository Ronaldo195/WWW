<?php
$allow_guests = true;

include('core.php');
include('includes/session.php');

if($input->HoloText($input->getContent('forum-enabled'), true) !== "1"){ header("Location: index.php"); exit; }

$threadid = isset($_GET['thread']) ? $input->FilterText($_GET['thread']) : 0;
$group = mysql_query("SELECT forumid FROM cms_forum_posts WHERE threadid='".$threadid."'");

if(!empty($threadid) && is_numeric($threadid)){
	$check = mysql_query("SELECT * FROM cms_forum_threads WHERE id = '".$threadid."' LIMIT 1") or die(mysql_error());
	$exists = mysql_num_rows($check);
	if($exists > 0){
		$thread = mysql_fetch_assoc($check);
		$valid_thread = true;
		mysql_query("UPDATE cms_forum_threads SET views = views + 1 WHERE id = '".$threadid."' LIMIT 1") or die(mysql_error());
	} else {
		header("Location: ".PATH."discussions/".mysql_result($group,0));
		exit;
	}
} else {
 //header("Location: me.php");
	exit;
}

$pagename = "Community";
$pageid = "forum";
$body_id = "viewmode";
$page = isset($_GET['page']) ? $input->FilterText($_GET['page']) : 0;

$posts = $input->mysql_evaluate("SELECT COUNT(*) FROM cms_forum_posts WHERE threadid = '".$threadid."'");
$pages = ceil(($posts + 0) / 10);

if($page > $pages || $page < 1){
	$page = 1;
}

$info = mysql_fetch_assoc($group);
if(isset($info['forumid']) && is_numeric($info['forumid'])){

	$check = mysql_query("SELECT * FROM groups WHERE id = '".$info['forumid']."' LIMIT 1");
	$exists = mysql_num_rows($check);

	if($exists > 0){

		$groupid = $info['forumid'];

		$error = false;
		$groupdata = mysql_fetch_assoc($check);
		
		if(!isset($groupdata['name'])){
			if($groupdata['Typee'] == 0)
				$groupdata['locked'] = "open";
			else if($groupdata['Typee'] == 1)
				$groupdata['locked'] = "locked";
			else if($groupdata['Typee'] == 2)
				$groupdata['locked'] = "closed";
			
			$groupdata['id'] = $groupdata['Id'];
			$groupdata['name'] = $groupdata['Name'];
			$groupdata['ownerid'] = $groupdata['OwnerId'];
		}
		
		$pagename = $groupdata['name'];
		$ownerid = $groupdata['ownerid'];

		$members = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE groupid = '".$groupid."'");

		$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1");
		$is_member = mysql_num_rows($check);

		if($is_member > 0 && $logged_in){

			$is_member = true;
			$my_membership = mysql_fetch_assoc($check);
			$member_rank = $my_membership['member_rank'];

		} else {

			$is_member = false;

		}

	} else {

		$error = true;

	}

} else {

	$error = true;

}

$key = 0;

if(isset($_GET['sp']) && $_GET['sp'] == "JumpToLast"){
header("Location: ".PATH."viewthread?thread=".$threadid."&page=".$pages."#page-bottom");
exit;
}

switch($thread['type']){
	case 1: $topic_open = true; break;
	case 2: $topic_open = false; break;
	case 3: $topic_open = true; break;
	case 4: $topic_open = false; break;
}

if(!isset($topic_open)){
	exit;
}

include('templates/subheader.php');
include('templates/header.php');

$edit_mode = isset($edit_mode) ? $edit_mode : false;
?>
<script type="text/javascript">
var habboReqPaths = "<?php echo PATH; ?>discussions/<?php echo $groupid; ?>";
</script>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="mypage-wrapper" class="cbb blue">
<div class="box-tabs-container box-tabs-left clearfix">
	<?php
	$sql = mysql_query("SELECT * FROM cms_forum_posts WHERE threadid='".$_GET['thread']."'");
	$row = mysql_fetch_assoc($sql);
	if($row['forumid'] != 0) {
	 if(isset($member_rank) && $member_rank > 1 && !$edit_mode){ ?><a href="<?php echo PATH."groups/".$groupid; ?>&do=edit" class="new-button dark-button edit-icon" style="float:left"><b><span></span>Modifica</b><i></i></a><?php } ?>
	<?php if(!$edit_mode){ echo isset($viewtools) ? $viewtools : ""; }
	} ?>
	<div class="myhabbo-view-tools">
	</div>
    <h2 class="page-owner">
	<?php
	$sql = mysql_query("SELECT forumid FROM cms_forum_posts WHERE threadid='".$_GET['thread']."'");
	$row = mysql_fetch_assoc($sql);
	if($row['forumid'] != 0) {
 echo $input->HoloText($groupdata['name']); ?>&nbsp;<?php
 if($groupdata['locked'] == "closed"){ ?><img src='<?php echo PATH; ?>web-gallery/images/status_closed_big.gif' alt='Closed Group' title='Gruppo Chiuso'><?php } ?>
<?php if($groupdata['locked'] == "locked"){ ?><img src='<?php echo PATH; ?>web-gallery/images/status_exclusive_big.gif' alt='Moderated Group' title='Gruppo Moderatori'><?php } ?></h2>
<?php }else{ ?>
    	Forum Discussione
	<?php } ?>
    </h2>
    <ul class="box-tabs">
		<?php if($row['forumid'] != 0) { ?>
		<li><a href="<?php echo PATH; ?>groups/<?php echo $groupid; ?>">Home Gruppo</a><span class="tab-spacer"></span></li>
        <li class="selected"><a href="<?php echo PATH; ?>discussions/<?php echo $groupid; ?>">Forum Discussione</a><span class="tab-spacer"></span></li>
		<?php }else{ ?>
		<li class="selected"><a href="<?php echo PATH; ?>forum"><?php echo $site['short']; ?> Forum</a><span class="tab-spacer"></span></li>
		<?php } ?>
    </ul>
</div>
	<div id="mypage-content">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content-1col">
            <tr>
                <td valign="top" style="width: 750px;" class="habboPage-col rightmost">
                    <div id="discussionbox">
<div id="group-postlist-container">

    <div class="postlist-header clearfix">
				<?php
				$sql = mysql_query("SELECT * FROM groups WHERE id='".$row['forumid']."' LIMIT 1");
				$row = mysql_fetch_assoc($sql);
				$asdf = "";
				$zxcv = "";
				if($row['forum'] == 0) {
					$asdf = "<a href=\"#\" id=\"create-post-message\" class=\"create-post-link verify-email\">Pubblica Risposta</a>";
					$zxcv = "<a href=\"#\" class=\"quote-post-link verify-email\" id=\"quote-post-".$row['id']."-message\">Cita</a>";
				}elseif($row['forum'] == 1) {
					if(!isset($row['id']))
						$grid = $row['Id'];
					else
						$grid = $row['id'];
					$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$grid."' LIMIT 1");
					if(mysql_num_rows($check) > 0) { 
						$asdf = "<a href=\"#\" id=\"create-post-message\" class=\"create-post-link verify-email\">Pubblica Risposta</a>";
						$zxcv = "<a href=\"#\" class=\"quote-post-link verify-email\" id=\"quote-post-".$grid."-message\">Cita</a>";
					}
				}/*elseif($row['topics'] == 2) {
					$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$row['id']."' AND member_rank='2' LIMIT 1");
					if(mysql_num_rows($check) > 0) { 
						$asdf = "<a href=\"#\" id=\"create-post-message\" class=\"create-post-link verify-email\">Pubblica Risposta</a>";
						$zxcv = "<a href=\"#\" class=\"quote-post-link verify-email\" id=\"quote-post-".$row['id']."-message\">Cita</a>";
					}
				}*/
				
				?>
                <?php if($topic_open && $logged_in){ ?><?php echo $asdf ?><?php } elseif($logged_in) { ?><span class="topic-closed"><img src="./web-gallery/images/groups/status_closed.gif" title="Closed Thread"> Discussione chiusa</span><?php } ?>
                <input type="hidden" id="email-verfication-ok" value="1"/>
				<?php
				$groupid = 0;
				$hid = $groupid > 0 ? mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$groupid."' AND member_rank='2' LIMIT 1") : '';
				if($hid != '' && mysql_num_rows($hid) > 0) { ?><a href="#" id="edit-topic-settings" class="edit-topic-settings-link">Modifica il topic &raquo;</a>
                <input type="hidden" id="settings_dialog_header" value="Modifica impostazioni tema"/>
				<?php
				}elseif($user->row['rank'] > 5){ ?><a href="#" id="edit-topic-settings" class="edit-topic-settings-link">Modifica il topic &raquo;</a>
                <input type="hidden" id="settings_dialog_header" value="Modifica impostazioni tema"/><?php } ?>
        <div class="page-num-list">
	<input type="hidden" id="current-page" value="<?php echo $page; ?>"/>
    Visualizza pagina:
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"".PATH."viewthread?thread=".$threadid."&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	} 
?>
    </div>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">

<?php
// Post view handler & echoer

$query_min = ($page * 10) - 10;

if($query_min < 0){ // Pagina 1
$query_min = 0;
}

$get_em = mysql_query("SELECT * FROM cms_forum_posts WHERE threadid = '".$threadid."' ORDER BY id ASC LIMIT ".$query_min.", 10") or die(mysql_error());
$dynamic_id = 0;

while($row = mysql_fetch_assoc($get_em)){

	$dynamic_id++;

	if($input->IsEven($dynamic_id)){
		$oddeven = "odd";
	} else {
		$oddeven = "even";
	}

	$userquery = mysql_query("SELECT * FROM users WHERE username = '".$row['author']."' LIMIT 1");
	$userdata = mysql_fetch_assoc($userquery);

	$userid = $userdata['id'];

	echo "<tr class=\"post-list-index-".$oddeven."\">
	<a id='post-".$row['id']."'>
	<td class=\"post-list-row-container\">
		&nbsp;\n";
            if($input->IsUserOnline($userid)){ echo "<img alt=\"Online\" src=\"./web-gallery/images/myhabbo/habbo_online_anim.gif\" />"; } else { echo "<img alt=\"Offline\" src=\"./web-gallery/images/myhabbo/habbo_offline.gif\" />"; }
		echo "<a href=\"".PATH."home/".$userdata['username']."\" class=\"post-list-creator-link post-list-creator-info\">".$userdata['username']."</a><div class=\"post-list-posts post-list-creator-info\">Messaggi: ".$userdata['postcount']."</div>
		<div class=\"clearfix\">
            <div class=\"post-list-creator-avatar\"><img src=\"http://www.habbo.it/habbo-imaging/avatarimage?figure=".$userdata['look']."&size=b&direction=2&head_direction=2&gesture=sml\" alt=\"".$userdata['username']."\" /></div><div class=\"post-list-group-badge\">";
		if($input->GetUserGroup($userid) != false){       
                	echo "<a href=\"".PATH."groups/".$input->GetUserGroup($userid)."\"><img src='".PATH."habbo-imaging/badge.php?badge=".$input->GetUserGroupBadge($userid).".gif' /></a>";
		}
            echo "</div>
		<div class=\"post-list-avatar-badge\">";
		if($input->GetUserBadge($userid) !== false){
			echo "<img src=\"".$cimagesurl.$badgesurl.$input->GetUserBadge($userid).".gif\" />";
		}
		echo "</div>
        </div>
        <div class=\"post-list-motto post-list-creator-info\">".trim($input->HoloText($userdata['motto']))."</div>
	</td>
	<td class=\"post-list-message\" valign=\"top\" colspan=\"2\">";
			if($topic_open == true && $logged_in){
echo "                ".$zxcv;
			}
			if($user->row['rank'] > 5 || $user->row['id'] == $userdata['id'] && $logged_in){
	                echo "<a href=\"#\" class=\"edit-post-link verify-email\" id=\"edit-post-".$row['id']."-message\">Modifica</a>";
			}
        echo "<span class=\"post-list-message-header\">"; 
	if($dynamic_id !== 1 || (isset($pagina) && $pagina > 1)){
		echo "RE: ";
 	}
	echo $input->HoloText($thread['title'],false,false,true)."</span><br />
        <span class=\"post-list-message-time\">".$row['edit_date']."</span>
        <div class=\"post-list-report-element\">";
			if($user->row['rank'] > 5 || $user->row['id'] == $userdata['id'] && $logged_in){
                		echo "<a href=\"#\" id=\"delete-post-".$row['id']."\" class=\"delete-button delete-post\"></a>";
			}
			/*if($user->row['id'] != $userdata['id'] && $logged_in){
				echo "        <div class=\"post-list-report-element\">\n                <a href=\"./iot/go.php?do=report&post=".$row['id']."&page=".$page."\" class=\"create-report-button\" title=\"Report this post\" target=\"habbohelp\" onclick=\"openOrFocusHelp(this); return false\"></a>\n        </div>";
			}*/
echo "        </div>";

		if(!empty($row['edit_date']) && !empty($row['edit_author'])){
		echo "\n<br /><br /><font size='1'><strong>Tema modificato</strong></font>";
		}

echo "        <div class=\"post-list-content-element\">";

            echo $input->bbcode_format(trim(nl2br($input->HoloText($row['message']))))."
                <input type=\"hidden\" id=\"".$row['id']."-message\" value=\"".$input->HoloText($row['message'])."\" />
        </div>
        <div>
        </div>
	</td>
</tr>";
}

?>

<tr id="new-post-entry-message" style="display:none;">
	<td class="new-post-entry-label"><div class="new-post-entry-label" id="new-post-entry-label">Messaggio:</div></td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
		<input type="hidden" id="edit-type"/>
		<input type="hidden" id="post-id"/>
        <a href="#" class="preview-post-link" id="post-form-preview">Anteprima &raquo;</a>
        <input type="hidden" id="spam-message" value="Spam-alarm!"/>
		<textarea id="post-message" class="new-post-entry-message" rows="5" name="message" ></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("post-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Rosso"],
            "orange" : ["#fe6301", "Arancione"],
            "yellow" : ["#ffce00", "Giallo"],
            "green" : ["#6cc800", "Verde"],
            "cyan" : ["#00c6c4", "Azzurro"],
            "blue" : ["#0070d7", "Blu"],
            "gray" : ["#828282", "Grigio"],
            "black" : ["#000000", "Nero"]
        };
        bbcodeToolbar.addColorSelect("Colori", colors, false);
    </script>
	    <br /><br />
        <a id="post-form-cancel" class="new-button red-button cancel-icon" href="#"><b><span></span>Annulla</b><i></i></a>
        <a id="post-form-save" class="new-button green-button save-icon" href="#"><b><span></span>Salva</b><i></i></a>
        </td>
        </tr>
        </table>
	</td>
</tr></table>
<div id="new-post-preview" style="display:none;">
</div>

    <div class="postlist-footer clearfix">
		<?php if($topic_open && $logged_in){ ?><?php echo $asdf ?></a><?php } elseif($logged_in){ ?><span class="topic-closed"><img src="./web-gallery/images/groups/status_closed.gif" title="Closed Thread"> Discussione chiusa</span><?php } else { echo "</a>Devi effettuare l'accesso per visualizzare/postare I post del forum."; } ?>
    </a><div class="page-num-list">
   Visualizza pagina:
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"".PATH."viewthread?thread=".$threadid."&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	} 
?>
    </div>
</div>
</div>

<a id='page-bottom'>

<script type="text/javascript" language="JavaScript">
L10N.put("myhabbo.discussion.error.topic_name_empty", "Devi specificare l'argomento!");
Discussions.initialize("DiscussionBoard", "forum.php", "<?php echo $threadid; ?>");
</script>
                    </div>
					
                </td>
                <td style="width: 4px;"></td>
                <td valign="top" style="width: 164px;">
    <div class="habblet ">
	<?php $incolumn = 0; include("templates/ads.php"); ?>
    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">
	Event.observe(window, "load", observeAnim);
	document.observe("dom:loaded", initDraggableDialogs);
</script>
    </div>
<div id="footer">
	<p><a href="index.php" target="_self">Homepage</a> | <a href="./disclaimer.php" target="_self">Termini di servizio </a> | <a href="./privacy.php" target="_self">Privacy Policy </a></p>
	<?php /*@@* DO NOT EDIT OR REMOVE THE LINE BELOW WHATSOEVER! *@@*/ ?>
	<p>Powered by HoloCMS &copy 2008 Meth0d.<br />HABBO is a registered trademark of Sulake Corporation. All rights reserved to their respective owner(s).</p>
	<?php /*@@* DO NOT EDIT OR REMOVE THE LINE ABOVE WHATSOEVER! *@@*/ ?>
</div></div>

</div>

	 
<div id="group-tools" class="bottom-bubble">
	<div class="bottom-bubble-t"><div></div></div>
	<div class="bottom-bubble-c">
<h3>Cambia Gruppo</h3>

<ul>
	<li><a href="/groups/actions/startEditingSession/55918" id="group-tools-style">roflcopter</a></li>
	<li><a href="#" id="group-tools-settings">e</a></li>
	<li><a href="#" id="group-tools-badge">Spegni</a></li>
	<li><a href="#" id="group-tools-members">Limite</a></li>
</ul>

	</div>
	<div class="bottom-bubble-b"><div></div></div>
</div>

<div class="cbb topdialog black" id="dialog-group-settings">
	
	<div class="box-tabs-container">
<ul class="box-tabs">
	<li class="selected" id="group-settings-link-group"><a href="#">Impostazioni Gruppo</a><span class="tab-spacer"></span></li>
	<li id="group-settings-link-forum"><a href="#">Forum Impostazioni</a><span class="tab-spacer"></span></li>
	<li id="group-settings-link-room"><a href="#">Impostazioni Stanze</a><span class="tab-spacer"></span></li>
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
</script><div class="cbb topdialog" id="postentry-verifyemail-dialog">
	<h2 class="title dialog-handle">Verifica</h2>
	
	<a class="topdialog-exit" href="#" id="postentry-verifyemail-dialog-exit">X</a>
	<div class="topdialog-body" id="postentry-verifyemail-dialog-body">
	<p>Si prega di verificare la vostra email prima di postare.</p>
	<p class="clearfix">
		<a href="#" id="postentry-verifyemail-ok" class="new-button"><b>Annulla</b><i></i></a>
	</p>
	</div>
</div>	
<div class="cbb topdialog" id="postentry-delete-dialog">
	<h2 class="title dialog-handle">Elimina post</h2>
	
	<a class="topdialog-exit" href="#" id="postentry-delete-dialog-exit">X</a>
	<div class="topdialog-body" id="postentry-delete-dialog-body">
<form method="post" id="postentry-delete-form">
	<input type="hidden" name="entryId" id="postentry-delete-id" value="" />
	<p>Sei sicuro di voler eliminare questo messaggio?</p>
	<p class="clearfix">
		<a href="#" id="postentry-delete-cancel" class="new-button"><b>Annulla</b><i></i></a>
		<a href="#" id="postentry-delete" class="new-button"><b>Avanti</b><i></i></a>
	</p>
</form>
	</div>
</div>	
					
<script type="text/javascript">
HabboView.run();
</script>

</body>
</html>