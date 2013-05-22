<?php
include("core.php");
$adduser = $input->EscapeString($_GET['adduser']);

if($adduser == 1){
	$date = mktime($_GET['month'], $_GET['day'], $_GET['year']);
	mysql_query("INSERT INTO users (username, password, mail, credits, look, motto, account_created, last_online, ip_last, ip_reg, home_room) VALUES ('".$_GET['username']."', '".$input->HoloHash($_GET['password'])."', '".$_GET['email']."', '".$site['credits']."', 'hd-180-2.lg-285-81.hr-828-42.sh-290-90.ch-215-92', 'Benvenuto!', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['REMOTE_ADDR']."', '0')");
	
	$user_id = mysql_insert_id(); 
	mysql_query("INSERT INTO accounts (id, provider, email, name, password, current) VALUES ('".$user_id."_id', 'id', '".$_GET['email']."', '".$_GET['username']."', '".$input->HoloHash($_GET['password'])."', '".$user_id."')");
	mysql_query("INSERT INTO user_stats (id, RoomVisits, OnlineTime, Respect, RespectGiven, GiftsGiven, GiftsReceived, DailyRespectPoints, DailyPetRespectPoints) VALUES ('".$user_id."', 0, 0, 0, 0, 0, 0, 3, 3)"); 
    mysql_query("INSERT INTO user_info (user_id, bans, cautions, reg_timestamp, login_timestamp, cfhs, cfhs_abusive) VALUES ('".$user_id."', '0', '0', UNIX_TIMESTAMP(), '0', '0', '0')"); 
	mysql_query("INSERT INTO cms_homes_stickers (userid, x, y, z, data, type, subtype, skin, groupid, var) VALUES (".$user_id.", '20', '19', '302', '', '2', '1', 'defaultskin', -1, NULL)");

	mysql_query("UPDATE users SET account = '".$user_id."_id' WHERE id = ".$user_id);
			
	$user->login($_GET['email'], $input->HoloHash($_GET['password']), "off", true);
	echo $user->login_error;
}
?>