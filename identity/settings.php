<?php
include("../core.php");

/*if(isset($_SESSION['provider']))
	header("Location: avatars");*/
	
include("header.php");
?>
<div id="container">

    <div class="settings-container clearfix">
        <h1>Gestione Account</h1>
        <div id="back-link">
        <a href="<?php echo PATH; ?>identity/avatars">I miei personaggi <?php echo $site['short']; ?></a> &raquo; Gestione Account      
        </div>
        
		
        <div style="padding: 0 10px">
		<?php
		if(isset($_GET['added']))
			echo '<p class="confirmation" style="margin-top:10px; text-align: center; font-weight: bold;">Il tuo Account '.$site['short'].' &egrave; stato creato con successo.</p>';
		?>
		
        <h3>Email:</h3>
        <div class="opt-email">
			<?php
			if($user->account['provider'] != 'id')
				echo '<span>I dati sul tuo indirizzo email non sono disponibili in questo momento.</span>';
			else
				echo '<span>'.$user->account['email'].'</span><a id="manage-email" class="new-button " onclick="" href="'.PATH.'identity/email"><b>Cambia indirizzo email</b><i></i></a>';
			?>
		</div>
        <br clear="all"/>
     
		<h3>Accesso effettuato come:</h3>
        <p>Lista dei servizi Web che stai utilizzando</p>
        <div class="opt-auth-providers clearfix settings-auth" style="float: none; width: auto">  
			<?php
			if($user->account['provider'] == 'Google')
				$image = 'web-gallery/v2/images/rpx/icon_google_big.png';
			else if($user->account['provider'] == 'Facebook')
				$image = 'web-gallery/v2/images/rpx/icon_facebook_connect_big.png';
			
			if(isset($image)){
				echo '
                <p>
                	<img src="'.PATH.$image.'" style="vertical-align: middle">
                	'.$user->account['email'].'
                </p>
				';
			}
				if($user->account['password'] != ''){ ?>
                <p>
                	<img src="<?php echo PATH; ?>web-gallery/v2/images/rpx/icon_habbo_big.png" style="vertical-align: middle" title="id"/>
                	<?php echo $user->account['email']; ?>
                </p>
				<?php } ?>
        <p>
        </p>
        </div>

        <h3>Password:</h3>
        <div class="opt-password">
		<?php
		if($user->account['password'] == '')
			echo '<span><a href="'.PATH.'identity/add_habbo_id">Imposta un Account '.$site['short'].'</a></span>';
		else
            echo '<span>************</span><a id="manage-password" class="new-button" href="'.PATH.'identity/password"><b>Cambia</b><i></i></a>';
		?>
        </div>
        <div class="opt-email">

        </div>
        </div>
    </div>
    <div class="settings-container-bottom">
  </div>
    <script type="text/javascript">
        document.observe("dom:loaded", function() {
            $(document.body).addClassName("js");
        });

        if (window.opener && window.opener.Avatars) {
            $("back-link").down("a").update("Chiudi Impostazioni");
            if (!!$("manage-password")) {
                $("manage-password").href = $("manage-password").href + "?fromClient=true";
            }
            Event.observe($("back-link"), "click", function(e) {
                Event.stop(e);
                window.opener.focus();
                window.close();
            });
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
