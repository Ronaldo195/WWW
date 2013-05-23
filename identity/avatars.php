<?php
include("../core.php");

$mail = explode('@', $user->account['email']);
$mail = $mail[0];

if(isset($_SESSION['provider'])){
	if(isset($_SESSION['provider']['profile']['providerName']) && $_SESSION['provider']['profile']['providerName'] == 'Google'){
		$image = PATH.'web-gallery/v2/images/google.jpg';
		$pname = $_SESSION['provider']['profile']['displayName'];
	} else if(isset($_SESSION['provider']['id']) && $_SESSION['provider']['id'] > 0){
		$image = 'https://graph.facebook.com/'.$_SESSION['provider']['id'].'/picture';
		$pname = $_SESSION['provider']['name'];
	} else {
		$image = 'https://ssl.facebook.com/pics/q_silhouette.gif'; 
		$pname = $mail;
	}
}else{
	$image = 'https://ssl.facebook.com/pics/q_silhouette.gif';
	$pname = $mail;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $site['short']; ?>: Scegli il tuo personaggio </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo PATH; ?>/web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="alternate" type="application/rss+xml" title="Habbo: RSS" href="http://www.habbo.it/articles/rss.xml" />
<meta name="csrf-token" content="3880d5d645"/>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/embed.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/embed.js" type="text/javascript"></script>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
<link media="only screen and (max-device-width: 480px)" href="<?php echo PATH; ?>/web-gallery/styles/small-device.css" type= "text/css" rel="stylesheet">



<script type="text/javascript">
var ad_keywords = "gender%3Am,age%3A17";
var ad_key_value = "kvage=17;kvgender=m;kvtags=";
</script>
<script type="text/javascript">
document.habboLoggedIn = true;
var habboName = "<?php echo $user->row['username']; ?>";
var habboId = <?php echo $user->row['id']; ?>;
var facebookUser = false;
var habboReqPath = "";
var habboStaticFilePath = "<?php echo PATH; ?>/web-gallery";
var habboImagerUrl = "<?php echo PATH; ?>/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo PATH; ?>client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "c0dccc320dc9a78a27bc3e8bf55bf7bf584aff65";
    HabboClient.maximizeWindow = true;
}


</script>

<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

<meta property="fb:app_id" content="163345683587" />
<meta property="fb:admins" content="100001245540290" />
<meta property="og:site_name" content="<?php echo $site['short']; ?> Hotel" />
<meta property="og:title" content="<?php echo $site['short']; ?>: Scegli il tuo personaggio" />
<meta property="og:url" content="<?php echo PATH; ?>" />
<meta property="og:image" content="http://www.habbo.it/v2/images/facebook/app_habbo_hotel_image.gif" />
<meta property="og:locale" content="it_IT" />

<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/common.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/avatarselection.css" type="text/css" />

<meta name="description" content="<?php echo $site['short']; ?> Hotel: Amici, divertimento, Celebrità!" />
<meta name="keywords" content="<?php echo $site['short']; ?> hotel, virtuale, mondo, social network, gratis, community, avatar, personaggio, chat, online, giovane, ragazzi, gioco di ruolo, giochi di ruolo, iscriviti, social, gruppi, forum, sicurezza, giocare, giochi, online, amici, giovani, rari, Furni rari, collezione, creare, collezionare, connettersi, furni, mobili, cuccioli, animali, creazione stanze, condivisione, espressione, Distintivi, badge, uscire, musica, HC, celebrità, visite HC, famosi, mmo, mmorpg, multiplayer" />



<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/ie6.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="63-BUILD-FOR-PATCH-1642a - 30.03.2013 00:49 - it" />
</head>

<body id="embedpage">
<div id="overlay"></div>

<div id="container">

    <div id="select-avatar">
	<div class="pick-avatar-container clearfix">
        <div class="title">
            <span class="habblet-close"></span>
            <h1>Scegli il tuo personaggio</h1>
        </div>
		<div id="content">
            <div id="user-info">
                  <img src="<?php echo $image; ?>"/>
              <div>
                  <div id="name"><?php echo $pname; ?></div>
                  <a href="<?php echo PATH; ?>me" id="logout">Torna in Hotel</a>
				  <a href="<?php echo PATH; ?>identity/settings" id="manage-account">Gestisci Account</a>
              </div>

            </div>
            <div id="first-avatar">
                    <img src="<?php echo $user->avatarURL("self","b,3,3,sml,1,0"); ?>" width="64" height="110"/>
                    <div id="first-avatar-info">
                        <div class="first-avatar-name"><?php echo $user->row['username']; ?></div>
                        <div class="first-avatar-lastonline">Ultimo accesso: <span title="<?php echo is_numeric($user->row['last_online']) ? date('d/m/Y H:i:s',$user->row['last_online']) : $user->row['last_online']; ?>"><?php echo $input->nicetime(is_numeric($user->row['last_online']) ? date('Y-m-d H:i:s',$user->row['last_online']) : $user->row['last_online']); ?></span></div>
                        <a id="first-avatar-play-link" href="<?php echo PATH; ?>me">
                            <div class="play-button-container">
                                <div class="play-button"><div class="play-text">Gioca</div></div>
                                <div class="play-button-end"></div>
                            </div>
                        </a>
                    </div>
            </div>

			
            <div id="link-new-avatar"><a class="new-button " onclick="" href="<?php echo PATH; ?>identity/add_avatar"><b>Aggiungi</b><i></i></a></div>

         
			<?php
				$sql = mysql_query("SELECT * FROM users WHERE account = '".$user->account['id']."'");
				$num = 50 - mysql_num_rows($sql);
				echo '
				<p style="margin: 5px 10px">Puoi aggiungere altri '.$num.' personaggi.</p>
            <div class="other-avatars">
                  <ul>
				  ';
				  
					if(isset($_SESSION['provider']['profile']['providerName']) && $_SESSION['provider']['profile']['providerName'] == 'Google')
						$id = $_SESSION['provider']['profile']['googleUserId'];
					else if(isset($_SESSION['provider']['profile']['providerName']) && $_SESSION['provider']['profile']['providerName'] == 'Twitter'){
						$id0 = explode("http://twitter.com/account/profile?user_id=", $_SESSION['provider']['profile']['identifier']);
						$id = $id0[1];
					}else if(isset($_SESSION['provider']['id']) && $_SESSION['provider']['id'] > 0)
						$id = $_SESSION['provider']['id'];
					else
						$id = $user->account['id'];

					$i = 0;
					while($row = mysql_fetch_assoc($sql)){
						if($row['id'] != $user->row['id']){
						$i++;
						if($input->IsEven($i)){
							$even = "odd";
						} else {
							$even = "even";
						}
					echo '
					<li class="'.$even.'">
                      <img src="'.$user->avatarURL($row['look'],"s,4,4,sml,1,0").'" width="33" height="56"/>
                      <div class="avatar-info">
                        <div class="avatar-info-container">
                          <div class="avatar-name">'.$row['username'].'</div>
	            	      <div class="avatar-lastonline">Ultimo accesso: <span title="'.(is_numeric($row['last_online']) ? date('d-m-Y H:i:s',$row['last_online']) : $row['last_online']).'">'.$input->nicetime(is_numeric($row['last_online']) ? date('Y-m-d H:i:s',$row['last_online']) : $row['last_online']).'</span></div>
                        </div>
                          <div class="avatar-select"><a href="'.PATH.'identity/UseAvatar?id='.$row['id'].'"><b>Gioca</b><i></i></a></div>
                      </div>
                    </li>';
					} }?>
                  </ul>
            </div>
        </div>
    </div>
    <div class="pick-avatar-container-bottom"></div>
  </div>
<?php include("../templates/footer.php"); ?>
    <script type="text/javascript">
        Embed.decorateFooterLinks();
    </script>
</div>
<script type="text/javascript">
if (typeof HabboView != "undefined") {
	HabboView.run();
}
</script>


<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-448325-20']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>    
    <!-- Start Quantcast tag -->
<script type="text/javascript">
_qoptions={
qacct:"p-b5UDx6EsiRfMI"
};
</script>
<script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script>
<noscript>
<img src="http://pixel.quantserve.com/pixel/p-b5UDx6EsiRfMI.gif" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/>
</noscript>
<!-- End Quantcast tag -->

<!-- HL-30554 -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1042363710;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "s2bqCJDN8AIQvuqE8QM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1042363710/?label=s2bqCJDN8AIQvuqE8QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
    
    
        


</body>
</html>
