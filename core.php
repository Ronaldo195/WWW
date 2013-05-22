<?php 
header('content-type: text/html; charset=iso-8859-1');
@define("IN_HOLOCMS", TRUE); 

@session_start(); 

@include('./config.php'); 
@include('../config.php'); 
@include('./includes/mysql.php'); 
@include('../includes/mysql.php'); 
@include('../includes/queries/'.DATABASE.'.php');
@include('./includes/queries/'.DATABASE.'.php');
@include('./includes/functions.php'); 
@include('../includes/functions.php');
@include('./includes/user.php'); 
@include('../includes/user.php');

$remote_ip = $_SERVER['REMOTE_ADDR']; 
$configsql = mysql_query($core->select1()) or die(mysql_error()); 
$config = mysql_fetch_assoc($configsql); 

$site['language'] = $config['language'];
$site['name'] = $config['sitename'];
$site['short'] = $config['shortname'];
$site['credits'] = $config['start_credits'];
$site['chat'] = $config['chat'];
$site['forum'] = $config['forum'];
$site['analytics'] = $input->HoloText($config['analytics'], true)."\n";

$client['ip'] = $config['ip']; 
$client['port'] = $config['port'];
$client['fport'] = $config['fport'];
$client['texts'] = $config['texts']; 
$client['vars'] = $config['variables']; 
$client['override_texts'] = $config['override_texts']; 
$client['override_vars'] = $config['override_vars']; 
$client['productdata'] = $config['productdata']; 
$client['furnidata'] = $config['furnidata']; 
$client['clienturl'] = $config['clienturl']; 
$client['base'] = $config['base']; 
$client['habboswf'] = $config['habboswf']; 
$client['clientext'] = $config['clientext']; 

$admin['notes'] = $config['admin_notes'];

$maintenance = $config['site_closed']; 

$isnew=0;
$newcheck = mysql_query("SELECT * FROM group_memberships") or $isnew=1;
$site['memberships'] = $isnew == 0 ? "group_memberships" : "groups_memberships";

$date_normal = date('d-m-Y'); 
$date_reversed = date('Y-m-d'); 
$date_full = date('d-m-Y H:i:s');
$mk_full = time();
$date_time = date('H:i:s'); 
$regdate = $date_normal; 

if(!isset($_SESSION['user']) && (isset($_COOKIE['remember']) && $_COOKIE['remember'] == "remember")){ 
    $cname = $input->FilterText($_COOKIE['rusername']); 
    $cpass_hash = $_COOKIE['rpassword']; 
    $csql = mysql_query($core->select2($cname)) or die(mysql_error()); 
    $cnum = mysql_num_rows($csql); 
    if($cnum < 1){ 
        setcookie("remember", "", time()-60*60*24*100, "/");
        setcookie("rusername", "", time()-60*60*24*100, "/");
        setcookie("rpassword", "", time()-60*60*24*100, "/");
    } else { 
        $crow = mysql_fetch_assoc($csql); 
        $correct_pass = $crow['password']; 
        if($cpass_hash == $correct_pass){ 
            $user->login($cname, $cpass_hash, "on");
            if($user->login_error != ''){
                setcookie("remember", "", time()-60*60*24*100, "/");
                setcookie("rusername", "", time()-60*60*24*100, "/");
                setcookie("rpassword", "", time()-60*60*24*100, "/");
                header("location: ".PATH);
            }
            exit; 
        } else { 
            setcookie("remember", "", time()-60*60*24*100, "/");
            setcookie("rusername", "", time()-60*60*24*100, "/");
            setcookie("rpassword", "", time()-60*60*24*100, "/");
            header("location: ".PATH);
        }
    }
}

if(isset($_SESSION['user'])){ 
	$user = unserialize($_SESSION['user']);
    $rawname = $user->row['id'];
    $rawpass = $user->account['password'];
	$usersql = mysql_query($core->select3($rawname, $rawpass)); 
    $password_correct = mysql_num_rows($usersql); 
    if($password_correct < 1){
        session_destroy(); 
		setcookie("remember", "", time()-60*60*24*100, "/");
        setcookie("rusername", "", time()-60*60*24*100, "/");
        setcookie("rpassword", "", time()-60*60*24*100, "/");
        header("location: ".PATH."?error=1"); 
        exit;
    } elseif($input->IsUserBanned($user->row['username'])){
        $bandata = mysql_fetch_assoc(mysql_query($core->select4($user->row['username']))) or die(mysql_error()); 
        $reason = $bandata['reason']; 
        $expire = $bandata['expire']; 
        $login_error = "Sei stato bannato per  \"" . $reason . "\". il tuo ban finisce il " . date('d/m/Y H:i:s',$expire) . ".";  
        include("logout.php");
		@session_destroy(); 
        exit;
    }
    if($password_correct == 1)
		mysql_query($core->update1($user->row['id'])) or die(mysql_error()); 
    $logged_in = true; 
} else {
    $user->row['username'] = "Visitatore"; 
    $user->row['id'] = "0"; 
    $logged_in = false; 
}

if($maintenance == 1 && !isset($is_maintenance) && (!isset($user->row['rank']) || $user->row['rank'] < 4)){ 
    header("Location: ".PATH."manutenzione"); 
    exit; 
}
?>