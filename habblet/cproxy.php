<?php
require_once "../core.php";

$hid = '';

if (isset($_GET['habbletKey']))
{
	$hid = $_GET['habbletKey'];
}

switch (strtolower($hid)){
	case "minimail":
	?>
	<div id="minimail" class="client-habblet-container contains-minimail draggable" style="z-index: 0; left: -119px; top: 56px;">
<div class="habblet-container ">		
		<div class="cb clearfix blue "><div class="bt"><div></div></div><div class="i1"><div class="i2"><div class="i3">
		<div class="rounded-container"><div style="background-color: rgb(255, 255, 255);"><div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(111, 153, 196);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(53, 113, 173);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div></div></div></div><div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(53, 113, 173);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div></div></div><div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(111, 153, 196);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div></div><div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(53, 113, 173);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div></div></div><h2 class="title rounded-done">Minimail
		<span class="habblet-close"></span></h2><div style="background-color: rgb(255, 255, 255);"><div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(53, 113, 173);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div></div><div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(111, 153, 196);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div></div><div style="margin: 0px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(53, 113, 173);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div></div></div><div style="margin: 0px 1px; height: 1px; overflow: hidden; background-color: rgb(255, 255, 255);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(111, 153, 196);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(53, 113, 173);"><div style="height: 1px; overflow: hidden; margin: 0px 1px; background-color: rgb(39, 103, 167);"></div></div></div></div></div></div>


	
	<div id="minimail-container">
    <div class="minimail-contents">
<div class="clearfix labels nostandard">
    <ul class="box-tabs">
        <li class="selected"><a href="#" label="inbox">Ricevuti</a><span class="tab-spacer"></span></li>
        <li><a href="#" label="sent">Inviati</a><span class="tab-spacer"></span></li>
        <li><a href="#" label="trash">Cestino</a><span class="tab-spacer"></span></li>
    </ul>
</div>


<div id="message-list" class="label-inbox">
<div class="new-buttons clearfix">
	<div class="labels inbox-refresh"><a href="#" class="new-button green-button" label="inbox" style="float: left; margin: 0"><b>Controlla i nuovi messaggi!</b><i></i></a></div>
</div>
<div style="clear: both; height: 1px"></div>

<div class="navigation">
    <div class="unread-selector"><input type="checkbox" class="unread-only"> Mostra solo messaggi non letti</div>
</div>


	<p class="no-messages">
	       Nessun messaggio	   
	</p>

</div></div>
	<div id="message-compose-wait"></div>
    <form style="display: none;" id="message-compose">
        <div>A</div>
        <div id="message-recipients-container" class="input-text" style="width: 426px; margin-bottom: 1em">
        	<input type="text" value="" id="message-recipients">
        	<div class="autocomplete" id="message-recipients-auto">
        		<div class="default" style="display: none;">Digita il nome del tuo Amico</div>
        		<ul class="feed" style="display: none;"></ul>
        	</div>
        </div>
        <div>Oggetto<br>
        <input type="text" style="margin: 5px 0" id="message-subject" class="message-text" maxlength="100" tabindex="2">
        </div>
        <div>Messaggio<br>
        <textarea style="margin: 5px 0" rows="5" cols="10" id="message-body" class="message-text" tabindex="3"></textarea>
        </div>
        <div class="new-buttons clearfix">
            <a href="#" class="new-button preview"><b>Anteprima</b><i></i></a>
            <a href="#" class="new-button send"><b>Invia</b><i></i></a>
        </div>
    </form>	
</div>

	
	</div></div></div><div class="bb"><div></div></div></div>
</div>

<!-- dependencies
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/v2/styles/minimail.css" type="text/css" />
-->
</div>
	<?php
	break;
	case "news":
	?>
	<div class="habblet-container ">		
	
	<div id="news-habblet-container">
	
		<div class="title">
		
			<div class="habblet-close"></div>
			
		</div>
		
		<div class="content-container">
		
			<div id="news-articles">
			
				<ul id="news-articlelist" class="articlelist">
				<?php
				
				$getNews = mysql_query("SELECT * FROM cms_news ORDER BY id DESC LIMIT 10");
				$i=0;
				while ($n = mysql_fetch_assoc($getNews)){
					$n['title_safe'] = $input->stringToURL($input->HoloText($n['title'],true),true,true);
					
					if ($input->IsEven($i))
						$oddEven = "even";
					else
						$oddEven = "odd";
			
					echo '<li class="' . $oddEven . '">
					
					  <div class="news-title">' . $n['title'] . '</div>
					  <div class="news-summary">' . $n['shortstory'] . '</div>
					  <div class="newsitem-date">' . date('d/m/Y', $n['date']) . '</div>
					  
					  <div class="clearfix">
					  
						<a href="'.PATH.'articles/'.$n['id'].'-'.$n['title_safe'].'" target="_blank" class="article-toggle">Leggi articolo</a>
						
					  </div>
					  
					</li>';
				}
					
				?>
				</ul>
				
			</div>
			
		</div>
		
		<div class="news-footer"></div>
	
	</div>

	<script type="text/javascript">    
		L10N.put("news.promo.readmore", "Leggi tutto").put("news.promo.close", "Chiudi articolo");
		News.init(false);
	</script>

</div>
<!-- dependencies
<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/v2/styles/news.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/news.js" type="text/javascript"></script>
-->
		<?php
		
		break;
}
	
?>