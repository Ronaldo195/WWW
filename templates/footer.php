<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
<?php if(isset($home) && $home == 1){ ?>
<div id="footer"><a href="<?php echo PATH; ?>index" target="_self">Homepage</a> / <a href="<?php echo PATH; ?>disclaimer" target="_self">Termini Di Servizio</a> / <a href="<?php echo PATH; ?>privacy" target="_self">Privacy Policy</a></div>
<div id="copyright">&copy; <?php echo $site['name']; ?>. Questo sito non &egrave; n&egrave; gestito n&egrave; affiliato dalla Sulake Corporation Oy.</div>
<?php }elseif(isset($maint) && $maint == true){ ?>
<div id="footer">
<div class="followbtn" style="text-align:right">
<a href="https://twitter.com/<?php echo TWITTER_NAME; ?>" class="twitter-follow-button" data-show-count="false" data-lang="it" data-size="large">Segui @<?php echo TWITTER_NAME; ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
<p class="copyright">&copy; <?php echo $site['name']; ?>. Questo sito non &egrave; n&egrave; gestito n&egrave; affiliato dalla Sulake Corporation Oy.</p>
</div>
<?php }else if(isset($reset) && $reset == 1){ ?>
<div id="footer">
<p class="footer-links"><a href="<?php echo PATH; ?>index" target="_self">Homepage</a> | <a href="<?php echo PATH; ?>disclaimer" target="_self">Termini Di Servizio</a> | <a href="<?php echo PATH; ?>privacy" target="_self">Privacy Policy</a></p>
<p class="copyright">&copy; <?php echo $site['name']; ?>. Questo sito non &egrave; n&egrave; gestito n&egrave; affiliato dalla Sulake Corporation Oy.</p>
</div>
<?php }else{ ?>
<br>
<div id="footer">
<p class="copyright"><a href="<?php echo PATH; ?>index" target="_self">Homepage</a> | <a href="<?php echo PATH; ?>disclaimer" target="_self">Termini Di Servizio</a> | <a href="<?php echo PATH; ?>privacy" target="_self">Privacy Policy</a></p>
<p class="copyright"><font color="black">&copy; <?php echo $site['name']; ?>. Questo sito non &egrave; n&egrave; gestito n&egrave; affiliato dalla Sulake Corporation Oy.</p><br>
</div>
<?php } ?>
<script type="text/javascript">
HabboView.run();
</script>
<?php echo $site['analytics']; ?>
</body>
</html>