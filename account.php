<?php
$allow_guests = false;

require_once('core.php');
require_once('includes/session.php');

$pagename = "Impostazioni account";
$body_id = "profile";
$pageid = "2";

if(isset($_GET['tab'])){
	$tab = $_GET['tab'];
	$tab = $tab == 6 ? 2 : $tab;
} else {
	$tab = 1;
}

if($tab == 1 && isset($_POST['next'])){
	$visibility = isset($_POST['visibility']) ? $input->EscapeString($_POST['visibility']) : 1;
	$online = isset($_POST['showOnlineStatus']) ? $input->EscapeString($_POST['showOnlineStatus']) : 1;
	$motto = isset($_POST['motto']) ? $input->EscapeString($_POST['motto']) : 1;
	
	mysql_query("UPDATE users SET motto = '".$motto."' WHERE id = ".$user->row['id']);
	mysql_query("UPDATE user_info SET online_show = '".$online."',home_show = '".$visibility."' WHERE user_id = ".$user->row['id']);
	$user->Refresh($user->row['username']);
	$input->MUS("updatemotto", $user->row['id']);
	$ok = "Aggiornamento avvenuto con successo!";
}

include('templates/subheader.php');
include('templates/header.php');

?>

<div id="container">
<div id="content">
<div class="content">
<div class="habblet-container" style="float:left; width:210px;">
<div class="cbb settings">

<h2 class="title">Impostazioni account</h2>
<div class="box-content">
        <div id="settingsNavigation">
            <ul>
				<?php if($tab == 1){ echo '<li class="selected">Stato e preferenze</li>'; }else{ echo '<li><a href="'.PATH.'profile?tab=1">Stato e preferenze</a></li>'; } ?>
				<?php if($tab == 3){ echo '<li class="selected">Cambia email</li>'; }else{ echo '<li><a href="'.PATH.'profile?tab=3">Cambia email</a></li>'; } ?>
				<?php if($tab == 4){ echo '<li class="selected">Password</li>'; }else{ echo '<li><a href="'.PATH.'profile?tab=4">Password</a></li>'; } ?>
				<?php if($tab == 2){ echo '<li class="selected">Lista amici</li>'; }else{ echo '<li><a href="'.PATH.'profile/friendsmanagement?tab=6">Lista amici</a></li>'; } ?>
				<li><a href="<?PHP echo PATH; ?>identity/settings">Gestione account</a></li>
            </ul>
        </div>
</div>
</div>
</div>

<?php if($tab == 1){ ?>
<div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Cambia il tuo profilo</h2>
            <div class="box-content">
            
<?php
if(isset($ok)){
	echo '<div class="rounded-green rounded">'.$ok.'<br></div>';
}
?>

<form action="" method="post" id="profileForm">
<input type="hidden" name="next" value=" ">
<h3>Il tuo Stato</h3>

<p>
Il tuo Stato &egrave; una frase che gli altri <?php echo $site['short']; ?> vedono nella tua <?php echo $site['short']; ?> Home Page e cliccando il tuo <?php echo $site['short']; ?> quando sei in Hotel.
</p>

<p>
<label>Motto:
<input type="text" name="motto" size="32" maxlength="32" value="<?php echo $user->row['motto']; ?>" id="avatarmotto" /></label>
</p>

<h3>La tua Pagina</h3>

<p>
Chi pu&ograve; vedere la tua <?php echo $site['short']; ?> Home Page:<br />
<label><input type="radio" name="visibility" value="1" <?php echo $input->GetUserInfo($user->row['id'], 'home_show') == 1 ? 'checked="checked"' : ''; ?> />Tutti</label>
<label><input type="radio" name="visibility" value="0" <?php echo $input->GetUserInfo($user->row['id'], 'home_show') == 0 ? 'checked="checked"' : ''; ?> />Nessuno</label>
</p>

<!--<h3>Richieste di Amicizia</h3>
<p>
<label><input type="checkbox" name="friendRequestsAllowed" checked="checked" value="true"/>
Richieste di Amicizia abilitate</label>
</p>-->

<h3>Status</h3>
<p>
Seleziona chi pu&ograve; vedere se sei online:<br />
<label><input type="radio" name="showOnlineStatus" value="0" <?php echo $input->GetUserInfo($user->row['id'], 'online_show') == 0 ? 'checked="checked"' : ''; ?> />Nessuno</label>
<label><input type="radio" name="showOnlineStatus" value="1"checked="checked" <?php echo $input->GetUserInfo($user->row['id'], 'online_show') == 1 ? 'checked="checked"' : ''; ?> />Tutti</label>
</p>

<div class="settings-buttons">
<a href="#" class="new-button" style="display: none" id="profileForm-submit"><b>Salva le modifiche</b><i></i></a>
<noscript><input type="submit" value="Salva le modifiche" name="save" class="submit" /></noscript>
</div>

</form>

<script type="text/javascript">
$("profileForm-submit").observe("click", function(e) { e.stop(); $("profileForm").submit(); });
$("profileForm-submit").show();
</script>

</div>
</div>
</div>
<?php }elseif($tab == 2){ ?>
  <div id="friend-management" class="habblet-container">
    <div class="cbb clearfix settings">
      <h2 class="title">Gestione Lista di Amici</h2>
      <div id="friend-management-container" class="box-content">
        <div id="category-view" class="clearfix">
          <div id="search-view">
            Cerca un Amico qui sotto
            <div id="friend-search" class="friendlist-search">
		      <input type="text" maxlength="32" id="friend_query" class="friend-search-query" />
		      <a class="friendlist-search new-button search-icon" id="friend-search-button"><b><span></span></b><i></i></a>
            </div>
          </div>
          <!--<div id="category-list">
<div id="friends-category-title">
    Categorie di Amici
</div>

<div class="category-default category-item selected-category" id="category-item-0">Amici</div>

    <input type="text" maxlength="32" id="category-name" class="create-category" /><div id="add-category-button" class="friendmanagement-small-icons add-category-item add-category"></div>
          </div>-->
        </div>
		<?php $cor = 1; require_once "habblet/ajax_friendmanagement.php"; ?>
		</div>
    </div>
  </div>
</div>
<script type="text/javascript"> 
  L10N.put("friendmanagement.tooltip.deletefriends", "Vuoi davvero eliminare i contatti selezionati?\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a class=\"friends-delete-button\" id=\"delete-friends-button\"\>Elimina</a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"cancel-delete-friends\"\>Annulla</a\>\n</div\>\n\n");
  L10N.put("friendmanagement.tooltip.deletefriend", "Sei sicuro di voler rimuovere questo amico?\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a id=\"delete-friend-%friend_id%\"\>Accetta</a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"remove-friend-can-%friend_id%\"\>Annulla</a\>\n</div\>");
  L10N.put("friendmanagement.tooltip.deletecategory", "Sei sicuro di voler cancellare questa categoria?\n<div class=\"friendmanagement-small-icons friendmanagement-save friendmanagement-tip-delete\"\>\n    <a class=\"delete-category-button\" id=\"delete-category-%category_id%\"\>Accetta</a\>\n</div\>\n<div class=\"friendmanagement-small-icons friendmanagement-remove friendmanagement-tip-cancel\"\>\n    <a id=\"cancel-cat-delete-%category_id%\"\>Annulla</a\>\n</div\>");
  new FriendManagement({ currentCategoryId: 0, pageListLimit: 30, pageNumber: 1});
</script> 
</div>
    </div>

<?php }else if($tab == 3){ ?>
<div class="habblet-container" style="float:left; width: 560px;">
<div class="cbb clearfix settings">

<h2 class="title">Cambia email</h2>
<div class="box-content">
<?php
if(isset($_SESSION['provider']) || $user->account['provider'] != "id")
	echo 'Puoi cambiare l\'Email solo effettuando il login con il tuo Account '.$site['short'];
else { ?>
Sei entrato in Habbo utilizzando il tuo Account Habbo. Per cambiare il tuo indirizzo email, entra nella pagina delle Impostazioni Account. Clicca sul link sottostante per accedere alla pagina dedicata al cambio Password dell'Account Habbo.<br><br>
<a href="<?php echo PATH; ?>identity/email">Vai alla pagina dedicata al cambio dell'indirizzo email del tuo Account Habbo.</a>
<?php } ?>
<div id="settings-editor">

</div>
</div>

</div>
</div>
</div>
</div>
    </div>

<?php } else if($tab == 4){ ?>
    <div class="habblet-container " style="float:left; width: 560px;">
        <div class="cbb clearfix settings">

            <h2 class="title">Cambia la tua password</h2>
            <div class="box-content">
				<?php
				if(isset($_SESSION['provider']))
					echo 'Puoi cambiare la Password solo effettuando il login con il tuo Account '.$site['short'];
				else { ?>
				Sei entrato in <?php echo $site['short']; ?> utilizzando il tuo Account <?php echo $site['short']; ?>. Per cambiare la tua Password, entra nella pagina delle Impostazioni Account. Clicca sul link sottostante per accedere alla pagina dedicata al cambio Password dell'Account <?php echo $site['short']; ?>.<br><br>
				<a href="<?php echo PATH; ?>identity/password">Vai alla pagina dedicata al cambio Password del tuo Account <?php echo $site['short']; ?>.</a>
			<?php } ?>
			</div>
</div>
</div>
</div>
</div>
<?php } else { ?>
<b>ID Non Valido.</b>
<?php } ?>
<div id="column3" class="column">
<?php include("templates/ads.php"); ?>
</div>
<?php

include('templates/footer.php');

?>