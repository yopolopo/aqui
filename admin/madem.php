<?php
include("markxml.php");
require_once('includes/sentry.php');
$thesentry = new sentry();
if(!$_SESSION['user']){
	header("Location: login.php");
}
require_once('includes/dbconnector.php');
$con=new dbconnector();
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
<script src="js/prototype.js"/></script>
<script src="js/ObjTree.js"></script>
<script src="js/util.js"></script>
<script type="text/javascript" src="js/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
	var marcador;
	var hy=1;
	var gicons = [];
	var side_bar_html = "";
	var gmarkers = [];
	var htmls1 = [];
	var htmls2 = [];
	var j = 0;
	var i = 0;
	var map;
	var geo;
    var reasons=[];
	var xmlDoc;
	var marker=[];
	var icono='48/pin1.png';
	var icono1='48/pin2.png';
	var icono2='48/pin3.png';
	var icono3='48/pin4.png';
	var icono4='48/pin6.png';
	function createMarker(marca,map,infoWindow,html) {
		google.maps.event.addListener(marca, 'mouseover', function() {
			infoWindow.setContent(html);
			infoWindow.open(map, marca);
		});
	}
	function inicio(){
		new Ajax.Request
		('marcadors.xml', { onSuccess:initialize, onFailure:errFunc});
	}
	function errFunc(){ }
	function initialize(t){
		var myOptions = {
			zoom: 3,
			center: new google.maps.LatLng(20.635716097114468, -87.06959009170532),
			navigationControl: true,
			scaleControl: true,
			disableDoubleClickZoom: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map=new google.maps.Map(document.getElementById("mapas"),myOptions);
		var infoWindow = new google.maps.InfoWindow;
		var xotree = new XML.ObjTree();
		tree = xotree.parseXML( t.responseText );
		var marcadores=tree["markers"].marker;
		var txt="";
		for(i=0;i<marcadores.length;i++){
			var lat = parseFloat(marcadores[i].lat);
			var lng = parseFloat(marcadores[i].lng);
			var point = new google.maps.LatLng(lat,lng);
			var idtype = marcadores[i].id_type;
			if(idtype==1){ var puntero=icono; }
			if(idtype==2){ var puntero=icono1; }
			if(idtype==3){ var puntero=icono2; }
			if(idtype==4){ var puntero=icono3; }
			if(idtype==5){ var puntero=icono4; }
			var name = marcadores[i].marcador;
			var ima = marcadores[i].image;
			if(ima==''){
				ima='#';
			}
			var html1 = "<a href='"+ima+"' target='_blank'><img src='"+ima+"' width='150px' height='110px' /></a><p>"+name+"</p>";
			var marca = new google.maps.Marker({
				map: map,
				icon: puntero,
				position: point,
				myname: name
			});
			marker.push(marca);
			createMarker(marca,map,infoWindow,html1);
		}
		var markerCluster = new MarkerClusterer(map, marker);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini" onload="inicio();">
<div class="wrapper">
	<?php include("header.php"); ?>
    <?php include("menu.php"); ?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1><h2>Mapa de Demandas</h2></h1>
		</section>
		<section class="content">
			<div class="row">
				<section class="col-lg-12 connectedSortable">
					<div class="box">
						<div id="mapas"></div>
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
