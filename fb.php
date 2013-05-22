<?php
include('core.php');
if(!isset($_SESSION['provider']))
	header("Location: index");

$error1 = false;
$error1_text = '';
$error2 = false;
$error3 = false;
$error4 = false;
$ok = false;
$username = '';

if(isset($_POST['next']) && $_POST['next'] == "true"){
	$username = $input->EscapeString($_POST['username']);
	$gender = $_SESSION['provider']['gender'];
	
	$birth = explode('/', $_SESSION['provider']['birthday']);
	$month = $birth[0];
	$day = $birth[1];
	$year = $birth[2];
	
	$terms = isset($_POST['termsOfServiceAccepted']) ? $input->EscapeString($_POST['termsOfServiceAccepted']) : "off";
	
	if(strlen($username) < 3 && strlen($username) > 24){
		$error1 = true;
		$error1_text = '<p class="error-message">Il nome &egrave; troppo corto o troppo lungo</p>';
	}
	
	if(!$input->ValidName($username) || $username == ""){
		$error1 = true;
		$error1_text = '<p class="error-message">Il nome non &egrave; valido</p>';
	}
	
	if($input->NameTaken($username)){
		$error1 = true;
		$error1_text = '<p class="error-message">Il nome '.$username.' &egrave; gi&agrave; stato scelto</p>';
	}
	
	if($error1 != true)
		$ok = true;
		
	if($terms == "off" || $terms == "" || $terms == null)
		$error4 = true;
		
	if(!$error1 && !$error4){
		$date = mktime($month, $day, $year);
		mysql_query("INSERT INTO users (username, password, mail, credits, look, motto, account_created, last_online, ip_last, ip_reg, home_room, account) VALUES ('".$username."', '".$input->HoloHash('')."', '".$_SESSION['provider']['profile']['email']."', '".$site['credits']."', 'hd-180-2.lg-285-81.hr-828-42.sh-290-90.ch-215-92', 'Benvenuto!', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['REMOTE_ADDR']."', '0', '".$_SESSION['provider']['id']."')");
	
		$user_id = mysql_insert_id(); 
		mysql_query("INSERT INTO accounts (id, provider, email, current) VALUES (".$_SESSION['provider']['id'].", 'Facebook', '".$_SESSION['provider']['email']."', '".$user_id."')");
		mysql_query("INSERT INTO user_stats (id, RoomVisits, OnlineTime, Respect, RespectGiven, GiftsGiven, GiftsReceived, DailyRespectPoints, DailyPetRespectPoints) VALUES ('".$user_id."', 0, 0, 0, 0, 0, 0, 3, 3)"); 
		mysql_query("INSERT INTO user_info (user_id, bans, cautions, reg_timestamp, login_timestamp, cfhs, cfhs_abusive) VALUES ('".$user_id."', '0', '0', UNIX_TIMESTAMP(), '0', '0', '0')"); 
		mysql_query("INSERT INTO cms_homes_stickers (userid, x, y, z, data, type, subtype, skin, groupid, var) VALUES (".$user_id.", '20', '19', '302', '', '2', '1', 'defaultskin', -1, NULL)");

		$user->login($_SESSION['provider']['email'], '', "off", true);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<title><?php echo $site['short']; ?> -  </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo PATH; ?>/web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="alternate" type="application/rss+xml" title="Habbo Hotel - RSS" href="http://www.habbo.com/articles/rss.xml" />
<meta name="csrf-token" content="807b3ea7c2"/>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/embed.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/embed.js" type="text/javascript"></script>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
<link media="only screen and (max-device-width: 480px)" href="<?php echo PATH; ?>/web-gallery/styles/small-device.css" type= "text/css" rel="stylesheet">

<link rel="stylesheet" href="/styles/local/com.css" type="text/css" />

<script src="/js/local/com.js" type="text/javascript"></script>

<script type="text/javascript">
var ad_keywords = "";
var ad_key_value = "";
</script>
<script type="text/javascript">
document.habboLoggedIn = false;
var habboName = null;
var habboId = null;
var habboReqPath = "";
var habboStaticFilePath = "<?php echo PATH; ?>/web-gallery";
var habboImagerUrl = "http://www.habbo.com/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo PATH; ?>/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "33f5cf82382eddb434ec50d631ca350ba765498d";
    HabboClient.maximizeWindow = true;
}


</script>

<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

<meta property="fb:app_id" content="183096284873" />

<meta property="og:site_name" content="Habbo Hotel" />
<meta property="og:title" content="Habbo Hotel - " />
<meta property="og:url" content="<?php echo PATH; ?>" />
<meta property="og:image" content="http://www.habbo.com/v2/images/facebook/app_habbo_hotel_image.gif" />
<meta property="og:locale" content="it_IT" />

<script src="<?php echo PATH; ?>/web-gallery/static/js/identity.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/identity.css" type="text/css" />

<meta name="description" content="Check into the world's largest virtual hotel for FREE! Meet and make friends, play games, chat with others, create your avatar, design rooms and more..." />
<meta name="keywords" content="habbo hotel, virtual, world, social network, free, community, avatar, chat, online, teen, roleplaying, join, social, groups, forums, safe, play, games, online, friends, teens, rares, rare furni, collecting, create, collect, connect, furni, furniture, pets, room design, sharing, expression, badges, hangout, music, celebrity, celebrity visits, celebrities, mmo, mmorpg, massively multiplayer" />

<script src="//cdn.optimizely.com/js/13389159.js"></script>

<!--[if IE 8]>
<link rel="stylesheet" href="http://habboo-a.akamaihd.net/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1644/web-gallery/static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="http://habboo-a.akamaihd.net/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1644/web-gallery/static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="http://habboo-a.akamaihd.net/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1644/web-gallery/static/styles/ie6.css" type="text/css" />
<script src="http://habboo-a.akamaihd.net/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/1644/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="63-BUILD-FOR-PATCH-1644a - 30.03.2013 01:21 - com" />
</head>

<body id="embedpage">
<div id="overlay"></div>

<div id="container">

    <div id="content">
  <div id="landing-container">

      <div class="cbb" id="rpx-more-info">
        <div class="more-info-container">
          <div class="header">Nuovo Utente</div>
          <div class="subheader">Non hai mai giocato ad <?php echo $site['short']; ?> prima?</div>
          <p>Vi preghiamo di comunicarci alcuni dati personali prima di entrare in hotel. Non condividere queste informazioni con nessuno, questo &egrave; per motivi di sicurezza.</p>

		<div id="error-messages-holder" class="error-messages-holder" <?php echo $error1 == true || $error2 == true || $error3 == true || $error4 == true ? '' : 'style="display:none;"'; ?>>
			<ul>
				<li id="name_err" <?php echo $error1 == true ? '' : 'style="display:none;"'; ?>><?php echo $error1_text; ?></li>
				<li id="terms_err" <?php echo $error4 == true ? '' : 'style="display:none;"'; ?>><p class="error-message">Accetta i termini di servizio</p></li>
			</ul>
		</div>
		
<form id="landing-form" action="" method="post">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<style>
#name-suggestions{margin-right:13px;clear:left}
#name-suggestions .available p{margin-top:5px;border:3px solid lightgreen;padding:5px 5px 5px 25px;background:#dfffdf url(/web-gallery/v2/images/registration/tick.png) no-repeat 2px 50%;line-height:16px}
#name-suggestions{margin-right:13px;clear:left}
#name-suggestions .available p{margin-top:5px;border:3px solid lightgreen;padding:5px 5px 5px 25px;background:#dfffdf url(/web-gallery/v2/images/registration/tick.png) no-repeat 2px 50%;line-height:16px}
#name-suggestions .taken{margin-top:5px;border:3px solid #f4de64;padding:5px;background-color:#ffe}
#name-suggestions .taken p{display:inline;padding:5px 0}
#name-suggestions .help{margin-left:0}
input.text-field{border:2px solid #e2001a;background:#fff4f2 url(/web-gallery/v2/images/registration/exclamation.png) no-repeat scroll 99% 50%;}

</style>
<script>
function Registrami(){
	form = document.forms['landing-form'];
	form.submit();
}
function NameTaken (){
	form = document.forms['landing-form'];
	username = form.elements['username'];
	$.get("nametaken.php?password=&habbo_name=" + username.value, function(data)
	{
		if($.trim(data) != "1")
		{
			document.getElementById('name-suggestions').style.display='none';
			
			if(username.value == '')
				document.getElementById('name_err').innerHTML = '<p class="error-message">Il nome non &egrave; valido</p>';
			else
				document.getElementById('name_err').innerHTML = '<p class="error-message">Il nome ' + username.value + ' &egrave; gi&agrave; stato scelto</p>';
			
			document.getElementById('name_err').style.display='block';
			document.getElementById('error-messages-holder').style.display='block';
			username.className = 'text-field';
		}else{
			document.getElementById('name_err').style.display='none';
			username.className = '';
			document.getElementById('succ_name').innerHTML = '<p>Congratulazioni! Il nome <strong>' + username.value + '</strong> &egrave; disponibile.</p>';
			document.getElementById('name-suggestions').style.display='block';
		}
	});
}
</script>
		<div class="field field-username">
              <label>Nome Utente</label><br>
              <input type="text" id="username" <?php if($error1){ echo 'class="text-field"'; } ?> name="username" value="<?php echo $username; ?>"/><a href="javascript:NameTaken();" class="new-button" id="more_data_submit"><b>Verifica</b><i></i></a>
			<div id="name-suggestions" <?php echo $error1 != true && $ok != true ? 'style="display:none;"' : ''; ?>>
                <div id="succ_name" class="available"><?php echo $error1 != true ? '<p>Congratulazioni! Il nome <strong>'.$username.'</strong> &egrave; disponibile.</p>' : ''; ?></div>
            </div>
		</div>
		
          <div class="field tos">
            <label id="tos">
              <input type="checkbox" name="termsOfServiceAccepted" id="terms" <?php echo $error4 != true ? 'checked' : ''; ?> class="checkbox-field"/>
              Accetto i <a href="http://help.habbo.com/entries/23096348-Terms-of-Service-and-Privacy-Policy" target="_blank" onclick="window.open('http://help.habbo.com/entries/23096348-Terms-of-Service-and-Privacy-Policy'); return false;">Termini di Servizio</a>
            </label>
          </div>

          <br />
          <a href="#" class="new-button" id="more_data_submit" onclick="Registrami();"><b>Finito</b><i></i></a>
		  <input type="hidden" name="next" value="true">
        </form>
        </div>
      </div>
  </div>
  <div id="landing-caption"><?php echo $site['name']; ?>... Fatti conoscere, gioca ed esprimi la tua idea</div>
</div>
<?php include("templates/footer.php"); ?>
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
  _gaq.push(['_setAccount', 'UA-448325-2']);
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

<!-- HELP-25840 -->
<!-- Google Code for US Visits -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1065925576;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "666666";
var google_conversion_label = "Gcy4CLjMkwIQyPei_AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1065925576/?label=Gcy4CLjMkwIQyPei_AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!-- End Google Code for US Visits -->
    
    
        


</body>
</html>
