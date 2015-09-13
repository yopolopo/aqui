<?php

// header('Access-Control-Allow-Origin: yourwebsite.com');
// header('Access-Control-Allow-Origin: www.yourwebsite.com');

session_start();

// Global user id | Comment this if you're using custom a custom object id
$userID = 1;

require_once 'config.php';
require_once 'functions.php';
require_once 'imgPicker.php';
$IP = new imgPicker($config);

if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		// Iframe upload action
		case 'upload':
			$file   = @$_FILES['ip-file'];
			$obj_id = isset($userID) ? $userID : $_POST['obj_id'];
			$type   = $_POST['type'];

			$IP->upload($file, $type, $obj_id);
		break;

		//HTML5 upload / webcam upload / iframe save \w crop
		case 'save':
			$_POST['obj_id'] = isset($userID) ? $userID : $_POST['obj_id'];
			$IP->save_cropped($_POST);
		break;
	}
}
?>