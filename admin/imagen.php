<?php
set_time_limit(0);
date_default_timezone_set("Mexico/BajaSur");
include("includes/dbconnector.php");
$con=new dbconnector();
if($_GET['dem']!=''){
	$sql=$con->query("SELECT * FROM demanda WHERE id='".$_GET['dem']."'");
	$row=$con->fetcharray($sql);
	$imagen=$row['imagen'];
}
?>
<html lang="en">
<head>
<title>Demanda Ciudadana - Imagen</title>
</head>
<body>
<img height="700" width="550" src="<?php echo $imagen; ?>"></div>
</body>
</html>