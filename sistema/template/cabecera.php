<?php
session_start();
if(!isset($_SESSION['usuario'])){
  header("Location:../../../SITA/index.php");
} else {
  if($_SESSION['active']==true){
    $usuario=$_SESSION["usuario"];
  }
}
?>

<?php include("config/functions.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css"/> <!-- Referencia a la hoja de estilos -->
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container-fluid">
				<a class="navbar-brand" href="../index.php">SITA</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="true" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="navbarColor02">
					<ul class="navbar-nav me-auto">
						<li class="nav-item">
							<a class="nav-link" href="#">Usuarios</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Academicos</a>
						</li>
					</ul>
					<form class="d-flex">
						<p> <?php echo fechaC(); ?> |</p>
						<span class="user">|  <?php echo $usuario; ?>  </span>
						<img class="photouser" src="img/user.png" alt="Usuario" style="width: 25px; height:25px;">
						<a href="config/salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" style="width: 25px; height:25px;" title="Salir"></a>
					</form>
				</div>
			</div>
		</nav>
	</header>
	<div class="container"> <!-- Contenido de la pagina variable -->
        <div class="row">