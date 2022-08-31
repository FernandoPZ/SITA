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
							<img class="card-img-top" src="/sistema/files/usuario/<?php echo $s_foto; ?>" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/mi_usuario.php" role="button">Entrar</a> <!-- Redirecciona para ver la cuenta actual -->
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 mx-auto">
					<div class="card">
						<h3 class="card-header col text-center">Ver mi información</h3>
						<div class="card-body">
							<img class="card-img-top" src="elementos/informacion.png" alt="">
							<div class="col text-center">
								</br>
								<a name="" id="" class="btn btn-primary" href="secciones/infDocente.php" role="button">Entrar</a> <!-- Redirecciona para ver la informacion del docente actual -->
							</div>
						</div>
					</div>
				</div>
				<?php
				include ("config/conexion.php"); // Realiza la conexion con la bd
				$consultaDocente = mysqli_query($conexion,"SELECT * FROM docente WHERE cuenta = $iduser"); // Realiza la consulta de la tabla docente
				$resultado = mysqli_num_rows($consultaDocente); // Almacena la cantidad todal de registros
				while ($datos = mysqli_fetch_array($consultaDocente)) // Bucle para almacenar los datos
				{ $idDoc = $datos['cve_docente']; } // Guarda la clave del docente
				?>
				<?php if ($resultado != 0){ ?> <!-- Si el docente tiene informacion registrada -->
					<div class="col-md-4 mx-auto">
						<div class="card">
							<h3 class="card-header col text-center">Exportar mi información</h3>
							<div class="card-body">
								<img class="card-img-top" src="elementos/exportar.png" alt="">
								<div class="col text-center">
									</br>
									<a name="" id="" class="btn btn-primary" href="secciones/expDocente.php?id=<?php echo $idDoc ?>" role="button">Entrar</a> <!-- Redirecciona para ver la lista de ususarios -->
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php include("template/pie.php"); ?> <!-- llamamos al pie de pagina -->
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
Ultima modificacion -- [31/08/2022 (14:11 hrs)]
-->