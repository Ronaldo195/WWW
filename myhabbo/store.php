<?php
require_once('../core.php');
require_once('../includes/session.php');

$check = mysql_query("SELECT groupid,active FROM cms_homes_group_linker WHERE userid = '".$user->row['id']."' AND active = '1' LIMIT 1");
$linked = mysql_num_rows($check);

$refer = $_SERVER['HTTP_REFERER'];

if($linked > 0){
	$linkdata = mysql_fetch_assoc($check);
	$groupid = $linkdata['groupid'];
	$pos = strrpos($refer, "groups/");
} else {
	$pos = strrpos($refer, "home/");
}

if ($pos === false) {
	echo "<strong>La sessione di modifica &egrave; scaduta</strong>";
	exit;
}

$mode = $_GET['key'];

if($mode == "inventory"){

// Look for the first inventory sticker in the DB for the header
$tmp = mysql_query("SELECT data FROM cms_homes_inventory WHERE type = '1' AND userid = '".$user->row['id']."' LIMIT 1");
$valid = mysql_num_rows($tmp);

if($valid > 0){
	$row = mysql_fetch_assoc($tmp);
	header("X-JSON: [[\"Inventario\",\"Webstore\"],[\"" . $input->formatThing(1,$row['data'],true) . "\",\"" . $input->formatThing(1,$row['data'],false) . "\",\"".$row['data']."\",\"Sticker\",null,1]]");
} else {
	header("X-JSON: [[\"Inventario\",\"Webstore\"],[]]");
}

?>
<div style="position: relative;">
<div id="webstore-categories-container">
	<h4>Categorie:</h4>
	<div id="webstore-categories">
<ul class="purchase-main-category">
		<li id="maincategory-1-stickers" class="selected-main-category webstore-selected-main">
			<div>Stickers</div>
			<ul class="purchase-subcategory-list" id="main-category-items-1">
				<?php if($user->row['rank'] > 4){ ?>
				<li id="subcategory-1-50-stickers" class="subcategory">
					<div><strong><font color='red'><?php echo $site['short']; ?> Staff</strong></font></div>
				</li>
				<?php } ?>
				<li id="subcategory-1-214-stickers" class="subcategory">
					<div>Pubblicit&agrave</div>
				</li>
				<li id="subcategory-1-205-stickers" class="subcategory">
					<div>Alhambra</div>
				</li>
				<li id="subcategory-1-211-stickers" class="subcategory">
					<div>Alfabeto Bling</div>
				</li>
				<li id="subcategory-1-203-stickers" class="subcategory">
					<div>Alfabeto Plastic</div>
				</li>
				<li id="subcategory-1-227-stickers" class="subcategory">
					<div>Alfabeto Legno</div>
				</li>
				<li id="subcategory-1-242-stickers" class="subcategory">
					<div>Alfabeto Blu Diner</div>
				</li>
				<li id="subcategory-1-244-stickers" class="subcategory">
					<div>Alfabeto Diner Verde</div>
				</li>
				<li id="subcategory-1-246-stickers" class="subcategory">
					<div>Alfabeto Diner Rosso</div>
				</li>
				<li id="subcategory-1-236-stickers" class="subcategory">
					<div>Graffiti</div>
				</li>
				<li id="subcategory-1-206-stickers" class="subcategory">
					<div>Compleanno</div>
				</li>
				<li id="subcategory-1-215-stickers" class="subcategory">
					<div>Motivi</div>
				</li>
				<li id="subcategory-1-204-stickers" class="subcategory">
					<div>Trax</div>
				</li>
				<li id="subcategory-1-223-stickers" class="subcategory">
					<div>Celebrazioni</div>
				</li>
				<li id="subcategory-1-217-stickers" class="subcategory">
					<div>Cina</div>
				</li>
				<li id="subcategory-1-201-stickers" class="subcategory">
					<div>Clubber</div>
				</li>
				<li id="subcategory-1-245-stickers" class="subcategory">
					<div>Batman</div>
				</li>
				<li id="subcategory-1-243-stickers" class="subcategory">
					<div>Diner</div>
				</li>
				<li id="subcategory-1-235-stickers" class="subcategory">
					<div>Eco</div>
				</li>
				<li id="subcategory-1-240-stickers" class="subcategory">
					<div>FX</div>
				</li>
				<li id="subcategory-1-208-stickers" class="subcategory">
					<div>Travestimenti</div>
				</li>
				<li id="subcategory-1-219-stickers" class="subcategory">
					<div>Gotico</div>
				</li>
				<li id="subcategory-1-238-stickers" class="subcategory">
					<div>Evidenziatori</div>
				</li>
				<li id="subcategory-1-213-stickers" class="subcategory">
					<div>Hockey</div>
				</li>
				<li id="subcategory-1-239-stickers" class="subcategory">
					<div>Inchiostrato</div>
				</li>
				<li id="subcategory-1-224-stickers" class="subcategory">
					<div>Japanese</div>
				</li>
				<li id="subcategory-1-225-stickers" class="subcategory">
					<div>Keep it Real (NOT!)</div>
				</li>
				<li id="subcategory-1-226-stickers" class="subcategory">
					<div>Amore</div>
				</li>
				<li id="subcategory-1-216-stickers" class="subcategory">
					<div><?echo $site['short']; ?></div>
				</li>
				<li id="subcategory-1-220-stickers" class="subcategory">
					<div><?echo $site['short']; ?>ween</div>
				</li>
				<li id="subcategory-1-221-stickers" class="subcategory">
					<div><?echo $site['short']; ?>wood</div>
				</li>
				<li id="subcategory-1-247-stickers" class="subcategory">
					<div>Olimpiadi</div>
				</li>
				<li id="subcategory-1-228-stickers" class="subcategory">
					<div>Altri 1</div>
				</li>
				<li id="subcategory-1-229-stickers" class="subcategory">
					<div>altri 2</div>
				</li>
				<li id="subcategory-1-230-stickers" class="subcategory">
					<div>altri 3</div>
				</li>
				<li id="subcategory-1-212-stickers" class="subcategory">
					<div>Super Mario</div>
				</li>
				<li id="subcategory-1-222-stickers" class="subcategory">
					<div>Frecce e Indicatori</div>
				</li>
				<li id="subcategory-1-232-stickers" class="subcategory">
					<div>Calcio</div>
				</li>
				<li id="subcategory-1-237-stickers" class="subcategory">
					<div>Scintillante</div>
				</li>
				<li id="subcategory-1-210-stickers" class="subcategory">
					<div>Pasqua</div>
				</li>
				<li id="subcategory-1-241-stickers" class="subcategory">
					<div>San Patrizio</div>
				</li>
				<li id="subcategory-1-207-stickers" class="subcategory">
					<div>Estate</div>
				</li>
				<li id="subcategory-1-209-stickers" class="subcategory">
					<div>Wrestling</div>
				</li>
				<?php if($user->row['rank'] > 5){ ?>
				<li id="subcategory-1-1000-stickers" class="subcategory">
					<div>Non disponibile</div>
				</li>
				<?php } ?>
			</ul>
		</li>
		<li id="maincategory-2-backgrounds" class="main-category">
			<div>Background</div>
			<ul class="purchase-subcategory-list" id="main-category-items-2">
				<li id="subcategory-2-127-stickers" class="subcategory">
					<div>Background 1</div>
				</li>
				<li id="subcategory-2-128-stickers" class="subcategory">
					<div>Background 2</div>
				</li>
				<li id="subcategory-2-129-stickers" class="subcategory">
					<div>Background 3</div>
				</li>
				<li id="subcategory-2-130-stickers" class="subcategory">
					<div>Background 4</div>
				</li>
				<li id="subcategory-2-131-stickers" class="subcategory">
					<div>Background 5</div>
				</li>
				<li id="subcategory-2-132-stickers" class="subcategory">
					<div>Background 6</div>
				</li>
				<li id="subcategory-2-248-stickers" class="subcategory">
					<div>Background 7</div>
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
</ul>
	</div>
</div>

<div id="webstore-content-container">
	<div id="webstore-items-container">
		<h4>Clicca su un oggetto per selezionarlo</h4>
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
		<div>Stickers</div>
	</li>
	<li id="inv-cat-backgrounds" class="main-category-no-subcategories">
		<div>Background</div>
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
		<h4>Clicca su uno sticker per selezionarlo:</h4>
		<div id="inventory-items"><ul id="inventory-item-list">
<?php
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '1'");
	$typ = "sticker";
	$number = mysql_num_rows($get_em);

	if($number < 1){
	echo "<div class=\"webstore-frank\">
	<div class=\"blackbubble\">
		<div class=\"blackbubble-body\">

<p><b>Questa categoria &egrave vuota!</b></p>
<p>Per comprare sticker apri il webstore selezionane uno e clicca sul tasto compra!</p>

		<div class=\"clear\"></div>
		</div>
	</div>
	<div class=\"blackbubble-bottom\">
		<div class=\"blackbubble-bottom-body\">
			<img src=\"".PATH."web-gallery/images/box-scale/bubble_tail_small.gif\" alt=\"\" width=\"12\" height=\"21\" class=\"invitation-tail\" />
		</div>
	</div>
	<div class=\"webstore-frank-image\"><img src=\"".PATH."web-gallery/images/frank/sorry.gif\" alt=\"\" width=\"57\" height=\"88\" /></div>
</div>";
	}

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
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '1'");
	$typ = "sticker";
	} else if($type == "notes"){
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '3'");
	$typ = "note";
	} else if($type == "widgets"){
	$typ = "widget";
	} else if($type == "backgrounds"){
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '4'");
	$typ = "background";
	} else {
	$get_em = mysql_query("SELECT * FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '1'");
	$typ = "sticker";
	}

	if($typ !== "widget"){
		$number = mysql_num_rows($get_em);
		echo "		<ul id=\"webstore-item-list\">";

		if($number < 1){
			echo "<div class=\"webstore-frank\">
	<div class=\"blackbubble\">
		<div class=\"blackbubble-body\">

<p><b>Questa categoria &egrave vuota!</b></p>
<p>Per comprare sticker apri il webstore selezionane uno e clicca sul tasto compra!</p>

		<div class=\"clear\"></div>
		</div>
	</div>
	<div class=\"blackbubble-bottom\">
		<div class=\"blackbubble-bottom-body\">
			<img src=\"".PATH."web-gallery/images/box-scale/bubble_tail_small.gif\" alt=\"\" width=\"12\" height=\"21\" class=\"invitation-tail\" />
		</div>
	</div>
	<div class=\"webstore-frank-image\"><img src=\"".PATH."web-gallery/images/frank/sorry.gif\" alt=\"\" width=\"57\" height=\"88\" /></div>
</div>";
	}

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
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE groupid = '".$groupid."' AND type = '2' AND subtype = '3' LIMIT 1");
			$placed_memberwidget = mysql_num_rows($check);
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE groupid = '".$groupid."' AND type = '2' AND subtype = '4' LIMIT 1");
			$placed_guestbookwidget = mysql_num_rows($check);

			echo "<ul id=\"inventory-item-list\">";
			echo "
			<li id=\"inventory-item-p-3\"
		title=\"My Groups\" class=\"webstore-widget-item"; if($placed_memberwidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_memberwidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>I Membri del mio gruppo</h3>
			<p>Visualizza i membri del tuo gruppo sulla tua home.</p>
		</div>
	</li>";
	echo "<li id=\"inventory-item-p-4\"
		title=\"Guestbook\" class=\"webstore-widget-item"; if($placed_guestbookwidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_guestbookwidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Guestbook</h3>
			<p>Permette agli altri di lasciati messaggi</p>
		</div>
	</li>
	
	</li>";
			echo "</ul>";
		} else { // User profile
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '2' LIMIT 1");
			$placed_groupwidget = mysql_num_rows($check);
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '3' LIMIT 1");
			$placed_roomwidget = mysql_num_rows($check);
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '4' LIMIT 1");
			$placed_guestbookwidget = mysql_num_rows($check);
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '5' LIMIT 1");
			$placed_friendswidget = mysql_num_rows($check);
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '9' LIMIT 1");
			$placed_ratewidget = mysql_num_rows($check);
			$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '2' AND subtype = '8' LIMIT 1");
			$placed_badgeswidget = mysql_num_rows($check);

			echo "<ul id=\"inventory-item-list\">";
	echo "
	<li id=\"inventory-item-p-2\"
		title=\"I Miei Gruppi\" class=\"webstore-widget-item"; if($placed_groupwidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_groupswidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>I Miei Gruppi</h3>
			<p>Visualizza i Gruppi di cui fai parte</p>
		</div>
	</li>
	<li id=\"inventory-item-p-3\"
		title=\"Le mie Stanze\" class=\"webstore-widget-item"; if($placed_roomwidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_roomswidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Le mie Stanze</h3>
			<p>Visualizza le tue Stanze.</p>
		</div>
	</li>
	<li id=\"inventory-item-p-4\"
		title=\"Guestbook\" class=\"webstore-widget-item"; if($placed_guestbookwidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_guestbookwidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>Guestbook</h3>
			<p>Permette agli altri di lasciarti messaggi.</p>
		</div>
	</li>
	<li id=\"inventory-item-p-9\"
		title=\"I miei Voti\" class=\"webstore-widget-item" ; if($placed_ratewidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_ratingwidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>I miei Voti</h3>
			<p>Mostra quanto sei figo!</p>
		</div>
	</li>
	<li id=\"inventory-item-p-5\"
		title=\"I Miei Amici\" class=\"webstore-widget-item"; if($placed_friendswidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_friendswidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>I Miei Amici</h3>
			<p>Fai conoscere a tutti i tuoi Amici!</p>
		</div>
	</li>
	
	</li>
	<li id=\"inventory-item-p-8\"
		title=\"I miei Distintivi\" class=\"webstore-widget-item" ; if($placed_badgeswidget > 0){ echo " webstore-widget-disabled"; } echo "\">
		<div class=\"webstore-item-preview w_badgeswidget_pre\" >
			<div class=\"webstore-item-mask\">

			</div>
		</div>
		<div class=\"webstore-widget-description\">
			<h3>I miei Distintivi</h3>
			<p>Mostra i tuoi distintivi nella tua pagina.</p>
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
	header("X-JSON: [[\"Inventario\",\"Webstore\"],[{\"itemCount\":1,\"titleKey\":\"".$row['name']."\",\"previewCssClass\":\"".$input->formatThing($row['type'],$row['data'],true)."\"}]]");
} else {
	header("X-JSON: [[\"Inventario\",\"Webstore\"],[]]");
}

?>
<div style="position: relative;">
<div id="webstore-categories-container">
	<h4>Categorie:</h4>
	<div id="webstore-categories">
<ul class="purchase-main-category">
		<li id="maincategory-1-stickers" class="selected-main-category webstore-selected-main">
			<div>Stickers</div>
			<ul class="purchase-subcategory-list" id="main-category-items-1">
				<?php if($user->row['rank'] > 5){ ?>
				<li id="subcategory-1-50-stickers" class="subcategory">
					<div><strong><font color='red'><?php echo $site['short']; ?> Staff</strong></font></div>
				</li>
				<?php } ?>
				<li id="subcategory-1-214-stickers" class="subcategory">
										<div>Pubblicit&agrave</div>
				</li>
				<li id="subcategory-1-205-stickers" class="subcategory">
					<div>Alhambra</div>
				</li>
				<li id="subcategory-1-211-stickers" class="subcategory">
					<div>Alfabeto Bling</div>
				</li>
				<li id="subcategory-1-203-stickers" class="subcategory">
					<div>Alfabeto Plastic</div>
				</li>
				<li id="subcategory-1-227-stickers" class="subcategory">
					<div>Alfabeto Legno</div>
				</li>
				<li id="subcategory-1-242-stickers" class="subcategory">
					<div>Alfabeto Blu Diner</div>
				</li>
				<li id="subcategory-1-244-stickers" class="subcategory">
					<div>Alfabeto Diner Verde</div>
				</li>
				<li id="subcategory-1-246-stickers" class="subcategory">
					<div>Alfabeto Diner Rosso</div>
				</li>
				<li id="subcategory-1-236-stickers" class="subcategory">
					<div>Graffiti</div>
				</li>
				<li id="subcategory-1-206-stickers" class="subcategory">
					<div>Compleanno</div>
				</li>
				<li id="subcategory-1-215-stickers" class="subcategory">
					<div>Motivi</div>
				</li>
				<li id="subcategory-1-204-stickers" class="subcategory">
					<div>Trax</div>
				</li>
				<li id="subcategory-1-223-stickers" class="subcategory">
					<div>Celebrazioni</div>
				</li>
				<li id="subcategory-1-217-stickers" class="subcategory">
					<div>Cina</div>
				</li>
				<li id="subcategory-1-201-stickers" class="subcategory">
					<div>Clubber</div>
				</li>
				<li id="subcategory-1-245-stickers" class="subcategory">
					<div>Batman</div>
				</li>
				<li id="subcategory-1-243-stickers" class="subcategory">
					<div>Diner</div>
				</li>
				<li id="subcategory-1-235-stickers" class="subcategory">
					<div>Eco</div>
				</li>
				<li id="subcategory-1-240-stickers" class="subcategory">
					<div>FX</div>
				</li>
				<li id="subcategory-1-208-stickers" class="subcategory">
					<div>Travestimenti</div>
				</li>
				<li id="subcategory-1-219-stickers" class="subcategory">
					<div>Gotico</div>
				</li>
				<li id="subcategory-1-238-stickers" class="subcategory">
					<div>Evidenziatori</div>
				</li>
				<li id="subcategory-1-213-stickers" class="subcategory">
					<div>Hockey</div>
				</li>
				<li id="subcategory-1-239-stickers" class="subcategory">
					<div>Inchiostrato</div>
				</li>
				<li id="subcategory-1-224-stickers" class="subcategory">
					<div>Japanese</div>
				</li>
				<li id="subcategory-1-225-stickers" class="subcategory">
					<div>Keep it Real (NOT!)</div>
				</li>
				<li id="subcategory-1-226-stickers" class="subcategory">
					<div>Amore</div>
				</li>
				<li id="subcategory-1-216-stickers" class="subcategory">
					<div><?echo $site['short']; ?></div>
				</li>
				<li id="subcategory-1-220-stickers" class="subcategory">
					<div><?echo $site['short']; ?>ween</div>
				</li>
				<li id="subcategory-1-221-stickers" class="subcategory">
					<div><?echo $site['short']; ?>wood</div>
				</li>
				<li id="subcategory-1-247-stickers" class="subcategory">
					<div>Olimpiadi</div>
				</li>
				<li id="subcategory-1-228-stickers" class="subcategory">
					<div>Altri 1</div>
				</li>
				<li id="subcategory-1-229-stickers" class="subcategory">
					<div>altri 2</div>
				</li>
				<li id="subcategory-1-230-stickers" class="subcategory">
					<div>altri 3</div>
				</li>
				<li id="subcategory-1-212-stickers" class="subcategory">
					<div>Super Mario</div>
				</li>
				<li id="subcategory-1-222-stickers" class="subcategory">
					<div>Frecce e Indicatori</div>
				</li>
				<li id="subcategory-1-232-stickers" class="subcategory">
					<div>Calcio</div>
				</li>
				<li id="subcategory-1-237-stickers" class="subcategory">
					<div>Scintillante</div>
				</li>
				<li id="subcategory-1-210-stickers" class="subcategory">
					<div>Pasqua</div>
				</li>
				<li id="subcategory-1-241-stickers" class="subcategory">
					<div>San Patrizio</div>
				</li>
				<li id="subcategory-1-207-stickers" class="subcategory">
					<div>Estate</div>
				</li>
				<li id="subcategory-1-209-stickers" class="subcategory">
					<div>Wrestling</div>
				</li>
				<?php if($user->row['rank'] > 5){ ?>
				<li id="subcategory-1-1000-stickers" class="subcategory">
					<div>Non disponibile</div>
				</li>
				<?php } ?>
			</ul>
		</li>
		<li id="maincategory-2-backgrounds" class="main-category">
			<div>Background</div>
			<ul class="purchase-subcategory-list" id="main-category-items-2">
				<li id="subcategory-2-127-stickers" class="subcategory">
					<div>Background 1</div>
				</li>
				<li id="subcategory-2-128-stickers" class="subcategory">
					<div>Background 2</div>
				</li>
				<li id="subcategory-2-129-stickers" class="subcategory">
					<div>Background 3</div>
				</li>
				<li id="subcategory-2-130-stickers" class="subcategory">
					<div>Background 4</div>
				</li>
				<li id="subcategory-2-131-stickers" class="subcategory">
					<div>Background 5</div>
				</li>
				<li id="subcategory-2-132-stickers" class="subcategory">
					<div>Background 6</div>
				</li>
				<li id="subcategory-2-248-stickers" class="subcategory">
					<div>Background 7</div>
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
</ul>

	</div>
</div>

<div id="webstore-content-container">
	<div id="webstore-items-container">
		<h4>Clicca su un oggetto per selezionarlo</h4>
		<div id="webstore-items">

<?php
	$category = "19";

	$get_em = mysql_query("SELECT * FROM cms_homes_catalouge WHERE category = '".$category."'");
	$number = mysql_num_rows($get_em);

	echo "		<ul id=\"webstore-item-list\">";

	if($number < 1){
	echo "<div class=\"webstore-frank\">
	<div class=\"blackbubble\">
		<div class=\"blackbubble-body\">

<p><b>This category is empty!</b></p>
<p>Watch this space - we add new items all the time!</p>

		<div class=\"clear\"></div>
		</div>
	</div>
	<div class=\"blackbubble-bottom\">
		<div class=\"blackbubble-bottom-body\">
			<img src=\"".PATH."web-gallery/images/box-scale/bubble_tail_small.gif\" alt=\"\" width=\"12\" height=\"21\" class=\"invitation-tail\" />
		</div>
	</div>
	<div class=\"webstore-frank-image\"><img src=\"".PATH."web-gallery/images/frank/sorry.gif\" alt=\"\" width=\"57\" height=\"88\" /></div>
</div>";
	}

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
Hai:<br /><b><?php echo $user->row['credits']; ?> Crediti</b><br />
<?php if($user->row['credits'] < $row['price']){ ?><span class="webstore-preview-error">You don't have enough Credits to buy this item.</span><br />
<a href="credits.php" target=_blank>Get Credits</a><?php } ?>
</div>

<div id="webstore-preview-purchase" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button <?php if($user->row['credits'] < $row['price']){ ?>disabled-button<?php } ?>" <?php if($user->row['credits'] < $row['price']){ ?>disabled="disabled"<?php } ?> id="webstore-purchase<?php if($user->row['credits'] < $row['price']){ ?>-disabled<?php } ?>"><b>Compra</b><i></i></a>
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
		<div>Stickers</div>
	</li>
	<li id="inv-cat-backgrounds" class="main-category-no-subcategories">
		<div>Background</div>
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
		<h4>Clicca su uno sticker per selezionarlo:</h4>
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

$productId = $input->FilterText($_POST['productId']);
$subCategoryId = $input->FilterText($_POST['subCategoryId']);

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' AND category = '".$subCategoryId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

$bg_pre = "";
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
Hai:<br /><b><?php echo $user->row['credits']; ?> Crediti</b><br />
<?php if($user->row['credits'] < $row['price']){ ?><span class="webstore-preview-error">You don't have enough Credits to buy this item.</span><br />
<a href="credits.php" target=_blank>Get Credits</a><?php } ?>
</div>

<div id="webstore-preview-purchase" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button <?php if($user->row['credits'] < $row['price']){ ?>disabled-button<?php } ?>" <?php if($user->row['credits'] < $row['price']){ ?>disabled="disabled"<?php } ?> id="webstore-purchase<?php if($user->row['credits'] < $row['price']){ ?>-disabled<?php } ?>"><b>Compra</b><i></i></a>
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
		<p>Sei sicuro di voler comprare <b><?php echo $row['name']; ?></b>? Questo prodotto costa <b><?php echo $row['price']; ?></b> crediti!</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>Annulla</b><i></i></a>
		<a href="#" class="new-button" id="webstore-confirm-submit"><b>Avanti</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	} else {
?>
		<p>Sorry, but you can not buy this item!</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	}
} elseif($mode == "purchase_stickers"){
$productId = $input->FilterText($_POST['selectedId']);

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

if($row['category'] == "50" && $user->row['rank'] < 6){ exit; }

	if($exists > 0){
		if($user->row['credits'] < $row['price']){
		?>
		<p>Non hai abbastanza crediti per comprare quest'oggetto!</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
		<?php
		} else {
			mysql_query("UPDATE users SET credits = credits - ".$row['price']." WHERE id = '".$user->row['id']."' LIMIT 1");
			$input->UpdateOrInsert($row['type'],$row['amount'],$row['data'],$user->row['id']);
			mysql_query("INSERT INTO cms_transactions (userid,amount,date,descr) VALUES ('".$user->row['id']."','-".$row['price']."','".$date_full."','Webstore purchase')");
			echo "OK";
		}
	} else {
?>
		<p>Sorry, but you can not buy this item! <?php echo $productId; ?></p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	}
} elseif($mode == "items"){

	$category = isset($_POST['subCategoryId']) ? $input->FilterText($_POST['subCategoryId']) : "";

	if($category == "50" && $user->row['rank'] < 6){ exit; }

	$get_em = mysql_query("SELECT * FROM cms_homes_catalouge WHERE category = ".$category) or die();
	$number = mysql_num_rows($get_em) or die(0);

	echo "		<ul id=\"webstore-item-list\">";

	if($number < 1){
	echo "<div class=\"webstore-frank\">
	<div class=\"blackbubble\">
		<div class=\"blackbubble-body\">

<p><b>Questa categoria &egrave; vuota!</b></p>
<p>Tieni d'occhio questo spazio - si aggiungono nuovi elementi per tutto il tempo!</p>

		<div class=\"clear\"></div>
		</div>
	</div>
	<div class=\"blackbubble-bottom\">
		<div class=\"blackbubble-bottom-body\">
			<img src=\"".PATH."web-gallery/images/box-scale/bubble_tail_small.gif\" alt=\"\" width=\"12\" height=\"21\" class=\"invitation-tail\" />
		</div>
	</div>
	<div class=\"webstore-frank-image\"><img src=\"".PATH."web-gallery/images/frank/sorry.gif\" alt=\"\" width=\"57\" height=\"88\" /></div>
</div>";
	}
	if($number > 0)
	while ($row = mysql_fetch_assoc($get_em)){

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
$productId = $input->FilterText($_POST['selectedId']);

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

if($row['category'] == "50" && $user->row['rank'] < 6){ exit; }

	if($exists > 0){
		if($user->row['credits'] < $row['price']){
		?>
		<p>Non hai abbastanza crediti per comprare quest'oggetto!</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
		<?php
		} else {
			$tcheck = mysql_query("SELECT id FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '4' AND data = '".$row['data']."' LIMIT 1");
			$tnum = mysql_num_rows($tcheck);
			if($tnum > 0){ ?>
		<p>You already have a background of this type in your inventory!</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
			<?php } else {
				mysql_query("UPDATE users SET credits = credits - ".$row['price']." WHERE id = '".$user->row['id']."' LIMIT 1");
				$input->UpdateOrInsert($row['type'],$row['amount'],$row['data'],$user->row['id']);
				mysql_query("INSERT INTO cms_transactions (userid,amount,date,descr) VALUES ('".$user->row['id']."','-".$row['price']."','".$date_full."','Webstore purchase')");
				echo "OK";
			}
		}
	} else {
?>
		<p>Sorry, but you can not buy this item!</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
<?php
	}
} elseif($mode == "purchase_stickie_notes"){
$productId = $input->FilterText($_POST['selectedId']); if(!is_numeric($productId)){ exit; }

$tmp = mysql_query("SELECT * FROM cms_homes_catalouge WHERE id = '".$productId."' LIMIT 1");
$exists = mysql_num_rows($tmp);
$row = mysql_fetch_assoc($tmp);

if($row['category'] == "50" && $user->row['rank'] < 6){ exit; }

	if($exists > 0){
		if($user->row['credits'] < $row['price']){
		?>
		<p>Non hai abbastanza crediti per comprare quest'oggetto!</p>

	<p class="new-buttons">
		<a href="#" class="new-button" id="webstore-confirm-cancel"><b>OK</b><i></i></a>
	</p>
	<div class="clear"></div>
		<?php
		} else {
			mysql_query("UPDATE users SET credits = credits - ".$row['price']." WHERE id = '".$user->row['id']."' LIMIT 1");
			$input->UpdateOrInsert($row['type'],$row['amount'],$row['data'],$user->row['id']);
			mysql_query("INSERT INTO cms_transactions (userid,amount,date,descr) VALUES ('".$user->row['id']."','-".$row['price']."','".$date_full."','Webstore purchase')");
			echo "OK";
		}
	} else {
?>
		<p>Sorry, but you can not buy this item! <?php echo $productId; ?></p>

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
	$productId = $input->FilterText($_POST['itemId']); if(!is_numeric($productId)){ exit; }
	$tmp = mysql_query("SELECT * FROM cms_homes_inventory WHERE id = '".$productId."' AND userid = '".$user->row['id']."' LIMIT 1");
	$exists = mysql_num_rows($tmp);
	$row = mysql_fetch_assoc($tmp);
}

$amount = isset($row['amount']) ? $row['amount'] : 1;
header("X-JSON: [\"" . $input->formatThing($row['type'],$row['data'],true) . "\",\"" . $input->formatThing($row['type'],$row['data'],false) . "\",\"8\",\"".$_POST['type']."\",null,".$amount."]");

?>
<h4>&nbsp;</h4>

<div id="inventory-preview-box"></div>

<div id="inventory-preview-place" class="clearfix">
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place"><b>Posiziona</b><i></i></a>
	</div>
<?php if($amount > 1 && $row['type'] == "1"){ ?>
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place-all"><b>Posiziona tutti</b><i></i></a>
	</div>
<?php } ?>
</div>
<?php
} elseif($mode == "noteeditor"){
?>
<form action="#" method="post" id="webstore-notes-form">

<input type="hidden" name="maxlength" id="webstore-notes-maxlength" value="800" />

<div id="webstore-notes-counter"><?php $text = isset($_POST['noteText']) ? strlen($input->HoloText($_POST['noteText'])) : 0; echo 800 - $text; ?></div>

<p>
	<select id="webstore-notes-skin" name="skin">
			<option value="1" id="webstore-notes-skin-defaultskin">Standard</option>
			<option value="6" id="webstore-notes-skin-goldenskin">Oro</option>
			<option value="3" id="webstore-notes-skin-metalskin">Metallico</option>
			<option value="5" id="webstore-notes-skin-notepadskin">Blocco appunti</option>
			<option value="2" id="webstore-notes-skin-speechbubbleskin">Fumettoso</option>
			<option value="4" id="webstore-notes-skin-noteitskin">Post-it</option>
	                <?php if($user->row['rank'] > 4){ ?><option value="9" id="webstore-notes-skin-nakedskin">Staff - Trasparente</option>
                        <?php } ?></select>
</p>

<p class="warning">ATTENZIONE!: I post-it non si possono modificare una volta posizionati in home!</p>

<div id="webstore-notes-edit-container">
<textarea id="webstore-notes-text" rows="7" cols="42" name="noteText"><?php $text = isset($_POST['noteText']) ? $input->HoloText($_POST['noteText']) : ""; echo $text; ?></textarea>
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
        bbcodeToolbar.addColorSelect("Colori", colors, true);
    </script>


</form>

<p>
<a href="#" class="new-button" id="webstore-confirm-cancel"><b>Annulla</b><i></i></a>
<a href="#" class="new-button" id="webstore-notes-continue"><b>Avanti</b><i></i></a>
</p>

<div class="clear"></div>
<?php
} elseif($mode == "noteeditor-preview"){
?>
<div id="webstore-notes-container">
<?php
if($user->row['rank'] < 6){ $text = $input->FilterText($_POST['noteText']); } else { $text = $input->FilterText($_POST['noteText']); }
$newskin = $input->FilterText($_POST['skin']);

	if($newskin == 1){ $skin = "defaultskin"; }
	else if($newskin == 2){ $skin = "speechbubbleskin"; }
	else if($newskin == 3){ $skin = "metalskin"; }
	else if($newskin == 4){ $skin = "noteitskin"; }
	else if($newskin == 5){ $skin = "notepadskin"; }
	else if($newskin == 6){ $skin = "goldenskin"; }
        else if($newskin == 9){ $skin = "nakedskin"; }
	else { $skin = "defaultskin"; }

	echo "<div class=\"movable stickie n_skin_".$skin."-c\" style=\" left: 0px; top: 0px; z-index: 1;\" id=\"stickie--1\">
	<div class=\"n_skin_".$skin."\" >
		<div class=\"stickie-header\">
			<h3></h3>
			<div class=\"clear\"></div>
		</div>
		<div class=\"stickie-body\">
			<div class=\"stickie-content\">
				<div class=\"stickie-markup\">" . $input->bbcode_format(nl2br($input->HoloText($text))) . "</div>
				<div class=\"stickie-footer\">
				</div>
			</div>
		</div>
	</div>
</div></div>";
?>
<p class="warning">ATTENZIONE!: I post-it non si possono modificare una volta posizionati in home!</p>

<p>
<a href="#" class="new-button" id="webstore-notes-edit"><b>Modifica</b><i></i></a>
<a href="#" class="new-button" id="webstore-notes-add"><b>Aggiungi alla pagina</b><i></i></a>
</p>

<div class="clear"></div>
<?php
} elseif($mode == "noteeditor-place"){

	if($user->row['rank'] < 6){ $data = $input->FilterText($_POST['noteText']); } else { $data = $input->FilterText($_POST['noteText']); }
	$newskin = $input->FilterText($_POST['skin']);

	if($newskin == 1){ $skin = "defaultskin"; }
	else if($newskin == 2){ $skin = "speechbubbleskin"; }
	else if($newskin == 3){ $skin = "metalskin"; }
	else if($newskin == 4){ $skin = "noteitskin"; }
	else if($newskin == 5){ $skin = "notepadskin"; }
	else if($newskin == 6){ $skin = "goldenskin"; }
        else if($newskin == 9){ $skin = "nakedskin"; }
	else { $skin = "defaultskin"; }

	if(strlen($data) < 501 && strlen($data) > 0){

		if($linked > 0){
			mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,x,y,z,data,type,subtype,skin) VALUES ('".$user->row['id']."','".$groupid."','10','10','18','".$input->FilterText($data)."','3','0','".$skin."')");
			$sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND type = '3' AND data = '".$input->FilterText($data)."' ORDER BY id DESC LIMIT 1");
			$sql2 = mysql_query("SELECT id FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '3' LIMIT 1");
		} else {
			mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,x,y,z,data,type,subtype,skin) VALUES ('".$user->row['id']."','-1','10','10','18','".$input->FilterText($data)."','3','0','".$skin."')");
			$sql = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '3' AND data = '".$input->FilterText($data)."' ORDER BY id DESC LIMIT 1");
			$sql2 = mysql_query("SELECT id FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '3' LIMIT 1");
		}

		$row = mysql_fetch_assoc($sql);
		$row2 = mysql_fetch_assoc($sql2);

		$input->UpdateOrDelete($row2['id'],$user->row['id']);

		$id = $row['id'];
		header("X-JSON: " . $id );

		$edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"stickie-" . $id . "-edit\" />
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
				<div class=\"stickie-markup\">" . $input->bbcode_format(nl2br($input->HoloText($data))) . "</div>
				<div class=\"stickie-footer\">
				</div>
			</div>
		</div>
	</div>
</div></div>";

	}
} elseif($mode == "place_sticker"){

$id = $input->FilterText($_POST['selectedStickerId']);
$z = $input->FilterText($_POST['zindex']);
$placeAll = isset($_POST['placeAll']) ? $input->FilterText($_POST['placeAll']) : "";

$check = mysql_query("SELECT data,amount FROM cms_homes_inventory WHERE userid = '".$user->row['id']."' AND type = '1' AND id = '".$id."' LIMIT 1");
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
				mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,x,y,z,type,subtype,data,skin) VALUES ('".$user->row['id']."','".$groupid."','10','10','".$z."','1','0','".$row['data']."','')");
				$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' AND type = '1' AND data = '".$row['data']."' ORDER BY id DESC LIMIT 1");
			} else {
				mysql_query("INSERT INTO cms_homes_stickers (userid,groupid,x,y,z,type,subtype,data,skin) VALUES ('".$user->row['id']."','-1','10','10','".$z."','1','0','".$row['data']."','')");
				$check = mysql_query("SELECT id FROM cms_homes_stickers WHERE userid = '".$user->row['id']."' AND groupid = '-1' AND type = '1' AND data = '".$row['data']."' ORDER BY id DESC LIMIT 1");
			}
			$assoc = mysql_fetch_assoc($check);
			$edit = "\n<img src=\"".PATH."web-gallery/images/myhabbo/icon_edit.gif\" width=\"19\" height=\"18\" class=\"edit-button\" id=\"sticker-" . $assoc['id'] . "-edit\" />
<script language=\"JavaScript\" type=\"text/javascript\">
Event.observe(\"sticker-" . $assoc['id'] . "-edit\", \"click\", function(e) { openEditMenu(e, " . $assoc['id'] . ", \"sticker\", \"sticker-" . $assoc['id'] . "-edit\"); }, false);
</script>\n";
			$sticker_pack = isset($sticker_pack) ? $sticker_pack : "" . "<div class=\"movable sticker s_" . $row['data'] . "\" style=\"left: 10px; top: 10px; z-index: " . $z . "\" id=\"sticker-" . $assoc['id'] . "\">\n" . $edit . "\n</div>\n";
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
L'immagine che selezioni rimarr&agrave sullo sfondo della tua Home fin quando non ne selezioni un'altra dal tuo inventario o tieni aperto lo Web Store. Se vuoi mantenerla come sfondo per la tua Home devi acquistarla e selezionarla dal tuo Inventario.
</p>

<p>
<a href="#" class="new-button" id="webstore-warning-ok"><b>OK</b><i></i></a>
</p>

<div class="clear"></div>
<?php
} else {
//echo "<b>Error:</b> Unknown mode " . $mode . ".";
header("Location: index.php");
}
?>