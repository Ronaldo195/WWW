<?php
include('../core.php');
include('../includes/session.php');

// simple check to avoid most direct access
$refer = $input->FilterText($_SERVER['HTTP_REFERER']);
$pos = strrpos($refer, "groups/");
if ($pos === false) { exit; }

$groupid = $input->FilterText($_POST['groupId']);
if(!is_numeric($groupid)){ exit; }

$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$valid = mysql_num_rows($check);

if($valid > 0){
	$groupdata = mysql_fetch_assoc($check);
	
	$checking = isset($groupdata['name']) ? $newcr=0 : $newcr=1;
	
	if($newcr == 1){
		if($groupdata['Typee'] == 0)
			$groupdata['locked'] = "open";
		else if($groupdata['Typee'] == 1)
			$groupdata['locked'] = "locked";
		else if($groupdata['Typee'] == 2)
			$groupdata['locked'] = "closed";
			
			$groupdata['name'] = $groupdata['Name'];
			$groupdata['created'] = $groupdata['DateCreated'];
			$groupdata['roomid'] = $groupdata['RoomId'];
			$groupdata['desc'] = $groupdata['Description'];
			$groupdata['badge'] = $groupdata['Image'];
			$ownerid = $groupdata['OwnerId'];
		} else {
			$groupdata['created'] = date('d/m/Y',$groupdata['created']);
			$ownerid = $groupdata['ownerid'];
		}
} else {
	exit;
}

if($ownerid !== $user->row['id']){ exit; }
?>
<form action="#" method="post" id="group-settings-form">

<div id="group-settings">
<div id="group-settings-data" class="group-settings-pane">
    <div id="group-logo">
        <img src="<?php echo PATH; ?>habbo-imaging/badge.php?badge=<?php echo $groupdata['badge']; ?>.gif" />
	</div>
	<div id="group-identity-area">
        <div id="group-name-area">
            <div id="group_name_message_error" class="error"></div>
            <label for="group_name" id="group_name_text">Modifica Nome Gruppo:</label>
            <input type="text" name="group_name" id="group_name" onKeyUp="GroupUtils.validateGroupElements('group_name', 25, 'Maximum Group name length reached');" value="<?php echo $input->HoloText($groupdata['name']); ?>"/><br />
        </div>

        <div id="group-url-area">
            <div id="group_url_message_error" class="error"></div>
                <label for="group_url" id="group_url_text"></label><br/>
                <?php /* <span id="group_url_text"><a href="group_profile.php?id=<?php echo $groupid; ?>ddsa">group_profile.php?id=<?php echo $groupid; ?></a></span><br/> */ ?>
                <input type="hidden" name="group_url" id="group_url" value="system"/>
                <input type="hidden" name="group_url_edited" id="group_url_edited" value="0"/>
        </div>
    </div>
    

	<div id="group-description-area">
	    <div id="group_description_message_error" class="error"></div>
	    <label for="group_description" id="description_text">Modifica Testo:</label>
	    <span id="description_chars_left">
	        <label for="characters_left">Caratteri Rimanenti:</label>
	        <input id="group_description-counter" type="text" value="<?php echo 255 - strlen($input->HoloText($groupdata['desc'])); ?>" size="3" readonly="readonly" class="amount" />
	    </span>
	    <textarea name="group_description" id="group_description" onKeyUp="GroupUtils.validateGroupElements('group_description', 255, 'Description limit reached');"><?php echo $input->HoloText($groupdata['desc']); ?></textarea>
	</div>

</div>

<div id="group-settings-type" class="group-settings-pane group-settings-selection">
    <label for="group_type">Modifica Tipologia Gruppo:</label>
        <input type="radio" name="group_type" id="group_type" value="open" <?php if($groupdata['locked'] == "open"){ echo "checked=\"checked\""; } ?> />
        <div class="description">
            <div class="group-type-normal">Regolare</div>
            <p>Possono Entrare Massimo 500 Persone.</p>
        </div>
        <input type="radio" name="group_type" id="group_type" value="locked" <?php if($groupdata['locked'] == "locked"){ echo "checked=\"checked\""; } ?> />
        <div class="description">
            <div class="group-type-exclusive">Esclusivo</div>
            <p>Gli Administratori Decidono Chi Entrare.</p>
        </div>
        <input type="radio" name="group_type" id="group_type" value="closed" <?php if($groupdata['locked'] == "closed"){ echo "checked=\"checked\""; } ?> />
        <div class="description">
            <div class="group-type-private">Privato</div>
            <p>Nessuno Puo Entrare.</p>
        </div>

    <input type="hidden" id="initial_group_type" value="<?php echo $groupdata['locked']; ?>">
</div>
</div>


<div id="forum-settings" style="display: none;">
<div id="forum-settings-type" class="group-settings-pane group-settings-selection">
    <label for="forum_type">Modifica Forum Gruppo:</label>
        <input type="radio" name="forum_type" id="forum_type" value="0" <?php if($groupdata['forum'] == 0) { echo 'checked="checked"'; } ?> />
        <div class="description">
            Pubblico<br />
            <p>Tutti Possono Postare Messaggi.</p>
        </div>
        <input type="radio" name="forum_type" id="forum_type" value="1" <?php if($groupdata['forum'] == 1) { echo 'checked="checked"'; } ?> />
        <div class="description">
            Privato<br />
            <p>Solo i Membri Del Gruppo Possono Postare Messaggi.</p>
        </div>
</div>

<div id="forum-settings-topics" class="group-settings-pane group-settings-selection">
    <label for="new_topic_permission">Modifica Permessi Nuova Discussione:</label>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="2" <?php if($groupdata['topics'] == 2) { echo 'checked="checked"'; } ?> />
        <div class="description">
            Admin<br />
            <p>Solo gli admin Del Gruppo possono Postare Discussioni.</p>
        </div>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="1" <?php if($groupdata['topics'] == 1) { echo 'checked="checked"'; } ?> />
        <div class="description">
            Membri<br />
            <p>Solo i Membri Del Gruppo Possono Postare Discussioni.</p>
        </div>
        <input type="radio" name="new_topic_permission" id="new_topic_permission" value="0" <?php if($groupdata['topics'] == 0) { echo 'checked="checked"'; } ?> />
        <div class="description">
            Tutti<br />
            <p>Tutti Gli Utenti Possono Postare Discussioni</p>
        </div>
</div>
</div>


<div id="room-settings" style="display: none;">
<?php 
$sql = mysql_query("SELECT * FROM rooms WHERE owner = '".$user->row['username']."'");

$groupdetails = mysql_query("SELECT * FROM groups WHERE id='".$groupid."' LIMIT 1");
$group = mysql_fetch_assoc($groupdetails);
?>
<label>Seleziona la stanza del tuo gruppo:</label>

<div id="room-settings-id" class="group-settings-pane-wide group-settings-selection">
    <ul><li><input type="radio" name="roomId" value=" " <?php if($group['roomid'] == 0) { echo "CHECKED"; } ?> /><div>Nessuna stanza</div></li>
	<?php
	$i = 0;
	while($row = mysql_fetch_assoc($sql)) {
		$i++;

        if($input->IsEven($i)){
            $even = "odd";
        } else {
            $even = "even";
        }
		?>
    	<li class="<?php echo $even; ?>">
    		<input type="radio" name="roomId" value="<?php echo $row['id']; ?>" <?php if($group['roomid'] == $row['id']) { echo "CHECKED"; } ?> /><div>
				<?php echo $input->HoloText($row['caption']); if($row['caption'] == ""){ ?>&nbsp;<?php } ?><br />
				<span class="room-description"><?php echo $input->HoloText($row['description']); if($row['description'] == "") { ?>&nbsp;<?php } ?></span>
			</div>
    	</li>
		<?php } ?>
    </ul>
</div>

</div>

<div id="group-button-area">
     <a href="javascript:showGroupSettingsConfirmation('<?php echo $groupid; ?>');" id="group-settings-update-button" class="new-button" onclick="showGroupSettingsConfirmation('<?php echo $groupid; ?>');">
        <b>Salva Cambiamenti</b><i></i>
    </a>
    <a id="group-delete-button" href="#" class="new-button red-button" onclick="openGroupActionDialog('groups_confirm_delete_group.php', 'groups_delete_group.php', null , '<?php echo $groupid; ?>', null);">
        <b>Elimina Gruppo</b><i></i>
    </a>
    <a href="#" id="group-settings-close-button" class="new-button" onclick="closeGroupSettings(); return false;"><b>Cancella</b><i></i></a>
</div>
</form>

<div class="clear"></div>

<script type="text/javascript" language="JavaScript">
    L10N.put("group.settings.title.text", "Modifica Gruppo");
	L10N.put("group.settings.group_type_change_warning.undefined", "Sicuro di voler cambiare lo stato del Gruppo?");
    L10N.put("group.settings.group_type_change_warning.normal", "Sei Sicuro Di Voler Passare il Gruppo Ad <strong\>Normale</strong\>?");
    L10N.put("group.settings.group_type_change_warning.exclusive", "Sei Sicuro Di Voler Passare il Gruppo Ad <strong \>Esclusivo</strong\>?");
    L10N.put("group.settings.group_type_change_warning.closed", "Sei Sicuro Di Voler Passare il Gruppo Ad  <strong\>Privato</strong\>?");
    L10N.put("group.settings.group_type_change_warning.large", "Sei Sicuro Di Voler Passare il Gruppo Ad <strong\>Illimitato</strong\>? Se Continui Non Potrai Cambiarlo Successivamente!");
    L10N.put("myhabbo.groups.confirmation_ok", "OK");
    L10N.put("myhabbo.groups.confirmation_cancel", "Cancel");
    switchGroupSettingsTab(null, "group");
</script>