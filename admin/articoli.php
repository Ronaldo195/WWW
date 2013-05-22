<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Articoli";
$page['rank'] = 6;

include("header.php");
?>	
	<script>
	function del(id){
		var sei_sicuro = confirm('Sei sicuro di voler eliminare l\'articolo?');
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
		<h3 class="tabs_involved">Articoli</h3>
		<ul class="tabs">
   			<li></li>
			<li><a href="#tab1" onclick="location.href='?add'">+ Aggiungi Articolo</a></li>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<th>Titolo</th> 
    				<th>Categoria</th> 
    				<th>Creazione</th> 
    				<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$sql = mysql_query("SELECT * FROM cms_news ORDER BY id DESC");
				
				while($row = mysql_fetch_assoc($sql)){
				echo '
				<tr> 
   					<td>'.$row['id'].'</td> 
    				<td>'.$row['title'].'</td> 
    				<td>'.$row['categories'].'</td> 
    				<td>'.date('d F Y', $row['date']).'</td> 
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
		$title  = isset($_POST['title']) ? $_POST['title'] : '';
		$short  = isset($_POST['short']) ? $_POST['short'] : '';
		$story  = isset($_POST['story']) ? $_POST['story'] : '';
		$image  = isset($_POST['image']) ? $input->EscapeString($_POST['image']) : '';
		$images = isset($_POST['images']) ? $_POST['images'] : '';
		$cat    = isset($_POST['category']) ? $input->EscapeString(implode(",",$_POST['category'])) : '';
		$author = isset($_POST['author']) ? $input->EscapeString($_POST['author']) : '';
		
		$imgs = '';
		for($i=0;$i<count($images);$i++){$imgs .= $images[$i] != '' ? $images[$i].',' : '';}
		$images = $input->EscapeString(substr($imgs, 0, -1));
		
		if($title == '' || $short == '' || $story == '' || $image == '' || $author == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("UPDATE cms_news SET title = '".$title."',shortstory = '".$short."',longstory = '".$story."', image = '".$image."', images = '".$images."', categories = '".$cat."', author = '".$author."' WHERE id = ".$id);
			$ok = "L'articolo &egrave; stato modificato correttamente!";
		}
	}
	
	$sql = mysql_query("SELECT * FROM cms_news WHERE id = ".$id) or die();
	
	if(mysql_num_rows($sql) > 0){
		$row = mysql_fetch_assoc($sql);
		
		$images = explode(",", $row['images']);
		$cat = explode(",", $row['categories']);
		
		$events = in_array('Eventi', $cat) ? 'checked' : '';
		$comp = in_array('Competizioni', $cat) ? 'checked' : '';
		$safe = in_array('Sicurezza', $cat) ? 'checked' : '';
	?>
		<script>
		var i = <?php echo (count($images) +1); ?>;
		function addtext(){
			if(i <= 10){
				var text = $("#textadding").html();
				text += '<input name="images[]" type="text" placeholder="Immagine #' + i + '">';
				$("#textadding").html(text);
				i++;
			}else{
				alert('Puoi aggiungere solo 10 immagini!');
			}
		}
		</script>
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
							<label>Titolo*</label>
							<input name="title" type="text" value="<?php echo $row['title']; ?>">
						</fieldset>
						
						<fieldset>
							<label>Riassunto*</label>
							<input name="short" type="text" value="<?php echo $row['shortstory']; ?>">
						</fieldset>
						
						<fieldset>
							<label>Immagine dell'articolo*</label>
							<input name="image" type="text" value="<?php echo $row['image']; ?>" placeholder="Immagine dell'articolo">
						</fieldset>
						
						<fieldset>
							<label>Immagini nell'articolo</label><b><a href="javascript:addtext();">+ AGGIUNGI</a></b>
							<?php for($i=0;$i<count($images);$i++){
							echo '<input name="images[]" type="text" value="'.$images[$i].'" placeholder="Immagine #'.($i+1).'">';
							} ?>
							
							<div id="textadding"></div>
						</fieldset>
						
						<textarea id="art_story" class="ckeditor" cols="80" id="editor1" name="story" rows="10"><?php echo $row['longstory']; ?></textarea>
						
						<fieldset style="width:48%; float:left; margin-right: 3%;">
							<label>Categoria</label>
							<br><br>
							<label><input type="checkbox" name="category[]" value="Eventi" <?php echo $events; ?>> Eventi</label>
							<br><br>
							<label><input type="checkbox" name="category[]" value="Competizioni" <?php echo $comp; ?>> Competizioni</label>
							<br><br>
							<label><input type="checkbox" name="category[]" value="Sicurezza" <?php echo $safe; ?>> Sicurezza</label>
							<br><br>
							<label><input type="checkbox" name="category[]" value=""> Altro</label>
						</fieldset>
						<fieldset style="width:48%; float:left;">
							<label>Autore*</label>
							<select name="author">
								<option value="<?php echo $user->row['username']; ?>">- <?php echo $user->row['username']; ?></option>
								<option value="Lo staff di <?php echo $site['short']; ?>">- Lo staff di <?php echo $site['short']; ?></option>
							</select>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<?php
					if(isset($_GET['edit'])){echo '<input type="submit" name="edit" value="Modifica Articolo" class="alt_btn">';}
					else{echo '<input type="submit" name="add" value="Pubblica Articolo" class="alt_btn">';}
					?>
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
	<?php } }elseif(isset($_GET['add'])){
	
	if(isset($_POST['add'])){
		$title  = isset($_POST['title']) ? $_POST['title'] : '';
		$short  = isset($_POST['short']) ? $_POST['short'] : '';
		$story  = isset($_POST['story']) ? $_POST['story'] : '';
		$image  = isset($_POST['image']) ? $input->EscapeString($_POST['image']) : '';
		$images = isset($_POST['images']) ? $_POST['images'] : '';
		$cat    = isset($_POST['category']) ? $input->EscapeString(implode(",",$_POST['category'])) : '';
		$author = isset($_POST['author']) ? $input->EscapeString($_POST['author']) : '';
		
		$imgs = '';
		for($i=0;$i<count($images);$i++){$imgs .= $images[$i] != '' ? $images[$i].',' : '';}
		$images = $input->EscapeString(substr($imgs, 0, -1));
		
		if($title == '' || $short == '' || $story == '' || $image == '' || $author == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("INSERT INTO cms_news (title,shortstory,longstory,image,images,categories,author,date) VALUES
			('".$title."','".$short."','".$story."','".$image."','".$images."','".$cat."','".$author."','".time()."')");
			$ok = "L'articolo &egrave; stato pubblicato correttamente!";
		}
	}
	
	?>
		<script>
		var i = 2;
		function addtext(){
			if(i <= 10){
				var text = $("#textadding").html();
				text += '<input name="images[]" type="text" placeholder="Immagine #' + i + '">';
				$("#textadding").html(text);
				i++;
			}else{
				alert('Puoi aggiungere solo 10 immagini!');
			}
		}
		</script>
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
							<label>Titolo*</label>
							<input name="title" type="text">
						</fieldset>
						
						<fieldset>
							<label>Riassunto*</label>
							<input name="short" type="text">
						</fieldset>
						
						<fieldset>
							<label>Immagine dell'articolo*</label>
							<input name="image" type="text" placeholder="Immagine dell'articolo">
						</fieldset>
						
						<fieldset>
							<label>Immagini nell'articolo</label><b><a href="javascript:addtext();">+ AGGIUNGI</a></b>
							<input name="images[]" type="text" placeholder="Immagine #1">
							<div id="textadding"></div>
						</fieldset>
						
						<textarea id="art_story" class="ckeditor" cols="80" id="editor1" name="story" rows="10"></textarea>
						
						<fieldset style="width:48%; float:left; margin-right: 3%;">
							<label>Categoria</label>
							<br><br>
							<label><input type="checkbox" name="category[]" value="Eventi"> Eventi</label>
							<br><br>
							<label><input type="checkbox" name="category[]" value="Competizioni"> Competizioni</label>
							<br><br>
							<label><input type="checkbox" name="category[]" value="Sicurezza"> Sicurezza</label>
							<br><br>
							<label><input type="checkbox" name="category[]" value=""> Altro</label>
						</fieldset>
						<fieldset style="width:48%; float:left;">
							<label>Autore*</label>
							<select name="author">
								<option value="<?php echo $user->row['username']; ?>">- <?php echo $user->row['username']; ?></option>
								<option value="Lo staff di <?php echo $site['short']; ?>">- Lo staff di <?php echo $site['short']; ?></option>
							</select>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="add" value="Pubblica Articolo" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
		<?php
		}elseif(isset($_GET['delete'])){
			$id = $input->EscapeString($_GET['delete']);
			mysql_query("DELETE FROM cms_news WHERE id = ".$id) or die();
			echo '<h4 class="alert_success">L\'articolo &egrave; stato eliminato correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
		}
		?>
	</section>
	<br>

</body>

</html>