<?php
include('core.php');

require 'facebook-sdk/src/facebook.php';

if(!isset($_SESSION['user'])){
	if(isset($_POST['username']) && isset($_POST['password'])){
		if($_POST['username'] != '' && $_POST['password'] != ''){
			$password = isset($_POST['password']) ? $input->HoloHash($input->EscapeString($_POST['password'])) : '';
			$username = isset($_POST['username']) ? $input->EscapeString($_POST['username']) : '';
			$user->login($username, $password, isset($_POST['_login_remember_me']) ? $_POST['_login_remember_me'] : "off", false);
		}else{
			$user->login_error = 'Inserisci i dati per accedere';
		}
	}
    
	if(isset($_GET['error']) && $_GET['error'] == 2)
		$user->login_error = 'Connessione non andata a buon fine. Riprova';
		
	if(isset($_POST['emailAddress'])){
		$forgot_email = $input->EscapeString($_POST['emailAddress']);
		$token = sha1(md5($forgot_email));
		
		mysql_query("INSERT INTO cms_reset (mail, token) VALUES ('".$forgot_email."', '".$token."')");
		
		// The message
		$message = '
		<table width="98%" border="0" cellspacing="0" cellpadding="0">
			<tbody><tr>
				<td align="center">

            <table border="0" cellpadding="0" cellspacing="0" width="595">
                <tbody><tr>
                    <td align="left" style="border-bottom:1px solid #aaaaaa;" height="70" valign="middle">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td>
                                    <img src="'.PATH.'web-gallery/v2/images/habbo.png" alt="'.$site['short'].'" width="110" height="40" style="display:block;">
                                </td>
                            </tr>

                        </tbody></table>
                    </td>
                </tr>


<tr>
    <td align="left" style="border-bottom:1px dashed #aaaaaa;" valign="middle">
        <table style="padding:0 0 10px 0;width:100%;" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td valign="top">
                                    <p style="font-family:Verdana,Arial,sans-serif;font-size:20px;padding-top:15px;">
                                        Ciao, '.$forgot_email.'
                                    </p>
                                    <p style="font-family:Verdana,Arial,sans-serif;font-size:12px;padding-bottom:5px;">
                                        Per scegliere una nuova Password clicca <a href="'.PATH.'account/password/resetIdentity/'.$token.'" target="_blank" class="">questo Link</a>.
                                    </p>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
    <td align="left" style="border-bottom:1px solid #aaaaaa;" height="100" valign="middle">
        <table style="" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td valign="middle">
                    <table style="background-color:#51b708;height:50px;" height="50px;" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td style="height:100%;vertical-align:middle;border:solid 2px #000000;" valign="middle">
                                <p style="font-family:Verdana,Arial,sans-serif;font-weight:bold;font-size:18px;color:#ffffff;">
                                                <a style="text-decoration:none;padding:15px 20px;color:#ffffff;" href="'.PATH.'account/password/resetIdentity/'.$token.'" target="_blank">
                                                    Scegli una nuova Password
                                                </a>
</p>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
    <td valign="top" align="center">
        <table style="font-family:Verdana,Arial,sans-serif;text-align:justify;font-size:11px;color:#aaaaaa;padding-top:10px;padding-right:10px;padding-left:10px;padding-bottom:10px;" border="0" cellpadding="0" cellspacing="0" width="595">
            <tbody><tr>
                <td style="height:8px;"></td>
            </tr>
            <tr>
                <td valign="top">
                                </td>
            </tr>
        </tbody></table>
    </td>
</tr>
</tbody></table>

</td>
</tr>
</tbody></table>
		';

		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70, "\r\n");
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$site['short'].' IT <pronoweb@libero.it>';
		// Send
		mail($forgot_email, 'Modifica la tua Password', $message, $headers);
	}
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" xmlns:fb="http://ogp.me/ns/fb"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $site['name']; ?> - Incontra nuovi amici, divertiti, fatti conoscere! </title>
<meta name="viewport" content="width=device-width">

<script>
var andSoItBegins = (new Date()).getTime();
var habboPageInitQueue = [];
var habboStaticFilePath = "<?php echo PATH; ?>web-gallery";
</script>
<link rel="shortcut icon" href="<?php echo PATH; ?>web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic">

<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/v3_landing.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/v3_landing_top.js" type="text/javascript"></script>

<meta name="description" content="Check into the world's largest virtual hotel for FREE! Meet and make friends, play games, chat with others, create your avatar, design rooms and more..." />
<meta name="keywords" content="<?php echo $site['short']; ?> hotel, virtuale, mondo, social network, gratis, community, avatar, chat, online, giovani, roleplaying, join, social, groups, forums, safe, play, games, online, friends, teens, rares, rare furni, collecting, create, collect, connect, furni, furniture, pets, room design, sharing, expression, badges, hangout, music, celebrity, celebrity visits, celebrities, mmo, mmorpg, massively multiplayer" />

<script src="//cdn.optimizely.com/js/13389159.js"></script>

<meta name="build" content="63-BUILD2041 - 27.03.2013 11:38 - com" />

</head>
<body>

<div id="overlay"></div>


<div id="change-password-form" class="overlay-dialog" style="display: none;">
<div id="change-password-form-container" class="clearfix form-container">
<h2 id="change-password-form-title" class="bottom-border">Password dimenticata?</h2>
<div id="change-password-form-content" style="display: none;">
<form method="post" action="<?php echo PATH; ?>?changePwd=true" id="forgotten-pw-form">
<input type="hidden" name="next" value="1">
<span>Scrivi qui l'indirizzo email del tuo Account <?php echo $site['short']; ?>:</span>
<div id="email" class="center bottom-border">
<input type="text" id="change-password-email-address" name="emailAddress" value="" class="email-address" maxlength="48"/>
<div id="change-password-error-container" class="error" style="display: none;">Perfavore, inserisci un'email valida.</div>
</div>
</form>
<div class="change-password-buttons">
<a href="#" id="change-password-cancel-link">Annulla</a>
<a href="#" id="change-password-submit-button" class="new-button"><b>Invia Email</b><i></i></a>
</div>
</div>
<div id="change-password-email-sent-notice" style="display: none;">
<div class="bottom-border">
<span>Ciao! Ti abbiamo appena inviato un'email con il link alla pagina in cui potrai modificare la tua Password.<br></span>
<div id="email-sent-container"><?php echo isset($forgot_email) ? $forgot_email : ''; ?></div>
</div>
<div class="change-password-buttons">
<a href="#" id="change-password-change-link">Indietro</a>
<a href="#" id="change-password-success-button" class="new-button"><b>Chiudi</b><i></i></a>
</div>
</div>
</div>
<div id="change-password-form-container-bottom" class="form-container-bottom"></div>
</div>

<script type="text/javascript">
function initChangePasswordForm() {
ChangePassword.init();
}
if (window.HabboView) {
HabboView.add(initChangePasswordForm);
} else if (window.habboPageInitQueue) {
habboPageInitQueue.push(initChangePasswordForm);
}
</script>

<script src="//connect.facebook.net/en_US/all.js"></script>

<header>
<div id="border-left"></div>
<div id="border-right"></div>
<?php
if(isset($user->login_error) && $user->login_error != ''){
	echo "
<div id=\"login-errors\">
    ".$user->login_error."
</div>
	";
}
?>
<div id="login-form-container">
<a href="#home" id="habbo-logo"></a>

<form action="" method="post">


<div id="login-columns">
<div id="login-column-1">
<label for="credentials-email">Email</label>
<input tabindex="2" type="text" name="username" id="credentials-email" value="">
<input tabindex="5" type="checkbox" name="_login_remember_me" id="credentials-remember-me">
<label for="credentials-remember-me" class="sub-label">Ricordati di me</label>
</div>

<div id="login-column-2">
<label for="credentials-password">Password</label>
<input tabindex="3" type="password" name="password" id="credentials-password">
<a href="#" id="forgot-password" class="sub-label">Password dimenticata?</a>
</div>

<div id="login-column-3">
<input type="submit" value="Login" style="margin: -10000px; position: absolute;">
<a href="#" tabindex="4" class="button" id="credentials-submit"><b></b><span>Entra</span></a>
</div>

<div id="login-column-4">
<div id="fb-root"></div>
<script type="text/javascript">
    window.fbAsyncInit = function() {
        Cookie.erase("fbsr_<?php echo APP_ID; ?>");
        FB.init({appId: '<?php echo APP_ID; ?>', status: true, cookie: true, xfbml: true});
        if (window.habboPageInitQueue) {
            // jquery might not be loaded yet
            habboPageInitQueue.push(function() {
                $(document).trigger("fbevents:scriptLoaded");
            });
        } else {
            $(document).fire("fbevents:scriptLoaded");
        }

    };
    window.assistedLogin = function(FBobject, optresponse) {
        
        Cookie.erase("fbsr_<?php echo APP_ID; ?>");
        FBobject.init({appId: '<?php echo APP_ID; ?>', status: true, cookie: true, xfbml: true});

        permissions = 'user_birthday,email';
        defaultAction = function(response) {

            if (response.authResponse) {
                fbConnectUrl = "<?php echo PATH; ?>facebook?connect=true";
                Cookie.erase("fbhb_val_<?php echo APP_ID; ?>");
                Cookie.set("fbhb_val_<?php echo APP_ID; ?>", response.authResponse.accessToken);
                window.location.replace(fbConnectUrl);
            }
        };

        if (typeof optresponse == 'undefined')
            FBobject.login(defaultAction, {scope:permissions});
        else
            FBobject.login(optresponse, {scope:permissions});

    };

    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol + '//connect.facebook.net/it_IT/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
</script>


<a href="javascript:void(0);" onclick="assistedLogin(FB); return false;">
    <img src="<?php echo PATH; ?>web-gallery/images/fb_connect.png">
</a>


<script type="text/javascript">
(function() {
    if (typeof window.janrain !== 'object') window.janrain = {};
    if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};
    
    janrain.settings.tokenUrl = '<?php echo PATH; ?>api_rpx.php';

    function isReady() { janrain.ready = true; };
    if (document.addEventListener) {
      document.addEventListener("DOMContentLoaded", isReady, false);
    } else {
      window.attachEvent('onload', isReady);
    }

    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.id = 'janrainAuthWidget';

    if (document.location.protocol === 'https:') {
      e.src = 'https://rpxnow.com/js/lib/hablux/engage.js';
    } else {
      e.src = 'http://widget-cdn.rpxnow.com/js/lib/hablux/engage.js';
    }

    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(e, s);
})();
</script>
<div id="rpx-signin">
<a style="font-size:12px;font-weight:bold;color:#6898bd" class="janrainEngage" onclick="return false;" href="#">...o con un altro servizio >></a>
</div>        </div>
</div>
</form>
</div>

<script>
habboPageInitQueue.push(function() {
if (!LandingPage.focusForced) {
LandingPage.fieldFocus('credentials-email');
}
});
</script>
<div id="alerts">
<noscript>
<div id="alert-javascript-container">
<div id="alert-javascript-title">
Missing JavaScript support
</div>
<div id="alert-javascript-text">
Javascript is disabled on your browser. Please enable JavaScript or upgrade to a Javascript-capable browser to use Habbo :)
</div>
</div>
</noscript>

<div id="alert-cookies-container" style="display:none">
<div id="alert-cookies-title">
Missing cookie support
</div>
<div id="alert-cookies-text">
Cookies are disabled on your browser. Please enable cookies to use Habbo.
</div>
</div>
<script type="text/javascript">
document.cookie = "habbotestcookie=supported";
var cookiesEnabled = document.cookie.indexOf("habbotestcookie") != -1;
if (cookiesEnabled) {
var date = new Date();
date.setTime(date.getTime()-24*60*60*1000);
document.cookie="habbotestcookie=supported; expires="+date.toGMTString();
} else {
if (window.habboPageInitQueue) {
// jquery might not be loaded yet
habboPageInitQueue.push(function() {
$('#alert-cookies-container').show();
});
} else {
$('alert-cookies-container').show();
}
}
</script>
</div>
<div id="top-bar-triangle"></div>
<div id="top-bar-triangle-border"></div>
</header>

<style>
.loading {
	background-image: url('/web-gallery/v2/images/page_loader.gif');
	background-repeat: no-repeat;
	background-size: 20px 20px;
	background-position:right;
}

.ok {
	background-image: url('/web-gallery/v2/images/ok.png');
	background-repeat: no-repeat;
	background-size: 20px 20px;
	background-position:right;
}
</style>

<div id="content">
<ul>
<li id="home-anchor">
<div id="welcome">
<a href="#registration" class="button large" id="join-now-button"><b></b><span>REGISTRATI ORA!</span><span class="sub">(&Egrave; gratis e sicuro)</span></a>
<div id="slogan">
<h1>Benvenuto in <?php echo $site['short']; ?>,</h1>
<p>un posto strano con gente fantastica!</p>
<p><a id="tell-me-more-link" href="#">Dimmi di più...</a></p>
</div>
</div>
<div id="carousel">
<div id="image1">
<style>
#people-inside{
	display:block;
	float:left;
	height:65px;
	position:relative;
	overflow:hidden;
	white-space:nowrap;
	z-index:100;
	top:30px;
	left:70px;
}
#people-inside b{
	float:left;
	padding:5px 10px 4px 16px;
	font-size:12px;
	height:56px;
	min-width:45px;
	max-width:145px;
	margin-right:8px;
	background:transparent url(web-gallery/v2/images/users_online_bubble.png) no-repeat -8px 0;
	color:#000;
	font-weight:normal;
	text-align:center;
	display:inline;
}
#people-inside i{
	position:absolute;
	right:0;
	top:0;
	width:8px;
	height:65px;
	background:transparent url(web-gallery/v2/images/users_online_bubble.png) no-repeat 0 0;
}
#people-inside span{
	display:block;
}
#people-inside .stats-fig{
	font-size:18px;
	font-weight:bold;
}
</style>
<div id="people-inside">
    <b><span><span class="stats-fig"><?php echo $input->GetOnline(); ?></span> <?php echo $site['short']; ?> in Hotel</span></b>
    <i></i>
</div>
</div>
<div id="image2"></div>
<div id="image3"></div>
<div id="tell-me-more"><?php echo $site['name']; ?> è un mondo virtuale in cui puoi creare il tuo personaggio e divertirti arredando le tue stanze, conoscendo nuovi amici, organizzando feste, chattando, prendendoti cura dei tuoi animali e molto altro! <br><br>Cosa aspetti? Clicca su 'Registrati Ora' per iniziare!</div>
</div>
<div id="floaters"></div>
</li>

<li id="registration-anchor">

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo PATH; ?>index.js"></script>

<div id="registration-form" class="show-captcha">
<div id="registration-form-header">
<h2>CREA IL TUO <?php echo $site['short']; ?></h2>
<p>Riempi i seguenti campi per registrare il tuo account:</p>
</div>
<div id="change-password-form2" class="overlay-dialog2" style="display: none;">
<div id="change-password-form-container" class="clearfix form-container">
<div id="change-password-form-content" style="text-align:center;">
<img src="<?php echo PATH; ?>web-gallery/images/progress_habbos.gif">
</div>
<div id="change-password-email-sent-notice" style="display: none;">
</div>
</div>
<div id="change-password-form-container-bottom" class="form-container-bottom"></div>
</div>

<div id="registration-form-main">
<form id="register-new-user" autocomplete="off" action="index.php">
<input type="hidden" name="next" value="">
<div id="registration-form-main-left">
<label for="registration-birthday">Data di Nascita</label>
<label for="registration-birthday" class="details">Necessaria per motivi di sicurezza.</label>
<div id="registrationBean.birth.error" style="display:none;">
	<div class="field-error">Data non valida o miniore di 13 anni</div>
</div>
<div id="registration-birthday">
<select name="registrationBean.month" id="registrationBean_month" class="dateselector"><option value="">Mese</option><option value="1">Gennaio</option><option value="2">Febbraio</option><option value="3">Marzo</option><option value="4">Aprile</option><option value="5">Maggio</option><option value="6">Giugno</option><option value="7">Luglio</option><option value="8">Agosto</option><option value="9">Settembre</option><option value="10">Ottobre</option><option value="11">Novembre</option><option value="12">Dicembre</option></select>
<select name="registrationBean.day" id="registrationBean_day" class="dateselector"><option value="">Giorno</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
<select name="registrationBean.year" id="registrationBean_year" class="dateselector"><option value="">Anno</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option><option value="1901">1901</option><option value="1900">1900</option></select>
</div>
<label for="registration-email">Email</label>
<label for="registration-email" class="details">Puoi utilizzarlo per effettuare l'accesso e per associare altri username.</label>
<div id="registrationBean.email.error" style="display:none;">
	<div class="field-error">Email non valida o gi&agrave; esistente.</div>
</div>

<input type="email" name="registrationBean.email" id="registration-email" value="">

</div>
<div id="registration-form-main-right">

<label for="registration-username">Username</label>
<label for="registration-username" class="details">Il tuo Username può contenere da <b>3 a 24</b> caratteri e <b>nessuno spazio</b>.</label>
<div id="registrationBean.username.error" style="display:none;">
	<div class="field-error">Username non valida o già esistente.</div>
</div>
<input type="text" name="registrationBean.username" id="registration-username" value="" class="">
<span id="password-field-container">
<label for="registration-password">Password</label>
<label for="registration-password" class="details">La password deve essere almeno <b>6 caratteri</b>.</b></label>
<div id="registrationBean.password.error" style="display:none;">
	<div class="field-error">Per favore, inserisci una password valida.</div>
</div>
<input type="password" name="registrationBean.password" id="registration-password" maxlength="32" value="">
</span>

<p class="checkbox-container" id="registration-tos">
<div id="registrationBean.conditions.error" style="display:none;">
	<div class="field-error">Per favore, accetta i termini di servizio.</div>
</div>
<input type="checkbox" id="tos" name="registrationBean.termsOfServiceSelection">
<label for="tos" class="details checkbox">
Accetto i <a href="<?php echo PATH; ?>Terms-of-Service" target="_blank" onclick="window.open('<?php echo PATH; ?>Terms-of-Service'); return false;">Termini di Servizio</a> e la Politica di Privacy di <?php echo $site['short']; ?>.
</label>
</p>

</div>

<div id="registration-form-main-right2">

<div id="captcha-container">

<label for="recaptcha_response_field">Sei umano?</label>
<label for="recaptcha_response_field" class="details">Inserisci il numero che vedi nel box:</label>

<div id="captcha-image-container" style="padding-left:8px;text-align:center;">
<div style="background:white;width:300px;height:56px;">
<div id="recaptcha_image" style="color:#000;letter-spacing:2px;font-weight:bold;color:#000000;font-size:40px;text-align:center;"></div>
</div>
<div id="captcha-overlay"></div>
</div>
<p id="captcha-new" class="details"><a class="recaptcha-reload" href="#" onclick="fnCaptcha();">Nuovo numero</a></p>
<div id="registrationBean.captcha.error" style="display:none;">
	<div class="field-error">Per favore, inserisci il numero valido.</div>
</div>
<input type="text" name="recaptcha_response_field" id="recaptcha_response_field">

</div>

<div class="submit-button-wrapper">
<a href="#" class="button large not-so-large register-submit" onclick="Registrami();"><b></b><span>Fatto!</span></a>
</div>
</div>
<script>
$('#registration-username').focusout(function(){ NameTaken(this); });
$('#registration-password').focusout(function(){ PassTaken(this); });
$('#registration-email').focusout(function(){ MailTaken(this); });
<?php
if(isset($forgot_email))
	echo "window.onload=function(){ChangePassword.showChangeEmailPasswordSentNotice('".$forgot_email."');}";
?>
</script>
</form>
</div>
</div>
<div id="magnifying-glass"></div>
<div id="sail"></div>
</li>
</ul>
</div>

<footer>
<div id="age-recommendation"></div>

<div id="footer-content">
<?php $home = 1; include("templates/footer.php"); ?>
</div>
<div id="sulake-logo"><a href="http://qubise.com/"></a></div>
</footer>


<script src="<?php echo PATH; ?>web-gallery/static/js/v3_landing_bottom.js" type="text/javascript"></script>
<!--[if IE]><script src="<?php echo PATH; ?>web-gallery/static/js/v3_ie_fixes.js" type="text/javascript"></script>
<![endif]-->



<script type="text/javascript">
var rpxJsHost = (("https:" == document.location.protocol) ? "https://" : "http://static.");
document.write(unescape("%3Cscript src='" + rpxJsHost +
"rpxnow.com/js/lib/rpx.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
RPXNOW.overlay = false;
RPXNOW.language_preference = 'en'; 
RPXNOW.flags = 'show_provider_list';
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

</body>
</html>

<?php } else {
header("location:me");
}
?>
