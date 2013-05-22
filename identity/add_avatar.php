<?php
include("../core.php");

if(isset($_POST['next'])){
	$name = isset($_POST['bean_avatarName']) ? $input->EscapeString($_POST['bean_avatarName']) : '';
	$figure = isset($_POST['bean_figure']) ? $input->EscapeString($_POST['bean_figure']) : '';
	
	if($name != '' && $figure != ''){
		if(!$input->ValidName($name) || $input->NameTaken($name))
			$error = 'Il nome '.$name.' &egrave; gi&agrave; stato scelto';
		else{
		if(mysql_num_rows(mysql_query("SELECT * FROM accounts WHERE id = '".$user->row['account'])) < 50){
			mysql_query("INSERT INTO users (username, password, mail, credits, look, motto, account_created, last_online, ip_last, ip_reg, home_room, account) VALUES ('".$name."', '".$user->account['password']."', '".$user->account['email']."', '".$site['credits']."', '".$figure."', 'Benvenuto!', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['REMOTE_ADDR']."', '0', '".$user->row['account']."')");

			$user_id = mysql_insert_id(); 
			mysql_query("INSERT INTO user_stats (id, RoomVisits, OnlineTime, Respect, RespectGiven, GiftsGiven, GiftsReceived, DailyRespectPoints, DailyPetRespectPoints) VALUES ('".$user_id."', 0, 0, 0, 0, 0, 0, 3, 3)"); 
			mysql_query("INSERT INTO user_info (user_id, bans, cautions, reg_timestamp, login_timestamp, cfhs, cfhs_abusive) VALUES ('".$user_id."', '0', '0', UNIX_TIMESTAMP(), '0', '0', '0')"); 
			mysql_query("UPDATE accounts SET current = ".$user_id." WHERE id = '".$user->row['account']."'");
			mysql_query("INSERT INTO cms_homes_stickers (userid, x, y, z, data, type, subtype, skin, groupid, var) VALUES (".$user_id.", '20', '19', '302', '', '2', '1', 'defaultskin', -1, NULL)");

			$user->Refresh($name);
			header("location: ../security_check.php"); exit;
		}
		else
			$error = 'Hai gi&agrave; 50 personaggi.';
		}
	}
	else
		$error = 'Scegli un nome.';

}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<title><?php echo $site['short']; ?>: Aggiungi personaggio </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo PATH; ?>/web-gallery/v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="alternate" type="application/rss+xml" title="Habbo: RSS" href="http://www.habbo.it/articles/rss.xml" />
<link rel="stylesheet" href="<?php echo PATH; ?>/web-gallery/static/styles/embed.css" type="text/css" />
<script src="<?php echo PATH; ?>/web-gallery/static/js/embed.js" type="text/javascript"></script>
<link media="only screen and (max-device-width: 480px)" href="<?php echo PATH; ?>/web-gallery/styles/small-device.css" type= "text/css" rel="stylesheet">



<script type="text/javascript">
var ad_keywords = "gender%3Am,age%3A23";
var ad_key_value = "kvage=23;kvgender=m;kvtags=";
</script>
<script type="text/javascript">
document.habboLoggedIn = true;
var habboName = "krid";
var habboId = 4203773;
var facebookUser = false;
var habboReqPath = "";
var habboStaticFilePath = "h<?php echo PATH; ?>web-gallery";
var habboImagerUrl = "http://www.habbo.it/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "http://www.habbo.it/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "a3bf8790cf435290f933cea645508eb607fb75bf";
    HabboClient.maximizeWindow = true;
}


</script>

<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

<meta property="fb:app_id" content="163345683587" />
<meta property="fb:admins" content="100001245540290" />
<meta property="og:site_name" content="Habbo Hotel" />
<meta property="og:title" content="Habbo: Aggiungi personaggio" />
<meta property="og:url" content="http://www.habbo.it" />
<meta property="og:image" content="http://www.habbo.it/v2/images/facebook/app_habbo_hotel_image.gif" />
<meta property="og:locale" content="it_IT" />

<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/common.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/avatarselection.css" type="text/css" />


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
<meta name="build" content="63-BUILD2051 - 02.04.2013 23:19 - it" />
</head>

<body id="embedpage">
<div id="overlay"></div>
<div id="container">

    <script type="text/javascript">
    document.observe("dom:loaded", function() {
        $(document.body).addClassName("js");
        $("habbo-name").focus();
        var checkHandler = function(e) {
            Event.stop(e);
            new Ajax.Updater("name-field-container", "<?php echo PATH; ?>identity/proxy", {
                parameters: { checkNameOnly: "true", "bean.avatarName": $F("habbo-name")},
                onComplete: function() {
                    if ($("name-field-container").select(".state-error").length != 0) {
                        $("habbo-name").focus();
                    }
                }
            });
			
			new Ajax.Updater("error-messages-container", "<?php echo PATH; ?>identity/proxy", {
                parameters: { ErrorNameOnly: "true", "bean.avatarName": $F("habbo-name") }
            });
        };
        Event.observe($("name-field-container"), "click", Event.delegate({
            '#check-name-btn > *' : checkHandler,
            '#check-name-btn' : checkHandler,
            '#name-suggestion-list a' : function(e) {
                Event.stop(e);
                new Ajax.Updater("name-field-container", "<?php echo PATH; ?>identity/proxy", {
                    parameters: { checkNameOnly: "true", "bean.avatarName": Event.element(e).innerHTML },
                    onComplete: function() {
                        if ($("name-field-container").select(".state-error").length != 0) {
                            $("habbo-name").focus();
                        }
                    }
                });
				
				new Ajax.Updater("error-messages-container", "<?php echo PATH; ?>identity/proxy", {
                parameters: { ErrorNameOnly: "true", "bean.avatarName": $F("habbo-name") }
            });
            }
        }));

        if ($("avatar-field-container")) {
            var avatarClickHandler = function(gender) {
                return function(e) {
                    Event.stop(e);
                    new Ajax.Updater("selected-avatar", "<?php echo PATH; ?>identity/proxy", {
                        parameters: { checkFigureOnly: "true", "bean.gender": gender, "bean.figure": $(Event.element(e)).up("a").readAttribute("rel") }
                    });
                }
            };
            Event.observe($("avatar-field-container"), "click", Event.delegate({
                'a.female-avatar img' : avatarClickHandler('f'),
                'a.male-avatar img'   : avatarClickHandler('m'),
                '#more-avatars'       : function(e) {
                        Event.stop(e);
                        new Ajax.Updater("avatar-field-container", "<?php echo PATH; ?>identity/proxy", {
                            parameters: { refreshAvailableFigures: "true" }
                        });
                    }
                }
            ));
        }

        if ($("done-btn")) {
            var submitButton = $("done-btn");
            Event.observe(submitButton, "click", function(e) {
                Event.stop(e);
                if (!submitButton.hasClassName("__submitting__")) {
                    submitButton.addClassName("__submitting__");
                    submitButton.up("form").submit();
                }
            });
        }

        if ($("popup-link")) {
            Event.observe($("popup-link"), "click", function(e) {
                Event.stop(e);
                window.open($("popup-link").href, null, "toolbar=no,location=yes,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=540,height=500");
            });
        }

    });
  </script>

  <div id="add-avatar">
    <div class="add-avatar-container clearfix">
        <div class="title">
          <span class="habblet-close"></span>
          <h1>Aggiungi personaggio</h1>
        </div>
        <div id="content">
            <a id="back-link" href="/identity/avatars">&laquo; Torna ai miei personaggi</a>
            <form id="add-avatar-form" method="post" action="">
			<input type="hidden" name="next" value="1">
            <div id="error-messages-container" style="margin-top: 10px">
			<?php if(isset($error)){ ?>
			<div class="error-messages-holder">
                <h3>Risolvi il seguente problema e completa nuovamente il campo richiesto.</h3>
                <ul>
                    <li><p class="error-message"><?php echo $error; ?></p></li>
                </ul>
			</div>
			<?php } ?>
            </div>

            <div id="name-field-container">
                <div class="field field-habbo-name">
                  <label for="habbo-name">Nome Habbo</label>
                  <a href="#" class="new-button" id="check-name-btn"><b>Disponibile?</b><i></i></a>
                  <input type="text" id="habbo-name" size="26" value="" name="bean.avatarName" class="text-field" maxlength="32"/>
                    <div id="name-suggestions">
                    </div>
                  <p class="help">Il tuo nome pu&ograve; contenere caratteri maiuscoli, minuscoli, numeri e caratteri speciali come _-=?!@:.,</p>
                </div>
            </div>
            <div id="avatar-field-container" class="clearfix">
                <div id="selected-avatar">
                    <h3>Scegli:</h3>
                    <img id="selected_figure" src="http://www.habbo.it/habbo-imaging/avatarimage?figure=hr-890-38.hd-629-7.ch-645-74.lg-695-62.sh-906-74.he-1602-62.ca-1803-62.wa-2011&direction=4" width="64" height="110"/>
					<input type="hidden" name="bean.figure" value="hr-890-38.hd-629-7.ch-645-74.lg-695-62.sh-906-74.he-1602-62.ca-1803-62.wa-2011">
				</div>
                <div id="avatar-choices">
                    <h3>Ragazze</h3>
                        <a href="<?php echo PATH; ?>identity/add_avatar?bean.figure=hr-555-39.hd-628-3.ch-685-81.lg-700-62&amp;bean.gender=f&amp;checkFigureOnly=true" class="female-avatar" rel="hr-555-39.hd-628-3.ch-685-81.lg-700-62">
                            <img src="http://www.habbo.it/habbo-imaging/avatarimage?figure=hr-555-39.hd-628-3.ch-685-81.lg-700-62,s-1.g-1.d-4.h-4.a-0&direction=4&size=s" width="33" height="56"/>
                        </a>
                        <a href="<?php echo PATH; ?>identity/add_avatar?bean.figure=hr-515-34.hd-600-10.ch-655-71.lg-705-80.sh-730-64.ca-1809&amp;bean.gender=f&amp;checkFigureOnly=true" class="female-avatar" rel="hr-515-34.hd-600-10.ch-655-71.lg-705-80.sh-730-64.ca-1809">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-515-34.hd-600-10.ch-655-71.lg-705-80.sh-730-64.ca-1809,s-1.g-1.d-4.h-4.a-0,81e04b3e25dac06f277a03beef7582a9.gif" width="33" height="56"/>
                        </a>
                        <a href="<?php echo PATH; ?>identity/add_avatar?bean.figure=hr-890-45.hd-600-7.ch-660-79.lg-3116-73-1315.ha-1003-78.he-1605-64&amp;bean.gender=f&amp;checkFigureOnly=true" class="female-avatar" rel="hr-890-45.hd-600-7.ch-660-79.lg-3116-73-1315.ha-1003-78.he-1605-64">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-890-45.hd-600-7.ch-660-79.lg-3116-73-1315.ha-1003-78.he-1605-64,s-1.g-1.d-4.h-4.a-0,6e13838b9453baec9b0250a491a92ad5.gif" width="33" height="56"/>
                        </a>
                        <a href="<?php echo PATH; ?>identity/add_avatar?bean.figure=hr-545-45.hd-629-1.ch-685-77.lg-700-62&amp;bean.gender=f&amp;checkFigureOnly=true" class="female-avatar" rel="hr-545-45.hd-629-1.ch-685-77.lg-700-62">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-545-45.hd-629-1.ch-685-77.lg-700-62,s-1.g-1.d-4.h-4.a-0,53f0ac2183ba11793bea1b2061178e69.gif" width="33" height="56"/>
                        </a>
                        <a href="<?php echo PATH; ?>identity/add_avatar?bean.figure=hr-890-35.hd-629-1.ch-665-82.lg-700-81.sh-3115-80-81.he-1605-62.wa-3210-62-62&amp;bean.gender=f&amp;checkFigureOnly=true" class="female-avatar" rel="hr-890-35.hd-629-1.ch-665-82.lg-700-81.sh-3115-80-81.he-1605-62.wa-3210-62-62">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-890-35.hd-629-1.ch-665-82.lg-700-81.sh-3115-80-81.he-1605-62.wa-3210-62-62,s-1.g-1.d-4.h-4.a-0,dea2af1a8981cf128a9756ba99d59166.gif" width="33" height="56"/>
                        </a>

                    <h3>Ragazzi</h3>
                        <a href="http://www.habbo.it/identity/add_avatar?bean.figure=hr-893-42.hd-208-7.ch-230-64.lg-285-77.sh-305-64.wa-2001&amp;bean.gender=m&amp;checkFigureOnly=true" class="male-avatar" rel="hr-893-42.hd-208-7.ch-230-64.lg-285-77.sh-305-64.wa-2001">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-893-42.hd-208-7.ch-230-64.lg-285-77.sh-305-64.wa-2001,s-1.g-1.d-4.h-4.a-0,59451291ad307b25b5f517170bd710c7.gif" width="33" height="56"/>
                        </a>
                        <a href="http://www.habbo.it/identity/add_avatar?bean.figure=hr-893-37.hd-209-9.ch-878-73-62.lg-281-62.ca-1801-64&amp;bean.gender=m&amp;checkFigureOnly=true" class="male-avatar" rel="hr-893-37.hd-209-9.ch-878-73-62.lg-281-62.ca-1801-64">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-893-37.hd-209-9.ch-878-73-62.lg-281-62.ca-1801-64,s-1.g-1.d-4.h-4.a-0,8a6968ee9349b0980fd675286e8bb7e0.gif" width="33" height="56"/>
                        </a>
                        <a href="http://www.habbo.it/identity/add_avatar?bean.figure=hr-679-36.hd-209-3.ch-235-62.lg-275-82.sh-295-82.ha-1009-82.ea-1401-81.fa-1201.wa-3211-82-62&amp;bean.gender=m&amp;checkFigureOnly=true" class="male-avatar" rel="hr-679-36.hd-209-3.ch-235-62.lg-275-82.sh-295-82.ha-1009-82.ea-1401-81.fa-1201.wa-3211-82-62">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-679-36.hd-209-3.ch-235-62.lg-275-82.sh-295-82.ha-1009-82.ea-1401-81.fa-1201.wa-3211-82-62,s-1.g-1.d-4.h-4.a-0,513872a768532e26aedcfb82059d8c56.gif" width="33" height="56"/>
                        </a>
                        <a href="http://www.habbo.it/identity/add_avatar?bean.figure=hr-893-32.hd-209-4.ch-3030-62.lg-281-63.ea-1401-63.wa-3211-64-64&amp;bean.gender=m&amp;checkFigureOnly=true" class="male-avatar" rel="hr-893-32.hd-209-4.ch-3030-62.lg-281-63.ea-1401-63.wa-3211-64-64">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-893-32.hd-209-4.ch-3030-62.lg-281-63.ea-1401-63.wa-3211-64-64,s-1.g-1.d-4.h-4.a-0,c410e5ce95d55ef32c6c15248f8762ab.gif" width="33" height="56"/>
                        </a>
                        <a href="http://www.habbo.it/identity/add_avatar?bean.figure=hr-155-38.hd-180-2.ch-878-70-64.lg-275-72&amp;bean.gender=m&amp;checkFigureOnly=true" class="male-avatar" rel="hr-155-38.hd-180-2.ch-878-70-64.lg-275-72">
                            <img src="http://www.habbo.it/habbo-imaging/avatar/hr-155-38.hd-180-2.ch-878-70-64.lg-275-72,s-1.g-1.d-4.h-4.a-0,506fda8222fa2e4f8e79700a7b4f783a.gif" width="33" height="56"/>
                        </a>
                    <p style="clear: left;"><a href="?refreshAvailableFigures=true" id="more-avatars">Voglio altri look!</a> Puoi cambiare il tuo look pi&ugrave; tardi!</p>
                </div>
            </div>
            <br clear="all"/>
            <a href="#" class="new-button green-button" id="done-btn"><b>Crea un personaggio</b><i></i></a>
            <input type="submit" id="done" value="Crea un personaggio"/>
        </form>
        </div>
    </div>
    <div class="add-avatar-container-bottom"></div>
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
