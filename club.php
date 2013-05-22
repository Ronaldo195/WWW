<?php
$allow_guests = true;

include('core.php');
include('includes/session.php');

$pagename = "Club";
$pageid = "7";
$body_id = "home";

include('templates/subheader.php');
include('templates/header.php');

?>
<div id="container">

	<div id="content" style="position: relative" class="clearfix"> 
    <div id="column" class="column" style="width: 770px; "> 
 
			     		
				<div class="habblet-container ">
						<div class="cbb clearfix hcred "> 
	
							<h2 class="title">Entra in <?php echo $site['short']; ?> Club
							</h2> 
<?php if(!$logged_in){ ?>
	<div id="hc-habblet" class='box-content'> 
		Effettua il login per scoprire lo status della tua iscrizione ad <?php echo $site['short']; ?> Club
	</div> 
<?php }else{ ?>
<script type="text/javascript">
var myRequest = null;
var myRequest2 = null;

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
        e = document.getElementById("hcing");
        e.innerHTML = myRequest.responseText;
    }
}

function myHandler2() {
	if (myRequest2.readyState == 4 && myRequest2.status == 200) {
        e = document.getElementById("hcing2");
        e.innerHTML = myRequest2.responseText;
    }
}

function Ricarica(){
	var r = Math.random();
	myRequest = CreateXmlHttpReq(myHandler);
	myRequest.open("GET","<?php echo PATH; ?>habblet/ajax_club.php");
	myRequest.send(null);
	
	myRequest2 = CreateXmlHttpReq(myHandler2);
	myRequest2.open("GET","<?php echo PATH; ?>habblet/ajax_club.php?p=2");
	myRequest2.send(null);
}

window.setInterval("Ricarica()", 1000);
</script>

<div id="hc-habblet box-content"> 
    <div id="hc-buy-container"> 
<div id="hc-buy-buttons" class="hc-buy-buttons"> 
 
<form class="subscribe-form" method="post"> 
 
   <div style="float: left; margin: 0px;"> 
    <div class="cbb habboclub-buyentry"> 
    <h2 class="title" style="background-color: #90a7b7;"> 
       HC o VIP?
     </h2> 
     <div style="padding: 10px 0 0 10px;" id="hcing">
		<center><img src="<?php echo PATH; ?>web-gallery/v2/images/progress_bar_blue.gif"></center>
	</div>
	<div style="height: 126px; padding: 10px" id="hcing2">
	</div> 
    </div> 
   </div> 
  <div style="float: left;"> 
	<?php
		$clubrow = mysql_query("SELECT * FROM user_subscriptions WHERE user_id = '".$user->row['id']."' LIMIT 1");
		$clubrow = mysql_num_rows($clubrow) > 0 ? mysql_fetch_assoc($clubrow) : '';
		if($clubrow != '' && $clubrow['subscription_id'] == "habbo_vip"){
	?>
<div style="float: left;"> 

<div class="cbb habboclub-buyentry"> 

<h2 class="title" style="background-color: #9b9448;"> 
<?php echo $site['short']; ?> Club</h2>  
<br>
	<div style="height: 136px; padding: 10px">
       L'acquisto di una sottoscrizione HC non &egrave; disponibile essendo tu in questo momento un Membro Vip Club.
    </div>

</div> 
</div>
</div>
        <?php }else{ ?>
     <div class="cbb habboclub-buyentry hcbasic"> 
     
      <h2 class="title" style="background-color: #9b9448;"> 
        <img style="float: left;" alt="hc" src="<?php echo PATH; ?>/web-gallery/v2/images/habboclub_basic_small.png" /> 
        1 mese
      </h2>   
            
    <div style="padding: 10px;"> 
     <img style="float: left;" alt="credits" src="<?php echo PATH; ?>/web-gallery/v2/images/newcredits/credit_in_white_bg.png" />   
     <span class="habboclub-offerprice">100</span> 
	
	<a class="new-button oversize" style="position: relative; left: 4px; top: 5px; margin-left: 0px" id="subscribe1" href="#" onclick='habboclub.buttonClick(1, "Conferma sottoscrizione"); return false;'><b>Acquista</b><i></i></a>
	
    </div> 
   </div> 
  
        
     <div class="cbb habboclub-buyentry hcbasic"> 
     
      <h2 class="title" style="background-color: #9b9448;"> 
        <img style="float: left;" alt="hc" src="<?php echo PATH; ?>/web-gallery/v2/images/habboclub_basic_small.png" /> 
        3 mesi</h2>   
            
    <div style="padding: 10px;"> 
     <img style="float: left;" alt="credits" src="<?php echo PATH; ?>/web-gallery/v2/images/newcredits/credit_in_white_bg.png" />   
<span class="habboclub-offerprice">300</span> 
<a class="new-button oversize" style="position: relative; left: 4px; top: 5px; margin-left: 0px" id="subscribe3" href="#" onclick='habboclub.buttonClick(2, "Conferma sottoscrizione"); return false;'><b>Acquista</b><i></i></a>
</div> 
</div> 

</div>   
   <?php } ?>
  <div style="float: left;"> 
       
     <div class="cbb habboclub-buyentry hcvip"> 
     
      <h2 class="title" style="background-color: #969696;">      
        <img style="float: left;" alt="vip" src="<?php echo PATH; ?>/web-gallery/v2/images/habboclub_vip_small.png" /> 
        1 mese
      </h2> 
            
    <div style="padding: 10px;"> 
     <img style="float: left;" alt="credits" src="<?php echo PATH; ?>/web-gallery/v2/images/newcredits/credit_in_white_bg.png" />   
     <span class="habboclub-offerprice">150</span>       
     <a class="new-button oversize" style="position: relative; left: 4px; top: 5px; margin-left: 0px" id="subscribe1" href="#" onclick='habboclub.buttonClick(3, "Conferma sottoscrizione"); return false;'><b>Acquista</b><i></i></a>
 
    </div> 
   </div> 
  
       
     <div class="cbb habboclub-buyentry hcvip"> 
     
      <h2 class="title" style="background-color: #969696;">      
        <img style="float: left;" alt="vip" src="<?php echo PATH; ?>/web-gallery/v2/images/habboclub_vip_small.png" /> 
        3 mesi 
      </h2> 
            
    <div style="padding: 10px;"> 
     <img style="float: left;" alt="credits" src="<?php echo PATH; ?>/web-gallery/v2/images/newcredits/credit_in_white_bg.png" />   
<span class="habboclub-offerprice">400</span>        
<a class="new-button oversize" style="position: relative; left: 4px; top: 5px; margin-left: 0px" id="subscribe3" href="#" onclick='habboclub.buttonClick(4, "Conferma sottoscrizione"); return false;'><b>Acquista</b><i></i></a>

</div> 
</div> 

</div> 

</form> 
</div>    </div> 
</div> 


<?php } ?>	
					</div> 
				</div> 
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
			 
 
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix hcred "> 
	
							<h2 class="title">Confronta i Benefici
							</h2> 
						<div id="habboclub-info" class="box-content" style="position: relative; top: 3px; left: -11px"> 
 <table cellspacing="0" cellpadding="0"> 
  <tr> 
   <td valign="top"> 
  <div class="cbb hcnone habboclub-infoentry" style="height: 214px;"> 
   <h2 class="title" style="height: 53px; background-color: #90a7b7;"> 
    <span style="position: relative; top: 18px; font-weight: bold">GRATIS</span> 
   </h2> 
   <div style="height: 3px"></div> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Look di base
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/clothes_b.png" /> 
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 83px;"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Colori di base
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/colors_b.png" /> 
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 101px;"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Look a 2 colori che puoi combinare a tuo gusto
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/multicolor_b.png" /> 
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 185px;">   
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    200 Amici in Lista
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/friends_b.png" /> 
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 136px;">   
  </div>  
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 75px;">   
   <div class="rounded" style="background-color: #ffffff;"> 
    12 modelli di Stanze
   </div> 
  </div> 
  
  <div class="cbb hcnone habboclub-infoentry" style="height: 65px;">   
  </div>  
  
  <div class="cbb hcnone habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;"> 
    1 Ballo
   </div> 
  </div>  
  
  <div class="cbb hcnone habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;"> 
    Offerte del Mercatino
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/coin_offers.png" /> 
   <div style="position: relative; top: 13px; left: -2px"> 
    = 5 Offerte
   </div> 
  </div>  
  
  </td><td valign="top"> 
  
  <div class="cbb hcbasic habboclub-infoentry"> 
   <h2 class="title" style="height: 53px; background-color: #9b9448;"> 
    <img style="position: relative; top: 5px" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/habboclub_basic_big.png" /> 
   </h2> 
   <div style="height: 3px"></div> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Look HC
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/clothes_hc.png" /> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry" style="height: 83px;"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Colori HC
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/colors_hc.png" /> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry" style="height: 101px;"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Look a 2 colori che puoi combinare a tuo gusto
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/multicolor_hc.png" /> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Guardaroba per 5 Look
   </div> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry" style="height: 135px;"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    1 Furni HC in Regalo al mese direttamente da un'esclusiva collezione
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/furni_hc.png" /> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    600 Amici in Lista
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/friends_hc.png" /> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Distintivo HC
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/badge_hc.png" /> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry" > 
   <div class="rounded" style="background-color: #ffffff;"> 
    Coda Club per le Stanze
   </div> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry" style="height: 75px;">   
   <div class="rounded" style="background-color: #ffffff;"> 
    + 8 modelli di Stanze HC
   </div> 
   <div style="padding: 10px">Stanze con Scale</div> 
  </div>  
  
  <div class="cbb hcbasic habboclub-infoentry">   
   <div class="rounded" style="background-color: #ffffff;"> 
    Comandi Chat
   </div> 
   <div style="padding: 5px;"> 
    <b>:furni</b> - Seleziona Furni<br/> 
    <b>:chooser</b> - Seleziona Utenti
   </div> 
  </div> 
  
  <div class="cbb hcbasic habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;"> 
    4 Balli HC
   </div> 
  </div>   
  
  <div class="cbb hcbasic habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;"> 
    Offerte del Mercatino
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/coin_offers.png" /> 
   <div style="position: relative; top: 13px; left: -2px"> 
    = 5 Offerte
   </div> 
  </div>   
  
  </td><td valign="top"> 
 
  <div class="cbb hcvip habboclub-infoentry"> 
   <h2 class="title" style="height: 53px; background-color: #969696;"> 
    <img style="position: relative; top: 5px" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/habboclub_vip_big.png" /> 
   </h2> 
   <div style="height: 3px"></div> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Look HC + VIP
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/clothes_vip.png" /> 
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Colori HC + VIP
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/colors_vip.png" /> 
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry" style="height: 101px;"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Look a 2 colori che puoi combinare a tuo gusto
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/multicolor.png" /> 
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry" > 
   <div class="rounded" style="background-color: #ffffff;"> 
    Guardaroba per 10 Look
   </div> 
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    2 Furni VIP in Regalo al mese direttamente da un'esclusiva collezione HC + VIP
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/furni_vip.png" /> 
  </div> 
  
   <div class="cbb hcvip habboclub-infoentry"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    900 Amici in Lista
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/friends_vip.png" /> 
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry"> 
   <div class="rounded" style="background-color: #ffffff;"> 
    Distintivo HC + VIP
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/badge_vip.png" /> 
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry" > 
   <div class="rounded" style="background-color: #ffffff;"> 
    Coda Club per le Stanze
   </div> 
  </div> 
  
  <div class="cbb hcvip habboclub-infoentry">   
   <div class="rounded" style="background-color: #ffffff;"> 
    8 Modelli di Stanze HC + 6 VIP
   </div> 
   <div style="padding: 10px"> 
     Stanze con Scale<br/> 
     Stanze senza Pareti
   </div> 
  </div>   
  
  <div class="cbb hcvip habboclub-infoentry">   
   <div class="rounded" style="background-color: #ffffff;"> 
    Comandi Chat
   </div> 
   <div style="padding: 5px;"> 
    <b>:furni</b> - Seleziona Furni<br/> 
    <b>:chooser</b> - Seleziona Utenti
   </div> 
  </div>   
  
  <div class="cbb hcvip habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;"> 
    4 Balli HC
   </div> 
  </div>  
  
  <div class="cbb hcvip habboclub-infoentry" >   
   <div class="rounded" style="background-color: #ffffff;"> 
    Offerte del Mercatino
   </div> 
   <img style="float: left; padding: 10px;" alt="xx" src="<?php echo PATH; ?>/web-gallery/v2/images/newhc/coin_offers.png" /> 
   <div style="position: relative; top: 13px; left: -2px"> 
    = 10 Offerte
   </div> 
  </div>  
  
   </td> 
  </tr> 
 </table> 
</div> 
	
						
					</div> 
				</div> 
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
			 
 
</div> 

<?php require_once('templates/footer.php'); ?>