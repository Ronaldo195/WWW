<?php 

require_once('../core.php'); 
require_once('../includes/session.php'); 

$voucher = $input->FilterText($_POST['voucherCode']); 
$newc=0;
$check = mysql_query("SELECT * FROM vouchers WHERE code = '" . $voucher . "' LIMIT 1") or $newc=1; 

if($newc==1)
	$check = mysql_query("SELECT * FROM credit_vouchers WHERE code = '" . $voucher . "' LIMIT 1") or $newc=1;
	
if(mysql_num_rows($check) > 0){ 
	$tmp = mysql_fetch_assoc($check);
	if($newc == 0){
		$amount = $tmp['credits']; 
		$amount2 = $tmp['pixels']; 
		$resultcode = "green"; 
	
		mysql_query("UPDATE users SET credits = credits + ".$amount.", activity_points = activity_points + ".$amount2." WHERE username = '".$user->row['username']."' LIMIT 1") or die(mysql_error()); 
		mysql_query("DELETE FROM vouchers WHERE code = '".$voucher."' LIMIT 1") or die(mysql_error()); 
		
		if($amount > 0 && $amount2 == 0)
			$result = "Hai ricevuto ".$amount." crediti con successo."; 
		elseif($amount > 0 && $amount2 > 0)
			$result = "Hai ricevuto ".$amount." crediti e ".$amount2." pixel con successo.";
		elseif($amount == 0 && $amount2 > 0)
			$result = "Hai ricevuto ".$amount2." pixel con successo.";
		elseif($amount == 0 && $amount2 == 0)
			$result = "Non hai ricevuto nulla. xD";
		else
			$result = "";
	} else {
		$amount = $tmp['value']; 
		$resultcode = "green"; 
	
		mysql_query("UPDATE users SET credits = credits + ".$amount." WHERE username = '".$user->row['username']."' LIMIT 1") or die(mysql_error()); 
		mysql_query("DELETE FROM credit_vouchers WHERE code = '".$voucher."' LIMIT 1") or die(mysql_error()); 
		
		$result = "Hai ricevuto ".$amount." crediti con successo.";
	}
		$input->MUS("updatecredits", $user->row['id']);
		$input->MUS("updatepixels", $user->row['id']);
		$user->Refresh($user->row['username']);
}else{ 
    $resultcode = "red"; 
    $result = "Il tuo Codice non è stato trovato."; 
}

echo '
<div class="redeem-redeeming">
    <div><input type="text" name="voucherCode" value="" class="redeemcode" size="8" /></div>
    <div class="redeem-redeeming-button"><a href="#" class="new-button green-button redeem-submit exclude"><b><span></span>Converti</b><i></i></a></div>
</div>
<div class="redeem-result">
	<div class="rounded-container">
		<div class="rounded-'.$resultcode.' rounded">
			'.$result.'
		</div>
	</div>
</div>';
?>