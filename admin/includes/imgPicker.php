<?php
/**
* imgPicker
*/
class imgPicker
{
	private $config = array();
	private $upload_dir;

	function __construct($config) {
		$this->config = $config;
		$this->upload_dir = $config['upload_dir'];
	}

	// Function for the iframe upload
	public function upload($file, $type = '', $obj_id = null) {
		if (!isset($file['tmp_name'])) {
			$this->json_error( $this->error('upload_failed') );
		}
		
		if ( !array_key_exists($type, $this->config('types')) ) {
			$this->json_error( $this->error('undefined_type') );
		}
		
		if ($file['error']) {
			$this->json_error( $this->error($file['error']) );
		}
		
		if ($file['size'] > $this->config('max_file_size') * 100) {
			$this->json_error( $this->error('max_file_size') );
		}
		
		if (!preg_match('/.('.$this->config('image_types').')+$/i', $file['name'])) {
			$this->json_error( $this->error('accept_file_types') );
		}

		if (!is_dir($this->upload_dir)) {
			mkdir($this->upload_dir, 0755);
		}
		
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		$filename = get_filename($obj_id, $type).".$ext";
		$path = $this->upload_dir.basename('_'.$filename);
		
		if (!move_uploaded_file($file['tmp_name'], $path)) {
			$this->json_error( $this->error('move_failed') );
		}
		
		$this->check_image_size($path, $type);

		$_SESSION['_imgPicker'] = $filename;
		$this->json_success( $this->get_full_url()."/$path" );
	}

	public function save_cropped($data) {
		$obj_id = $data['obj_id'];
		$type   = $data['type'];
		$config = $this->config("types/$type");
		$image_data = explode(',', $data['image']);
		
		if ( !array_key_exists($type, $this->config('types') )) {
			$this->json_error( $this->error('undefined_type') );
		}

		// The image was uploaded with the iframe upload function
		if (empty($image_data[1])) {
			$filename = @$_SESSION['_imgPicker'];
			$original_path = $this->upload_dir.'_'.$filename;
			$path = $this->upload_dir.$filename;
			
			if (!is_file($original_path) || !@rename($original_path, $path)) {
				$this->json_error( $this->error('upload_failed') );
			}
		}
		// The image is sent as base64 data
		else {
			$filename = get_filename($obj_id, $type) . ".jpg";
			$path = $this->upload_dir.$filename;
			$original_path = $this->upload_dir."_$filename";
			$size = round((strlen($image_data[1]) - 814) / 1.37);
			if ($size > $this->config('max_file_size') * 1000) {
				$this->json_error( $this->error('max_file_size') );
			} 
		    
		    $handle = fopen($path , 'wb'); 
		    if (!$handle || empty($image_data[1])) {
		    	$this->json_error( $this->error('upload_failed') );
		    }
		    fwrite($handle, base64_decode($image_data[1]) ); 
		    fclose($handle);
		}

		//Make a copy for the original
	    if (isset($config['original'])) {
	    	@copy($path, $original_path);
	    }

		$this->check_image_size($path, $type);

		$crop_width  = @$config['crop_width'];
		$crop_height = @$config['crop_height'];
		$force_crop  = !empty($config['force_crop']) ? true : false;
		$image_width = $data['width'];
		$image_height = $data['height'];

		if (!empty($crop_width)) {
			if ( ($image_width > $crop_width) || ($image_width < $crop_width && $force_crop) ) {
				$new_width = $crop_width;
				$new_height = $image_height / $image_width * $crop_width;
			}
		} elseif (!empty($crop_height)) {
			if ( ($image_height > $crop_height) || ($image_height < $crop_height && $force_crop) ) {
				$new_height = $crop_height;
				$new_width = $image_width / $image_height * $crop_height;
			}
		}

		// Crop image
		$this->crop_image($path, $image_width, $image_height, $data['x'], $data['y'], @$new_width, @$new_height);

		// Save image to database callback
		imgPickerDB($filename, $obj_id, $type, @$data['data']);

		// Return cropped image
		$this->json_success( $this->get_full_url()."/$path" );
	}

	private function crop_image($path, $width, $height, $x, $y, $new_width = null, $new_height = null) {
		list($imagewidth, $imageheight, $image_type) = getimagesize($path);
	    
	    $image_type = image_type_to_mime_type($image_type);
	    $new_width = ($new_width) ? ceil($new_width) : $width;
	    $new_height = ($new_height) ? ceil($new_height) : $height;
	    $new_image = imagecreatetruecolor($new_width, $new_height);

	    switch ($image_type) {
	        case 'image/gif':
	            $source = imagecreatefromgif($path); 
	        break;
	        case 'image/pjpeg':
	        case 'image/jpeg':
	        case 'image/jpg':
	            $source = imagecreatefromjpeg($path); 
	        break;
	        case 'image/png':
	        case 'image/x-png':
	            $source = imagecreatefrompng($path); 
	        break;
	    }

	    imagecopyresampled($new_image, $source, 0, 0, $x, $y, $new_width, $new_height, $width, $height);
	    
	    switch ($image_type) {
	        case 'image/gif':
	            imagegif($new_image, $path);
	        break;
	        case 'image/pjpeg':
	        case 'image/jpeg':
	        case 'image/jpg':
	            imagejpeg($new_image, $path, 90); 
	        break;
	        case 'image/png':
	        case 'image/x-png':
	            imagepng($new_image, $path);  
	        break;
	    }

	    chmod($path, 0777);
	    return $path;
	}

	// Checks the min/max width/hight of the image
	private function check_image_size($path, $type) {
		$config = $this->config("types/$type");

		$min_width   = @$config['min_width'];
		$min_height  = @$config['min_height'];
		$max_width   = @$config['max_width'];
		$max_height  = @$config['max_height'];
		$min_width   = (empty($min_width)) ? 1 : $min_width;
		$min_height  = (empty($min_height)) ? 1 : $min_height;
		
		$size = @getimagesize($path);
		if ($size[0] < $min_width) {
			@unlink($path);
			$this->json_error( $this->error('min_width').$min_width.'px' );
		}
		if ($size[1] < $min_height) {
			@unlink($path);
			$this->json_error( $this->error('min_height').$min_height.'px' );
		}
		if ($max_width && $size[0] > $max_width) {
			@unlink($path);
			$this->json_error( $this->error('max_width').$max_width.'px' );
		}
		if ($max_height && $size[1] > $max_height) {
			@unlink($path);
			$this->json_error( $this->error('max_height').$max_height.'px' );
		}
	}


	private function get_full_url() {
	    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
	    return
	        ($https ? 'https://' : 'http://').
	        (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
	        (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
	        ($https && $_SERVER['SERVER_PORT'] === 443 ||
	        $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
	        substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
	}

	private function json_success($data = array()) {
		//header('Content-Type: application/json');
	    echo json_encode(array('success' => true, 'data' => $data));
	    exit;
	}

	private function json_error($data = array()) {
		//header('Content-Type: application/json');
	    echo json_encode(array('success' => false, 'data' => $data));
	    exit;
	}

	private function error($error) {
		if (isset($this->config['error_messages'][$error])) {
			return $this->config['error_messages'][$error];
		}
		return $error;
	}

	private function config($path) {
		$config = $this->config;
		$path = explode('/', $path);
		foreach ($path as $bit) {
			if (isset($config[$bit])) {
				$config = $config[$bit];
			} else $config = null;
		}
		return $config;
	}

	private function get_file_size($file_path, $clear_stat_cache = false) {
	    if ($clear_stat_cache) {
	        @clearstatcache(true, $file_path);
	    }
	    return fix_integer_overflow(filesize($file_path));
	}

	private function get_config_bytes($val) {
	    $val = trim($val);
	    $last = strtolower($val[strlen($val)-1]);
	    switch($last) {
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }
	    return $this->fix_integer_overflow($val);
	}

	private function fix_integer_overflow($size) {
	    if ($size < 0) {
	        $size += 2.0 * (PHP_INT_MAX + 1);
	    }
	    return $size;
	}
}