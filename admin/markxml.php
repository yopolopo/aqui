<?php
require_once("includes/dbconnector.php");
$con=new dbconnector();
$getdata=$con->query("SELECT * FROM demanda");
$dir='marcadors.xml';
$xml=fopen($dir, 'w');
if($xml==NULL){
	echo "Error al abrir el archivo";
}
else{
	$escribir=fwrite($xml, '<?xml version="1.0" encoding="utf-8" standalone="yes"?>');
	$escribir=fwrite($xml, '<markers>');
	while($dataload=$con->fetcharray($getdata)){
		$escribir=fwrite($xml, '<marker><id>'.$dataload['id'].'</id><id_type>'.$dataload['ids'].'</id_type><marcador>'.$dataload['comentario'].'</marcador>
			<image>'.$dataload['imagen'].'</image><lat>'.$dataload['latitud'].'</lat><lng>'.$dataload['longitud'].'</lng></marker>');
	}
	$escribir=fwrite($xml, '</markers>');
}
fclose($xml);
?>