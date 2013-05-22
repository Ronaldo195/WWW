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
			location.href = '<?php echo PATH; ?>admin/utenti/utenti?delete='+id;
		}
	}
	</script>
	<section id="main" class="column">
		<article id="articles" class="module width_full">
		<header>
		<h3 class="tabs_involved">Utenti online</h3>
		<ul class="tabs2">
		<?php
		$page = isset($_GET['page']) ? $input->EscapeString($_GET['page']) : 1;
		$sql = mysql_query("SELECT * FROM users WHERE online = '1' ORDER BY id DESC") or die();
		$count = mysql_num_rows($sql);
		$pages = ceil($count / 15);
		$limit = 15;
		$offset = $page - 1;
		$offset = $offset * 15;
		$sql = mysql_query("SELECT * FROM users WHERE online = '1' ORDER BY username ASC LIMIT $limit OFFSET $offset") or die();
		
		if($page > 1) { ?><li><a href="?page=<?php echo ($page-1); ?>">&laquo;</a></li><?php } else { ?><li><a href="">&laquo;</a></li><?php }
		
		$i = 0;
		$n = $pages;
		while ($i <> $n){
			$i++;
			if ($i < $page + 8){
				if($i == $page){ echo "<li class=\"active\"><a href=\"#\">".$i."</a></li>\n";
				} else {
					if ($i + 4 >= $page && $page + 4 >= $i){
						echo "<li><a href=\"?page=".$i."\">".$i."</a></li>\n";
					}
				}
			}
		}
		?>
		<?php if($page < $pages) { ?><li><a href="?page=<?php echo ($page+1); ?>">&raquo;</a></li><?php }else{ ?><li><a href="">&raquo;</a></li><?php } ?>
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
    				<td><a href="'.PATH.'admin/utenti/utenti?edit='.$row['id'].'"><img src="'.PATH.'admin/images/icn_edit.png"></a>&nbsp;&nbsp;&nbsp;
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
	<br><br>
	</section>

</body>
</html>