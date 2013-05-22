<?php
$is_maintenance = true;
include("core.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $site['short']; ?></title>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo PATH; ?>web-gallery/static/js/jquery.tweet.js"></script>
	
	<link href="<?php echo PATH; ?>styles/maintenance.css" rel="stylesheet" type="text/css" />
	
</head>
<body>

<div id="container">
	<div id="content">
		<div id="header" class="clearfix">
			<h1><span></span></h1>
		</div>
		<div id="process-content">

<div class="fireman">

<h1>Pausa per Manutenzione!</h1>

<p>
Siamo spiacenti ma al momento non è possibile accedere a <?php echo $site['short']; ?>.<br><br>
Torneremo al più presto.
<p>

</div>

<div class="tweet-container">

<h2>Che cosa sta succedendo?</h2>

<div class="tweet"></div>

</div>

<?php $maint = true; include("templates/footer.php"); ?>
		</div>
	</div>
</div>

<script src="https://ssl.google-analytics.com/urchin.js" type="text/javascript">
</script>


<script type='text/javascript'>
$(document).ready(function(){
  $(".tweet").tweet({
    username: "<?php echo TWITTER_NAME; ?>",
    count: 10
  });
});
</script>

</body>
</html>
