<?php
if(!isset($bypass) || $bypass != true){
require_once('../core.php');
require_once('../includes/session.php');

$ownerid = $input->FilterText($_GET['ownerId']);
$widgetid = $input->FilterText($_GET['ratingId']);
$rate = $input->FilterText($_GET['givenRate']);
$my_id = $user->row['id'];
}

if(is_numeric($ownerid) && is_numeric($widgetid) && is_numeric($rate)){
	$myvote = mysql_query("SELECT COUNT(*) FROM cms_ratings WHERE raterid = '".$my_id."' AND userid = '".$ownerid."'");
	$myvote = mysql_num_rows($myvote) > 0 ? mysql_result($myvote,0) : 0;
	if($myvote < 1 && $ownerid != $my_id && $rate > 0 && $rate < 6){
		mysql_query("INSERT INTO cms_ratings (userid,rating,raterid) VALUES ('".$ownerid."','".$rate."','".$my_id."')");
	}
}

$totalvotes = mysql_query("SELECT COUNT(*) FROM cms_ratings WHERE userid = '".$ownerid."'");
$totalvotes = mysql_num_rows($totalvotes) > 0 ? mysql_result($totalvotes,0) : 0;
$highvotes = mysql_query("SELECT COUNT(*) FROM cms_ratings WHERE userid = '".$ownerid."' AND rating > 3");
$highvotes = mysql_num_rows($highvotes) > 0 ? mysql_result($highvotes,0) : 0;
$votestally = mysql_query("SELECT SUM(rating) FROM cms_ratings WHERE userid = '".$ownerid."'");
$votestally = mysql_num_rows($votestally) > 0 ? mysql_result($votestally,0) : 0;

$x = $totalvotes;
if($x == 0){ $x = 1; }
$average = round($votestally / $x, 1);
$px = ceil(($average * 150) / 5);
?>
<script type="text/javascript">	
	var ratingWidget;
	 
		ratingWidget = new RatingWidget(<?php echo $input->HoloText($ownerid); ?>, <?php echo $input->HoloText($widgetid); ?>);
	 
</script><div class="rating-average">
		<b>Voto: <?php echo $average; ?></b><br/>
	<div id="rating-stars" class="rating-stars" >
				<ul id="rating-unit_ul1" class="rating-unit-rating">
				<li class="rating-current-rating" style="width:<?php echo $px; ?>px;" />
	
			</ul>	
	</div>
	<?php echo $totalvotes; ?> Voti totali
	
	<br/>
	(<?php echo $highvotes; ?> Voti alti)
</div>