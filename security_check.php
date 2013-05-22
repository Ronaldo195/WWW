<?php
include('core.php');

@session_start();

if(isset($user)){
$username = $input->FilterText($user->account['email']);
$password = $input->FilterText($user->account['password']);

$sql = mysql_query("SELECT * FROM accounts WHERE email = '".$username."' AND password = '".$password."' LIMIT 1") or die(mysql_error());
$row = mysql_fetch_assoc($sql);

	if($row['password'] != $password){
            session_destroy();
	}
}

?>

<html>
<head>
  <title>Reindizionamento...</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <style type="text/css">body { background-color: #e3e3db; text-align: center; font: 11px Verdana, Arial, Helvetica, sans-serif; } a { color: #fc6204; }</style>
</head>
<body>
<?php if(isset($_GET['me']) && $input->FilterText($_GET['me'])){ ?>
<script type="text/javascript">window.location.replace('me');</script><noscript><meta http-equiv="Refresh" content="0;URL=me"></noscript>
<?php } else { ?>
<script type="text/javascript">window.location.replace('me');</script><noscript><meta http-equiv="Refresh" content="0;URL=me"></noscript>
<?php } ?>
<p class="btn">Se non reindirizza automaticamente <a href="me" id="manual_redirect_link">Clicca QUI</a></p>

</body>
</html>