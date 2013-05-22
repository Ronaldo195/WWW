<?php
include("../core.php");
$pageid = "Dashboard";

$page['id'] = 'Accesso Negato';
$page['rank'] = 1;

include("header.php");
?>

	<section id="main" class="column">
		<article class="module width_full">
			<header><h3>Accesso Negato</h3></header>
				<div class="module_content">
					<center>
						<img src="images/locked.png"><br>
						<h3>Attenzione, non ti &egrave; consentito visualizzare questa pagina.
						<br>
						Clicca <a href="<?php echo PATH; ?>admin/home">qui</a> per tornare indietro.</h3>
					</center>
				</div>
		</article><!-- end of styles article -->
		<div class="spacer"></div>
	</section>


</body>

</html>