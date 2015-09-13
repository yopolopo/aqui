<?php
require_once('includes/sentry.php');
$thesentry = new sentry();
if(!$_SESSION['user']){
	header("Location: login.php");
}
require_once('includes/dbconnector.php');
$con=new dbconnector();
if($_GET['act']=='add'){
	$sql=$con->query("SELECT count(id) as total FROM demanda WHERE ids=".$_POST['serv']);
	$row=$con->fetcharray($sql);
	$folio=$_POST['serv'].($row['total']+1);
	if($_POST['name']!='' && $_POST['apel']!='' && $_POST['tele']!=''){
		$sql=$con->query("SELECT * FROM cliente WHERE telefono='".$_POST['tele']."'");
		if($con->getnumrows($sql)>0){
			$row=$con->fetcharray($sql);
			$idc=$row['id'];
			$con->query("UPDATE cliente SET nombre='".$_POST['name']."', apellido='".$_POST['apel']."', telefono='".$_POST['tele']."' WHERE id=".$idc);
		}
		else{
			$contra=rand(10000000,99999999);
			$con->query("INSERT INTO cliente(nombre,apellido,telefono,pasando) VALUES('".$_POST['name']."','".$_POST['apel']."','".$_POST['tele']."',
				'".md5($contra)."')");
			$sql=$con->query("SELECT * FROM cliente WHERE telefono='".$_POST['tele']."'");
			$row=$con->fetcharray($sql);
			$idc=$row['id'];
			$con->query("INSERT INTO quea(nombre,idc) VALUES('".$contra."','".$idc."')");
		}
		$con->query("INSERT INTO demanda(folio,idc,ids,comentario,latitud,longitud,estatus) VALUES('".$folio."','".$idc."','".$_POST['serv']."','".$_POST['come']."',
			'".$_POST['lat']."','".$_POST['lng']."',1)");
	}
	else{
		$idc=0;
		$con->query("INSERT INTO demanda(folio,idc,ids,comentario,latitud,longitud,estatus) VALUES('".$folio."','".$idc."','".$_POST['serv']."','".$_POST['come']."',
			'".$_POST['lat']."','".$_POST['lng']."',1)");
	}
	header("Location: newdem.php?act=si");
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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true" type="text/javascript"></script>
<script>
	<?php
	if($_GET['act']=='si'){ echo "alert('Se ha guardado exitosamente.');"; }
	?>
	window.onload=function(){
		if(document.form1){
			document.form1.user.focus();
		}
	}
	var marcador;
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
			zoom: 16,
			center: new google.maps.LatLng(20.635716097114468, -87.06959009170532),
			navigationControl: true,
			scaleControl: true,
			disableDoubleClickZoom: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map=new google.maps.Map(document.getElementById("map"),myOptions);
		muestraCoord(new google.maps.LatLng(20.635716097114468, -87.06959009170532),map,infoWindow);
		google.maps.event.addListener(map, 'dblclick', function(event) {
			muestraCoord(event.latLng,map,infoWindow);
		});
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(function(position){
				var posi = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
				map.setCenter(posi);
				muestraCoord(posi,map,infoWindow);
			});
		}
	}
	function muestraCoord(location,map,infoWindow){
		if(marcador){
			marcador.setMap(null);
		}
		coordenadas(location);
		marcador=new google.maps.Marker({
			position:location,
			draggable:true
			//icon:blueIcon
		});
		var html= '<div style="height:40px; width:200px;">'+
      	   	"<p>Aqui se creara la localizacion de la demanda</p>" +
			"</div>";
		google.maps.event.addListener(marcador, "click", function(){
			infoWindow.setContent(html);
			infoWindow.open(map, marcador);
		});
		google.maps.event.addListener(marcador, "dragstart", function(){
			infoWindow.close();
		});
		google.maps.event.addListener(marcador, 'dragend', function(){
			var locacion=marcador.getPosition();
			coordenadas(locacion);
			html= '<div style="height:40px; width:200px;">'+
				"<p>Aqui se creara la localizacion de la demanda</p>" +
				"</div>";
		});
		marcador.setMap(map);
	}
	function coordenadas(location){
		var lat = location.lat();
		var lng = location.lng();
		document.getElementById('lat').value=lat;
		document.getElementById('lng').value=lng;
	}
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini" onload="hecho();">
<div class="wrapper">
	<?php include("header.php"); ?>
    <?php include("menu.php"); ?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1><h2>Crear Demanda</h2></h1>
		</section>
		<section class="content">
			<div class="row">
				<section class="col-lg-12 connectedSortable">
					<div class="box">
						<div class="row">
							<section class="col-md-9">
								<form method="post" name="form1" action="newdem.php?act=add">
								<fieldset class="fieldset">
									<legend class="legend">Datos</legend>
									<div id="map"></div>
									<input type="hidden" name="lat" id="lat" />
									<input type="hidden" name="lng" id="lng" />
									<br />
									<div class="form-group">
										<label for="name">Nombre</label>
										<input type="text" name="name" id="name" class="form-control" placeholder="Nombre del Contacto" value="<?php echo $_POST['name']; ?>" />
									</div>
									<div class="form-group">
										<label for="apel">Apellido</label>
										<input type="text" name="apel" id="apel" class="form-control" placeholder="Apellido del Contacto" value="<?php echo $_POST['apel']; ?>">
									</div>
									<div class="form-group">
										<label for="tele">Telefono</label>
										<input type="text" name="tele" id="tele" class="form-control" placeholder="Telefono del Contacto" value="<?php echo $_POST['tele']; ?>">
									</div>
									<div class="form-group">
										<label for="serv">Categoria del Servicio</label>
										<select name="serv" id="serv" class="form-control validate[required]">
											<option value="0">Escoge la Categoria</option>
											<?php
											$sql=$con->query("SELECT * FROM servicio");
											while($row=$con->fetcharray($sql)){
												echo '<option value="'.$row['id'].'"';
												if($_POST['serv']==$row['id']){ echo ' selected="selected"'; }
												echo '>'.$row['nombre'].'</option>';
											}
										?>
										</select>
									</div>
									<div class="form-group">
										<label for="come">Comentario</label>
										<textarea name="come" id="come" cols="37" rows="3" class="form-control validate[required]"><?php echo $_POST['come']; ?></textarea>
									</div>
									<div class="button-height"><button type="submit" class="button blue-gradient">Guardar</button></div>
								</fieldset>
								</form>
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
