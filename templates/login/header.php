<?php

if(!isset($body_id)){ $body_id = "landing"; }

?>

<body id="<?php echo $body_id; ?>" class="process-template">

<div id="overlay"></div>

<div id="container">
	<div class="cbb process-template-box clearfix">
		<div id="content">
			<div id="header" class="clearfix">
				<h1><a href="<?php echo PATH; ?>"></a></h1>
				<ul class="stats">
					    <li class="stats-online"><span class="stats-fig"><?php echo $input->GetOnline(); ?></span> <?php echo $site['short']; ?> online in questo momento!</li>
					    <li class="stats-visited"><img src='<?php echo PATH; ?>web-gallery/v2/images/online.gif' alt='Server Status' border='0'></li>
				</ul>
			</div>