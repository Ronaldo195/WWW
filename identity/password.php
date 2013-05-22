<?php
include("../core.php");
include("../includes/session.php");
include("../recaptcha/recaptchalib.php");

if($user->account['password'] == '')
	header("Location: avatars");
	
$resp = null;
$error1 = false;
$error2 = false;
$error3 = false;
$error4 = false;
$ok = false;

if(isset($_POST["next"]) && $_POST["next"] == 1){
	$currentpsw = isset($_POST['currentPassword']) ? $input->EscapeString($_POST['currentPassword']) : '';
	$newpsw = isset($_POST['newPassword']) ? $input->EscapeString($_POST['newPassword']) : '';
	$retypepsw = isset($_POST['retypedNewPassword']) ? $input->EscapeString($_POST['retypedNewPassword']) : '';
	$challange = isset($_POST['recaptcha_challenge_field']) ? $input->EscapeString($_POST['recaptcha_challenge_field']) : '';
	$response = isset($_POST['recaptcha_response_field']) ? $input->EscapeString($_POST['recaptcha_response_field']) : '';
	
	$resp = recaptcha_check_answer("6LdBFN8SAAAAAOXmIvxf1Dfhb5ZF3i2XdGbC2-AW", $_SERVER['REMOTE_ADDR'], $challange, $response);

	if($currentpsw == '' || $input->HoloHash($currentpsw) != $user->account['password']){
		$error1 = true;
	}
	else if(!$input->ValidPass($newpsw) || strlen($newpsw) < 6 || strlen($newpsw) > 23){
		$error2 = true;
	}
	else if($newpsw == '' || $newpsw == '' || $newpsw != $retypepsw){
		$error3 = true;
	}
	else if (!$resp->is_valid) {
        $error4 = true;
    }
	
	if(!$error1 && !$error2 && !$error3 && !$error4){
		mysql_query("UPDATE accounts SET password = '".$input->HoloHash($newpsw)."' WHERE id = '".$user->row['account']."'");
		$user->Refresh($user->row['username']);
		$ok = true;
	}
}

include("header.php");
?>

<div id="container">

    <div class="settings-container clearfix">
        <h1>Gestione Account</h1>
	        <div id="back-link">
	        	<a href="avatars">I miei personaggi Habbo</a> &raquo; <a href="settings"> Gestione Account</a> &raquo; Cambia Password
	        </div>        
        <div style="padding: 0 10px">
		
		<?php if($error1 || $error2 || $error3 || $error4){ ?>
		<div class="error-messages-holder">
            <h3>Risolvi il seguente problema e completa nuovamente il campo richiesto.</h3>
            <ul>
                <?php
					if($error1)
						echo '<li><p class="error-message">La tua password attuale non corrisponde.</p></li>';
					else if($error2)
						echo '<li><p class="error-message">Password non valida. Inserisci una Password valida.</p></li>';
					else if($error3)
						echo '<li><p class="error-message">Le password non corrispondono.</p></li>';
					else if($error4)
						echo '<li><p class="error-message">Questo codice di sicurezza non &egrave; valido, inseriscilo nuovamente.</p></li>';
				?>
            </ul>
        </div>
		<?php }else if($ok == true){ ?>
			<p class="confirmation" style="margin-top:10px; text-align: center; font-weight: bold;">La tua password &egrave; stata cambiata con successo.</p>
		<?php } ?>
         <form id="change-password" method="post" action="">
            <input type="hidden" name="next" value="1" />
            <div class="field field-currentpassword">
              <label for="current-password">Password attuale</label>
              <input type="password" id="current-password" size="35" name="currentPassword" value="" class="password-field" maxlength="32"/>
              <p class="help"></p>
            </div>

            <div class="form-box">
            <div class="field field-password">
              <label for="password">Nuova Password</label>
              <input type="password" id="password" size="35" name="newPassword" value="" class="password-field" maxlength="32"/>
            </div>

            <div class="field field-password2">
              <label for="password2">Nuova Password (di nuovo)</label>
              <input type="password" id="password2" size="35" name="retypedNewPassword" value="" class="password-field" maxlength="32"/>
              <p class="help">La tua Password deve essere lunga almeno 6 caratteri.</p>
            </div>
            </div>

            <div id="register-fieldset-captcha" class="field field-captcha">
            <label>Digita qui sotto il codice di sicurezza.</label>
			<?php echo recaptcha_get_html("6LdBFN8SAAAAAEZfiyb7lVc2fT6MOIeF28JDGCJ5"); ?>
                <!--<noscript>
                    <iframe src="https://www.google.com/recaptcha/api/noscript?k=6LdBFN8SAAAAAEZfiyb7lVc2fT6MOIeF28JDGCJ5" height="300" width="290" frameborder="0"></iframe><br/>
                </noscript>
                <input type="text" id="recaptcha_response_field" value="" autocomplete="off" name="recaptcha_response_field" class="text-field"/>
                <div id="recaptcha_image" class="register-label"></div>
            <br clear="all"/><a href="#" id="captcha-reload" onclick="Utils.reloadRecaptcha(); return false;">Prova ad usare altre parole</a>-->
            </div>

            <div style="overflow: hidden">
                <a href="#" class="new-button password-button" id="next-btn" onclick="$(this).up('form').submit(); return false;"><b>Cambia</b><i></i></a>
                <input type="submit" id="next" value="Cambia" />
            </div>
         </form>
        </div>
    </div>
    <div class="settings-container-bottom"></div>
    <script type="text/javascript">
        document.observe("dom:loaded", function() {
            $(document.body).addClassName("js");
        });
    </script>
    <script type="text/javascript">
        document.observe("dom:loaded", function() {
            Utils.showRecaptcha("register-fieldset-captcha", "6LdBFN8SAAAAAEZfiyb7lVc2fT6MOIeF28JDGCJ5");
        });
    </script>
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
    

    



</body>
</html>
