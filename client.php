<?php
include('core.php');
include('includes/session.php');

if($logged_in)
    require_once('includes/session.php');
else{
    header("location: ".PATH);
    exit;
}

if(CLOSING && date('H') > 1 && date('H') < 8 && $user->row['rank'] < 4){
	header("Location: ".PATH."hotelclosed");
	exit;
}

if(isset($_GET['roomId']) && $_GET['forwardId'] == "2"){
	$roomid = $_GET['roomId'];
	$checksql = mysql_query("select id from rooms where id = '".$roomid."' limit 1");
	$roomexists = mysql_num_rows($checksql);
	if($roomexists > 0){
		$forward['enable'] = true;
		$forward['type'] = 2;
		$forward['id'] = $roomid;
	}else
		$forward['enable'] = false;
}else
	$forward['enable'] = false;

    $myticket = $input->GenerateTicket();
    mysql_query("UPDATE users SET auth_ticket = '".$myticket."', ip_last = '".$remote_ip."' WHERE id = '".$user->row['id']."' LIMIT 1") or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<title><?php echo $site['name']; ?>: Client</title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo PATH; ?>web-gallery/images/v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/common.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/common.js" type="text/javascript"></script>

<script type="text/javascript">
document.habboLoggedIn = true;
var habboName = "<?php echo $user->row['username']; ?>";
var habboId = <?php echo $user->row['id']; ?>;
var facebookUser = "false";
var habboReqPath = "";
var habboStaticFilePath = "<?php echo PATH; ?>web-gallery";
var habboImagerUrl = "<?php echo PATH; ?>habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo PATH; ?>client";
window.name = "hablux_client";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "hablux_client";
    HabboClient.maximizeWindow = true;
}


</script>

<noscript>
    <meta http-equiv="refresh" content="0;url=/client/nojs" />
</noscript>
<meta http-equiv="Pragma" content="no-cache, no-store" />
<meta http-equiv="Expires" content="-1" />
<meta http-equiv="Cache-Control" content="no-cache, no-store" />
<meta name="google" content="notranslate" />

<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/habboflashclient.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/habboflashclient.js" type="text/javascript"></script>
<script src="<?php echo PATH; ?>web-gallery/static/js/identity.js" type="text/javascript"></script>
<script type="text/javascript">
    FlashExternalInterface.loginLogEnabled = true;
    
    FlashExternalInterface.logLoginStep("web.view.start");
    
    if (top == self) {
        FlashHabboClient.cacheCheck();
    }
    var flashvars = {
            "client.allow.cross.domain" : "0", 
            "client.notify.cross.domain" : "1", 
            "connection.info.host" : "<?php echo $client['ip']; ?>", 
            "connection.info.port" : "<?php echo $client['port']; ?>", 
            "connection.info.mus" : "<?php echo $client['fport']; ?>", 
            "site.url" : "<?php echo PATH; ?>", 
            "url.prefix" : "<?php echo PATH; ?>", 
            "client.reload.url" : "<?php echo PATH; ?>client", 
            "client.fatal.error.url" : "<?php echo PATH; ?>disconnesso", 
            "client.connection.failed.url" : "<?php echo PATH; ?>disconnesso", 
            "external.variables.txt" : "<?php echo $client['vars']; ?>", 
            "external.texts.txt" : "<?php echo $client['texts']; ?>", 
            "productdata.load.url" : "<?php echo $client['productdata']; ?>", 
            "furnidata.load.url" : "<?php echo $client['furnidata']; ?>", 
			"external.override.variables.txt" : "<?php echo $client['override_vars']; ?>", 
            "external.override.texts.txt" : "<?php echo $client['override_texts']; ?>", 
			"use.sso.ticket" : "1",
            "sso.ticket" : "<?php echo $myticket; ?>",
<?php if($forward['enable']){ ?>
            "forward.type" : "<?php echo $forward['type']; ?>",
            "forward.id" : "<?php echo $forward['id']; ?>",
<?php } ?>
            "processlog.enabled" : "1", 
            "account_id" : "1", 
            "client.starting" : "<?php echo $client['clientext']; ?>", 
            "flash.client.url" : "<?php echo $client['clienturl']; ?>", 
            "user.hash" : "", 
            "facebook.user" : "false", 
            "has.identity" : "0", 
            "flash.client.origin" : "popup" 
    };
    var params = {
        "base" : "<?php echo $client['base']; ?>",
        "allowScriptAccess" : "always",
        "menu" : "false"                
    };

        if (!(HabbletLoader.needsFlashKbWorkaround())) {
            params["wmode"] = "opaque";
        }

    FlashExternalInterface.signoutUrl = "<?php echo PATH; ?>account/logout";

    var clientUrl = "<?php echo $client['habboswf']; ?>";
    swfobject.embedSWF(clientUrl, "flash-container", "100%", "100%", "10.1.0", "http://habboo-a.akamaihd.net/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1642/web-gallery/flash/expressInstall.swf", flashvars, params, null, FlashExternalInterface.embedSwfCallback);

    window.onbeforeunload = unloading;
    function unloading() {
        var clientObject;
        if (navigator.appName.indexOf("Microsoft") != -1) {
            clientObject = window["flash-container"];
        } else {
            clientObject = document["flash-container"];
        }
        try {
            clientObject.unloading();
        } catch (e) {}
    }
    window.onresize = function() {
        HabboClient.storeWindowSize();
    }.debounce(0.5);
</script>

<meta name="description" content="Entra nella più grande community virtuale online: è gratis! Conosci nuovi amici, gioca, parla con gli altri, crea il tuo avatar, crea stanze ed altro ancora..." />
<meta name="keywords" content="<?php echo $site['name']; ?>, virtuale, mondo, social network, gratis, community, avatar, chat, online, teenagers, ragazzi, ragazze, entra, social, gruppi, forum, giochi, amici, teens, rari, furni rari, creare, collezionare, connettersi, furni, oggetti, animali, disegna stanze, sharing, badges, musica, celebrità, mmo, mmorpg, massively multiplayer" />

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
body { behavior: url(<?php echo PATH; ?>web-gallery/static/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="63-BUILD2041 - 27.03.2013 11:38 - com" />
</head>

<body id="client" class="flashclient">
<div id="overlay"></div>
<img src="<?php echo PATH; ?>web-gallery/v2/images/page_loader.gif" style="position:absolute; margin: -1500px;" />

<div id="overlay"></div>
<div id="client-ui" >
    <div id="flash-wrapper">
    <div id="flash-container">
        <div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
<div class="cbb clearfix">
    <h2 class="title">Per favore, aggiorna Flash Player all'ultima versione!.</h2>
    <div class="box-content">
            <p>Puoi installare Adobe Flash Player da qui: <a href="http://get.adobe.com/flashplayer/">Installa Flash Player</a>. Informazioni utili per l'installazione: <a href="http://www.adobe.com/products/flashplayer/productinfo/instructions/">Altre informazioni</a></p>
            <p><a href="http://www.adobe.com/go/getflashplayer"><img src="<?php echo PATH; ?>web-gallery/v2/images/client/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
    </div>
</div>
        </div>
        <script type="text/javascript">
            $('content').show();
        </script>
        <noscript>
            <div style="width: 400px; margin: 20px auto 0 auto; text-align: center">
                <p>Se non sei reindirizzato automaticamente, per favore <a href="/client/nojs">clicca qui</a></p>
            </div>
        </noscript>
    </div>
    </div>
	<div id="content" class="client-content"></div>            
	<iframe id="game-content" class="hidden" src="about:blank"></iframe>
</div>
    <script type="text/javascript">
        RightClick.init("flash-wrapper", "flash-container");
        if (window.opener && window.opener != window && window.opener.location.href == "/") {
            window.opener.location.replace("/me");
        }
        $(document.body).addClassName("js");
       	HabboClient.startPingListener();
        Pinger.start(true);
        HabboClient.resizeToFitScreenIfNeeded();
    </script>

<script type="text/javascript">
    HabboView.run();
</script>

</body>
</html>