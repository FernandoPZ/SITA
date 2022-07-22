<?php include("../template/cabecera.php"); ?> <!-- Llama al encabezado de pagina -->

<?php
include "../config/conexion.php"; // Conecta con la base de datos
if($_SESSION['tipo'] != 1) // Valida si el usuario es administrador
{
    header("location: /SITA/sistema/index.php"); // Redirecciona a la pagina principal
}
?>

<title>SITA - Usuarios</title> <!-- Titulo de la pagina -->

            <div class="jumbotron">
                <h1 class="display-3">Lista de usuarios</h1>
                <hr class="my-2">
                <div class="container-fluid">
                    <?php
                    $busqueda = strtolower($_REQUEST['busqueda']); // Almacena el parametro de buscar
                    if(empty($busqueda)) // Identifica si el campo de busqueda esta vacio
                    {
                        header("location: verUsuario.php"); // Redirecciona a la lista de usuarios
                    }
                    ?>
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <div class="container-fluid">
                            <button type="button" onclick="location.href='nuevoUsuario.php'" class="btn btn-primary">Nuevo usuario</button> <!-- Redirecciona a formulario de crear nuevo usuario -->
                            <form action="buscarUsuario.php" method="get" class="d-flex">
                                <input class="form-control me-sm-2" type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>"> <!-- Campo para buscar -->
                                <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Buscar"> <!-- Boton para buscar -->
                            </form>
                        </div>
                    </nav>
                </div>
                <table class="table table-hover"> <!-- Tabla de contenido -->
                    <thead class="text-center">
                        <tr>
                        <th scope="col">Clave</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">1er apellido</th>
                        <th scope="col">2do apellido</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                        //Paginador
                        $tipo = '';
                        if($busqueda == 'administrador'){
                            $tipo = " OR u.tipo LIKE '%1%' ";
                        }else if($busqueda == 'editor'){
                            $tipo = " OR u.tipo LIKE '%2%' ";
                        }else if($busqueda == 'consultor'){
                            $tipo = " OR u.tipo LIKE '%3%' ";
                        }
                        // Consulta todos los campos buscando coincidencias con lo buscado
                        $sql_registro = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro FROM usuario u WHERE (cve_usuario LIKE '%$busqueda%'
                                                                                                                        OR nombre LIKE '%$busqueda%'
                                                                                                                        OR apellido1 LIKE '%$busqueda%'
                                                                                                                        OR apellido2 LIKE '%$busqueda%'
                                                                                                                        OR usuario LIKE '%$busqueda%'
                                                                                                                        OR correo LIKE '%$busqueda%'
                                                                                                                        $tipo ) AND activo = 1;");
                        $result_registro = mysqli_fetch_array($sql_registro); // Almacena el numero de registros encontrados
                        $total_registro = $result_registro['total_registro']; // Guarda el numero de registros
                        $por_pagina = 5; // Indicador de cuantos registros mostrara por pagina
                        if(empty($_GET['pagina'])) // Identifica si el numero de paginas no este vacio
                        {
                            $pagina = 1;
                        }else{
                            $pagina = $_GET['pagina'];
                        }
                        $desde = ($pagina-1) * $por_pagina; //Identifica la posicion de la pagina
                        $total_pagina = ceil($total_registro / $por_pagina); // Calcula el total de las paginas
                        // Realiza la consulta de los datos a mostrar en la lista
                        $query = mysqli_query($conexion, "SELECT u.cve_usuario,
                                                                 r.tipo,
                                                                 u.nombre,
                                                                 u.apellido1,
                                                                 u.apellido2,
                                                                 u.foto,
                                                                 u.usuario,
                                                                 u.correo
                                                                 FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipo_usu WHERE (u.cve_usuario LIKE '%$busqueda%'
                                                                                                                                            OR u.nombre LIKE '%$busqueda%'
                                                                                                                                            OR u.apellido1 LIKE '%$busqueda%'
                                                                                                                                            OR u.apellido2 LIKE '%$busqueda%'
                                                                                                                                            OR u.usuario LIKE '%$busqueda%'
                                                                                                                                            OR u.correo LIKE '%$busqueda%'
                                                                                                                                            OR r.tipo LIKE '%$busqueda%') AND u.activo = 1 ORDER BY cve_usuario ASC LIMIT $desde,$por_pagina;");
                        mysqli_close($conexion); // Cierra la conexion a la bd
                        $result = mysqli_num_rows($query); // Calcula el numero de filas de la consulta
                        if($result > 0){ // Valida si el numero de consultas es mayor a cero
                            while ($data = mysqli_fetch_array($query)){ // Crea un bucle para mostrar los resultados
                                ?>
                                <tbody class="text-center">
                                    <tr class="table-active"> <!-- Campos a llenar -->
                                    <th scope="row"><?php echo $data ['cve_usuario']; ?></th> <!-- La clave del usuario -->
                                    <td><?php echo $data ['tipo']; ?></td> <!-- El tipo del usuario -->
                                    <td><?php echo $data ['nombre']; ?></td> <!-- El nombre del usuario -->
                                    <td><?php echo $data ['apellido1']; ?></td> <!-- El primer apellido del usuario -->
                                    <td><?php echo $data ['apellido2']; ?></td> <!-- El segundo apellido del usuario -->
                                    <td> <img src="/SITA/sistema/files/usuario/<?php echo $data ['foto']; ?>" style="width: 50px; height:50px;"> </td> <!-- La fotografia del usuario -->
                                    <td><?php echo $data ['usuario']; ?></td> <!-- El ID del usuario -->
                                    <td><?php echo $data ['correo']; ?></td> <!-- El correo del usuario -->
                                    <td>
                                        <form method="post">
                                            <a role="button" class="btn btn-outline-warning" href="editarUsuario.php?id=<?php echo $data ['cve_usuario']; ?>">Editar</a> <!-- Redirecciona para editar al usuario -->
                                            <?php if($data['cve_usuario'] != 1){ ?> <!-- Valida que no sea el usuario master -->
                                            <a role="button" class="btn btn-outline-danger" href="eliminarUsuario.php?id=<?php echo $data ['cve_usuario']; ?>" >Borrar</a> <!-- Redirecciona para eliminar al usuario -->
                                            <?php } ?> <!-- Si es el usuario master, no muestra la opcion de eliminar -->
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
                    if($total_registro!= 0){ //Valida si el total de registros es diferente a cero
                ?>
                <div>
                    <ul class="pagination justify-content-end">
                        <?php
                            if($pagina != 1) // Si la pagina es diferente a 1, mostrara los botones de retroceso
                            { ?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo 1; ?> &busqueda=<?php echo $busqueda; ?>"> |< </a></li> <!-- Ir al inicio de las paginas -->
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina-1; ?> &busqueda=<?php echo $busqueda; ?>"> << </a></li> <!-- Ir una pagina anterior -->
                        <?php } ?>
                        <?php
                            for ($i=1; $i <= $total_pagina; $i++){
                                if($i == $pagina){
                                    echo '<li class="page-item active"><a class="page-link">'.$i.'</a></li>'; // Muestra la pagina actual
                                }else{
                                    echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>'; // Muestra las demas paginas
                                }
                            }
                        ?>
                        <?php
                            if($pagina != $total_pagina) // Si la pagina es diferente al total de paginas, mostrara los botones de adelantar
                            { ?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina+1; ?> &busqueda=<?php echo $busqueda; ?>"> >> </a></li> <!-- Avanza una pagina -->
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $total_pagina; ?> &busqueda=<?php echo $busqueda; ?>"> >| </a></li> <!-- Va al final de las paginas -->
                        <?php } ?>
                    </ul>
                </div>
                <?php }else{ ?>
                    <div class="alert alert-dismissible alert-warning mx-auto"> <!-- Alerta de que no se encontraron coincidencias -->
                        <h4 class="alert-heading text-center">Oh vaya...</h4>
                        <p class="mb-0 text-center">No se han encontrado similitudes :(</p>
                    </div>
                <?php } ?>
			</div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[buscarUsuarios] (Prototipo) ---
Ultima modificacion -- [22/07/2022 (12:19 hrs)]
-->