<?php
include("core.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $site['short']; ?>: Hai una nuova Password! :-D </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo PATH; ?>web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="alternate" type="application/rss+xml" title="Habbo: RSS" href="http://www.habbo.it/articles/rss.xml" />

<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/common.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/process.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/common.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/fullcontent.js" type="text/javascript"></script>


<script type="text/javascript">
var ad_keywords = "";
var ad_key_value = "";
</script>
<script type="text/javascript">
document.habboLoggedIn = false;
var habboName = null;
var habboId = null;
var habboReqPath = "";
var habboStaticFilePath = "<?php echo PATH; ?>web-gallery";
var habboImagerUrl = "<?php echo PATH; ?>habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo PATH; ?>client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "client";
    HabboClient.maximizeWindow = true;
}


</script>

<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />


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
<meta name="build" content="63-BUILD2082 - 16.04.2013 23:11 - it" />
</head>
<body class="process-template secure-page">

<div id="overlay"></div>

<div id="container">
	<div class="cbb process-template-box clearfix">
		<div id="content" class="wide">
					<div id="header" class="clearfix">
						<h1><a href="<?php echo PATH; ?>"></a></h1>
<ul class="stats">
    <li class="stats-online"><span class="stats-fig"><?php echo $input->GetOnline(); ?></span> <?php echo $site['short']; ?> online in questo momento!</li>
</ul>
					</div>
			<div id="process-content">
	        	<div class="cbb clearfix">
    <h2 class="title">Ce l'hai fatta!</h2>
    <div class="box-content">
    <p>La tua Password &egrave; stata sostituita con successo.</p>
    <p><a href="<?php echo PATH; ?>">Torna in Home Page &raquo;</a></p>
    </div>
</div>
<?php include("templates/footer.php"); ?>
</div>
        </div>
    </div>
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
    

    



</body>
</html>
