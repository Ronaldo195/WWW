<?php
include("../core.php");

$uid = isset($_GET['id']) ? $input->EscapeString($_GET['id']) : '';

if($uid == ''){
	header('Location: ../me');
	exit;
}else{
	if(isset($_SESSION['provider'])){
		if(isset($_SESSION['provider']['profile']['providerName']) && $_SESSION['provider']['profile']['providerName'] == 'Google')
			$id = $_SESSION['provider']['profile']['googleUserId'];
		else if(isset($_SESSION['provider']['profile']['providerName']) && $_SESSION['provider']['profile']['providerName'] == 'Twitter'){
			$id = explode("http://twitter.com/account/profile?user_id=", $_SESSION['provider']['profile']['identifier']);
			$id = $id[1];
		}else if(isset($_SESSION['provider']['id']) && $_SESSION['provider']['id'] > 0)
			$id = $_SESSION['provider']['id'];
	}else
		$id = $user->account['id'];
		
	$sql = mysql_query("SELECT * FROM users WHERE id = ".$uid." AND account = '".$id."' LIMIT 1");
	
	if(mysql_num_rows($sql) > 0){
		$row = mysql_fetch_assoc($sql);
		mysql_query("UPDATE accounts SET current = ".$uid." WHERE id = '".$id."'");
		$user->Refresh($row['username']);
		mysql_query("UPDATE users SET last_online = '".time()."' WHERE id = '".$uid."'") or die(mysql_error());
		header("Location: ../me");
		exit;
	}else
		header("Location: ../me");
}
?>