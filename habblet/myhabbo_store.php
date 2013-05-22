<?php


require_once('../core.php');
require_once('../includes/session.php');

$check = mysql_query("SELECT groupid,active FROM cms_homes_group_linker WHERE userid = '".$user->row['id']."' AND active = '1' LIMIT 1") or die(mysql_error());
$linked = mysql_num_rows($check);

if($linked > 0){
	$linkdata = mysql_fetch_assoc($check);
	$groupid = $linkdata['groupid'];
}

/** Quick function to format the type stuff
*
* eg. $input->formatThing(1,"geniefirehead",true); would return
* s_geniefirehead_pre
*
* $input->formatThing(4,"bg_rain",false); would return
* b_bg_rain
*
*/

function $input->formatThing($type,$data,$pre)
{
	$str = "";

	switch($type){
		case 1: $str = $str . "s_"; break;
		case 2: $str = $str . "w_"; break;
		case 3: $str = $str . "commodity_"; break; // =S
		case 4: $str = $str . "b_"; break;
	}

	$str = $str . $data;

	if($pre == true){ $str = $str . "_pre"; }

	return addslashes($str);
}

/** Quick function to insert or update the user's inventory
*
* $input->UpdateOrInsert(type,amount,data,userid);
* always returns true or cuts the script off with a mysql error
*
*/

function $input->UpdateOrInsert($type,$amount,$data,$my_id)
{
	$data = addslashes($data);
	$type = addslashes($type);
	$amount = addslashes($amount);

	$check = mysql_query("SELECT id FROM cms_homes_inventory WHERE data = '".$data."' AND userid = '".$my_id."' AND type = '".$type."' LIMIT 1") or die(mysql_error());
	$exists = mysql_num_rows($check);

	if($exists > 0){
		mysql_query("UPDATE cms_homes_inventory SET amount = amount + ".$amount." WHERE userid = '".$my_id."' AND type = '".$type."' AND data = '".$data."' LIMIT 1") or die(mysql_error());
	} else {
		mysql_query("INSERT INTO cms_homes_inventory (userid,type,subtype,data,amount) VALUES ('".$my_id."','".$type."','0','".$data."','".$amount."')") or die(mysql_error());
	}

	return true;
}

/** Quick function to delete or update something from the user's inventory
*
* always returns true or cuts the script off with a mysql error
*
*/

function $input->UpdateOrDelete($id,$my_id)
{
	$id = addslashes($id);
	$type = addslashes($type);

	$check = mysql_query("SELECT amount FROM cms_homes_inventory WHERE id = '".$id."' AND userid = '".$my_id."' LIMIT 1") or die(mysql_error());
	$exists = mysql_num_rows($check);

	if($exists > 0){
	$row = mysql_fetch_assoc($check);

		if($row['amount'] > 1){
			mysql_query("UPDATE cms_homes_inventory SET amount = amount - 1 WHERE id = '".$id."' AND userid = '".$my_id."' LIMIT 1") or die(mysql_error());
		} else {
			mysql_query("DELETE FROM cms_homes_inventory WHERE id = '".$id."' AND userid = '".$my_id."' LIMIT 1") or die(mysql_error());
		}

	}

	return true;
}

$mode = $input->FilterText($_GET['key']);

if($mode == "inventory"){

// Look for the first inventory sticker in the DB for the header
$tmp = mysql_query("SELECT data FROM cms_homes_inventory WHERE type = '1' AND userid = '".$user->row['id']."' LIMIT 1");
$valid = mysql_num_rows($tmp);

if($valid > 0){
	$row = mysql_fetch_assoc($tmp);
	header("X-JSON: [[\"Inventario\",\"Catalogo\"],[\"" . $input->formatThing(1,$row['data'],true) . "\",\"" . $input->formatThing(1,$row['data'],false) . "\",\"".$row['data']."\",\"Sticker\",null,1]]");
} else {
	header("X-JSON: [[\"Inventario\",\"Catalogo\"],[\"\",\"\",\"\",\"Sticker\",null,1]]");
}
?>
<div style="position: relative;">
<div id="webstore-categories-container">
	<h4>Categorie:</h4>
	<div id="webstore-categories">
<ul class="purchase-main-category">
		<li id="maincategory-1-stickers" class="selected-main-category webstore-selected-main">
			<div>Sticker</div>
			<ul class="purchase-subcategory-list" id="main-category-items-228">
				<?php if($user->row['rank'] > 5){ ?>
				<li id="subcategory-1-50-stickers" class="subcategory">
					<div><strong><font color='red'><?php echo $site['short']; ?> Staff</strong></font></div>
				</li>
				<?php } ?>
				<li id="subcategory-3-214-stickers" class="subcategory">
					<div>Pubblici</div>
				</li>
				<li id="subcategory-3-205-stickers" class="subcategory">
					<div>Alhambra</div>
				</li>
				<li id="subcategory-3-211-stickers" class="subcategory">
					<div>Lettere Bling</div>
				</li>
				<li id="subcategory-3-203-stickers" class="subcategory">
					<div>Lettere Plastic</div>
				</li>
				<li id="subcategory-3-227-stickers" class="subcategory">
					<div>Lettere Wood</div>
				</li>
				<li id="subcategory-3-236-stickers" class="subcategory">
					<div>Banca</div>
				</li>
				<li id="subcategory-3-206-stickers" class="subcategory">
					<div>Compleanno</div>
				</li>
				<li id="subcategory-3-215-stickers" class="subcategory">
					<div>Bordi</div>
				</li>
				<li id="subcategory-3-204-stickers" class="subcategory">
					<div>Buttoni</div>
				</li>
				<li id="subcategory-3-223-stickers" class="subcategory">
					<div>Celebrazioni</div>
				</li>
				<li id="subcategory-3-217-stickers" class="subcategory">
					<div>China</div>
				</li>
				<li id="subcategory-3-201-stickers" class="subcategory">
					<div>Club</div>
				</li>
				<li id="subcategory-3-235-stickers" class="subcategory">
					<div>Eco</div>
				</li>
				<li id="subcategory-3-240-stickers" class="subcategory">
					<div>FX</div>
				</li>
				<li id="subcategory-3-208-stickers" class="subcategory">
					<div>Costumi</div>
				</li>
				<li id="subcategory-3-219-stickers" class="subcategory">
					<div>Gotici</div>
				</li>
				<li id="subcategory-3-238-stickers" class="subcategory">
					<div>Evidenziatore</div>
				</li>
				<li id="subcategory-3-213-stickers" class="subcategory">
					<div>Hockey</div>
				</li>
				<li id="subcategory-3-239-stickers" class="subcategory">
					<div>Alieni</div>
				</li>
				<li id="subcategory-3-224-stickers" class="subcategory">
					<div>Giappone</div>
				</li>
				<li id="subcategory-3-225-stickers" class="subcategory">
					<div>Reali</div>
				</li>
				<li id="subcategory-3-226-stickers" class="subcategory">
					<div>Amore</div>
				</li>
				<li id="subcategory-3-216-stickers" class="subcategory">
					<div><?php echo $site['short']; ?></div>
				</li>
				<li id="subcategory-3-220-stickers" class="subcategory">
					<div><?php echo $site['short']; ?>Varie</div>
				</li>
				<li id="subcategory-3-221-stickers" class="subcategory">
					<div><?php echo $site['short']; ?>wood</div>
				</li>
				<li id="subcategory-3-228-stickers" class="subcategory">
					<div>Altri 1</div>
				</li>
				<li id="subcategory-3-229-stickers" class="subcategory">
					<div>Altri 2</div>
				</li>
				<li id="subcategory-3-230-stickers" class="subcategory">
					<div>Altri 3</div>
				</li>
				<li id="subcategory-3-212-stickers" class="subcategory">
					<div>Mario</div>
				</li>
				<li id="subcategory-3-222-stickers" class="subcategory">
					<div>Indicatori</div>
				</li>
				<li id="subcategory-3-232-stickers" class="subcategory">
					<div>Calcio</div>
				</li>
				<li id="subcategory-3-237-stickers" class="subcategory">
					<div>Scintillanti</div>
				</li>
				<li id="subcategory-3-210-stickers" class="subcategory">
					<div>Primavera</div>
				</li>
				<li id="subcategory-3-241-stickers" class="subcategory">
					<div>St. Patrizio</div>
				</li>
				<li id="subcategory-3-207-stickers" class="subcategory">
					<div>Mare</div>
				</li>
				<li id="subcategory-3-209-stickers" class="subcategory">
					<div>Wrestling</div>
				</li>
				<?php if($user->row['rank'] > 5){ ?>
				<li id="subcategory-3-1000-stickers" class="subcategory">
					<div>Inutili!</div>
				</li>
				<?php } ?>
			</ul>
		</li>
		<li id="maincategory-2-backgrounds" class="main-category">
			<div>Sfondi</div>
			<ul class="purchase-subcategory-list" id="main-category-items-2">
				<li id="subcategory-2-127-stickers" class="subcategory">
					<div>Sfondi 1</div>
				</li>
				<li id="subcategory-2-128-stickers" class="subcategory">
					<div>Sfondi 2</div>
				</li>
				<li id="subcategory-2-129-stickers" class="subcategory">
					<div>Sfondi 3</div>
				</li>
				<li id="subcategory-2-130-stickers" class="subcategory">
					<div>Sfondi 4</div>
				</li>
				<li id="subcategory-2-131-stickers" class="subcategory">
					<div>Sfondi 5</div>
				</li>
				<li id="subcategory-2-132-stickers" class="subcategory">
					<div>Sfondi 6</div>
				</li>
			</ul>
		</li>
		<li id="maincategory-6-stickie_notes" class="main-category-no-subcategories">
			<div>Post-it</div>
			<ul class="purchase-subcategory-list" id="main-category-items-6">
				<li id="subcategory-6-29-stickie_notes" class="subcategory">
					<div>store.subcategory.all</div>
				</li>
			</ul>
		</li>
</div>
</div>

<div id="webstore-content-container">
	<div id="webstore-items-container">
		<h4>Seleziona un oggetto facendo clic su di esso</h4>
		<div id="webstore-items"><ul id="webstore-item-list">
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
</ul></div>
	</div>
	<div id="webstore-preview-container">
		<div id="webstore-preview-default"></div>
		<div id="webstore-preview"></div>
	</div>
</div>

<div id="inventory-categories-container">
	<h4>Categorie:</h4>
	<div id="inventory-categories">
<ul class="purchase-main-category">
	<li id="inv-cat-stickers" class="selected-main-category-no-subcategories">
		<div>Sticker</div>
	</li>
	<li id="inv-cat-backgrounds" class="main-category-no-subcategories">
		<div>Sfondi</div>
	</li>
	<li id="inv-cat-widgets" class="main-category-no-subcategories">
		<div>Widget</div>
	</li>
	<li id="inv-cat-notes" class="main-category-no-subcategories">
		<div>Post-it</div>
	</li>
</ul>

	</div>
</div>

<div id="inventory-content-container">
	<div id="inventory-items-container">
		<h4>Fare clic su un oggetto per selezionarlo:</h4>
		<div id="inventory-items"><ul id="inventory-item-list">
<?php
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '1'") or die(mysql_error());
	$typ = "sticker";
	$number = mysql_num_rows($get_em);
?>

	<?php if($number < 1){ ?>
	<div class="webstore-frank">
	<div class="blackbubble">
		<div class="blackbubble-body">

<p><b>Il tuo inventario e vuoto!</b></p>
<p><p>Per acquistare gli adesivi, gli sfondi e le note, fare clic sulla scheda Webstore per sfogliare le categorie. Quando trovi qualcosa che ti piace clicca su 'Acquista' per acquistarlo.</p></p>

		<div class="clear"></div>
		</div>
	</div>
	<div class="blackbubble-bottom">
		<div class="blackbubble-bottom-body">
			<img src="<?php echo PATH; ?>web-gallery/images/box-scale/bubble_tail_small.gif" alt="" width="12" height="21" class="invitation-tail" />
		</div>
	</div>
	<div class="webstore-frank-image"><img src="/web-gallery/images/frank/sorry.gif" alt=""  /></div>
</div>
	<?php } 

	while ($row = mysql_fetch_assoc($get_em)) {

	if($row['amount'] > 1){
		$specialcount = "<div class=\"webstore-item-count\"><div>x".$row['amount']."</div></div>";
	} else {
		$specialcount = "";
	}

	printf("	<li id=\"inventory-item-%s\" title=\"%s\">
		<div class=\"webstore-item-preview %s\">

			<div class=\"webstore-item-mask\">
				%s
			</div>
		</div>
	</li>", $row['id'], $row['data'], $input->formatThing($row['type'],$row['data'],true), $specialcount);
	}

	// We want at least 20 empty slots. If the user has less than 20 items for this type
	// we echo the necessary empty slots to fill it up to 20 slots using a for() loop.
	if($number < 20){
	$empty_slots = 20 - $number;
		for ($i = 1; $i <= $empty_slots; $i++) {
		echo "<li class=\"webstore-item-empty\"></li>";
		}
	}

?>
</ul></div>
	</div>
	<div id="inventory-preview-container">
		<div id="inventory-preview-default"></div>
		<div id="inventory-preview"><h4>&nbsp;</h4>

<div id="inventory-preview-box"></div>

<div id="inventory-preview-place" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place"><b>Posiziona</b><i></i></a>
	</div>
</div>

</div>
	</div>
</div>

<div id="webstore-close-container">
	<div class="clearfix"><a href="#" id="webstore-close" class="new-button"><b>Chiudi</b><i></i></a></div>
</div>
<?php } else if($mode == "inventory_items"){
$type = $input->FilterText($_POST['type']);

	if($type == "stickers"){
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '1'") or die(mysql_error());
	$typ = "sticker";
	} else if($type == "notes"){
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '3'") or die(mysql_error());
	$typ = "note";
	} else if($type == "widgets"){
	$typ = "widget";
	} else if($type == "backgrounds"){
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '4'") or die(mysql_error());
	$typ = "background";
	} else {
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '1'") or die(mysql_error());
	$typ = "sticker";
	}

	if($typ !== "widget"){
		$number = mysql_num_rows($get_em); ?>
			<ul id="webstore-item-list">

		<?php if($number < 1){ ?>
			<div class="webstore-frank">
	<div class="blackbubble">
		<div class="blackbubble-body">


<p><b>Il tuo inventario e vuoto!</b></p>
<p><p>Per acquistare gli adesivi, gli sfondi e le note, fare clic sulla scheda Webstore per sfogliare le categorie. Quando trovi qualcosa che ti piace clicca su 'Acquista' per acquistarlo.</p></p>

		<div class="clear"></div>
		</div>
	</div>
	<div class="blackbubble-bottom">
		<div class="blackbubble-bottom-body">
			<img src="<?php echo PATH; ?>web-gallery/images/box-scale/bubble_tail_small.gif" alt="" width="12" height="21" class="invitation-tail" />
		</div>
	</div>
	<div class="webstore-frank-image"><img src="/web-gallery/images/frank/sorry.gif" alt=""  /></div>
</div>
	<?php }

		while ($row = mysql_fetch_assoc($get_em)) {

		if($row['amount'] > 1){
			$specialcount = "<div class=\"webstore-item-count\"><div>x".$row['amount']."</div></div>";
		} else {
			$specialcount = "";
		}

		printf("	<li id=\"inventory-item-%s\" title=\"%s\">
		<div class=\"webstore-item-preview %s\">

			<div class=\"webstore-item-mask\">
				%s
			</div>
		</div>
	</li>", $row['id'], $row['data'], $input->formatThing($row['type'],$row['data'],true), $specialcount);
	}

	// We want at least 20 empty slots. If the user has less than 20 items for this type
	// we echo the necessary empty slots to fill it up to 20 slots using a for loop.
		if($number < 20){
		$empty_slots = 20 - $number;
			for ($i = 1; $i <= $empty_slots; $i++) {
			echo "<li class=\"webstore-item-empty\"></li>";
			}
		}

		echo "</ul>";
	} elseif($typ == "widget"){
		if($linked > 0){ // Group Mode
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE groupid = '".$groupid."' AND type = '2' AND subtype = '3' LIMIT 1") or die(mysql_error());
			$placed_memberwidget = mysql_num_rows($check);
			$check2 = mysql_query("SELECT id FROM cms_homes_stickers WHERE groupid = '".$groupid."' AND type = '2' AND subtype = '4' LIMIT 1") or die(mysql_error());
			$placed_memberwidget2 = mysql_num_rows($check2);

			echo "<ul id=\"inventory-item-list\">";
			echo "<li id=\"inventory-item-p-3\"
		title=\"Membri Del gruppo\" class=\"webstore-widget-item"; if($placed_memberwidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_memberwidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Membri del gruppo</h3>
			<p></p>
		</div>
	</li>";
		echo "<li id=\"inventory-item-p-4\"
		title=\"Guestbook\" class=\"webstore-widget-item"; if($placed_memberwidget2 > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_guestbookwidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Guest Book</h3>
			<p></p>
		</div>
	</li>"; 
			echo "</ul>";
		} else { // User profile

			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '2' LIMIT 1") or die(mysql_error());
			$placed_groupwidget = mysql_num_rows($check);
			$check2 = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '4' LIMIT 1") or die(mysql_error());
			$placed_memberwidget2 = mysql_num_rows($check2);
			$check3 = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '5' LIMIT 1") or die(mysql_error());
			$placed_memberwidget3 = mysql_num_rows($check3);
			$check4 = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '3' LIMIT 1") or die(mysql_error());
			$placed_memberwidget4 = mysql_num_rows($check4);
			$check5 = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '6' LIMIT 1") or die(mysql_error());
			$placed_memberwidget5 = mysql_num_rows($check5);
			$check6 = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '8' LIMIT 1") or die(mysql_error());
			$placed_memberwidget6 = mysql_num_rows($check6);

			echo "<ul id=\"inventory-item-list\">";
	echo "<li id=\"inventory-item-p-4\"
		title=\"Guestbook\" class=\"webstore-widget-item"; if($placed_memberwidget2 > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_guestbookwidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Guest Book</h3>
			<p></p>
		</div>
	</li>";  
	echo "<li id=\"inventory-item-p-5\"
		title=\"Miei Amici\"  class=\"webstore-widget-item"; if($placed_memberwidget3 > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_friendswidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Miei Amici</h3>
			<p></p>
		</div>
	</li>";

	echo "<li id=\"inventory-item-p-2\"
		title=\"Miei Gruppi\" class=\"webstore-widget-item"; if($placed_groupwidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_groupswidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Miei gruppi</h3>
			<p></p>
		</div>
	</li>";
	echo "<li id=\"inventory-item-p-3\"
		title=\"Mie Stanze\"  class=\"webstore-widget-item"; if($placed_memberwidget4 > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_roomswidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Mie Stanze</h3>
			<p></p>
		</div>
	</li>

	<li id=\"inventory-item-p-8\"
		title=\"Miei Distintivi\"  class=\"webstore-widget-item"; if($placed_memberwidget6 > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_badgeswidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Miei Distintivi</h3>
			<p>Mostra i tuoi Distintivi nella tua Pagina.</p>
		</div>
	</li>"; 
echo "</ul>";
		}
	}
} elseif($mode == "main"){

// Look for the first thing in this category
$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE category = '19' ORDER BY id ASC LIMIT 1");
$valid = mysql_num_rows($tmp);

if($valid > 0){
	$row = mysql_fetch_assoc($tmp);
	header("X-JSON: [[\"Inventario\",\"Catalogo\"],[\"" . $input->formatThing(1,$row['data'],true) . "\",\"" . $input->formatThing(1,$row['data'],false) . "\",\"".$row['data']."\",\"Sticker\",null,1]]");
} else {
	header("X-JSON: [[\"Inventario\",\"Catalogo\"],[\"\",\"\",\"\",\"Sticker\",null,1]]");
}

?>
<div style="position: relative;">
<div id="webstore-categories-container">
	<h4>Categorie:</h4>
	<div id="webstore-categories">
<ul class="purchase-main-category">
		<li id="maincategory-1-stickers" class="selected-main-category webstore-selected-main">
			<div>Sticker</div>
			<ul class="purchase-subcategory-list" id="main-category-items-228">
				<?php if($user->row['rank'] > 5){ ?>
				<li id="subcategory-1-50-stickers" class="subcategory">
					<div><strong><font color='red'><?php echo $site['short']; ?> Staff</strong></font></div>
				</li>
				<?php } ?>
				<li id="subcategory-3-214-stickers" class="subcategory">
					<div>Pubblici</div>
				</li>
				<li id="subcategory-3-205-stickers" class="subcategory">
					<div>Alhambra</div>
				</li>
				<li id="subcategory-3-211-stickers" class="subcategory">
					<div>Lettere Bling</div>
				</li>
				<li id="subcategory-3-203-stickers" class="subcategory">
					<div>Lettere Plastic</div>
				</li>
				<li id="subcategory-3-227-stickers" class="subcategory">
					<div>Lettere Wood</div>
				</li>
				<li id="subcategory-3-236-stickers" class="subcategory">
					<div>Banca</div>
				</li>
				<li id="subcategory-3-206-stickers" class="subcategory">
					<div>Compleanno</div>
				</li>
				<li id="subcategory-3-215-stickers" class="subcategory">
					<div>Bordi</div>
				</li>
				<li id="subcategory-3-204-stickers" class="subcategory">
					<div>Buttoni</div>
				</li>
				<li id="subcategory-3-223-stickers" class="subcategory">
					<div>Celebrazioni</div>
				</li>
				<li id="subcategory-3-217-stickers" class="subcategory">
					<div>China</div>
				</li>
				<li id="subcategory-3-201-stickers" class="subcategory">
					<div>Club</div>
				</li>
				<li id="subcategory-3-235-stickers" class="subcategory">
					<div>Eco</div>
				</li>
				<li id="subcategory-3-240-stickers" class="subcategory">
					<div>FX</div>
				</li>
				<li id="subcategory-3-208-stickers" class="subcategory">
					<div>Costumi</div>
				</li>
				<li id="subcategory-3-219-stickers" class="subcategory">
					<div>Gotici</div>
				</li>
				<li id="subcategory-3-238-stickers" class="subcategory">
					<div>Evidenziatore</div>
				</li>
				<li id="subcategory-3-213-stickers" class="subcategory">
					<div>Hockey</div>
				</li>
				<li id="subcategory-3-239-stickers" class="subcategory">
					<div>Alieni</div>
				</li>
				<li id="subcategory-3-224-stickers" class="subcategory">
					<div>Giappone</div>
				</li>
				<li id="subcategory-3-225-stickers" class="subcategory">
					<div>Reali</div>
				</li>
				<li id="subcategory-3-226-stickers" class="subcategory">
					<div>Amore</div>
				</li>
				<li id="subcategory-3-216-stickers" class="subcategory">
					<div><?php echo $site['short']; ?></div>
				</li>
				<li id="subcategory-3-220-stickers" class="subcategory">
					<div><?php echo $site['short']; ?>Varie</div>
				</li>
				<li id="subcategory-3-221-stickers" class="subcategory">
					<div><?php echo $site['short']; ?>wood</div>
				</li>
				<li id="subcategory-3-228-stickers" class="subcategory">
					<div>Altri 1</div>
				</li>
				<li id="subcategory-3-229-stickers" class="subcategory">
					<div>Altri 2</div>
				</li>
				<li id="subcategory-3-230-stickers" class="subcategory">
					<div>Altri 3</div>
				</li>
				<li id="subcategory-3-212-stickers" class="subcategory">
					<div>Mario</div>
				</li>
				<li id="subcategory-3-222-stickers" class="subcategory">
					<div>Indicatori</div>
				</li>
				<li id="subcategory-3-232-stickers" class="subcategory">
					<div>Calcio</div>
				</li>
				<li id="subcategory-3-237-stickers" class="subcategory">
					<div>Scintillanti</div>
				</li>
				<li id="subcategory-3-210-stickers" class="subcategory">
					<div>Primavera</div>
				</li>
				<li id="subcategory-3-241-stickers" class="subcategory">
					<div>St. Patrizio</div>
				</li>
				<li id="subcategory-3-207-stickers" class="subcategory">
					<div>Mare</div>
				</li>
				<li id="subcategory-3-209-stickers" class="subcategory">
					<div>Wrestling</div>
				</li>
				<?php if($user->row['rank'] > 5){ ?>
				<li id="subcategory-3-1000-stickers" class="subcategory">
					<div>Inutili!</div>
				</li>
				<?php } ?>
			</ul>
		</li>
		<li id="maincategory-2-backgrounds" class="main-category">
			<div>Sfondo</div>
			<ul class="purchase-subcategory-list" id="main-category-items-2">
				<li id="subcategory-2-127-stickers" class="subcategory">
					<div>Sfondo 1</div>
				</li>
				<li id="subcategory-2-128-stickers" class="subcategory">
					<div>Sfondo 2</div>
				</li>
				<li id="subcategory-2-129-stickers" class="subcategory">
					<div>Sfondo 3</div>
				</li>
				<li id="subcategory-2-130-stickers" class="subcategory">
					<div>Sfondo 4</div>
				</li>
				<li id="subcategory-2-131-stickers" class="subcategory">
					<div>Sfondo 5</div>
				</li>
				<li id="subcategory-2-132-stickers" class="subcategory">
					<div>Sfondo 6</div>
				</li>
			</ul>
		</li>
		<li id="maincategory-6-stickie_notes" class="main-category-no-subcategories">
			<div>Post-it</div>
			<ul class="purchase-subcategory-list" id="main-category-items-6">
				<li id="subcategory-6-29-stickie_notes" class="subcategory">
					<div>store.subcategory.all</div>
				</li>
			</ul>
		</li>
</div>

<div id="webstore-content-container">
	<div id="webstore-items-container">
		<h4>Seleziona un oggetto.</h4>
		<div id="webstore-items">

<?php

	$get_em = mysql_query("SELECT * FROM cms_homes_catalouge WHERE category = '19'") or die(mysql_error());
	$number = mysql_num_rows($get_em);
?>

	<ul id="webstore-item-list">

	<?php if($number < 1){ ?>
	<div class="webstore-frank">
	<div class="blackbubble">
		<div class="blackbubble-body">

<p><b>Categoria Vuota!</b></p>
<p>Opss! Questa categoria pultroppo e vuota.</p>

		<div class="clear"></div>
		</div>
	</div>
	<div class="blackbubble-bottom">
		<div class="blackbubble-bottom-body">
			<img src="<?php echo PATH; ?>web-gallery/images/box-scale/bubble_tail_small.gif" alt="" width="12" height="21" class="invitation-tail" />
		</div>
	</div>
	<div class="webstore-frank-image"><img src="/web-gallery/images/frank/sorry.gif" alt=""  /></div>
</div>
	<?php }

	while ($row = mysql_fetch_assoc($get_em)) {

	if($row['amount'] > 1){
		$specialcount = "<div class=\"webstore-item-count\"><div>x".$row['amount']."</div></div>";
	} else {
		$specialcount = "";
	}

	printf("	<li id=\"inventory-item-%s\" title=\"%s\">
		<div class=\"webstore-item-preview %s\">

			<div class=\"webstore-item-mask\">
				%s
			</div>
		</div>
	</li>", $row['id'], $row['data'], $input->formatThing($row['type'],$row['data'],true), $specialcount);
	}

	// We want at least 20 empty slots. If the user has less than 20 items for this type
	// we echo the necessary empty slots to fill it up to 20 slots using a for() loop.
	if($number < 20){
	$empty_slots = 20 - $number;
		for ($i = 1; $i <= $empty_slots; $i++) {
		echo "<li class=\"webstore-item-empty\"></li>";
		}
	}

	echo "</ul>";
?>

		</div>
	</div>
	<div id="webstore-preview-container">
		<div id="webstore-preview-default"></div>
		<div id="webstore-preview"><?php
$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '1' AND category = '19' LIMIT 1");
$exists = mysql_num_rows($tmp);

	$row = mysql_fetch_assoc($tmp);
?>
<h4 title="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></h4>

<div id="webstore-preview-box"></div>

<div id="webstore-preview-price">
Prezzo:<br /><b>
	<?php echo $row['price']; ?> Crediti
</b>
</div>

<div id="webstore-preview-purse">
Tu tieni:<br /><b><?php echo $user->row['credits']; ?> Crediti.</b><br />
<?php if($user->row['credits'] < $row['cost']){ ?><span class="webstore-preview-error">Non tieni crediti sufficenti per acquistare questo oggetto.</span><br />
<a href="credits" target=_blank>¡Ottieni Crediti!</a><?php } ?>
</div>

<div id="webstore-preview-purchase" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button <?php if($user->row['credits'] < $row['cost']){ ?>disabled-button<?php } ?>" <?php if($user->row['credits'] < $row['cost']){ ?>disabled="disabled"<?php } ?> id="webstore-purchase<?php if($user->row['credits'] < $row['cost']){ ?>-disabled<?php } ?>"><b>Compra</b><i></i></a>
	</div>
</div>

<span id="webstore-preview-bg-text" style="display: none">Anteprima</span>
</div>
	</div>
</div>

<div id="inventory-categories-container">
	<h4>Categorie:</h4>
	<div id="inventory-categories">
<ul class="purchase-main-category">
	<li id="inv-cat-stickers" class="selected-main-category-no-subcategories">
		<div>Sticker</div>
	</li>
	<li id="inv-cat-backgrounds" class="main-category-no-subcategories">
		<div>Sfondi</div>
	</li>
	<li id="inv-cat-widgets" class="main-category-no-subcategories">
		<div>Elementi</div>
	</li>
	<li id="inv-cat-notes" class="main-category-no-subcategories">
		<div>Post-it</div>
	</li>
</ul>

	</div>
</div>

<div id="inventory-content-container">
	<div id="inventory-items-container">
		<h4>Fare clic su un elemento per selezionarlo:</h4>
		<div id="inventory-items"><ul id="inventory-item-list">
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
	<li class="webstore-item-empty"></li>
</ul></div>
	</div>
	<div id="inventory-preview-container">
		<div id="inventory-preview-default"></div>
		<div id="inventory-preview"><h4>&nbsp;</h4>

<div id="inventory-preview-box"></div>

<div id="inventory-preview-place" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place"><b>Posiziona</b><i></i></a>
	</div>
</div>

</div>
	</div>
</div>

<div id="webstore-close-container">
	<div class="clearfix"><a href="#" id="webstore-close" class="new-button"><b>Chiudi</b><i></i></a></div>
</div>
</div>
<?php
} elseif($mode == "preview"){

$productId = addslashes($_POST['productId']);
$subCategoryId = addslashes($_POST['subCategoryId']);

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' AND category = '".$subCategoryId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

if($row['type'] == "4"){
	$bg_pre = "\"bgCssClass\":\"" . $input->formatThing($row['type'],$row['data'],false) . "\",";
}

header("X-JSON: [{\"itemCount\":1,\"titleKey\":\"".$row['name']."\"," . $bg_pre . "\"previewCssClass\":\"" . $input->formatThing($row['type'],$row['data'],true) . "\"}]");

?>
<h4 title="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></h4>

<div id="webstore-preview-box"></div>

<?php if($exists > 0){ ?><div id="webstore-preview-price">
Prezzo:<br /><b>
	<?php echo $row['price']; ?> Crediti
</b>
</div>

<div id="webstore-preview-purse">
Tu tieni:<br /><b><?php echo $user->row['credits']; ?> Crediti</b><br />
<?php if($user->row['credits'] < $row['cost']){ ?><span class="webstore-preview-error">Non tieni crediti sufficenti per acquistare questo oggetto.</span><br />
<a href="credits" target=_blank>Ottieni crediti</a><?php } ?>
</div>

<div id="webstore-preview-purchase" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button <?php if($user->row['credits'] < $row['cost']){ ?>disabled-button<?php } ?>" <?php if($user->row['credits'] < $row['cost']){ ?>disabled="disabled"<?php } ?> id="webstore-purchase<?php if($user->row['credits'] < $row['cost']){ ?>-disabled<?php } ?>"><b>Compra</b><i></i></a>
	</div>
</div><?php } ?>

<span id="webstore-preview-bg-text" style="display: none">Anteprima</span>
<?php
} elseif($mode == "purchase_confirm"){
$productId = $input->FilterText($_POST['productId']);
$subCategoryId = $input->FilterText($_POST['subCategoryId']);

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' AND category = '".$subCategoryId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

	if($exists > 0){
?>

		<div class="webstore-item-preview <?php echo $input->formatThing($row['type'],$row['data'],true); ?>">
			<div class="webstore-item-mask">
			</div>
		</div>
		<p>Sicuro di comprare <b><?php echo $row['name']; ?></b>? ti costera  <b><?php echo $row['price']; ?></b> Crediti.</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>Cancel</b><i></i></a>
		<a href="#" class="new-button" id="webstore-confirm-submit"><b>Continue</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	} else {
?>
		<p>Ci dispiace,non puoi comprare questo.</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>Ok</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	}
} elseif($mode == "purchase_stickers"){
$productId = addslashes($_POST['selectedId']);

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

if($row['category'] == "50" && $user->row['rank'] < 6){ exit; }

	if($exists > 0){
		if($user->row['credits'] < $row['price']){
		?>
		<p>Ci dispiace , non hai abbastanza crediti per comprare questo oggetto.</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>Ok</b><i></i></a>
	</p>
	<div class="clear"></div>
		<?php
		} else {
			mysql_query("UPDATE users SET credits = credits - ".$row['price']." WHERE id = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
			$input->UpdateOrInsert($row['type'],$row['amount'],$row['data'],$user->row['id']);
			mysql_query("INSERT INTO cms_transactions (userid,amount,date,descr) VALUES ('".$user->row['id']."','-".$row['price']."','".$date_full."','Comprato adesivo homepage')");
			//@SendMUSData('UPRC' . $user->row['id']);
			echo "OK";
		}
	} else {
?>
		<p>Ci dispiace,non puoi comprare questo oggetto.</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	}
} elseif($mode == "items"){

	$category = addslashes($_POST['subCategoryId']);

	if($category == "50" && $user->row['rank'] < 6){ exit; }

	$get_em = mysql_query("SELECT * FROM cms_homes_catalouge WHERE category = '".$category."'") or die(mysql_error());
	$number = mysql_num_rows($get_em);
?>

			<ul id="webstore-item-list">

	<?php if($number < 1){ ?>
	<div class="webstore-frank">
	<div class="blackbubble">
		<div class="blackbubble-body">

<p><b>Categoria Vuota!</b></p>
<p>Opss! Questa categoria pultroppo e vuota.</p>


		<div class="clear"></div>
		</div>
	</div>
	<div class="blackbubble-bottom">
		<div class="blackbubble-bottom-body">
			<img src="<?php echo PATH; ?>web-gallery/images/box-scale/bubble_tail_small.gif" alt="" width="12" height="21" class="invitation-tail" />
		</div>
	</div>
	<div class="webstore-frank-image"><img src="/web-gallery/images/frank/sorry.gif" alt=""  /></div>
</div>
	<?php }

	while ($row = mysql_fetch_assoc($get_em)) {

	if($row['amount'] > 1){
		$specialcount = "<div class=\"webstore-item-count\"><div>x".$row['amount']."</div></div>";
	} else {
		$specialcount = "";
	}

	printf("	<li id=\"inventory-item-%s\" title=\"%s\">
		<div class=\"webstore-item-preview %s\">

			<div class=\"webstore-item-mask\">
				%s
			</div>
		</div>
	</li>", $row['id'], $row['data'], $input->formatThing($row['type'],$row['data'],true), $specialcount);
	}

	// We want at least 20 empty slots. If the user has less than 20 items for this type
	// we echo the necessary empty slots to fill it up to 20 slots using a for() loop.
	if($number < 20){
	$empty_slots = 20 - $number;
		for ($i = 1; $i <= $empty_slots; $i++) {
		echo "<li class=\"webstore-item-empty\"></li>";
		}
	}

	echo "</ul>";

} elseif($mode == "purchase_backgrounds"){
$productId = addslashes($_POST['selectedId']);

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

if($row['category'] == "50" && $user->row['rank'] < 6){ exit; }

	if($exists > 0){
		if($user->row['credits'] < $row['price']){
		?>
		<p>Ci dispiace , non hai abbastanza crediti per comprare questo oggetto.</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
		<?php
		} else {
			$tcheck = mysql_query("SELECT id FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '4' AND data = '".$row['data']."' LIMIT 1") or die(mysql_error());
			$tnum = mysql_num_rows($tcheck);
			if($tnum > 0){ ?>
		<p>¡Gia tieni uno sfondo del genere!</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
			<?php } else {
				mysql_query("UPDATE users SET credits = credits - ".$row['price']." WHERE id = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
				$input->UpdateOrInsert($row['type'],$row['amount'],$row['data'],$user->row['id']);
				mysql_query("INSERT INTO cms_transactions (userid,amount,date,descr) VALUES ('".$user->row['id']."','-".$row['price']."','".$date_full."','Comprato adesivo homepage')");
				//@SendMUSData('UPRC' . $user->row['id']);
				echo "OK";
			}
		}
	} else {
?>
		<p>Ci dispiace , non puoi comprare questo.</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	}

		
} elseif($mode == "purchase_stickie_notes"){
$productId = addslashes($_POST['selectedId']); if(!is_numeric($productId)){ exit; }

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

if($row['category'] == "50" && $user->row['rank'] < 6){ exit; }

	if($exists > 0){
		if($user->row['credits'] < $row['price']){
		?>
		<p>Ci dispiace, non hai crediti sufficenti per comprare questo oggetto.</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
		<?php
		} else {
			mysql_query("UPDATE users SET credits = credits - ".$row['price']." WHERE id = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
			$input->UpdateOrInsert($row['type'],$row['amount'],$row['data'],$user->row['id']);
			mysql_query("INSERT INTO cms_transactions (userid,amount,date,descr) VALUES ('".$user->row['id']."','-".$row['price']."','".$date_full."','Comprato adesivo homepage')");
			//@SendMUSData('UPRC' . $user->row['id']);
			echo "OK";
		}
	} else {
?>
		<p>Ci dispiace, non hai crediti sufficenti per comprare questo oggetto.</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	}
} elseif($mode == "inventory_preview"){

if($_POST['type'] == "widgets"){
	$widget = $input->FilterText($_POST['itemId']);
	if($widget == "2"){
		$row['data'] = "groupswidget";
	} elseif($widget == "3"){
		$row['data'] = "memberwidget";
	} else {
		$row['data'] = "profilewidget";
	}
	$row['type'] = 2;
	$exists = 1;
} else {
	$productId = addslashes($_POST['itemId']); if(!is_numeric($productId)){ exit; }
	$tmp = mysql_query("SELECT * FROM cms_homes_inventory WHERE id = '".$productId."' AND userid = '".$user->row['id']."' LIMIT 1");
	$exists = mysql_num_rows($tmp);
	$row = mysql_fetch_assoc($tmp);
}

header("X-JSON: [\"" . $input->formatThing($row['type'],$row['data'],true) . "\",\"" . $input->formatThing($row['type'],$row['data'],false) . "\",\"8\",\"".$_POST['type']."\",null,".$row['amount']."]");

?>
<h4>&nbsp;</h4>

<div id="inventory-preview-box"></div>

<div id="inventory-preview-place" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place"><b>Posiziona</b><i></i></a>
	</div>
<?php if($row['amount'] > 1 && $row['type'] == "1"){ ?>
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place-all"><b>Posiziona Tutto</b><i></i></a>
	</div>
<?php } ?>
</div>
<?php
} elseif($mode == "noteeditor"){
?>
<form action="#" method="post" id="webstore-notes-form">

<input type="hidden" name="maxlength" id="webstore-notes-maxlength" value="<?php if($user->row['rank'] > 5){ ?>5000<?php } else { ?>500<?php } ?>" />
<?php if($user->row['rank'] > 5){ ?>
<div id="webstore-notes-counter"><?php echo 5000 - strlen(stripslashes($_POST['noteText'])); ?></div>
<?php } else { ?>
<div id="webstore-notes-counter"><?php echo 500 - strlen(stripslashes($_POST['noteText'])); ?></div>
<?php } ?>

<p>
	<select id="webstore-notes-skin" name="skin">
			<option value="1" id="webstore-notes-skin-defaultskin">Default</option>
			<option value="6" id="webstore-notes-skin-goldenskin">Oro</option>
			<option value="3" id="webstore-notes-skin-metalskin">Metallo</option>
			<option value="5" id="webstore-notes-skin-notepadskin">Blocco Note</option>
			<option value="2" id="webstore-notes-skin-speechbubbleskin">Fumetto</option>
			<option value="4" id="webstore-notes-skin-noteitskin">Post-it</option>
			<?php if($user->row['rank'] > 5){ ?>
			<option value="9" id="edit-menu-skins-select-nakedskin">Transparente</option>
			<?php } ?>
	</select>
</p>

<p class="warning">Attenzione! Una volta messo questo documento non e possibile modificare il testo.</p>

<div id="webstore-notes-edit-container">

<textarea id="webstore-notes-text" rows="7" cols="42" name="noteText"><?php echo $input->SwitchWordFilter($input->textInJS($_POST['noteText'])); ?></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("webstore-notes-text");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Rosso"],
            "orange" : ["#fe6301", "Arancione"],
            "yellow" : ["#ffce00", "Giallo"],
            "green" : ["#6cc800", "Verde"],
            "cyan" : ["#00c6c4", "Azzurro"],
            "blue" : ["#0070d7", "Blu"],
            "gray" : ["#828282", "Grigio"],
            "black" : ["#000000", "Nero"]
        };
        bbcodeToolbar.addColorSelect("Colori", Colori, true);
    </script>


</form>

<p>
<a href="#" class="new-button" id="webstore-confirm-cancel"><b>Annulla</b><i></i></a>
<a href="#" class="new-button" id="webstore-notes-continue"><b>Continua</b><i></i></a>
</p>

<div class="clear"></div>
<?php
} elseif($mode == "noteeditor-preview"){
?>
<div id="webstore-notes-container">
<?php
if($user->row['rank'] > 5){
$text = $input->SwitchWordFilter(addslashes($input->textInJS($_POST['noteText'])));
} else {
$text = $input->HoloText($input->SwitchWordFilter(addslashes($input->textInJS($_POST['noteText']))), false, true);
}
$newskin = $_POST['skin'];

	if($newskin == 1){ $skin = "defaultskin"; }
	else if($newskin == 2){ $skin = "speechbubbleskin"; }
	else if($newskin == 3){ $skin = "metalskin"; }
	else if($newskin == 4){ $skin = "noteitskin"; }
	else if($newskin == 5){ $skin = "notepadskin"; }
	else if($newskin == 6){ $skin = "goldenskin"; }
	else if($newskin == 9 && $user->row['rank'] > 5){ $skin = "nakedskin"; }
	else { $skin = "defaultskin"; }

	echo "<div class=\"movable stickie n_skin_".$skin."-c\" style=\" left: 0px; top: 0px; z-index: 1;\" id=\"stickie--1\">
	<div class=\"n_skin_".$skin."\" >
		<div class=\"stickie-header\">
			<h3></h3>
			<div class=\"clear\"></div>
		</div>
		<div class=\"stickie-body\">
			<div class=\"stickie-content\">
				<div class=\"stickie-markup\">".$text."</div>
				<div class=\"stickie-footer\">
				</div>
			</div>
		</div>
	</div>
</div></div>";
?>
<p class="warning">ATTENZIONE!: I post-it non si possono modificare una volta posizionati in home.</p>

<p>
<a href="#" class="new-button" id="webstore-notes-edit"><b>Modifica</b><i></i></a>
<a href="#" class="new-button" id="webstore-notes-add"><b>Aggiungi Alla home</b><i></i></a>
</p>

<div class="clear"></div>
<?php
} elseif($mode == "noteeditor-place"){

	if($user->row['rank'] > 5){
	$data = $input->SwitchWordFilter(addslashes($input->textInJS($_POST['noteText'])));
	$lenght = 5000;
	} else {
	$data = $input->HoloText($input->SwitchWordFilter(addslashes($input->textInJS($_POST['noteText']))), false, true);
	$lenght = 500;
	}
	
	$newskin = $_POST['skin'];

	if($newskin == 1){ $skin = "defaultskin"; }
	else if($newskin == 2){ $skin = "speechbubbleskin"; }
	else if($newskin == 3){ $skin = "metalskin"; }
	else if($newskin == 4){ $skin = "noteitskin"; }
	else if($newskin == 5){ $skin = "notepadskin"; }
	else if($newskin == 6){ $skin = "goldenskin"; }
	else if($newskin == 9 && $user->row['rank'] > 5){ $skin = "nakedskin"; }
	else { $skin = "defaultskin"; }

	if(strlen($data) < $lenght && strlen($data) > 0){

		if($linked > 0){
			mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,x,y,z,data,type,subtype,skin) VALUES ('".$user->row['id']."','".$groupid."','10','10','18','".$data."','3','0','".$skin."')") or die(mysql_error());
			$sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND type = '3' AND data = '".$data."' ORDER BY id DESC LIMIT 1") or die(mysql_error());
			$sql2 = mysql_query("SELECT id FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '3' LIMIT 1") or die(mysql_error());
		} else {
			mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,x,y,z,data,type,subtype,skin) VALUES ('".$user->row['id']."','-1','10','10','18','".$data."','3','0','".$skin."')") or die(mysql_error());
			$sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '3' AND data = '".$data."' ORDER BY id DESC LIMIT 1") or die(mysql_error());
			$sql2 = mysql_query("SELECT id FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '3' LIMIT 1") or die(mysql_error());
		}

		$row = mysql_fetch_assoc($sql);
		$row2 = mysql_fetch_assoc($sql2);

		$input->UpdateOrDelete($row2['id'],$user->row['id']);

		$id = $row['id'];
		header("X-JSON: " . $id );

		$edit = "\n<img src=\"'".PATH."/web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"stickie-" . $id . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"stickie-" . $id . "-edit\", \"click\", function(e) { openEditMenu(e, " . $id . ", \"stickie\", \"stickie-" . $id . "-edit\"); }, false);
</script>\n";

		echo "<div class=\"movable stickie n_skin_".$skin."-c\" style=\" left: 0px; top: 0px; z-index: 1;\" id=\"stickie-" . $id . "\">
	<div class=\"n_skin_".$skin."\" >
		<div class=\"stickie-header\">
			<h3>".$edit."</h3>
			<div class=\"clear\"></div>
		</div>
		<div class=\"stickie-body\">
			<div class=\"stickie-content\">
				<div class=\"stickie-markup\">" . $data . "</div>
				<div class=\"stickie-footer\">
				</div>
			</div>
		</div>
	</div>
</div></div>";

	}
} elseif($mode == "place_sticker"){

$id = addslashes($_POST['selectedStickerId']);
$z = addslashes($_POST['zindex']);
$placeAll = $_POST['placeAll'];

$check = mysql_query("SELECT data,amount FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '1' AND id = '".$id."' LIMIT 1") or die(mysql_error());
$exists = mysql_num_rows($check);

	if($exists > 0){
		$row = mysql_fetch_assoc($check);

		if($placeAll == "true"){
			$amount = $row['amount'];
		} else {
			$amount = 1;
		}

		$header_pack = "X-JSON: [";

		for ($i = 1; $i <= $amount; $i++) {
			if($linked > 0){
				mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,x,y,z,type,subtype,data,skin) VALUES ('".$user->row['id']."','".$groupid."','10','10','".$z."','1','0','".$row['data']."','')") or die(mysql_error());
				$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND type = '1' AND data = '".$row['data']."' ORDER BY id DESC LIMIT 1") or die(mysql_error());
			} else {
				mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,x,y,z,type,subtype,data,skin) VALUES ('".$user->row['id']."','-1','10','10','".$z."','1','0','".$row['data']."','')") or die(mysql_error());
				$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '1' AND data = '".$row['data']."' ORDER BY id DESC LIMIT 1") or die(mysql_error());
			}
			$assoc = mysql_fetch_assoc($check);
			$edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"sticker-" . $assoc['id'] . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"sticker-" . $assoc['id'] . "-edit\", \"click\", function(e) { openEditMenu(e, " . $assoc['id'] . ", \"sticker\", \"sticker-" . $assoc['id'] . "-edit\"); }, false);
</script>\n";
			$sticker_pack = $sticker_pack . "<div class=\"movable sticker s_" . $row['data'] . "\" style=\"left: 10px; top: 10px; z-index: " . $z . "\" id=\"sticker-" . $assoc['id'] . "\">\n" . $edit . "\n</div>\n";
			if($i == 1){ // X-JSON: [1
				$header_pack = $header_pack . $assoc['id'];
			} else { // X-JSON [1,2
				$header_pack = $header_pack . "," . $assoc['id'];
			}
		}

		$header_pack = $header_pack . "]";

		if($placeAll == "true"){
			mysql_query("DELETE FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND id = '".$id."' AND type = '1' LIMIT 1");
		} else {
			$input->UpdateOrDelete($id,$user->row['id']);
		}

		header($header_pack);
		echo $sticker_pack;

 	}

} elseif($mode == "background_warning"){
?>
<p>
L'immagine selezionata rimarra come sfondo della pagina finche non si seleziona un altra immagine o si chiudera il Webstore. Se si desidera mantenere come immagine di sfondo, sara necessario acquistare e selezionare dal vostro inventario.
</p>

<p>
<a href="#" class="new-button" id="webstore-warning-ok"><b>OK</b><i></i></a>
</p>

<div class="clear"></div>
<?php
} else {
//echo "<b>¡Error Fatal!</b> Ha sucedido un error al tener el Modo:  " . $mode . ".";
header("Location: index");
}
?>