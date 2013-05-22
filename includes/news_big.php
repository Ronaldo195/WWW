<link rel="stylesheet" href="<?php echo PATH; ?>web-gallery/static/styles/lightweightmepage.css" type="text/css" />
<script src="<?php echo PATH; ?>web-gallery/static/js/lightweightmepage.js" type="text/javascript"></script>

<div id="promo-box">

    <div id="promo-bullets"></div>

<?php
$sql = mysql_query("SELECT * FROM cms_news_slider ORDER BY id DESC LIMIT 5");
$i = 0;

while($news = mysql_fetch_assoc($sql)){
$i++;
?>
    <div class="promo-container" style="background-image: url(<?php echo $news['image'].")".($i > 1 ? ";display: none" : ""); ?>">
        <div class="promo-content-container">
            <div class="promo-content">
                <div class="title"><?php echo $news['title']; ?></div>
                <div class="body"><?php echo $news['shortstory']; ?></div>
            </div>
        </div>

		<div class="promo-link-container">
			<div class="enter-hotel-btn">
				<div class="open enter-btn">
					<?php
					if($news['button_enable'] == "1")
						echo '<a style="padding: 0 8px 0 18px;" target="_blank" href="'.$news['link_button'].'">'.$news['button_title'].'</a><b></b>';
					?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

</div>

<script type="text/javascript">document.observe("dom:loaded", function() { PromoSlideShow.init(); });</script>