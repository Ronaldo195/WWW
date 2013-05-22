<?php
include("../core.php");

if(isset($_POST['text']) || isset($_GET['text'])){
	$text = isset($_POST['text']) ? $input->FilterText($_POST['text']) : $input->FilterText($_GET['text']);
	
	if($text == "/svuota" && $user->row['rank'] > 3){
		mysql_query("TRUNCATE TABLE cms_chat");
		mysql_query("INSERT INTO cms_chat (username, text, date) VALUES ('Staff', 'La Chat e\' stata svuotata','".time()."')");
	} elseif(isset($text))
		mysql_query("INSERT INTO cms_chat (username, text, date) VALUES ('".$user->row['username']."', '".$text."','".time()."')");
	else
		echo "nada";
	exit;
}
?>
<style>
#even {background-color:#E3E3E3;}
.msg {padding: 5px 5px 5px 5px;}
.msg:hover {background-color:#EBEDCA!important;}
</style>
<?php
$sql = mysql_query("SELECT * FROM cms_chat");
$i = 1;
while($row = mysql_fetch_assoc($sql)){
	$i++;
	if($input->IsEven($i))
		$even = "even";
	else
		$even = "odd";
	
	$text = $input->HoloText($row['text'],false,true);
	$text = str_replace("è","&egrave;", $text);
	$text = str_replace("ò","&ograve;", $text);
	$text = str_replace("à","&agrave;", $text);
	$text = str_replace("ì","&igrave;", $text);
	$text = str_replace("ù","&ugrave;", $text);
	$time = date('d/m/Y H:i:s', $row['date']);
	echo '
	<div id="'.$even.'" class="msg">
		<div style="float:right;color:#BABABA;">'.$time.'</div>
		<b>'.$row['username'].':</b> '.$text.' 
	</div>
	';
}
 ?>