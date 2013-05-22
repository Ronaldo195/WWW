<?php
require_once "../core.php";
$friend = isset($_POST['friendId']) ? $input->EscapeString($_POST['friendId']) : 0;
$page = isset($_POST['pageSize']) ? $input->EscapeString($_POST['pageSize']) : 30;

if(isset($_POST['friendList']) && is_array($_POST['friendList']))
	foreach($_POST['friendList'] as $friend){
		mysql_query('DELETE FROM messenger_friendships WHERE user_one_id = '.$friend.' AND user_two_id = '.$user->row['id']);
		mysql_query('DELETE FROM messenger_friendships WHERE user_one_id = '.$user->row['id'].' AND user_two_id = '.$friend);
	}

if($friend > 0){
	mysql_query('DELETE FROM messenger_friendships WHERE user_one_id = '.$friend.' AND user_two_id = '.$user->row['id']);
	mysql_query('DELETE FROM messenger_friendships WHERE user_one_id = '.$user->row['id'].' AND user_two_id = '.$friend);
}

include('ajax_friendmanagement.php');

?>