<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Codici";
$page['rank'] = 5;

include("header.php");
?>	
	<script>
	function del(id){
		var sei_sicuro = confirm('Sei sicuro di voler eliminare?');
		if (sei_sicuro)
		{
			location.href = '?delete='+id;
		}
	}
	</script>
	<section id="main" class="column">
		<?php if(!isset($_GET['add']) && !isset($_GET['delete'])){ ?>
		
		<article id="articles" class="module width_full">
		<header>
		<h3 class="tabs_involved">Codici</h3>
		<ul class="tabs">
			<li></li>
			<li><a href="#tab1" onclick="location.href='?add'">+ Aggiungi Codice</a></li>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>Codice</th> 
    				<th>Crediti</th> 
    				<th>Pixel</th> 
					<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$err=0;
				$sql = mysql_query("SELECT * FROM vouchers") or $err=1;
				
				if($err==1)
					$sql = mysql_query("SELECT * FROM credit_vouchers");
				while($row = mysql_fetch_assoc($sql)){
					if($err==1){
						$row['credits'] = $row['value'];
						$row['pixels'] = "N/D";
					}
				echo '
				<tr> 
   					<td>'.$row['code'].'</td> 
    				<td>'.$row['credits'].'</td> 
    				<td>'.$row['pixels'].'</td> 
    				<td><a href="javascript:del(\''.$row['code'].'\')"><img src="'.PATH.'admin/images/icn_trash.png"></a></td> 
				</tr>';
				}
			?>
			</tbody> 
			</table>
			</div>
		</div>
		
		</article>
	
	<?php
	}elseif(isset($_GET['add'])){
	
	if(isset($_POST['add'])){
		$code    = isset($_POST['code']) ? $input->EscapeString($_POST['code']) : '';
		$credits = isset($_POST['credits']) ? $input->EscapeString($_POST['credits']) : '';
		$pixels  = isset($_POST['pixels']) ? $input->EscapeString($_POST['pixels']) : '';

		if($code == '' || $credits == '' || $pixels == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			$err=0;
			mysql_query("INSERT INTO vouchers (code,credits,pixels) VALUES ('".$code."','".$credits."','".$pixels."')") or $err=1;
			if($err==1)
				mysql_query("INSERT INTO credit_vouchers (code,value) VALUES ('".$code."','".$credits."')");
			$ok = "Il Codice &egrave; stata pubblicata correttamente!";
		}
	}
	
		if(isset($error))
			echo '<h4 class="alert_error">'.$error.'</h4>';
		else if(isset($ok))
			echo '<h4 class="alert_success">'.$ok.'</h4>';
		?>
		<script>
		function generatepass(plength){
			keylist = "abcdefghijklmnopqrstuvwxyz1234567890";
			temp = '';
			for (i=0; i<plength; i++)
				temp += keylist.charAt(Math.floor(Math.random()*keylist.length));
			return temp;
		}
		function insertpsw(length){
			$("#code").val(generatepass(length));
		}
		</script>
		<article id="newarticle" class="module width_full">
			<form action="" method="post">
			<header><h3>Pubblica un nuovo Articolo</h3></header>
				<div class="module_content">
						<fieldset>
							<label>Codice* <a href="javascript:insertpsw(10);">Genera codice</a></label>
							<input id="code" name="code" type="text">
						</fieldset>
						
						<fieldset>
							<label>Crediti*</label>
							<input name="credits" value="0" type="text">
						</fieldset>
						
						<fieldset>
							<label>Pixel*</label>
							<input name="pixels" value="0" type="text">
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="add" value="Pubblica Codice" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
		<?php
		}elseif(isset($_GET['delete'])){
			$id = $input->EscapeString($_GET['delete']);
			$err=0;
			mysql_query("DELETE FROM vouchers WHERE code = '".$id."'") or $err=1;
			if($err==1)
				mysql_query("DELETE FROM credit_vouchers WHERE code = '".$id."'");
			echo '<h4 class="alert_success">Il Codice &egrave; stato eliminato correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
		}
		?>
	</section>
	<br>

</body>

</html>