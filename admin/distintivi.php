<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Distintivi";
$page['rank'] = 4;

include("header.php");
?>	
	<script>
	function del(badge, id){
		var sei_sicuro = confirm('Sei sicuro di voler togliere il distintivo?');
		if (sei_sicuro)
		{
			location.href = '?delete='+id+'-'+badge;
		}
	}
	</script>
	<section id="main" class="column">
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
	<?php
	if(!isset($_GET['add']) && !isset($_GET['delete'])){
	
	if(isset($_POST['search'])){
	$name = isset($_POST['name']) ? $input->EscapeString($_POST['name']): '';
	?>
	<article id="articles" class="module width_full">
		<header>
		<h3 class="tabs_involved">Distintivi di: <?php echo $name; ?></h3>
		<ul class="tabs2">
			<li><a href="?add&name=<?php echo $name; ?>">+ Aggiungi distintivo</a></li>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>Distintivo</th> 
    				<th>Codice</th>  
					<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$userid = mysql_result(mysql_query("SELECT id FROM users WHERE username = '".$name."' LIMIT 1"),0);
				$sql = mysql_query("SELECT * FROM user_badges WHERE user_id = ".$userid);
				
				while($row = mysql_fetch_assoc($sql)){
				echo '
				<tr> 
					<td><img src="'.$cimagesurl.$badgesurl.$row['badge_id'].'.gif"></td> 
   					<td>'.$row['badge_id'].'</td> 
    				<td><a href="javascript:del(\''.$row['badge_id'].'\','.$row['user_id'].')"><img src="'.PATH.'admin/images/icn_trash.png"></a></td> 
				</tr>';
				}
			?>
			</tbody> 
			</table>
			</div>
		</div>
		
		</article>
	<?php
	}else{
	?>
		
	<article id="newarticle" class="module width_full">
			<form action="" method="post">
			<header>
			<h3 class="tabs_involved">Cerca utente</h3>
			<ul class="tabs2">
			<li><a href="?add">+ Dai distintivo</a></li>
			</ul>
			</header>
				<div class="module_content">
						<fieldset>
							<label>Username*</label>
							<input id="txt1" name="name" type="text" autocomplete="off">
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="search" value="Trova distintivi dell'utente" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
	
	<?php
	} }elseif(isset($_GET['add'])){
	
	if(isset($_POST['add'])){
		$name  = isset($_POST['name']) ? $_POST['name'] : '';
		$badge  = isset($_POST['badge']) ? $_POST['badge'] : '';
		
		if($name == '' || $badge == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			$badges = explode(",", $badge);
			
			if($name == "(tutti)")
				$exits = mysql_query("SELECT id FROM users") or die();
			elseif($name == "(online)")
				$exits = mysql_query("SELECT id FROM users WHERE online = '1'") or die();
			elseif($name == "(staff)")
				$exits = mysql_query("SELECT id FROM users WHERE rank > 3") or die();
			else
				$exits = mysql_query("SELECT id FROM users WHERE username = '".$name."' LIMIT 1") or die();
				
			if(mysql_num_rows($exits) > 0){
				while($row = mysql_fetch_array($exits)){
					$userid = $row[0];
					foreach($badges as $bdg){
						if($bdg != '' && strlen($bdg) > 2){
							$check = mysql_query("SELECT * FROM user_badges WHERE badge_id = '".$bdg."' AND user_id = ".$userid) or die();
							if(mysql_num_rows($check) < 1)
								mysql_query("INSERT INTO user_badges (user_id,badge_id) VALUES ('".$userid."','".$bdg."')") or die(mysql_error());
						}
					}
				}
			}
			$ok = "Il distintivo &egrave; stato dato correttamente!";
		}
	}
	
	?>
		<script>
		function preview(){
			var badge = $("#badge").val().split(',');
			var text = '';
			
			if(badge.length < 5)
				for (i = 0, l = badge.length; i < l; i += 1){
					if(badge[i] != '' && badge[i].length > 2)
						text += '<img src="http://images-eussl.habbo.com/c_images/album1584/' + badge[i] + '.gif"> ';
				}
			else
				alert('Puoi dare massimo 4 distintivi!');
				
			$("#preview").html(text);
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
							<label>Username*</label>
							<input id="txt1" name="name" type="text" autocomplete="off" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>"><br><br><br><br>
							 - "<b>(tutti)</b>" per darlo a tutti gli utenti<br>
							 - "<b>(online)</b>" per darlo a tutti gli utenti in hotel<br>
							 - "<b>(staff)</b>" per darlo a tutto lo staff
						</fieldset>
						
						<fieldset>
							<label>Distintivo/i* (<a href="javascript:preview();">Anteprima</a>)</label>
							<input id="badge" name="badge" type="text" placeholder="Codice distintivi separati con ,">
							<br><br><br><br>
							<label>
							<span id="preview"></span>
							</label>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="add" value="Dai distintivo" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
		<?php
		}elseif(isset($_GET['delete'])){
			$badge = explode("-", $_GET['delete']);
			mysql_query("DELETE FROM user_badges WHERE badge_id = '".$badge[1]."' AND user_id = ".$badge[0]) or die();
			echo '<h4 class="alert_success">Il distintivo &egrave; stato tolto correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
		}
		?>
	</section>
	<br>

</body>

</html>