<?php

$allow_guests = true;

include('../core.php');
include('../includes/session.php');

$groupid = $input->FilterText($_POST['groupId']);

if(!empty($groupid) && is_numeric($groupid)){
    $check = mysql_query("SELECT * FROM groups WHERE id = '".$groupid."' LIMIT 1") or die(mysql_error());
    $exists = mysql_num_rows($check);
} else {
    echo "<div class=\"groups-info-basic\">
	<div class=\"groups-info-close-container\"><a href=\"#\" class=\"groups-info-close\"></a></div>
        Gruppo Invalido o non trovato.
          </div>";
    exit;
}

if($exists < 1){ exit; }

$data = mysql_fetch_assoc($check);

echo "<div class=\"groups-info-basic\">
	<div class=\"groups-info-close-container\"><a href=\"#\" class=\"groups-info-close\"></a></div>
	
	<div class=\"groups-info-icon\"><a href=\"".PATH."groups/".$groupid."\"><img src=\"".PATH."habbo-imaging/badge.php?badge=".$data['badge'].".gif\" /></a></div>
	<h4><a href=\"".PATH."groups/".$groupid."\">".$input->HoloText($data['name'])."</a></h4>
	
	<p>
Gruppo creato il:<br />
<strong>".date("d-M-Y",$data['created'])."</strong>
	</p>
	
	<div class=\"groups-info-description\">".$input->HoloText(nl2br($data['desc']))."</div>

</div>";