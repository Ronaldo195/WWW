<?php
include('../core.php');
include('../includes/session.php');

// simple check to avoid most direct access
$refer = $input->FilterText($_SERVER['HTTP_REFERER']);
$pos = strrpos($refer, "groups/");
if ($pos === false) { exit; }

$groupid = $input->FilterText($_POST['groupId']);
if(!is_numeric($groupid)){ exit; }

$check = mysql_query("SELECT ownerid FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$isowner = mysql_fetch_array($check);

if($isowner['ownerid'] != $user->row['id']){
    exit;
}

$check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
$valid = mysql_num_rows($check);

if($valid > 0){ $groupdata = mysql_fetch_assoc($check); } else {exit; }

?>
<div id="badge-editor-flash" align="center">
<strong>Installa Flash Player Se Non Vedi Questo Editor</strong>
</div>
<script type="text/javascript" language="JavaScript">
var swfobj = new SWFObject("<?php echo PATH; ?>web-gallery/flash/BadgeEditor.swf", "badgeEditor", "280", "366", "8");
swfobj.addParam("base", "<?php echo PATH; ?>web-gallery/flash/");
swfobj.addParam("bgcolor", "#FFFFFF");
swfobj.addVariable("post_url", "<?php echo PATH; ?>save_group_badge.php");
swfobj.addVariable("__app_key", "Meth0d.org");
swfobj.addVariable("groupId", "<?php echo $groupid; ?>");
swfobj.addVariable("badge_data", "<?php echo $groupdata['badge']; ?>");
swfobj.addVariable("localization_url", "badge_editor.xml");
swfobj.addVariable("xml_url", "badge_data.xml");
swfobj.addParam("allowScriptAccess", "always");
swfobj.write("badge-editor-flash");
</script>