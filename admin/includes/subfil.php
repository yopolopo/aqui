<?php
function SubirImagen($tmp,$size,$type,$image){
	if($tmp){
		if ($size<10000000){
			if(move_uploaded_file($tmp, $image)){
				$papa=1;
				return $papa;
			}
			else{
				$papa=2;
				return $papa;
			}
		}
		else{
			$papa=2;
			return $papa;
		}
	}
}
?>