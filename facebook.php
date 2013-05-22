<?php
include('core.php');

if(!isset($_COOKIE['fbhb_val_'.APP_ID]))
	header("Location: index?error=2");

require 'facebook-sdk/src/facebook.php';
  
  $config = array();
  $config['appId'] = APP_ID;
  $config['secret'] = APP_SECRET;
  $config['fileUpload'] = false; // optional

  $facebook = new Facebook($config);
  $facebook->setAccessToken($_COOKIE['fbhb_val_'.APP_ID]);
  
  $fb = $facebook->getUser();
if ($fb) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	$_SESSION['provider'] = $user_profile;
	
	$query = mysql_query("SELECT * FROM accounts WHERE id = '".$user_profile['id']."' AND provider = 'Facebook' LIMIT 1");
		
	if(mysql_num_rows($query) > 0){
		$account = mysql_fetch_assoc($query);
		$user->login($account['email'], $account['password'], "off", false);
		exit;
	}else{
		setcookie("fbhb_val_".APP_ID, "", time()-60*60*24*100, "/");
		header("location: fb");
		exit;
	}
  }
  catch (FacebookApiException $e) {
    $user = null;
	header("Location: index?error=2");
  }
}else{
	header("Location: index?error=2");
}

?>