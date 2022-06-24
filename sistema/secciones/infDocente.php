                        // Fragmento que muestra en un listado la formacion del docente
                        <div class="tab-pane fade" id="formacion"> <!-- Tabla de Formacion -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Listado pendiente
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr> <!-- Nombre de los campos a mostrar -->
                                            <th scope="col">Clave</th>
                                            <th scope="col">Nivel de estudio</th>
                                            <th scope="col">Siglas de los estudios</th>
                                            <th scope="col">Institucion</th>
                                            <th scope="col">Area</th>
                                            <th scope="col">Disiplina</th>
                                            <th scope="col">Pais</th>
                                            <th scope="col">Fecha de titulacion</th>
                                            <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            //Paginador
                                            include "../config/conexion.php";
                                            $sql_formacion = mysqli_query($conexion, "SELECT COUNT(*) AS tr_formacion FROM formacion WHERE activo = 1"); // Cuenta y almacena todos los registros activos
                                            $result_formacion = mysqli_fetch_array($sql_formacion);
                                            $total_formacion = $result_formacion['tr_formacion'];
                                            $por_pagina = 5; // Indicador de cuantos registros mostrara por pagina
                                            if(empty($_GET['pagina'])) // Identifica si el numero de paginas no este vacio
                                            {
                                                $pagina = 1;
                                            }else{
                                                $pagina = $_GET['pagina'];
                                            }
                                            $desde = ($pagina-1) * $por_pagina; //Identifica la posicion de la pagina
                                            $total_pagina = ceil($total_formacion / $por_pagina); // Calcula el total de las paginas
                                            // Realiza la consulta de los datos a mostrar en la lista
                                            $query = mysqli_query($conexion, "SELECT cve_formacion,
                                                                                     nivel_estudio,
                                                                                     siglas_estudio,
                                                                                     institucion,
                                                                                     area,
                                                                                     disciplina,
                                                                                     pais,
                                                                                     fecha_inicio,
                                                                                     fecha_fin,
                                                                                     fecha_titulacion,
                                                                                     habilidades,
                                                                                     cve_docente,
                                                                                     fecha_add,
                                                                                     user_cve,
                                                                                     activo
                                                                                     FROM formacion WHERE activo = 1 ORDER BY cve_formacion ASC LIMIT $desde,$por_pagina;");
                                            mysqli_close($conexion); // Cierra la conexion a la bd
                                            $result = mysqli_num_rows($query); // Calcula el numero de filas de la consulta
                                            if($result > 0){ // Valida si el numero de consultas es mayor a cero
                                                while ($data = mysqli_fetch_array($query)){ // Crea un bucle para mostrar los resultados
                                                    ?>
                                                    <tbody>
                                                        <tr class="table-active"> <!-- Campos a llenar -->
                                                            <th scope="row"><?php echo $data ['cve_formacion']; ?></th> <!-- La clave del usuario -->
                                                            <td><?php echo $data ['nivel_estudio']; ?></td> <!-- El tipo del usuario -->
                                                            <td><?php echo $data ['siglas_estudio']; ?></td> <!-- El nombre del usuario -->
                                                            <td><?php echo $data ['institucion']; ?></td> <!-- El primer apellido del usuario -->
                                                            <td><?php echo $data ['area']; ?></td> <!-- El segundo apellido del usuario -->
                                                            <td><?php echo $data ['disciplina']; ?></td> <!-- La fotografia del usuario -->
                                                            <td><?php echo $data ['pais']; ?></td> <!-- El ID del usuario -->
                                                            <td><?php echo $data ['fecha_titulacion']; ?></td> <!-- El correo del usuario -->
                                                            <td>
                                                                <form method="post">
                                                                    <a role="button" class="btn btn-outline-warning" href="editarFormacion.php?id_d=<?php echo $data ['cve_docente']; ?>?id_d=<?php echo $data ['cve_formacion']; ?>">Editar</a> <!-- Redirecciona para editar al usuario -->
                                                                    <a role="button" class="btn btn-outline-danger" href="eliminarFormacion.php?id_d=<?php echo $data ['cve_docente']; ?>?id_f=<?php echo $data ['cve_formacion']; ?>" >Borrar</a> <!-- Redirecciona para eliminar al usuario -->
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
                                            if($total_formacion!= 0){
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
                                                <h4 class="alert-heading text-center">No hay formacion registrada para este docente, aun...</h4>
                                                <p class="mb-0 text-center">Agrega el primer registro</p>
                                                <br>
                                                <div class="text-center">
                                                    <a role="button" class="btn btn-outline-danger" href="nuevoFormacion.php?id_d=<?php echo $data ['cve_docente']; ?>" >Borrar</a> <!-- Redirecciona para eliminar al usuario -->
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>