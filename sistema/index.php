<?php include("template/cabecera.php"); ?>
<title>SITA - Inicio</title>

			<div class="jumbotron">
				<h1 class="display-3">Bienvenido al sistema, <?php echo $usuario; ?></h1>
				<hr class="my-2">
			</div>
			<br>

			<?php if($_SESSION['tipo'] == 1){ ?>
			<div class="col-md-4 mx-auto"> <!-- divide la pantalla en 3 elementos de 4 espacios de 12, cada uno -->
				<div class="card"> <!-- tarjetas para presentar las secciones -->
					<h3 class="card-header col text-center">Usuarios</h3>
					<div class="card-body">
						<img class="card-img-top" src="img/elementos/recuhum.png" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/verUsuario.php" role="button">Entrar</a>
							</div>
					</div>
				</div>
			</div>
			<?php } ?>

			<div class="col-md-4 mx-auto"> <!-- divide la pantalla en 3 elementos de 4 espacios de 12, cada uno -->
				<div class="card"> <!-- tarjetas para presentar las secciones -->
					<h3 class="card-header col text-center">Docentes</h3>
					<div class="card-body">
						<img class="card-img-top" src="img/elementos/academ.png" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/verDocente.php" role="button">Entrar</a>
							</div>
					</div>
				</div>
			</div>


<?php include("template/pie.php"); ?>