<?php 
include('core.php');
include('includes/session.php');

$user->Refresh($user->row['username']);

$pagename = $user->row['username'];
$pageid = "1";

$messages = mysql_query("SELECT COUNT(*) FROM cms_minimail WHERE to_id = '".$user->row['id']."'") or $messages = 0;
header("X-JSON: {\"totalMessages\":".$messages."}");

include('templates/subheader.php');
include('templates/header.php');
?>

<div id="container">
<div id="content" style="position: relative" class="clearfix">
<style>
#plate-nav {position: absolute;top: 0;left: 0;height: 21px;width: 128px;background: transparent url(web-gallery/v2/images/topstories_nav_bg.png) no-repeat top left;color: #fff;line-height: 21px;}
#plate-nav2 {position: absolute;top: 21px;left: 0;height: 21px;width: 128px;background: transparent url(web-gallery/v2/images/topstories_nav_bg2.png) no-repeat top left;color: #fff;line-height: 21px;}
#plate-nav3 {position: absolute;top: 42px;left: 0;height: 21px;width: 128px;background: transparent url(web-gallery/v2/images/topstories_nav_bg2.png) no-repeat top left;color: #fff;line-height: 21px;}
#credits-icon {float:left;background: transparent url(web-gallery/v2/images/info_icons.png) no-repeat 100% -142px;width:16px;height:20px;padding-left:5px;}
#pixels-icon {float:left;background: transparent url(web-gallery/v2/images/info_icons.png) no-repeat 100% -1070px;width:16px;height:20px;padding-left:5px;}
#HC-icon {float:left;background: transparent url(web-gallery/v2/images/info_icons.png) no-repeat 100% -94px;width:16px;height:20px;padding-left:5px;}
#VIP-icon {float:left;background: transparent url(web-gallery/v2/images/info_icons.png) no-repeat 100% -1120px;width:16px;height:20px;padding-left:5px;}
</style>
<div id="wide-personal-info">
	<div id="plate-nav">&nbsp; <div id="credits-icon">&nbsp;</div><?php echo $user->row['credits']; ?></div>
	<div id="plate-nav2">&nbsp; <div id="pixels-icon">&nbsp;</div><?php echo $user->row['activity_points']; ?></div>
	<div id="plate-nav3">&nbsp; <div id="<?php echo $input->HCType($user->row['id']); ?>-icon">&nbsp;</div><?php echo $input->HCDaysLeft($user->row['id']) != 0 ? str_replace("da adesso","", $input->nicetime(date('d-m-Y',$input->HCDaysLeft($user->row['id']))))." ".$input->HCType($user->row['id']) : '<a href="'.PATH.'credits/club">Entra nel Club!</a>'; ?></div>
    <div id="habbo-plate">
	<a href="<?php echo PATH; ?>identity/avatars">
	<img alt="<?php echo $user->row['username']; ?>" src="<?php echo $user->avatarURL("self","b,3,3,sml,1,0"); ?>" width="64" height="110"/>
</a>
    </div>

    <div id="name-box" class="info-box">
        <div class="label">Nome Utente:</div>
        <div class="content"><?php echo $user->row['username']; ?></div>
    </div>
    <div id="motto-box" class="info-box">
        <div class="label">Missione:</div>
        <div class="content"><?php echo $user->row['motto']; ?></div>
    </div>
    <div id="last-logged-in-box" class="info-box">
        <div class="label">Ultimo Accesso:</div>
        <div class="content"><?php echo date('d-m-Y H:i:s', $user->row['last_online']); ?> </div>
    </div>
	<div id="email-box" class="info-box">
        <div class="label">Email:</div>
        <div class="content"><?php echo $user->account['email']; ?></div>
    </div>

<div class="enter-hotel-btn">
	<?php
		if(CLOSING && date('H') > 1 && date('H') < 8){
			echo '
			<div class="closed enter-btn">
				<span>L\'hotel &egrave; chiuso!</span>
				<b></b>
			</div>
			';
		}else{
			echo '
			<div class="open enter-btn">
				<a href="'.PATH.'client" onclick="HabboClient.openOrFocus(this); return false;">Entra in '.$site['name'].'<i></i></a>
				<b></b>
			</div>
			';
		}
	?>
	<div style="padding-top:25px">
	<style>
	#badges {
		float:left;
		margin-left:5px;
		background-image: url('web-gallery/v2/images/personal_info/badgeback.png');
		background-repeat:no-repeat;
		width:54px;
		height:58px;
	}
	</style>
    <?php
	$i = 0;
    $getBadges = mysql_query("SELECT badge_id FROM user_badges WHERE user_id = '".$user->row['id']."' AND badge_slot >= 1 ORDER BY badge_slot ASC LIMIT 5");
	while ($badge = mysql_fetch_assoc($getBadges)){
		$i++;
		echo '
			<div id="badges">
				<img style="margin-top:10px;" src="http://images.habbo.com/c_images/album1584/'.$badge['badge_id'].'.gif">
			</div>
		';
	}
	for($i=$i;$i<5;$i++){
		echo '<div id="badges"></div>';
	}
    ?>
	</div>
</div>

</div>
<?php

require_once('./includes/news_big.php');

?>


<div id="column1" class="column">

<div class="habblet-container minimail" id="mail">
                        <div class="cbb clearfix blue ">

                            <h2 class="title">Messaggi
                            </h2>
                        <div id="minimail">
    <div class="minimail-contents">
		<?php
		$bypass = true;
		$page = "inbox";
		include('./minimail/loadMessage.php');
		?>
	    </div>
		<div id="message-compose-wait"></div>
	    <form style="display: none" id="message-compose">
	        <div>Nome utente</div>
	        <div id="message-recipients-container" class="input-text" style="width: 426px; margin-bottom: 1em">
	        	<input type="text" value="" id="message-recipients" />
	        	<div class="autocomplete" id="message-recipients-auto">
	        		<div class="default" style="display: none;">digitare il nome del destinatario</div>
	        		<ul class="feed" style="display: none;"></ul>

	        	</div>
	        </div>
	        <div>Oggetto<br/>
	        <input type="text" style="margin: 5px 0" id="message-subject" class="message-text" maxlength="100" tabindex="2" />
	        </div>
	        <div>Segnala<br/>
	        <textarea style="margin: 5px 0" rows="5" cols="10" id="message-body" class="message-text" tabindex="3"></textarea>

	        </div>
	        <div class="new-buttons clearfix">
	            <a href="#" class="new-button preview"><b>Anteprima</b><i></i></a>
	            <a href="#" class="new-button send"><b>Invia</b><i></i></a>
	        </div>
	    </form>
	</div>
		<?php
		$error=0;
		$sql = mysql_query("SELECT * FROM messenger_friendships WHERE user_one_id = '".$user->row['id']."'") or $error=1;
		if($error==1)
			$sql = mysql_query("SELECT * FROM messenger_friendships WHERE sender = '".$user->row['id']."' OR receiver = '".$user->row['id']."'");
		$count = mysql_num_rows($sql);
		
		$sql = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$user->row['id']."' OR senderid = '".$user->row['id']."'") or die(mysql_error());
		$mescount = mysql_num_rows($sql); 
		?>
		<script type="text/javascript">
		L10N.put("minimail.compose", "Componi").put("minimail.cancel", "Annulla")
			.put("bbcode.colors.red", "Rosso").put("bbcode.colors.orange", "Arancione")
	    	.put("bbcode.colors.yellow", "Giallo").put("bbcode.colors.green", "verde")
	    	.put("bbcode.colors.cyan", "Turchese").put("bbcode.colors.blue", "Blu")
	    	.put("bbcode.colors.gray", "Grigio").put("bbcode.colors.black", "Nero")
	    	.put("minimail.empty_body.confirm", "Sei sicuro di inviare un messaggio vuoto?")
	    	.put("bbcode.colors.label", "Colore").put("linktool.find.label", " ")
	    	.put("linktool.scope.habbos", "<?php echo $site['short']; ?>").put("linktool.scope.rooms", "Stanze")
	    	.put("linktool.scope.groups", "Grouppi").put("minimail.report.title", "Segnala");

		new MiniMail({ pageSize: 10,
		   total: <?php echo $mescount; ?>,
		   friendCount: <?php echo $count; ?>,
		   maxRecipients: 50,
		   messageMaxLength: 20,
		   bodyMaxLength: 4096,
		   secondLevel: <?php echo $count == 0 ? "true" : "false"; ?>});
	</script>
	</div></div>
    <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>				<div class="habblet-container ">

        <div class="habblet-container ">
      <div class="cbb clearfix red">
<div class="box-tabs-container clearfix">
    <h2>Scelti dallo Staff</h2>
    <ul class="box-tabs">
		<li id="tab-rooms"><a href="#">Stanze</a><span class="tab-spacer"></span></li>
        <li id="tab-groups" class="selected"><a href="#">Gruppi</a><span class="tab-spacer"></span></li>
    </ul>
</div>

	<div id="tab-rooms-content"  style="height:200px;overflow-y:scroll;display: none;" id="promorooms-habblet-list-container">
		<div class="progressbar"><img src="<?php echo PATH; ?>web-gallery/images/progress_bubbles.gif"></div>
		<a href="<?php echo PATH; ?>habblet/proxy.php?hid=h17" class="tab-ajax"></a>
	</div>
	
    <div id="tab-groups-content" >
    <div style="height:200px;overflow-y:scroll;" id="promogroups-habblet-list-container" class="habblet-list-container groups-list">
    <ul class="habblet-list two-cols clearfix">
    <?php
	$o = 0;
	$sql = mysql_query("SELECT * FROM cms_recommended WHERE type = 'group' ORDER BY id ASC") or die(mysql_error());
    while($row = mysql_fetch_assoc($sql)) {
		$groupsql = mysql_query("SELECT * FROM groups WHERE id = '".$row['rec_id']."' LIMIT 1");
		$grouprow = mysql_fetch_assoc($groupsql);
		
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
				$o = 0;
        }
		if(isset($grouprow['id'])){
			$grid = $grouprow['id'];
			$grname = $grouprow['name'];
			$grimage = $grouprow['badge'];
		} else {
			$grid = $grouprow['Id'];
			$grname = $grouprow['Name'];
			$grimage = $grouprow['Image'];
		}
    ?>
            <li class="<?php echo $even; ?>" style="background-image: url(<?php echo PATH; ?>habbo-imaging/badge.php?badge=<?php echo $grimage; ?>.gif)">
            <a class="item" href="<?php echo PATH."groups/".$grid; ?>"><strong><?php echo $input->HoloText($grname); ?></strong></a>
            </li>
        <?php } ?>
    </ul>
    </div>
</div></div>
                       
                <script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<div class="cbb clearfix default ">
<div class="box-tabs-container clearfix"><div>
    <h2><?php echo $site['short']; ?></h2>
    <ul class="box-tabs">
        <li id="tab-2-2" class="selected"><a href="#">Trova Utenti</a><span class="tab-spacer"></span></li></div>


   
<div class="habblet-content-info">
    <a name="habbo-search">Inserire i primi caratteri del nome per trovare altri utenti</a>
</div>
<div id="habbo-search-error-container" style="display: none;"><div id="habbo-search-error" class="rounded-red rounded"></div></div>
<br clear="all"/>
<div id="avatar-habblet-list-search">
    <input type="text" id="avatar-habblet-search-string"/>

    <a href="#" id="avatar-habblet-search-button" class="new-button"><b>Cerca</b><i></i></a>
</div>

<br clear="all"/>

<div id="avatar-habblet-content">
<div id="avatar-habblet-list-container" class="habblet-list-container">
        <ul class="habblet-list">
        </ul>

</div>
<script type="text/javascript">
    L10N.put("habblet.search.error.search_string_too_long", "La parola chiave che hai inserito &egrave troppo lunga. La lunghezza massima &egrave 30 caratteri.");
    L10N.put("habblet.search.error.search_string_too_short", "La parola chiave che hai inserito &egrave troppo corta. Sono richiesti almeno 2 caratteri.");
    L10N.put("habblet.search.add_friend.title", "Aggiungi alla tua lista di amici");
	new HabboSearchHabblet(2, 30);

</script>

</div>


  </div>

					</div>


				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>

<div id="column2" class="column">

<?php include("includes/news_mini.php"); ?>
<?php $incolumn = 1; include("templates/ads.php"); ?>

</div>

<div id="column3" class="column">
<?php $incolumn = 0; include("templates/ads.php"); ?>
</div>
</div>


<script type="text/javascript">
	HabboView.add(LoginFormUI.init);
</script>
<?php

include('templates/footer.php');

?>
