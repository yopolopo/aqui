<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Image Picker</title>
	
	<!-- Only for demo -->
	<link rel="stylesheet" href="assets/css/demo.css">

	<!-- Bootstrap-->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="assets/css/imgPicker.css">
	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<script src="assets/js/imgPicker.js"></script>
	
	<!-- Bootstrap-->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>
<body>
	<div id="container">
		<h2>Integration with Bootstrap</h2>

		<p><img src="assets/img/default_avatar.png" class="avatar" width="90" height="90"></p>

		<p>
			<button type="button" class="edit_avatar btn btn-info" data-toggle="modal" data-target="#myModal">Change avatar</button>
		</p>
	
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Integration with Bootstrap</h4>
		      </div>
		      <div class="modal-body">
		      	<div id="cropper"></div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


		<p>More examples: 
		<a href="index.php">Example 1</a> | <a href="example2.php">Example 2</a> | <a href="example3.php">Example 3</a> | <a href="example4.php">Example 4</a>
		</p>

	</div>

	<script>
		$(function() {
			// Avatar
			$('.edit_avatar').imgPicker({
				el: '.avatar',
				type: 'avatar',
				minWidth: 90,
				minHeight: 90,
				title: 'Change your avatar',
				// Inline cropper, inside Bootstrap modal
				inline: '#cropper',
				// Success callback
				complete: function() {
					// Hide modal
					$('#myModal').modal('hide');
				}
			});
		});
	</script>
</body>
</html>