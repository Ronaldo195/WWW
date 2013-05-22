<?php
include('../core.php');
include('../includes/session.php');

$i = 0;
$output = "[";

$error=0;
$getem = mysql_query("SELECT * FROM messenger_friendships WHERE user_one_id = '".$user->row['id']."'") or $error=1;
if($error==1)
	$getem = mysql_query("SELECT * FROM messenger_friendships WHERE sender = '".$user->row['id']."' OR receiver = '".$user->row['id']."'");

while ($row = mysql_fetch_assoc($getem)) {
	$i++;
	$frid = '';
	if($error == 0)
		$frid = $row['user_two_id'];
	else {
		if($row['sender'] == $user->row['id'])
			$frid = $row['receiver'];
		else
			$frid = $row['sender'];
	}
	
	$friendsql = mysql_query("SELECT * FROM users WHERE id = '".$frid."'");
	$friendrow = mysql_fetch_assoc($friendsql);

	$name = $friendrow['username'];
	$id = $friendrow['id'];

	$output = $output."{\"id\":".$id.",\"name\":\"".$name."\"},";
}
$output = substr_replace($output,"",-1);
$output = $output."]";
?>
/*-secure-
<?php echo $output; ?>
 */
