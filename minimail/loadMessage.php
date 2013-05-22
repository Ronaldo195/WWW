<?php
if(!isset($bypass) || $bypass != "true"){
	include('../core.php');
	include('../includes/session.php');
}
$my_id = $user->row['id'];

if(isset($_GET['messageId'])){
	$mesid = $input->FilterText($_GET['messageId']);
	$label = $input->FilterText($_GET['label']);
	$sql = mysql_query("SELECT * FROM cms_minimail WHERE id = '".$mesid."'");
	$row = mysql_fetch_assoc($sql);
	$sql2 = mysql_query("SELECT * FROM users WHERE id = '".$row['senderid']."'");
	$senderrow = mysql_fetch_assoc($sql2);
	$sql3 = mysql_query("SELECT * FROM users WHERE id = '".$row['to_id']."'");
	$torow = mysql_fetch_assoc($sql3); ?>
	<ul class="message-headers">
				<li><a href="#" class="report" title="Report as offensive"></a></li>
			<li><b>Oggetto:</b> <?php echo $row['subject']; ?></li>
			<li><b>Da:</b> <?php echo $senderrow['username']; ?></li>
			<li><b>Ad:</b> <?php echo $torow['username']; ?></li>

		</ul>
		<div class="body-text"><?php echo $input->bbcode_format(trim(nl2br(stripslashes($row['message'])))); ?><br></div>
		<div class="reply-controls">
			<div>
				<div class="new-buttons clearfix">
				<?php if($row['conversationid'] != '0'){ ?>
					<a href="#" class="related-messages" id="rel-<?php echo $row['conversationid']; ?>" title="Show full conversation"></a>
				<?php } ?>
				<?php if($label == "trash"){ ?>
					<a href="#" class="new-button undelete"><b>Salva</b><i></i></a>
					<a href="#" class="new-button red-button delete"><b>Elimina</b><i></i></a>
				<?php } elseif($label == "inbox") { ?>
					<a href="#" class="new-button red-button delete"><b>Elimina</b><i></i></a>
					<a href="#" class="new-button reply"><b>Rispondi</b><i></i></a>
				<?php } ?>
				</div>
			</div>
			<div style="display: none;">
				<textarea rows="5" cols="10" class="message-text"></textarea><br>
				<div class="new-buttons clearfix">Cancella</b><i></i></a>
					<a href="#" class="new-button preview"><b>Anteprima</b><i></i></a>

					<a href="#" class="new-button send-reply"><b>Invia</b><i></i></a>
				</div>
			</div>
		</div>
	<?php if($label == "inbox"){ mysql_query("UPDATE cms_minimail SET read_mail = '1' WHERE id = '".$mesid."'");}
}
if(isset($_POST['label']) OR isset($bypass) && $bypass == "true"){
	$label = isset($_POST['label']) ? $input->FilterText($_POST['label']) : '';
	$start = isset($_POST['start']) ? $input->FilterText($_POST['start']) : '';
	$conversationid = isset($_POST['conversationId']) ? $input->FilterText($_POST['conversationId']) : '';
	$unread = isset($_POST['unreadOnly']) ? $input->FilterText($_POST['unreadOnly']) : '';
	if(isset($bypass) && $bypass == "true"){
		$label = $page;
	}

	?>
		<a href="#" class="new-button compose"><b>Componi</b><i></i></a>
	<div class="clearfix labels nostandard">
		<ul class="box-tabs">
		<?php
		$sql = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND read_mail = '0'");
		$unreadmail = mysql_num_rows($sql);
		?>
			<li <?php if($label == "inbox"){ echo "class=\"selected\""; } ?>><a href="#" label="inbox">Ricevuti<?php if($unreadmail <> 0){ echo " (".$unreadmail.")"; } ?></a><span class="tab-spacer"></span></li>
			<li <?php if($label == "sent"){ echo "class=\"selected\"";  } ?>><a href="#" label="sent">Inviati</a><span class="tab-spacer"></span></li>
			<li <?php if($label == "trash"){ echo "class=\"selected\""; } ?>><a href="#" label="trash">Cestino</a><span class="tab-spacer"></span></li>
		</ul>

	</div>
	<div id="message-list" class="label-<?php echo $label; ?>">
	<div class="new-buttons clearfix">
		<div class="labels inbox-refresh"><a href="#" class="new-button green-button" label="Ricevuti" style="float: left; margin: 0"><b>Controlla i nuovi messaggi!</b><i></i></a></div>
	</div>

	<div style="clear: both; height: 1px"></div>
<?php if($label == "inbox"){ ?>
	<div class="navigation">
		<div class="unread-selector"><input type="checkbox" class="unread-only" <?php if($unread == "true"){ echo "checked"; } ?>/> Mostra solo messaggi non letti</div>
			<?php
			$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND deleted = '0'");
			$allmail = mysql_num_rows($sql1);
			$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND deleted = '0' AND read_mail = '0'");
			$unreadmail = mysql_num_rows($sql1);
			if($unread == "true"){
				$allnum = $unreadmail;
			} else {
				$allnum = $allmail;
			}
			if($start != null){
				$offset = $start;
				$startnum = $start + 1;
				$endnum = $start + 10;
				if($endnum > $allnum){ $endnum = $allnum; }
			} else {
				$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND deleted = '0' LIMIT 10");
				$endnum = mysql_num_rows($sql1);
				$offset = "0";
				$startnum = "1";
			}
			$var1 = " <a href=\"#\" class=\"newer\">Newer</a> ";
			$var2 = " ".$startnum." - ".$endnum." of ".$allnum." ";
			$var3 = " <a href=\"#\" class=\"older\">Older</a> ";
			$var4 = " <a href=\"#\" class=\"newest\">Newest</a> ";
			$var5 = "<!-- <a href=\"#\" class=\"oldest\">Oldest</a> -->";
			$totalpages = ceil($allnum / 10);
			if($endnum != $allnum && $startnum != 1){
				$maillist = $var1.$var2.$var3;
			} elseif($endnum != $allnum && $startnum == 1){
				$maillist = $var2.$var3;
			} elseif($endnum == $allnum && $startnum != 1){
				$maillist = $var1.$var2;
			} elseif($endnum == $allnum && $startnum == 1){
				$maillist = $var2;
			}
			if($startnum + 20 < $allnum && $endnum <> $allnum){
				$maillist = $maillist.$var5;
			}
			if($startnum - 20 > 0){
				$maillist = $var4.$maillist;
			}
			$maillist = "<p>".$maillist."</p>";
			?>
		<?php if($allmail == 0){ ?>
			<p class="no-messages">
				   Nessun messagio
			</p>
		<?php } elseif($unreadmail == "0" && $unread == "true"){ ?>
			<p class="no-messages">
				   Nessun messaggio
			</p>
		<?php } ?>
			<div class="progress"></div>
			<?php if($unread == "true"){
				if($unreadmail <> 0){ echo $maillist; }
				} else {
				if($allmail <> 0){ echo $maillist; }
				} ?>
	</div>

	<?php
			   $i = 0;
			   if($unread == "true"){
			   	$getem = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND deleted = '0' AND read_mail = '0' ORDER BY ID DESC LIMIT 10 OFFSET ".$offset) or die(mysql_error());
			   } else {
			   	$getem = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND deleted = '0' ORDER BY id DESC LIMIT 10 OFFSET ".$offset) or die(mysql_error());
			   }
			   while ($row = mysql_fetch_assoc($getem)) {
					   $i++;

					   if($row['read_mail'] == 0){
						   $read = "unread";
					   } else {
						   $read = "read";
					   }

					   $mysql = mysql_query("SELECT * FROM users WHERE id = '".$row['senderid']."' LIMIT 1");
					   $senderrow = mysql_fetch_assoc($mysql);
					   $figure = "http://www.habbo.it/habbo-imaging/avatarimage?figure=".$senderrow['look']."&size=s&direction=9&head_direction=2&gesture=sml";

	printf("	<div class=\"message-item %s \" id=\"msg-%s\">
			<div class=\"message-preview\" status=\"%s\">

				<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
					%s
				</span>
				<img src=\"%s\" />
				<span class=\"message-sender\" title=\"%s\">%s</span>

				<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
			</div>
			<div class=\"message-body\" style=\"display: none;\">
				<div class=\"contents\"></div>

				<div class=\"message-body-bottom\"></div>
			</div>
		</div>", $read, $row['id'], $read, $input->nicetime($row['date']), $input->nicetime($row['date']), $input->nicetime($row['date']), $figure, $senderrow['username'], $senderrow['username'], $row['subject'], $row['subject']);
			   }
	?>

	<div class="navigation">
			<div class="progress"></div>

			<?php if($unread == "true"){
				if($unreadmail <> 0){ echo $maillist; }
				} else {
				if($allmail <> 0){ echo $maillist; }
				} ?>
	</div>

	</div>
	<?php } elseif($label == "sent"){ ?>
		<div class="navigation">
			<?php
			$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE senderid = '".$my_id."'");
			$allmail = mysql_num_rows($sql1);
			$allnum = $allmail;
			if($start != null){
				$offset = $start;
				$startnum = $start + 1;
				$endnum = $start + 10;
				if($endnum > $allnum){ $endnum = $allnum; }
			} else {
				$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE senderid = '".$my_id."' AND deleted = '0' LIMIT 10");
				$endnum = mysql_num_rows($sql1);
				$offset = "0";
				$startnum = "1";
			}
			$var1 = " <a href=\"#\" class=\"newer\">Newer</a> ";
			$var2 = " ".$startnum." - ".$endnum." of ".$allnum." ";
			$var3 = " <a href=\"#\" class=\"older\">Older</a> ";
			$var4 = " <a href=\"#\" class=\"newest\">Newest</a> ";
			$var5 = "<!-- <a href=\"#\" class=\"oldest\">Oldest</a> -->";
			$totalpages = ceil($allnum / 10);
			if($endnum != $allnum && $startnum != 1){
				$maillist = $var1.$var2.$var3;
			} elseif($endnum != $allnum && $startnum == 1){
				$maillist = $var2.$var3;
			} elseif($endnum == $allnum && $startnum != 1){
				$maillist = $var1.$var2;
			} elseif($endnum == $allnum && $startnum == 1){
				$maillist = $var2;
			}
			if($startnum + 20 < $allnum && $endnum <> $allnum){
				$maillist = $maillist.$var5;
			}
			if($startnum - 20 > 0){
				$maillist = $var4.$maillist;
			}
			$maillist = "<p>".$maillist."</p>";
			?>
			<?php if($allmail == 0){ ?>
				<p class="no-messages">
					   Non hai inviato messaggi.
				</p>
			<?php } ?>
				<div class="progress"></div>

				<?php if($allmail <> 0){ echo $maillist; } ?>
		</div>
		<?php
				   $i = 0;
				   $getem = mysql_query("SELECT * FROM cms_minimail WHERE senderid = '".$my_id."' ORDER BY id DESC LIMIT 10 OFFSET ".$offset) or die(mysql_error());

				   while ($row = mysql_fetch_assoc($getem)) {
						   $i++;

						   if($row['read_mail'] == 0){
							   $read = "unread";
						   } else {
							   $read = "read";
						   }

						   $mysql = mysql_query("SELECT * FROM users WHERE id = '".$row['senderid']."' LIMIT 1");
						   $senderrow = mysql_fetch_assoc($mysql);
						   $figure = "http://www.habbo.it/habbo-imaging/avatarimage?figure=".$senderrow['look']."&size=s&direction=9&head_direction=2&gesture=sml";

		printf("	<div class=\"message-item %s \" id=\"msg-%s\">
				<div class=\"message-preview\" status=\"%s\">

					<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
						%s
					</span>
					<img src=\"%s\" />
					<span class=\"message-sender\" title=\"To: %s\">To: %s</span>

					<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
				</div>
				<div class=\"message-body\" style=\"display: none;\">
					<div class=\"contents\"></div>

					<div class=\"message-body-bottom\"></div>
				</div>
			</div>", $read, $row['id'], $read, $row['date'], $row['date'], $row['date'], $figure, $senderrow['username'], $senderrow['username'], $row['subject'], $row['subject']);
				   }
		?>

		<div class="navigation">
				<div class="progress"></div>

				<?php if($allmail <> 0){ echo $maillist; } ?>
	</div>
	<?php } elseif($label == "trash"){ ?>
			<?php
			$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND deleted = '1'");
			$allmail = mysql_num_rows($sql1);
			$allnum = $allmail;
			
			if($allnum > 0){
			?>
			<div class="trash-controls notice">
				I messaggi in questa cartella pi&ugrave vecchi di 30 giorni vengono elimitati automaticamente. <a href="#" class="empty-trash">Svuota cestino</a>
			</div>
			<div class="navigation">
			<?php }
			if($start != null){
				$offset = $start;
				$startnum = $start + 1;
				$endnum = $start + 10;
				if($endnum > $allnum){ $endnum = $allnum; }
			} else {
				$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND deleted = '1' LIMIT 10");
				$endnum = mysql_num_rows($sql1);
				$offset = "0";
				$startnum = "1";
			}
			$var1 = " <a href=\"#\" class=\"newer\">Newer</a> ";
			$var2 = " ".$startnum." - ".$endnum." of ".$allnum." ";
			$var3 = " <a href=\"#\" class=\"older\">Older</a> ";
			$var4 = " <a href=\"#\" class=\"newest\">Newest</a> ";
			$var5 = "<!-- <a href=\"#\" class=\"oldest\">Oldest</a> -->";
			$totalpages = ceil($allnum / 10);
			if($endnum != $allnum && $startnum != 1){
				$maillist = $var1.$var2.$var3;
			} elseif($endnum != $allnum && $startnum == 1){
				$maillist = $var2.$var3;
			} elseif($endnum == $allnum && $startnum != 1){
				$maillist = $var1.$var2;
			} elseif($endnum == $allnum && $startnum == 1){
				$maillist = $var2;
			}
			if($startnum + 20 < $allnum && $endnum <> $allnum){
				$maillist = $maillist.$var5;
			}
			if($startnum - 20 > 0){
				$maillist = $var4.$maillist;
			}
			$maillist = "<p>".$maillist."</p>";
			?>
			<?php if($allmail == 0){ ?>
				<p class="no-messages">
					   Nessun messaggio eliminato
				</p>
			<?php } ?>
				<div class="progress"></div>

				<?php if($allmail <> 0){ echo $maillist; } ?>
		</div>
		<?php
				   $i = 0;
				   $getem = mysql_query("SELECT * FROM cms_minimail WHERE to_id = '".$my_id."' AND deleted = '1' ORDER BY ID DESC LIMIT 10 OFFSET ".$offset) or die(mysql_error());

				   while ($row = mysql_fetch_assoc($getem)) {
						   $i++;

						   if($row['read_mail'] == 0){
							   $read = "unread";
						   } else {
							   $read = "read";
						   }

						   $mysql = mysql_query("SELECT * FROM users WHERE id = '".$row['senderid']."' LIMIT 1");
						   $senderrow = mysql_fetch_assoc($mysql);
						   $figure = "http://www.habbo.it/habbo-imaging/avatarimage?figure=".$senderrow['look']."&size=s&direction=9&head_direction=2&gesture=sml";

		printf("	<div class=\"message-item %s \" id=\"msg-%s\">
				<div class=\"message-preview\" status=\"%s\">

					<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
						%s
					</span>
					<img src=\"%s\" />
					<span class=\"message-sender\" title=\"%s\">%s</span>

					<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
				</div>
				<div class=\"message-body\" style=\"display: none;\">
					<div class=\"contents\"></div>

					<div class=\"message-body-bottom\"></div>
				</div>
			</div>", $read, $row['id'], $read, $input->nicetime($row['date']), $input->nicetime($row['date']), $input->nicetime($row['date']), $figure, $senderrow['username'], $senderrow['username'], $row['subject'], $row['subject']);
				   }
		?>

		<div class="navigation">
				<div class="progress"></div>

				<?php if($allmail <> 0){ echo $maillist; } ?>
	</div>

	</div>
	<?php } elseif($label == "conversation"){ ?>
			<div class="trash-controls notice">
				Stai leggendo una conversazione. Fare clic sulle schede sopra per tornare alle proprie cartelle.

			</div>
		<?php $id = $_POST['messageId'];
		$conid = $input->FilterText($_POST['conversationId']); ?>

		<div class="navigation">
			<?php
			$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE conversationid = '".$conid."' AND deleted = '0'");
			$allmail = mysql_num_rows($sql1);
			$allnum = $allmail;
			if($start != null){
				$offset = $start;
				$startnum = $start + 1;
				$endnum = $start + 10;
				if($endnum > $allnum){ $endnum = $allnum; }
			} else {
				$sql1 = mysql_query("SELECT * FROM cms_minimail WHERE conversationid = '".$conid."' AND deleted = '0' LIMIT 10");
				$endnum = mysql_num_rows($sql1);
				$offset = "0";
				$startnum = "1";
			}
			$var1 = " <a href=\"#\" class=\"newer\">Newer</a> ";
			$var2 = " ".$startnum." - ".$endnum." of ".$allnum." ";
			$var3 = " <a href=\"#\" class=\"older\">Older</a> ";
			$var4 = " <a href=\"#\" class=\"newest\">Newest</a> ";
			$var5 = "<!-- <a href=\"#\" class=\"oldest\">Oldest</a> -->";
			$totalpages = ceil($allnum / 10);
			if($endnum != $allnum && $startnum != 1){
				$maillist = $var1.$var2.$var3;
			} elseif($endnum != $allnum && $startnum == 1){
				$maillist = $var2.$var3;
			} elseif($endnum == $allnum && $startnum != 1){
				$maillist = $var1.$var2;
			} elseif($endnum == $allnum && $startnum == 1){
				$maillist = $var2;
			}
			if($startnum + 20 < $allnum && $endnum <> $allnum){
				$maillist = $maillist.$var5;
			}
			if($startnum - 20 > 0){
				$maillist = $var4.$maillist;
			}
			$maillist = "<p>".$maillist."</p>";
			?>
			<?php if($allmail == 0){ ?>
				<p class="no-messages">
					  Nessun Messaggio
				</p>
			<?php } ?>
				<div class="progress"></div>

				<?php if($allmail <> 0){ echo $maillist; } ?>
		</div>
		<?php
				   $i = 0;
				   $getem = mysql_query("SELECT * FROM cms_minimail WHERE conversationid = '".$conid."' AND deleted = '0' ORDER BY id DESC LIMIT 10 OFFSET ".$offset) or die(mysql_error());

				   while ($row = mysql_fetch_assoc($getem)) {
						   $i++;

						   if($row['read_mail'] == 0){
							   $read = "unread";
						   } else {
							   $read = "read";
						   }

						   $mysql = mysql_query("SELECT * FROM users WHERE id = '".$row['senderid']."' LIMIT 1");
						   $senderrow = mysql_fetch_assoc($mysql);
						   $figure = "http://www.habbo.it/habbo-imaging/avatarimage?figure=".$senderrow['look']."&size=s&direction=9&head_direction=2&gesture=sml";

		printf("	<div class=\"message-item %s \" id=\"msg-%s\">
				<div class=\"message-preview\" status=\"%s\">

					<span class=\"message-tstamp\" isotime=\"%s\" title=\"%s\">
						%s
					</span>
					<img src=\"%s\" />
					<span class=\"message-sender\" title=\"%s\">%s</span>

					<span class=\"message-subject\" title=\"%s\">&ldquo;%s&rdquo;</span>
				</div>
				<div class=\"message-body\" style=\"display: none;\">
					<div class=\"contents\"></div>

					<div class=\"message-body-bottom\"></div>
				</div>
			</div>", $read, $row['id'], $read, $input->nicetime($row['date']), $input->nicetime($row['date']), $input->nicetime($row['date']), $figure, $senderrow['username'], $senderrow['username'], $row['subject'], $row['subject']);
				   }
		?>

		<div class="navigation">
				<div class="progress"></div>

				<?php if($allmail <> 0){ echo $maillist; } ?>
	</div>
	<?php }
	if(isset($bypass) && $bypass == "true" && isset($message) && $message != ""){ ?><div style="opacity: 1;" class="notification"><?php echo $message; ?></div></div><?php }
}
?>