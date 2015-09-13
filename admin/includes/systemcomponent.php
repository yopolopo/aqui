<?php
class systemcomponent{
	var $settings;
	function getsettings(){
		$settings['dbhost']='localhost';
		$settings['dbusername']='root';
		$settings['dbpassword']='';
		$settings['dbname']='demanda';
		return $settings;
	}
}
?>