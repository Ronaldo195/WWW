<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Impostazioni generali";
$page['rank'] = 7;

include("header.php");

if(isset($_POST['next'])){
	$name = isset($_POST['name']) ? $input->EscapeString($_POST['name']) : '';
	$short = isset($_POST['short']) ? $input->EscapeString($_POST['short']) : '';
	$credits = isset($_POST['credits']) ? $input->EscapeString($_POST['credits']) : '';
	$chat = isset($_POST['chat']) ? $input->EscapeString($_POST['chat']) : '';
	$forum = isset($_POST['forum']) ? $input->EscapeString($_POST['forum']) : '';
	$analytics = isset($_POST['analytics']) ? $_POST['analytics'] : '';
	
	
	if($name == '' || $short == '' || $credits == '')
		$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
	else{
		mysql_query("UPDATE cms_system SET sitename = '".$name."',shortname = '".$short."',start_credits = '".$credits."',chat = '".$chat."',forum = '".$forum."',analytics = '".$analytics."'");
		$configsql = mysql_query($core->select1()) or die(mysql_error()); 
		$config = mysql_fetch_assoc($configsql); 
		$site['name'] = $config['sitename'];
		$site['short'] = $config['shortname'];
		$site['credits'] = $config['start_credits'];
		$site['chat'] = $config['chat'];
		$site['forum'] = $config['forum'];
		$site['analytics'] = $input->HoloText($config['analytics'], true)."\n";
		$ok = "Le modifiche sono state salvate correttamente!";
	}
}
?>	
	<section id="main" class="column">
		
		<?php
		if(isset($error))
			echo '<h4 class="alert_error">'.$error.'</h4>';
		else if(isset($ok))
			echo '<h4 class="alert_success">'.$ok.'</h4>';
		?>
		
		<article class="module width_full">
			<form action="" method="post">
			<header><h3>Manutenzione</h3></header>
				<div class="module_content">
						<fieldset>
							<label>Nome hotel* (completo)</label>
							<input type="text" name="name" value="<?php echo $site['name']; ?>">
						</fieldset>
						<fieldset>
							<label>Nome hotel* (corto)</label>
							<input type="text" name="short" value="<?php echo $site['short']; ?>">
						</fieldset>
						<fieldset>
							<label>Crediti iniziali*</label>
							<input type="text" name="credits" value="<?php echo $site['credits']; ?>">
						</fieldset>
						<fieldset>
							<label>Chat</label>
							<select name="chat">
								<option value="1" <?php echo $site['chat'] == '1' ? 'selected' : ''; ?>>Abilitato</option>
								<option value="0" <?php echo $site['chat'] == '0' ? 'selected' : ''; ?>>Disabilitato</option>
							</select>
						</fieldset>
						<fieldset>
							<label>Forum</label>
							<select name="forum">
								<option value="1" <?php echo $site['forum'] == '1' ? 'selected' : ''; ?>>Abilitato</option>
								<option value="0" <?php echo $site['forum'] == '0' ? 'selected' : ''; ?>>Disabilitato</option>
							</select>
						</fieldset>
						<fieldset>
							<label style="width:500px">Codice Analytics (verr&agrave; visualizzato in tutte le pagine)</label>
							<textarea name="analytics" rows="10"><?php echo $site['analytics']; ?></textarea>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="next" value="Salva modifiche" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>

	</section>
	<br>

</body>

</html>