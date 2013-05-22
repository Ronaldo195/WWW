<?php

$allow_guests = true;

include('core.php');
include('includes/session.php');


$pagename = "Staff";
$pageid = "staff";

include('templates/subheader.php');
include('templates/header.php');

?>
<style>
.guestbook-entries {
	list-style: none;
	padding: 0;
	margin: 0;
}

.guestbook-entries li {
	list-style: none;
	padding-bottom: 3px;
	margin-bottom: 5px;
	word-wrap: break-word;
}

* html .guestbook-entries li {
	zoom : 1;
}

.guestbook-entries li p {
	padding: 0;
	margin: 0;
}

.guestbook-entries .guestbook-author {
	float: left;
	width: 30px;
	margin-right: 8px;
}

.guestbook-entries .guestbook-message {
	margin: 0 50px 0 65px;
}

.guestbook-entries .guestbook-actions {
	float: right;
	width: 30px;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 5px;
}

.guestbook-entries .guestbook-cleaner {
	clear:both;
	height:1px;
	font-size:1px;
	border:none;
	margin:0; padding:0;
	background:transparent;
}

.guestbook-entries .guestbook-entry-footer {
	font-size: 9px;
	text-align: right;
	padding-right: 30px;
}

.metadata {
	color: #666;
}

#guestbook-form-dialog, #guestbook-delete-dialog {
	width: 300px;
    position: absolute;
    left: -1500px;
    top: 0;
}
#guestbook-form {
	margin: 0;
	padding: 0;
}
#guestbook-form textarea {
	width: 98%;
	font-size: 11px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}

#guestbook-form-preview.disabled span {
	color: #888;
}

.guestbook-toolbar {
	margin-top: 12px;
}

.guestbook-toolbar .colorlink span img {
	margin-right: 10px;
}

.guestbook-message .offline, .guestbook-message .online {
	text-indent: 17px;
	height: 18px;
}

.guestbook-message .offline {
	background: transparent url(web-gallery/images/myhabbo/habbo_offline.gif) no-repeat top left;
}

.guestbook-message .online {
	background: transparent url(web-gallery/images/myhabbo/habbo_online_anim.gif) no-repeat top left;
}
</style>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
		<div id="column7" class="column">
			
		<?php
		
		$sql = mysql_query("SELECT * FROM users WHERE rank > 3");
		
		if(mysql_num_rows($sql) > 0){
		
		while($row = mysql_fetch_assoc($sql)){
		
		switch($row['rank']){
			case '4':
				$badge = 'NWB';
				break;
			case '5':
				$badge = 'HBA';
				break;
			case '6':
			case '7':
				$badge = 'ADM';
				break;
			default:
				$badge = '';
				break;
		}
		echo '
			<div class="habblet-container " style="float:left;width: 385px;">
				<div class="cbb clearfix default ">
					<ul class="guestbook-entries" id="guestbook-entry-container">
					<li id="guestbook-entry-dafs" class="guestbook-entry">
						<div class="guestbook-author">
							<img src="'.$user->avatarURL($row['look'],"b,2,3,sml,1,0","wav").'">
						</div>

						<div class="guestbook-actions"><img src="'.$cimagesurl.$badgesurl.$badge.'.gif"></div>
						
						<div class="guestbook-message">
							<div class="'.($input->IsUserOnline($row['id']) ? 'online' : 'offline').'">
								<a href="'.PATH.'home/'.$row['username'].'">'.$row['username'].'</a>
							</div>
							<p>'.$row['description'].'</p>
						</div>
					</li>
					</ul>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName(\'process-template\')) { Rounder.init(); }</script>
			</div>
			';
		}
		}
		?>
		</div>
	
		<div id="column3" class="column">
			<?php include("templates/ads.php"); ?>
		</div>
	</div>
<script type="text/javascript">
	HabboView.add(LoginFormUI.init);
</script>
<?php

include('templates/footer.php');
?>
</div>