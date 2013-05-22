<div class="habblet-container news-promo">
	<div class="cbb clearfix notitle ">
<?php
$sql = mysql_query("SELECT * FROM cms_news ORDER BY date DESC LIMIT 5");
$i = 0;
while($row = mysql_fetch_assoc($sql)){
	$row['summary'] = nl2br($input->HoloText($row['shortstory'], true));
	$row['title'] = $input->HoloText($row['title'], true);
	$row['title_safe'] = $input->stringToURL($input->HoloText($row['title'],true),true,true);
	$row['date'] = date('M j, Y', $row['date']);
	$news[$i] = $row;
	$i++;
}
?>
						<div id="newspromo">
        <div id="topstories">
	        <div class="topstory" style="background-image: url(<?php echo $news[0]['image']; ?>)">
	            <h4>ULTIME NEWS</a></h4>
	            <h3><a href="<?php echo PATH."articles/".$news[0]['id']."-".$news[0]['title_safe']; ?>"><?php echo $news[0]['title']; ?></a></h3>
	            <p class="summary">
	            <?php echo $news[0]['summary']; ?>
	            </p>
	            <p>
	                <a href="<?php echo PATH."articles/".$news[0]['id']."-".$news[0]['title_safe']; ?>">Leggi &raquo;</a>
	            </p>
	        </div>
	        <div class="topstory" style="background-image: url(<?php echo $news[1]['image']; ?>); display: none">
	            <h4>ULTIME NEWS</a></h4>
	            <h3><a href="<?php echo PATH."articles/".$news[1]['id']."-".$news[1]['title_safe']; ?>"><?php echo $news[1]['title']; ?></a></h3>
	            <p class="summary">
	            <?php echo $news[1]['summary']; ?>
	            </p>
	            <p>
	                <a href="<?php echo PATH."articles/".$news[1]['id']."-".$news[1]['title_safe']; ?>">Leggi &raquo;</a>
	            </p>
	        </div>
	        <div class="topstory" style="background-image: url(<?php echo $news[2]['image']; ?>); display: none">
	            <h4>ULTIME NEWS</a></h4>
	            <h3><a href="<?php echo PATH."articles/".$news[2]['id']."-".$news[2]['title_safe']; ?>"><?php echo $news[2]['title']; ?></a></h3>
	            <p class="summary">
	            <?php echo $news[2]['summary']; ?>
	            </p>
	            <p>
	                <a href="<?php echo PATH."articles/".$news[2]['id']."-".$news[2]['title_safe']; ?>">Leggi &raquo;</a>
	            </p>
	        </div>
            <div id="topstories-nav" style="display: none"><a href="#" class="prev">Indietro</a><span>1</span> / 3<a href="#" class="next">Avanti</a></div>
        </div>
        <ul class="widelist">
            <li class="even">
                <a href="<?php echo PATH."articles/".$news[3]['id']."-".$news[3]['title_safe']; ?>"><?php echo $news[3]['title']; ?></a><div class="newsitem-date"><?php echo $news[3]['date']; ?></div>
            </li>
            <li class="odd">
                <a href="<?php echo PATH."articles/".$news[4]['id']."-".$news[4]['title_safe']; ?>"><?php echo $news[4]['title']; ?></a><div class="newsitem-date"><?php echo $news[3]['date']; ?></div>
            </li>
            <li class="last"><a href="<?php echo PATH; ?>articles">Altre news &raquo;</a></li>
        </ul>
</div>
<script type="text/javascript">
	document.observe("dom:loaded", function() { NewsPromo.init(); });
</script>
					</div>

				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
