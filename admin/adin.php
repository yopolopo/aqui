<?php
require_once('includes/sentry.php');
$thesentry = new sentry();
if(!$_SESSION['user']){
	header("Location: login.php");
}
require_once('includes/dbconnector.php');
$con=new dbconnector();
if($_GET['act']=='add'){
	include('includes/subima.php');
	$nombre=$_FILES['imag']['name'];
	$destino="iniciativa/";
	$image=$destino.$nombre;
	SubirImagen($_FILES['imag']['tmp_name'],$_FILES['imag']['size'],$_FILES['imag']['type'],$image);
	$con->query("INSERT INTO iniciativas(titulo,descripcion,texto,imagen) VALUES('".mysql_escape_string($_POST['titu'])."','".mysql_escape_string($_POST['rese'])."',
		'".mysql_escape_string($_POST['desc'])."','".$image."')");
	header("Location: adin.php?act=si");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="iso-8859-1">
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
<script>
	<?php
	if($_GET['act']=='si'){ echo "alert('Se ha guardado exitosamente.');"; }
	?>
	window.onload=function(){
		if(document.form1){
			document.form1.titu.focus();
		}
	}
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php include("header.php"); ?>
<?php include("menu.php"); ?>
	<div class="content-wrapper">
        <section class="content-header">
			<h1>
				Alta de Iniciativas
			</h1>
        </section>
		<section class="content">
			<div class="row">
				<div class="col-md-10">
					<div class="box box-info">
						<form enctype="multipart/form-data" method="post" name="form1" action="adin.php?act=add">
						<div class="box-body">
							<div class="input-group">
								<span class="input-group-addon">Titulo</span>
								<input type="text" name="titu" required class="form-control">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Reseña</span>
								<textarea name="rese" cols="37" rows="2" required class="form-control"></textarea>
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Descripci&oacute;n</span>
								<textarea name="desc" cols="37" rows="5" required class="form-control"><?php echo $_POST['desc']; ?></textarea>
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Imagen</span>
								<input type="file" name="imag" required class="form-control">
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
