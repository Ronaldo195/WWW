<?php
include('../core.php');
include('../includes/session.php');

if($input->getContent('forum-enabled') != "1"){ header("Location: index.php"); exit; }

$message = $input->FilterText($_POST['message']);
$topicTitle = $input->FilterText($_POST['topicName']);

if(empty($topicTitle)){ echo "Non Puoi Lasciare il titolo bianco"; exit; }

mysql_query("INSERT INTO cms_forum_threads (forumid,type,title,author,date,lastpost_author,lastpost_date,views,posts,unix) VALUES ('".$_POST['groupId']."','1','".$topicTitle."','".$user->row['username']."','".$date_full."','".$user->row['username']."','".$date_full."','0','0','".strtotime('now')."')") or die(mysql_error());
mysql_query("UPDATE users SET postcount = postcount + 1 WHERE id = '".$user->row['id']."' LIMIT 1");

$check = mysql_query("SELECT id FROM cms_forum_threads WHERE forumid='".$_POST['groupId']."' ORDER BY id DESC LIMIT 1") or die(mysql_error());
$row = mysql_fetch_assoc($check);

$threadid = $row['id'];

mysql_query("INSERT INTO cms_forum_posts (forumid,threadid,message,author,date) VALUES ('".$_POST['groupId']."','".$threadid."','".$message."','".$user->row['username']."','".$date_full."')");

echo "<center><br /><br /><b>Topic Creato Correttamente.</b><br /><a href='".PATH."viewthread?thread=".$threadid."&page=1'>Procedi</a><br /><br /><br /></center>";
?>