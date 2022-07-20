<?php include("../template/cabecera.php"); ?> <!-- Llama al encabezado de pagina -->

<?php
include "../config/conexion.php"; // Inicia la conexion con la bd
?>

<?php
if($_SESSION['tipo'] == 4) //Valida si es un usuario nivel administrador
{
    header("location: /SITA/sistema/index.php"); //Si no, regresa a la pagina principal
}
?>

<title>SITA - Docentes</title> <!-- Titulo de la pagina -->

            <div class="jumbotron">
                <h1 class="display-3">Lista de Docentes</h1>
                <hr class="my-2">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <div class="container-fluid">
                            <?php if($_SESSION['tipo'] != 3){ ?> <!-- Valida que el usuario no sea un Consultor -->
                            <button type="button" onclick="location.href='nuevoDocente.php'" class="btn btn-primary">Nuevo Registro</button>
                            <?php } ?>
                            <form action="buscarDocente.php" method="get" class="d-flex">
                                <input class="form-control me-sm-2" type="text" name="busqueda" id="busqueda" placeholder="Buscar docente">
                                <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Buscar">
                            </form>
                        </div>
                    </nav>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center"> <!-- Nombre de los campos a mostrar -->
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
                        $sql_registro = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro FROM docente WHERE activo = 1"); // Cuenta y almacena todos los registros activos
                        $result_registro = mysqli_fetch_array($sql_registro); // Cuenta la cantidad de registros consultados
                        $total_registro = $result_registro['total_registro']; // Almacena el numero de registros
                        $por_pagina = 5; // La cantidad de registros para mostrar por pagina
                        if(empty($_GET['pagina'])) // Identifica si el numero de paginas no este vacio
                        {
                            $pagina = 1; // La pagina inicial
                        }else{
                            $pagina = $_GET['pagina']; // Almacena la pagina actual
                        }
                        $desde = ($pagina-1) * $por_pagina; //Identifica la posicion de la pagina
                        $total_pagina = ceil($total_registro / $por_pagina); // Calcula el total de las paginas
                        // Realiza la consulta de los datos a mostrar en la lista
                        $query = mysqli_query($conexion, "SELECT d.cve_docente,
                                                                 p.puesto,
                                                                 d.nombre,
                                                                 d.apellido1,
                                                                 d.apellido2,
                                                                 d.foto,
                                                                 d.num_empleado
                                                                 FROM docente d INNER JOIN puesto p ON d.puesto = p.cve_puesto WHERE d.activo = 1 ORDER BY cve_docente ASC LIMIT $desde,$por_pagina;");
                        mysqli_close($conexion); // Cierra la conexion con la bd
                        $result = mysqli_num_rows($query); // Calcula el numero de filas de la consulta
                        if($result > 0){ // Valida si el numero de consultas es mayor a cero
                            while ($data = mysqli_fetch_array($query)){ // Crea un bucle para mostrar los resultados
                                ?>
                                <tbody class="text-center">
                                    <tr class="table-active"> <!-- Campos a llenar -->
                                    <th scope="row"><?php echo $data ['cve_docente']; ?></th> <!-- Clave del docente -->
                                    <td><?php echo $data ['nombre']; ?></td> <!-- Nombre del docente -->
                                    <td><?php echo $data ['apellido1']; ?></td> <!-- Primer apellido del docente -->
                                    <td><?php echo $data ['apellido2']; ?></td> <!-- Segundo apellido del docente -->
                                    <td><img src="/SITA/sistema/files/docente/foto/<?php echo $data ['foto']; ?>" style="width: 50px; height:50px;"></td> <!-- Fotografia del docente -->
                                    <td><?php echo $data ['num_empleado']; ?></td> <!-- Numero de empleado -->
                                    <td><?php echo $data ['puesto']; ?></td> <!-- Puesto asignado -->
                                    <td>
                                        <form method="post">
                                            <a role="button" class="btn btn-outline-info" href="infDocente.php?id=<?php echo $data ['cve_docente']; ?>">Ver</a>
                                            <?php if($_SESSION['tipo'] != 3){ ?> <!-- Valida que el usuario en sesion no sea consultor -->
                                            <a role="button" class="btn btn-outline-warning" href="editarDocente.php?id=<?php echo $data ['cve_docente']; ?>">Editar</a>
                                            <a role="button" class="btn btn-outline-danger" href="eliminarDocente.php?id=<?php echo $data ['cve_docente']; ?>" >Borrar</a>
                                            <?php } ?> <!-- Si el usuario es consultor, no muestra la opcion de eliminar ni editar -->
                                        </form>
                                    </td>
                                    </tr>
                                </tbody>
                                <?php
                            }
                        }
                    ?>
                </table>
                <?php if($total_registro!= 0){ ?> <!-- Valida si no hay registros para mostrar -->
                <div>
                    <ul class="pagination justify-content-end">
                        <?php
                            if($pagina != 1) // Si la pagina es diferente a 1, mostrara los botones de retroceso
                            { ?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo 1; ?>"> |< </a></li> <!-- Ir al inicio de las paginas -->
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina-1; ?>"> << </a></li> <!-- Ir una pagina anterior -->
                        <?php } ?>
                        <?php
                            for ($i=1; $i <= $total_pagina; $i++){
                                if($i == $pagina){
                                    echo '<li class="page-item active"><a class="page-link">'.$i.'</a></li>'; // Muestra la pagina actual
                                }else{
                                    echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>'; // Muestra las demas paginas
                                }
                            }
                        ?>
                        <?php
                            if($pagina != $total_pagina) // Si la pagina es diferente al total de paginas, mostrara los botones de adelantar
                            { ?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina+1; ?>"> >> </a></li> <!-- Avanza una pagina -->
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $total_pagina; ?>"> >| </a></li> <!-- Va al final de las paginas -->
                        <?php } ?>
                    </ul>
                </div>
                <?php }else{ ?>
                    <div class="alert alert-dismissible alert-light mx-auto"> <!-- Muestra un mensaje de aviso si no hay docentes registrados -->
                        <h4 class="alert-heading text-center">No hay docentes registrados, aun...</h4>
                        <p class="mb-0 text-center">Agrega al primer registro :D</p>
                        <br>
                        <div class="text-center">
                            <button type="button" onclick="location.href='nuevoDocente.php'" class="btn btn-primary mx-auto">Nuevo Registro</button> <!-- Redirecciona para crear un nuevo registro -->
                        </div>
                    </div>
                <?php } ?>
			</div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[verDocente] (Prototipo) ---
Ultima modificacion -- [30/06/2022 (09:19 hrs)]
-->