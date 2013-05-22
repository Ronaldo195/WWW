<?php
$is_maintenance = 1;
include("../core.php");

$page['id'] = "Gestione Utenti";
$page['rank'] = 4;

include("header.php");
?>	
	<script>
	function del(id){
		var sei_sicuro = confirm('Sei sicuro di voler eliminare l\'utente?');
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
		<h3 class="tabs_involved">Lista utenti</h3>
		<ul class="tabs2">
		<?php
		$page = isset($_GET['page']) ? $input->EscapeString($_GET['page']) : 1;
		$flag = isset($_GET['name']) ? "WHERE username LIKE '%".$input->EscapeString($_GET['name'])."%'" : "";
		$sql = mysql_query("SELECT * FROM users ".$flag." ORDER BY id DESC") or die();
		$count = mysql_num_rows($sql);
		$pages = ceil($count / 15);
		$limit = 15;
		$offset = $page - 1;
		$offset = $offset * 15;
		$sql = mysql_query("SELECT * FROM users ".$flag." ORDER BY username ASC LIMIT $limit OFFSET $offset") or die();
		
		if($page > 1) { ?><li><a href="?page=<?php echo ($page-1).(isset($_GET['name']) ? "&name=".$input->EscapeString($_GET['name']) : ""); ?>">&laquo;</a></li><?php } else { ?><li><a href="">&laquo;</a></li><?php }
		
		$i = 0;
		$n = $pages;
		while ($i <> $n){
			$i++;
			if ($i < $page + 8){
				if($i == $page){ echo "<li class=\"active\"><a href=\"#\">".$i."</a></li>\n";
				} else {
					if ($i + 4 >= $page && $page + 4 >= $i){
						echo "<li><a href=\"?page=".$i."".(isset($_GET['name']) ? "&name=".$input->EscapeString($_GET['name']) : "")."\">".$i."</a></li>\n";
					}
				}
			}
		}
		?>
		<?php if($page < $pages) { ?><li><a href="?page=<?php echo ($page+1).(isset($_GET['name']) ? "&name=".$input->EscapeString($_GET['name']) : ""); ?>">&raquo;</a></li><?php }else{ ?><li><a href="">&raquo;</a></li><?php } ?>
		</ul>
		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<th>Username</th> 
    				<th>Email</th> 
    				<th>Creazione</th> 
    				<th>Azioni</th>
				</tr> 
			</thead> 
			<tbody>
			<?php
			if(mysql_num_rows($sql) > 0)
				while($row = mysql_fetch_assoc($sql)){
				$account = mysql_fetch_assoc(mysql_query("SELECT * FROM accounts WHERE id = '".$row['account']."'"));
				echo '
				<tr> 
   					<td>'.$row['id'].'</td> 
    				<td>'.(isset($_GET['name']) ? str_replace($input->EscapeString($_GET['name']), "<b>".$input->EscapeString($_GET['name'])."</b>", $row['username']) : $row['username']).'</td> 
    				<td>'.$account['email'].'</td> 
    				<td>'.date('d F Y', $row['account_created']).'</td> 
    				<td><a href="?edit='.$row['id'].'"><img src="'.PATH.'admin/images/icn_edit.png"></a>&nbsp;&nbsp;&nbsp;
					<a href="javascript:del('.$row['id'].')"><img src="'.PATH.'admin/images/icn_trash.png"></a></td> 
				</tr>';
				}
			?>
    </div>
			</tbody> 
			</table>
			</div>
			
		</div>
		
		</article>
	
	<?php
	}elseif(isset($_GET['edit'])){
	$id = isset($_GET['edit']) ? $input->EscapeString($_GET['edit']) : '';
	
	if(isset($_POST['edit'])){
		$query = "UPDATE users SET id = '".$id."'";
	
        // Add the $_POST'ed UPDATE statements to the query
        foreach($_POST as $key => $value){
                if(strlen($value) > 0 && strlen($key) > 0 && $key !== "edit" && $key !== "username" && $key !== "id" && $key !== "auth_ticket" && $key !== "ip_last" && $key !== "user" && $key !== "rank"){
                        if(strpos($value, "'"))
							$query = $query . ", ".$key." = '".addslashes($value)."'";
						else
							$query = $query . ", ".$key." = '".$value."'";
                }
        }

        $query = $query . " WHERE id = '".$id."' LIMIT 1";
        mysql_query($query) or die(mysql_error());
        
		$ok = "Utente modificato correttamente.";
	}
	
	$sql = mysql_query("SELECT * FROM users WHERE id = ".$id) or die();
	
	if(mysql_num_rows($sql) > 0){
		$row = mysql_fetch_assoc($sql);
	?>
		
		<?php
		if(isset($error))
			echo '<h4 class="alert_error">'.$error.'</h4>';
		else if(isset($ok))
			echo '<h4 class="alert_success">'.$ok.'</h4>';
		?>
		
		<article id="newarticle" class="module width_full">
			<form action="" method="post">
			<header><h3>Modifica utente</h3></header>
				<div class="module_content">
		<?php
		foreach($row as $key => $value){
        
        if($key !== "password" && $key !== "online"){
        
        if($key == "username" || $key == "id" || $key == "auth_ticket" || $key == "ip_last" || $key == "account" || $key == "rank"){
                $flags = "disabled='disabled'";
        } else {
                $flags = "";
        }
        
			if($key == "description"){
				echo '<b>'.$key.'</b>: <textarea class="ckeditor" cols="80" name="'.$key.'" rows="5">'.$value.'</textarea>';
			}else{
				echo '
						<fieldset>
							<label>'.$key.'</label>
							<input name="'.$key.'" type="text" value="'.$value.'" '.$flags.'>
						</fieldset>';
			}
		}
    }
    
?>
</div>
			<footer>
				<div class="submit_link">
					<input type="submit" name="edit" value="Modifica utente" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>
		<div class="spacer"></div>
	<?php } }elseif(isset($_GET['delete'])){
			if($user->row['rank'] == 7){
				$id = $input->EscapeString($_GET['delete']);
				mysql_query("DELETE FROM users WHERE id = ".$id) or die();
				mysql_query("DELETE FROM user_achievements WHERE user_id = ".$id) or die();
				mysql_query("DELETE FROM user_badges WHERE user_id = ".$id) or die();
				mysql_query("DELETE FROM user_effects WHERE user_id = ".$id) or die();
				mysql_query("DELETE FROM user_favorites WHERE user_id = ".$id) or die();
				mysql_query("DELETE FROM user_ignores WHERE user_id = ".$id) or die();
				mysql_query("DELETE FROM user_info WHERE user_id = ".$id) or die();
				mysql_query("DELETE FROM user_pets WHERE user_id = ".$id) or die();
				mysql_query("DELETE FROM group_memberships WHERE userid = ".$id) or die();
				mysql_query("DELETE FROM groups_memberships WHERE userid = ".$id) or die();
				mysql_query("DELETE FROM groups WHERE ownerid = ".$id) or die();
				mysql_query("DELETE FROM items WHERE user_id = ".$id) or die();
				mysql_query("DELETE FROM cms_homes_stickers WHERE userid = ".$id) or die();
				mysql_query("DELETE FROM cms_homes_inventory WHERE userid = ".$id) or die();
				mysql_query("DELETE FROM cms_guestbook WHERE userid = ".$id) or die();
				echo '<h4 class="alert_success">L\'utente &egrave; stato eliminato correttamente! Clicca <a href="?">qui</a> per tornare indietro</h4>';
			}else{
				header("Location: ".PATH."admin/stop");
			}
		}
		?>
	<br><br>
	</section>

</body>
</html>