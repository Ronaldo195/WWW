<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Dashboard";
$page['rank'] = 4;

include("header.php");

if(isset($_GET['svuota']) && !isset($_POST['insert'])){
	if($user->row['rank'] == 7){
		mysql_query("UPDATE cms_system SET admin_notes = ''");
		$admin['notes'] = '';
	}
}

if(isset($_POST['insert'])){
	$text = isset($_POST['text']) ? $_POST['text'] : '';
	
	if($text != ''){
		$text = $admin['notes'].($admin['notes'] == '' ? "" : "|").$text."-".$user->row['username'];
		mysql_query("UPDATE cms_system SET admin_notes = '".$text."'");
		$admin['notes'] = $text;
	}
}
?>
	<section id="main" class="column">
		<h4 class="alert_info">Bentornato nell'amministrazione! Tutte le operazioni sono nel menu a sinistra.</h4>
		
		<article class="module width_half">
		<header><h3 class="tabs_involved">Statistiche</h3></header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<tbody> 
				<tr> 
   					<td>UTENTI ONLINE:</td> 
    				<td><b><?php echo $input->GetOnline(); ?></b></td> 
				</tr>
				<tr> 
   					<td>UTENTI REGISTRATI:</td> 
    				<td><b><?php echo $input->mysql_evaluate("SELECT COUNT(*) FROM users"); ?></b></td> 
				</tr>
				<tr> 
   					<td>UTENTI BANNATI:</td> 
    				<td><b><?php echo $input->mysql_evaluate("SELECT COUNT(*) FROM bans"); ?></b></td> 
				</tr>
				<tr> 
   					<td>STANZE CREATE:</td> 
    				<td><b><?php echo $input->mysql_evaluate("SELECT COUNT(*) FROM rooms"); ?></b></td> 
				</tr>
				<tr> 
   					<td>GRUPPI CREATI:</td> 
    				<td><b><?php echo $input->mysql_evaluate("SELECT COUNT(*) FROM groups"); ?></b></td> 
				</tr>
				<tr> 
   					<td>FURNI TOTALI:</td> 
    				<td><b><?php echo $input->mysql_evaluate("SELECT COUNT(*) FROM items"); ?></b></td> 
				</tr>
			</tbody> 
			</table>
			</div>
		</div>
		
		</article>
		
		<article class="module width_half">
			<script>
			window.onload=function(){
				var objDiv = document.getElementById("messages");
				objDiv.scrollTop = objDiv.scrollHeight;
			}
			</script>
			<header><h3>Chat dello Staff <?php echo $user->row['rank'] == 7 ? '(<a href="?svuota">SVUOTA</a>)' : ''; ?></h3></header>
			<div id="messages" class="message_list">
				<div class="module_content">
				<?php
				if($admin['notes'] != ''){
					$message = explode("|", $admin['notes']);
					for($i=0;$i<count($message);$i++){
						$dati = explode("-", $message[$i]);
						echo '<div class="message"><p>'.$dati[0].'</p><p><strong>'.$dati[1].'</strong></p></div>';
					}
				}
				?>
				</div>
			</div>
			<footer>
				<form class="post_message" method="post" autocomplete="off">
					<input type="text" name="text" placeholder="Messaggio">
					<input type="submit" name="insert" class="btn_post_message" value="">
				</form>
			</footer>
		</article>
	</section>
</body>
</html>