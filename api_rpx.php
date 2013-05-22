<?php
include("core.php");
ob_start();

$engage_pro = false;

$token = $_POST['token'];

if(strlen($token) == 40) {

  $post_data = array('token'  => $token,
                     'apiKey' => RPX_API_KEY,
                     'format' => 'json',
                     'extended' => 'true'); //Extended is not available to Basic.

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/auth_info');
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_FAILONERROR, true);
  $result = curl_exec($curl);
  curl_close($curl);

  $auth_info = json_decode($result, true);
  if ($auth_info['stat'] == 'ok') {
	$_SESSION['provider'] = $auth_info;
	
	if($auth_info['profile']['providerName'] == 'Google')
		$query = mysql_query("SELECT * FROM accounts WHERE id = '".$auth_info['profile']['googleUserId']."' AND provider = 'Google' LIMIT 1");
		
	if(mysql_num_rows($query) > 0){
		$account = mysql_fetch_assoc($query);
		$user->login($account['email'], $account['password'], "off", false);
	}else{
		header("Location: rpx.php");
	}
  } else {
    header("Location: index.php");
  }
}else{
  header("Location: index.php");
}
?>