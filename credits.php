<?php

$allow_guests = true; 

include('core.php'); 
include('includes/session.php'); 

$user->Refresh($user->row['username']);

$pagename = "Crediti"; 
$pageid = 6; 
$body_id = "home"; 

include('templates/subheader.php'); 
include('templates/header.php'); 

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<title><?php echo $site['short'] ?>: Crediti </title> 
 

 
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/cbs2credits.css" type="text/css" />
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/newcredits.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/cbs2credits.js" type="text/javascript"></script>
<!--[if IE 8]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/49_81fe7a2068e0c3abfa3d081776b673b8/16/web-gallery/v2/styles/ie8.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 8]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/49_81fe7a2068e0c3abfa3d081776b673b8/16/web-gallery/v2/styles/ie.css" type="text/css" />
<![endif]--> 
<!--[if lt IE 7]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/49_81fe7a2068e0c3abfa3d081776b673b8/16/web-gallery/v2/styles/ie6.css" type="text/css" />
<script src="http://images.habbo.com/habboweb/49_81fe7a2068e0c3abfa3d081776b673b8/16/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
 
<meta name="description" content="Habbo Hotel: amici, divertimento, celebrità!" />
<meta name="keywords" content="habbo hotel, virtuale, mondo, social network, gratis, community, avatar, personaggio, chat, online, giovane, ragazzi, gioco di ruolo, giochi di ruolo, iscriviti, social, gruppi, forum, sicurezza, giocare, giochi, online, amici, giovani, rari, furni rari, collezione, creare, collezionare, connettersi, furni, mobili, cuccioli, animali, creazione stanze, condivisione, espressione, distintivi, badge, uscire, musica, VIP, celebrità, visite VIP, famosi, mmo, mmorpg, multiplayer" />
 
 
 
<!--[if IE 8]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/657/web-gallery/static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/657/web-gallery/static/styles/ie.css" type="text/css" />
<![endif]-->

<!--[if lt IE 7]>
<link rel="stylesheet" href="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/657/web-gallery/static/styles/ie6.css" type="text/css" />
<script src="http://images.habbo.com/habboweb/63_1dc60c6d6ea6e089c6893ab4e0541ee0/657/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>
 
<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]--> 
<meta name="build" content="49-BUILD74 - 27.04.2010 10:59 - it" /> 
</head> 
<body id="newcredits" class="anonymous "> 
 
<div id="content-container"> 
 
<div id="container"> 
	<div id="content" style="position: relative" class="clearfix"> 
    <div id="column1" class="column"> 
			     		
				<div class="habblet-container " style=" width: 770px">		
						<div class="cbb clearfix orange " style=" width: 760px">
	
							<h2 class="title">Acquista <?php echo $site['short'] ?> Crediti!
							</h2> 
							<script src="<?php echo PATH; ?>web-gallery/static/js/credits.js" type="text/javascript"></script>

						<div class="method-group online clearfix"> 
<div class="method idx0 nosmallprint"
        > 
    <div class="method-content"> 
        <h2>Titolo</h2> 
 
        <div class="summary clearfix"> 
             
          <div>    
Contenuto.

</div>

<br><br>

            <center><a href="promozioni.php" onclick="return submitCreditForm($(this).up('form'), 'online', '627', '');" class="large-button large-green-button"><span><b>Continua</b></span><i></i></a> </center>
        </div> 
    </div> 
 
<style type="text/css">

#header h1 span{text-indent:-10000px;float:left;width:111px;height:42px;border:0;background-repeat:no-repeat;background-image:url(.../web-gallery/v2/images/habbo.png)}

</style>
 
        
</div> 
</div> 
<div class="method-group phone clearfix"> 
<div class="method idx0 m-ivrit"
        > 
    <div class="method-content"> 
        <h2>Metodo Box 1#</h2> 
 
        <div class="summary clearfix"> 
			<ol>
				Descrizione Box 1#
			</ol>
        </div> 
    </div> 
 
       
 
            <div class="smallprint"> 
                Descrizione 2 Box 1#
<br/><br/> 
            </div> 
        
</div> 
<div class="method idx1"> 
    <div class="method-content"> 
        <h2>Metodo 2 Box 2#</h2> 
 
        <div class="summary clearfix"> 
            
            <ol> 
			Descrizione Metodo 2#
			</ol>      
        </div> 
    </div> 
            <div class="smallprint"> 
                Descrizione 2 Metodo 2# 
            </div> 
        
</div> 
</div> 
<div class="method-group other clearfix"> 
        <div class="method idx0"> 
            <div class="method-content"> 
                <h2></h2> 
 
            </div> 
        </div> 
 
        <div class="method idx1"> 
            <div class="method-content"> 
                <div>&nbsp;</div> 
            </div> 
        </div> 
</div> 
 
<script type="text/javascript"> 
document.observe("dom:loaded", function() { new CreditsList(); });
</script> 
 
 
 

										<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 

							
					</div> 
							
					<?php if($logged_in){ ?>
						<div class="habblet-container ">		
						<div class="cbb clearfix darkgray ">
	
							
						<div id="redeem-habblet">
    <div class="redeem-balance">
        <p class="redeem-balance-username"><?php echo $user->row['username']; ?></p>
        <p class="redeem-balance-text">Saldo</p>
        <p><span class="redeem-balance-amount"><?php echo $user->row['credits']; ?></span></p>
    </div>

    <div class="redeem-redeeming-text"><p class="redeeming-text">Inserisci il tuo codice</p></div>

    <div class="redeem-form-container clearfix">
        <form method="post" action="" id="voucher-form">
<div class="redeem-redeeming">
    <div><input type="text" name="voucherCode" value="" class="redeemcode" size="8" /></div>

    <div class="redeem-redeeming-button"><a href="#" class="new-button green-button redeem-submit exclude"><b><span></span>Converti</b><i></i></a></div>
    
</div>
        </form>
    </div>
</div>

<script type="text/javascript">
document.observe("dom:loaded", function() { new NewRedeemHabblet(); });
</script>

						
							
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			  
			<?php } ?>
						<div class="habblet-container ">
							<div class="ad-container">&nbsp;</div>
						</div> 
							<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
			 
 
</div> 
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]--> 
    </div>
	</div> 
 
</div> 
 
 
 
<script src="http://www.google-analytics.com/ga.js" type="text/javascript"></script> 
<script type="text/javascript"> 
var pageTracker = _gat._getTracker("UA-448325-20");
pageTracker._trackPageview();
</script> 
    
    <script type="text/javascript"> 
if (window.location.href.indexOf("/register/welcome") != -1) {
        <!-- Google Code for Registration Conversion Page HL-14188 BEGIN -->
        var google_conversion_id = 1042363710;
        var google_conversion_language = "it";
        var google_conversion_format = "2";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "u3yICManSBC-6oTxAw";
 
        document.write('<' + '<script language="JavaScript" type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">' +        '>' + '</' + 'script' + '>');
        <!-- Google Code for signup Conversion Page HL-14188 END -->
 
}
</script> 
 
<!-- Start Quantcast tag --> 
<script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script> 
<script type="text/javascript">_qacct="p-b5UDx6EsiRfMI";quantserve();</script> 
<noscript> 
<a href="http://www.quantcast.com/p-b5UDx6EsiRfMI" target="_blank"><img src="http://pixel.quantserve.com/pixel/p-b5UDx6EsiRfMI.gif" style="display: none" border="0" height="1" width="1" alt="Quantcast"/></a> 
</noscript> 
<!-- End Quantcast tag --> 
    
    
<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script> 
<?php 

include('templates/footer.php'); 

?>
</body> 
</html> 