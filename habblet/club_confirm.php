<?php
require_once('../core.php');
require_once('../includes/session.php');

$option = $input->HoloText($_POST['optionNumber']);

switch($option){
	case 1: $price = 100; $valid = 1; break;
	case 2: $price = 300; $valid = 1; break;
	case 3: $price = 150; $valid = 1; break;
	case 4: $price = 400; $valid = 1; break;
}
if($option == 1 || $option == 3){ $days = "30"; }
if($option == 2 || $option == 4){ $days = "92"; }
if($option == 1 || $option == 2){ $type = "Club"; }
if($option == 3 || $option == 4){ $type = "VIP"; }
?>
<div id="hc_confirm_box">
<img src="<?php if($option == 1 || $option == 2){ ?><?php echo PATH; ?>web-gallery/v2/images/habboclub_basic_small.png<?php }elseif($option == 3 || $option == 4){ ?><?php echo PATH; ?>web-gallery/v2/images/habboclub_vip_small.png<?php } ?>" align="left" style="border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-style: initial; border-color: initial; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px; float: left; "><div style="width: 300px; margin-left: 10px; float: left; ">
<p style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-bottom: 1em; ">
Stai per acquistare un periodo <?php echo $site['short']; ?> Club. Grande!</p>
<p style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-bottom: 1em; ">
Prezzo:<span class="Apple-converted-space">&nbsp;</span><b><?php echo $price; ?> Crediti</b></p>
<p style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-bottom: 1em; ">
Stai acquistando:<span class="Apple-converted-space">&nbsp;</span><b><?php echo $days; ?> giorni <?php echo $site['short']." ".$type; ?></b></p></div>
<p style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-bottom: 1em; ">
<a class="new-button" onclick="habboclub.closeSubscriptionWindow(); return false;" style="color: rgb(252, 98, 4); margin-top: 0px; margin-right: 0px; margin-bottom: 5px; margin-left: 10px; display: block; float: right; height: 25px; position: relative; text-decoration: none; cursor: pointer; overflow-x: hidden; overflow-y: hidden; white-space: nowrap; " href="#">
<b style="float: left; font-size: 11px; height: 17px; background-origin: initial; background-clip: initial; color: rgb(0, 0, 0) !important; font-weight: bold; text-align: center; display: inline; margin-right: 3px; padding-left: 20px; padding-right: 17px; padding-top: 5px; padding-bottom: 4px; background: url('<?php echo PATH; ?>/web-gallery/v2/images/new_button.png') no-repeat no-repeat initial -3px 0px">
Annulla</b><i></i></a><a ondblclick="habboclub.showSubscriptionResultWindow(<?php echo $option; ?>,'<?php if($option == 1 || $option == 2){ echo $site['short']." Club"; }elseif($option == 3 || $option == 4){ echo $site['short']." VIP"; } ?>'); return false;" onclick="habboclub.showSubscriptionResultWindow(<?php echo $option; ?>,'<?php if($option == 1 || $option == 2){ echo $site['short']." Club"; }elseif($option == 3 || $option == 4){ echo $site['short']." VIP"; } ?>'); return false;" class="new-button" style="color: rgb(252, 98, 4); margin-top: 0px; margin-right: 0px; margin-bottom: 5px; margin-left: 10px; display: block; float: right; height: 25px; position: relative; text-decoration: none; cursor: pointer; overflow-x: hidden; overflow-y: hidden; white-space: nowrap; " href="#"><b style="float: left; font-size: 11px; height: 17px; background-origin: initial; background-clip: initial; color: rgb(0, 0, 0) !important; font-weight: bold; text-align: center; display: inline; margin-right: 3px; padding-left: 20px; padding-right: 17px; padding-top: 5px; padding-bottom: 4px; background: url('<?php echo PATH; ?>/web-gallery/v2/images/new_button.png') no-repeat no-repeat initial -3px 0px">Sottoscrivi</b><i></i></a>
</div>