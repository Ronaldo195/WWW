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
$message = $input->HoloText($_POST["message"],false,true); 

$row = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = '".$user->row['id']."' LIMIT 1"));
?>

<ul class="guestbook-entries">
	<li id="guestbook-entry--1" class="guestbook-entry">
		<div class="guestbook-author">
			<img src="http://www.habbo.it/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&direction=2&head_direction=2&gesture=sml&size=s" alt="<?php echo $row['username'] ?>" title="<?php echo $row['username'] ?>"/>
		</div>
		<div class="guestbook-message">
			<div class="online">
				<a href="<?php echo PATH."home/".$user->row['username']; ?>"><?php echo $user->row['username']; ?></a>
			</div>
			<p><?php echo $message; ?></p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>
		<div class="guestbook-entry-footer metadata"></div>
	</li>
</ul>

<div class="guestbook-toolbar clearfix">
<a href="#" class="new-button" id="guestbook-form-continue"><b>Continua le modifiche</b><i></i></a>
<a href="#" class="new-button" id="guestbook-form-post"><b>Pubblica messaggio</b><i></i></a>	
</div>