<?php
session_start();
if(!isset($_SESSION['usuario'])){
  header("Location:/SITA/index.php");
} else {
  if($_SESSION['active']==true){
    $usuario=$_SESSION["usuario"];
	$tipo=$_SESSION["tipo"];
  }
}
?>

<?php 
	date_default_timezone_set('America/Mexico_City'); 
	function fechaC(){
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
    <link rel="stylesheet" href="/SITA/sistema/css/bootstrap.css"/> <!-- Referencia a la hoja de estilos -->
	<link rel="stylesheet" href="/SITA/sistema/css/style.css"/> <!-- hoja de estilos propia -->
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<div class="container-fluid">
				<a class="navbar-brand" href="../index.php">SITA</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="true" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="navbarColor02">
					<ul class="navbar-nav me-auto">
						<?php if($_SESSION['tipo'] == 1){ ?>
						<li class="nav-item">
							<a class="nav-link" href="/SITA/sistema/secciones/verUsuario.php">Usuarios</a>
						</li>
						<?php } ?>
						<li class="nav-item">
							<a class="nav-link" href="#">Academicos</a>
						</li>
					</ul>
					<form class="d-flex">
						<p> <?php echo fechaC(); ?> |</p>
						<span class="user">|  <?php echo $usuario .' - '. $tipo; ?>  </span>
						<img class="photouser" src="/SITA/sistema/img/elementos/user.png" alt="Usuario" style="width: 25px; height:25px;">
						<a href="/SITA/sistema/config/salir.php"><img class="close" src="/SITA/sistema/img/elementos/salir.png" alt="Salir del sistema" style="width: 25px; height:25px;" title="Salir"></a>
					</form>
				</div>
			</div>
		</nav>
	</header>
	<div class="container"> <!-- Contenido de la pagina variable -->
        <div class="row">
		<br>