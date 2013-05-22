<?php
include('core.php');
include('./includes/session.php');

if($input->HoloText($input->getContent('forum-enabled'), true) !== "1"){ header("Location: index.php"); exit; }

$postId = $input->FilterText($_POST['postId']);
$message = $input->FilterText($_POST['message']);
$topicId = $input->FilterText($_POST['topicId']);
$page = $input->FilterText($_POST['page']);

if(!empty($postId) && is_numeric($postId) && !empty($topicId) && is_numeric($topicId)){
	$check = mysql_query("SELECT * FROM cms_forum_threads WHERE id = '".$topicId."' LIMIT 1") or die(mysql_error());
	$exists = mysql_num_rows($check);
	if($exists > 0){
		$thread = mysql_fetch_assoc($check);
		$check = mysql_query("SELECT * FROM cms_forum_posts WHERE id = '".$postId."' LIMIT 1") or die(mysql_error());
		$exists = mysql_num_rows($check);
		$valid_thread = true;
			if($exists > 0){
				$xpostdata = mysql_fetch_assoc($check);
				if($user->row['rank'] > 5 || $xpostdata['author'] == $user->row['username']){
					mysql_query("UPDATE cms_forum_posts SET edit_author = '".$user->row['username']."', edit_date = '".$date_full."', message = '".$message."' WHERE id = '".$postId."' LIMIT 1") or die(mysql_error());
				} else {
					exit;
				}
			} else {
				exit;
			}
	} else {
		exit;
	}
} else {
	exit;
}

if(empty($topicId) || !is_numeric($topicId)){ "&nbsp;"; exit; }

$posts = $input->mysql_evaluate("SELECT COUNT(*) FROM cms_forum_posts WHERE threadid = '".$topicId."'");
$pages = ceil(($posts + 0) / 10);

if($page > $pages || $page < 1){
	$page = 1;
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

?>
<div id="group-postlist-container">

    <div class="postlist-header clearfix">
                <?php if($topic_open){ ?><a href="#" id="create-post-message" class="create-post-link verify-email">Rispondi</a><?php } ?>
                <input type="hidden" id="email-verfication-ok" value="1"/>
                <?php if($user->row['rank'] > 5){ ?><a href="#" id="edit-topic-settings" class="edit-topic-settings-link">Tool Moderatore &raquo;</a>
                <input type="hidden" id="settings_dialog_header" value="Moderation Tools"/><?php } ?>
        <div class="page-num-list">
	<input type="hidden" id="current-page" value="<?php echo $page; ?>"/>
    Vedi Pagine:
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"".PATH."viewthread?thread=".$topicId."&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	} 
?>
    </div>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">

<?php
// Post view handler & echoer

$query_min = ($page * 10) - 10;

if($query_min < 0){ // Page 1
$query_min = 0;
}

$get_em = mysql_query("SELECT * FROM cms_forum_posts WHERE threadid = '".$topicId."' ORDER BY id ASC LIMIT ".$query_min.", 10") or die(mysql_error());
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
		<a href=\"".PATH."home/".$userdata['username']."\" class=\"post-list-creator-link post-list-creator-info\">".$userdata['username']."</a><br />&nbsp;\n";
            if($input->IsUserOnline($userid)){ echo "<img alt=\"Online\" src=\"./web-gallery/images/myhabbo/habbo_online_anim.gif\" />"; } else { echo "<img alt=\"Offline\" src=\"./web-gallery/images/myhabbo/habbo_offline.gif\" />"; }
		echo "<div class=\"post-list-posts post-list-creator-info\">Messaggi: ".$userdata['postcount']."</div>
		<div class=\"clearfix\">
            <div class=\"post-list-creator-avatar\"><img src=\"http://www.habbo.it/habbo-imaging/avatarimage?figure=".$userdata['look']."&size=b&direction=2&head_direction=2&gesture=sml\" alt=\"".$userdata['username']."\" /></div><div class=\"post-list-group-badge\">";
		if($input->GetUserGroup($userid) !== false){       
                	echo "<a href=\"".PATH."groups/".$input->GetUserGroup($userid)."\"><img src=\"./habbo-imaging/badge.php?badge=".$input->GetUserGroupBadge($userid)."\" /></a>";
		}
            echo "</div>
		<div class=\"post-list-avatar-badge\">";
		if($input->GetUserBadge($userid) !== false){
			echo "<img src=\"".$cimagesurl.$badgesurl.$input->GetUserBadge($userid).".gif\" />";
		}
		echo "</div>
        </div>
        <div class=\"post-list-motto post-list-creator-info\">".$input->HoloText($userdata['motto'])."</div>
	</td>
	<td class=\"post-list-message\" valign=\"top\" colspan=\"2\">
                <a href=\"#\" class=\"quote-post-link verify-email\" id=\"quote-post-".$row['id']."-message\">Quote</a>";
			if($user->row['rank'] > 5 || $user->row['id'] == $userdata['id']){
	                echo "<a href=\"#\" class=\"edit-post-link verify-email\" id=\"edit-post-".$row['id']."-message\">Modifica</a>";
			}
        echo "<span class=\"post-list-message-header\">"; 
	if($dynamic_id !== 1 || $page > 1){
		echo "RE: ";
 	}
	echo $input->HoloText($thread['title'])."</span><br />
        <span class=\"post-list-message-time\">".$row['edit_date']."</span>
        <div class=\"post-list-report-element\">";
			if($user->row['rank'] > 5 || $user->row['id'] == $userdata['id']){
                		echo "<a href=\"#\" id=\"delete-post-".$row['id']."\" class=\"delete-button delete-post\"></a>";
			}
			if($user->row['id'] !== $userdata['id']){
				echo "        <div class=\"post-list-report-element\">\n                <a href=\"./iot/go.php?do=report&post=".$row['id']."&page=".$page."\" class=\"create-report-button\" title=\"Report this post\" target=\"habbohelp\" onclick=\"openOrFocusHelp(this); return false\"></a>\n        </div>";
			}
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
		<?php if($topic_open){ ?><a href="#" id="create-post-message-lower" class="create-post-link verify-email">Pubblica Risposta</a><?php } ?>
    </a><div class="page-num-list">
    Vedi Pagina:
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"".PATH."viewthread?thread=".$topicId."&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	} 
?>
    </div>
</div>
</div>

<a id='page-bottom'>

<script type="text/javascript" language="JavaScript">
L10N.put("myhabbo.discussion.error.topic_name_empty", "Devi specificare l'argomento!");
Discussions.initialize("DiscussionBoard", "<?php echo PATH; ?>viewthread?thread=<?php echo $topicId; ?>", "<?php echo $topicId; ?>");
</script>
