<?php
require_once('..//core.php');
require_once('../includes/session.php');

$ownerid = $input->FilterText($_GET['ownerId']);
$widgetid = $input->FilterText($_GET['ratingId']);

if($ownerid == $user->id){
	mysql_query("DELETE FROM cms_ratings WHERE userid = '".$ownerid."'");
}
?>
<script type="text/javascript">	
	var ratingWidget;
	 
		ratingWidget = new RatingWidget(<?php echo $input->HoloText($ownerid); ?>, <?php echo $input->HoloText($widgetid); ?>);
	 
</script><div class="rating-average">
		<b>Voti: 0</b><br/>
	<div id="rating-stars" class="rating-stars" >
				<ul id="rating-unit_ul1" class="rating-unit-rating">
				<li class="rating-current-rating" style="width:0px;" />
	
			</ul>	
	</div>
	0 Voti totali
	
	<br/>
	(0 Voti alti)
</div>