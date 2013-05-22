<?php
include("core.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo PATH; ?>: L'Hotel &egrave; chiuso. </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo PATH; ?>web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="alternate" type="application/rss+xml" title="Habbo: RSS" href="http://www.habbo.it/articles/rss.xml" />
<meta name="csrf-token" content="5655390a6a"/>
<script src="<?php echo PATH; ?>web-gallery/static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/common.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/common.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/process.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/habboflashclient.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/habboflashclient.js" type="text/javascript"></script>

<script type="text/javascript">
var ad_keywords = "gender%3Am,age%3A23";
var ad_key_value = "kvage=23;kvgender=m;kvtags=";
</script>
<script type="text/javascript">
document.habboLoggedIn = true;
var habboName = "<?php echo $user->row['username']; ?>";
var habboId = <?php echo $user->row['id']; ?>;
var facebookUser = true;
var habboReqPath = "";
var habboStaticFilePath = "<?php echo PATH; ?>web-gallery";
var habboImagerUrl = "<?php echo PATH; ?>habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo PATH; ?>client";
window.name = "18ed9143c91653690db6cb6cc896cb40c98eb959";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "18ed9143c91653690db6cb6cc896cb40c98eb959";
    HabboClient.maximizeWindow = true;
}


</script>

<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

<meta property="fb:app_id" content="163345683587" />
<meta property="fb:admins" content="100001245540290" />
<meta property="og:site_name" content="<?php echo $site['short']; ?> Hotel" />
<meta property="og:title" content="<?php echo $site['short']; ?>: L'Hotel è chiuso." />
<meta property="og:url" content="<?php echo PATH; ?>" />
<meta property="og:image" content="<?php echo PATH; ?>web-gallert/v2/images/facebook/app_habbo_hotel_image.gif" />
<meta property="og:locale" content="it_IT" />



<meta name="description" content="<?php echo $site['short']; ?> Hotel: Amici, divertimento, Celebrità!" />
<meta name="keywords" content="<?php echo $site['short']; ?> hotel, virtuale, mondo, social network, gratis, community, avatar, personaggio, chat, online, giovane, ragazzi, gioco di ruolo, giochi di ruolo, iscriviti, social, gruppi, forum, sicurezza, giocare, giochi, online, amici, giovani, rari, Furni rari, collezione, creare, collezionare, connettersi, furni, mobili, cuccioli, animali, creazione stanze, condivisione, espressione, Distintivi, badge, uscire, musica, HC, celebrità, visite HC, famosi, mmo, mmorpg, multiplayer" />



<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/ie6.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="63-BUILD2104 - 29.04.2013 11:11 - it" />
</head>
<body id="popup" class="process-template client_error">
<div id="container">
    <div id="content">
	    <div id="process-content" class="centered-client-error">
	       	<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix orange ">
	
							<h2 class="title">Al momento l'Hotel &egrave; chiuso.
							</h2>
						<div class="box-content">
    <p>Al momento l'Hotel &egrave; chiuso. Controlla l'orario di apertura che trovi qui sotto ed effettua nuovamente il login.</p>
    <p>
        Orario di Apertura: 8.00 - 2.00<br /><br />
        <?php echo $input->nicetime(date('d-m-Y H:i:s',mktime(8,0,0))); ?> all'apertura
    </p>
</div>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-448325-20']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>


<script type="text/javascript">
  document.observe("dom:loaded", function() {
    ClientMessageHandler.googleEvent("client_error", "hotel_closed");
  });
</script>

						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<script type="text/javascript">
HabboView.run();
</script>
<div id="column2" class="column">
</div>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
		</div>
    </div>
</div>

</body>
</html>
