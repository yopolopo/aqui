<?php

// Return the filename
function get_filename($object_id, $type) {
    // Generate filename based on object_id and type
    return substr(md5( $object_id ), 0 , 20) . (empty($type) ? '' : "-$type"); 
}

// Save image to database
// You can define here where and how you save your images
function imgPickerDB($image, $object_id, $type = '', $data = array()) {
    // $image - is the image file
    // $object_id - is the userID from api.php or a custom id
    // $type - is the type of the image (avatar/cover/background/...)
    // $data - custom data 

	if($type=='avatar'){ $_SESSION['fotofrente']=$image; }
	if($type=='avatar1'){ $_SESSION['fotoderecha']=$image; }
	if($type=='avatar2'){ $_SESSION['fotoizquierda']=$image; }
	if($type=='avatar3'){ $_SESSION['seriepulgar']=$image; }
	if($type=='avatar4'){ $_SESSION['serieindice']=$image; }
	if($type=='avatar5'){ $_SESSION['seriemedio']=$image; }
	if($type=='avatar6'){ $_SESSION['serieanular']=$image; }
	if($type=='avatar7'){ $_SESSION['seriemenique']=$image; }
	if($type=='avatar8'){ $_SESSION['seccionpulgar']=$image; }
	if($type=='avatar9'){ $_SESSION['seccionindice']=$image; }
	if($type=='avatar10'){ $_SESSION['seccionmedio']=$image; }
	if($type=='avatar11'){ $_SESSION['seccionanular']=$image; }
	if($type=='avatar12'){ $_SESSION['seccionmenique']=$image; }
	if($type=='avatar13'){ $_SESSION['grafoscopica']=$image; }
    // !!! Comment this if you want to save your images    
    return false;
    
    // Connect to database
    /*$db_name = 'imgPicker'; // Database name
    $db_user = 'root';      // Database user
    $db_pass = '';          // Database password
    $db_host = 'localhost'; // Database host

    db_connect($db_name, $db_user, $db_pass, $db_host);

    //Table name & table fields
    $db_table = 'images';
    $id_field = 'object_id';
    $type_field  = 'type';
    $image_field = 'image';

    $where = (!empty($type)) ? " AND $type_field = '$type'" : '';
    $query = "SELECT $id_field FROM $db_table WHERE $id_field = $object_id $where LIMIT 1";
    $result = @mysql_query($query);
    if (@mysql_num_rows($result)) {
        
        // Update
        $query = "UPDATE $db_table SET $image_field = '$image' WHERE $id_field = $object_id $where LIMIT 1";
        @mysql_query($query);

        return true;
    }
    else {
        if (!empty($type)) {
            $type_field = ", $type_field";
            $type = ", '$type'";
        }

        // Insert
        $query = "INSERT INTO  $db_table ($id_field, $image_field $type_field) VALUES ($object_id, '$image' $type)";
        if (@mysql_query($query)) {
            return true;
        }
    }
    return false;*/
}

// Connect to database
function db_connect($db_name, $db_user, $db_pass, $db_host = 'localhost') {
    $db = @mysql_connect($db_host, $db_user , $db_pass) or die('<h1>Error establishing a database connection</h1>');
    @mysql_select_db($db_name , $db) or die('<h1>Error establishing a database connection</h1>');
}

?>