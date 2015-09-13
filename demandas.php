<?php
include("admin/includes/dbconnector.php");
$con=new dbconnector();
if($_GET['pag']){
	$inicio=$_GET['pag'];
}
else{
	$inicio=0;
}
if($_GET['stat']==3){
	$_GET['act']='search';
	$_POST['stat']=3;
}
if($_GET['serv']!=''){
	$_GET['act']='search';
	$_POST['serv']=$_GET['serv'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include("header.php"); ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
	<?php
	if($_GET['fol']!=''){
		$sql=$con->query("SELECT * FROM demanda WHERE folio='".$_GET['fol']."'");
		$row=$con->fetcharray($sql);
		echo 'var lat='.$row['latitud'].'
		;';
		echo 'var lng='.$row['longitud'].'
		;';
		?>
		function hecho(t){
			var hy=1;
			var gicons = [];
			var gmarkers = [];
			var htmls1 = [];
			var j = 0;
			var marker;
			var i = 0;
			var map;
			var geo;
			var reasons=[];
			var xmlDoc;
			var pos;
			var infoWindow = new google.maps.InfoWindow;
			var myOptions = {
				zoom: 10,
				center: new google.maps.LatLng(lat,lng),
				navigationControl: true,
				scaleControl: true,
				disableDoubleClickZoom: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			var map=new google.maps.Map(document.getElementById("map2"),myOptions);
			var marcador=new google.maps.Marker({
				position: new google.maps.LatLng(lat,lng),
				//icon:blueIcon
			});
			marcador.setMap(map);
		}
	<?php } ?>
</script>
</head>
<body <?php if($_GET['fol']!=''){ echo 'onload="hecho();"'; } ?> class="theme-invert">
<?php include("menu.php"); ?>
<section class="section" id="head">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">	
				<?php if($_GET['fol']==''){ ?><h1 class="title">Tickets</h1><br /><br /><br /><?php }
				else{ ?><h1 class="title">Ticket #<?php echo $_GET['fol']; ?>.</h1><?php } ?>
			</div>
		</div>
		<div class="linea">
			<?php if($_GET['fol']==''){ ?>
				<div class="row">
					<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">
						<div class="col-sm-12">
							<form id="topics-filter" method="POST" action="demandas.php?act=search">
								<h5 class="bold">FILTRAR</h5>
								<input type="text" name="folio" placeholder="#Folio" />
								<select name="serv" class="one">
									<option value="0">Servicios</option>
									<?php
									$sql=$con->query("SELECT * FROM servicio");
									while($row=$con->fetcharray($sql)){
										echo '<option ';
										if($_POST['serv']==$row['id']){ echo 'selected="selected"'; }
										echo 'value="'.$row['id'].'">'.$row['nombre'].'</option>';
									}
									?>
								</select>
								<select name="stat" class="two">
									<option value="0">Status</option>
									<?php
									$sql=$con->query("SELECT * FROM estatus WHERE id IN (1,2,3)");
									while($row=$con->fetcharray($sql)){
										echo '<option ';
										if($_POST['stat']==$row['id']){ echo 'selected="selected"'; }
										echo 'value="'.$row['id'].'">'.$row['nombre'].'</option>';
									}
									?>
								</select><br /><br />
								<input type="submit" id="searchsubmit" value="Buscar" />
							</form>
						</div>
					</div>
					<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
						<div class="col-sm-12">
							<?php
							$cond='';
							if($_GET['act']=='search'){
								$done=0;
								if($_POST['serv']>0){ $cond.='WHERE ids='.$_POST['serv']; $done=1; }
								if($_POST['stat']>0){
									if($done==0){ $cond.='WHERE estatus='.$_POST['stat']; $done=1; }
									else{ $cond.=' AND estatus='.$_POST['stat']; }
								}
								else{
									if($done==0){ $cond.='WHERE estatus IN (1,2,3)'; $done=1; }
									else{ $cond.=' AND estatus IN (1,2,3)'; }
								}
								if($_POST['folio']!=''){
									if($done==0){ $cond.='WHERE folio="'.$_POST['folio'].'"'; $done=1; }
									else{ $cond.=' AND folio="'.$_POST['folio'].'"'; }
								}
							}
							else{
								$cond='WHERE estatus IN (1,2,3)';
							}
							echo '<div class="encierro2">';
							$sql=$con->query("SELECT * FROM demanda ".$cond." ORDER BY fecha DESC LIMIT ".$inicio.",10");
							$lim=$con->getnumrows($sql);
							while($row=$con->fetcharray($sql)){
								echo '<a href="demandas.php?fol='.$row['folio'].'"><div class="row linke">';
								echo '<div class="right"><h5 class="opensans-bold">Folio '.$row['folio'].'</h5></div>';
								echo '<h6 class="opensans">'.$row['comentario'].'</h6>';
								echo '</div></a>';
							}
							echo '</div>';
							echo '<br />';
							echo '<center>';
							if($inicio>0){ echo '<h6><span class="current"><a href="demandas.php?pag='.($inicio-10).'">Atras</a></span></h6>'; }
							echo '<h6>'.$inicio.' a '.($inicio+10).'</h6>';
							if($lim==10){ echo '<h6><span class="current"><a href="demandas.php?pag='.($inicio+10).'">next</a></span></h6>'; }
							echo '</center>';
							?>
						</div>
					</div>
				</div>
				<?php
			}
			else{
				$sql=$con->query("SELECT * FROM demanda WHERE folio='".$_GET['fol']."'");
				$row=$con->fetcharray($sql);
				?>
				<div class="row">
					<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
						<div class="col-sm-5">
							<div class="container">
								<div class="hq-info">
									<img class="callate" src="admin/<?php echo $row['imagen']; ?>" />
									<h6 class="opensans-bold white"><?php echo $row['comentario']; ?></h6>
									<br /><br />
									<h4 class="opensans-bold white">Respuesta:</h4>
									<h6 class="opensans-bold white"><?php echo $row['respuesta']; ?></h6>
								</div>
							</div>
						</div>
						<div class="col-sm-7"><div id="map2"></div></div>
						<div class="clear"></div>
					</div>
				</div>
				<?php
			}
			?>
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