<?php include("../template/cabecera.php"); ?> <!-- Llama al encabezado de la pagina -->

<?php include ("../config/conexion.php"); ?> <!-- Realiza la conexion de la bd -->

<?php
$user = $_SESSION['cve_usuario']; // Guarda la clave de usuario con la que entra
if($_SESSION['tipo'] != 1) // Valida si el usuario es nivel administrador
{
    // Consulta todos los datos de la clave del docente
    $sql_docente = mysqli_query($conexion,"SELECT d.cve_docente,
                                                  d.nombre,
                                                  d.apellido1,
                                                  d.apellido2,
                                                  d.foto,
                                                  d.institucion,
                                                  d.tipo_contratacion,
                                                  d.fecha_ingreso,
                                                  d.num_empleado,
                                                  d.cuenta,
                                                  d.fecha_add,
                                                  d.user_cve,
                                                  d.activo,
                                                  (d.puesto) AS idpuesto,
                                                  (p.puesto) AS puesto
                                                  FROM docente d INNER JOIN puesto p ON d.puesto = p.cve_puesto WHERE cuenta = $user");
    $result_sql_docente = mysqli_num_rows($sql_docente); // Almacena la cantidad todal de registros
}else{
    if(empty($_GET['id'])) // Valida si la clave del usuario no esta vacia
    {
        header('location: verDocente.php'); // Redirecciona a la lista de usuarios
        mysqli_close($conexion); // Cierra la conexion con la bd
    }
    $idDoc = $_GET['id']; // Almacena la clave del docente
    // Consulta todos los datos de la clave del docente
    $sql_docente = mysqli_query($conexion,"SELECT d.cve_docente,
                                                  d.nombre,
                                                  d.apellido1,
                                                  d.apellido2,
                                                  d.foto,
                                                  d.institucion,
                                                  d.tipo_contratacion,
                                                  d.fecha_ingreso,
                                                  d.num_empleado,
                                                  d.cuenta,
                                                  d.fecha_add,
                                                  d.user_cve,
                                                  d.activo,
                                                  (d.puesto) AS idpuesto,
                                                  (p.puesto) AS puesto
                                                  FROM docente d INNER JOIN puesto p ON d.puesto = p.cve_puesto WHERE cve_docente = $idDoc");
    $result_sql_docente = mysqli_num_rows($sql_docente); // Almacena la cantidad todal de registros
}

if($result_sql_docente == 0){ // Verifica que la cantidad no este vacia
    $datos = 0;
}else{
    $datos = 1;
    while ($data_docente = mysqli_fetch_array($sql_docente))
    {
        $idDoc = $data_docente['cve_docente']; // Guarda la clave del docente
        $puesto = $data_docente['puesto']; // Guarda el puesto del docente
        $idpuesto = $data_docente['idpuesto']; // Guarda la clave del puesto
        if($idpuesto == 1){ // Si la clave del puesto de usuario es 1 entonces es Profesor
            $option = '<option value="'.$idpuesto.'"select>'.$puesto.'</option>';
        }else if($idpuesto == 2){ // Si la clave del puesto de usuario es 2 entonces es Administrativo
            $option = '<option value="'.$idpuesto.'"select>'.$puesto.'</option>';
        }else if($idpuesto == 3){ // Si la clave del puesto de usuario es 3 entonces es Cordinador
            $option = '<option value="'.$idpuesto.'"select>'.$puesto.'</option>';
        }
        $nombre = $data_docente['nombre']; // Guarda el nombre del docente
        $apellido1 = $data_docente['apellido1']; // Guarda el primer apellido del docente
        $apellido2 = $data_docente['apellido2']; // Guarda el segundo apellido del docente
        $fotoa = $data_docente['foto']; // Guarda el nombre de la fotografia del docente
        $institucion = $data_docente['institucion']; // Guarda el nombre de la institucion
        $tipo_contratacion = $data_docente['tipo_contratacion']; // Guarda el tipo de contratacion
        $fecha_ingreso = $data_docente['fecha_ingreso']; // Guarda la fecha de ingreso a la institucion
        $num_empleado = $data_docente['num_empleado']; // Guarda el numero de empleado del docente
        $cuenta = $data_docente['cuenta']; // Guarda la cuenta asociada
        $fecha_add = $data_docente['fecha_add']; // Guarda la fecha de ingreso al sistema
        $user_cve = $data_docente['user_cve']; // Guarda la clave del usuario que lo agrego
        $activo = $data_docente['activo']; // Guarda el estatus del registro
    }
    // Consulta todos los datos de la tabla informacion
    $sql_informacion = mysqli_query($conexion,"SELECT * FROM informacion WHERE cve_docente = $idDoc");
    while ($data_informacion = mysqli_fetch_array($sql_informacion))
    {
        $cve_info = $data_informacion['cve_info']; // Guarda la clave de informacion
        $fecha_nac = $data_informacion['fecha_nac']; // Guarda la fecha de nacimiento del docente
        $doc_naca = $data_informacion['doc_nac']; // Guarda el nombre del archivo del acta de nacimiento
        $genero = $data_informacion['genero']; // Guarda el genero del docente
        $estado_civil = $data_informacion['estado_civil']; // Guarda el estado civil del docente
        $nacionalidad = $data_informacion['nacionalidad']; // Guarda la nacionalidad del docente
        $curp = $data_informacion['curp']; // Guarda el CURP del docente
        $doc_curpa = $data_informacion['doc_curp']; // Guarda el nombre del archivo CURP del docente
        $rfc = $data_informacion['rfc']; // Guarda el RFC del docente
        $doc_rfca = $data_informacion['doc_rfc']; // Guarda el archivo RFC del docente
        $nss = $data_informacion['nss']; // Guarda el numero de seguridad social del docente
    }
    // Consulta todos los datos de la tabla contacto
    $sql_contacto = mysqli_query($conexion,"SELECT * FROM contacto WHERE cve_docente = $idDoc");
    while ($data_contacto = mysqli_fetch_array($sql_contacto))
    {
        $cve_contacto = $data_contacto['cve_contacto']; // Guarda la clave de contacto
        $correo_ins = $data_contacto['correo_ins']; // Guarda el correo institucional del docente
        $correo_per = $data_contacto['correo_per']; // Guarda el correo personal del docente
        $telefono = $data_contacto['telefono']; // Guarda el numero de telefono del docente
    }
    // Consulta todos los datos de la tabla domicilio
    $sql_domicilio = mysqli_query($conexion,"SELECT * FROM domicilio WHERE cve_docente = $idDoc");
    while ($data_domicilio = mysqli_fetch_array($sql_domicilio))
    {
        $cve_domicilio = $data_domicilio['cve_domicilio']; // Guarda la clave de domicilio
        $calle = $data_domicilio['calle']; // Guarda el nombre de la calle
        $num_ext = $data_domicilio['num_ext']; // Guarda el numero exterior
        $num_int = $data_domicilio['num_int']; // Guarda el numero interior
        $codigo_postal = $data_domicilio['codigo_postal']; // Guarda el codigo postal
        $colonia = $data_domicilio['colonia']; // Guarda el nombre de la colonia
        $municipio = $data_domicilio['municipio']; // Guarda el nombre del municipio
        $ciudad = $data_domicilio['ciudad']; // Guarda el nombre de la ciudad
        $estado = $data_domicilio['estado']; // Guarda el nombre del estado
        $pais = $data_domicilio['pais']; // Guarda el nombre del pais
        $doc_doma = $data_domicilio['doc_dom']; // Guarda el nombre del comprobante de domicilio
    }
    // Consulta todos los datos de la tabla viaje
    $sql_viaje = mysqli_query($conexion,"SELECT * FROM viaje WHERE cve_docente = $idDoc");
    while ($data_viaje = mysqli_fetch_array($sql_viaje))
    {
        $cve_viaje = $data_viaje['cve_viaje']; // Guarda la clave de viaje
        $disp_viaje = $data_viaje['disp_viaje']; // Guarda la disponibilidad de viaje
        $num_pasaporte = $data_viaje['num_pasaporte']; // Guarda el numero de pasaporte del docente
        $fecha_ven_pas = $data_viaje['fecha_ven_pas']; // Guarda la fecha de vencimiento del pasaporte
    }
}
?>

<title>SITA - Informacion del docente</title> <!-- Nombre de la pagina --> 

            <div class="jumbotron">
                <h1 class="display-3">Informacion del docente</h1>
                <hr class="my-2">
                <?php if($datos == 0){ ?> <!-- Valida que contenga datos -->
                    <div class="text-center">
                        <div class="col-md-5 mx-auto">
                        </br>
                            <div class="alert alert-dismissible alert-warning"> <!-- Alerta de que el docente no tiene infromacion -->
                                <h4 class="alert-heading">oh, vaya...</h4>
                                <p class="mb-0"> Parece que aun no ingresa la informacion </p>
                                <br>
                                <div class="text-center">
                                    <button type="button" onclick="location.href='nuevoDocente.php'" class="btn btn-primary mx-auto">Agregar informacion</button> <!-- Redirecciona para crear un nuevo registro -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }else{ ?>
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#docente">Docente</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#informacion">Informacion</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#contacto">Contacto</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#domicilio">Domicilio</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#viaje">Viaje</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#formacion">Formacion</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#experiencia">Experiencia</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#premios">Premios</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#publicaciones">Publicaciones</a> <!-- boton del tab -->
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content"> <!-- Tablas de contenido -->
                        <a><?php echo isset($alert) ? $alert : ''; ?></a> <!-- Espacio para las alertas -->
                        <div class="tab-pane fade active show" id="docente"> <!-- Tabla de datos principales -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Informacion general
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class = "form-group col-md-8">
                                            <label class="form-label mt-2">Nombre o nombres</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>" disabled=""> <!-- Muestra el nombre del docente -->
                                            <label class="form-label mt-2">Primer apellido</label>
                                            <input type="text" class="form-control" name="apellido1" id="apellido1" value="<?php echo $apellido1; ?>" disabled=""> <!-- Muestra el primer apellido del docente -->
                                            <label class="form-label mt-2">Segundo apellido</label>
                                            <input type="text" class="form-control" name="apellido2" id="apellido2" value="<?php echo $apellido2; ?>" disabled=""> <!-- Muestra el segundo apellido del docente -->
                                            <label class="form-label mt-2">Institucion</label>
                                            <input type="text" class="form-control" name="institucion" id="institucion" value="<?php echo $institucion; ?>" disabled=""> <!-- Muestra el nombre de la institucion -->
                                        </div>
                                        <div class = "form-group col-md-4 mx-auto">
                                            <label class="form-label mt-2">Fotografia</label>
                                            <div class="m-0 vh-50 row justify-content-center align-items-center">
                                                <div class="col-auto">
                                                <output><img src="/SITA/sistema/files/docente/foto/<?php echo $fotoa; ?>" style="width: 245px; height:245px;"></output> <!-- Muestra la fotografia del docente -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Tipo de contratacion</label>
                                            <select class="form-select" name="tipo_contratacion" id="tipo_contratacion" disabled="">
                                                <option value="<?php echo $tipo_contratacion; ?>" hidden><?php echo $tipo_contratacion; ?></option> <!-- Muestra el tipo de contratacion -->
                                            </select>
                                        </div>
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Fecha de ingreso</label>
                                            <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo $fecha_ingreso; ?>" disabled=""> <!-- Muestra la fecha de ingreso -->
                                        </div>
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Numero de empleado</label>
                                            <input type="number" class="form-control" name="num_empleado" id="num_empleado" value="<?php echo $num_empleado; ?>" disabled=""> <!-- Muestra el numero de empleado -->
                                        </div>
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Puesto</label>
                                            <?php
                                                include "../config/conexion.php";
                                                $query_puesto = mysqli_query($conexion,"SELECT * FROM puesto");
                                                mysqli_close($conexion);
                                                $result_puesto = mysqli_num_rows($query_puesto);
                                            ?>
                                            <select class="form-select" name="puesto" id="puesto" disabled="">
                                                <?php
                                                    echo $option; // Muestra el puesto del docente
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <form method="post">
                                            <a role="button" class="btn btn-info" href="editarDocente.php?id=<?php echo $idDoc ?>">Editar</a> <!-- Redirecciona para editar el docente -->
                                            <a role="button" class="btn btn-danger" href="../" >Volver</a> <!-- Redirecciona a home -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="informacion"> <!-- Tabla de Informacion -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Informacion especifica <!-- Nombre de la seccion -->
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <div class="row">
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Fecha de nacimiento</label>
                                                <input type="date" class="form-control" name="fecha_nac" id="fecha_nac" value="<?php echo $fecha_nac; ?>" disabled=""> <!-- Muestra la fecha de nacimiento -->
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Genero</label>
                                                <select class="form-select" name="genero" id="genero" disabled="">
                                                    <option value="<?php echo $genero; ?>" hidden><?php echo $genero; ?></option> <!-- Muestra el genero del docente -->
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Nacionalidad</label><br>
                                                <select class="form-select" name="nacionalidad" id="nacionalidad" disabled="">
                                                    <option value="<?php echo $nacionalidad; ?>" hidden><?php echo $nacionalidad; ?></option> <!-- Muestra la nacionalidad -->
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Estado civil</label>
                                                <select class="form-select" name="estado_civil" id="estado_civil" disabled="">
                                                    <option value="<?php echo $estado_civil; ?>" hidden><?php echo $estado_civil; ?></option> <!-- Muestra el estado civil -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero de seguridad social</label>
                                                <input type="number" class="form-control" name="nss" id="nss" value="<?php echo $nss; ?>" disabled=""> <!-- Muestra el numero de seguridad social -->
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">CURP</label>
                                                <input type="text" class="form-control" name="curp" id="curp" value="<?php echo $curp; ?>" disabled=""> <!-- Muestra el CURP -->
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">RFC</label>
                                                <input type="text" class="form-control" name="rfc" id="rfc" value="<?php echo $rfc; ?>" disabled=""> <!-- Muestra el RFC -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <form method="post">
                                            <a role="button" class="btn btn-info" href="editarDocente.php?id=<?php echo $idDoc ?>">Editar</a> <!-- Redirecciona para editar el docente -->
                                            <a role="button" class="btn btn-danger" href="../" >Volver</a> <!-- Redirecciona a home -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contacto"> <!-- Tabla de Contacto -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Informacion de contacto
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <div class="row">
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Correo institucional</label>
                                                <input type="email" class="form-control" name="correo_ins" id="correo_ins" value="<?php echo $correo_ins; ?>" disabled=""> <!-- Muestra el correo institucional -->
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Correo personal</label>
                                                <input type="email" class="form-control" name="correo_per" id="correo_per" value="<?php echo $correo_per; ?>" disabled=""> <!-- Muestra el correo personal -->
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero telefonico</label>
                                                <input type="number" class="form-control" name="telefono" id="telefono" value="<?php echo $telefono; ?>" disabled=""> <!-- Muestra el numero telefonico -->
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <br>
                                            <form method="post">
                                                <a role="button" class="btn btn-info" href="editarDocente.php?id=<?php echo $idDoc ?>">Editar</a> <!-- Redirecciona para editar al docente -->
                                                <a role="button" class="btn btn-danger" href="../" >Volver</a> <!-- Redirecciona a home -->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="domicilio"> <!-- Tabla de Domicilio -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Domicilio
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <div class="row">
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Calle</label>
                                                <input type="text" class="form-control" name="calle" id="calle" value="<?php echo $calle; ?>" disabled=""> <!-- Muestra en nombre de la calle -->
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Numero exterior</label>
                                                <input type="text" class="form-control" name="num_ext" id="num_ext" value="<?php echo $num_ext; ?>" disabled=""> <!-- Muestra el numero exterior -->
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Numero interior</label>
                                                <input type="text" class="form-control" name="num_int" id="num_int" value="<?php echo $num_int; ?>" disabled=""> <!-- Muestra el numero interior -->
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Colonia</label>
                                                <input type="text" class="form-control" name="colonia" id="colonia" value="<?php echo $colonia; ?>" disabled=""> <!-- Muestra el nombre de la colonia -->
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Codigo Postal</label>
                                                <input type="number" class="form-control" name="codigo_postal" value="<?php echo $codigo_postal; ?>" id="codigo_postal" disabled=""> <!-- Muestra el codigo postal -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Municipio</label>
                                                <input type="text" class="form-control" name="municipio" id="municipio" value="<?php echo $municipio; ?>" disabled=""> <!-- Muestra el municipio -->
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Ciudad</label>
                                                <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>" disabled=""> <!-- Muestra la ciudad -->
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Estado</label>
                                                <input type="text" class="form-control" name="estado" id="estado" value="<?php echo $estado; ?>" disabled=""> <!-- Muestra el estado -->
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Pais</label>
                                                <input type="text" class="form-control" name="pais" id="pais" value="<?php echo $pais; ?>" disabled=""> <!-- Muestra el pais -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <form method="post">
                                            <a role="button" class="btn btn-info" href="editarDocente.php?id=<?php echo $idDoc ?>">Editar</a> <!-- Redirecciona para editar el docente -->
                                            <a role="button" class="btn btn-danger" href="../" >Volver</a> <!-- Redirecciona a home -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="viaje"> <!-- Tabla de Viaje -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Viaje
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <div class="row">
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Disponibilidad de viajar</label>
                                                <select class="form-select" name="disp_viaje" id="disp_viaje" disabled="">
                                                    <option value="<?php echo $disp_viaje; ?>" hidden><?php echo $disp_viaje; ?></option> <!-- Muestra la disponibilidad de viajar -->
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero de pasaporte</label>
                                                <input type="number" class="form-control" name="num_pasaporte" id="num_pasaporte" value="<?php echo $num_pasaporte; ?>" disabled=""> <!-- Muestra el numero de pasaporte -->
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Fecha de vencimiento del pasaporte</label>
                                                <input type="date" class="form-control" name="fecha_ven_pas" id="fecha_ven_pas" value="<?php echo $fecha_ven_pas; ?>" disabled=""> <!-- Muestra la fecha de vencimiento -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <form method="post">
                                            <a role="button" class="btn btn-info" href="editarDocente.php?id=<?php echo $idDoc ?>">Editar</a> <!-- Redirecciona para editar el docente -->
                                            <a role="button" class="btn btn-danger" href="../" >Volver</a> <!-- Redirecciona a home -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="formacion"> <!-- Tabla de Formacion -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Lista de formacion academica
                                </div>
                                <div class="card-body">
                                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                                        <div class="container-fluid">
                                            <button type="button" onclick="location.href='nuevoFormacion.php?id_d=<?php echo $idDoc;?>'" class="btn btn-primary">Nuevo Registro</button> <!-- Redirecciona a registrar Formacion -->
                                        </div>
                                    </nav>
                                    <table class="table table-hover">
                                        <thead class="text-center">
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
                                            $query = mysqli_query($conexion, "SELECT * FROM formacion WHERE activo = 1 ORDER BY cve_formacion ASC LIMIT $desde,$por_pagina;");
                                            mysqli_close($conexion); // Cierra la conexion a la bd
                                            $result = mysqli_num_rows($query); // Calcula el numero de filas de la consulta
                                            if($result > 0){ // Valida si el numero de consultas es mayor a cero
                                                while ($data = mysqli_fetch_array($query)){ // Crea un bucle para mostrar los resultados
                                                    ?>
                                                    <tbody class="text-center">
                                                        <tr class="table-active"> <!-- Campos a llenar -->
                                                            <th scope="row"><?php echo $data ['cve_formacion']; ?></th> <!-- La clave del usuario -->
                                                            <td><?php echo $data ['nivel_estudio']; ?></td> <!-- El nivel de estudios -->
                                                            <td><?php echo $data ['siglas_estudio']; ?></td> <!-- Las siglas de los estudios -->
                                                            <td><?php echo $data ['institucion']; ?></td> <!-- El nombre de la institucion -->
                                                            <td><?php echo $data ['area']; ?></td> <!-- El area aplicable -->
                                                            <td><?php echo $data ['disciplina']; ?></td> <!-- La disiplina aplicable -->
                                                            <td><?php echo $data ['pais']; ?></td> <!-- El pais de los estudios -->
                                                            <td><?php echo $data ['fecha_titulacion']; ?></td> <!-- La fecha de titulacion -->
                                                            <td>
                                                                <form method="post">
                                                                    <a role="button" class="btn btn-outline-info" href="infFormacion.php?id_d=<?php echo $idDoc; ?>&id_f=<?php echo $data ['cve_formacion']; ?>">Ver</a> <!-- Redirecciona para visualizar la Formacion -->
                                                                    <a role="button" class="btn btn-outline-warning" href="editarFormacion.php?id_d=<?php echo $idDoc; ?>&id_f=<?php echo $data ['cve_formacion']; ?>">Editar</a> <!-- Redirecciona para editar al Formacion -->
                                                                    <a role="button" class="btn btn-outline-danger" href="eliminarFormacion.php?id_d=<?php echo $idDoc; ?>&id_f=<?php echo $data ['cve_formacion']; ?>" >Borrar</a> <!-- Redirecciona para eliminar la Formacion -->
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
                                            if($total_formacion!= 0){ // Almacena el total de registros de Formacion
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
                                            <div class="alert alert-dismissible alert-light mx-auto"> <!-- Mensaje de que no hay registros -->
                                                <h4 class="alert-heading text-center">No hay formacion registrada para este docente, aun...</h4>
                                                <p class="mb-0 text-center">Agrega el primer registro</p>
                                                <br>
                                                <div class="text-center">
                                                    <a role="button" class="btn btn-primary" href="nuevoFormacion.php?id_d=<?php echo $idDoc;?>" >Nuevo registro</a> <!-- Redirecciona para registrar Formacion -->
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button> <!-- Boton para volver -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="experiencia"> <!-- Tabla de Experiencia -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Lista de experiencias
                                </div>
                                <div class="card-body">
                                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                                        <div class="container-fluid">
                                            <button type="button" onclick="location.href='nuevoExperiencia.php?id_d=<?php echo $idDoc;?>'" class="btn btn-primary">Nuevo Registro</button> <!-- Redirecciona a registrar un nuevo usuario -->
                                        </div>
                                    </nav>
                                    <table class="table table-hover">
                                        <thead class="text-center">
                                            <tr> <!-- Nombre de los campos a mostrar -->
                                            <th scope="col">Clave</th>
                                            <th scope="col">Actividad</th>
                                            <th scope="col">Institucion</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            //Paginador
                                            include "../config/conexion.php";
                                            $sql_experiencia = mysqli_query($conexion, "SELECT COUNT(*) AS tr_experiencia FROM experiencia WHERE activo = 1"); // Cuenta y almacena todos los registros activos
                                            $result_experiencia = mysqli_fetch_array($sql_experiencia);
                                            $total_experiencia = $result_experiencia['tr_experiencia'];
                                            $por_pagina = 5; // Indicador de cuantos registros mostrara por pagina
                                            if(empty($_GET['pagina'])) // Identifica si el numero de paginas no este vacio
                                            {
                                                $pagina = 1;
                                            }else{
                                                $pagina = $_GET['pagina'];
                                            }
                                            $desde = ($pagina-1) * $por_pagina; //Identifica la posicion de la pagina
                                            $total_pagina = ceil($total_experiencia / $por_pagina); // Calcula el total de las paginas
                                            // Realiza la consulta de los datos a mostrar en la lista
                                            $query_experiencia = mysqli_query($conexion, "SELECT * FROM experiencia WHERE activo = 1 ORDER BY cve_experiencia ASC LIMIT $desde,$por_pagina;");
                                            mysqli_close($conexion); // Cierra la conexion a la bd
                                            $result_experiencia = mysqli_num_rows($query_experiencia); // Calcula el numero de filas de la consulta
                                            if($result_experiencia > 0){ // Valida si el numero de consultas es mayor a cero
                                                while ($data_experiencia = mysqli_fetch_array($query_experiencia)){ // Crea un bucle para mostrar los resultados
                                                    ?>
                                                    <tbody class="text-center">
                                                        <tr class="table-active"> <!-- Campos a llenar -->
                                                            <th scope="row"><?php echo $data_experiencia ['cve_experiencia']; ?></th> <!-- La clave del usuario -->
                                                            <td><?php echo $data_experiencia ['actividad']; ?></td> <!-- El tipo del usuario -->
                                                            <td><?php echo $data_experiencia ['institucion']; ?></td> <!-- El nombre del usuario -->
                                                            <td><?php echo $data_experiencia ['periodo']; ?></td> <!-- El primer apellido del usuario -->
                                                            <td>
                                                                <form method="post">
                                                                    <a role="button" class="btn btn-outline-info" href="infExperiencia.php?id_d=<?php echo $idDoc; ?>&id_e=<?php echo $data_experiencia ['cve_experiencia']; ?>">Ver</a> <!-- Redirecciona para visualizar la Experiencia -->
                                                                    <a role="button" class="btn btn-outline-warning" href="editarExperiencia.php?id_d=<?php echo $idDoc; ?>&id_e=<?php echo $data_experiencia ['cve_experiencia']; ?>">Editar</a> <!-- Redirecciona para editar al Experiencia -->
                                                                    <a role="button" class="btn btn-outline-danger" href="eliminarExperiencia.php?id_d=<?php echo $idDoc; ?>&id_e=<?php echo $data_experiencia ['cve_experiencia']; ?>" >Borrar</a> <!-- Redirecciona para eliminar la Experiencia -->
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
                                            if($total_experiencia!= 0){
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
                                                <h4 class="alert-heading text-center">No hay experiencia registrada para este docente, aun...</h4>
                                                <p class="mb-0 text-center">Agrega el primer registro</p>
                                                <br>
                                                <div class="text-center">
                                                    <a role="button" class="btn btn-primary" href="nuevoExperiencia.php?id_d=<?php echo $idDoc;?>" >Nuevo registro</a> <!-- Redirecciona para eliminar al usuario -->
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="premios"> <!-- Tabla de Premios -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Lista de los premios del docente
                                </div>
                                <div class="card-body">
                                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                                        <div class="container-fluid">
                                            <button type="button" onclick="location.href='nuevoPremio.php?id_d=<?php echo $idDoc;?>'" class="btn btn-primary">Nuevo Registro</button> <!-- Redirecciona a registrar un nuevo Premio -->
                                        </div>
                                    </nav>
                                    <table class="table table-hover">
                                        <thead class="text-center">
                                            <tr> <!-- Nombre de los campos a mostrar -->
                                            <th scope="col">Clave</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Institucion</th>
                                            <th scope="col">Motivo</th>
                                            <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            //Paginador
                                            include "../config/conexion.php";
                                            $sql_premio = mysqli_query($conexion, "SELECT COUNT(*) AS tr_premio FROM premios WHERE activo = 1"); // Cuenta y almacena todos los registros activos
                                            $result_premio = mysqli_fetch_array($sql_premio);
                                            $total_premio = $result_premio['tr_premio'];
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
                                            $query_premio = mysqli_query($conexion, "SELECT * FROM premios WHERE activo = 1 ORDER BY cve_premio ASC LIMIT $desde,$por_pagina;");
                                            mysqli_close($conexion); // Cierra la conexion a la bd
                                            $result = mysqli_num_rows($query_premio); // Calcula el numero de filas de la consulta
                                            if($result > 0){ // Valida si el numero de consultas es mayor a cero
                                                while ($data_premio = mysqli_fetch_array($query_premio)){ // Crea un bucle para mostrar los resultados
                                                    ?>
                                                    <tbody class="text-center">
                                                        <tr class="table-active"> <!-- Campos a llenar -->
                                                            <th scope="row"><?php echo $data_premio ['cve_premio']; ?></th> <!-- La clave del usuario -->
                                                            <td><?php echo $data_premio ['nombre']; ?></td> <!-- El tipo del usuario -->
                                                            <td><?php echo $data_premio ['fecha']; ?></td> <!-- El nombre del usuario -->
                                                            <td><?php echo $data_premio ['institucion']; ?></td> <!-- El primer apellido del usuario -->
                                                            <td><?php echo $data_premio ['motivo']; ?></td> <!-- El segundo apellido del usuario -->
                                                            <td>
                                                                <form method="post">
                                                                    <a role="button" class="btn btn-outline-info" href="infPremio.php?id_d=<?php echo $idDoc; ?>&id_pr=<?php echo $data_premio ['cve_premio']; ?>">Ver</a> <!-- Redirecciona para visualizar la Experiencia -->
                                                                    <a role="button" class="btn btn-outline-warning" href="editarPremio.php?id_d=<?php echo $idDoc; ?>&id_pr=<?php echo $data_premio ['cve_premio']; ?>">Editar</a> <!-- Redirecciona para editar al Experiencia -->
                                                                    <a role="button" class="btn btn-outline-danger" href="eliminarPremio.php?id_d=<?php echo $idDoc; ?>&id_pr=<?php echo $data_premio ['cve_premio']; ?>" >Borrar</a> <!-- Redirecciona para eliminar la Experiencia -->
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
                                            if($total_premio!= 0){
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
                                                <h4 class="alert-heading text-center">No hay premios registrados para este docente, aun...</h4>
                                                <p class="mb-0 text-center">Agrega el primer registro</p>
                                                <br>
                                                <div class="text-center">
                                                    <button type="button" onclick="location.href='nuevoPremio.php?id_d=<?php echo $idDoc;?>'" class="btn btn-primary">Nuevo Registro</button> <!-- Redirecciona a registrar un nuevo Premio -->
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="publicaciones"> <!-- Tabla de Publicaciones -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Lista de publicaciones del docente
                                </div>
                                <div class="card-body">
                                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                                        <div class="container-fluid">
                                            <button type="button" onclick="location.href='nuevoPublicacion.php?id_d=<?php echo $idDoc;?>'" class="btn btn-primary">Nuevo Registro</button> <!-- Redirecciona a registrar un nuevo Publicacion -->
                                        </div>
                                    </nav>
                                    <table class="table table-hover">
                                        <thead class="text-center">
                                            <tr> <!-- Nombre de los campos a mostrar -->
                                            <th scope="col">Clave</th>
                                            <th scope="col">Articulo</th>
                                            <th scope="col">Revista/Libro</th>
                                            <th scope="col">Editorial</th>
                                            <th scope="col">Volumen</th>
                                            <th scope="col">Fecha de publicacion</th>
                                            <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            //Paginador
                                            include "../config/conexion.php";
                                            $sql_publicacion = mysqli_query($conexion, "SELECT COUNT(*) AS tr_publicacion FROM publicaciones WHERE activo = 1"); // Cuenta y almacena todos los registros activos
                                            $result_publicacion = mysqli_fetch_array($sql_publicacion);
                                            $total_publicacion = $result_publicacion['tr_publicacion'];
                                            $por_pagina = 5; // Indicador de cuantos registros mostrara por pagina
                                            if(empty($_GET['pagina'])) // Identifica si el numero de paginas no este vacio
                                            {
                                                $pagina = 1;
                                            }else{
                                                $pagina = $_GET['pagina'];
                                            }
                                            $desde = ($pagina-1) * $por_pagina; //Identifica la posicion de la pagina
                                            $total_pagina = ceil($total_publicacion / $por_pagina); // Calcula el total de las paginas
                                            // Realiza la consulta de los datos a mostrar en la lista
                                            $query_publicacion = mysqli_query($conexion, "SELECT * FROM publicaciones WHERE activo = 1 ORDER BY cve_publicacion ASC LIMIT $desde,$por_pagina;");
                                            mysqli_close($conexion); // Cierra la conexion a la bd
                                            $result = mysqli_num_rows($query_publicacion); // Calcula el numero de filas de la consulta
                                            if($result > 0){ // Valida si el numero de consultas es mayor a cero
                                                while ($data_publicacion = mysqli_fetch_array($query_publicacion)){ // Crea un bucle para mostrar los resultados
                                                    ?>
                                                    <tbody class="text-center">
                                                        <tr class="table-active"> <!-- Campos a llenar -->
                                                            <th scope="row"><?php echo $data_publicacion ['cve_publicacion']; ?></th> <!-- La clave del usuario -->
                                                            <td><?php echo $data_publicacion ['titulo_articulo']; ?></td> <!-- El tipo del usuario -->
                                                            <td><?php echo $data_publicacion ['titulo_revista']; ?></td> <!-- El nombre del usuario -->
                                                            <td><?php echo $data_publicacion ['editorial']; ?></td> <!-- El primer apellido del usuario -->
                                                            <td><?php echo $data_publicacion ['volumen']; ?></td> <!-- El segundo apellido del usuario -->
                                                            <td><?php echo $data_publicacion ['fecha_publicacion']; ?></td> <!-- El segundo apellido del usuario -->
                                                            <td>
                                                                <form method="post">
                                                                    <a role="button" class="btn btn-outline-info" href="infPublicacion.php?id_d=<?php echo $idDoc; ?>&id_pu=<?php echo $data_publicacion ['cve_publicacion']; ?>">Ver</a> <!-- Redirecciona para visualizar la Experiencia -->
                                                                    <a role="button" class="btn btn-outline-warning" href="editarPublicacion.php?id_d=<?php echo $idDoc; ?>&id_pu=<?php echo $data_publicacion ['cve_publicacion']; ?>">Editar</a> <!-- Redirecciona para editar al Experiencia -->
                                                                    <a role="button" class="btn btn-outline-danger" href="eliminarPublicacion.php?id_d=<?php echo $idDoc; ?>&id_pu=<?php echo $data_publicacion ['cve_publicacion']; ?>" >Borrar</a> <!-- Redirecciona para eliminar la Experiencia -->
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
                                            if($total_publicacion!= 0){
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
                                                <h4 class="alert-heading text-center">No hay publicaciones registrados para este docente, aun...</h4>
                                                <p class="mb-0 text-center">Agrega el primer registro</p>
                                                <br>
                                                <div class="text-center">
                                                    <button type="button" onclick="location.href='nuevoPublicacion.php?id_d=<?php echo $idDoc;?>'" class="btn btn-primary">Nuevo Registro</button> <!-- Redirecciona a registrar un nuevo Publicacion -->
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php } ?>
            </div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[infDocente] (Prototipo) ---
Ultima modificacion -- [29/06/2022 (14:45 hrs)]
-->