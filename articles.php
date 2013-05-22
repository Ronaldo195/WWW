<?php

$allow_guests = true;
require_once('core.php');
require_once('includes/session.php');

$id = isset($_GET['id']) ? $input->FilterText($_GET['id']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$category = $input->stringToURL($input->HoloText($category,true),true,false);
$archive = isset($_GET['archive']) ? $_GET['archive'] : '';
$pagenum = isset($_GET['pageNumber']) ? $_GET['pageNumber'] : '';
if($pagenum == ''){ $pagenum = 1; }
$add = "";
if($category != ''){ $add = "WHERE categories LIKE '%".$category."%'"; }
if($id == ''){ $id = mysql_result(mysql_query("SELECT MAX(id) AS count FROM cms_news ".$add." LIMIT 1"),0); }

$sql = mysql_query("SELECT * FROM cms_news WHERE id = '".$id."' LIMIT 1");
$news_row = '';
if(mysql_num_rows($sql) > 0){
	$news_row = mysql_fetch_assoc($sql);
	foreach ($news_row as $value) {
		$value = $input->HoloText($value);
	}
}
	
$pageid = ($category == 'eventi' || $category == 'competizioni') ? $category : "news";
$body_id = "news";

if($news_row != ''){
	$pagename = $news_row['title'];
	$pagedesc = $news_row['shortstory'];
}

if(isset($_POST['comment'])){
	$comment = $input->FilterText($_POST['comment']);
	$query = mysql_query("INSERT INTO cms_news_comments (article,userid,comment,posted_on) VALUES ('".$news_row['id']."','".$user->row['id']."','".$comment."','".time()."')");
	echo "<script>alert('Commento inserito correttamente!');</script>";
}

require_once('templates/subheader.php');
require_once('templates/header.php');
?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
    <div id="column1" class="column">
			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix default ">

	
							<h2 class="title">Articoli
							</h2>
						<div id="article-archive">
<?php 
if($archive == true){
$count = mysql_result(mysql_query("SELECT COUNT(*) FROM cms_news"),0);
$pages = ceil($count / 20);
?>
<div id="article-paging" class="clearfix">
        <?php if(($pagenum + 1) <= $pages){ ?><a href="<?php echo PATH; ?>articles/archive?pageNumber=<?php echo $pagenum + 1; ?>" class="older">&lt;&lt; Meno recenti</a><?php } ?>
        <?php if(($pagenum - 1) > 0){ ?><a href="<?php echo PATH; ?>articles/archive?pageNumber=<?php echo $pagenum - 1; ?>" class="newer">Pi&ugrave; recenti &gt;&gt;</a><?php } ?>
</div>
<?php } ?>
<?php
if($category == '' && $archive == ''){
$time['stop'] = time() - 60*60*24;
$sql = mysql_query("SELECT * FROM cms_news WHERE date > ".$time['stop']." ORDER BY id DESC"); 
if(mysql_num_rows($sql) > 0){ ?>
<h2>Oggi</h2>
<ul>

<?php while($row = mysql_fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>
		<a href="<?php echo PATH; ?>articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
$time['start'] = time() - 60*60*24;
$time['stop'] = time() - 60*60*24*2;
$sql = mysql_query("SELECT * FROM cms_news WHERE date < ".$time['start']." AND date > ".$time['stop']." ORDER BY id DESC"); 
if(mysql_num_rows($sql) > 0){ ?>
<h2>Ieri</h2>
<ul>

<?php while($row = mysql_fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
$time['start'] = time() - 60*60*24*2;
$time['stop'] = time() - 60*60*24*7;
$sql = mysql_query("SELECT * FROM cms_news WHERE date < ".$time['start']." AND date > ".$time['stop']." ORDER BY id DESC"); 
if(mysql_num_rows($sql) > 0){ ?>
<h2>Questa settimana</h2>
<ul>

<?php while($row = mysql_fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
$time['start'] = time() - 60*60*24*7;
$time['stop'] = time() - 60*60*24*14;
$sql = mysql_query("SELECT * FROM cms_news WHERE date < ".$time['start']." AND date > ".$time['stop']." ORDER BY id DESC"); 
if(mysql_num_rows($sql) > 0){ ?>
<h2>La settimana scorsa</h2>
<ul>

<?php while($row = mysql_fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
$time['start'] = time() - 60*60*24*14;
$time['stop'] = time() - 60*60*24*30;
$sql = mysql_query("SELECT * FROM cms_news WHERE date < ".$time['start']." AND date > ".$time['stop']." ORDER BY id DESC"); 
if(mysql_num_rows($sql) > 0){ ?>
<h2>Questo mese</h2>
<ul>

<?php while($row = mysql_fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>articles/<?php echo $row['id']."-".$row['title_safe']; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }
}elseif($archive == true && $category == ''){ ?>
<h2>Archivio news</h2>
<ul>

<?php
$sql = "SELECT * FROM cms_news ORDER BY date DESC LIMIT 20";
if($pagenum > 1){ $sql = $sql." OFFSET ".($pagenum - 1) * 20; }
$sql = mysql_query($sql);
while($row = mysql_fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>articles/<?php echo $row['id']."-".$row['title_safe']; ?>/in/archive<?php if($pagenum > 1){ echo $pagenum; } ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php }elseif($category != ''){ ?>
<h2>Categoria</h2>
<ul>

<?php
$sql = mysql_query("SELECT * FROM cms_news WHERE categories LIKE '%".$category."%'");
while($row = mysql_fetch_assoc($sql)){ $row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true); ?>
	<li>		
		<a href="<?php echo PATH; ?>articles/<?php echo $row['id']."-".$row['title_safe']; ?>/in/category/<?php echo $category; ?>" class="article-<?php echo $row['id']; ?>"><?php echo stripslashes($row['title']); ?>&nbsp;&raquo;</a>
	</li>
	
<?php } ?>

</ul>
<?php } ?>

<a href="<?php echo PATH; ?>articles/archive">Altre news &raquo;</a>
</div>
	
						
					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 

</div>
<div id="column2" class="column">

			     		
				<div class="habblet-container ">		
						<div class="cbb clearfix notitle ">
	
							<?php
							if($news_row == ''){
							?>
							<div id="article-wrapper">
	<h2>Articolo non esistente</h2>
	<div class="article-meta"></div>
	
	<img src="<?php echo PATH; ?>web-gallery/images/frank/sorry.gif" class="article-image"/>
	
	<p class="summary">Articolo non esistente</p>
	
	<div class="article-body">
<p>Articolo non esistente</p>
<div class="article-author">- Lo staff di <?php echo $site['short']; ?></div>

	<script type="text/javascript" language="Javascript">
		document.observe("dom:loaded", function() {
			$$('.article-images a').each(function(a) {
				Event.observe(a, 'click', function(e) {
					Event.stop(e);
					Overlay.lightbox(a.href, "Sto caricando l'immagine");
				});
			});
			
			$$('a.article-0').each(function(a) {
				a.replace(a.innerHTML);
			});
		});
	</script>
	</div>
</div>
							<?php }else{ ?>
						<div id="article-wrapper">
	<h2><?php echo $news_row['title']; ?></h2>
	<div class="article-meta"><?php echo "Pubblicato il ".date('M j, Y',$news_row['date']); ?> 
	<?php $categories = explode(",",$news_row['categories']); $output = ""; foreach($categories as &$value){ $output = $output."<a href=\"".PATH."articles/category/".$input->stringToURL($input->HoloText($value,true),true,true)."\">".$value."</a>, "; } $output = substr_replace($output,"",-2); ?>
		<?php echo $output; ?>
		
		<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4b966b9f4c113b29"><img src="http://s7.addthis.com/static/btn/v2/lg-share-it.gif" width="125" height="16" alt="Bookmark and Share" style="border:0" align="right"/></a>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4b966b9f4c113b29"></script>
	</div>
	
	<?php $images = explode(",",$news_row['images']); if(!empty($images[0])){ ?>
			<img src="<?php echo $images[0]; ?>" class="article-image"/>
	<?php } ?>
	<p class="summary"><?php echo nl2br($news_row['shortstory']); ?></p>
	
	<div class="article-body">
<p><?php echo nl2br($news_row['longstory']); ?></p>
<div class="article-author">- <?php echo $news_row['author']; ?></div>
	
<?php if(count($images) > 1){ unset($images[0]); $output = ""; foreach($images as $value){ $output = $output."<a href=\"".$value."\" style=\"background-image: url(".$value."); background-position: -20px -20px\"></a>\n"; } ?>
	<div class="article-images clearfix">
	
		<?php echo $output; ?>
	
	</div>
<?php } ?>

	<script type="text/javascript" language="Javascript">
		document.observe("dom:loaded", function() {
			$$('.article-images a').each(function(a) {
				Event.observe(a, 'click', function(e) {
					Event.stop(e);
					Overlay.lightbox(a.href, "Sto caricando l'immagine");
				});
			});
			
			$$('a.article-<?php echo $news_row['id']; ?>').each(function(a) {
				a.replace(a.innerHTML);
			});
		});
	</script>
	</div>
</div>
<?php
}
?>
							
						
					</div>
				</div>

				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
			 
<?php if($logged_in == true && $news_row['id'] > 0){ ?>
<table border="0" width="552" id="table1" cellspacing="0" cellpadding="0"> 
	<tr> 
		<td height="20" background="<?php echo PATH; ?>web-gallery/v2/images/news_top.gif">&nbsp;</td> 
	</tr> 
	<tr> 
	<td background="<?php echo PATH; ?>/web-gallery/v2/images/news_middle.gif" align="center"> 
	<form name="newscomment" id="newscomment" method="post" action="">
		<textarea name="comment" cols="80" rows="5" style="resize: vertical;" placeholder="Inserisci un tuo Commento!"></textarea><br>
			<div style="margin-right: 17px; margin-top: 5px;">
				<a style="margin-right: 5px;" class="new-button" href="javascript:document.newscomment.submit()"><b>Invia Commento</b><i></i></a>
			</div>
	</form>
	</td> 
	</tr> 
	<tr> 
		<td background="<?php echo PATH; ?>/web-gallery/v2/images/news_bottom2.gif" height="20">&nbsp;</td> 
	</tr> 
</table>
<br>
<?php
}

if($news_row['id'] > 0){
	// imposto quanti risultati x pagina
	$rowsPerPage = 5;
	// impostiamo di default di mostrare x prima la prima pagina
	$pageNum = 1;

	// se $_GET['page'] è definito, lo si usa come page namber
	if(isset($_GET['page']))
	{
		$pageNum = $_GET['page'];
	}

	// conto l' offset
	$offset = ($pageNum - 1) * $rowsPerPage;

	$query = "SELECT * FROM cms_news_comments WHERE article = '".$news_row['id']."' ORDER BY id ASC LIMIT $offset, $rowsPerPage";
	$result = mysql_query($query) or die();

	while($row = mysql_fetch_assoc($result))
	{
		$dati = mysql_query("SELECT * FROM users WHERE id = '".$row['userid']."'");
		$dati = mysql_fetch_assoc($dati);
		
		if($input->IsUserOnline($dati['id']) == true)
			$status = "habbo_online_anim.gif";
		else
			$status = "habbo_offline.gif";
			
		echo '
<table border="0" width="552" id="com-'.$row['id'].'" cellspacing="0" cellpadding="0"> 
	<tr> 
		<td height="20" background="'.PATH.'web-gallery/v2/images/news_top.gif">&nbsp;</td> 
	</tr> 
	<tr> 
		<td background="'.PATH.'web-gallery/v2/images/news_middle.gif" style="padding-right: 15px;" align="center" valign="top"> 
		<table border="0" width="100%" id="table3" cellspacing="0" cellpadding="0" height="30"> 
			<tr>
				<td width="20">&nbsp;</td> 
				<td valign="top">
				<img src="'.PATH.'web-gallery/images/myhabbo/'.$status.'" />
				<a href="'.PATH.'home/'.$dati['username'].'">'.$dati['username'].'</a></td> 
			</tr> 
		</table> 
		<table border="0" width="100%" id="table4" cellspacing="0" cellpadding="0"> 
			<tr> 
				<td width="20">&nbsp;</td> 
				<td>'.$row['comment'].'<br><br></td> 
			</tr> 
			<tr> 
				<td width="20">&nbsp;</td> 
				<td align="right"><i>'.date('d/m/Y H:i:s', $row['posted_on']).'</i>&nbsp;&nbsp;&nbsp;&nbsp;</td> 
			</tr> 
		</table> 
		</td> 
	</tr> 
	<tr> 
		<td background="'.PATH.'web-gallery/v2/images/news_bottom.gif" height="30">&nbsp;</td> 
	</tr> 
</table> 

 
<table border="0" width="552" id="table2" cellspacing="0" cellpadding="0"> 
	<tr> 
		<td><img src="http://www.habbo.com/habbo-imaging/avatarimage?figure='.$dati['look'].'&size=b&direction=2&head_direction=2&gesture=sml"><br>&nbsp;</td> 
		<td>&nbsp;</td> 
	</tr> 
</table> 
';
	}

	// quanti valori abbiamo nel DB
	$query   = "SELECT COUNT(*) AS numrows FROM cms_news_comments WHERE article = '".$news_row['id']."'";
	$result  = mysql_query($query) or die('Error, query failed');
	$row     = mysql_fetch_array($result, MYSQL_ASSOC);
	$numrows = $row['numrows'];

	// quante pagine sono?
	$maxPage = ceil($numrows/$rowsPerPage);
	
	// crea link per accedere ad ogni pagina
	$self = $_SERVER['PHP_SELF'];
	$nav  = '';
	for($page = 1; $page <= $maxPage; $page++)
	{
		if ($page == $pageNum)
		{
			$nav .= " $page "; 
		}
		else
		{
			$nav .= " <a href=\"$self?id=".$news_row['id']."&page=$page\">$page</a> ";
		}
	}

	// Creo i links Previous e Next
	// e quelli First page e Last page

	if ($pageNum > 1)
	{
		$page  = $pageNum - 1;
		$prev  = " <a href=\"$self?id=".$news_row['id']."&page=$page\">[Indietro]</a> ";
		$first = " <a href=\"$self?id=".$news_row['id']."&page=1\">[Primo]</a> ";
	}
	else
	{
		$prev  = '&nbsp;'; // se siamo nella 1° pag non mostriamo Prev
		$first = '&nbsp;'; // e neanche il link alla 1° pag
	}

	if ($pageNum < $maxPage)
	{
		$page = $pageNum + 1;
		$next = " <a href=\"$self?id=".$news_row['id']."&page=$page\">[Avanti]</a> ";
		$last = " <a href=\"$self?id=".$news_row['id']."&page=$maxPage\">[Ultimo]</a> ";
	}
	else
	{
		$next = '&nbsp;'; // siamo nell' ultima pag, nn mostriamo Next
		$last = '&nbsp;'; // siamo nell' ultima pag, nn mostriamo il link Last 
	}

	// mostra i links di navigazione
	if($numrows > 0 && $user->row['id'] != 0)
	{
		echo "<p style='text-align: right'>Pagina:<b>" . $first . $prev . $nav . $next . $last . "</b></p>";
	}
}
?>
</div>
<div id="column3" class="column">
	<?php include("templates/ads.php"); ?>
</div>
<script type="text/javascript">
HabboView.run();
</script>
<?php require_once('./templates/footer.php'); ?>
