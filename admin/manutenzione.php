<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Manutenzione";
$page['rank'] = 7;

include("header.php");

if(isset($_POST['next'])){
	$main = isset($_POST['main']) ? $input->EscapeString($_POST['main']) : '';
	
	if($main == '')
		$error = 'Scegli se chiudere o aprire l\'hotel';
	else{
		mysql_query("UPDATE cms_system SET site_closed = '".$main."'");
		$ok = "Il sito &egrave; stato ".($main == 1 ? "chiuso" : "aperto")." correttamente!";
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
							<label>Attualmente l'hotel &egrave; <?php echo $maintenance == 1 ? "Chiuso" : "Aperto"; ?></label>
							<select name="main">
								<option value="" selected>Scegli...</option>
								<option value="1">Chiudi Hotel</option>
								<option value="0">Apri Hotel</option>
							</select>
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
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>
		<div class="spacer"></div>

	</section>
	<br>

</body>

</html>