<?php
include('../core.php');
include('../includes/session.php');

$groupid = $_POST['groupId'];
if($input->getContent('forum-enabled') != "1"){ header("Location: index.php"); exit; }

if($groupid > 0){
	$sql = mysql_query("SELECT * FROM groups WHERE id='".$groupid."' LIMIT 1");
	$row = mysql_fetch_assoc($sql);
	$checks = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$groupid."' LIMIT 1");
	$check = mysql_fetch_assoc($checks);

	$rank = mysql_num_rows($checks) > 0 ? $check['member_rank'] : 0;
} else {
	$row['topics'] = 0;
	$checks = '';
}

if(($groupid > 0 && ($row['topics'] == 0) || ($row['topics'] == 1 && mysql_num_rows($checks) > 0) || ($row['topics'] == 2 && $rank == 3)) || $groupid == 0) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">
<tr>
    <td class="post-header-link" valign="top" style="width: 148px;"></td>
    <td class="post-header-name" valign="top"></td>
    <td align="right">
</tr>
<tr>
	<td colspan="3" class="post-list-row-container"><div id="new-topic-preview"></div></td>
</tr>

<tr class="new-topic-entry-label" id="new-topic-entry-label">
	<td class="new-topic-entry-label">Topic:</td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
	    <div class="post-list-content-element"><input type="text" size="50" id="new-topic-name"/></div>
	    </td>
	    </tr>
	    </table>
    </td>
</tr>
<tr class="topic-name-error">
    <td></td>
    <td colspan="2">
        <div id="topic-name-error"></div>
    </td>
</tr>

<tr id="new-post-entry-message" style="display:none;">
	<td class="new-post-entry-label"><div class="new-post-entry-label" id="new-post-entry-label">Post:</div></td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
		<input type="hidden" id="edit-type"/>
		<input type="hidden" id="post-id"/>
        <a href="#" class="preview-post-link" id="topic-form-preview">Anteprima &raquo;</a>
        <input type="hidden" id="spam-message" value="Spam detected!"/>
		<textarea id="post-message" class="new-post-entry-message" rows="5" name="message" ></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("post-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Red"],
            "orange" : ["#fe6301", "Orange"],
            "yellow" : ["#ffce00", "Yellow"],
            "green" : ["#6cc800", "Green"],
            "cyan" : ["#00c6c4", "Cyan"],
            "blue" : ["#0070d7", "Blue"],
            "gray" : ["#828282", "Grey"],
            "black" : ["#000000", "Black"]
        };
        bbcodeToolbar.addColorSelect("Colours", colors, false);
    </script>
	    <br /><br/>
        <a class="new-button red-button cancel-icon" href="<?php echo PATH; ?>discussions/<?php echo $_POST['groupId']; ?>"><b><span></span>Annulla</b><i></i></a>
        <a id="topic-form-save" class="new-button green-button save-icon" href="#"><b><span></span>Salva</b><i></i></a>
        </td>
        </tr>
        </table>
	</td>
</tr>

</table>
<div id="new-post-preview" style="display:none;">
</div>
<?php }
?>