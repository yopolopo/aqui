<?php
include("admin/includes/dbconnector.php");
include('admin/includes/mail.php');
$con=new dbconnector();
if($_GET['act']=='ins'){
	include('admin/includes/subima.php');
	$nombre=$_FILES['imag']['name'];
	$destino="admin/imagenes/";
	$image=$destino.$nombre;
	$imagen='imagenes/'.$nombre;
	SubirImagen($_FILES['imag']['tmp_name'],$_FILES['imag']['size'],$_FILES['imag']['type'],$image);
	$sql=$con->query("SELECT count(id) as total FROM demanda WHERE ids=".$_POST['serv']);
	$row=$con->fetcharray($sql);
	$folio=$_POST['serv'].($row['total']+1);
	if($_POST['name']!='Nombre' || $_POST['corr']!='Correo'){
		$sql=$con->query("SELECT * FROM cliente WHERE correo='".$_POST['corr']."'");
		if($con->getnumrows($sql)>0){
			$row=$con->fetcharray($sql);
			$idc=$row['id'];
			//$con->query("UPDATE cliente SET nombre='".$_POST['name']."', apellido='".$_POST['apel']."', correo='".$_POST['corr']."', telefono='".$_POST['tele']."' WHERE id=".$idc);
		}
		else{
			$con->query("INSERT INTO cliente(nombre,apellido,correo,telefono) VALUES('".$_POST['name']."','".$_POST['apel']."','".$_POST['corr']."','".$_POST['tele']."')");
			$sql=$con->query("SELECT * FROM cliente WHERE nombre='".$_POST['name']."' AND apellido='".$_POST['apel']."' AND correo='".$_POST['corr']."' AND 
				telefono='".$_POST['tele']."'");
			$row=$con->fetcharray($sql);
			$idc=$row['id'];
		}
		echo '<div class="creado">cliente</div>';
		$con->query("INSERT INTO demanda(folio,idc,ids,comentario,imagen,latitud,longitud,estatus) VALUES('".$folio."','".$idc."','".$_POST['serv']."','".$_POST['come']."',
			'".$imagen."','".$_POST['lat']."','".$_POST['lng']."',1)");
	}
	else{
		$idc=0;
		echo '<div class="creado">anonimo</div>';
		$con->query("INSERT INTO demanda(folio,idc,ids,comentario,imagen,latitud,longitud,estatus) VALUES('".$folio."','".$idc."','".$_POST['serv']."','".$_POST['come']."',
			'".$imagen."','".$_POST['lat']."','".$_POST['lng']."',1)");
	}
	if($_POST['corr']!='Correo'){
		$html = new lib_mail;
		$html->sender('admin@demos.ntechnow.com', 'Demanda Ciudadana');
		$html->addTo($_POST['corr']);
		$html->addCc('admin@demos.ntechnow.com');
		$html->subject('Numero de folio del ticket para seguimiento');
		$html->html('<p><a href="demos.ntechnow.com/demandas/demandas.php?fol='.$folio.'">Este sera el link para el seguimiento de su ticket, se le agradece su participaci&oacute;n 
			en esta campa&ntilde;a de mejora de gobierno</a></p>', true);
		$html->send();
	}
	header("Location: submit-ticket.php?act=listo&folio=".$folio);
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>TICKETRAMA - Submit Ticket</title>
<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="stylesheets/base.css">
<link rel="stylesheet" href="stylesheets/skeleton.css">
<link rel="stylesheet" href="stylesheets/layout.css">
<link rel="stylesheet" href="stylesheets/style.css">
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="shortcut icon" href="images/favicon.ico">
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true" type="text/javascript"></script>
<script type="text/javascript">
	function Chequeo(){
		var error='';
		var no=0;
		var nuv=document.getElementById('serv');
		var valor=nuv.options[nuv.selectedIndex].value;
		if(valor==0){
			error += 'Servicio \n';
			no=1;
		}
		nuv=document.getElementById('come').value;
		if(nuv=='Comentario'){
			error += 'Comentario \n';
			no=1;
		}
		nuv=document.getElementById('uploadFile').value;
		if(nuv!=''){
			var str=document.getElementById('uploadBtn').value.toUpperCase();
			var suffix=".JPG";
			var suffix2=".JPEG";
			var suffix3=".PNG";
			var suffix4=".GIF";
			if(str.indexOf(suffix, str.length - suffix.length) == -1 && str.indexOf(suffix2, str.length - suffix2.length) == -1 && 
				str.indexOf(suffix3, str.length - suffix3.length) == -1 && str.indexOf(suffix4, str.length - suffix4.length) == -1){
				error += 'Imagen \n';
				no=1;
				document.getElementById('uploadBtn').value='';
			}
		}
		if(no==1){
			alert('Por favor checa los campos requeridos: \n'+error);
		}
		else{
			document.formula.submit();
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
		var html= "<table>"+
      	   	"<tr><td>Aqui se creara la localizacion de la demanda</td></tr>" +
			"</table>";
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
			html= "<table>"+
				"<tr><td>Aqui se creara la localizacion de la demanda</td></tr>" +
				"</table>";
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
<body class="transparent-bg" onload="hecho();">
<div class="container">
	<div class="sixteen columns">
		<?php
		if($_GET['act']=='listo'){
			?>
			<div class="creado">
				<h3 class="coral bold">Ticket creado</h3>
				<h3 class="coral bold">Link de Seguimiento: <a href="demandas.php?fol=<?php echo $_GET['folio']; ?>">Tu demanda</a></h3>
			</div>
			<?php
		}
		else{
			?>
			<form class="submit-ticket" name="formula" method="POST" enctype="multipart/form-data" action="submit-ticket.php?act=ins">
			<div class="left">
				<div id="map"></div>
				<input type="hidden" name="lat" id="lat" />
				<input type="hidden" name="lng" id="lng" />
				<select name="serv" id="serv">
					<option value="0">Escoge la Categoria</option>
					<?php
					$sql=$con->query("SELECT * FROM servicio");
					while($row=$con->fetcharray($sql)){
						echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
					}
					?>
				</select>
				<input type="hidden" class="half" id="uploadFile" placeholder="Escoge la imagen" disabled="disabled" />
				<div class="fileUpload btn btn-primary">
					<span id="Escribe">Subir Imagen</span>
					<input type="file" name="imag" id="uploadBtn" class="upload" />
				</div>
				<script type="text/javascript">
					document.getElementById("uploadBtn").onchange = function () {
						document.getElementById("uploadFile").value = this.value;
						document.getElementById("Escribe").innerHTML = this.value;
					};
				</script>
				<textarea name="come" id="come" onblur="if(this.value == '') { this.value='Comentario'}" onfocus="if (this.value == 'Comentario') {this.value=''}"/>Comentario</textarea>
				<input type="text" readonly="true" value="Para anonimo dejar todo asi" />
				<input class="half" type="text" name="name" id="name" value="Nombre" onblur="if(this.value == '') { this.value='Nombre'}" 
					onfocus="if (this.value == 'Nombre') {this.value=''}" />
				<input class="half" type="text" name="apel" id="apel" value="Apellido" onblur="if(this.value == '') { this.value='Apellido'}" 
					onfocus="if (this.value == 'Apellido') {this.value=''}" />
				<input class="half" type="text" name="corr" id="corr" value="Correo" onblur="if(this.value == '') { this.value='Correo'}" 
					onfocus="if (this.value == 'Correo') {this.value=''}" />
				<input class="half" type="text" name="tele" id="tele" value="Telefono" onblur="if(this.value == '') { this.value='Telefono'}" 
					onfocus="if (this.value == 'Telefono') {this.value=''}" />
				<input type="button" onclick="Chequeo();" value="Enviar" />
			</div>
			<!--<div onclick="Chequeo();" class="submit">
				<h3 class="coral bold">Enviar</h3>
				<div class="cross">
					<img src="images/plus-big.png" alt="">
				</div>
			</div>-->
			</form>
			<?php
		}
		?>
	</div>
</div>
</body>
</html>