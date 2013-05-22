<?php
include('core.php');
include('includes/session.php');

if($site['chat'] == '0')
	header("Location: ".PATH."error");

$pagename = "Chat";
$pageid = "chat";

include('templates/subheader.php');
include('templates/header.php');
?>
<script type="text/javascript">
var myRequest = null;

function CreateXmlHttpReq(handler) {
 	var xmlhttp = null;
	try {
    	xmlhttp = new XMLHttpRequest();
  	}catch(e){
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
  xmlhttp.onreadystatechange = handler;
  return xmlhttp;
}

function myHandler() {
    if (myRequest.readyState == 4 && myRequest.status == 200) {
        e = document.getElementById("chatbox");
        e.innerHTML = myRequest.responseText;
    }
}

function Ricarica(){
	var r = Math.random();
	myRequest = CreateXmlHttpReq(myHandler);
	myRequest.open("GET","<?php echo PATH; ?>habblet/ajax_chat.php");
	myRequest.send(null);
	var objDiv = document.getElementById("listing");
	objDiv.scrollTop = objDiv.scrollHeight;
}

var ms_ultimo = 0;
function Insert() {
	start = new Date().getTime();
	if((start-ms_ultimo) <= 2000)
		alert('Non si flodda amico :o');
	else {
		ms_ultimo = start;
		new Ajax.Updater('', '<?php echo PATH; ?>habblet/ajax_chat.php', {
			method: 'post', 
			parameters: { text: $F('texting') },
			insertion: Insertion.Bottom
		});
   }
   document.getElementById('texting').value = '';
}

window.setInterval("Ricarica()", 500);
</script>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
		<div id="column1" class="column">
			<div class="habblet-container " style=" width: 770px">	
			<form id="forming" action="" method="post">
				<div class="cbb clearfix orange ">
					<h2 class="title">Chat di <?php echo $site['short'] ?> <?php echo $user->row['rank'] > 3 ? '(Comandi: /svuota)' : ''; ?></h2> 
					<br>
					<div id="listing" style="height:300px;overflow:hidden;">
						<div id="chatbox">
							<center><img src="<?php echo PATH; ?>web-gallery/v2/images/progress_bar_blue.gif"></center>
						</div>
					</div>

						<textarea id="texting" name="texting" rows="5" cols="122" style="resize:none;" maxlength="500"></textarea>
	<div style="padding-left:9px;">
	<script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("texting");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Rosso"],
            "orange" : ["#fe6301", "Arancione"],
            "yellow" : ["#ffce00", "Giallo"],
            "green" : ["#6cc800", "Verde"],
            "cyan" : ["#00c6c4", "Turchese"],
            "blue" : ["#0070d7", "Blu"],
            "gray" : ["#828282", "Grigio"],
            "black" : ["#000000", "Nero"]
        };
        bbcodeToolbar.addColorSelect("Colori", colors, false);
    </script>
	</div>
					<a style="margin-right:9px;" href="javascript:Insert();" class="new-button password-button"><b>Inserisci Messaggio</b><i></i></a>
					
				</div>
				</form>
			</div>
		</div>
		
		<div id="column2" class="column">
			&nbsp;
		</div>
		
		<div id="column3" class="column">
		<?php $incolumn = 0; include("templates/ads.php"); ?>
		</div>
	<div>
<?php

include('templates/footer.php');
?>
</div>