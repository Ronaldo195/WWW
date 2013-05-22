<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright © 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================+
|| # Parts by Yifan Lu
|| # www.obbahhotel.com
|+===================================================*/

include('../core.php');



$allow_guests = false;



$id = $input->FilterText($_POST['accountId']);
$sql = mysql_query("SELECT username FROM users WHERE id = '".$id."' LIMIT 1") or die(mysql_error());
$row = mysql_fetch_assoc($sql);
$name = $input->FilterText($row['username']); ?>
<p>
Vuoi aggiungere questa persona <?php echo $name; ?> ai tuoi amici?
</p>

<p>
<a href="#" class="new-button done"><b>Cancella</b><i></i></a>
<a href="#" class="new-button add-continue"><b>Continua</b><i></i></a></p>