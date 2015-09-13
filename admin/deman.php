<?php
require_once('includes/sentry.php');
$thesentry = new sentry();
if(!$_SESSION['user']){
	header("Location: login.php");
}
require_once('includes/dbconnector.php');
$con=new dbconnector();
if($_GET['act']=='res'){
	$con->query("UPDATE demanda SET estatus='".$_POST['stat']."', respuesta='".mysql_escape_string($_POST['resp'])."' WHERE id=".$_GET['dem']);
	header("Location: deman.php?dem=".$_GET['dem']);
}
if($_GET['act']=='nota'){
	$con->query("INSERT INTO notademanda(idd,nota,idu) VALUES('".$_GET['dem']."','".$_POST['nota']."','".$_SESSION['iden']."')");
	header("Location: deman.php?dem=".$_GET['dem']);
}
if($_GET['dem']>0){
}
else{
	header("Location: demanda.php");
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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<?php include("header.php"); ?>
    <?php include("menu.php"); ?>
	<div class="content-wrapper">
		<?php
		$sql=$con->query("SELECT * FROM demanda WHERE id=".$_GET['dem']);
		$row=$con->fetcharray($sql);
		?>
		<section class="content-header">
			<h1><h2>Demanda #<?php echo $row['folio']; ?></h2><small>Creada en <?php echo $row['fecha']; ?>.</small></h1>
			<p><strong>Comentario: </strong><?php echo $row['comentario']; ?></p>
		</section>
		<section class="content">
			<div class="row">
				<section class="col-lg-12 connectedSortable">
					<div class="box">
						<div class="row">
							<section class="col-md-7">
								<form name="demanda" action="deman.php?dem=<?php echo $_GET['dem']; ?>&act=res" method="POST">
								<div class="form-group">
									<label for="stat">Status: </label>
									<select class="form-control" name="stat">
										<?php
										$sq=$con->query("SELECT * FROM estatus");
										while($dat=$con->fetcharray($sq)){
											echo '<option';
											if($row['estatus']==$dat['id']){ echo ' selected="selected"'; }
											echo ' value="'.$dat['id'].'">'.$dat['nombre'].'</option>';
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="resp">Respuesta: </label>
									<textarea class="form-control" name="resp" cols="60" rows="5"><?php echo $row['respuesta']; ?></textarea>
								</div>
								<center>
									<a href="#" onclick="document.demanda.submit();" class="btn btn-primary">Guardar</a>
								</center>
								</form>
								<form name="nota" action="deman.php?dem=<?php echo $_GET['dem']; ?>&act=nota" method="POST">
								<div class="form-group">
									<label for="resp">Añadir Nota: </label>
									<textarea class="form-control" name="nota" cols="60" rows="5"></textarea>
								</div>
								<center>
									<a href="#" onclick="document.nota.submit();" class="btn btn-primary">Guardar</a>
								</center>
								</form>
								<br />
							</section>
							<section class="col-md-5">
								<div class="block-title">
									<h3>Notas</h3>
								</div>
								<table class="table">
									<thead>
										<tr><th scope="col">Nota</th><th scope="col">Usuario</th></tr>
									</thead>
									<tbody>
										<?php
										$sq=$con->query("SELECT * FROM notademanda WHERE idd=".$_GET['dem']);
										if($con->getnumrows($sq)>0){
											while($dat=$con->fetcharray($sq)){
												echo '<tr><td>'.$dat['nota'].'</td>';
												$ql=$con->query("SELECT * FROM users WHERE id=".$dat['idu']);
												$dut=$con->fetcharray($ql);
												echo '<td>'.$dut['nombre'].'</td></tr>';
											}
										}
										else{
											echo '<tr><td>No hubo resultados</td></tr>';
										}
										?>
									</tbody>
								</table>
							</section>
						</div>
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
