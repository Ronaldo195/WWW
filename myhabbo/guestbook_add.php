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

include('../core.php');
include('../includes/session.php');

$ownerid = $input->FilterText($_POST['ownerId']);
$widgetid = $input->FilterText($_POST['widgetId']);
$message = $input->FilterText($_POST["message"]);
$sql = mysql_query("SELECT NOW()");
$date = mysql_result($sql, 0);

mysql_query("INSERT INTO cms_guestbook (message,time,widget_id,userid) VALUES ('".$message."','".$date."','".$widgetid."','".$user->row['id']."')");

$row = mysql_fetch_assoc(mysql_query("SELECT * FROM cms_guestbook WHERE userid = '".$user->row['id']."' ORDER BY id DESC LIMIT 1"));
$userrow = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = '".$row['userid']."'"));

?>

	<li id="guestbook-entry-<?php echo $row['id']; ?>" class="guestbook-entry">
		<div class="guestbook-author">
			<img src="http://www.habbo.it/habbo-imaging/avatarimage?figure=<?php echo $userrow['look']; ?>&direction=2&head_direction=2&gesture=sml&size=s" alt="<?php echo $userrow['username'] ?>" title="<?php echo $userrow['username'] ?>"/>
		</div>
			<div class="guestbook-actions">
					<img src="<?php echo PATH; ?>web-gallery/images/myhabbo/buttons/delete_entry_button.gif" id="gbentry-delete-<?php echo $row['id']; ?>" class="gbentry-delete" style="cursor:pointer" alt=""/>
					<br/>
			</div>
		<div class="guestbook-message">
			<div class="online">
				<a href="<?php echo PATH."home/".$user->row['username']; ?>"><?php echo $user->row['username']; ?></a>

			</div>
			<p><?php echo $input->HoloText($row["message"],false,true); ?></p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>
		<div class="guestbook-entry-footer metadata"><?php echo $row['time']; ?></div>
	</li>