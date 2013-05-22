<?php
include('../core.php');
$id = $input->FilterText($_POST['anAccountId']);
$ownerid = isset($_POST['ownerAccountId']) ? $input->FilterText($_POST['ownerAccountId']) : 0;
$sql = mysql_query("SELECT * FROM users WHERE id = '".$id."' LIMIT 1");
$row = mysql_fetch_assoc($sql);
$sql = mysql_query("SELECT * FROM user_badges WHERE user_id = '".$id."' AND badge_slot = '1' LIMIT 1");
$count = mysql_num_rows($sql);
if($count != 0){
$badgerow = mysql_fetch_assoc($sql);
$badge = $input->FilterText($badgerow['badge_id']);
}else{
$badge = "";
}
if($input->IsUserOnline($id) == true){
$online = "habbo_online_anim_big.gif";
}else{
$online = "habbo_offline_big.gif";
}
?>
<div class="avatar-list-info-container">
	<div class="avatar-info-basic clearfix">
		<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close" id="avatar-list-info-close-<?php echo $row['id']; ?>"></a></div>
		<div class="avatar-info-image">
		<?php
		if($badge != ""){
			echo "<img src=\"".$cimagesurl.$badgesurl.$badge.".gif\">";
		}
		?>
			<img src="http://www.habbo.it/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&size=l&direction=4&head_direction=4" alt="<?php echo $row['username']; ?>" />
		</div>
<h4><a href="<?php echo PATH."home/".$row['username']; ?>"><?php echo $row['username']; ?></a></h4>
<p>
<img src="<?php echo PATH; ?>web-gallery/images/myhabbo/<?php echo $online; ?>" />
</p>
<p><?php echo $site['short']; ?> creato il: <b><?php echo date('d/m/Y',$row['account_created']); ?></b></p>
<p><a href="<?php echo PATH."home/".$row['username']; ?>" class="arrow"><?php echo $site['short']; ?> Home page.</a></p>
<p class="avatar-info-motto"><?php echo $row['motto']; ?></p>
	</div>
</div>