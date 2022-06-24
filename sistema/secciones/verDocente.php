<?php include("../template/cabecera.php"); ?> <!-- Llama al encabezado de pagina -->

<?php
include "../config/conexion.php"; // Inicia la conexion con la bd

// if($_SESSION['tipo'] == 4)
// {
//     header("location: /SITA/sistema/index.php");
// }

?>
<title>SITA - Docentes</title> <!-- Titulo de la pagina -->

            <div class="jumbotron">
                <h1 class="display-3">Lista de Docentes</h1>
                <hr class="my-2">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <div class="container-fluid">
                            <button type="button" onclick="location.href='nuevoDocente.php'" class="btn btn-primary">Nuevo Registro</button>
                            <form action="buscarDocente.php" method="get" class="d-flex">
                                <input class="form-control me-sm-2" type="text" name="busqueda" id="busqueda" placeholder="Buscar docente">
                                <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Buscar">
                            </form>
                        </div>
                    </nav>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Clave</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">1er apellido</th>
                            <th scope="col">2do apellido</th>
                            <th scope="col">Fotografia</th>
                            <th scope="col">Numero</th>
                            <th scope="col">Puesto</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                        //Paginador
                        $sql_registro = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro FROM docente WHERE activo = 1");
                        $result_registro = mysqli_fetch_array($sql_registro);
                        $total_registro = $result_registro['total_registro'];

                        $por_pagina = 5;

                        if(empty($_GET['pagina']))
                        {
                            $pagina = 1;
                        }else{
                            $pagina = $_GET['pagina'];
                        }

                        $desde = ($pagina-1) * $por_pagina;
                        $total_pagina = ceil($total_registro / $por_pagina);

                        $query = mysqli_query($conexion, "SELECT d.cve_docente, p.puesto, d.nombre, d.apellido1, d.apellido2, d.foto, d.num_empleado FROM docente d INNER JOIN puesto p ON d.puesto = p.cve_puesto WHERE d.activo = 1 ORDER BY cve_docente ASC LIMIT $desde,$por_pagina;");

                        mysqli_close($conexion);

                        $result = mysqli_num_rows($query);
                        if($result > 0){
                            while ($data = mysqli_fetch_array($query)){
                                ?>
                                <tbody class="text-center">
                                    <tr class="table-active">
                                    <th scope="row"><?php echo $data ['cve_docente']; ?></th>
                                    <td><?php echo $data ['nombre']; ?></td>
                                    <td><?php echo $data ['apellido1']; ?></td>
                                    <td><?php echo $data ['apellido2']; ?></td>
                                    <td><img src="/SITA/sistema/files/upload/fotos/<?php echo $data ['foto']; ?>" style="width: 50px; height:50px;"></td>
                                    <td><?php echo $data ['num_empleado']; ?></td>
                                    <td><?php echo $data ['puesto']; ?></td>
                                    <td>
                                        <form method="post">
                                            <a role="button" class="btn btn-outline-info" href="infDocente.php?id=<?php echo $data ['cve_docente']; ?>">Ver</a>
                                            <a role="button" class="btn btn-outline-warning" href="editarDocente.php?id=<?php echo $data ['cve_docente']; ?>">Editar</a>
                                            <a role="button" class="btn btn-outline-danger" href="eliminarDocente.php?id=<?php echo $data ['cve_docente']; ?>" >Borrar</a>
                                        </form>
                                    </td>
                                    </tr>
                                </tbody>
                                <?php
                            }
                        }
                    ?>
                </table>
                <?php
                    if($total_registro!= 0){
                ?>
                <div>
                    <ul class="pagination justify-content-end">
                        <?php
                            if($pagina != 1)
                            { ?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo 1; ?>">|<</a></li>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
                        <?php } ?>
                        <?php
                            for ($i=1; $i <= $total_pagina; $i++){
                                if($i == $pagina){
                                    echo '<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
                                }else{
                                    echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';
                                }
                            }
                        ?>
                        <?php
                            if($pagina != $total_pagina)
                            { ?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina+1; ?>">>></a></li>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $total_pagina; ?>">>|</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php }else{ ?>
                    <div class="alert alert-dismissible alert-light mx-auto">
                        <h4 class="alert-heading text-center">No hay docentes registrados, aun...</h4>
                        <p class="mb-0 text-center">Agrega al primer registro :D</p>
                        <br>
                        <div class="text-center">
                            <button type="button" onclick="location.href='nuevoDocente.php'" class="btn btn-primary mx-auto">Nuevo Registro</button>
                        </div>
                    </div>
                <?php } ?>
			</div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[verDocente] (Prototipo) ---
Codificacion final -- [23/06/2022 (12:47 hrs)]
Comentario final ---- [23/06/2022 (12:47 hrs)]
-->