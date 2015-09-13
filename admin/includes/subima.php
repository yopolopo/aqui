<?php
function SubirImagen($tmp,$size,$type,$image){
	if($tmp){
		if ($size<10000000){
			if($type=="image/gif" || $type=="image/jpg" || $type=="image/png" || $type=="image/jpeg"){
				if(move_uploaded_file($tmp, $image)){
					$papa=1;
					return $papa;
				}
				else{
					
				}
			}
			else{
				
			}
		}
		else{
			
		}
	}
}
?>