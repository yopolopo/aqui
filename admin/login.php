<?php
require_once("includes/sentry.php");
$sentry = new sentry();
$sentry->sentry();
require_once('includes/dbconnector.php');
$con=new dbconnector();
if ($_POST['user'] != ''){
	$sentry->checklogin($_POST['user'],$_POST['pass']);
}
if ($_GET['action'] == 'logout'){
	if ($sentry->logout()){ }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Demanda Ciudadana</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<b>Demanda</b> Ciudadana
	</div>
	<div class="login-box-body">
		<form action="login.php" method="post">
		<div class="form-group has-feedback">
			<input type="text" name="user" class="form-control" placeholder="Usuario">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" name="pass" class="form-control" placeholder="Password">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Inicia Sesión</button>
			</div>
		</div>
		</form>
	</div>
</div>
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
	$(function () {
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
	});
</script>
</body>
</html>
