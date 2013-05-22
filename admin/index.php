<?php
$is_maintenance = 1;
include("../core.php");

if(isset($user->row) && isset($_SESSION['adm_key']))
	header("Location: home");

if(isset($_POST['key'])){
	$name = isset($_POST['username']) ? $input->EscapeString($_POST['username']) : '';
	$pass = isset($_POST['password']) ? $input->EscapeString($_POST['password']) : '';
	$key = isset($_POST['key']) ? $input->EscapeString($_POST['key']) : '';
	
	if($key == PANEL_KEY && isset($user->row))
		$_SESSION['adm_key'] = $key;
		
	$user->login($name, $input->HoloHash($pass), "off", false, 'true');
}
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Amministrazione</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
  <center><img src="<?php echo PATH; ?>web-gallery/v2/images/habbo.png"></center>
  <br><br>
    <div class="login">
      <h1>Accesso all'amministrazione</h1>
      <form method="post" action="">
		<p><?php echo $user->login_error; ?></p>
        <p><input type="text" name="username" value="" placeholder="Username"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>
        <p><input type="text" name="key" value="" placeholder="Codice Segreto"></p>
        <p class="submit"><input type="submit" name="commit" value="Accedi"></p>
      </form>
    </div>
  </section>
</body>
</html>
