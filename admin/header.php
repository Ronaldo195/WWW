<?php
if(!isset($user->row) || !isset($_SESSION['adm_key']) || $_SESSION['adm_key'] != PANEL_KEY)
	header("Location: ".PATH."admin");
	
if(isset($_GET['logout'])){
	unset($_SESSION['adm_key']);
	header("Location: ".PATH."me");
}

if($page['rank'] > $user->row['rank'])
	header("Location: ".PATH."admin/stop");
?>
<!doctype html>
<html lang="it">

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
	<title><?php echo $page['id']; ?></title>
	<link rel="stylesheet" href="<?php echo PATH."admin/"; ?>css/layout.css" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="<?php echo PATH."admin/"; ?>js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="<?php echo PATH."admin/"; ?>js/hideshow.js" type="text/javascript"></script>
	<script src="<?php echo PATH."admin/"; ?>js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo PATH."admin/"; ?>js/jquery.equalHeight.js"></script>
	<script type="text/javascript">
	$(document).ready(function() 
     {
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});

    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>
	<script src="<?php echo PATH."admin/"; ?>ckeditor/ckeditor.js"></script>
	<script>
	function logout(){
		var sei_sicuro = confirm('Sei sicuro di voler uscire?');
		if (sei_sicuro)
		{
			location.href = '?logout=1';
		}
	}
	</script>
</head>


<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title"><center><a href="<?php echo PATH; ?>admin"><img src="<?php echo PATH; ?>web-gallery/v2/images/habbo.png"></a></center></h1>
			<h2 class="section_title"><?php echo $page['id']; ?></h2>
			<div class="btn_view_site"><a href="<?php echo PATH; ?>">Visualizza sito</a></div>
		</hgroup>
	</header>
	
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo $user->row['username']; ?></p>
			<a class="logout_user" href="javascript:logout();" title="Logout">Logout</a>
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs">
				<a href="<?php echo PATH."admin/"; ?>">Dashboard</a>
				<div class="breadcrumb_divider"></div>
				<a class="current"><?php echo $page['id']; ?></a></article>
		</div>
	</section>
	
	<aside id="sidebar" class="column" style="height:100%">
		<form method="get" action="<?php echo PATH; ?>admin/utenti/utenti" class="quick_search">
			<input name="name" type="text" value="" placeholder="Cerca utente">
		</form>
		<hr/>
		<h3>Server & Client</h3>
		<ul class="toggle">
			<li class="icn_video"><a href="<?php echo PATH; ?>admin/sito/client">Gestione client</a></li>
		</ul>
		<h3>Sito & Contenuto</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo PATH; ?>admin/sito/generale">Generale</a></li>
			<li class="icn_settings"><a href="<?php echo PATH; ?>admin/sito/manutenzione">Manutenzione (<b><?php echo $maintenance == 1 ? 'Chiuso' : 'Aperto'; ?></b>)</a></li>
			<li class="icn_new_article"><a href="<?php echo PATH; ?>admin/sito/articoli">Gestione articoli</a></li>
			<li class="icn_photo"><a href="<?php echo PATH; ?>admin/sito/meganews">Gestione mega-news</a></li>
			<li class="icn_tags"><a href="<?php echo PATH; ?>admin/sito/raccomandati">Gestione raccomandati</a></li>
			<li class="icn_edit_article"><a href="<?php echo PATH; ?>admin/sito/codici">Gestione codici</a></li>
			<li class="icn_photo"><a href="<?php echo PATH; ?>admin/sito/banner">Gestione pubblicit&agrave;</a></li>
		</ul>
		<h3>Utenti</h3>
		<ul class="toggle">
			<li class="icn_view_users"><a href="<?php echo PATH; ?>admin/utenti/utenti">Gestione utenti</a></li>
			<li class="icn_view_users"><a href="<?php echo PATH; ?>admin/utenti/online">Utenti online</a></li>
			<li class="icn_add_user"><a href="<?php echo PATH; ?>admin/utenti/rank">Gestione rank</a></li>
			<li class="icn_security"><a href="<?php echo PATH; ?>admin/utenti/ban">Gestione ban</a></li>
			<li class="icn_tags"><a href="<?php echo PATH; ?>admin/utenti/distintivi">Gestione distintivi</a></li>
		</ul>
		
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2013 Cristiand</strong></p>
		</footer>
	</aside>