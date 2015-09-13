<?php
include("admin/includes/dbconnector.php");
$con=new dbconnector();
if($_GET['id']>0){
	$sql=$con->query("SELECT * FROM iniciativas WHERE id=".$_GET['id']);
	$row=$con->fetcharray($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("header.php"); ?>
<body class="theme-invert">
<?php include("menu.php"); ?>
<section class="section" id="head">
	<div class="container">
		<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
			<div class="row">
				<div class="col-sm-8">
					<h2 class="text-center title"><?php if($_GET['act']=='search'){
						echo 'Resultados de la Busqueda';
					}
					else{
						if($_GET['id']>0){ echo nl2br(stripslashes($row['titulo'])); } else{ echo 'Iniciativas'; } ?></h2>
					<?php } ?>
				</div>
				<div class="col-sm-4">
					<form method="POST" action="programas.php?act=search" id="topics-filter">
						<input size="40" type="text" name="busnom" value="<?php if($_POST['busnom']==''){ echo 'Buscar'; } else{ echo $_POST['busnom']; } ?>" 
							onblur="if (this.value == '') { this.value = 'Buscar' }" onfocus="if (this.value == 'Buscar') { this.value = '' }"/>
						<input type="submit" id="searchsubmit" value="Buscar" />
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
			<div class="linea2">
				<div class="row">
					<div class="col-sm-12">
						<?php
						if($_GET['act']=='search'){
							$sql=$con->query("SELECT * FROM iniciativas WHERE titulo LIKE '%".$_POST['busnom']."%' OR descripcion LIKE '%".$_POST['busnom']."%' OR 
								texto LIKE '%".$_POST['busnom']."%'");
							while($row=$con->fetcharray($sql)){
								?>
								<a href="programas.php?id=<?php echo $row['id']; ?>"><div class="linke">
									<p class="opensans remove-bottom"><?php echo nl2br(stripslashes($row['titulo'])); ?></p>
								</div></a>
								<ul class="topics-meta square opensans">
									<li>
										<?php
										$date=strtotime($row['fecha']);
										$date=date('d/m/Y', $date);
										echo $date;
										?>
									</li>
								</ul>
								<?php
							}
						}
						else{
							if($_GET['id']>0){ ?>
								<ul class="news-list">
									<li class="news-item single-post clearfix">
										<figure class="media-object">
											<a href="#"><img class="callate2" src="admin/<?php echo $row['imagen'] ?>" alt=""/></a>
											<figcaption class="caption clearfix">
												<div class="news-date left">
													<img class="icon" src="assets/images/calendar.png" alt=""/>
													<a href="#">
														<?php
														$date=strtotime($row['fecha']);
														$date=date('d/m/Y', $date);
														echo $date;
														?>
													</a>
												</div>
											</figcaption>
										</figure>
										<h5 class="news-title opensans-bold">
											<a href="#"><?php echo nl2br(stripslashes($row['titulo'])); ?>.</a>
										</h5>
										<p class="news-excerpt opensans">
											<?php echo nl2br(stripslashes($row['texto'])); ?>
										</p>
									</li>
								</ul>
								<?php
							}
							else{
								?>
								<h2>Nuevas Iniciativas</h2>
								<ul class="news-list">
									<?php
									$sql=$con->query("SELECT * FROM iniciativas ORDER BY fecha DESC LIMIT 0,10");
									while($row=$con->fetcharray($sql)){
										?>
										<li class="news-item clearfix">
											<figure class="media-object">
												<?php if($row['imagen']!='iniciativa/'){ ?>
													<a href="programas.php?id=<?php echo $row['id']; ?>"><img class="callate2" src="admin/<?php echo $row['imagen']; ?>" alt=""/></a>
												<?php } ?>
												<figcaption class="caption clearfix">
													<div class="news-date left">
														<img class="icon" src="assets/images/calendar.png" alt=""/>
														<a href="news.php?id=<?php echo $row['id']; ?>">
															<?php
															$date=strtotime($row['fecha']);
															$date=date('d/m/Y', $date);
															echo $date;
															?>
														</a>
													</div>
												</figcaption>
											</figure>
											<h5 class="news-title opensans-bold">
												<a href="programas.php?id=<?php echo $row['id']; ?>"><?php echo nl2br(stripslashes($row['titulo'])); ?></a>
											</h5>
											<p class="news-excerpt opensans">
												<?php echo nl2br(stripslashes($row['descripcion'])); ?>
											</p>
											<a href="programas.php?id=<?php echo $row['id']; ?>" class="small-btn readmore-btn left">Leer m&aacute;s</a>
										</li>
									<?php
									}
								}
								?>
							</ul>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include("footer.php"); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.custom.72241.js"></script>
<script src="assets/js/magister.js"></script>
</body>
</html>