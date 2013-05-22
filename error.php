<?php
$allow_guests = true;

@include('./core.php');
@include('./includes/session.php');

$pageid = "profile";
$pagename = "Non ho trovato la pagina che cerchi!";
include('templates/subheader.php');
include('templates/header.php');

?>

<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix red ">

							<h2 class="title">Non ho trovato la pagina che cerchi!
							</h2>
						<div id="notfound-content" class="box-content">
    <p class="error-text">Mi dispiace ma non riesco a trovare la pagina che hai richiesto.</p> <img id="error-image" src="<?php echo PATH; ?>web-gallery/v2/images/error.gif" />
    <p class="error-text">Prova a digitare di nuovo l'URL. Se ti ritrovi qui, premi il pulsante 'Indietro' per tornare da dove sei venuto.</p>
</div>


					</div>
				</div>
				

</div>

<?php
include('templates/footer.php');
?>