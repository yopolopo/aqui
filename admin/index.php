<?php
require_once('includes/sentry.php');
$thesentry = new sentry();
if(!$_SESSION['user']){
	header("Location: login.php");
}
require_once('includes/dbconnector.php');
$con=new dbconnector();
if($_POST['things']){
	$things=serialize($_POST['things']);
	$things=unserialize($things);
	foreach ($things as $hey){
		$con->query("UPDATE demanda SET estatus=1 WHERE id=".$hey);
	}
}
if($_POST['thangs']){
	$thangs=serialize($_POST['thangs']);
	$thangs=unserialize($thangs);
	foreach ($thangs as $hey){
		$con->query("UPDATE demanda SET estatus=4 WHERE id=".$hey);
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
<script>
	<?php
	if($_GET['act']=='si'){ echo "alert('Se ha guardado exitosamente.');"; }
	if($_GET['act']=='si2'){ echo "alert('Se ha guardado exitosamente.');"; }
	if($_GET['act']=='no'){ echo "alert('Ya existe en la base de datos este empleado.');"; }
	?>
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<?php include("header.php"); ?>
    <?php include("menu.php"); ?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1><h2>Nuevas Demandas</h2></h1>
		</section>
		<section class="content">
			<div class="row">
				<section class="col-lg-12 connectedSortable">
					<div class="box">
						<form action="index.php" method="POST">
						<table class="table">
							<thead>
								<tr><th scope="col">Nombre</th><th scope="col">Email</th><th scope="col">Telefono</th><th scope="col">Status</th>
								<th scope="col">Servicio</th><th scope="col">Comentarios</th><th scope="col">Cancelar</th></tr>
							</thead>
							<tbody>
								<?php
								$sql=$con->query("SELECT * FROM demanda WHERE estatus=1 ORDER BY fecha DESC");
								if($con->getnumrows($sql)>0){
									while($row=$con->fetcharray($sql)){
										$sq=$con->query("SELECT * FROM cliente WHERE id=".$row['idc']);
										if($con->getnumrows($sq)>0){
											$dat=$con->fetcharray($sq);
										}
										else{
											$dat['nombre']='Anonimo';
										}
										$ql=$con->query("SELECT * FROM servicio WHERE id=".$row['ids']);
										$dut=$con->fetcharray($ql);
										echo '<tr><td><a href="deman.php?dem='.$row['id'].'">'.$dat['nombre'].' '.$dat['apellido'].'</a></td><td>'.$dat['correo'].'</td>
											<td>'.$dat['telefono'].'</td><td>Pendiente</td><td>'.$dut['nombre'].'</td><td>'.$row['comentario'].'</td>
											<td><input type="checkbox" value="'.$row['id'].'" name="thangs[]" /></td></tr>';
									}
								}
								else{
									echo '<tr><td>No hubo resultados</td></tr>';
								}
								?>
							</tbody>
						</table>
						<br />
						<center><button type="submit" class="button glossy mid-margin-left">
							<span class="button-icon"><span class="icon-tick"></span></span>
							Guardar
						</button></center>
						<br />
						</form>
					</div>
				</section>
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
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/knob/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/fastclick/fastclick.min.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>
