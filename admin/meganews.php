<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Meganews";
$page['rank'] = 6;

include("header.php");
?>	
	<script>
	function del(id){
		var sei_sicuro = confirm('Sei sicuro di voler eliminare la news?');
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
		<h3 class="tabs_involved">Meganews</h3>
		<ul class="tabs">
   			<li></li>
			<li><a href="#tab1" onclick="location.href='?add'">+ Aggiungi Meganews</a></li>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<th>Titolo</th> 
    				<th>Autore</th> 
    				<th>Creazione</th> 
    				<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$sql = mysql_query("SELECT * FROM cms_news_slider ORDER BY id DESC");
				
				while($row = mysql_fetch_assoc($sql)){
				echo '
				<tr> 
   					<td>'.$row['id'].'</td> 
    				<td>'.$row['title'].'</td> 
    				<td>'.$row['author'].'</td> 
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
		$image  = isset($_POST['image']) ? $input->EscapeString($_POST['image']) : '';
		$button['enable'] = isset($_POST['btn_enable']) ? 1 : 0;
		$button['title'] = isset($_POST['btn_title']) ? $input->EscapeString($_POST['btn_title']) : '';
		$button['link'] = isset($_POST['btn_link']) ? $input->EscapeString($_POST['btn_link']) : '';
		$author = $user->row['username'];
		
		if($title == '' || $short == '' || $image == '' || $author == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("UPDATE cms_news_slider SET title = '".$title."',shortstory = '".$short."', image = '".$image."',button_enable = '".$button['enable']."',link_button = '".$button['link']."',button_title = '".$button['title']."',author = '".$author."' WHERE id = ".$id);
			$ok = "La news &egrave; stata modificata correttamente!";
		}
	}
	
	$sql = mysql_query("SELECT * FROM cms_news_slider WHERE id = ".$id) or die();
	
	if(mysql_num_rows($sql) > 0){
		$row = mysql_fetch_assoc($sql);
	?>
		<script>
		function addtext(){
			var text = $("#textadding").html();
			var check = $("#btn_enable").attr('checked');
			
			if(check == true)
				text = '<input name="btn_title" type="text" placeholder="Titolo buttone"><input name="btn_link" type="text" placeholder="Link buttone">';
			else
				text = '';
				
			$("#textadding").html(text);
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
							<label>Immagine della news*</label>
							<input name="image" type="text" value="<?php echo $row['image']; ?>" placeholder="Immagine dell'articolo">
						</fieldset>
						
						<fieldset>
							<label>Buttone</label>
							<br><br><label><input id="btn_enable" name="btn_enable" type="checkbox" onclick="addtext();" <?php echo $row['button_enable'] == 1 ? 'checked' : ''; ?>> Abilita buttone</label>
							<div id="textadding">
							<?php
							if($row['button_enable'] == 1)
								echo '<input name="btn_title" type="text" value="'.$row['button_title'].'" placeholder="Titolo buttone">
								<input name="btn_link" type="text" value="'.$row['link_button'].'" placeholder="Link buttone">';
							?>
							</div>
						</fieldset>
						
						<textarea id="art_story" class="ckeditor" cols="80" id="editor1" name="short" rows="10"><?php echo $row['shortstory']; ?></textarea>
						
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="edit" value="Modifica Meganews" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
	<?php } }elseif(isset($_GET['add'])){
	
	if(isset($_POST['add'])){
		$title  = isset($_POST['title']) ? $_POST['title'] : '';
		$short  = isset($_POST['short']) ? $_POST['short'] : '';
		$image  = isset($_POST['image']) ? $input->EscapeString($_POST['image']) : '';
		$button['enable'] = isset($_POST['btn_enable']) ? 1 : 0;
		$button['title'] = isset($_POST['btn_title']) ? $input->EscapeString($_POST['btn_title']) : '';
		$button['link'] = isset($_POST['btn_link']) ? $input->EscapeString($_POST['btn_link']) : '';
		$author = $user->row['username'];

		if($title == '' || $short == '' || $image == '' || $author == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("INSERT INTO cms_news_slider (title,shortstory,image,button_enable,link_button,button_title,author,date) VALUES
			('".$title."','".$short."','".$image."','".$button['enable']."','".$button['link']."','".$button['title']."','".$author."','".time()."')");
			$ok = "La Meganews &egrave; stata pubblicata correttamente!";
		}
	}
	
	?>
		<script>
		function addtext(){
			var text = $("#textadding").html();
			var check = $("#btn_enable").attr('checked');
			
			if(check == true)
				text = '<input name="btn_title" type="text" placeholder="Titolo buttone"><input name="btn_link" type="text" placeholder="Link buttone">';
			else
				text = '';
				
			$("#textadding").html(text);
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
							<label>Immagine della news*</label>
							<input name="image" type="text" placeholder="Immagine dell'articolo">
						</fieldset>
						
						<fieldset>
							<label>Buttone</label>
							<br><br><label><input id="btn_enable" name="btn_enable" type="checkbox" onclick="addtext();"> Abilita buttone</label>
							<div id="textadding"></div>
						</fieldset>
						
						<textarea id="art_story" class="ckeditor" cols="80" id="editor1" name="short" rows="10"></textarea>
						
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="add" value="Pubblica Meganews" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
		<?php
		}elseif(isset($_GET['delete'])){
			$id = $input->EscapeString($_GET['delete']);
			mysql_query("DELETE FROM cms_news_slider WHERE id = ".$id) or die();
			echo '<h4 class="alert_success">La Meganews &egrave; stata eliminata correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
		}
		?>
	</section>
	<br>

</body>

</html>