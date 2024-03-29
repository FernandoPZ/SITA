<?php
session_start(); // Se inicia la sesion
if(!isset($_SESSION['usuario'])){ // Verifica que el usuario no esta vacio
	header("Location:https://utec-sita.herokuapp.com/index.php"); // Redirecciona al login
}else{
	if($_SESSION['active']==true){ // Valida que la sesion este activa
		$iduser=$_SESSION['cve_usuario']; // Almacena la clave del usuario
		$s_tipo=$_SESSION["tipo"]; // Almacena el tipo de usuario
		$s_nombre=$_SESSION["nombre"]; // Almacena el id del usuario
		$s_apellido1=$_SESSION["apellido1"]; // Almacena el nombre de la foto del usuario
        $s_apellido2=$_SESSION['apellido2']; // Almacena el status del usuario
		$s_usuario=$_SESSION["usuario"]; // Almacena el id del usuario
		$s_foto=$_SESSION["foto"]; // Almacena el nombre de la foto del usuario
		$s_correo=$_SESSION["correo"]; // Almacena el tipo de usuario
        $s_activo=$_SESSION['activo']; // Almacena el status del usuario
	}
}
?>

<?php // Funcinalidad de la fecha actual
date_default_timezone_set('America/Mexico_City'); // Zona horaria
function fechaC(){ // Definir el formato
	$mes = array("","Enero",
					"Febrero", 
					"Marzo", 
					"Abril", 
					"Mayo", 
					"Junio", 
					"Julio", 
					"Agosto", 
					"Septiembre", 
					"Octubre", 
					"Noviembre", 
					"Diciembre");
					return date('d')." de ". $mes[date('n')] . " de " . date('Y');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://utec-sita.herokuapp.com/sistema/css/bootstrap.css"/> <!-- Referencia a la hoja de estilos -->
	<link rel="stylesheet" href="https://utec-sita.herokuapp.com/sistema/css/style.css"/> <!-- hoja de estilos propia -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script><!-- JavaScript Bundle with Popper -->
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary"> <!-- Barra de navegacion -->
			<div class="container-fluid">
				<a class="navbar-brand" href="../index.php">SITA</a> <!-- Redirecciona a la pagina principal -->
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" aria-expanded="true" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse">
					<ul class="navbar-nav me-auto">
						<?php if($s_tipo == 4){ ?> <!-- Valida que el usuario es un Docente -->
							<li class="nav-item">
								<a class="nav-link" href="/sistema/secciones/mi_usuario.php">Mi usuario</a> <!-- Redirecciona a ver la cuenta -->
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/sistema/secciones/infDocente.php">Mi información</a> <!-- Redirecciona a ver la informacion del docente actual -->
							</li>
						<?php } ?>
						<?php if($s_tipo != 4){ ?> <!-- Valida que el usuario no sea un Docente -->
							<?php if($s_tipo == 1){ ?> <!-- Valida solo para mostrar a los administradores -->
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuarios</a> <!-- Despliega la lista de opciones de usuarios -->
									<div class="dropdown-menu">
										<a class="dropdown-item" href="/sistema/secciones/nuevoUsuario.php">Nuevo usuario</a> <!-- Redirecciona a registrar usuario -->
										<a class="dropdown-item" href="/sistema/secciones/verUsuario.php">Ver usuarios</a> <!-- Redirecciona a ver los usuarios -->
										<div class="dropdown-divider"></div> <!-- Muestra una linea para dividir la lista -->
										<a class="dropdown-item" href="/sistema/secciones/mi_usuario.php">Mi usuario</a> <!-- Redirecciona a ver la cuenta -->
									</div>
								</li>
							<?php } ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Docentes</a> <!-- Despliega la lista de opciones de docentes -->
								<div class="dropdown-menu">
									<?php if($s_tipo != 3){ ?> <!-- Valida que el usuario no sea un Consultor -->
									<a class="dropdown-item" href="/sistema/secciones/nuevoDocente.php">Nuevo registro</a> <!-- Redirecciona a registrar un docente -->
									<?php } ?>
									<a class="dropdown-item" href="/sistema/secciones/verDocente.php">Ver registros</a> <!-- Redirecciona a ver los docentes -->
								</div>
							</li>
						<?php } ?>
					</ul>
					<form class="d-flex">
						<p> <?php echo fechaC(); ?> |</p> <!-- Muestra la fecha actual -->
						<span class="user">|  <?php echo $s_usuario .' - '. $s_tipo ?> </span>
						<a href="/sistema/secciones/mi_usuario.php"><img class="photouser" src="/sistema/files/usuario/<?php echo $s_foto; ?>" alt="Usuario" style="width: 25px; height:25px;"></a> <!-- Redirecciona a su usuario -->
						<a href="/sistema/config/salir.php"><img class="close" src="/sistema/elementos/salir.png" alt="Salir del sistema" style="width: 25px; height:25px;" title="Salir"></a> <!-- Cierra la sesion del usuario -->
					</form>
				</div>
			</div>
		</nav>
	</header>
	<div class="container"> <!-- Contenido de la pagina variable -->
		<div class="row">
			<br>

<!--
--- Templates[Cabecera] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (13:47 hrs)]
-->