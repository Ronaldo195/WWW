<?php
if(!isset($cor))
	require_once "../core.php";

$page = isset($_POST['pageNumber']) ? $input->EscapeString($_POST['pageNumber']) : "";
$page = isset($_GET['pageNumber']) ? $input->EscapeString($_GET['pageNumber']) : $page;
$psize = isset($_POST['pageSize']) ? $input->EscapeString($_POST['pageSize']) : "";
$psize = isset($_GET['pageSize']) ? $input->EscapeString($_GET['pageSize']) : $psize;
$search = isset($_POST['searchString']) ? $input->EscapeString($_POST['searchString']) : "";
$search = isset($_GET['searchString']) ? $input->EscapeString($_GET['searchString']) : $search;
$text_search = $search == "" ? "" : "AND users.username LIKE '%".$search."%'";
if (isset($page) == false || is_numeric($page) == false || $page < 1)
	$page = 1;
	
if (isset($psize) == false || is_numeric($psize) == false || $psize < 1)
	$psize = 30;
	
?>
        <div id="friend-list" class="clearfix">
<?php
	$error = 0;
	$sql = mysql_query("SELECT users.id,users.username,users.last_online FROM messenger_friendships,users WHERE (messenger_friendships.user_one_id = '".$user->row['id']."' AND users.id = messenger_friendships.user_two_id)") or $error=1;
	
	if($error == 1)
		$sql = mysql_query("SELECT users.id,users.username,users.last_online FROM messenger_friendships,users WHERE (messenger_friendships.sender = '".$user->row['id']."' AND users.id = messenger_friendships.receiver OR messenger_friendships.receiver = '".$user->row['id']."' AND users.id = messenger_friendships.sender)");
	
	$quanti = mysql_num_rows($sql);
	if($quanti > 0){ ?>
<div id="friend-list-header-container" class="clearfix">
    <div id="friend-list-header">
        <div class="page-limit">
            <div class="big-icons friend-header-icon">Amici
                <br />Mostra
                <?php
				if($psize == 30){ echo " 30 |"; }else{ echo '<a class="category-limit" id="pagelimit-30">30</a> |'; }
                if($psize == 50){ echo " 50 |"; }else{ echo ' <a class="category-limit" id="pagelimit-50">50</a> |'; }
                if($psize == 100){ echo " 100"; }else{ echo ' <a class="category-limit" id="pagelimit-100">100</a>'; }
				?>
            </div>
        </div>
    </div>
    <div id="friend-list-paging">
	<?php
	$inizio = ($page - 1) * $psize;
	$intero = $quanti / $psize;

	for($i=1;$i<$intero+1;$i++){
		if($i == $page)
			echo ' | '.$i.' ';
		else
			echo '| <a href="#" class="friend-list-page" id="page-'.$i.'">'.$i.'</a> ';
	}
	?>
        </div>
    </div>

<form id="friend-list-form">
    <table id="friend-list-table" border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="friend-list-header">
                <th class="friend-select" />
                <th class="friend-name">
                    <a class="sort">Nome</a>
                </th>
                <th class="friend-login">
                    <a class="sort">Visto l'ultima volta</a>
                </th>
                <th class="friend-remove">Rimuovi</th>
            </tr>
        </thead>
        <tbody>
		<?php
		$i = 0;
		$sql = mysql_query("SELECT users.id,users.username,users.last_online FROM messenger_friendships,users WHERE (messenger_friendships.user_one_id = '".$user->row['id']."' AND users.id = messenger_friendships.user_two_id ".$text_search.") ORDER BY users.username ASC LIMIT " . $inizio . ", " . $psize) or $error=1;
		
		if($error == 1)
			$sql = mysql_query("SELECT users.id,users.username,users.last_online FROM messenger_friendships,users WHERE (messenger_friendships.sender = '".$user->row['id']."' AND users.id = messenger_friendships.receiver ".$text_search." OR messenger_friendships.receiver = '".$user->row['id']."' AND users.id = messenger_friendships.sender ".$text_search.") ORDER BY users.username ASC LIMIT " . $inizio . ", " . $psize);
	
			while($f = mysql_fetch_array($sql)) {
				
					$i++;
					if($input->IsEven($i)) {
						$oddeven = "odd";
					} else {
						$oddeven = "even";
					}
						
						printf("   <tr class=\"%s\">
               <td><input type=\"checkbox\" name=\"friendList[]\" value=\"%s\" /></td>
               <td class=\"friend-name\">
                %s
               </td>
               <td class=\"friend-login\" title=\"%s\">%s</td>
				<td class=\"friend-remove\">
				<div id=\"remove-friend-button-%s\" class=\"friendmanagement-small-icons friendmanagement-remove remove-friend\"></div>
				</td>
				</tr>", $oddeven, $f['id'], $f['username'], is_numeric($f['last_online']) ? date('d/m/Y H:i:s',$f['last_online']) : $f['last_online'], $input->nicetime(is_numeric($f['last_online']) ? date('Y-m-d H:i:s',$f['last_online']) : $f['last_online']), $f['id']);
						
			}
					
		?>
        </tbody>
    </table>
    <a class="select-all" id="friends-select-all" href="#">Seleziona tutti</a> |
    <a class="deselect-all" href=#" id="friends-deselect-all">De-seleziona tutti</a>
</form>


<div id="category-options" class="clearfix">
<!--<select id="category-list-select" name="category-list">
    <option value="0">Amici</option>
</select>-->
<div class="friend-del"><a class="new-button red-button cancel-icon" href="#" id="delete-friends"><b><span></span>Elimina i contatti selezionati</b><i></i></a></div>
<!--<div class="friend-move"><a class="new-button" href="#" id="move-friend-button"><b><span></span>Sposta</b><i></i></a></div>-->
</div>
<?php } else{ echo '<p class="last" style="padding-top: 11px">Non hai ancora nessun amico</p>'; } ?>
        </div>