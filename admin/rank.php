<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Rank";
$page['rank'] = 7;

include("header.php");
?>	
	<script>
	function del(id){
		var sei_sicuro = confirm('Sei sicuro di voler togliere il rank a questo utente?');
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
		<h3 class="tabs_involved">Gestione Rank</h3>
		<ul class="tabs2">
			<li><a href="?add">+ Dai promozione</a></li>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<th>Username</th> 
    				<th>Rank</th> 
					<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$sql = mysql_query("SELECT * FROM users WHERE rank > 3 ORDER BY rank DESC");
				
				while($row = mysql_fetch_assoc($sql)){
				echo '
				<tr> 
   					<td>'.$row['id'].'</td> 
    				<td>'.$row['username'].'</td> 
    				<td>'.$row['rank'].'</td> 
    				<td><a href="javascript:del(\''.$row['id'].'\')"><img src="'.PATH.'admin/images/icn_trash.png" title="revoca rank"></a></td> 
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
		$name = isset($_POST['name']) ? $input->EscapeString($_POST['name']) : '';
		$rank = isset($_POST['rank']) ? $input->EscapeString($_POST['rank']) : 1;
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
		$desc = strpos($desc, "'") ? addslashes($desc) : $desc;

		if($name == '' || $rank == '' || $desc == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("UPDATE users SET rank = '".$rank."',description = '".$desc."' WHERE username = '".$name."' LIMIT 1");
			$ok = "La promozione &egrave; stata data correttamente!";
		}
	}
	
		if(isset($error))
			echo '<h4 class="alert_error">'.$error.'</h4>';
		else if(isset($ok))
			echo '<h4 class="alert_success">'.$ok.'</h4>';
		?>
		<script type="text/javascript" src="<?php echo PATH."admin/"; ?>js/autocomplete.js"></script> 
		<script type="text/javascript">
		// è la classe provider
function StateSuggestions() {

    this.states = [
	<?php
	$sql = mysql_query("SELECT username FROM users");
	$text = '';
	while($row = mysql_fetch_array($sql))
		$text .= '"'.$row[0].'",';
	$text = substr($text, 0, -1);
	echo $text;
	?>
    ];
}

// funzione che richiede i suggerimenti passandogli un AutoSuggestControl
StateSuggestions.prototype.requestSuggestions = function (oAutoSuggestControl /*:AutoSuggestControl*/,  bTypeAhead) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl.textbox.value;
    
    if (sTextboxValue.length > 0){
    
	// trasformo tutto in minuscolo
	var sTextboxValueLC = sTextboxValue.toLowerCase();
    
        //search for matching states
        for (var i=0; i < this.states.length; i++) { 
	   
	   // trasformo anche i suggerimenti in minuscolo
	   var sStateLC = this.states[i].toLowerCase();
	    
            if (sStateLC.indexOf(sTextboxValueLC) == 0) {
                
		//aSuggestions.push(this.states[i]);
		//suggerisco la stringa già presente, quindi con i caratteri maiuscoli e minuscoli, più la stringa rimanente suggerita
		aSuggestions.push(sTextboxValue + this.states[i].substring(sTextboxValue.length));
            } 
        }
    }

    //provide suggestions to the control
    //oAutoSuggestControl.autosuggest(aSuggestions);
    oAutoSuggestControl.autosuggest(aSuggestions, bTypeAhead);
};

window.onload = function () {
                var oTextbox = new AutoSuggestControl(document.getElementById("txt1"), new StateSuggestions());        
            }
		</script>
		<style>
		div.suggestions {
			position: absolute;
			width:500px;
			background: #F6F6F6;
			border-bottom: 1px solid #ccc;
			border-left: 1px solid #ccc;
			border-right: 1px solid #ccc;
		}
		div.suggestions div {
			cursor: pointer;
			padding: 0px 3px;
			background-color: #F6F6F6;
			font-size:15px;
		}
		div.suggestions div.current {
			background-color: #ccc;
			color: white;
		}
		</style>
		<article id="newarticle" class="module width_full">
			<form action="" method="post" autocomplete="off">
			<header><h3>Dai promozione</h3></header>
				<div class="module_content">
						<fieldset>
							<label>Username*</label>
							<input id="txt1" name="name" type="text">
						</fieldset>
						
						<fieldset>
							<label>Rank*</label>
							<select name="rank">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
							</select>
						</fieldset>
						
						<fieldset>
							<label>Descrizione* (Pagina Staff)</label>
							<textarea name="desc" rows="10" cols="10"></textarea>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="add" value="Dai promozione" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
		<?php
		}elseif(isset($_GET['delete'])){
			$id = $input->EscapeString($_GET['delete']);
			mysql_query("UPDATE users SET rank = '1' WHERE id = '".$id."'") or die();
			echo '<h4 class="alert_success">La promozione &egrave; stata revocata correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
		}
		?>
	</section>
	<br>

</body>

</html>