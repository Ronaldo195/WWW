<?php
include("core.php");
$token = $input->EscapeString($_GET['token']);

$sql = mysql_query("SELECT * FROM cms_reset WHERE token = '".$token."'");

if(mysql_num_rows($sql) > 0){
    $row = mysql_fetch_assoc($sql);

    if(isset($_POST['next']) && $_POST['next'] == 1){
        $pass = $_POST['Password'];
        $pass2 = $_POST['retypedPassword'];
        
        if($pass == '')
            $error = "Digita la tua nuova Password ";
        else if(strlen($pass) < 6 && strlen($pass) > 23)
            $error = "La Password deve comprendere tra i 6 e i 23 caratteri";
        else if($pass != $pass2)
            $error = "Le Password non corrispondono";
        else{
            mysql_query("UPDATE accounts SET password = '".$input->HoloHash($pass)."' WHERE email = '".$row['mail']."'");
            mysql_query("DELETE FROM cms_reset WHERE mail = '".$row['mail']."'");
            header("location: ".PATH."account/password/resetConfirmation");
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $site['short']; ?>:  </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo PATH; ?>web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $site['short']; ?>: RSS" href=""<?php echo PATH; ?>articles/rss.xml" />

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

<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/frontpage.css" type="text/css" />

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
<body class="process-template black secure-page">

<div id="container">
	<div class="process-template-box clearfix">
		<div id="content" class="wide">
		    <div id="header" class="clearfix">
			    <h1><a href="<?php echo PATH; ?>"></a></h1>
			</div>
			<div id="process-content">

<div id="reset-password-form-container">
    <div id="errors">
	<?php
	if(isset($error)){
        echo '
	<div class="rounded-container">
		<div class="rounded-red rounded">
            <div id="error-title" class="error">
                    '.$error.' <br>
            </div>
        </div>
	</div>
	';
    } ?>
    </div>
    <div id="reset-password-form-content">
        <div id="left-column">
            <div class="header bottom-top-border">Imposta la tua Password</div>
            <form method="post" action="" id="pwreset-form">
                <fieldset id="register-fieldset-password">
                    <div class="form-content clearfix">
                        <div class="label registration-text">Email</div>
                        <input type="text" id="email-address" value="<?php echo $row['mail']; ?>" autocomplete="off" readOnly="true">
                    </div>
                    <div class="form-content clearfix">
                        <div class="left">
                            <div id="password">
                                <div class="label registration-text">Nuova Password</div>
                                <input type="password" name="Password" id="register-password" maxlength="32" <?php echo isset($error) ? 'class="error"' : ''; ?>>
                            </div>
                            <div id="password-retype">
                                <div class="label registration-text">Inserisci nuovamente la Password</div>
                                <input type="password" name="retypedPassword" id="register-password2" maxlength="32" <?php echo isset($error) ? 'class="error"' : ''; ?>>
                            </div>
                        </div>
                        <div class="right">
                            <div class="help">La Password deve essere di almeno <b>6 caratteri</b></div>
                        </div>
                    </div>
                </fieldset>
                <div id="password-change-all-account-notice-text" class="bottom-top-dotted-border">
                    <div class="force-email-notice"></div>
                    <span class="white">Il cambio Password verr&agrave; effettuato su tutti i personaggi <?php echo $site['short']; ?> collegati a questo Account.</span></div>
                <input type="hidden" name="token" value="<?php echo $token; ?>">
				<input type="hidden" name="next" value="1">
            </form>
            <div id="change-password-buttons">
                <a href="<?php echo PATH; ?>" id="change-password-cancel-link">Chiudi per annullare</a>
                <a href="#" id="reset-password-submit-button"
                   class="new-button"><b>Salva Password</b><i></i></a>
            </div>
        </div>

        <div id="right-column">
            <div class="header bottom-top-border">I tuoi personaggi</div>
            <ul id="reset-password-account-list" class="clearfix">
                <?php
    $sql = mysql_result(mysql_query("SELECT id FROM accounts WHERE email = '".$row['mail']."'"),0);
    $sql = mysql_query("SELECT * FROM users WHERE account = '".$sql."'");
    while($users = mysql_fetch_assoc($sql)){
        echo '
						<li class="white">
							<div class="green-tick"></div>
							<span>'.$users['username'].'</span>
						</li>';
    }
                ?>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    Event.observe($("reset-password-submit-button"), "click", function() {
        $("pwreset-form").submit();
    });

    $("register-password").focus();
</script>
<?php $reset = 1; include("templates/footer.php"); ?>
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

<?php
}
?>