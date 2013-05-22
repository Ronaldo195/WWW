<?php
$allow_guests = true;

include('../core.php');
include('../includes/session.php');

$hid = $input->FilterText($_GET['hid']);
$first = $input->FilterText($_GET['first']);
?>
<?php if($hid == "h120"){ ?>
<head>
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/v2/styles/rooms.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/rooms.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/rooms.js" type="text/javascript"></script>
</head>
<script type="text/javascript">
L10N.put("show.more", "Show more rooms");
L10N.put("show.less", "Show fewer rooms");
var roomListHabblet_h120 = new RoomListHabblet("rooms-habblet-list-container-h120", "room-toggle-more-data-h120", "room-more-data-h120");
</script>
<?php }elseif($hid == "h122"){ ?>
<head>
<script src="<?php echo PATH; ?>web-gallery/static/js/moredata.js" type="text/javascript"></script>
</head>
<div id="hotgroups-habblet-list-container" class="habblet-list-container groups-list">
    <ul class="habblet-list two-cols clearfix">
<?php
$o = 0;
$i = 0;
$getem = mysql_query("SELECT * FROM groups ORDER BY views DESC LIMIT 10") or die(mysql_error());

while ($row = mysql_fetch_assoc($getem)) {
		$i++;
		
        if($o == 0){
			$even = "odd";
			$o++;
        }elseif($o == 1 || $o == 2){
            $even = "even";
			$o++;
        } elseif($o == 3 || $o == 4){
            $even = "odd";
			
			if($o == 3)
				$o++;
			else
				$o = 1;
		}
		
		if(!isset($row['name'])){
			$row['id'] = $row['Id'];
			$row['name'] = $row['Name'];
			$row['badge'] = $row['Image'];
		}
        printf("<li class=\"%s\" style=\"background-image: url(".PATH."habbo-imaging/badge.php?badge=%s)\">
                <a class=\"item\" href=\"".PATH."groups/%s\"><span class=\"index\">%s.</span> %s</a>
            </li>\n", $even, $row['badge'], $row['id'], $i, $input->HoloText($row['name']));
}
?>
</ul>
</div>
<?php }elseif($hid == "h17"){ ?>
<style type="text/css">
.room-occupancy-1{
	background-image:url('<?php echo PATH; ?>web-gallery/v2/images/rooms/room_icon_1.gif')!important;
}
.room-occupancy-2{
	background-image:url('<?php echo PATH; ?>web-gallery/v2/images/rooms/room_icon_2.gif')!important;
}
.room-occupancy-3{
	background-image:url('<?php echo PATH; ?>web-gallery/v2/images/rooms/room_icon_3.gif')!important;
}
.room-occupancy-4{
	background-image:url('<?php echo PATH; ?>web-gallery/v2/images/rooms/room_icon_4.gif')!important;
}
.room-occupancy-5{
	background-image:url('<?php echo PATH; ?>web-gallery/v2/images/rooms/room_icon_5.gif')!important;
}
</style>
		<div id="rooms-habblet-list-container-h119" class="recommendedrooms-lite-habblet-list-container">
			<ul class="habblet-list">
			<?php
			$sql = mysql_query("SELECT rec_id FROM cms_recommended WHERE type = 'room'");
			if(mysql_num_rows($sql) > 0){
			$i = 0;
			while($row = mysql_fetch_array($sql)){
				$i++;
				$room = mysql_fetch_assoc(mysql_query("SELECT * FROM rooms WHERE id = ".$row[0]));
				
				$count[$i] = ($room['users_now'] / $room['users_max']) * 100;
				if($count[$i] == 99 || $count[$i] > 99)
					$room_fill = 5;
				elseif($count[$i] > 65)
					$room_fill = 4;
				elseif($count[$i] > 32)
					$room_fill = 3;
				elseif($count[$i] > 0)
					$room_fill = 2;
				elseif($count[$i] < 1)
					$room_fill = 1;
				
				if($input->IsEven($i))
					$even = "odd";
				else
					$even = "even";
			
			echo '
				<li class="'.$even.'">
					<span class="clearfix enter-room-link room-occupancy-'.$room_fill.'" title="Vai!" roomid="'.$room['id'].'">
						<span class="room-enter" onclick="HabboClient.openOrFocus(\''.PATH.'client?forwardId=2&roomId='.$room['id'].'\'); return false;">Vai!</span>
						<span class="room-name" onclick="HabboClient.openOrFocus(\''.PATH.'client?forwardId=2&roomId='.$room['id'].'\'); return false;">'.$room['caption'].'</span>
						<span class="room-description" onclick="HabboClient.openOrFocus(\''.PATH.'client?forwardId=2&roomId='.$room['id'].'\'); return false;">'.$room['description'].'</span>
						<span class="room-owner">Proprietario: <a href="'.PATH.'home/'.$room['owner'].'">'.$room['owner'].'</a></span>
					</span>
				</li>
			'; } }
			?>
			</ul>
		</div>

<?php } ?>