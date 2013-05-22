<?php
require_once('../core.php');
require_once('../includes/session.php');

$query = $input->FilterText($_GET['query']);
$scope = $_GET['scope'];

$sql = '';
switch($scope){
	case 1: $sql = mysql_query("SELECT id,username FROM users WHERE username LIKE '%".$query."%' LIMIT 5"); break;
	case 2: $sql = mysql_query("SELECT id,caption FROM rooms WHERE caption LIKE '%".$query."%' LIMIT 5"); break;
	case 3: $sql = mysql_query("SELECT id,name FROM groups WHERE name LIKE '%".$query."%' LIMIT 5"); break;
}

switch($scope){
	case 1: $type = "habbo"; break;
	case 2: $type = "room"; break;
	case 3: $type = "group"; break;
}
?>
<ul>
	<li>Clicca su un link per inserirlo nel documento</li>
<?php while($row = mysql_fetch_row($sql)){ ?>

    <li><a href="#" class="linktool-result" type="<?php echo $type; ?>" value="<?php echo $input->HoloText($row[0]); ?>" title="<?php echo $input->HoloText($row[1]); ?>"><?php echo $input->HoloText($row[1]); ?></a></li>

<?php } ?>
</ul>