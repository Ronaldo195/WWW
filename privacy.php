<?php
include('core.php');
include('templates/login/subheader.php');
include('templates/login/header.php');
?>

<div id="process-content">
<div id="terms" class="box-content">
	<div class="tos-header"><b>Tutela della privacy</b></div>
	<div class="tos-item"><br><?php echo "Qui su <b>".$site['name']."</b> (Noto anche come <b>".$site['short']."</b>) abbiamo a cuore la vostra privacy. Tutte le vostre credenziali e le altre informazioni fornite durante la registrazione saranno memorizzate in un database MySQL sicuro a cui solo alcune persone autorizzate hanno accesso.<br>".$site['name']." non potr&agrave <b><i>mai</i></b> condividere le tue informazioni con terze parti senza il tuo esplicito consenso nel farlo."; ?></div>
</div>

<?php

include('templates/footer.php');

?>
