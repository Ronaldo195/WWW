<?php
include("../core.php");
	
	if(isset($_GET['p']) && $_GET['p'] == '2'){
		$clubro = mysql_query("SELECT * FROM user_subscriptions WHERE user_id = '".$user->row['id']."' LIMIT 1");
		$clubrow = mysql_fetch_assoc($clubro);
		if($clubrow['subscription_id'] == "habbo_club"){
			echo 'Diventa un '.$site['short'].' VIP e scopri di pi&ugrave;!';
		} else if($clubrow['subscription_id'] == "habbo_vip"){
			echo 'Complimenti, sei '.$site['short'].' Vip!';
		} else {
			echo 'HC o VIP? Hc ti da la possibilita\' di scegliere Look Esclusivi, ma VIP ti da qualcosa che nessuno in '.$site['short'].' puo\' darti! :)';
		}
	}else{
		if($logged_in){
			$clubro = mysql_query("SELECT * FROM user_subscriptions WHERE user_id = '".$user->row['id']."' LIMIT 1");
			$clubrow = mysql_fetch_assoc($clubro);
			if(!$input->IsHCMember($user->row['id'])){
				echo "Nessuna iscrizione attiva.";
			}
			if($input->IsHCMember($user->row['id'])){
				echo "Ti restano: " . $input->nicetime(date('d-m-Y',$input->HCDaysLeft($user->row['id']))) . " ".$input->HCType($user->row['id']);
			}
		}
	}
?>