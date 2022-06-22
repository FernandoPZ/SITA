<?php include("template/cabecera.php"); ?> <!-- Llamamos a la cabecera -->

<title>SITA - Inicio</title> <!-- Titulo de la pagina -->

			<div class="jumbotron">
				<h1 class="display-3">Bienvenido al sistema, <?php echo $usuario; ?></h1> <!-- Saludo al usuario -->
				<hr class="my-2">
			</div>
			<br>
			<!--
				En la pagina principal solo se muestran accesos al listado
				de los usuarios y docentes, si hay otra idea de que mas poner
				se editara en el futuro.
			-->
			
			<?php if($_SESSION['tipo'] == 1){ ?> <!-- Valida que el usuario es un administrador -->
			<div class="col-md-4 mx-auto">
				<div class="card">
					<h3 class="card-header col text-center">Usuarios</h3>
					<div class="card-body">
						<img class="card-img-top" src="img/elementos/recuhum.png" alt="">
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
						<img class="card-img-top" src="img/elementos/academ.png" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/verDocente.php" role="button">Entrar</a> <!-- Redirecciona para ver la lista de docentes -->
							</div>
					</div>
				</div>
			</div>

<?php include("template/pie.php"); ?> <!-- llamamos al pie de pagina -->

<!--
--- Pagina[Home] (Prototipo) ---
Codificacion final -- [22/06/2022 (08:10 hrs)]
Comentario final ---- [22/06/2022 (08:10 hrs)]
-->