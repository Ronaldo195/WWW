<?php
include('../core.php');

if($input->getContent('forum-enabled') !== "1"){ header("Location: index.php"); exit; }
if(!$_SESSION['user']){ exit; }

$topicid = $input->FilterText($_POST['topicId']);

if(is_numeric($topicid)){
	if($user->row['rank'] > 5){
		$check = mysql_query("SELECT * FROM cms_forum_threads WHERE id = '".$topicid."' LIMIT 1");
		$exists = mysql_num_rows($check);
		$row = mysql_fetch_assoc($check);
		if($exists > 0){
			mysql_query("DELETE FROM cms_forum_threads WHERE id = '".$topicid."' LIMIT 1");
			mysql_query("DELETE FROM cms_forum_posts WHERE threadid = '".$topicid."'");
			
			if($row['forumid'] == 0 || $row['forumid'] == '')
				header("Location: ".PATH."forum");
			else
				header("Location: ".PATH."discussions/".$row['forumid']);
				
			echo "TOPIC_DELETED";
			exit;
		} else {
			exit;
		}
	} else {
		exit;
	}
} else {
	exit;
}

?>