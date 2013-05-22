<?php
class core_sql {
	function select1(){
		return "SELECT * FROM cms_system LIMIT 1";
	}
	function select2($cname){
		return "SELECT * FROM accounts WHERE email = '".$cname."' LIMIT 1";
	}
	function select3($rawname, $rawpass){
		return "SELECT * FROM accounts WHERE current = '".$rawname."' AND password = '".$rawpass."' LIMIT 1";
	}
	function select4($name){
		return "SELECT * FROM bans WHERE value = '".$name."' OR value = '".$_SERVER['REMOTE_ADDR']."' LIMIT 1";
	}
	function select5(){
		return "SELECT users_online FROM server_status LIMIT 1";
	}
	function select6($str){
		return "SELECT sval FROM system_config WHERE skey = '".$str."' LIMIT 1";
	}
	function select7($str){
		return "SELECT contentvalue FROM cms_content WHERE contentkey = '".$str."' LIMIT 1";
	}
	function select8($name){
		return "SELECT * FROM users WHERE username = '".$name."'";
	}
	function select9($email){
		return "SELECT * FROM accounts WHERE email = '".$email."'";
	}
	function select10($id){
		return "SELECT badge_id FROM user_badges WHERE user_id = '".$id."' AND badge_slot = '1' LIMIT 1";
	}
	function select11($mid){
		return "SELECT * FROM user_stats WHERE id = '".$mid."' AND groupid > 0 LIMIT 1";
	}
	function select12($my_id){
		return "SELECT groupid FROM user_stats WHERE id = ".$my_id." LIMIT 1";
	}
	function select13($has_badge){
		return "SELECT badge FROM groups WHERE id = ".$has_badge." LIMIT 1";
	}
	function select14($intUID){
		return "SELECT * FROM users WHERE id = '".$intUID."' LIMIT 1";
	}
	function select15(){
		return "SELECT word FROM system_wordfilter";
	}
	function select16($data, $my_id, $type){
		return "SELECT id FROM cms_homes_inventory WHERE data = '".$data."' AND userid = '".$my_id."' AND type = '".$type."' LIMIT 1";
	}
	function select17($id, $my_id){
		return "SELECT amount FROM cms_homes_inventory WHERE id = '".$id."' AND userid = '".$my_id."' LIMIT 1";
	}
	function insert1($amount, $my_id, $type, $data){
		return "INSERT INTO cms_homes_inventory (userid,type,subtype,data,amount) VALUES ('".$my_id."','".$type."','0','".$data."','".$amount."')";
	}
	function update1($id){
		return "UPDATE users SET ip_last = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '".$id."' LIMIT 1";
	}
	function update2($amount, $my_id, $type, $data){
		return "UPDATE cms_homes_inventory SET amount = amount + ".$amount." WHERE userid = '".$my_id."' AND type = '".$type."' AND data = '".$data."' LIMIT 1";
	}
	function update3($id, $my_id){
		return "UPDATE cms_homes_inventory SET amount = amount - 1 WHERE id = '".$id."' AND userid = '".$my_id."' LIMIT 1";
	}
	function delete1($name){
		return "DELETE FROM bans WHERE value = '".$name."' OR value = '".$_SERVER['REMOTE_ADDR']."' LIMIT 1";
	}
	function delete2($id, $my_id){
		return "DELETE FROM cms_homes_inventory WHERE id = '".$id."' AND userid = '".$my_id."' LIMIT 1";
	}
}

class community_sql {

}
$core = new core_sql;
?>