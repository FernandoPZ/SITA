<?php include("../template/cabecera.php"); ?>
<title>SITA - Usuarios</title>

			<div class="jumbotron">
				<h1 class="display-3">Lista de usuarios</h1>
                <hr class="my-2">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <div class="container-fluid">
                            <button type="button" onclick="location.href='nuevoUsuario.php'" class="btn btn-success">Nuevo usuario</button>
                            <form class="d-flex">
                                <input class="form-control me-sm-2" type="text" placeholder="Nombre de usuario">
                                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
                            </form>
                        </div>
                    </nav>
                </div>
			</div>

<?php include("../template/pie.php"); ?>