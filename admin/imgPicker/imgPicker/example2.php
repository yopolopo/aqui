<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Image Picker</title>
	
	<!-- Only for demo -->
	<link rel="stylesheet" href="assets/css/demo.css">

	<link rel="stylesheet" href="assets/css/imgPicker.css">
	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<script src="assets/js/imgPicker.js"></script>

</head>
<body>
	<div id="container">
		<h2>Avatar modal example</h2>
		<img src="assets/img/default_avatar.png" class="avatar" width="90" height="90">
		<button type="button" class="edit-avatar btn btn-info">Edit</button>
		
		<p>More examples: 
		<a href="index.php">Example 1</a> | <a href="example3.php">Example 3</a> | <a href="example4.php">Example 4</a> | <a href="example5.php">Example 5</a>
		</p>
	
	</div>

	<script>
		$(function() {
			// Avatar
			$('.edit-avatar').imgPicker({
				el: '.avatar',
				type: 'avatar',
				minWidth: 90,
				minHeight: 90,
				title: 'Change your avatar'
			});
		});
	</script>
</body>
</html>