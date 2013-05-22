<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright © 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include('../core.php');

if(!$_SESSION['user']){ exit; }

if($user->row['rank'] < 6){ exit; }

?>

<p>Si Sta Per Eliminare un Argomento Confermi?</p>

<p>
<a href="#" class="new-button" id="discussion-action-cancel"><b>Annulla</b><i></i></a>
<a href="#" class="new-button" id="discussion-action-ok"><b>Procedi</b><i></i></a>
</p>

<div class="clear"></div>