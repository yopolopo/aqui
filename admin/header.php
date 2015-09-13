<header class="main-header">
	<a href="index.php" class="logo">
		<span class="logo-mini"><b>D</b>C</span>
		<span class="logo-lg"><b>Demanda</b> Cuidadana</span>
	</a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs"><?php echo $_SESSION['user']; ?></span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<p>
								<?php echo $_SESSION['user']; ?>
							</p>
						</li>
						<li class="user-footer">
							<div class="pull-right">
								<a href="login.php?action=logout" class="btn btn-default btn-flat">Cerrar Sesion</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>