<?php
@session_start();
setcookie("remember", "", time()-60*60*24*100, "/");
setcookie("rusername", "", time()-60*60*24*100, "/");
setcookie("rpassword", "", time()-60*60*24*100, "/");

if(isset($login_error)){
	include('templates/login/subheader.php');
	include('templates/login/header.php');
?>

<title><?php echo isset($site['name']) ? $site['name'] : ''; ?>: Sei fuori!</title>

<div id="process-content">
<div class="action-error flash-message">
<div class="rounded">
		<b><?php echo $login_error; ?></b>
</div>
</div>

<div style="text-align: center">

	<div style="width:100px; margin: 10px auto"><a href="<?php echo PATH; ?>" id="logout-ok" class="new-button fill"><b>OK</b><i></i></a></div>

<div id="column1" class="column">              
</div>
<div id="column2" class="column">
</div>

</div>

<?php
}else{

include("core.php");
$input->MUS('signout', $user->row['id']);
@session_destroy();

if(isset($_COOKIE['remember']) && $_COOKIE['remember'] == "remember"){
	setcookie("remember", "", time()-60*60*24*100, "/");
	setcookie("rusername", "", time()-60*60*24*100, "/");
	setcookie("rpassword", "", time()-60*60*24*100, "/");
}

include('templates/login/subheader.php');
include('templates/login/header.php');

?>

<title><?php echo $site['name']; ?>: Sei fuori!</title>

<div id="process-content">
	        	<div class="action-confirmation flash-message">
	<div class="rounded">
		<b>Sei uscito da <?php echo $site['short']; ?>!</b>
	</div>
</div>

<div style="text-align: center">
	
	<div style="width:100px; margin: 10px auto"><a href="<?php echo PATH; ?>" id="logout-ok" class="new-button fill"><b>OK</b><i></i></a></div>

<div id="column1" class="column">              
</div>
<div id="column2" class="column">
</div>

</div>

<?php
}
@session_destroy();
include('templates/footer.php');
?>
