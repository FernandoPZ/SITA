<?php include("template/cabecera.php"); ?> <!-- Llamamos a la cabecera -->

<title>SITA - Inicio</title> <!-- Titulo de la pagina -->

			<div class="jumbotron">
				<h1 class="display-3">Bienvenido al sistema, <?php echo $s_usuario; ?></h1> <!-- Saludo al usuario -->
				<hr class="my-2">
			</div>
			<br>
			<?php if($_SESSION['tipo'] == 4){ ?> <!-- Valida que el usuario es un Docente -->
				<div class="col-md-4 mx-auto">
					<div class="card">
						<h3 class="card-header col text-center">Ver mi usuario</h3>
						<div class="card-body">
							<img class="card-img-top" src="elementos/recuhum.png" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/mi_usuario.php" role="button">Entrar</a> <!-- Redirecciona para ver la lista de ususarios -->
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 mx-auto">
					<div class="card">
						<h3 class="card-header col text-center">Ver mi informacion</h3>
						<div class="card-body">
							<img class="card-img-top" src="elementos/recuhum.png" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/infDocente.php" role="button">Entrar</a> <!-- Redirecciona para ver la lista de ususarios -->
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 mx-auto">
					<div class="card">
						<h3 class="card-header col text-center">Importar mi informacion</h3>
						<div class="card-body">
							<img class="card-img-top" src="elementos/recuhum.png" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/inpDocente.php" role="button">Entrar</a> <!-- Redirecciona para ver la lista de ususarios -->
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if($_SESSION['tipo'] != 4){ ?> <!-- Valida que el usuario no sea un Docente -->
				<?php if($_SESSION['tipo'] == 1){ ?> <!-- Valida que el usuario es un Administrador -->
					<div class="col-md-4 mx-auto">
						<div class="card">
							<h3 class="card-header col text-center">Usuarios</h3>
							<div class="card-body">
								<img class="card-img-top" src="elementos/recuhum.png" alt="">
									<div class="col text-center">
										</br>
										<a name="" id="" class="btn btn-primary" href="secciones/verUsuario.php" role="button">Entrar</a> <!-- Redirecciona para ver la lista de ususarios -->
									</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="col-md-4 mx-auto">
					<div class="card">
						<h3 class="card-header col text-center">Docentes</h3>
						<div class="card-body">
							<img class="card-img-top" src="elementos/academ.png" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/verDocente.php" role="button">Entrar</a> <!-- Redirecciona para ver la lista de docentes -->
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

<?php include("template/pie.php"); ?> <!-- llamamos al pie de pagina -->

<!--
--- Pagina[Home] (Prototipo) ---
Ultima modificacion -- [04/07/2022 (09:49 hrs)]
-->