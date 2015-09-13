<?php
require_once 'systemcomponent.php';
class dbconnector extends systemcomponent{
	var $thequery;
	var $link;
	function dbconnector(){
		$settings=systemcomponent::getsettings();
		$host=$settings['dbhost'];
		$db=$settings['dbname'];
		$user=$settings['dbusername'];
		$pass=$settings['dbpassword'];
		$this->link=mysql_connect($host, $user, $pass);
		mysql_select_db($db);
		register_shutdown_function(array(&$this, 'close'));
	}
	function query($query){
		$this->thequery=$query;
		return mysql_query($query, $this->link);
	}
	function getquery(){
		return $this->thequery;
	}
	function getnumrows($result){
		return mysql_num_rows($result);
	}
	function fetcharray($result){
		return mysql_fetch_array($result);
	}
	function close(){
		mysql_close($this->link);
	}
}
?>