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

$allow_guests = false;

include('../core.php');
include('../includes/session.php');

session_start();
if($_GET['name'] != NULL)
{
	$username = $input->FilterText($_GET['name']);
	$email = $input->FilterText($user->account['email']);
	$userq = mysql_query("SELECT * FROM users WHERE username = '".$username."' LIMIT 1");
	if(mysql_num_rows($userq) > 0)
	{
		$banq = mysql_query("SELECT * FROM bans WHERE bantype = 'user' AND value = '".$username."' AND expire > ".time()."");
		if(mysql_fetch_array($banq) > 0)
		{
			session_destroy();
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=".$url."/choose_avatar.php?do=ban\">";
			
			die;
		}
		$userq = mysql_query("SELECT * FROM users WHERE username ='$username'");
		$user = mysql_fetch_array($userq);
		if($user['mail'] == $email)
		{
			$_SESSION['user'] = $username;
			$query = mysql_query("UPDATE users SET last_online = UNIX_TIMESTAMP(), ip_last = '".$_SERVER['REMOTE_ADDR']."' WHERE username = '".$username."'");
			
echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=".$url."/welcome.php\">";

		}
		else
	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=".$url."/choose_avatar.php?do=username\">";	

	}
	else
echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=".$url."/choose_avatar.php?do=username\">";	
}
else	
echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=".$url."/choose_avatar.php?do=username\">";	
?>