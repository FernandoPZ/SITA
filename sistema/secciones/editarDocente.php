<?php include("../template/cabecera.php"); ?> <!-- Cabecera de la pagina -->

<?php
if($_SESSION['tipo'] == 3) // Validacion de tipo de usuario
{
    header("location: /sistema/index.php"); //Regresa a la pagina principal
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
include "../config/conexion.php"; // Realiza la coneccion de la bd
$user = $_SESSION['cve_usuario'] // Guarda la clave de usuario con la que entra
?>

<?php
if(empty($_GET['id'])) // Valida si la clave del usuario no esta vacia
{
    header('location: verUsuario.php'); // Redirecciona a la lista de usuarios
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
if($result_sql_docente == 0){ // Verifica que la cantidad no este vacia
    header('Location: verUsuario.php'); // Redirecciona a la lista de usuarios
}else{
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
        $cuenta = $data_docente['cuenta']; // Guarda la cuenta vinculada
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

<?php
    if($_SESSION['tipo'] == 4) // Valida si el usuario es docente
    {
        if($cuenta == $_SESSION['cve_usuario']){ // Valida si el usuario edita su propia informacion
        }else{
            header("location: ../"); // Redirecciona a la pagina anterior
        }
    }
?>

<?php
switch($decision){ // Apartado de deciciones
    case "actualizar": // Guargar
        if(!empty($_POST)){ // Valida si los campos no esten vacios
            $alert=''; // Validacion de la alerta
            // Tabla docente
            if(empty($_POST['puesto']) // puesto del docente
            || empty($_POST['nombre']) // Nombre del docente
            || empty($_POST['apellido1']) // Primer apellido del docente
            || empty($_POST['apellido2']) // Segundo apellido del docente
            || empty($_FILES['foto']) // Foto del docente
            || empty($_POST['institucion']) // Nombre de la institucion
            || empty($_POST['tipo_contratacion']) // Tipo de contratacion
            || empty($_POST['fecha_ingreso']) // Fecha de ingreso a la institucion
            || empty($_POST['num_empleado']) // Numero de empleado asignado
            // Tabla informacion
            || empty($_POST['fecha_nac']) // Fecha de nacimiento
            || empty($_FILES['doc_nac']) // Acta de nacimiento
            || empty($_POST['genero']) // Genero
            || empty($_POST['estado_civil']) // Estado civil
            || empty($_POST['nacionalidad']) // Nacionalidad
            || empty($_POST['curp']) // Curp
            || empty($_FILES['doc_curp']) // Documento del curp
            || empty($_POST['rfc']) // RFC
            || empty($_FILES['doc_rfc']) // Documento del rfc
            || empty($_POST['nss']) // Numero de seguridad social
            // Tabla contacto
            || empty($_POST['correo_ins']) // Correo institucional
            || empty($_POST['correo_per']) // Correo personal
            || empty($_POST['telefono']) // Numero de telefono
            // Tabla domicilio
            || empty($_POST['calle']) // Nombre de la calle
            || empty($_POST['num_ext']) // Numero exterior
            || empty($_POST['num_int']) // Numero interior
            || empty($_POST['codigo_postal']) // Codigo postal
            || empty($_POST['colonia']) // Nombre de la colonia
            || empty($_POST['municipio']) // Nombre del municipio
            || empty($_POST['ciudad']) // Nombre de la ciudad
            || empty($_POST['estado']) // Nombre del estado
            || empty($_POST['pais']) // Nombre del pais
            || empty($_FILES['doc_dom']) // Comprobante de domicilio
            // Tabla viaje
            || empty($_POST['disp_viaje']) // Disponibilidad de viajar
            || empty($_POST['num_pasaporte']) // Numero de pasaporte
            || empty($_POST['fecha_ven_pas'])){ // Fecha de vencimiento del pasaporte
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                $fecha= new DateTime(); // Determina la fecha actual
                // Tabla docente
                $puesto = $_POST['puesto']; // Guarda el puesto del docente
                $nombre = $_POST['nombre']; // Guarda el nombre del docente
                $apellido1 = $_POST['apellido1']; // Guarda el primer apellido del docente
                $apellido2 = $_POST['apellido2']; // Guarda el segundo apellido del docente
                $foto = $_FILES['foto']['name']; // Guarda la foto del docente
                $nombreFoto=($foto!="")?$fecha->getTimestamp()."_".$foto:"$fotoa"; // Asignacion de nombre unico a la foto
                $institucion = $_POST['institucion']; // Guarda el nombre de la institucion
                $tipo_contratacion = $_POST['tipo_contratacion']; // Guarda el tipo de contratacion
                $fecha_ingreso = $_POST['fecha_ingreso']; // Guarda la fecha de ingreso
                $num_empleado = $_POST['num_empleado']; // Guarda el numero de empleado
                // Tabla informacion
                $fecha_nac = $_POST['fecha_nac']; // Guarda la fecha de nacimiento
                $doc_nac = $_FILES['doc_nac']['name']; // Guarda el acta de nacimiento del docente
                $nombre_doc_nac=($doc_nac!="")?$fecha->getTimestamp()."_".$doc_nac:"$doc_naca"; // Asignacion de nombre unico al acta de nacimiento
                $genero = $_POST['genero']; // Guarda el genero del docente
                $estado_civil = $_POST['estado_civil']; // Guarda el estado civil del docente
                $nacionalidad = $_POST['nacionalidad']; // Guarda la nacionalidad del docente
                $curp = $_POST['curp']; // Guarda el curp del docente
                $doc_curp = $_FILES['doc_curp']['name']; // Guarda el documento curp del docente
                $nombre_doc_curp=($doc_curp!="")?$fecha->getTimestamp()."_".$doc_curp:"$doc_curpa"; // Asignacion de nombre unico al curp
                $rfc = $_POST['rfc']; // Guarda el RFC del docente
                $doc_rfc = $_FILES['doc_rfc']['name']; // Guarda el documento rfc del docente
                $nombre_doc_rfc=($doc_rfc!="")?$fecha->getTimestamp()."_".$doc_rfc:"$doc_rfca"; // Asignacion de nombre unico al rfc
                $nss = $_POST['nss']; // Guarda el numero de seguridad social del docente
                // Tabla contacto
                $correo_ins = $_POST['correo_ins']; //Guarda el correo institucional del docente
                $correo_per = $_POST['correo_per']; // Guarda el correo personal del docente
                $telefono = $_POST['telefono']; // Guarda el numero de telefono del docente
                // Tabla domicilio
                $calle = $_POST['calle']; // Guarda el nombre de la calle
                $num_ext = $_POST['num_ext']; // Guarda el numero exterior
                $num_int = $_POST['num_int']; // Guarda el numero interior
                $codigo_postal = $_POST['codigo_postal']; // Guarda el codigo postal
                $colonia = $_POST['colonia']; // Guarda el nombre de la colonia
                $municipio = $_POST['municipio']; // Guarda el nombre del municipio
                $ciudad = $_POST['ciudad']; // Guarda el nombre de la ciudad
                $estado = $_POST['estado']; // Guarda el nombre del estado
                $pais = $_POST['pais']; // Guarda el nombre del pais
                $doc_dom = $_FILES['doc_dom']['name']; // Guarda el comprobante de domicilio
                $nombre_doc_dom=($doc_dom!="")?$fecha->getTimestamp()."_".$doc_dom:"$doc_doma"; // Asignacion de nombre unico al comprobante de domicilio
                // Tabla viaje
                $disp_viaje = $_POST['disp_viaje']; // Guarda la disponibilidad de viaje
                $num_pasaporte = $_POST['num_pasaporte']; // Guarda el numero del pasaporte
                $fecha_ven_pas = $_POST['fecha_ven_pas']; // Guarda la fecha de vencimiento del pasaporte
                // Sentencias de sql
                $query = mysqli_query($conexion,"SELECT * FROM docente WHERE (num_empleado = '$num_empleado' AND cve_docente != $idDoc)"); // Verifica que el numero de empleado introducido este en la bd
                $result = mysqli_fetch_array($query); // Almacena cuantas coincidencias existen
                if($result > 0){ // Si hay alguna coincidencia con el numero de empleado, muestra la alerta
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el numero de empleado introducido ya esta registrado.
                    </div>
                    '; // Alerta de coincidencia de numero de empleado
                }else{
                    // Actualizar en la tabla docente
                    $query_update_docente = mysqli_query($conexion,"UPDATE docente SET puesto = '$puesto',
                                                                                       nombre = '$nombre',
                                                                                       apellido1 = '$apellido1',
                                                                                       apellido2 = '$apellido2',
                                                                                       foto = '$nombreFoto',
                                                                                       institucion = '$institucion',
                                                                                       tipo_contratacion = '$tipo_contratacion',
                                                                                       fecha_ingreso = '$fecha_ingreso',
                                                                                       num_empleado = '$num_empleado'
                                                                                       WHERE cve_docente = '$idDoc'");
                    if($query_update_docente){ // Valida si se realizo la actualizacion en la tabla docentes
                         // Actualiza en la tabla informacion
                        $query_update_informacion = mysqli_query($conexion,"UPDATE informacion SET fecha_nac = '$fecha_nac',
                                                                                                   doc_nac = '$nombre_doc_nac',
                                                                                                   genero = '$genero',
                                                                                                   estado_civil = '$estado_civil',
                                                                                                   nacionalidad = '$nacionalidad',
                                                                                                   curp = '$curp',
                                                                                                   doc_curp = '$nombre_doc_curp',
                                                                                                   rfc = '$rfc',
                                                                                                   doc_rfc = '$nombre_doc_rfc',
                                                                                                   nss = '$nss'
                                                                                                   WHERE cve_docente = '$idDoc'");
                        if($query_update_informacion){ // Valida si se realizo la actualizacion en la tabla informacion
                            // Actualiza en la tabla contacto
                            $query_update_contacto = mysqli_query($conexion,"UPDATE contacto SET correo_ins = '$correo_ins',
                                                                                                 correo_per = '$correo_per',
                                                                                                 telefono = '$telefono'
                                                                                                 WHERE cve_docente = '$idDoc'");
                            if($query_update_contacto){ // Valida si se realizo la actualizacion en la tabla contacto
                                // Actualiza en la tabla domicilio
                                $query_update_domicilio = mysqli_query($conexion,"UPDATE domicilio SET calle = '$calle',
                                                                                                       num_ext = '$num_ext',
                                                                                                       num_int = '$num_int',
                                                                                                       codigo_postal = '$codigo_postal',
                                                                                                       colonia = '$colonia',
                                                                                                       municipio = '$municipio',
                                                                                                       ciudad = '$ciudad',
                                                                                                       estado = '$estado',
                                                                                                       pais = '$pais',
                                                                                                       doc_dom = '$nombre_doc_dom'
                                                                                                       WHERE cve_docente = '$idDoc'");
                                if($query_update_domicilio){ // Valida si se realizo la actualizacion en la tabla domicilio
                                    // Actualiza en la tabla viaje
                                    $query_update_viaje = mysqli_query($conexion,"UPDATE viaje SET disp_viaje = '$disp_viaje',
                                                                                                   num_pasaporte = '$num_pasaporte',
                                                                                                   fecha_ven_pas = '$fecha_ven_pas'
                                                                                                   WHERE cve_docente = '$idDoc'");
                                    if($query_update_viaje){ // Valida si se realizo la actualizacion en la tabla viaje
                                        $alert='
                                            <div class="alert alert-dismissible alert-success">
                                                <strong>Listo!</strong> El docente se actualizó correctamente.
                                            </div>
                                        '; // Alerta de que se actualizo correctamente
                                        $archivoFoto=$_FILES["foto"]["tmp_name"]; // Almacena la imagen subida
                                        if($archivoFoto!=""){ // Verifica que el campo de subida no este vacio
                                            move_uploaded_file($archivoFoto,"../files/docente/foto/".$nombreFoto); // Mueve la imagen subida a otra carpeta dentro del sistema
                                        }
                                        $archivo_doc_nac=$_FILES["doc_nac"]["tmp_name"]; // Almacena el archivo subido
                                        if($archivoFoto!=""){ // Verifica que el campo de subida no este vacio
                                            move_uploaded_file($archivo_doc_nac,"../files/docente/naci/".$nombre_doc_nac); // Mueve el archivo subida a otra carpeta dentro del sistema
                                        }
                                        $archivo_doc_curp=$_FILES["doc_curp"]["tmp_name"]; // Almacena el archivo subido
                                        if($archivoFoto!=""){ // Verifica que el campo de subida no este vacio
                                            move_uploaded_file($archivo_doc_curp,"../files/docente/curp/".$nombre_doc_curp); // Mueve el archivo subida a otra carpeta dentro del sistema
                                        }
                                        $archivo_doc_rfc=$_FILES["doc_rfc"]["tmp_name"]; // Almacena el archivo subido
                                        if($archivoFoto!=""){ // Verifica que el campo de subida no este vacio
                                            move_uploaded_file($archivo_doc_rfc,"../files/docente/rfc/".$nombre_doc_rfc); // Mueve el archivo subida a otra carpeta dentro del sistema
                                        }
                                        $archivo_doc_dom=$_FILES["doc_dom"]["tmp_name"]; // Almacena el archivo subido
                                        if($archivoFoto!=""){ // Verifica que el campo de subida no este vacio
                                            move_uploaded_file($archivo_doc_dom,"../files/docente/domi/".$nombre_doc_dom); // Mueve el archivo subida a otra carpeta dentro del sistema
                                        }
                                    }else{
                                        $alert='
                                            <div class="alert alert-dismissible alert-danger">
                                                <strong>Algo salió mal en el apartado Viaje...</strong> El usuario no se pudo guardar, contacte a soporte.
                                            </div>
                                        '; // Alerta de algun problema al guardar el registro
                                    }
                                }else{
                                    $alert='
                                        <div class="alert alert-dismissible alert-danger">
                                            <strong>Algo salió mal en el apartado Domicilio...</strong> El usuario no se pudo guardar, contacte a soporte.
                                        </div>
                                    '; // Alerta de algun problema al guardar el registro
                                }
                            }else{
                                $alert='
                                    <div class="alert alert-dismissible alert-danger">
                                        <strong>Algo salió mal en el apartado Contacto...</strong> El usuario no se pudo guardar, contacte a soporte.
                                    </div>
                                '; // Alerta de algun problema al guardar el registro
                            }
                        }else{
                            $alert='
                                <div class="alert alert-dismissible alert-danger">
                                    <strong>Algo salió mal en el apartado Información...</strong> El usuario no se pudo guardar, contacte a soporte.
                                </div>
                            '; // Alerta de algun problema al guardar el registro
                        }
                    }else{
                        $alert='
                            <div class="alert alert-dismissible alert-danger">
                                <strong>Algo salió mal en el apartado Docente...</strong> El usuario no se pudo guardar, contacte a soporte.
                            </div>
                        '; // Alerta de algun problema al guardar el registro
                    }
                }
            }
        }
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
    case "volver": // Cancelar
        header('Location:/sistema/secciones/verDocente.php'); // Redirecciona a la lista de los docentes
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
}
?>

<title>SITA - Editar docente</title> <!-- Nombre de la pagina --> 

            <div class="jumbotron">
                <h1 class="display-3">Editar docente</h1>
                <hr class="my-2">
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#docente">Docente</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#informacion">Información</a> <!-- boton del tab -->
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
                    </ul>
                    <div id="myTabContent" class="tab-content"> <!-- Tablas de contenido -->
                        <a><?php echo isset($alert) ? $alert : ''; ?></a> <!-- Espacio para las alertas -->
                        <div class="tab-pane fade active show" id="docente"> <!-- Tabla de datos principales -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Información general
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class = "form-group col-md-8">
                                            <label class="form-label mt-2">Nombre o nombres</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre(s)">
                                            <label class="form-label mt-2">Primer apellido</label>
                                            <input type="text" class="form-control" name="apellido1" id="apellido1" value="<?php echo $apellido1; ?>" placeholder="Primer apellido">
                                            <label class="form-label mt-2">Segundo apellido</label>
                                            <input type="text" class="form-control" name="apellido2" id="apellido2" value="<?php echo $apellido2; ?>" placeholder="Segundo apellido">
                                            <label class="form-label mt-2">Institución</label>
                                            <input type="text" class="form-control" name="institucion" id="institucion" value="<?php echo $institucion; ?>" placeholder="Nombre de la institucion">
                                        </div>
                                        <div class = "form-group col-md-4 mx-auto">
                                            <label class="form-label mt-2">Fotografía</label>
                                            <input type="file" class="form-control" name="foto" id="foto">
                                            <p class="text-secondary"><small>Dejar en blanco si no quiere cambiar de fotografía</small></p>
                                            <div class="m-0 vh-50 row justify-content-center align-items-center">
                                                <div class="col-auto">
                                                    <br>
                                                    <output id="previsual"></output> <!-- Espacio para previsualizar la foto subida -->
                                                    <script> <?php include("../js/scripts.js"); ?> </script> <!-- llama al script necesario para poder previsualizar -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Tipo de contratación</label>
                                            <select class="form-select" name="tipo_contratacion" id="tipo_contratacion">
                                                <option value="<?php echo $tipo_contratacion; ?>" hidden><?php echo $tipo_contratacion; ?></option>
                                                <option value="Tiempo completo">Tiempo completo</option>
                                                <option value="Medio tiempo">Medio tiempo</option>
                                            </select>
                                        </div>
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Fecha de ingreso</label>
                                            <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo $fecha_ingreso; ?>">
                                        </div>
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Numero de empleado</label>
                                            <input type="number" class="form-control" name="num_empleado" id="num_empleado" value="<?php echo $num_empleado; ?>" placeholder="10 digitos">
                                        </div>
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Puesto</label>
                                            <?php
                                                include "../config/conexion.php";
                                                $query_puesto = mysqli_query($conexion,"SELECT * FROM puesto");
                                                mysqli_close($conexion);
                                                $result_puesto = mysqli_num_rows($query_puesto);
                                            ?>
                                            <select class="form-select" name="puesto" id="puesto">
                                                <?php
                                                    echo $option; // Muestra la opcion actual
                                                    if($result_puesto > 0)
                                                    {
                                                        while ($puesto = mysqli_fetch_array($query_puesto)){
                                                            ?>
                                                            <option value="" hidden>Selecciona una opción</option>
                                                            <option value="<?php echo $puesto["cve_puesto"]; ?>"><?php echo $puesto["puesto"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="informacion"> <!-- Tabla de Informacion -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Información especifica <!-- Nombre de la seccion -->
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <div class="row">
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Fecha de nacimiento</label>
                                                <input type="date" class="form-control" name="fecha_nac" id="fecha_nac" value="<?php echo $fecha_nac; ?>">
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Genero</label>
                                                <select class="form-select" name="genero" id="genero">
                                                    <option value="<?php echo $genero; ?>" hidden><?php echo $genero; ?></option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Acta de nacimiento </label><span class="text-secondary"><small> (Dejar en blanco si no quiere actualizar el archivo)</small></span>
                                                <input type="file" class="form-control" name="doc_nac" id="doc_nac">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Nacionalidad</label><br>
                                                <select class="form-select" name="nacionalidad" id="nacionalidad">
                                                    <option value="<?php echo $nacionalidad; ?>" hidden><?php echo $nacionalidad; ?></option>
                                                    <option value="Mexicana">Mexicana</option>
                                                    <option value="Extranjera">Extranjera</option>
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Estado civil</label>
                                                <select class="form-select" name="estado_civil" id="estado_civil">
                                                    <option value="<?php echo $estado_civil; ?>" hidden><?php echo $estado_civil; ?></option>
                                                    <option value="Soltero">Soltero</option>
                                                    <option value="Casado">Casado</option>
                                                    <option value="Divorciado">Divorciado</option>
                                                    <option value="Union libre">Unión libre</option>
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero de seguridad social</label>
                                                <input type="number" class="form-control" name="nss" id="nss" value="<?php echo $nss; ?>" placeholder="10 caracteres">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">CURP</label>
                                                <input type="text" class="form-control" name="curp" id="curp" value="<?php echo $curp; ?>" placeholder="18 caracteres">
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Documento CURP</label><span class="text-secondary"><small> (Dejar en blanco si no quiere actualizar el archivo)</small></span>
                                                <input type="file" class="form-control" name="doc_curp" id="doc_curp">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">RFC</label>
                                                <input type="text" class="form-control" name="rfc" id="rfc" value="<?php echo $rfc; ?>" placeholder="13 caracteres">
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Documento RFC</label><span class="text-secondary"><small> (Dejar en blanco si no quiere actualizar el archivo)</small></span>
                                                <input type="file" class="form-control" name="doc_rfc" id="doc_rfc">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-6">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contacto"> <!-- Tabla de Contacto -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Información de contacto
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <div class="row">
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Correo institucional</label>
                                                <input type="email" class="form-control" name="correo_ins" id="correo_ins" value="<?php echo $correo_ins; ?>" placeholder="correo@ejemplo.com">
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Correo personal</label>
                                                <input type="email" class="form-control" name="correo_per" id="correo_per" value="<?php echo $correo_per; ?>" placeholder="correo@ejemplo.com">
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero telefónico</label>
                                                <input type="number" class="form-control" name="telefono" id="telefono" value="<?php echo $telefono; ?>" placeholder="10 digitos">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <br>
                                            <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="domicilio"> <!-- Tabla de Domicilio -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Información de domicilio
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <div class="row">
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Calle</label>
                                                <input type="text" class="form-control" name="calle" id="calle" value="<?php echo $calle; ?>" placeholder="Nombre de la calle">
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Numero exterior</label>
                                                <input type="text" class="form-control" name="num_ext" id="num_ext" value="<?php echo $num_ext; ?>" placeholder="Numero exterior">
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Numero interior</label>
                                                <input type="text" class="form-control" name="num_int" id="num_int" value="<?php echo $num_int; ?>" placeholder="Numero interior">
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Colonia</label>
                                                <input type="text" class="form-control" name="colonia" id="colonia" value="<?php echo $colonia; ?>" placeholder="Nombre de la colonia">
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Codigo Postal</label>
                                                <input type="number" class="form-control" name="codigo_postal" value="<?php echo $codigo_postal; ?>" id="codigo_postal" placeholder="xxxxx">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Municipio</label>
                                                <input type="text" class="form-control" name="municipio" id="municipio" value="<?php echo $municipio; ?>" placeholder="Nombre del municipio">
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Ciudad</label>
                                                <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>" placeholder="Nombre de la ciudad">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Estado</label>
                                                <input type="text" class="form-control" name="estado" id="estado" value="<?php echo $estado; ?>" placeholder="Nombre del estado">
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">País</label>
                                                <input type="text" class="form-control" name="pais" id="pais" value="<?php echo $pais; ?>" placeholder="Nombre del pais">
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Comprobante de domicilio</label><span class="text-secondary"><small> (Dejar en blanco si no quiere actualizar el archivo)</small></span>
                                                <input type="file" class="form-control" name="doc_dom" id="doc_dom">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="viaje"> <!-- Tabla de Viaje -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Información de viaje
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <div class="row">
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Disponibilidad de viajar</label>
                                                <select class="form-select" name="disp_viaje" id="disp_viaje">
                                                    <option value="<?php echo $disp_viaje; ?>" hidden><?php echo $disp_viaje; ?></option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero de pasaporte</label>
                                                <input type="number" class="form-control" name="num_pasaporte" id="num_pasaporte" value="<?php echo $num_pasaporte; ?>" placeholder="xxxxxxxxxx">
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Fecha de vencimiento del pasaporte</label>
                                                <input type="date" class="form-control" name="fecha_ven_pas" id="fecha_ven_pas" value="<?php echo $fecha_ven_pas; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                        <button type="submit" name="decision" value="actualizar" class="btn btn-primary" style="float: center;">Actualizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de pagina -->

<!--
--- Pagina[editarDocente] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:35 hrs)]
-->