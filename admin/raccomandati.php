<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Raccomandati";
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
		<h3 class="tabs_involved">Raccomandati</h3>
		<ul class="tabs">
   			<li><a href="#tab1">Gruppi</a></li>
			<li><a href="#tab2">Stanze</a></li>
			<li><a href="#tab1" onclick="location.href='?add'">+ Aggiungi Raccomandato</a></li>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<th>Nome</th> 
    				<th>Descrizione</th> 
    				<th>Creazione</th> 
					<th>Distintivo</th>
    				<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$sql = mysql_query("SELECT * FROM cms_recommended WHERE type = 'group' ORDER BY id DESC");
				
				while($row = mysql_fetch_assoc($sql)){
				$rows = mysql_fetch_assoc(mysql_query("SELECT * FROM groups WHERE id = ".$row['rec_id']));
				
				if(!isset($rows['name'])){
					$rows['id'] = $rows['Id'];
					$rows['name'] = $rows['Name'];
					$rows['badge'] = $rows['Image'];
					$rows['desc'] = $rows['Description'];
					$rows['created'] = $rows['DateCreated'];
				} else {
					$rows['created'] = date('d F Y', $rows['created']);
				}
				echo '
				<tr> 
   					<td>'.$rows['id'].'</td> 
    				<td>'.$rows['name'].'</td> 
    				<td>'.$rows['desc'].'</td> 
    				<td>'.$rows['created'].'</td> 
					<td><img src="'.PATH.'habbo-imaging/badge.php?badge='.$rows['badge'].'"></td>
    				<td><a href="javascript:del('.$rows['id'].')"><img src="'.PATH.'admin/images/icn_trash.png"></a></td> 
				</tr>';
				}
			?>
			</tbody> 
			</table>
			</div>
			
			<div id="tab2" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<th>Nome</th> 
    				<th>Autore</th> 
    				<th>Descrizione</th> 
    				<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$sql = mysql_query("SELECT * FROM cms_recommended WHERE type = 'room' ORDER BY id DESC");
				
				while($row = mysql_fetch_assoc($sql)){
				$rows = mysql_fetch_assoc(mysql_query("SELECT * FROM rooms WHERE id = ".$row['rec_id']));
				echo '
				<tr> 
   					<td>'.$rows['id'].'</td> 
    				<td>'.$rows['caption'].'</td> 
    				<td>'.$rows['owner'].'</td> 
    				<td>'.$rows['description'].'</td> 
    				<td><a href="javascript:del('.$rows['id'].')"><img src="'.PATH.'admin/images/icn_trash.png"></a></td> 
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
		$id  = isset($_POST['id']) ? $input->EscapeString($_POST['id']) : '';
		$type  = isset($_POST['type']) ?  $input->EscapeString($_POST['type']) : '';

		if($id == '' || $type == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("INSERT INTO cms_recommended (rec_id,type) VALUES (".$id.",'".$type."')");
			$ok = "La Raccomandata &egrave; stata pubblicata correttamente!";
		}
	}
	
	?>
		<?php
		if(isset($error))
			echo '<h4 class="alert_error">'.$error.'</h4>';
		else if(isset($ok))
			echo '<h4 class="alert_success">'.$ok.'</h4>';
		?>
		<article id="newarticle" class="module width_full">
			<form action="" method="post">
			<header><h3>Pubblica un nuovo Articolo</h3></header>
				<div class="module_content">
						<fieldset>
							<label>ID Stanza/Gruppo*</label>
							<input name="id" type="text">
						</fieldset>
						
						<fieldset>
							<label>Tipo raccomandato*</label>
							<select name="type">
								<option value="group">Gruppo</option>
								<option value="room">Stanza</option>
							</select>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="add" value="Pubblica Raccomandato" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
		<?php
		}elseif(isset($_GET['delete'])){
			$id = $input->EscapeString($_GET['delete']);
			mysql_query("DELETE FROM cms_recommended WHERE rec_id = ".$id) or die();
			echo '<h4 class="alert_success">La Raccomandata &egrave; stata eliminata correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
		}
		?>
	</section>
	<br>

</body>

</html>