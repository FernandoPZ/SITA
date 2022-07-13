<?php include("../template/cabecera.php"); ?> <!-- Llamamos a la cabecera -->

<?php
include "../config/conexion.php"; //Conexion a la base de datos
if($_SESSION['tipo'] != 1) //Valida si es un usuario nivel administrador
{
    header("location: /SITA/sistema/index.php"); //Si no, regresa a la pagina principal
}
?>

<title>SITA - Usuarios</title> <!-- Titulo de la pagina -->

            <div class="jumbotron">
                <h1 class="display-3">Lista de usuarios</h1>
                <hr class="my-2">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- Barra de nuevo registro y busqueda -->
                        <div class="container-fluid">
                            <button type="button" onclick="location.href='nuevoUsuario.php'" class="btn btn-primary">Nuevo usuario</button> <!-- Redirecciona a registrar un nuevo usuario -->
                            <form action="buscarUsuario.php" method="get" class="d-flex"> <!-- Barra de busqueda -->
                                <input class="form-control me-sm-2" type="text" name="busqueda" id="busqueda" placeholder="Nombre de usuario">
                                <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Buscar">
                            </form>
                        </div>
                    </nav>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr> <!-- Nombre de los campos a mostrar -->
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
                        $sql_registro = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro FROM usuario WHERE activo = 1"); // Cuenta y almacena todos los registros activos
                        $result_registro = mysqli_fetch_array($sql_registro);
                        $total_registro = $result_registro['total_registro'];
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
                                                                 FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipo_usu WHERE u.activo = 1 ORDER BY cve_usuario ASC LIMIT $desde,$por_pagina;");
                        mysqli_close($conexion); // Cierra la conexion a la bd
                        $result = mysqli_num_rows($query); // Calcula el numero de filas de la consulta
                        if($result > 0){ // Valida si el numero de consultas es mayor a cero
                            while ($data = mysqli_fetch_array($query)){ // Crea un bucle para mostrar los resultados
                                ?>
                                <tbody>
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
                    if($total_registro!= 0){ //Valida si el toal de registros es diferente a cero
                ?>
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
                    <div class="alert alert-dismissible alert-light mx-auto"> <!-- Muestra un mensaje de error si no hay usuarios registrados -->
                        <h4 class="alert-heading text-center">¡No hay usuarios!</h4>
                        <p class="mb-0 text-center">Que raro, no deberias de poder ver esto, contacta a un tecnico.</p>
                    </div>
                <?php } ?>
			</div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[verUsuarios] (Prototipo) ---
Ultima modificacion -- [21/06/2022 (14:35 hrs)]
-->