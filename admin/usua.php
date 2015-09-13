<?php
require_once('includes/sentry.php');
$thesentry = new sentry();
if(!$_SESSION['user']){
	header("Location: login.php");
}
require_once('includes/dbconnector.php');
$con=new dbconnector();
if($_GET['act']=='add'){
	$sql=$con->query("SELECT * FROM users WHERE nombre='".$_POST['user']."'");
	if($con->getnumrows($sql)>0){
		$_GET['act']=='no';
	}
	else{
		$con->query("INSERT INTO users(nombre,pasando,grupo,noombre,appaterno,apmaterno) VALUES('".$_POST['user']."','".md5($_POST['pass'])."',1,'".$_POST['name']."',
			'".$_POST['appa']."','".$_POST['apma']."')");
		$sql=$con->query("SELECT * FROM users WHERE nombre='".$_POST['user']."'");
		$row=$con->fetcharray($sql);
		$con->query("INSERT INTO queu(idp,varia) VALUES('".$row['id']."','".$_POST['pass']."')");
		header("Location: usua.php?act=si");
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Nuevas Demandas</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
<link rel="stylesheet" href="plugins/morris/morris.css">
<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php include("header.php"); ?>
<?php include("menu.php"); ?>
	<div class="content-wrapper">
        <section class="content-header">
			<h1>
				Crear Nuevo Usuario
			</h1>
        </section>
		<section class="content">
			<div class="row">
				<div class="col-md-10">
					<div class="box box-info">
						<form action="usua.php?act=add" method="POST">
						<div class="box-body">
							<div class="input-group">
								<span class="input-group-addon">Usuario</span>
								<input type="text" name="user" required class="form-control">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Password</span>
								<input type="password" name="pass" required class="form-control">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Nombre del Empleado</span>
								<input type="text" name="name" required class="form-control">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Apellido Paterno</span>
								<input type="text" name="appa" required class="form-control">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Apellido Materno</span>
								<input type="text" name="apma" required class="form-control">
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>Version</b> 0.0.1 beta
		</div>
		<strong>Copyright &copy; 2015 GCPC.</strong> All rights reserved.
	</footer>
</div>
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/fastclick/fastclick.min.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>
