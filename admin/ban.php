<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Ban";
$page['rank'] = 4;

include("header.php");
?>	
	<script>
	function del(id){
		var sei_sicuro = confirm('Sei sicuro di voler eliminare il ban?');
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
		<h3 class="tabs_involved">Utenti bannati</h3>
		<ul class="tabs">
			<li></li>
			<li><a href="#tab1" onclick="location.href='?add'">+ Aggiungi Ban</a></li>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<th>Username/IP</th> 
    				<th>Bannato da</th> 
					<th>Motivazione</th> 
					<th>Scadenza</th> 
					<th>Azioni</th> 
				</tr> 
			</thead> 
			<tbody>
			<?php
				$sql = mysql_query("SELECT * FROM bans");
				while($row = mysql_fetch_assoc($sql)){
				echo '
				<tr> 
   					<td>'.$row['id'].'</td> 
    				<td>'.$row['value'].'</td> 
    				<td>'.$row['added_by'].'</td> 
					<td style="width:200px">'.$row['reason'].'</td> 
					<td>'.date('d/m/Y H:i:s',$row['expire']).'</td> 
    				<td><a href="javascript:del(\''.$row['id'].'\')"><img src="'.PATH.'admin/images/icn_trash.png"></a></td> 
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
		$type    = isset($_POST['type']) ? $input->EscapeString($_POST['type']) : '';
		$value = isset($_POST['value']) ? $input->EscapeString($_POST['value']) : '';
		$reason  = isset($_POST['reason']) ? $_POST['reason'] : '';
		$expiretime  = isset($_POST['length']) ? $input->EscapeString((time()+$_POST['length'])) : '';
		$mod  = $user->row['username'];
		
		if($type == '' || $value == '' || $reason == '' || $expiretime == '')
			$error = 'Tutti i campi contrassegnati con <b>*</b> sono obbligatori!';
		else{
			mysql_query("INSERT INTO bans (bantype,value,reason,expire,added_by,added_date,appeal_state) VALUES 
			('" . $type . "','" . $value . "','" . $reason . "','" . $expiretime . "','" . $mod . "','" . date('d/m/Y H:i') . "','0')");
			$input->MUS("reloadbans");
			$ok = "L'utente &egrave; stato bannato correttamente!";
		}
	}
	
		if(isset($error))
			echo '<h4 class="alert_error">'.$error.'</h4>';
		else if(isset($ok))
			echo '<h4 class="alert_success">'.$ok.'</h4>';
		?>
<script type="text/javascript" src="<?php echo PATH."admin/"; ?>js/autocomplete.js"></script> 
<script>
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

StateSuggestions.prototype.requestSuggestions = function (oAutoSuggestControl,  bTypeAhead) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl.textbox.value;
    if (sTextboxValue.length > 0){
	var sTextboxValueLC = sTextboxValue.toLowerCase();
       for (var i=0; i < this.states.length; i++) { 
	   var sStateLC = this.states[i].toLowerCase();
            if (sStateLC.indexOf(sTextboxValueLC) == 0) {
				aSuggestions.push(sTextboxValue + this.states[i].substring(sTextboxValue.length));
            } 
        }
    }
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
			<form action="" method="post">
			<header><h3>Banna utente</h3></header>
				<div class="module_content">
						<fieldset>
							<label>Tipo Ban*</label>
							<select name="type">
								<option value="user" onclick="usersclass();">Username</option>
								<option value="ip">Indirizzo IP</option>
							</select>
						</fieldset>
						
						<fieldset>
							<label>Username/IP*</label>
							<input id="txt1" name="value" type="text" autocomplete="off">
						</fieldset>
						
						<fieldset>
							<label>Motivazione*</label>
							<input name="reason" type="text">
						</fieldset>
						
						<fieldset>
							<label>Tempo*</label>
							<select type="text" name="length">
								<option value="1800">30 Minuti</option>
								<option value="3600">1 Ora</option>
								<option value="10800">3 Ore</option>
								<option value="43200">12 Ore</option>
								<option value="86400">1 Giorno</option>
								<option value="259200">3 Giorni</option>
								<option value="604800">1 Settimana</option>
								<option value="1209600">2 Settimane</option>
								<option value="2592000">1 Mese</option>
								<option value="7776000">3 Mesi</option>
								<option value="31104000">1 Anno</option>
								<option value="62208000">2 Anni</option>
								<option value="360000000">Permanente</option>
							</select>
						</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="add" value="Banna utente" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
		<?php
		}elseif(isset($_GET['delete'])){
			$id = $input->EscapeString($_GET['delete']);
			mysql_query("DELETE FROM bans WHERE id = '".$id."'") or die();
			$input->MUS("reloadbans");
			echo '<h4 class="alert_success">Il Ban &egrave; stato tolto correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
		}
		?>
	</section>
	<br>

</body>

</html>