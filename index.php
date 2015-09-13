<?php
include("admin/includes/dbconnector.php");
$con=new dbconnector();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include("header.php"); ?>
<script>
	window.onload=function(){
		<?php if($_GET['act']=='listo'){ ?>
			if(confirm('Quieres ver tu ticket?')){
				window.location.href="demandas.php?fol=<?php echo $_GET['folio']; ?>";
			}
			else{ return false; }
		<?php } ?>
	}
</script>
</head>
<body class="theme-invert">
<?php include("menu.php"); ?>
<section class="section" id="head">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">	
				<h1 class="title">Demanda Ciudadana</h1><br /><br /><br />
			</div>
		</div>
		<div class="linea">
			<div class="row">
				<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">	
					<div class="col-sm-4">
						<a href="demandas.php"><div class="encierro">
							<h2 class="subtitle left alado">
								<?php
								$sql=$con->query("SELECT count(id) as total FROM demanda WHERE estatus IN (1,2,3)");
								$row=$con->fetcharray($sql);
								echo number_format($row['total']);
								?>
							</h2>
							<div class="overview-sub">
								<h5>Demandas</h5>
								<h5>Recibidas</h5>
							</div>
						</div></a>
					</div>
					<div class="col-sm-4">
						<a href="ticket.php"><div class="encierro">
							<div class="overview-sub">
								<h5 class="coral">A&ntilde;adir</h5>
								<h5 class="coral">Demanda</h5>
							</div>
						</div></a>
					</div>
					<div class="col-sm-4">
						<a href="demandas.php?stat=3"><div class="encierro">
							<h2 class="subtitle left alado">
								<?php
								$sql=$con->query("SELECT count(id) as total FROM demanda WHERE estatus=3");
								$row=$con->fetcharray($sql);
								echo number_format($row['total']);
								?>
							</h2>
							<div class="overview-sub">
								<h5 class="b-grey">Demandas</h5>
								<h5 class="b-grey">Solucionadas</h5>
							</div>
						</div></a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
					<div class="col-sm-6">
						<div class="encierro2">
							<h2>Demandas recientes</h2>
							<?php
							$sql=$con->query("SELECT comentario, folio FROM demanda WHERE estatus=1 ORDER BY fecha DESC LIMIT 0,5");
							while($row=$con->fetcharray($sql)){
								echo '<a href="demandas.php?fol='.$row['folio'].'"><div class="row linke"><h5 class="left">'.substr($row['comentario'],0,40);
								echo '</h5></div></a>';
							}
							?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="encierro2">
							<h2>Temas más demandados</h2>
							<?php
							$sql=$con->query("SELECT count(d.id) as total, s.nombre, s.id FROM demanda d INNER JOIN servicio s ON s.id=d.ids WHERE d.estatus IN (1,2,3) GROUP BY 
								d.ids ORDER BY total DESC LIMIT 0,5");
							while($row=$con->fetcharray($sql)){
								echo '<a href="demandas.php?serv='.$row['id'].'"><div class="row linke"><h5 class="opensans-bold right">'.$row['total'].'</h5>
									<h5>'.$row['nombre'].'</h5></div></a>';
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include("footer.php"); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.custom.72241.js"></script>
<!-- Custom template scripts -->
<script src="assets/js/magister.js"></script>
</body>
</html>