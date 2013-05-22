<?php
include("../core.php");
include("../includes/session.php");

if(isset($_SESSION['provider']))
	header("Location: avatars");
	
$error1 = false;
$error2 = false;
$ok = false;

if(isset($_POST['next']) && $_POST['next'] == '1'){
	$mail = isset($_POST['email']) ? $input->EscapeString($_POST['email']) : '';
	$password = isset($_POST['currentPassword']) ? $input->EscapeString($_POST['currentPassword']) : '';
	
	if($mail == '' || !$input->ValidMail($mail))
		$error1 = true;
	else if($password == '' || $user->account['password'] != $input->HoloHash($password))
		$error2 = true;
	
	if($error1 == false && $error2 == false){
		mysql_query("UPDATE accounts SET email = '".$mail."' WHERE id = '".$user->row['account']."'");
		$user->Refresh($user->row['username']);
		$ok = true;
	}
}

include("header.php");
?>
<div id="container">

    <div class="settings-container clearfix">
        <h1>Gestisci i tuoi indirizzi email</h1>
        <div id="back-link">
            <a href="<?php echo PATH; ?>identity/avatars">I miei personaggi</a> &raquo; <a href="<?php echo PATH; ?>identity/settings"> Gestione Account</a> &raquo; Modifica indirizzo email
        </div>
        <div style="padding: 10px 10px 0 10px">

            <?php if($error1 == true || $error2 == true){ ?>
            <p>I cambiamenti avranno effetto su tutti i personaggi collegati al tuo account.</p>
			<div class="error-messages-holder">
				<h3>Si sono verificati i seguenti errori:</h3>
				<ul>
					<?php if(!isset($_POST['email']) || !isset($_POST['currentPassword'])){ ?><li><p class="error-message">Tutti i campi sono richiesti</p></li><?php } ?>
					<?php if($error1 == true){ ?><li><p class="error-message">Per favore, inserisci un indirizzo email valido</p></li><?php } ?>
					<?php if($error2 == true){ ?><li><p class="error-message">Le due password non corrispondono</p></li><?php } ?>
				</ul>
			</div>
			<?php }else if($ok == true){ ?>
			<p class="confirmation" style="margin-top:10px; text-align: center; font-weight: bold;">Il tuo indirizzo email &egrave; stato cambiato con successo.</p>
			<?php } ?>
            <div class="form-box" style="margin-top: 10px">
			<form name="change_email_form" action="" method="post" id="new-email-form">
				<input type="hidden" name="next" value="1"/>
                <div class="field">
					<label for="newEmailAddress" style="width: auto">Attuale indirizzo email</label>
					<p><b><?php echo $user->account['email']; ?></b></p>
                    <label for="newEmailAddress" style="width: auto">Inserisci il nuovo indirizzo email</label>
                    <input type="text" id="newEmailAddress" name="email" value="" class="text-field" />
                        <label for="passwordField" style="width: auto;">Inserisci la tua Password per salvare le modifiche.</label>
                        <input type="password" id="passwordField" name="currentPassword" value="" class="text-field"/>
                </div>
				<p style="margin-top: 10px;width:130px;"><a href="#" class="new-button" onClick="document.change_email_form.submit();"><b>Cambia Email</b><i></i></a></p>
<br>
</form>
            </div>


        </div>
    </div>
    <div class="settings-container-bottom"></div>
    <script type="text/javascript">
        $(document.body).addClassName("js");
        if (window.opener && window.opener.Avatars) {
            $("back-link").href = "/identity/settings";            
            $("back-link").firstChild.nodeValue = "Torna alla gestione Account";
        }
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
