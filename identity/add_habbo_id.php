<?php
include("../core.php");

if(!$_SESSION['provider'])
	header("Location: avatars");

if(isset($_POST['next'])){
	$pass = isset($_POST['Password']) ? $input->EscapeString($_POST['Password']) : '';
	$pass2 = isset($_POST['retypedPassword']) ? $input->EscapeString($_POST['retypedPassword']) : '';
	
	if($pass == '' || $pass2 == '')
		$error = "Inserisci una Password.";
	else if(strlen($pass) < 6 || strlen($pass) > 23)
		$error = "La Password deve comprendere tra i 6 e i 23 caratteri.";
	else if($pass != $pass2)
		$error = "Le Password non corrispondono.";
		
	if(!isset($error)){
		mysql_query("UPDATE accounts SET password = '".$input->HoloHash($pass)."' WHERE id = '".$user->account['id']."'");
		$user->Refresh($user->row['username']);
		
		header("location: settings?added=1");
	}
}

include("header.php");
?>

<div id="container">

    <div class="settings-container settings-auth clearfix">
        <h1>Aggiungi un Account <?php echo $site['short']; ?></h1>
        <div id="back-link">
        <a href="<?php echo PATH; ?>identity/avatars">I miei personaggi</a> &raquo; <a href="<?php echo PATH; ?>identity/settings"> Gestione Account</a> &raquo; Aggiungi un Account
        </div>
        <div style="padding: 0 10px">
		<?php
		if(isset($error)){
		echo '
		<div class="error-messages-holder">
            <h3>Risolvi il seguente problema e completa nuovamente il campo richiesto.</h3>
            <ul>
                <li><p class="error-message">'.$error.'</p></li>
            </ul>
        </div>
		';
		}
		?>
        	<h3>Aggiungi un Account</h3>
        	<p>Scegli un indirizzo email e una Password da usare per accedere a <?php echo $site['short']; ?></p>
			<form action="" method="post" id="embedded-login">
			    <input type="hidden" name="next" value="1">
			    <div class="field">
			        <label for="habboid-email" class="login-text">Indirizzo email</label>
			        <input tabindex="1" type="text" class="text-field" name="habboIdEmail" id="habboid-email" value="<?php echo $user->account['email']; ?>" maxlength="32" class="text-field" autocomplete="off" readOnly="true" disabled="disabled">
			    </div>
			    <div class="field <?php echo isset($error) ? 'state-error' : ''; ?>">
			        <label for="habboid-password" class="login-text">Password</label>
			        <input tabindex="2" type="password" class="password-field" name="Password" id="habboid-password" maxlength="32" class="password-field"/>
			    </div>
			    <div class="field <?php echo isset($error) ? 'state-error' : ''; ?>">
			        <label for="habboid-retyped-password" class="login-text">Riscrivi Password</label>
			        <input tabindex="2" type="password" class="password-field" name="retypedPassword" id="habboid-retyped-password" maxlength="32" class="password-field"/>
			    </div>
			    
			    <div style="overflow: hidden"><a href="#" class="new-button left" onclick="$(this).up('form').submit(); return false;"><b>Aggiungi un Account <?php echo $site['short']; ?></b><i></i></a></div>
			</form>
        	
        </div>
    </div>
    <div class="settings-container-bottom"></div>
    <script type="text/javascript">
    	$(document.body).addClassName("js");
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
