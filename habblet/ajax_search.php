<?php
include('../core.php');

if(isset($_POST['searchString'])) {
$page = isset($_POST['pageNumber']) ? $input->FilterText($_POST['pageNumber']) : 1;
$search = $input->FilterText($_POST['searchString']);
$sql = mysql_query("SELECT username,look,id,last_online FROM users WHERE username LIKE '$search%' ORDER BY username ASC");
$count = mysql_num_rows($sql);
$pages = ceil($count / 10);
if($page == null){ $page = 1; }
$limit = 10;
$offset = $page - 1;
$offset = $offset * 10;
$sql = mysql_query("SELECT username,look,id,last_online FROM users WHERE username LIKE '$search%' ORDER BY username ASC LIMIT $limit OFFSET $offset");
if(mysql_num_rows($sql) > 0) {
echo '<ul class="habblet-list">';
$i = 0;
while($row = mysql_fetch_assoc($sql)) {
		        $i++;

        if($input->IsEven($i)){
            $even = "odd";
        } else {
            $even = "even";
        } ?>

              <li class="<?php echo $even; ?> offline" homeurl="<?php echo PATH; ?>home/<?php echo $input->HoloText($row['username']); ?>" style="background-image: url(http://www.habbo.it/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&direction=2&head_direction=2&gesture=sml&size=s)">
	            	    <div class="item">
	            		    <b><?php echo $input->HoloText($row['username']); ?></b><br />

	            	    </div>
	            	    <div class="lastlogin">
	            	    	<b>Ultima Visita</b><br />
	            	    		<span title="<?php echo $row['last_online']; ?>"><?php echo is_numeric($row['last_online']) ? date("d-m-Y H:i", $row['last_online']) : $row['last_online']; ?></span>
	            	    </div>
	            	    <div class="tools">
	            	    		<a href="#" class="add" avatarid="<?php echo $row['id']; ?>" title="Richiesta Amico"></a>
	            	    </div>
	            	    <div class="clear"></div>
	                </li>

<?php			} ?>
							    <div id="habblet-paging-avatar-habblet-list-container">
        <p id="avatar-habblet-list-container-list-paging" class="paging-navigation">
		            	 <?php if($page > 1) { ?><a href="#" class="avatar-habblet-list-container-list-paging-link" id="avatar-habblet-list-container-list-previous">&laquo;</a><?php } else { ?><span class="disabled">&laquo;</span><?php } ?>
		<?php           
		$i = 0;
		$n = $pages;
		while ($i <> $n){
			$i++;
			if ($i < $page + 8){
				if($i == $page){ echo "<span class=\"current\">".$i."</span>\n";
				} else {
					if ($i + 4 >= $page && $page + 4 >= $i){
						echo "<a href=\"#\" class=\"avatar-habblet-list-container-list-paging-link\" id=\"avatar-habblet-list-container-list-page-".$i."\">".$i."</a>\n";
					}
				}
			}
		}
		?>
		<?php if($page < $pages) { ?><a href="#" class="avatar-habblet-list-container-list-paging-link" id="avatar-habblet-list-container-list-next">&raquo;</a><?php }else{ ?><span class="disabled">&raquo;</span><?php } ?>
			        </p>
        <input type="hidden" id="avatar-habblet-list-container-pageNumber" value="<?php echo $page; ?>"/>
        <input type="hidden" id="avatar-habblet-list-container-totalPages" value="<?php echo $pages; ?>"/>
    </div>
				<?php
			}else{
			echo "<div class=\"box-content\">
                ".$site['short']." Non trovato verifica che il nome sia attivo. <br>
       </div>";
		}
}

?>
