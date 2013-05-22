<?php
include("../core.php");
$checkname = isset($_POST['checkNameOnly'])  ? $_POST['checkNameOnly'] : false;
$checkfigure = isset($_POST['checkFigureOnly'])  ? $_POST['checkFigureOnly'] : false;
$refresh = isset($_POST['refreshAvailableFigures'])  ? $_POST['refreshAvailableFigures'] : false;
$refreshget = isset($_GET['refreshAvailableFigures'])  ? $_GET['refreshAvailableFigures'] : false;
$error = isset($_POST['ErrorNameOnly']) ? $_POST['ErrorNameOnly'] : false;

if($checkfigure){
	$figure = $_POST['bean_figure'];
	echo '
	<h3>Scegli:</h3>
	<img src="http://www.habbo.it/habbo-imaging/avatarimage?figure='.$figure.'&direction=4" width="64" height="110"/>
	<input type="hidden" name="bean.figure" value="'.$figure.'">
	';
}else if($error != ''){
	$name = isset($_POST['bean_avatarName']) ? $input->EscapeString($_POST['bean_avatarName']) : '';

	if(!$input->ValidName($name))
		$err = 'Questo nome non pu&ograve; essere accettato.';
	else if($input->NameTaken($name))
		$err = 'Il nome '.$name.' &egrave; gi&agrave; stato scelto';
	else
		$err = '';
	
	if($err != ''){
		echo '
			<div class="error-messages-holder">
                <h3>Risolvi il seguente problema e completa nuovamente il campo richiesto.</h3>
                <ul>
                    <li><p class="error-message">'.$err.'</p></li>
                </ul>
			</div>
		';
	}
}else if($checkname){
	$name = isset($_POST['bean_avatarName']) ? $input->EscapeString($_POST['bean_avatarName']) : '';
	if($input->ValidName($name) && !$input->NameTaken($name))
		echo '
		<div class="field field-habbo-name">
                  <label for="habbo-name">Nome Habbo</label>
                  <a href="#" class="new-button" id="check-name-btn"><b>Disponibile?</b><i></i></a>
                  <input type="text" id="habbo-name" size="26" value="'.$name.'" name="bean.avatarName" class="text-field" maxlength="32"/>
                    <div id="name-suggestions">
					<div class="available">
                            <p>Congratulazioni! Il nome <strong>'.$name.'</strong> &egrave; disponibile.</p>
                        </div>
                    </div>
        </div>
		';
	else
		echo '
		<div class="field field-habbo-name state-error">
                  <label for="habbo-name">Nome Habbo</label>
                  <a href="#" class="new-button" id="check-name-btn"><b>Disponibile?</b><i></i></a>
                  <input type="text" id="habbo-name" size="26" value="'.$name.'" name="bean.avatarName" class="text-field" maxlength="32"/>
                  <div id="name-suggestions">
                  </div>
					<p class="help">Il tuo nome pu&ograve; contenere caratteri maiuscoli, minuscoli, numeri e caratteri speciali come _-=?!@:.,</p>
        </div>
		';
}else if($refresh || $refreshget){
$female = array(
			'hr-890-38.hd-629-7.ch-645-74.lg-695-62.sh-906-74.he-1602-62.ca-1803-62.wa-2011',
			'hr-890-36.hd-629-8.ch-884-70.lg-716-73-62.sh-907-72',
			'hr-890-36.hd-629-8.ch-884-71.lg-715-71.sh-907-62.he-1602-71',
			'hr-545-34.hd-605-4.ch-660-62.lg-700-64',
			'hr-530-36.hd-600-10.ch-635-69.lg-700-84.sh-725-91.he-1608.fa-1212.wa-2008',
			'hr-515-47.hd-600-1.ch-685-62.lg-3116-72-62.fa-1202-68',
			'hr-545-45.hd-629-1.ch-685-77.lg-700-62',
			'hr-545-39.hd-600-3.ch-660-63.lg-700-78.ca-1815-62',
			'hr-890-33.hd-600-1.ch-675-73.lg-705-65.sh-907-64.he-1608.ca-1813.wa-2008',
			'hr-890-31.hd-629-3.ch-879-78.lg-715-78.sh-907-64.he-1602-71.wa-2011',
			'hr-550-1316.hd-600-25.ch-660-75.lg-700-75.ea-1401-75',
			'hr-515-42.hd-600-10.ch-660-73.lg-720-77.sh-730-62',
			'hr-890-44.hd-625-1.ch-640-66.lg-715-73.sh-907-73.ha-1010-74.ca-1804-73'
			);

$male = array(
			'hr-893-45.hd-209-9.ch-878-81-80.lg-3116-62-62.sh-305-77.ca-1815-62.wa-2011',
			'hr-893-39.hd-209-7.ch-235-62.lg-280-81.sh-290-62.wa-2011',
			'hr-893-45.hd-180-1.ch-3030-62.lg-275-64',
			'hr-135-39.hd-209-3.ch-255-64.lg-280-64.sh-906-64.wa-2006.cc-260-62',
			'hr-135-48.hd-208-12.ch-230-78.lg-270-69.sh-906-62.fa-1201',
			'hr-125-31.hd-190-4.ch-210-66.lg-3116-62-62',
			'hr-165-31.hd-209-9.ch-3109-1315-80.lg-280-62.he-1609-62.ea-1401-62.fa-1202-62.wa-3211-62-62',
			'hr-135-35.hd-180-3.ch-3030-62.lg-280-82.sh-305-62.wa-2011',
			'hr-125-36.hd-209-8.ch-255-70.lg-280-64.sh-906-73.wa-2001',
			'hr-155-35.hd-180-7.ch-3109-1315-82.lg-3116-70-1315.sh-3115-70-1315.ha-1003-1315.he-1608.fa-1212.cp-3128-62',
			'hr-893-45.hd-185-4.ch-3030-1315.lg-281-63',
			'hr-165-31.hd-180-2.ch-878-62-62.lg-270-62.sh-295-62.fa-1201',
			'hr-679-42.hd-180-1.ch-210-82.lg-280-64.sh-295-62.ha-1003-64',
			'hr-893-45.hd-180-1.ch-3030-64.lg-281-62.sh-295-62',
			'hr-893-36.hd-209-1.ch-255-73.lg-280-79.sh-3115-85-62.ca-1802'
			);
			
?>
<div id="avatar-field-container" class="clearfix">
                <div id="selected-avatar">
                    <h3>Scegli:</h3>
                        <img src="http://www.habbo.it/habbo-imaging/avatar/hr-890-38.hd-629-7.ch-645-74.lg-695-62.sh-906-74.he-1602-62.ca-1803-62.wa-2011,s-0.g-1.d-4.h-4.a-0,33c49f659a50a3d1b3505791a6f69334.gif" width="64" height="110"/>
                </div>
                <div id="avatar-choices">
                    <h3>Ragazze</h3>
                        <?php
						for($i=0;$i<5;$i++){
							$lenght = count($female) - 1;
							$rand = rand(0, $lenght);
							echo '
                        <a href="'.PATH.'proxy?bean.figure='.$female[$rand].'&amp;bean.gender=f&amp;checkFigureOnly=true" class="female-avatar" rel="'.$female[$rand].'">
                            <img src="http://www.habbo.it/habbo-imaging/avatarimage?figure='.$female[$rand].'&direction=4&size=s" width="33" height="56"/>
                        </a>
							'; 
						}
						?>

                    <h3>Ragazzi</h3>
                        <?php
						for($i=0;$i<5;$i++){
							$lenght = count($male) - 1;
							$rand = rand(0, $lenght);
							echo '
                        <a href="'.PATH.'proxy?bean.figure='.$male[$rand].'&amp;bean.gender=f&amp;checkFigureOnly=true" class="female-avatar" rel="'.$male[$rand].'">
                            <img src="http://www.habbo.it/habbo-imaging/avatarimage?figure='.$male[$rand].'&direction=4&size=s" width="33" height="56"/>
                        </a>
							'; 
						}
						?>
                    <p style="clear: left;"><a href="http://www.habbo.it/identity/add_avatar?refreshAvailableFigures=true" id="more-avatars">Voglio altri look!</a> Puoi cambiare il tuo look pi&ugrave; tardi!</p>
                </div>
            </div>
<?php } ?>