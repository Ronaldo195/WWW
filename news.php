<?php
/*=======================================================+
|| # HoloCMS - Website and Content Management System
|+=======================================================+
|| # Copyright © 2013 DnT [Tutti i diritti riservati]
|| # http://dnt.webnet32.com/
|+=======================================================+
|| # DnT HoloCMS v3 - Created By Donatello (DnT)
|| # http://code.google.com/p/dnt-project/downloads/list
|+=======================================================*/


$allow_guests = true;

include('core.php');
include('includes/session.php');

$body_id = "news";
$pageid = "4";
//$id = $input->FilterText($_GET['id']);
//yaya

if($input->FilterText($_GET['id'])){
        $news_id = $input->FilterText($_GET['id']);
        $main_sql = mysql_query("SELECT * FROM cms_news_slider WHERE id = '".$news_id."'") or die(mysql_error());
        $article_exists = mysql_num_rows($main_sql);
	if($article_exists == "1"){
                $news = mysql_fetch_assoc($main_sql);
                $pagename = "News - " . stripslashes($news['title']);
                $archive = "0";
	} else {
                $pagename = "Articolo inesistente!";
                $archive = "1";
	}

      
} else {
        $pagename = "News";
        $archive = "1";
}

include('templates/subheader.php');
include('templates/header.php');

?>


<?php
function FilterNew($str, $news_id)
{
	$str = str_replace("à", "&agrave;",($str));
	$str = str_replace('\r\n', '', ($str));
	$str = str_replace('\"', '', ($str));
	$str = str_replace("è", "&egrave;",($str));
	$str = str_replace("ì", "&igrave;",($str));
	$str = str_replace("ò", "&ograve;",($str));
	$str = str_replace("ù", "&ugrave;",($str));

	
	return $str;
}
?>

<div id="container">
	<div id="content">
    <div id="column1" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix default ">

							<h2 class="title">News
							</h2>
						<div id="article-archive">



<h2>Tutte le News</h2>
<ul>
	<li>
<?php
	$get_sub_archive = mysql_query("SELECT id, title, date FROM cms_news_slider ORDER BY id DESC LIMIT 50");
	$count = mysql_num_rows($get_sub_archive);

	if($count > 0){
		while ($row = mysql_fetch_array($get_sub_archive, MYSQL_NUM)) {
			printf("<li><a href='news?id=%s'>%s</a> &raquo;</li>", $row[0], $input->HoloText($row[1]));
		}
	} else {
		echo "<br />No headlines to display yet.";
	}
	?>
</li>
</ul>

</div>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

</div>
<div id="column2" class="column">
				<div class="habblet-container ">
						<div class="cbb clearfix notitle ">

<?php if($archive < 1){ ?>
						<div id="article-wrapper">
	<h2><?php echo stripslashes($news['title']); ?></h2>
	<div class="article-meta">Postata il <?php echo $news['date']; ?> da <a href='user_profile?name=<?php echo $news['author']; ?>'./online.gif' border='0'><?php echo $news['author']; ?></a>

</div>
	<p class="summary"><?php echo $news['shortstory']; ?></p>


	    <div class="article-body">





			</div>

	</div>
</div>
<?php } elseif($archive == "1"){ ?>
<div id="article-wrapper">

				<h2>Articolo inesistente</h2>
	<div class="article-meta" style="height: 1px">&nbsp;</div>
	Clicca su uno degli articoli qui a sinistra per leggerlo!
</div>

<?php } ?>



					</div>
				</div>


</div>

<div id="column3" class="column">
</div>

<?php

include('templates/footer.php');

?>