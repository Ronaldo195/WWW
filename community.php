<?php
$allow_guests = true;

include('core.php');
include('includes/session.php');

$pagename = "Community";
$pageid = "com";

include('templates/subheader.php');
include('templates/header.php');

?>
<div id="container">
	<div id="content" style="position: relative" class="clearfix">
	
		<?php require_once('./includes/news_big.php'); ?>

		<div id="column1" class="column">
		
				<div class="habblet-container ">		
						<div class="cbb clearfix blue ">

<div class="box-tabs-container clearfix">
    <h2>Gruppi</h2>
    <ul class="box-tabs">
		<li id="tab-0-1-2"><a href="#">I gruppi del momento</a><span class="tab-spacer"></span></li>
        <li id="tab-0-1-1" class="selected"><a href="#">Argomenti recenti</a><span class="tab-spacer"></span></li>
    </ul>

</div>
    <div id="tab-0-1-1-content">
<ul class="active-discussions-toplist">
<?php
$i = 0;
$getem = mysql_query("SELECT * FROM cms_forum_threads ORDER BY unix DESC LIMIT 10") or die(mysql_error());

while ($row = mysql_fetch_assoc($getem)) {
    if($row['author'] != ""){
        $i++;

        if($input->IsEven($i)){
            $even = "even";
        } else {
            $even = "odd";
        }
		
		$posts = $input->mysql_evaluate("SELECT COUNT(*) FROM cms_forum_posts WHERE threadid = '".$row['id']."'");
		$pages = ceil($posts / 10);
		$pagelink = "<a href=\"".PATH."viewthread?thread=".$row['id']."\" class=\"topiclist-page-link secondary\">1</a>";
		if($pages > 4){
			$pageat = $pages - 2;
			$pagelink .= "\n...";
			while($pageat <= $pages){
				$pagelink .= " <a href=\"".PATH."viewthread?thread=".$row['id']."&page=".$pageat."\" class=\"topiclist-page-link secondary\">".$pageat."</a>";
				$pageat++;
			}
		}elseif($pages != 1){
			$pageat = 2;
			while($pageat <= $pages){
				$pagelink .= " <a href=\"".PATH."viewthread?thread=".$row['id']."&page=".$pageat."\" class=\"topiclist-page-link secondary\">".$pageat."</a>";
				$pageat++;
			}
		}

        printf("<li class=\"%s\" >
		<a href=\"./viewthread?thread=%s\" class=\"topic\">
			<span>%s</span>

		</a>
		<div class=\"topic-info post-icon\">
            <span class=\"grey\">(</span>
                 %s
             <span class=\"grey\">)</span>
		 </div>
	</li>", $even, $row['id'], $input->HoloText($row['title'],false,false,true), $pagelink);
    }
}
?>

</ul>
<div id="active-discussions-toplist-hidden-h121" style="display: none">
    <ul class="active-discussions-toplist">
<?php
$i = 0;
$getem = mysql_query("SELECT * FROM cms_forum_threads ORDER BY unix DESC LIMIT 40 OFFSET 10") or die(mysql_error());

while ($row = mysql_fetch_assoc($getem)) {
    if($row['author'] !== ""){
        $i++;

        if(IsEven($i)){
            $even = "even";
        } else {
            $even = "odd";
        }
		
		$posts = $input->mysql_evaluate("SELECT COUNT(*) FROM cms_forum_posts WHERE threadid = '".$row['id']."'");
		$pages = ceil($posts / 10);
		$pagelink = "<a href=\"".PATH."viewthread?thread=".$row['id']."\" class=\"topiclist-page-link secondary\">1</a>";
		if($pages > 4){
			$pageat = $pages - 2;
			$pagelink .= "\n...";
			while($pageat <= $pages){
				$pagelink .= " <a href=\"".PATH."viewthread?thread=".$row['id']."&page=".$pageat."\" class=\"topiclist-page-link secondary\">".$pageat."</a>";
				$pageat++;
			}
		}elseif($pages != 1){
			$pageat = 2;
			while($pageat <= $pages){
				$pagelink .= " <a href=\"".PATH."viewthread?thread=".$row['id']."&page=".$pageat."\" class=\"topiclist-page-link secondary\">".$pageat."</a>";
				$pageat++;
			}
		}

        printf("<li class=\"%s\" >
		<a href=\"".PATH."viewthread?thread=%s\" class=\"topic\">
			<span>%s</span>

		</a>
		<div class=\"topic-info post-icon\">
            <span class=\"grey\">(</span>
                 %s
             <span class=\"grey\">)</span>
		 </div>
	</li>", $even, $row['id'], $input->HoloText($row['title'],false,false,true), $pagelink);
    }
}
?>

</ul>

</div>
<div class="clearfix">
    <a href="#" class="discussions-toggle-more-data secondary" id="discussions-toggle-more-data-h121">Mostra altre discussioni</a>
</div>
<script type="text/javascript">
L10N.put("show.more.discussions", "Mostra altre discussioni");
L10N.put("show.less.discussions", "Mostra altre discussioni");
var discussionMoreDataHelper = new MoreDataHelper("discussions-toggle-more-data-h121", "active-discussions-toplist-hidden-h121","discussions");
</script>
    </div>
	
    <div id="tab-0-1-2-content" style="display: none">
<div class="progressbar"><img src="<?php echo PATH; ?>web-gallery/images/progress_bubbles.gif" alt="" width="29" height="6" /></div>
    		<a href="<?php echo PATH; ?>habblet/proxy.php?hid=h122" class="tab-ajax"></a>

<div class="clearfix">
    <a href="#" class="discussions-toggle-more-data secondary" id="discussions-toggle-more-data-h121">Guarda altri risultati</a>
</div>
<script type="text/javascript">
L10N.put("show.more.discussions", "Mostra altre discussioni");
L10N.put("show.less.discussions", "Mostra altre discussioni");
var discussionMoreDataHelper = new MoreDataHelper("discussions-toggle-more-data-h121", "active-discussions-toplist-hidden-h121","discussions");
</script>
    </div>
	</div>

					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

				
				

							<div class="habblet-container ">		
						<div class="cbb clearfix activehomes ">
	
							<h2 class="title">Siamo Utenti - Cliccaci!
							</h2>
						<div id="homes-habblet-list-container" class="habblet-list-container">
	<img class="active-habbo-imagemap" src="<?php echo PATH; ?>web-gallery/v2/images/activehomes/transparent_area.gif" width="435px" height="230px" usemap="#habbomap" />

<?php
$i = 0;
$getem = mysql_query("SELECT * FROM users ORDER BY RAND() LIMIT 18") or die(mysql_error());

while ($row = mysql_fetch_assoc($getem)) {
$i++;
$list_id = $i - 1;

if($input->IsUserOnline($row['id']) == true){
	$status = "online";
} else {
	$status = "offline";
}

printf("        <div id=\"active-habbo-data-%s\" class=\"active-habbo-data\">
                    <div class=\"active-habbo-data-container\">
                        <div class=\"active-name %s\">%s</div>
                        ".$site['short']." creato il: %s
                            <p class=\"moto\">%s</p>
                    </div>
                </div>
                <input type=\"hidden\" id=\"active-habbo-url-%s\" value=\"user_profile?name=%s\"/>
                <input type=\"hidden\" id=\"active-habbo-image-%s\" class=\"active-habbo-image\" value=\"http://www.habbo.com/habbo-imaging/avatarimage?figure=%s&size=b&direction=4&head_direction=4&gesture=sml\n\" />", $list_id, $status, $row['username'], date('d-m-Y', $row['account_created']), $input->HoloText($row['motto']), $list_id, $row['username'], $list_id, $row['look']);
}
?>



            <div id="placeholder-container">
                    <div id="active-habbo-image-placeholder-0" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-1" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-2" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-3" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-4" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-5" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-6" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-7" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-8" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-9" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-10" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-11" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-12" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-13" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-14" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-15" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-16" class="active-habbo-image-placeholder"></div>
                    <div id="active-habbo-image-placeholder-17" class="active-habbo-image-placeholder"></div>
            </div>
    </div>

    <map id="habbomap" name="habbomap">
            <area id="imagemap-area-0" shape="rect" coords="55,53,95,103" href="#" alt=""/>
            <area id="imagemap-area-1" shape="rect" coords="120,53,160,103" href="#" alt=""/>
            <area id="imagemap-area-2" shape="rect" coords="185,53,225,103" href="#" alt=""/>
            <area id="imagemap-area-3" shape="rect" coords="250,53,290,103" href="#" alt=""/>
            <area id="imagemap-area-4" shape="rect" coords="315,53,355,103" href="#" alt=""/>
            <area id="imagemap-area-5" shape="rect" coords="380,53,420,103" href="#" alt=""/>
            <area id="imagemap-area-6" shape="rect" coords="28,103,68,153" href="#" alt=""/>
            <area id="imagemap-area-7" shape="rect" coords="93,103,133,153" href="#" alt=""/>
            <area id="imagemap-area-8" shape="rect" coords="158,103,198,153" href="#" alt=""/>
            <area id="imagemap-area-9" shape="rect" coords="223,103,263,153" href="#" alt=""/>
            <area id="imagemap-area-10" shape="rect" coords="288,103,328,153" href="#" alt=""/>
            <area id="imagemap-area-11" shape="rect" coords="353,103,393,153" href="#" alt=""/>
            <area id="imagemap-area-12" shape="rect" coords="55,153,95,203" href="#" alt=""/>
            <area id="imagemap-area-13" shape="rect" coords="120,153,160,203" href="#" alt=""/>
            <area id="imagemap-area-14" shape="rect" coords="185,153,225,203" href="#" alt=""/>
            <area id="imagemap-area-15" shape="rect" coords="250,153,290,203" href="#" alt=""/>
            <area id="imagemap-area-16" shape="rect" coords="315,153,355,203" href="#" alt=""/>
            <area id="imagemap-area-17" shape="rect" coords="380,153,420,203" href="#" alt=""/>
    </map>
<script type="text/javascript">
    var activeHabbosHabblet = new ActiveHabbosHabblet();
    document.observe("dom:loaded", function() { activeHabbosHabblet.generateRandomImages(); });
</script>


					</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
		</div>

		<div id="column2" class="column">
			<?php include("includes/news_mini.php"); ?>
			<?php $incolumn = 1; include("templates/ads.php"); $incolumn = 0; ?>
		</div>
	<script type="text/javascript">
	HabboView.add(LoginFormUI.init);
</script>
		<div id="column3" class="column">
			<div class="habblet-container community-skyscraper">
				<div class="ad-container">
					<br><br><br><br><br><br><br><br><br><br><?php include("templates/ads.php"); ?>
				</div>
			</div>
			<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
		</div>
	</div>
<?php

include('templates/footer.php');
?>
</div>