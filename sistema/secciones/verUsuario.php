<?php include("../template/cabecera.php"); ?>
<?php
include "../config/conexion.php";
?>
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Clave del usuario</th>
                        <th scope="col">Tipo de usuario</th>
                        <th scope="col">Nombre del usuario</th>
                        <th scope="col">Activo</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                        $query = mysqli_query($conexion, "SELECT u.cve_usuario, r.tipo, u.usuario, u.activo FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipou");

                        $result = mysqli_num_rows($query);
                        if($result > 0){
                            while ($data = mysqli_fetch_array($query)){
                                ?>
                                <tbody>
                                    <tr class="table-active">
                                    <th scope="row"><?php echo $data ['cve_usuario']; ?></th>
                                    <td><?php echo $data ['tipo']; ?></td>
                                    <td><?php echo $data ['usuario']; ?></td>
                                    <td><?php echo $data ['activo']; ?></td>
                                    <td>
                                        <form method="post">
                                            <input type="submit" name="accion" value="Editar" class="btn btn-primary"/>
                                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                                        </form>
                                    </td>
                                    </tr>
                                </tbody>
                                <?php
                            }
                        }
                    ?>
                </table>
			</div>

<?php include("../template/pie.php"); ?>