<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Image Picker</title>
	
	<!-- Only for demo -->
	<link rel="stylesheet" href="assets/css/demo.css">

	<link rel="stylesheet" href="assets/css/imgPicker.css">
	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<script src="assets/js/imgPicker.min.js"></script>

</head>
<body>
	<div id="container">
		<div id="cover_container">
			<img src="assets/img/default_cover.jpg" class="cover" width="630" height="178">
			<button type="button" class="edit-cover btn btn-default">Edit Cover</button>
		</div>
		
		<div id="avatar_container">
			<img src="assets/img/default_avatar.png" class="avatar" width="90" height="90">
			<button type="button" class="edit-avatar btn btn-info">Edit</button>
		</div>
		
		<button type="button" class="edit-bg btn btn-info">Edit Background</button>
		
		<h1 class="logo">Image<span>Picker</span></h1>
		<p class="info">Uploader - Webcam - Cropper</p>

		<h2>Features:</h2>
		<ul>
			<li>Upload images</li>
			<li>Take pictures with your Webcam</li>
			<li>Cropping and resizing</li>
			<li>Works in all the major browsers, including IE7+ and mobile</li>
			<li>Touchescreen compatible</li>
			<li>Works with modal & inline</li>
			<li>Save images to database</li>
			<li>Options like aspect ratio, min/max width/height and more</li>
			<li>Easy to configure & customize</li>
		</ul>
		
		<p>More examples: 
		<a href="example2.php">Example 2</a> | <a href="example3.php">Example 3</a> | <a href="example4.php">Example 4</a> | <a href="example5.php">Example 5</a>
		</p>
		<h1 class="getit"><a href="http://codecanyon.net/user/HazzardWeb/portfolio">Get it Now !</a></h1>
	
	</div>

	<script>
		$(function() {
			// Avatar
			$('.edit-avatar').imgPicker({
				el: '.avatar',
				type: 'avatar',
				//aspectRatio: '1:1', // The aspect ratio is done automatically but you can set it manually
				minWidth: 90,
				minHeight: 90,
				title: 'Change your avatar' 
			});

			// Cover
			$('.edit-cover').imgPicker({
				el: '.cover',
				type: 'cover',
				title: 'Change cover',
				webcam: false
			});

			// Background
			$('.edit-bg').imgPicker({
				el: '', // No element	
				type: 'background',
				title: 'Change background',
				webcam: false,
				// Success callback
				complete: function(imageUrl) {
					// Set body background
					$('body').css('background-image', 'url("' + imageUrl + '")');
				}
			});
		});
	</script>
</body>
</html>