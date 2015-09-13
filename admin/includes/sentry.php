<?php
class sentry{
	var $loggedin=false;
	var $userdata;
	function sentry(){
		session_start();
		header("Cache-control: private");
	}
	function logout(){
		unset($this->userdata);
		session_destroy();
		return true;
	}
	function checklogin($user, $pass){
		require_once('dbconnector.php');
		$loginconnector = new dbconnector();
		if(!$user || !$pass){
			header("Location: login.php?action=fallo2") ;
		}
		else{
			$getuser = $loginconnector->query("SELECT * FROM users WHERE nombre = '".$user."' AND pasando='".md5($pass)."'");
			$this->userdata = $loginconnector->fetcharray($getuser);
			if ($loginconnector->getnumrows($getuser) > 0){
				$_SESSION["user"] = $user;
				$_SESSION["group"] = $this->userdata["grupo"];
				$_SESSION['iden'] = $this->userdata["id"];
				$_SESSION['creden'] = '';
				if($_SESSION['group']==1){
					header("Location: index.php");
				}
				return true;
			}
			else{
				unset($this->userdata);
				header("Location: login.php?action=fallo");
				return false;
			}
		}			
	}
}
?>