<?php
require_once('../core.php');
require_once('../includes/session.php');

$option = $input->HoloText($_POST['optionNumber']);

switch($option){
	case 1: $price = 100; $months = 2678400; $club = "Club"; break;
	case 2: $price = 300; $months = 8035200; $club = "Club"; break;
	case 3: $price = 150; $months = 2678400; $club = "VIP"; break;
	case 4: $price = 400; $months = 8035200; $club = "VIP"; break;
}

if($user->row['credits'] < $price){
	$msg = "Non hai abbastanza crediti per completare l'acquisto di sottoscrizione.";
} else {
	$error = 0;
	
	if($option == 1 || $option == 2){
		if($input->GiveHC($user->row['id'], $months) == "vip")
			$error = 1;
	}else if($option == 3 || $option == 4){
		$input->GiveVIP($user->row['id'], $months);
	}

	$user->Refresh($user->row['username']);
	if($error > 0){
		$msg = "Errore! Non puoi acquistare ".$site['short']." Club mentre fai parte del ".$site['short']." VIP";
	} else {
		$credits = ($user->row['credits'] - $price);
		mysql_query("UPDATE users SET credits = '".$credits."' WHERE id = ".$user->row['id']);
		$input->MUS("updatevip", $user->row['id']);
		$input->MUS("updatecredits", $user->row['id']);
		$msg = "Congratulazioni! Hai acquistato con successo ".$site['short']." ".$club."!";
	}
}
?>
<div id="hc_confirm_box">

    <img src="<?php echo PATH; ?>/web-gallery/images/piccolo_happy.gif" alt="" align="left" style="margin:10px;" />
<p><b>Sottoscritto</b></p>
<p><?php echo $msg; ?></p>

<p>
<a href="#" class="new-button" onclick="habboclub.closeSubscriptionWindow(); return false;">
<b>OK</b><i></i></a>
</p>

</div>

<div class="clear"></div>