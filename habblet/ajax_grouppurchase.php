<?php

include('../core.php');

if(!$user){ echo "<p>\nEffettua l'accesso prima.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Ok</b><i></i></a>\n</p>"; exit; }

$do = isset($_GET['do']) ? $input->FilterText($_GET['do']) : "";
$my_row = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id = '".$user->row['id']."'"));
if($my_row['rank'] < 1)
{
die ("<p id=\"purchase-result-error\">L'acquisto Del gruppo e fallito a causa di un errore.</p>\n<div id=\"purchase-group-errors\">\n<p>\nIl tuo rank &egrave; troppo basso! Sfigato!<br />\n</p>\n</div>\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Ok</b><i></i></a>\n</p>\n<div class=\"clear\"></div>");
}
	// Make sure the user meets the requirements to buy a group. If not, this part
	// should cut off the script.
	
	if($input->getContent('allow-group-purchase') !== "1"){

			echo "<p id=\"purchase-result-error\">L'acquisto Del gruppo e fallito a causa di un errore.</p>\n<div id=\"purchase-group-errors\">\n<p>\nL'acquisto del gruppo e stato momentaneamente disattivato dallo staff riprova piu tardi .<br />\n</p>\n</div>\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Ok</b><i></i></a>\n</p>\n<div class=\"clear\"></div>"; exit;

	} elseif($user->row['credits'] < 20){

			echo "<p id=\"purchase-result-error\">L'acquisto Del gruppo e fallito a causa di un errore.</p>\n<div id=\"purchase-group-errors\">\n<p>\nTu Non Hai Abbastanza Crediti. </a><br />\n</p>\n</div>\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Ok</b><i></i></a>\n</p>\n<div class=\"clear\"></div>"; exit;

	} else {

			$groups_owned = $input->mysql_evaluate("SELECT COUNT(*) FROM groups WHERE ownerid = '".$user->row['id']."' LIMIT 10");

			if($groups_owned > 50){
				echo "<p id=\"purchase-result-error\">L'acquisto Del gruppo e fallito a causa di un errore.</p>\n<div id=\"purchase-group-errors\">\n<p>\nHai Raggiungo Il Massimo Numero Di Gruppi per utente.<br />\n</p>\n</div>\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Ok</b><i></i></a>\n</p>\n<div class=\"clear\"></div>"; exit;
			}

	}


	// The buy part. If the script has not been cut off yet, we should be ready to go.

	if(empty($do) || $do !== "purchase_confirmation"){

		echo "<p>\n<img src='".PATH."habbo-imaging/badge.php?badge=b0503Xs09114s05013s05015.gif' border='0' align='left'>Completa il Form Qua Sotto Per Avere il tuo gruppo, Costa <b>20</b> Crediti.\n</p>\n\n<p>\n<b>Nome Gruppo</b><br /><input type='text' name='name' id='group_name' value='' length='10' maxlength='25'>\n</p>\n\n<p>\n<b>Descrizione Gruppo</b><br />\n<textarea name='description' id='group_description' maxlength='200'></textarea>\n</p>\n\n<p>\nPotrai Modificare Le Impostazioni Del Gruppo Una Volta Creato.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.confirm(); return false;\"><b>Compra</b><i></i></a>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Cancella</b><i></i></a>\n</p>"; exit;

	} elseif($do == "purchase_confirmation"){

		$group_name = trim($input->FilterText($_POST['name']));
		$group_desc = trim($input->FilterText($_POST['description']));

		if(empty($group_name) || empty($group_desc)){

			echo "<p>\nPerfavore Completa tutti i Campi!\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>Indietro</b><i></i></a>\n</p>"; exit;

		} else {

			if(strlen($group_name > 25) && !is_numeric($group_name)){

				echo "<p>\nIl Nome del gruppo che hai scelto e troppo lungo.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>Indietro</b><i></i></a>\n</p>"; exit;

			} elseif(strlen($group_desc > 200) && !is_numeric($group_desc)){

				echo "<p>\nLa Descrizione Del gruppo e troppo Lunga.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>Indietro</b><i></i></a>\n</p>"; exit;

			} else {

				$check = mysql_query("SELECT id FROM groups WHERE name = '".$group_name."' LIMIT 1") or die(mysql_error());
				$already_exists = mysql_num_rows($check);

				if($already_exists > 0){

					echo "<p>\nIl Nome del gruppo esiste gia.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); GroupPurchase.open(); return false;\"><b>Indietro</b><i></i></a>\n</p>";

				} else {

					$orname = $group_name;
					$group_name = $input->FilterText($orname);
					$group_desc = $input->FilterText($group_desc);

					mysql_query("INSERT INTO groups (`name`, `desc`, `badge`, `ownerid`, `created`) VALUES ('".$group_name."','".$group_desc."','b0503Xs09114s05013s05015','".$user->row['id']."','".time()."')") or die(mysql_error());
					$group_id = mysql_insert_id();
					
					mysql_query("INSERT INTO cms_homes_stickers (userid, x, y, z, data, type, subtype, skin, groupid, var) VALUES (-1, '18', '16', '82', '', '2', '1', 'defaultskin', ".$group_id.", NULL)");
					mysql_query("INSERT INTO ".$site['memberships']." (userid,groupid,member_rank) VALUES ('".$user->row['id']."','".$group_id."','3')") or die(mysql_error());
					mysql_query("UPDATE users SET credits = credits - 20 WHERE id = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
					
					$input->MUS("updatecredits", $user->row['id']);

					echo "<p>\n<b>Gruppo Comprato</b><br /><br /><img src='".PATH."habbo-imaging/badge.php?badge=b0503Xs09114s05013s05015.gif' border='0' align='left'>Congratulazioni ora sei il proprietario del <b>".$input->HoloText($orname)."</b>.<br /><br />Clicca <a href='".PATH."groups/".$group_id."'>qua</a> Per Andare nel tuo gruppo\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>Chiudi</b><i></i></a>\n</p>";

				}

			}

		}

	} else {

		echo "<p>\nC'e stato un errore riprova piu tardi.\n</p>\n\n<p>\n<a href=\"#\" class=\"new-button\" onclick=\"GroupPurchase.close(); return false;\"><b>OK</b><i></i></a>\n</p>";

	}

?>



