<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITA - Inicio</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css"/> <!-- Referencia a la hoja de estilos -->
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">SITA</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="true" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="navbarColor02">
					<ul class="navbar-nav me-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle show" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">Usuarios</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Ver usuarios</a>
								<a class="dropdown-item" href="#">Editar usuario</a>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Academicos</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Ver academicos</a>
								<a class="dropdown-item" href="#">Editar academicos</a>
							</div>
						</li>
					</ul>
					<form class="d-flex">
						<p> <?php echo date('d-m-Y') ?> </p>
						<span> | </span>
						<span class="user"> [usuario] </span>
						<img class="photouser" src="img/user.png" alt="Usuario" style="width: 25px; height:25px;">
						<a href="#"><img class="close" src="img/salir.png" alt="Salir del sistema" style="width: 25px; height:25px;" title="Salir"></a>
					</form>
				</div>
			</div>
		</nav>
	</header>
	<div class="container"> <!-- Contenido de la pagina variable -->
        <div class="row">