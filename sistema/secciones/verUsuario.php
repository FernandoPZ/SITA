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
                            <button type="button" onclick="location.href='nuevoUsuario.php'" class="btn btn-primary">Nuevo usuario</button>
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
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                        $query = mysqli_query($conexion, "SELECT u.cve_usuario, r.tipo, u.usuario FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipou WHERE u.activo = 1 ORDER BY cve_usuario ASC");

                        $result = mysqli_num_rows($query);
                        if($result > 0){
                            while ($data = mysqli_fetch_array($query)){
                                ?>
                                <tbody>
                                    <tr class="table-active">
                                    <th scope="row"><?php echo $data ['cve_usuario']; ?></th>
                                    <td><?php echo $data ['tipo']; ?></td>
                                    <td><?php echo $data ['usuario']; ?></td>
                                    <td>
                                        <form method="post">
                                            <a role="button" class="btn btn-outline-warning" href="editarUsuario.php?id=<?php echo $data ['cve_usuario']; ?>">Editar</a>
                                            <?php if($data['cve_usuario'] != 1){ ?>
                                            <a role="button" class="btn btn-outline-danger" href="eliminarUsuario.php?id=<?php echo $data ['cve_usuario']; ?>" >Borrar</a>
                                            <?php } ?>
                                        </form>
                                    </td>
                                    </tr>
                                </tbody>
                                <?php
                            }
                        }
                    ?>
                </table>
                <div>
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                        <a class="page-link" href="#">&laquo;</a>
                        </li>
                        <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#">5</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#">&raquo;</a>
                        </li>
                    </ul>
                </div>
			</div>

<?php include("../template/pie.php"); ?>