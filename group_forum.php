<?php
$allow_guests = false;

include('core.php');
include('includes/session.php');

$pagename = "Discussioni";
$pageid = "forum";
$body_id = "viewmode";

$member_rank = 0;
$my_membership['is_current'] = 0;

if(isset($_POST['searchString']) && $input->FilterText($_POST['searchString'])){
	$searchString = $input->FilterText($_POST['searchString']);
	$check = mysql_query("SELECT id FROM groups WHERE name LIKE '".$searchString."' LIMIT 1") or die(mysql_error());
	$found = mysql_num_rows($check);
	if($found > 0){
		$tmp = mysql_fetch_assoc($check);
		header("Location: ".PATH."groups/".$tmp['id']);
		exit;
	}
}


if($input->FilterText($_GET['id']) && is_numeric($_GET['id'])){

	$check = mysql_query("SELECT * FROM groups WHERE id = '".$_GET['id']."' LIMIT 1");
	$exists = mysql_num_rows($check);

	if($exists > 0){

		$groupid = $input->FilterText($_GET['id']);

		$error = false;
		$groupdata = mysql_fetch_assoc($check);
		
		if(!isset($groupdata['name'])){
			if($groupdata['Typee'] == 0)
				$groupdata['locked'] = "open";
			else if($groupdata['Typee'] == 1)
				$groupdata['locked'] = "locked";
			else if($groupdata['Typee'] == 2)
				$groupdata['locked'] = "closed";
			
			$groupdata['name'] = $groupdata['Name'];
			$groupdata['ownerid'] = $groupdata['OwnerId'];
		}
		
		$pagename = $groupdata['name'];
		$ownerid = $input->FilterText($groupdata['ownerid']);

		$members = $input->mysql_evaluate("SELECT COUNT(*) FROM ".$site['memberships']." WHERE groupid = '".$groupid."'");

		$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid = '".$groupid."' LIMIT 1");
		$is_member = mysql_num_rows($check);

		if($is_member > 0 && $logged_in){

			$is_member = true;
			$my_membership = mysql_fetch_assoc($check);
			$member_rank = $my_membership['member_rank'];

		} else {

			$is_member = false;

		}

	} else {

		$error = true;

	}

} else {

	$error = true;

}

if($error != true){
include('templates/subheader.php');
include('templates/header.php');
mysql_query("UPDATE groups SET views = views+'1' WHERE id='".$groupid."' LIMIT 1");

$viewtools = "	<div class=\"myhabbo-view-tools\">\n";

$page = isset($_GET['page']) ? $input->FilterText($_GET['page']) : 0;

$threads = $input->mysql_evaluate("SELECT COUNT(*) FROM cms_forum_threads WHERE forumid='".$groupid."'");
$pages = ceil(($threads + 0) / 10);

if($page > $pages || $page < 1){
	$page = 1;
}

$key = 0;

mysql_query("UPDATE groups SET views = views+'1' WHERE id='".$groupid."' LIMIT 1");

?>

<script type="text/javascript">
var habboReqPaths = "<?php echo PATH; ?>discussions/<?php echo $groupid; ?>";
</script>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="mypage-wrapper" class="cbb blue">
<div class="box-tabs-container box-tabs-left clearfix">
	<?php $edit_mode = isset($edit_mode) ? $edit_mode : false; if($member_rank > 1 && !$edit_mode){ ?><a href="<?php echo PATH; ?>groups/<?php echo $groupid; ?>&do=edit" class="new-button dark-button edit-icon" style="float:left"><b><span></span>Modifica</b><i></i></a><?php } ?>
    <h2 class="page-owner">
<?php echo $input->HoloText($groupdata['name']); ?>&nbsp;
<?php if($groupdata['locked'] == "closed"){ ?><img src='<?php echo PATH; ?>web-gallery/images/status_closed_big.gif' alt='Gruppo Chiuso' title='Gruppo Chiuso'><?php } ?>
<?php if($groupdata['locked'] == "locked"){ ?><img src='<?php echo PATH; ?>web-gallery/images/status_exclusive_big.gif' alt='Gruppo Moderatori' title='Gruppo Moderatori'><?php } ?></h2>
</h2>
    <ul class="box-tabs">
        <li><a href="<?php echo PATH; ?>groups/<?php echo $groupid; ?>">Home Gruppo</a><span class="tab-spacer"></span></li>
        <li class="selected"><a href="<?php echo PATH; ?>discussions/<?php echo $groupid; ?>">Forum Discussione</a><span class="tab-spacer"></span></li>
<?php $viewtools = "	<div class=\"myhabbo-view-tools\">\n";

if($logged_in && !$is_member && $groupdata['locked'] != "closed"){ $viewtools = $viewtools . "<a href=\"joingroup.php?groupId=".$groupid."\" id=\"join-group-button\">"; if($groupdata['locked'] == "open"){ $viewtools = $viewtools . "Entra nel gruppo"; } else { $viewtools = $viewtools . "Richiedi Membro"; } $viewtools = $viewtools . "</a>"; }
if($logged_in && $my_membership['is_current'] != "1" && $is_member){ $viewtools = $viewtools . "<a href=\"#\" id=\"select-favorite-button\">Preferito</a>\n"; }
if($logged_in && $my_membership['is_current'] == "1" && $is_member){ $viewtools = $viewtools . "<a href=\"#\" id=\"deselect-favorite-button\">Rimuovi Preferito</a>"; }
if($logged_in && $is_member && $user->row['id'] !== $ownerid){ $viewtools = $viewtools . "<a href=\"leavegroup.php?groupId=".$groupid."\" id=\"leave-group-button\">Esci Dal Gruppo</a>\n"; }

$viewtools = $viewtools . "	</div>\n"; ?>
    </ul>
</div>	
	<div id="mypage-content">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content-1col">
            <tr>
                <td valign="top" style="width: 750px;" class="habboPage-col rightmost">
                    <div id="discussionbox">
					<?php
					$sql = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid = '".$user->row['id']."' AND groupid='".$_GET['id']."'");
					$member = mysql_fetch_assoc($sql);
					if(mysql_num_rows($sql) > 0) { ?>
<div id="group-topiclist-container">
<div class="topiclist-header clearfix">
		<?php
		$sql = mysql_query("SELECT * FROM groups WHERE id='".$_GET['id']."' LIMIT 1");
		$row = mysql_fetch_assoc($sql);
		
		if($row['topics'] == 0) {
			echo '<input type="hidden" id="email-verfication-ok" value="1"/>';
			if($logged_in){
				echo '<a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuova discussione</b><i></i></a>';
			} else { 
				echo "Devi essere registrato per rispondere o inserire nuovi messaggi.";
			}
		} elseif($row['topics'] == 1) {
			$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$_GET['id']."' LIMIT 1");
		
			if(mysql_num_rows($check) > 0) { 
				echo '<input type="hidden" id="email-verfication-ok" value="1"/>';
				if($logged_in){ 
					echo '<a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuova discussione</b><i></i></a>';
				} else { 
					echo "Devi essere registrato per rispondere o inserire nuovi messaggi..";
				}
			}
		} elseif($row['topics'] == 2) {
			$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$_GET['id']."' AND member_rank = 3 LIMIT 1");
			if(mysql_num_rows($check) > 0) {
				echo '<input type="hidden" id="email-verfication-ok" value="1"/>';
				if($logged_in){
					echo '<a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuova discussione</b><i></i></a>';
				} else { 
					echo "Devi essere registrato per rispondere o inserire nuovi messaggi.";
				}
			}
		}
?>
		
    <div class="page-num-list">
    Vedi Pagine:
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"".PATH."discussions/".$groupid."&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	} 
?>
    </div>
</div>
<table class="group-topiclist" border="0" cellpadding="0" cellspacing="0" id="group-topiclist-list">
	<tr class="topiclist-columncaption">
		<td class="topiclist-columncaption-topic">Topic</td>
		<td class="topiclist-columncaption-lastpost">Ultimo Post</td>
		<td class="topiclist-columncaption-replies">Risposte</td>
		<td class="topiclist-columncaption-views">Visto</td>
	</tr>
	
<?php

if($threads == 0){
echo "	<tr class=\"topiclist-row-1\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			Nessun topic da visualizzare.
		</td>
		</tr>";
}

$sql = mysql_query("SELECT * FROM cms_forum_threads WHERE type > 2 AND forumid='".$groupid."' ORDER BY unix DESC") or die(mysql_error());
$stickies = mysql_num_rows($sql);

$query_min = ($page * 10) - 10;
$query_max = 10;

$query_max = $query_max - $stickies;
$query_min = $query_min - $stickies;

if($query_min < 0){ // Page 1
$query_min = 0;
}

while($row = mysql_fetch_assoc($sql)){

	$key++;

	if($input->IsEven($key)){
		$x = "odd";
	} else {
		$x = "even";
	}

	echo "<tr class=\"topiclist-row-" . $x . "\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			<div class=\"topiclist-row-content\">
			<a class=\"topiclist-link icon icon-sticky\" href=\"".PATH."viewthread?thread=".$row['id']."\">".$input->HoloText($row['title'],false,false,true)."</a>";

			if($row['type'] == 4){
			echo "&nbsp;<span class=\"topiclist-row-topicsticky\"><img src=\"".PATH."web-gallery/images/groups/status_closed.gif\" title=\"Chiudi  Thread\" alt=\"Chiudi Thread\"></span>";
			}

			echo "&nbsp;(page ";

			$thread_pages = ceil(($row['posts'] + 1) / 10);

			for ($i = 1; $i <= $thread_pages; $i++){
				echo "<a href=\"".PATH."viewthread?thread=" . $row['id'] . "&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
			} 

            echo ")
			<br />
			<span><a class=\"topiclist-row-openername\" href=\"".PATH."home/".$row['author'] . "\">" . $row['author'] . "</a></span>";

			$date_bits = explode(" ", $row['date']);
			$date = $date_bits[0];
			$time = $date_bits[1];
			
				echo "&nbsp;<span class=\"latestpost\">" . $date . "</span>
			<span class=\"latestpost\">(" . $time . ")</span>
			</div>
		</td>
		<td class=\"topiclist-lastpost\" valign=\"top\">
		    <a class=\"lastpost-page-link\" href=\"".PATH."viewthread?thread=" . $row['id'] . "&sp=JumpToLast\">";

			$date_bits = explode(" ", $row['lastpost_date']);
			$date = $date_bits[0];
			$time = $date_bits[1];

				echo "<span class=\"lastpost\">" . $date . "</span>
            <span class=\"lastpost\">(" . $time . ")</span></a><br />
			<span class=\"topiclist-row-writtenby\">by:</span> <a class=\"topiclist-row-openername\" href=\"".PATH."home/" . $row['lastpost_author'] . "\">" . $row['lastpost_author'] . "</a>&nbsp;
		</td>
 		<td class=\"topiclist-replies\" valign=\"top\">" . $row['posts'] . "</td>
 		<td class=\"topiclist-views\" valign=\"top\">" . $row['views'] . "</td>
	</tr>";

}

$sql = mysql_query("SELECT * FROM cms_forum_threads WHERE type < 3 AND forumid='".$groupid."' ORDER BY unix DESC LIMIT ".$query_min.", ".$query_max."") or die(mysql_error());

while($row = mysql_fetch_assoc($sql)){

	$key++;

	if($input->IsEven($key)){
		$x = "odd";
	} else {
		$x = "even";
	}

	echo "<tr class=\"topiclist-row-" . $x . "\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			<div class=\"topiclist-row-content\">
			<a class=\"topiclist-link \" href=\"".PATH."viewthread?thread=".$row['id']."\">".$input->HoloText($row['title'],false,false,true)."</a>";

			if($row['type'] == 2){
			echo "&nbsp;<span class=\"topiclist-row-topicsticky\"><img src=\"".PATH."web-gallery/images/groups/status_closed.gif\" title=\"Chiudi Thread\" alt=\"Chiudi  Thread\"></span>";
			}

			echo "&nbsp;(page ";

			$thread_pages = ceil(($row['posts'] + 1) / 10);

			for ($i = 1; $i <= $thread_pages; $i++){
				echo "<a href=\"".PATH."viewthread?thread=" . $row['id'] . "&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
			} 

            echo ")
			<br />
			<span><a class=\"topiclist-row-openername\" href=\"".PATH."home/" . $row['author'] . "\">" . $row['author'] . "</a></span>";

			$date_bits = explode(" ", $row['date']);
			$date = $date_bits[0];
			$time = $date_bits[1];
			
				echo "&nbsp;<span class=\"latestpost\">" . $date . "</span>
			<span class=\"latestpost\">(" . $time . ")</span>
			</div>
		</td>
		<td class=\"topiclist-lastpost\" valign=\"top\">
		    <a class=\"lastpost-page-link\" href=\"".PATH."viewthread?thread=" . $row['id'] . "&sp=JumpToLast\">";

			$date_bits = explode(" ", $row['lastpost_date']);
			$date = $date_bits[0];
			$time = $date_bits[1];

				echo "<span class=\"lastpost\">" . $date . "</span>
            <span class=\"lastpost\">(" . $time . ")</span></a><br />
			<span class=\"topiclist-row-writtenby\">by:</span> <a class=\"topiclist-row-openername\" href=\"".PATH."home/" . $row['lastpost_author'] . "\">" . $row['lastpost_author'] . "</a>&nbsp;
		</td>
 		<td class=\"topiclist-replies\" valign=\"top\">" . $row['posts'] . "</td>
 		<td class=\"topiclist-views\" valign=\"top\">" . $row['views'] . "</td>
	</tr>";

}

?>	

	</table>
<div class="topiclist-footer clearfix">
		<?php
		$sql = mysql_query("SELECT * FROM groups WHERE id='".$_GET['id']."' LIMIT 1");
		$row = mysql_fetch_assoc($sql);

		if($row['topics'] == 0) {
			echo '<input type="hidden" id="email-verfication-ok" value="1"/>';
			if($logged_in){
				echo '<a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuova discussione</b><i></i></a>';
			} else { 
				echo "Devi essere registrato per rispondere o inserire nuovi messaggi.";
			}
		} elseif($row['topics'] == 1) {
			$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$_GET['id']."' LIMIT 1");
		
			if(mysql_num_rows($check) > 0) { 
				echo '<input type="hidden" id="email-verfication-ok" value="1"/>';
				if($logged_in){ 
					echo '<a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuova discussione</b><i></i></a>';
				} else { 
					echo "Devi essere registrato per rispondere o inserire nuovi messaggi..";
				}
			}
		} elseif($row['topics'] == 2) {
			$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$_GET['id']."' AND member_rank = 3 LIMIT 1");
			if(mysql_num_rows($check) > 0) {
				echo '<input type="hidden" id="email-verfication-ok" value="1"/>';
				if($logged_in){
					echo '<a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuova discussione</b><i></i></a>';
				} else { 
					echo "Devi essere registrato per rispondere o inserire nuovi messaggi.";
				}
			}
		}
?>
    <div class="page-num-list">
    Vedi Pagina:
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"".PATH."discussions/".$groupid."&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	}
?>
    </div>
<?php }else{ ?>
<div id="group-topiclist-container">
<div class="topiclist-header clearfix">
        <input type="hidden" id="email-verfication-ok" value="1"/>
		<?php
		$sql = mysql_query("SELECT * FROM groups WHERE id='".$_GET['id']."' LIMIT 1");
		$row = mysql_fetch_assoc($sql);

		if($row['topics'] == 0) { ?>
		
        <input type="hidden" id="email-verfication-ok" value="1"/>
        <?php if($logged_in){ ?><a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuovo Thread</b><i></i></a><?php } else { echo "Devi essere registrato per rispondere o inserire nuovi messaggi."; }
		}elseif($row['topics'] == 1) {
		$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$_GET['id']."' LIMIT 1");
		if(mysql_num_rows($check) > 0) { ?>
        <input type="hidden" id="email-verfication-ok" value="1"/>
        <?php if($logged_in){ ?><a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuovo Thread</b><i></i></a><?php } else { echo "Devi essere registrato per rispondere o inserire nuovi messaggi"; }
		}
	}elseif($row['topics'] == 2) {
	$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$_GET['id']."' AND member_rank='2' LIMIT 1");
		if(mysql_num_rows($check) > 0) { ?>
        <input type="hidden" id="email-verfication-ok" value="1"/>
        <?php if($logged_in){ ?><a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuovo Thread</b><i></i></a><?php } else { echo "Devi essere registrato per rispondere o inserire nuovi messaggi."; }
	}
}
?>
    <div class="page-num-list">
    View page:
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"".PATH."discussions/".$groupid."&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	} 
?>
    </div>
</div>
<table class="group-topiclist" border="0" cellpadding="0" cellspacing="0" id="group-topiclist-list">
	<tr class="topiclist-columncaption">
		<td class="topiclist-columncaption-topic">Topic</td>
		<td class="topiclist-columncaption-lastpost">Ultimo</td>
		<td class="topiclist-columncaption-replies">Risposte</td>
		<td class="topiclist-columncaption-views">Visto</td>
	</tr>
	
<?php

if($threads == 0){
echo "	<tr class=\"topiclist-row-1\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			Nessun topic da visualizzare.
		</td>
		</tr>";
}

$sql = mysql_query("SELECT * FROM cms_forum_threads WHERE type > 2 AND forumid='".$groupid."' ORDER BY unix DESC") or die(mysql_error());
$stickies = mysql_num_rows($sql);

$query_min = ($page * 10) - 10;
$query_max = 10;

$query_max = $query_max - $stickies;
$query_min = $query_min - $stickies;

if($query_min < 0){ // Page 1
$query_min = 0;
}

while($row = mysql_fetch_assoc($sql)){

	$key++;

	if($input->IsEven($key)){
		$x = "odd";
	} else {
		$x = "even";
	}

	echo "<tr class=\"topiclist-row-" . $x . "\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			<div class=\"topiclist-row-content\">
			<a class=\"topiclist-link icon icon-sticky\" href=\"".PATH."viewthread?thread=".$row['id']."\">".$input->HoloText($row['title'])."</a>";

			if($row['type'] == 4){
			echo "&nbsp;<span class=\"topiclist-row-topicsticky\"><img src=\"".PATH."web-gallery/images/groups/status_closed.gif\" title=\"Closed Thread\" alt=\"Chiudi Topic\"></span>";
			}

			echo "&nbsp;(page ";

			$thread_pages = ceil(($row['posts'] + 1) / 10);

			for ($i = 1; $i <= $thread_pages; $i++){
				echo "<a href=\"".PATH."viewthread?thread=" . $row['id'] . "&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
			} 

            echo ")
			<br />
			<span><a class=\"topiclist-row-openername\" href=\"".PATH."home/" . $row['author'] . "\">" . $row['author'] . "</a></span>";

			$date_bits = explode(" ", $row['date']);
			$date = $date_bits[0];
			$time = $date_bits[1];
			
				echo "&nbsp;<span class=\"latestpost\">" . $date . "</span>
			<span class=\"latestpost\">(" . $time . ")</span>
			</div>
		</td>
		<td class=\"topiclist-lastpost\" valign=\"top\">
		    <a class=\"lastpost-page-link\" href=\"".PATH."viewthread?thread=" . $row['id'] . "&sp=JumpToLast\">";

			$date_bits = explode(" ", $row['lastpost_date']);
			$date = $date_bits[0];
			$time = $date_bits[1];

				echo "<span class=\"lastpost\">" . $date . "</span>
            <span class=\"lastpost\">(" . $time . ")</span></a><br />
			<span class=\"topiclist-row-writtenby\">by:</span> <a class=\"topiclist-row-openername\" href=\"".PATH."home/" . $row['lastpost_author'] . "\">" . $row['lastpost_author'] . "</a>&nbsp;
		</td>
 		<td class=\"topiclist-replies\" valign=\"top\">" . $row['posts'] . "</td>
 		<td class=\"topiclist-views\" valign=\"top\">" . $row['views'] . "</td>
	</tr>";

}

$sql = mysql_query("SELECT * FROM cms_forum_threads WHERE type < 3 AND forumid='".$groupid."' ORDER BY unix DESC LIMIT ".$query_min.", ".$query_max."") or die(mysql_error());

while($row = mysql_fetch_assoc($sql)){

	$key++;

	if($input->IsEven($key)){
		$x = "odd";
	} else {
		$x = "even";
	}

	echo "<tr class=\"topiclist-row-" . $x . "\">
		<td class=\"topiclist-rowtopic\" valign=\"top\">
			<div class=\"topiclist-row-content\">
			<a class=\"topiclist-link \" href=\"".PATH."viewthread?thread=".$row['id']."\">".$input->HoloText($row['title'])."</a>";

			if($row['type'] == 2){
			echo "&nbsp;<span class=\"topiclist-row-topicsticky\"><img src=\"".PATH."web-gallery/images/groups/status_closed.gif\" title=\"Chiudi Thread\" alt=\"Chiudi Thread\"></span>";
			}

			echo "&nbsp;(page ";

			$thread_pages = ceil(($row['posts'] + 1) / 10);

			for ($i = 1; $i <= $thread_pages; $i++){
				echo "<a href=\"".PATH."viewthread?thread=" . $row['id'] . "&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
			} 

            echo ")
			<br />
			<span><a class=\"topiclist-row-openername\" href=\"".PATH."home/" . $row['author'] . "\">" . $row['author'] . "</a></span>";

			$date_bits = explode(" ", $row['date']);
			$date = $date_bits[0];
			$time = $date_bits[1];
			
				echo "&nbsp;<span class=\"latestpost\">" . $date . "</span>
			<span class=\"latestpost\">(" . $time . ")</span>
			</div>
		</td>
		<td class=\"topiclist-lastpost\" valign=\"top\">
		    <a class=\"lastpost-page-link\" href=\"".PATH."viewthread?thread=" . $row['id'] . "&sp=JumpToLast\">";

			$date_bits = explode(" ", $row['lastpost_date']);
			$date = $date_bits[0];
			$time = $date_bits[1];

				echo "<span class=\"lastpost\">" . $date . "</span>
            <span class=\"lastpost\">(" . $time . ")</span></a><br />
			<span class=\"topiclist-row-writtenby\">by:</span> <a class=\"topiclist-row-openername\" href=\"".PATH."home/" . $row['lastpost_author'] . "\">" . $row['lastpost_author'] . "</a>&nbsp;
		</td>
 		<td class=\"topiclist-replies\" valign=\"top\">" . $row['posts'] . "</td>
 		<td class=\"topiclist-views\" valign=\"top\">" . $row['views'] . "</td>
	</tr>";

}

?>	

	</table>
<div class="topiclist-footer clearfix">
		<?php
		$sql = mysql_query("SELECT * FROM groups WHERE id='".$_GET['id']."' LIMIT 1");
		$row = mysql_fetch_assoc($sql);

		if($row['topics'] == 0) { ?>
		
        <input type="hidden" id="email-verfication-ok" value="1"/>
        <?php if($logged_in){ ?><a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuovo Thread</b><i></i></a><?php } else { echo "Devi essere registrato per rispondere o inserire nuovi messaggi."; }
		}elseif($row['topics'] == 1) {
		$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$_GET['id']."' LIMIT 1");
		if(mysql_num_rows($check) > 0) { ?>
        <input type="hidden" id="email-verfication-ok" value="1"/>
        <?php if($logged_in){ ?><a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuovo Thread</b><i></i></a><?php } else { echo "Devi essere registrato per rispondere o inserire nuovi messaggi."; }
		}
	}elseif($row['topics'] == 2) {
	$check = mysql_query("SELECT * FROM ".$site['memberships']." WHERE userid='".$user->row['id']."' AND groupid='".$_GET['id']."' AND member_rank='2' LIMIT 1");
		if(mysql_num_rows($check) > 0) { ?>
        <input type="hidden" id="email-verfication-ok" value="1"/>
        <?php if($logged_in){ ?><a href="#" id="newtopic-upper" class="new-button verify-email newtopic-icon" style="float:left"><b><span></span>Nuovo Thread</b><i></i></a><?php } else { echo "Devi essere registrato per rispondere o inserire nuovi messaggi."; }
	}
}
?>
    <div class="page-num-list">
   Vedi Pagina:
<?php
	for ($i = 1; $i <= $pages; $i++){
		if($page == $i){
			echo $i . "\n";
		} else {
			echo "<a href=\"".PATH."discussions/".$groupid."&page=" . $i . "\" class=\"topiclist-page-link\">" . $i . "</a>\n";
		}
	}
?>
    </div>
<?php }
?>
</div>
</div>

<script type="text/javascript" language="JavaScript">
L10N.put("myhabbo.discussion.error.topic_name_empty", "Topic title may not be empty");
Discussions.initialize("<?php echo $_GET['id']; ?>", "<?php echo PATH; ?>discussions/<?php echo $groupid; ?>", null);
</script>
                    </div>
					
                </td>
                <td style="width: 4px;"></td>
                <td valign="top" style="width: 164px;">
    <div class="habblet ">
	<?php $incolumn = 0; include("templates/ads.php"); ?>
    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">
	Event.observe(window, "load", observeAnim);
	document.observe("dom:loaded", initDraggableDialogs);
</script>
    </div>
<?php include("templates/footer.php"); ?>

</div>

</div>

<div class="cbb topdialog black" id="dialog-group-settings">
	
	<div class="box-tabs-container">
<ul class="box-tabs">
	<li class="selected" id="group-settings-link-group"><a href="#">Gruppo</a><span class="tab-spacer"></span></li>
	<li id="group-settings-link-forum"><a href="#">Forum</a><span class="tab-spacer"></span></li>
	<li id="group-settings-link-room"><a href="#">Camera</a><span class="tab-spacer"></span></li>
</ul>
</div>

	<a class="topdialog-exit" href="#" id="dialog-group-settings-exit">X</a>
	<div class="topdialog-body" id="dialog-group-settings-body">
<p style="text-align:center"><img src="<?php echo PATH; ?>web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></p>
	</div>
</div>	

<script language="JavaScript" type="text/javascript">
Event.observe("dialog-group-settings-exit", "click", function(e) {
    Event.stop(e);
    closeGroupSettings();
}, false);
</script><div class="cbb topdialog" id="postentry-verifyemail-dialog">
	<h2 class="title dialog-handle">Conferma Indirizzo Email</h2>
	
	<a class="topdialog-exit" href="#" id="postentry-verifyemail-dialog-exit">X</a>
	<div class="topdialog-body" id="postentry-verifyemail-dialog-body">
	<p>e necessaria L'email prima di poter postare un commento.</p>
	<p><a href="/profile?tab=3">Arriva</a></p>
	<p class="clearfix">
		<a href="#" id="postentry-verifyemail-ok" class="new-button"><b>OK</b><i></i></a>
	</p>
	</div>
</div>	
					
<script type="text/javascript">
HabboView.run();
</script>

</body>
</html>
<?php
} else if(!isset($_GET['id']) || $_GET['id'] == 0) {
	header("Location: ".PATH."forum");
} else {
$pagename = "Pagina Non Trovata";
$body_id = "home";
include('templates/subheader.php');
include('templates/header.php');
?>



<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
				<div class="habblet-container ">		
						<div class="cbb clearfix red ">
	
							<h2 class="title">Pagina Non trovata!
							</h2>
						<div id="notfound-content" class="box-content">
    <p class="error-text">La Pagina non &egrave; stata trovata.</p> <img id="error-image" src="<?php echo PATH; ?>web-gallery/v2/images/error.gif" />
    <p class="error-text">premi indietro del browser per tornare alla pagina precedente</p>
    <p class="error-text"><b>Cerca Gruppo</b></p>
    <?php if(isset($searchString)){ echo "<p class=\"error-text\">Non &egrave; stato trovato niente col nome <strong>'".$searchString."'.</strong></p>"; } ?>
    <p class="error-text">
	<form method='post'>
		<input type='text' name='searchString' maxlength='25' size='25' value='<?php if(isset($_POST['searchString'])){ echo $input->FilterText($_POST['searchString']); } ?>'>
		<input type='submit' class='submit' value='Cerca'>
	</form>
    </p>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 
</div>



<?php
include('templates/footer.php');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>