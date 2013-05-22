<?php
class Input {

    function HoloHash($password){
        return sha1($password . "xCg532%@%gdvf^5DGaa6&*rFTfg^FD4\$OIFThrR_gh(ugf*/");
    }
	
    function GetOnline(){
        $sql = mysql_query($GLOBALS['core']->select5()); 
        return mysql_result($sql,0);
    }

    function FetchServerSetting($strSetting, $switch = false){ 
        $tmp = mysql_query($GLOBALS['core']->select6($strSetting));
        $tmp = mysql_fetch_assoc($tmp); 
        if($switch != true){ 
            return $tmp['sval']; 
        } elseif($switch == true && $tmp['sval'] == "1"){ 
            return "Enabled"; 
        } elseif($switch == true && $tmp['sval'] !== "1"){ 
            return "Disabled"; 
        }
    } 

    function getContent($strKey){ 
        $tmp = mysql_query($GLOBALS['core']->select7($this->FilterText($strKey))) or die(mysql_error()); 
        $tmp = mysql_fetch_assoc($tmp); 
        return $tmp['contentvalue']; 
    }

    function NameTaken($u_name = ''){
        return (mysql_num_rows(mysql_query($GLOBALS['core']->select8($u_name))) > 0  ? true : false);
    }

    function ValidName($u_name = ''){
        if(preg_match('/^[a-zA-Z0-9._:,-]+$/i', $u_name) && !preg_match('/mod-/i', $u_name) && !preg_match('/adm-/i', $u_name) && strlen($u_name) > 2 && strlen($u_name) < 25)
            return true;
        else
            return false;
    }

    function ValidPass($u_name = ''){
        if(preg_match('/^[a-zA-Z0-9]+$/i', $u_name))
            return true;
        else
            return false;
    }

    function ValidMail($email, $check = false) {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
        
        if (preg_match($regex, $email)){
            
            if($check)
                return mysql_num_rows(mysql_query($GLOBALS['core']->select9($email))) > 0 ? false : true;
            
            return true;
        }else
            return false;
    }

    function IsEven($num){ 
        if($num % 2 == 0)
            return true; 
        else
            return false;
    } 

    function bbcode_format($str){
        $str = str_replace(":)", " <img src='".PATH."web-gallery/smilies/happy.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(";)", " <img src='".PATH."web-gallery/smilies/wink2.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(":D", " <img src='".PATH."web-gallery/smilies/grin.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(":3", " <img src='".PATH."web-gallery/smilies/waii.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(";D", " <img src='".PATH."web-gallery/smilies/wink.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(":P", " <img src='".PATH."web-gallery/smilies/tongue.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(";P", " <img src='".PATH."web-gallery/smilies/tongue.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(":p", " <img src='".PATH."web-gallery/smilies/tongue.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(";p", " <img src='".PATH."web-gallery/smilies/tongue.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace("(L)", " <img src='".PATH."web-gallery/smilies/heart.gif' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace("(l)", " <img src='".PATH."web-gallery/smilies/heart.gif' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(":o", " <img src='".PATH."web-gallery/smilies/surprised.png' alt='Smiley' title='Smiley' border='0'> ", $str); 
        $str = str_replace(":O", " <img src='".PATH."web-gallery/smilies/surprised.png' alt='Smiley' title='Smiley' border='0'> ", $str); 

        $simple_search = array( 
                                    '/\[b\](.*?)\[\/b\]/is', 
                                    '/\[i\](.*?)\[\/i\]/is', 
                                    '/\[u\](.*?)\[\/u\]/is', 
                                    '/\[s\](.*?)\[\/s\]/is', 
                                    '/\[quote\](.*?)\[\/quote\]/is', 
                                    '/\[link\=(.*?)\](.*?)\[\/link\]/is', 
                                    '/\[url\=(.*?)\](.*?)\[\/url\]/is', 
                                    '/\[color\=(.*?)\](.*?)\[\/color\]/is', 
                                    '/\[size=small\](.*?)\[\/size\]/is', 
                                    '/\[size=large\](.*?)\[\/size\]/is', 
                                    '/\[code\](.*?)\[\/code\]/is', 
                                    '/\[habbo\=(.*?)\](.*?)\[\/habbo\]/is', 
                                    '/\[room\=(.*?)\](.*?)\[\/room\]/is', 
                                    '/\[group\=(.*?)\](.*?)\[\/group\]/is',
                                    '/\[img\](.*?)\[\/img\]/is' 
                                    ); 


        $simple_replace = array( 
                                '<strong>$1</strong>', 
                                '<em>$1</em>', 
                                '<u>$1</u>', 
                                '<s>$1</s>', 
                                "<div class='bbcode-quote'>$1</div>", 
                                "<a href='$1'>$2</a>", 
                                "<a href='$1'>$2</a>", 
                                "<font color='$1'>$2</font>", 
                                "<font size='1'>$1</font>", 
                                "<font size='3'>$1</font>", 
                                '<pre>$1</pre>', 
                                "<a href='".PATH."home/$1'>$2</a>", 
                                "<a onclick=\"roomForward(this, '$1', 'private'); return false;\" target=\"client\" href=\"".PATH."client.php?forwardId=2&roomId=$1\">$2</a>", 
                                "<a href='".PATH."groups/$1'>$2</a>",
								"<img src='$1' width='30' height='30'/>"  
                                ); 

        $str = preg_replace ($simple_search, $simple_replace, $str);
		$str = str_replace ("à", "&agrave;", $str);
		$str = str_replace ("è", "&egrave;", $str);
		$str = str_replace ("ì", "&igrave;", $str);
		$str = str_replace ("ò", "&ograve;", $str);
		$str = str_replace ("ù", "&ugrave;", $str);

        return $str; 
    } 

    function GenerateTicket(){ 

        $data = "HABLUX-"; 

        for ($i=1; $i<=6; $i++){ 
            $data = $data . rand(0,10); 
        } 

        $data = $data . ""; 

        for ($i=1; $i<=20; $i++){ 
            $data = $data . rand(0,10); 
        } 

        $data = $data . ""; 
        $data = $data . rand(0,10); 

        return $data; 
    } 

	function GetUserInfo($id, $info){
        $sql = mysql_query("SELECT ".$info." FROM user_info WHERE user_id = '".$id."'"); 
        return mysql_num_rows($sql) > 0 ? mysql_result($sql,0) : 1;
    }
	
    function GetUserBadge($id){
        $check = mysql_query($GLOBALS['core']->select10($id)) or die(mysql_error()); 
        $hasbadge = mysql_num_rows($check); 
        if($hasbadge > 0)
            return mysql_result($check,0); 
        else
            return false;
    }

    function GetUserGroup($mid){
        $check = mysql_query($GLOBALS['core']->select11($mid)) or die(mysql_error());
        $has_fave = mysql_num_rows($check);

        if($has_fave > 0){

            $row = mysql_fetch_assoc($check);
            $groupid = $row['groupid'];

            return $groupid;

        } else {

            return false;

        }
    }

    function GetUserGroupBadge($my_id){ 
        $check = mysql_query($GLOBALS['core']->select12($my_id)) or die(mysql_error()); 
        $has_badge = mysql_num_rows($check) > 0 ? mysql_result($check,0) : 0; 

        if($has_badge > 0){ 
            $check = mysql_query($GLOBALS['core']->select13($has_badge)) or die(mysql_error()); 
            return mysql_result($check,0);

        } else return false;
    }

    function IsUserOnline($intUID){
        $result = mysql_fetch_array(mysql_query($GLOBALS['core']->select14($intUID))) or die(mysql_error()); 
		
		if($this->GetUserInfo($intUID, 'online_show') == 1){
			if($result['online'] == 1)
				return true; 
			else
				return false; 
        } else
			return false;
        
        /*$fp = fsockopen($result['ip_last'], '1232', $errno, $errstr, 30); 
        if($fp){ 
        return true;
        fclose($fp); 
        } else { 
        return false;
        }*/
    } 

    function IsUserBanned($name){
        if(mysql_num_rows(mysql_query($GLOBALS['core']->select4($name))) > 0){
            $stamp_expire = mysql_fetch_assoc(mysql_query($GLOBALS['core']->select4($name)));
            $stamp_expire = $stamp_expire['expire'];
            $stamp_now = time();
            if($stamp_now < $stamp_expire)
                return true;
            else {
                mysql_query($GLOBALS['core']->delete1($name));
                return false;
            }
        } else
            return false;
    }

    function mysql_evaluate($query, $default_value="undefined") { 
        $result = mysql_query($query) or die(mysql_error()); 

        if(mysql_num_rows($result) < 1){ 
            return $default_value; 
        } else { 
            return mysql_result($result, 0); 
        } 
    } 

    function FilterText($str, $advanced=false) { 
        if($advanced == true){ return mysql_real_escape_string($str); } 
        $str = mysql_real_escape_string(htmlspecialchars($str)); 
        return $str; 
    }

    function EscapeString($string = ''){
        return mysql_real_escape_string(stripslashes(trim(htmlspecialchars($string))));
    }

    function HoloText($str, $advanced=false, $bbcode=false, $chars=false){ 
        if($advanced == true){ return stripslashes($str); } 
        $str = stripslashes(nl2br(htmlspecialchars($str))); 
        if($bbcode == true){$str = $this->bbcode_format($str); } 
		if($chars == true){
			$str = str_replace ("à", "&agrave;", $str);
			$str = str_replace ("è", "&egrave;", $str);
			$str = str_replace ("ì", "&igrave;", $str);
			$str = str_replace ("ò", "&ograve;", $str);
			$str = str_replace ("ù", "&ugrave;", $str);
		} 
        return $str; 
    } 

    function textInJS($str, $clean = false){ 
        $str = str_replace("??","?",$str); 
        $str = str_replace("??","?",$str); 
        $str = str_replace("?‘","?",$str); 
        $str = str_replace("?±","?",$str); 
        $str = str_replace("??","?",$str); 
        $str = str_replace("??","?",$str); 
        $str = str_replace("?‰","?",$str); 
        $str = str_replace("?©","?",$str); 
        $str = str_replace("?“","?",$str); 
        $str = str_replace("??","?",$str); 
        $str = str_replace("??","?",$str); 
        $str = str_replace("??","?",$str); 
        $str = str_replace("??","?",$str); 
        $str = str_replace("?","?",$str); 
        
        if($clean == true){ 
            $str = str_replace("?","N",$str); 
            $str = str_replace("?","n",$str); 
            $str = str_replace("?","A",$str); 
            $str = str_replace("?","a",$str); 
            $str = str_replace("?","E",$str); 
            $str = str_replace("?","e",$str); 
            $str = str_replace("?","O",$str); 
            $str = str_replace("?","o",$str); 
            $str = str_replace("?","U",$str); 
            $str = str_replace("?","u",$str); 
            $str = str_replace("?","I",$str); 
            $str = str_replace("?","i",$str); 
        } 
        
        return $str; 
    } 

    function SwitchWordFilter($str){
        $sql = mysql_query($GLOBALS['core']->select15()) or die(mysql_error()); 
        while($row = mysql_fetch_assoc($sql))
            $str = str_replace($row['word'],'******',$str); 
        return $str; 
    }

    function formatThing($type,$data,$pre){
        $str = "";

        switch($type){
            case 1: $str = $str . "s_"; break;
            case 2: $str = $str . "w_"; break;
            case 3: $str = $str . "commodity_"; break; // =S
            case 4: $str = $str . "b_"; break;
        }

        $str = $str . $data;

        if($pre == true){ $str = $str . "_pre"; }

        return $str;
    }

    function UpdateOrInsert($type,$amount,$data,$my_id){
        $data = $this->FilterText($data);
        $type = $this->FilterText($type);
        $amount = $this->FilterText($amount);

        $check = mysql_query($GLOBALS['core']->select16($data, $my_id, $type)) or die(mysql_error());
        $exists = mysql_num_rows($check);

        if($exists > 0){
            mysql_query($GLOBALS['core']->update2($amount, $my_id, $type, $data)) or die(mysql_error());
        } else {
            mysql_query($GLOBALS['core']->insert1($amount, $my_id, $type, $data)) or die(mysql_error());
        }

        return true;
    }

    function UpdateOrDelete($id,$my_id){
        $id = $this->FilterText($id);

        $check = mysql_query($GLOBALS['core']->select17($id, $my_id)) or die(mysql_error());
        $exists = mysql_num_rows($check);

        if($exists > 0){
            $row = mysql_fetch_assoc($check);

            if($row['amount'] > 1){
                mysql_query($GLOBALS['core']->update3($id, $my_id)) or die(mysql_error());
            } else {
                mysql_query($GLOBALS['core']->delete2($id, $my_id)) or die(mysql_error());
            }

        }

        return true;
    }

    function nicetime($date){
        if(empty($date))
            return "Data non esistente";
        $periods = array("secondi", "minuti", "ore", "giorni", "settimane", "mesi", "anni", "decenni");
        $lengths = array("60","60","24","7","4.35","12","10");
        $now = time();
        $unix_date = strtotime($date);
        if(empty($unix_date))  
            return "Data non valida";
		else if($date == "01-01-1970")
			return 0;
        if($now > $unix_date) {    
            $difference = $now - $unix_date;
            $tense = "fa";
        } else {
            $difference = $unix_date - $now;
            $tense = "da adesso";
        }
        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
            $difference /= $lengths[$j];
        $difference = round($difference);
        return "$difference $periods[$j] {$tense}";
    }

    function stringToURL($str,$lowercase=true,$spaces=false){
        $str = trim(preg_replace('/\s\s+/',' ',preg_replace("/[^A-Za-z0-9-]/", " ", $str)));
        if($lowercase == true){ $str = strtolower($str); }
        if($spaces == true){ $str = str_replace(" ", "-", $str); }else{ str_replace(" ", "", $str); }
        return $str;
    }
	
	function GiveHC($user_id, $months){ 
	$sql = mysql_query("SELECT * FROM user_subscriptions WHERE user_id = '".$user_id."' LIMIT 1") or die(mysql_error()); 
	$valid = mysql_num_rows($sql); 

    if($valid > 0){ 
		$row = mysql_fetch_assoc($sql);
		if($row['subscription_id'] == 'habbo_vip')
			return "vip";
			
        mysql_query("UPDATE user_subscriptions SET timestamp_expire = timestamp_expire + ".$months." WHERE user_id = '".$user_id."' LIMIT 1") or die(mysql_error()); 
        
		$check = mysql_query("SELECT * FROM user_badges WHERE badge_id = 'ACH_BasicClub1' AND user_id = '".$user_id."' LIMIT 1") or die(mysql_error()); 
        $found = mysql_num_rows($check); 
        if($found < 1)
            mysql_query("INSERT INTO user_badges (user_id,badge_id,badge_slot) VALUES ('".$user_id."','ACH_BasicClub1','0')") or die(mysql_error()); 
		
		return true;
    } else {
        mysql_query("INSERT INTO user_subscriptions (user_id,subscription_id,timestamp_activated,timestamp_expire) VALUES ('".$user_id."','habbo_club','".time()."','".time()."')") or die(mysql_error()); 
        $this->GiveHC($user_id, $months); 
    }
}

	function GiveVIP($user_id, $months){ 
	$sql = mysql_query("SELECT * FROM user_subscriptions WHERE user_id = '".$user_id."' LIMIT 1") or die(mysql_error()); 
	$valid = mysql_num_rows($sql); 
	
    if($valid > 0){ 
        mysql_query("UPDATE user_subscriptions SET timestamp_expire = timestamp_expire + ".$months.",subscription_id = 'habbo_vip' WHERE user_id = '".$user_id."' LIMIT 1") or die(mysql_error()); 
        
		$check = mysql_query("SELECT * FROM user_badges WHERE badge_id = 'ACH_VipClub1' AND user_id = '".$user_id."' LIMIT 1") or die(mysql_error()); 
        $found = mysql_num_rows($check); 
        if($found < 1)
            mysql_query("INSERT INTO user_badges (user_id,badge_id,badge_slot) VALUES ('".$user_id."','ACH_VipClub1','0')") or die(mysql_error()); 
    } else {
        mysql_query("INSERT INTO user_subscriptions (user_id,subscription_id,timestamp_activated,timestamp_expire) VALUES ('".$user_id."','habbo_vip','".time()."','".time()."')") or die(mysql_error()); 
        $this->GiveVIP($user_id, $months); 
    }
}

	function HCDaysLeft($my_id){
		$sql = mysql_query("SELECT timestamp_expire FROM user_subscriptions WHERE user_id = '".$my_id."' LIMIT 1") or die(mysql_error());
		$valid = mysql_num_rows($sql);
	
		if($valid > 0){
			$expire = mysql_result($sql,0);
			return $expire;
		} else {
			return 0;
		}
	}

	function IsHCMember($id){
		if($this->HCDaysLeft($id) > 0 ){
			return true;
		} else {
			$check = mysql_query("SELECT * FROM user_subscriptions WHERE user_id = '".$id."' LIMIT 1");
			$clubrecord = mysql_num_rows($check);
			if($clubrecord > 0){
				mysql_query("DELETE FROM user_badges WHERE badge_id = 'HC1' OR badge_id = 'HC2' AND userid = '".$id."' LIMIT 1");
				mysql_query("DELETE FROM user_subscriptions WHERE userid = '".$id."' LIMIT 1") or die(mysql_error());
			}
			return false;
		}
	}
	
	function HCType($id){
		if($this->HCDaysLeft($id) > 0 ){
			$sql = mysql_query("SELECT subscription_id FROM user_subscriptions WHERE user_id = '".$id."' LIMIT 1") or die(mysql_error());
			$hid = mysql_result($sql,0);
			
			if($hid == 'habbo_club')
				return "HC";
			else if($hid == 'habbo_vip')
				return "VIP";
			else
				return "HC";
		} else
			return "HC";
	}

	function MUS($command, $data = ''){
		$configsql = mysql_query($GLOBALS['core']->select1());
		$config = mysql_fetch_assoc($configsql);

		$mus_ip = $config['ip'];
		$mus_port = $config['fport'];
		
		$MUSdata = $command . chr(1) . $data;
		$proto = @getprotobyname('tcp');
		$socket = @socket_create(AF_INET, SOCK_STREAM, $proto);
		@socket_connect($socket, $mus_ip, $mus_port);
		@socket_send($socket, $MUSdata, strlen($MUSdata), MSG_DONTROUTE);	
		@socket_close($socket);
	}
}
$input = new Input();
?>