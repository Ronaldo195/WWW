<?php
if(empty($body_id))
	$body_id = "home";

if(date('H') > 18 || date('H') < 6)
	$container = "header-container-night";
else
	$container = "header-container";

?>
<body id="<?php echo $body_id; ?>" class="<?php if(!$logged_in){ echo "anonymous"; } ?> ">
<div id="overlay"></div>

<div id="<?php echo $container; ?>">
	<div id="header" class="clearfix">
		<h1><a href="<?php echo PATH; ?>"></a></h1>
       <div id="subnavi">
			<div id="subnavi-user">
                            <?php if($logged_in){ ?>
				<ul>
	<li id="myfriends"><a href="#"><span>I miei Amici</span></a><span class="r"></span></li>
	<li id="mygroups"><a href="#"><span>I miei Gruppi</span></a><span class="r"></span></li>
	<li id="myrooms"><a href="#"><span>Le mie Stanze</span></a><span class="r"></span></li>
				</ul>



                            <?php } elseif(!$logged_in){ ?>
                                <div class="clearfix">&nbsp;</div>
                            
<?php } ?>
			</div>
        <?php if(!$logged_in){ ?>
            <div id="subnavi-login">
                <form action="<?php echo PATH; ?>?anonymousLogin" method="post" id="login-form">
            		<input type="hidden" name="page" value="<?php echo $pageid; ?>" />
                    <ul>
                        <li>
                            <label for="login-username" class="login-text"><b>Email</b></label>
                            <input tabindex="1" type="text" class="login-field" name="username" id="login-username" />
		                    <a href="#" id="login-submit-new-button" class="new-button" style="float: left; display:none"><b>Entra</b><i></i></a>
                            <input type="submit" id="login-submit-button" value="Entra" class="submit"/>
                        </li>
                        <li>
                            <label for="login-password" class="login-text"><b>Password</b></label>
                            <input tabindex="2" type="password" class="login-field" name="password" id="login-password" />
                            <input tabindex="3" type="checkbox" name="_login_remember_me" value="true" id="login-remember-me" />
                            <label for="login-remember-me" class="left">Ricordati di me!</label>
                        </li>
                    </ul>
                </form>
                <div id="subnavi-login-help" class="clearfix">
                    <ul>
                        <li class="register"><a href="<?php echo PATH; ?>" id="forgot-password"><span>Password dimenticata?</span></a></li>
                    	<li><a href="<?php echo PATH; ?>register-go"><span>Registrati gratis!</span></a></li>
                    </ul>
                </div>
<div id="remember-me-notification" class="bottom-bubble" style="display:none;">
	<div class="bottom-bubble-t"><div></div></div>
	<div class="bottom-bubble-c">
					Cliccando qui, deciderai di restare connesso finch&egrave non cliccherai su 'Esci' 
	</div>
	<div class="bottom-bubble-b"><div></div></div>
</div>
            </div>
        </div>
		<script type="text/javascript">
			LoginFormUI.init();
			RememberMeUI.init("right");
		</script>
        <?php } else { ?>
            <div id="subnavi-search">
                <div id="subnavi-search-upper">
                <ul id="subnavi-search-links">
<li><a href="<?php echo PATH; ?>account/logout" class="userlink">Esci</a></li>
	</ul>
                </div>
				<div id="to-hotel" style="width:595px">
				<?php
				echo $user->row['rank'] > 3 ? '<a href="'.PATH.'admin" class="new-button red-button edit-icon"><b><span></span>Amministrazione</b><i></i></a>' : '';
				
				if(CLOSING && date('H') > 1 && date('H') < 8 && $user->row['rank'] < 4)
					echo '<div id="hotel-closed-medium" style="float:right;">Orario di Apertura: 8.00 - 2.00</div>';
				else
					echo '<a href="'.PATH.'client" style="margin-right:5px;" class="new-button green-button " target="client" onclick="HabboClient.openOrFocus(this); return false;"><b>Entra in Hotel</b><i></i></a>';
				?>
				</div>
			</div>
        </div>
        <script type="text/javascript">
		L10N.put("purchase.group.title", "Crea un gruppo");
        </script>
        <?php } ?>
<ul id="navi">

        <?php
	if(isset($_SESSION['provider'])){
		if(isset($_SESSION['provider']['profile']['providerName']) && $_SESSION['provider']['profile']['providerName'] == 'Google')
			$image = 'google';
		else if(isset($_SESSION['provider']['id']) && $_SESSION['provider']['id'] > 0)
			$image = 'facebook_connect';
		else
			$image = 'habbo'; 
	}else
		$image = 'habbo';
		
		if($pageid > 0 && $pageid < 4  || $pageid == "908" || $pageid == "myprofile"  && $logged_in == true){
		?>
        <li class="selected"><strong><?php echo $user->row['username']; ?> (&nbsp;<i style="background-repeat:no-repeat;background-image: url(<?php echo PATH; ?>web-gallery/v2/images/rpx/icon_<?php echo $image; ?>_small.png);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>)</strong><span></span></li><?php } elseif($logged_in == true){ ?>
        <li class=" "><a href="<?php echo PATH; ?>me"><?php echo $user->row['username']; ?> (&nbsp;<i style="background-repeat:no-repeat;background-image: url(<?php echo PATH; ?>web-gallery/v2/images/rpx/icon_<?php echo $image; ?>_small.png);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>)</a><span></span></li><?php } elseif($logged_in !== true){ ?>
        <li id="tab-register-now"><a href="<?php echo PATH; ?>index#registration" target="_self">Registrati ora!</a><span></span></li><?php } ?>



<?php if($pageid == "com" || $pageid == 4 || $pageid == 8 || $pageid == "news" || $pageid == "eventi" || $pageid == "competizioni" || $pageid == "staff"){ ?>

	<li class="selected"><strong>Community</strong><span></span></li><?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>community">Community</a><span></span></li><?php } ?>
	
<?php if($site['forum'] == '1'){ if($pageid == "forum"){ ?>
	<li class="selected"><strong>Forum</strong><span></span></li><?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>forum">Forum</a><span></span></li><?php } } ?>

<?php if($pageid == "safety"){
	echo '<li class="selected"><strong>Sicurezza</strong><span></span></li>'; } else {
	echo '<li class=" "><a href="'.PATH.'safety">Sicurezza</a><span></span></li>'; } ?>	

<?php if($pageid == "6" || $pageid == "7"){ ?>
	<li class="selected"><strong>Crediti</strong><span></span></li><?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>credits">Crediti</a><span></span></li><?php } ?>

<?php if($site['chat'] == '1'){ if($pageid == "chat"){ ?>
	<li class="selected"><strong>Chat</strong><span></span></li><?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>chat">Chat</a><span></span></li><?php } } ?>	

</ul>
	<style>
	#habbos-online {
		position: absolute;
		width: 110px;
		left: 781px;
		top: 15px;
		font-size: 10px;
		text-align: center;
	}

	#habbos-online span {
		display: block;	
		padding: 20px;
		background-color: #fff;		
		border-radius:10px;
	}
	</style>
	<div id="habbos-online"><span><?php echo $input->GetOnline(); ?> <?php echo $site['short']; ?> in Hotel</span></div>
	
	</div>
</div>

<div id="content-container">

<div id="navi2-container" class="pngbg">
    <div id="navi2" class="pngbg clearfix">

	<ul>
	
	
<?php if($pageid > 0 && $pageid < 4 || $pageid == "908" || $pageid == "myprofile" || $pageid == "9000"){ ?>

	<?php if($pageid == "1"){ ?>
	<li class="selected">Home<?php } else { ?>
	<li class=""><a href="<?php echo PATH; ?>me">Home</a><?php } ?></li>

	<?php if($pageid == "myprofile"){ ?>
	<li class="selected">La mia pagina<?php } else { ?>
	<li class=""><a href="<?php echo PATH; ?>home/<?php echo $user->row['username']; ?>">La mia pagina</a><?php } ?></li>

	<?php if($pageid == "2" && $logged_in){ ?>
	<li class="selected last">Impostazioni Account<?php } elseif($logged_in){ ?>
	<li class=" "><a href="<?php echo PATH; ?>profile">Impostazioni Account</a><?php } ?></li>
	
	<li class=" last"><a href="<?php echo PATH; ?>credits/club"><?php echo $site['short']." Club"; ?></a>

<?php } else if($pageid == "safety"){ 
	if($pageid == "safety"){ ?>
	<li class="selected last">Consigli Sicurezza<?php } else { ?>
	<li class=" last"><a href="<?php echo PATH; ?>community">Consigli sicurezza</a>
	<?php } ?>
	
<?php } else if($pageid == "profile" || $pageid == "712" || $pageid == "com" || $pageid == "8" || $pageid == "9" || $pageid == "999" || $pageid == "news" || $pageid == "eventi" || $pageid == "competizioni" || $pageid == "staff"){ ?>
	
	<?php if($pageid == "com"){ ?>
	<li class="selected">Community<?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>community">Community</a><?php } ?>
	
	<?php if($pageid == "staff"){ ?>
	<li class="selected">Staff<?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>staff">Staff</a><?php } ?>

    <?php if($pageid == "news"){ ?>
	<li class="selected">Ultime Notizie<?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>articles">Ultime Notizie</a><?php } ?>
	
	<?php if($pageid == "eventi"){ ?>
	<li class="selected">Eventi<?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>articles/category/eventi">Eventi</a><?php } ?>
	
	<?php if($pageid == "competizioni"){ ?>
	<li class="selected last">Competizioni & Quiz<?php } else { ?>
	<li class=" last"><a href="<?php echo PATH; ?>articles/category/competizioni">Competizioni & Quiz</a><?php } ?>
	
<?php } else if($pageid > 5 && $pageid < 8){ ?>

	<?php if($pageid == 6){ ?>
	<li class="selected">Crediti<?php } else { ?>
	<li class=" "><a href="<?php echo PATH; ?>credits">Crediti</a><?php } ?>
	
	<?php if($pageid == 7){ ?>
	<li class="selected last"><?php echo $site['short']." Club"; } else { ?>
	<li class=" last"><a href="<?php echo PATH; ?>credits/club"><?php echo $site['short']." Club"; ?></a><?php } ?>

<?php } else if($pageid == "forum"){ ?>

	<?php if($pageid == "forum"){ ?>
	<li class="selected last"><?php echo $site['short']; ?> Forum<?php } else { ?>
	<li class=" last"><a href="<?php echo PATH; ?>chat"><?php echo $site['short']; ?> Forum</a><?php } ?>

<?php } else if($pageid == "chat"){ ?>

	<?php if($pageid == "chat"){ ?>
	<li class="selected last">Chat<?php } else { ?>
	<li class=" last"><a href="<?php echo PATH; ?>chat">Chat</a><?php } ?>

<?php } ?>
</li>
<?php if($maintenance == 1){ ?>
<br><br><div align="center" style="color: red; background-color: white; border: 1px solid black; padding:2px;"><b>Attenzione:</b> l'Hotel &egrave momentaneamente in Manutenzione!</div>
<?php } ?>				
</ul>


	</div>
</div>
</div>
