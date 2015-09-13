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
		<h2>Change Background (auto upload)</h2>
		
		<button type="button" class="edit-background btn btn-info">Edit Background</button>

		<p>More examples: 
		<a href="index.php">Example 1</a> | <a href="example2.php">Example 2</a> | <a href="example3.php">Example 3</a> | <a href="example5.php">Example 5</a>
		</p>

	</div>

	<script>
		$(function() {
			// Background
			$('.edit-background').imgPicker({
				el: '', // No element
				type: 'background',
				title: 'Change background',
				webcam: false,
				// Auto open uploader
				open: 'upload',
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