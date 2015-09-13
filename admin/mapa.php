<?php
set_time_limit(0);
date_default_timezone_set("Mexico/BajaSur");
include("includes/dbconnector.php");
$con=new dbconnector();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Demanda Ciudadana - Localizacion</title>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
	<?php
	if($_GET['dem']!=''){
		$sql=$con->query("SELECT * FROM demanda WHERE id='".$_GET['dem']."'");
		$row=$con->fetcharray($sql);
		echo 'var lat='.$row['latitud'].';
		';
		echo 'var lng='.$row['longitud'].';
		';
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
				zoom: 14,
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
	<?php }
	else{
		?>
		window.close();
	<?php } ?>
</script>
</head>
<body onload="hecho()">
<div id="map2" style="height:460px; width:660px;"></div>
</body>
</html>