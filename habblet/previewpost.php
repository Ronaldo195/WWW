<?php
include('../core.php');
$x = $input->FilterText($_GET['x']);

if($input->getContent('forum-enabled') !== "1"){ header("Location: index.php"); exit; }
if(!$_SESSION['user']){ exit; }
if($x !== "topic" && $x !== "post"){ exit; }

$message = isset($_POST['message']) ? $input->FilterText($_POST['message']) : '';
$topicName = isset($_POST['topicName']) ? $input->FilterText($_POST['topicName']) : '';

if(empty($topicName)){ $topicName = "Anteprima"; }

echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"group-postlist-list\" id=\"group-postlist-list\">
<tr class=\"post-list-index-preview\">
	<td class=\"post-list-row-container\">
		<a href=\"".PATH."home/".$user->row['username']."\" class=\"post-list-creator-link post-list-creator-info\">".$user->row['username']."</a><br />
            &nbsp;&nbsp;<img alt=\"offline\" src=\"".PATH."web-gallery/images/myhabbo/habbo_online_anim.gif\" />
		<div class=\"post-list-posts post-list-creator-info\">Messaggio: ".$user->row['postcount']."</div>
		<div class=\"clearfix\">
            <div class=\"post-list-creator-avatar\"><img src=\"http://www.habbo.com/habbo-imaging/avatarimage?figure=".$user->row['look']."&size=b&direction=2&head_direction=2&gesture=sml\" alt=\"".$user->row['username']."\" /></div>
            <div class=\"post-list-group-badge\">";
                	if($input->GetUserGroup($user->row['id']) !== false){       
                	echo "<a href=\"".PATH."groups/".$input->GetUserGroup($user->row['id'])."\"><img src=\"./habbo-imaging/badge.php?badge=".$input->GetUserGroupBadge($user->row['id'])."\" /></a>";
		}
echo "            </div>
            <div class=\"post-list-avatar-badge\">";
		if($input->GetUserBadge($user->row['id']) !== false){
			echo "<img src=\"".$cimagesurl.$badgesurl.$input->GetUserBadge($user->row['id']).".gif\" />";
		}
echo "</div>
        </div>
        <div class=\"post-list-motto post-list-creator-info\">".$user->row['motto']."</div>
	</td>
	<td class=\"post-list-message\" valign=\"top\" colspan=\"2\">
            <a href=\"#\" id=\"edit-post-message\" class=\"resume-edit-link\">&laquo; Modifica</a>
        <span class=\"post-list-message-header\"> ".$topicName."</span><br />
        <span class=\"post-list-message-time\">".$date_full."</span>
        <div class=\"post-list-report-element\">
        </div>
        <div class=\"post-list-content-element\">
            ".$input->bbcode_format(trim(nl2br($input->HoloText($message))))."
        </div>
	<div>&nbsp;</div><div>&nbsp;</div>

        <div>\n";
			if($x == "topic"){
		        echo "<a id=\"topic-form-cancel-preview\" class=\"new-button red-button cancel-icon\" href=\"#\"><b><span></span>Annulla</b><i></i></a>
		        <a id=\"topic-form-save-preview\" class=\"new-button green-button save-icon\" href=\"#\"><b><span></span>Salva</b><i></i></a>            ";
			} else {
			  echo "<a id=\"post-form-cancel\" class=\"new-button red-button cancel-icon\" href=\"#\"><b><span></span>Annulla</b><i></i></a>
		        <a id=\"post-form-save\" class=\"new-button green-button save-icon\" href=\"#\"><b><span></span>Salva</b><i></i></a>";
			}
echo "\n	</div>
	</td>
</tr>
</table>";

?>
