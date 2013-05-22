<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Pubblicit&agrave;";
$page['rank'] = 7;

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
		<?php if(!isset($_GET['edit']) && !isset($_GET['add']) && !isset($_GET['delete'])){ ?>
		
		<article id="articles" class="module width_full">
		<header>
		<h3 class="tabs_involved">Pubblicit&agrave;</h3>
		<ul class="tabs">
   			<li></li>
			<li><a href="#tab1" onclick="location.href='?add'">+ Aggiungi Pubblicit&agrave;</a></li>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<th>Nome</th> 
    				<th>Stato</th> 
    				<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$sql = mysql_query("SELECT * FROM cms_banners ORDER BY id DESC");
				
				while($row = mysql_fetch_assoc($sql)){
				echo '
				<tr> 
   					<td>'.$row['id'].'</td> 
    				<td>'.$row['name'].'</td> 
    				<td>'.($row['status'] == 0 ? 'Disabilitato' : 'Abilitato').'</td> 
    				<td><a href="?edit='.$row['id'].'"><img src="'.PATH.'admin/images/icn_edit.png"></a>&nbsp;&nbsp;&nbsp;
					<a href="javascript:del('.$row['id'].')"><img src="'.PATH.'admin/images/icn_trash.png"></a></td> 
				</tr>';
				}
			?>
			</tbody> 
			</table>
			</div>
			
		</div>
		
		</article>
	
	<?php
	}elseif(isset($_GET['edit'])){
	$id = isset($_GET['edit']) ? $input->EscapeString($_GET['edit']) : '';
	
	if(isset($_POST['edit'])){
		$name   = isset($_POST['name']) ? $input->EscapeString($_POST['name']) : '';
		$status = isset($_POST['status']) ? $_POST['status'] : '';
		$pos    = isset($_POST['pos']) ? $_POST['pos'] : '';
		$html   = isset($_POST['html']) ? $_POST['html'] : '';
		$html   = strpos($html, "'") ? addslashes($html) : $html;
		
		if($name == '' || $status == '' || $pos == '' || $html == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("UPDATE cms_banners SET name = '".$name."',status = '".$status."',pos = '".$pos."',html = '".$html."' WHERE id = ".$id);
			$ok = "La pubblicit&agrave; &egrave; stata modificata correttamente!";
		}
	}
	
	$sql = mysql_query("SELECT * FROM cms_banners WHERE id = ".$id) or die();
	
	if(mysql_num_rows($sql) > 0){
		$row = mysql_fetch_assoc($sql);
	
		if(isset($error))
			echo '<h4 class="alert_error">'.$error.'</h4>';
		else if(isset($ok))
			echo '<h4 class="alert_success">'.$ok.'</h4>';
		?>
		<article id="newarticle" class="module width_full">
			<form action="" method="post">
			<header><h3>Aggiungi Pubblicit&agrave;</h3></header>
				<div class="module_content">
						<fieldset>
							<label>Nome*</label>
							<input name="name" type="text" value="<?php echo $row['name']; ?>">
						</fieldset>
						
						<fieldset>
							<label>Stato*</label>
							<select name="status">
								<option value="1" <?php echo $row['status'] == 1 ? 'selected' : ''; ?>>Abilitato</option>
								<option value="0" <?php echo $row['status'] == 0 ? 'selected' : ''; ?>>Disabilitato</option>
							</select>
						</fieldset>
						
						<fieldset>
							<label>Posizione*</label>
							<select name="pos">
								<option value="1" <?php echo $row['pos'] == 1 ? 'selected' : ''; ?>>In colonna</option>
								<option value="0" <?php echo $row['pos'] == 0 ? 'selected' : ''; ?>>Laterale</option>
							</select>
						</fieldset>
						
						<fieldset>
							<label>HTML*</label>
							<textarea cols="80" id="editor1" name="html" rows="10"><?php echo $row['html']; ?></textarea>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="edit" value="Modifica Pubblicit&agrave;" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
	<?php } }elseif(isset($_GET['add'])){
	
	if(isset($_POST['add'])){
		$name   = isset($_POST['name']) ? $input->EscapeString($_POST['name']) : '';
		$status = isset($_POST['status']) ? $_POST['status'] : '';
		$html   = isset($_POST['html']) ? $_POST['html'] : '';
		$pos    = isset($_POST['pos']) ? $_POST['pos'] : '';
		$html   = strpos($html, "'") ? addslashes($html) : $html;
		
		if($name == '' || $status == '' || $pos == '' || $html == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("INSERT INTO cms_banners (name,status,pos,html) VALUES ('".$name."','".$status."','".$pos."','".$html."')");
			$ok = "La Pubblicit&agrave; &egrave; stata pubblicata correttamente!";
		}
	}
	
		if(isset($error))
			echo '<h4 class="alert_error">'.$error.'</h4>';
		else if(isset($ok))
			echo '<h4 class="alert_success">'.$ok.'</h4>';
		?>
		<article id="newarticle" class="module width_full">
			<form action="" method="post">
			<header><h3>Aggiungi Pubblicit&agrave;</h3></header>
				<div class="module_content">
						<fieldset>
							<label>Nome*</label>
							<input name="name" type="text">
						</fieldset>
						
						<fieldset>
							<label>Stato*</label>
							<select name="status">
								<option value="1">Abilitato</option>
								<option value="0">Disabilitato</option>
							</select>
						</fieldset>
						
						<fieldset>
							<label>Posizione*</label>
							<select name="pos">
								<option value="1">In colonna</option>
								<option value="0">Laterale</option>
							</select>
						</fieldset>
						
						<fieldset>
							<label>HTML*</label>
							<textarea cols="80" id="editor1" name="html" rows="10"></textarea>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="add" value="Pubblica Pubblicit&agrave;" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
		<?php
		}elseif(isset($_GET['delete'])){
			$id = $input->EscapeString($_GET['delete']);
			mysql_query("DELETE FROM cms_banners WHERE id = ".$id) or die();
			echo '<h4 class="alert_success">La Pubblicit&agrave; &egrave; stata eliminata correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
		}
		?>
	</section>
	<br>

</body>

</html>