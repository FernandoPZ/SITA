<?php include("../template/cabecera.php"); ?> <!-- Cabecera de la pagina -->

<?php
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
include "../config/conexion.php"; // Realiza la coneccion de la bd
$user = $_SESSION['cve_usuario']; // Guarda la clave de usuario con la que entra
?>

<?php
if($_SESSION['tipo'] == 3) // Validacion de tipo de usuario
{
    header("location: /sistema/index.php"); //Regresa a la pagina principal
}
if($_SESSION['tipo'] == 4) // Validacion de tipo de usuario
{
    $sql_docente = mysqli_query($conexion,"SELECT * FROM docente WHERE cuenta = $user"); // Consulta todos los datos de la clave del docente
    $result_sql_docente = mysqli_num_rows($sql_docente); // Almacena la cantidad todal de registros
    if($result_sql_docente != 0){ // Verifica que la cantidad este vacia
        header("location: /sistema/index.php"); //Regresa a la pagina principal
    }
}
?>

<?php
switch($decision){ // Apartado de deciciones
    case "guardar": // Guargar
        if(!empty($_POST)){ // Valida si los campos no esten vacios
            $alert=''; // Validacion de la alerta
            // Tabla docente
            if(empty($_POST['puesto']) // puesto del docente
            || empty($_POST['nombre']) // Nombre del docente
            || empty($_POST['apellido1']) // Primer apellido del docente
            || empty($_POST['apellido2']) // Segundo apellido del docente
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
                if($_SESSION['tipo'] == 4){
                    $nombreFoto=$s_foto; // Asignacion de nombre unico a la foto
                }else{
                    $foto = $_FILES['foto']['name']; // Guarda la foto del docente
                    $nombreFoto=($foto!="")?$fecha->getTimestamp()."_".$foto:"default.png"; // Asignacion de nombre unico a la foto
                }
                $institucion = $_POST['institucion']; // Guarda el nombre de la institucion
                $tipo_contratacion = $_POST['tipo_contratacion']; // Guarda el tipo de contratacion
                $fecha_ingreso = $_POST['fecha_ingreso']; // Guarda la fecha de ingreso
                $num_empleado = $_POST['num_empleado']; // Guarda el numero de empleado
                if($_SESSION['tipo'] == 4) // Validacion de tipo de usuario
                {
                    $cuenta = $user;
                }
                else
                {
                    $cuenta = 0;
                }
                // Tabla informacion
                $fecha_nac = $_POST['fecha_nac']; // Guarda la fecha de nacimiento
                $doc_nac = $_FILES['doc_nac']['name']; // Guarda el acta de nacimiento del docente
                $nombre_doc_nac=($doc_nac!="")?$fecha->getTimestamp()."_".$doc_nac:"NO_DISPONIBLE"; // Asignacion de nombre unico al acta de nacimiento
                $genero = $_POST['genero']; // Guarda el genero del docente
                $estado_civil = $_POST['estado_civil']; // Guarda el estado civil del docente
                $nacionalidad = $_POST['nacionalidad']; // Guarda la nacionalidad del docente
                $curp = $_POST['curp']; // Guarda el curp del docente
                $doc_curp = $_FILES['doc_curp']['name']; // Guarda el documento curp del docente
                $nombre_doc_curp=($doc_curp!="")?$fecha->getTimestamp()."_".$doc_curp:"NO_DISPONIBLE"; // Asignacion de nombre unico al curp
                $rfc = $_POST['rfc']; // Guarda el RFC del docente
                $doc_rfc = $_FILES['doc_rfc']['name']; // Guarda el documento rfc del docente
                $nombre_doc_rfc=($doc_rfc!="")?$fecha->getTimestamp()."_".$doc_rfc:"NO_DISPONIBLE"; // Asignacion de nombre unico al rfc
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
                $nombre_doc_dom=($doc_dom!="")?$fecha->getTimestamp()."_".$doc_dom:"NO_DISPONIBLE"; // Asignacion de nombre unico al comprobante de domicilio
                // Tabla viaje
                $disp_viaje = $_POST['disp_viaje']; // Guarda la disponibilidad de viaje
                $num_pasaporte = $_POST['num_pasaporte']; // Guarda el numero del pasaporte
                $fecha_ven_pas = $_POST['fecha_ven_pas']; // Guarda la fecha de vencimiento del pasaporte
                // Sentencias de sql
                // Validacion de numero de empleado
                $query_num = mysqli_query($conexion,"SELECT * FROM docente WHERE num_empleado = '$num_empleado'"); // Verifica que el numero de empleado introducido este en la bd
                $result_num = mysqli_fetch_array($query_num); // Almacena cuantas coincidencias existen
                if($result_num > 0){ // Si hay alguna coincidencia con el numero de empleado, muestra la alerta
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el numero de empleado introducido ya está registrado.
                    </div>
                    '; // Alerta de coincidencia de numero de empleado
                }else{
                    // Validacion de nss
                    $query_nss = mysqli_query($conexion,"SELECT * FROM informacion WHERE nss = '$nss'"); // Verifica que el nss introducido este en la bd
                    $result_nss = mysqli_fetch_array($query_nss); // Almacena cuantas coincidencias existen
                    if($result_nss > 0){ // Si hay alguna coincidencia, muestra la alerta
                        $alert='
                        <div class="alert alert-dismissible alert-warning">
                            <strong>Oh vaya...</strong> el numero de seguro social introducido ya está registrado.
                        </div>
                        '; // Alerta de coincidencia de nss
                    }else{
                        // Validacion de curp
                        $query_curp = mysqli_query($conexion,"SELECT * FROM informacion WHERE curp = '$curp'"); // Verifica que el curp introducido este en la bd
                        $result_curp = mysqli_fetch_array($query_curp); // Almacena cuantas coincidencias existen
                        if($result_curp > 0){ // Si hay alguna coincidencia, muestra la alerta
                            $alert='
                            <div class="alert alert-dismissible alert-warning">
                                <strong>Oh vaya...</strong> el CURP introducido ya está registrado.
                            </div>
                            '; // Alerta de coincidencia de curp
                        }else{
                            // Validacion de rfc
                            $query_rfc = mysqli_query($conexion,"SELECT * FROM informacion WHERE rfc = '$rfc'"); // Verifica que el rfc introducido este en la bd
                            $result_rfc = mysqli_fetch_array($query_rfc); // Almacena cuantas coincidencias existen
                            if($result_rfc > 0){ // Si hay alguna coincidencia, muestra la alerta
                                $alert='
                                <div class="alert alert-dismissible alert-warning">
                                    <strong>Oh vaya...</strong> el RFC introducido ya está registrado.
                                </div>
                                '; // Alerta de coincidencia de rfc
                            }else{
                                // Validacion de correo institucional
                                $query_ins = mysqli_query($conexion,"SELECT * FROM contacto WHERE correo_ins = '$correo_ins'"); // Verifica que el correo introducido este en la bd
                                $result_ins = mysqli_fetch_array($query_ins); // Almacena cuantas coincidencias existen
                                if($result_ins > 0){ // Si hay alguna coincidencia, muestra la alerta
                                    $alert='
                                    <div class="alert alert-dismissible alert-warning">
                                        <strong>Oh vaya...</strong> el correo institucional introducido ya está registrado.
                                    </div>
                                    '; // Alerta de coincidencia de correo
                                }else{
                                    // Validacion de correo personal
                                    $query_per = mysqli_query($conexion,"SELECT * FROM contacto WHERE correo_per = '$correo_per'"); // Verifica que el correo introducido este en la bd
                                    $result_per = mysqli_fetch_array($query_per); // Almacena cuantas coincidencias existen
                                    if($result_per > 0){ // Si hay alguna coincidencia, muestra la alerta
                                        $alert='
                                        <div class="alert alert-dismissible alert-warning">
                                            <strong>Oh vaya...</strong> el correo personal introducido ya está registrado.
                                        </div>
                                        '; // Alerta de coincidencia de correo
                                    }else{
                                        // Validacion de numero telefonico
                                        $query_tel = mysqli_query($conexion,"SELECT * FROM contacto WHERE telefono = '$telefono'"); // Verifica que el numero telefonico introducido este en la bd
                                        $result_tel = mysqli_fetch_array($query_tel); // Almacena cuantas coincidencias existen
                                        if($result_tel > 0){ // Si hay alguna coincidencia, muestra la alerta
                                            $alert='
                                            <div class="alert alert-dismissible alert-warning">
                                                <strong>Oh vaya...</strong> el numero telefónico introducido ya está registrado.
                                            </div>
                                            '; // Alerta de coincidencia de telefono
                                        }else{
                                            // Validacion de numero de pasaporte
                                            $query_pas = mysqli_query($conexion,"SELECT * FROM viaje WHERE num_pasaporte = '$num_pasaporte'"); // Verifica que el numero telefonico introducido este en la bd
                                            $result_pas = mysqli_fetch_array($query_pas); // Almacena cuantas coincidencias existen
                                            if($result_pas > 0){ // Si hay alguna coincidencia, muestra la alerta
                                                $alert='
                                                <div class="alert alert-dismissible alert-warning">
                                                    <strong>Oh vaya...</strong> el numero de pasaporte introducido ya está registrado.
                                                </div>
                                                '; // Alerta de coincidencia de telefono
                                            }else{
                                                // Guardar en la tabla docente
                                                $query_insert_docente = mysqli_query($conexion,"INSERT INTO docente(puesto,nombre,apellido1,apellido2,foto,institucion,tipo_contratacion,fecha_ingreso,num_empleado,cuenta,user_cve)
                                                                                                    VALUES ('$puesto','$nombre','$apellido1','$apellido2','$nombreFoto','$institucion','$tipo_contratacion','$fecha_ingreso','$num_empleado','$cuenta','$user')");
                                                if($query_insert_docente){ // Valida si se realizo la insercion en la tabla docentes
                                                    $queryDocente = mysqli_query($conexion, "SELECT * FROM docente ORDER BY cve_docente DESC LIMIT 1"); // Consulta el registro apenas creado
                                                    while ($data = mysqli_fetch_array($queryDocente)) // Alamcena los datos de ese registro
                                                    {
                                                        $idDoc = $data['cve_docente']; // Guardamos la clave del docente
                                                    }
                                                    // Guardar en la tabla informacion
                                                    $query_insert_informacion = mysqli_query($conexion,"INSERT INTO informacion(fecha_nac, doc_nac, genero, estado_civil, nacionalidad, curp, doc_curp, rfc, doc_rfc, nss, cve_docente)
                                                                                                                        VALUES ('$fecha_nac','$nombre_doc_nac','$genero','$estado_civil','$nacionalidad','$curp','$nombre_doc_curp','$rfc','$nombre_doc_rfc','$nss','$idDoc')");
                                                    if($query_insert_informacion){ // Valida si se realizo la insercion en la tabla informacion
                                                        // Guardar en la tabla contacto
                                                        $query_insert_contacto = mysqli_query($conexion,"INSERT INTO contacto(correo_ins, correo_per, telefono, cve_docente)
                                                                                                            VALUES ('$correo_ins','$correo_per','$telefono','$idDoc')");
                                                        if($query_insert_contacto){ // Valida si se realizo la insercion en la tabla contacto
                                                            // Guardar en la tabla domicilio
                                                            $query_insert_domicilio = mysqli_query($conexion,"INSERT INTO domicilio(calle, num_ext, num_int, codigo_postal, colonia, municipio, ciudad, estado, pais, doc_dom, cve_docente)
                                                                                                                VALUES ('$calle','$num_ext','$num_int','$codigo_postal','$colonia','$municipio','$ciudad','$estado','$pais','$nombre_doc_dom','$idDoc')");
                                                            if($query_insert_domicilio){ // Valida si se realizo la insercion en la tabla domicilio
                                                                // Guardar en la tabla viaje
                                                                $query_insert_viaje = mysqli_query($conexion,"INSERT INTO viaje(disp_viaje, num_pasaporte, fecha_ven_pas, cve_docente	)
                                                                                                                VALUES ('$disp_viaje','$num_pasaporte','$fecha_ven_pas','$idDoc')");
                                                                if($query_insert_viaje){ // Valida si se realizo la insercion en la tabla viaje
                                                                    $alert='
                                                                        <div class="alert alert-dismissible alert-success">
                                                                            <strong>Listo!</strong> El docente se guardó correctamente.
                                                                        </div>
                                                                    '; // Alerta de que se guardo correctamente
                                                                    if($_SESSION['tipo'] == 4){
                                                                        if (!copy('../files/usuario/'.$nombreFoto, '../files/docente/foto/'.$nombreFoto)) {
                                                                            echo "Error al copiar $nombreFoto...\n";
                                                                        }
                                                                    }else{
                                                                        $archivoFoto=$_FILES["foto"]["tmp_name"]; // Almacena la imagen subida
                                                                        if($archivoFoto!=""){ // Verifica que el campo de subida no este vacio
                                                                            move_uploaded_file($archivoFoto,"../files/docente/foto/".$nombreFoto); // Mueve la imagen subida a otra carpeta dentro del sistema
                                                                        }
                                                                    }
                                                                    $archivo_doc_nac=$_FILES["doc_nac"]["tmp_name"]; // Almacena el acta de nacimiento subida
                                                                    if($archivo_doc_nac!=""){ // Verifica que el campo de subida no este vacio
                                                                        move_uploaded_file($archivo_doc_nac,"../files/docente/naci/".$nombre_doc_nac); // Mueve el archivo subida a otra carpeta dentro del sistema
                                                                    }
                                                                    $archivo_doc_curp=$_FILES["doc_curp"]["tmp_name"]; // Almacena la imagen subida
                                                                    if($archivo_doc_curp!=""){ // Verifica que el campo de subida no este vacio
                                                                        move_uploaded_file($archivo_doc_curp,"../files/docente/curp/".$nombre_doc_curp); // Mueve el archivo subida a otra carpeta dentro del sistema
                                                                    }
                                                                    $archivo_doc_rfc=$_FILES["doc_rfc"]["tmp_name"]; // Almacena la imagen subida
                                                                    if($archivo_doc_rfc!=""){ // Verifica que el campo de subida no este vacio
                                                                        move_uploaded_file($archivo_doc_rfc,"../files/docente/rfc/".$nombre_doc_rfc); // Mueve el archivo subida a otra carpeta dentro del sistema
                                                                    }
                                                                    $archivo_doc_dom=$_FILES["doc_dom"]["tmp_name"]; // Almacena la imagen subida
                                                                    if($archivo_doc_dom!=""){ // Verifica que el campo de subida no este vacio
                                                                        move_uploaded_file($archivo_doc_dom,"../files/docente/domi/".$nombre_doc_dom); // Mueve el archivo subida a otra carpeta dentro del sistema
                                                                    }
                                                                }else{
                                                                    $query_delete_domicilio = mysqli_query($conexion,"DELETE FROM domicilio where cve_docente='$idDoc'"); // Elimina el registro creado
                                                                    $query_delete_contacto = mysqli_query($conexion,"DELETE FROM contacto where cve_docente='$idDoc'"); // Elimina el registro creado
                                                                    $query_delete_informacion = mysqli_query($conexion,"DELETE FROM informacion where cve_docente='$idDoc'"); // Elimina el registro creado
                                                                    $query_delete_docente = mysqli_query($conexion,"DELETE FROM docente where cve_docente='$idDoc'"); // Elimina el registro creado
                                                                    $alert='
                                                                        <div class="alert alert-dismissible alert-danger">
                                                                            <strong>Algo salio mal en el apartado Viaje...</strong> El usuario no se pudo guardar.
                                                                        </div>
                                                                    '; // Alerta de algun problema al guardar el registro
                                                                }
                                                            }else{
                                                                $query_delete_contacto = mysqli_query($conexion,"DELETE FROM contacto where cve_docente='$idDoc'"); // Elimina el registro creado
                                                                $query_delete_informacion = mysqli_query($conexion,"DELETE FROM informacion where cve_docente='$idDoc'"); // Elimina el registro creado
                                                                $query_delete_docente = mysqli_query($conexion,"DELETE FROM docente where cve_docente='$idDoc'"); // Elimina el registro creado
                                                                $alert='
                                                                    <div class="alert alert-dismissible alert-danger">
                                                                        <strong>Algo salio mal en el apartado Domicilio...</strong> El usuario no se pudo guardar.
                                                                    </div>
                                                                '; // Alerta de algun problema al guardar el registro
                                                            }
                                                        }else{
                                                            $query_delete_informacion = mysqli_query($conexion,"DELETE FROM informacion where cve_docente='$idDoc'"); // Elimina el registro creado
                                                            $query_delete_docente = mysqli_query($conexion,"DELETE FROM docente where cve_docente='$idDoc'"); // Elimina el registro creado
                                                            $alert='
                                                                <div class="alert alert-dismissible alert-danger">
                                                                    <strong>Algo salio mal en el apartado Contacto...</strong> El usuario no se pudo guardar.
                                                                </div>
                                                            '; // Alerta de algun problema al guardar el registro
                                                        }
                                                    }else{
                                                        $query_delete_docente = mysqli_query($conexion,"DELETE FROM docente where cve_docente='$idDoc'"); // Elimina el registro creado
                                                        $alert='
                                                            <div class="alert alert-dismissible alert-danger">
                                                                <strong>Algo salio mal en el apartado Información...</strong> El usuario no se pudo guardar.
                                                            </div>
                                                        '; // Alerta de algun problema al guardar el registro
                                                    }
                                                }else{
                                                    $alert='
                                                        <div class="alert alert-dismissible alert-danger">
                                                            <strong>Algo salio mal en el apartado Docente...</strong> El usuario no se pudo guardar.
                                                        </div>
                                                    '; // Alerta de algun problema al guardar el registro
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
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

<?php if($_SESSION['tipo'] == 4){ ?>
<title>SITA - Introducir información</title> <!-- Nombre de la pagina --> 
<?php }else{ ?>
<title>SITA - Registrar docente</title> <!-- Nombre de la pagina --> 
<?php } ?>

            <div class="jumbotron">
                <?php if($_SESSION['tipo'] == 4){ ?>
                <h1 class="display-3">Introducir información</h1>
                <?php }else{ ?>
                <h1 class="display-3">Registrar nuevo docente</h1>
                <?php } ?>
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
                                            <?php if($_SESSION['tipo'] == 4){ ?>
                                                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $s_nombre;?>" placeholder="Nombre(s)">
                                            <?php }else{ ?>
                                                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : '';?>" placeholder="Nombre(s)">
                                            <?php } ?>
                                            <label class="form-label mt-2">Primer apellido</label>
                                            <?php if($_SESSION['tipo'] == 4){ ?>
                                                <input type="text" class="form-control" name="apellido1" id="apellido1" value="<?php echo $s_apellido1;?>" placeholder="Nombre(s)">
                                            <?php }else{ ?>
                                                <input type="text" class="form-control" name="apellido1" id="apellido1" value="<?php echo isset($_POST['apellido1']) ? $_POST['apellido1'] : '';?>" placeholder="Primer apellido">
                                            <?php } ?>
                                            <label class="form-label mt-2">Segundo apellido</label>
                                            <?php if($_SESSION['tipo'] == 4){ ?>
                                                <input type="text" class="form-control" name="apellido2" id="apellido2" value="<?php echo $s_apellido2;?>" placeholder="Nombre(s)">
                                            <?php }else{ ?>
                                                <input type="text" class="form-control" name="apellido2" id="apellido2" value="<?php echo isset($_POST['apellido2']) ? $_POST['apellido2'] : '';?>" placeholder="Segundo apellido">
                                            <?php } ?>
                                            <label class="form-label mt-2">Institución</label>
                                            <input type="text" class="form-control" name="institucion" id="institucion" value="<?php echo isset($_POST['institucion']) ? $_POST['institucion'] : '';?>" placeholder="Nombre de la institución">
                                        </div>
                                        <div class = "form-group col-md-4 mx-auto">
                                            <label class="form-label mt-2">Fotografía</label>
                                            <?php if($_SESSION['tipo'] == 4){ ?>
                                                <br>
                                                <div class="d-flex justify-content-center">
                                                    <output><img src="/sistema/files/usuario/<?php echo $s_foto; ?>" style="width: 245px; height:245px;"></output>
                                                </div>
                                            <?php }else{ ?>
                                                <input type="file" class="form-control" name="foto" id="foto">
                                                <div class="m-0 vh-50 row justify-content-center align-items-center">
                                                    <div class="col-auto">
                                                        <br>
                                                        <output id="previsual"></output> <!-- Espacio para previsualizar la foto subida -->
                                                        <script> <?php include("../js/scripts.js"); ?> </script> <!-- llama al script necesario para poder previsualizar -->
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Tipo de contratación</label>
                                            <select class="form-select" name="tipo_contratacion" id="tipo_contratacion">
                                                <option value="" hidden>Selecciona una opción</option>
                                                <option value="Tiempo completo">Tiempo completo</option>
                                                <option value="Medio tiempo">Medio tiempo</option>
                                            </select>
                                        </div>
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Fecha de ingreso</label>
                                            <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : '';?>">
                                        </div>
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Numero de empleado</label>
                                            <input type="number" class="form-control" name="num_empleado" id="num_empleado" value="<?php echo isset($_POST['num_empleado']) ? $_POST['num_empleado'] : '';?>" placeholder="10 digitos">
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
                                                <input type="date" class="form-control" name="fecha_nac" id="fecha_nac" value="<?php echo isset($_POST['fecha_nac']) ? $_POST['fecha_nac'] : '';?>">
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Genero</label>
                                                <select class="form-select" name="genero" id="genero">
                                                    <option value="" hidden>Selecciona una opción</option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Acta de nacimiento</label>
                                                <input type="file" class="form-control" name="doc_nac" id="doc_nac">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Nacionalidad</label><br>
                                                <select class="form-select" name="nacionalidad" id="nacionalidad">
                                                    <option value="" hidden>Selecciona una opción</option>
                                                    <option value="Mexicana">Mexicana</option>
                                                    <option value="Extranjera">Extranjera</option>
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Estado civil</label>
                                                <select class="form-select" name="estado_civil" id="estado_civil">
                                                    <option value="" hidden>Selecciona una opción</option>
                                                    <option value="Soltero">Soltero</option>
                                                    <option value="Casado">Casado</option>
                                                    <option value="Divorciado">Divorciado</option>
                                                    <option value="Union libre">Union libre</option>
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero de seguridad social</label>
                                                <input type="number" class="form-control" name="nss" id="nss" value="<?php echo isset($_POST['nss']) ? $_POST['nss'] : '';?>" placeholder="10 caracteres">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">CURP</label>
                                                <input type="text" class="form-control" name="curp" id="curp" value="<?php echo isset($_POST['curp']) ? $_POST['curp'] : '';?>" placeholder="18 caracteres">
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Documento CURP</label>
                                                <input type="file" class="form-control" name="doc_curp" id="doc_curp">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">RFC</label>
                                                <input type="text" class="form-control" name="rfc" id="rfc" value="<?php echo isset($_POST['rfc']) ? $_POST['rfc'] : '';?>" placeholder="13 caracteres">
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Documento RFC</label>
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
                                                <input type="email" class="form-control" name="correo_ins" id="correo_ins" value="<?php echo isset($_POST['correo_ins']) ? $_POST['correo_ins'] : '';?>" placeholder="correo@ejemplo.com">
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Correo personal</label>
                                                <?php if($_SESSION['tipo'] == 4){ ?>
                                                    <input type="text" class="form-control" name="correo_per" id="correo_per" value="<?php echo $s_correo;?>" placeholder="Nombre(s)">
                                                <?php }else{ ?>
                                                    <input type="email" class="form-control" name="correo_per" id="correo_per" value="<?php echo isset($_POST['correo_per']) ? $_POST['correo_per'] : '';?>" placeholder="correo@ejemplo.com">
                                                <?php } ?>
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero telefónico</label>
                                                <input type="number" class="form-control" name="telefono" id="telefono" value="<?php echo isset($_POST['telefono']) ? $_POST['telefono'] : '';?>" placeholder="10 digitos">
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
                                                <input type="text" class="form-control" name="calle" id="calle" value="<?php echo isset($_POST['calle']) ? $_POST['calle'] : '';?>" placeholder="Nombre de la calle">
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Numero exterior</label>
                                                <input type="text" class="form-control" name="num_ext" id="num_ext" value="<?php echo isset($_POST['num_ext']) ? $_POST['num_ext'] : '';?>" placeholder="Numero exterior">
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Numero interior</label>
                                                <input type="text" class="form-control" name="num_int" id="num_int" value="<?php echo isset($_POST['num_int']) ? $_POST['num_int'] : '';?>" placeholder="Numero interior">
                                            </div>
                                            <div class = "form-group col-md-3">
                                                <label class="form-label mt-2">Colonia</label>
                                                <input type="text" class="form-control" name="colonia" id="colonia" value="<?php echo isset($_POST['colonia']) ? $_POST['colonia'] : '';?>" placeholder="Nombre de la colonia">
                                            </div>
                                            <div class = "form-group col-md-2">
                                                <label class="form-label mt-2">Codigo Postal</label>
                                                <input type="number" class="form-control" name="codigo_postal" value="<?php echo isset($_POST['codigo_postal']) ? $_POST['codigo_postal'] : '';?>" id="codigo_postal" placeholder="xxxxx">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Municipio</label>
                                                <input type="text" class="form-control" name="municipio" id="municipio" value="<?php echo isset($_POST['municipio']) ? $_POST['municipio'] : '';?>" placeholder="Nombre del municipio">
                                            </div>
                                            <div class = "form-group col-md-6">
                                                <label class="form-label mt-2">Ciudad</label>
                                                <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?php echo isset($_POST['ciudad']) ? $_POST['ciudad'] : '';?>" placeholder="Nombre de la ciudad">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Estado</label>
                                                <input type="text" class="form-control" name="estado" id="estado" value="<?php echo isset($_POST['estado']) ? $_POST['estado'] : '';?>" placeholder="Nombre del estado">
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">País</label>
                                                <input type="text" class="form-control" name="pais" id="pais" value="<?php echo isset($_POST['pais']) ? $_POST['pais'] : '';?>" placeholder="Nombre del país">
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Comprobante de domicilio</label>
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
                                                    <option value="" hidden>Selecciona una opción</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Numero de pasaporte</label>
                                                <input type="number" class="form-control" name="num_pasaporte" id="num_pasaporte" value="<?php echo isset($_POST['num_pasaporte']) ? $_POST['num_pasaporte'] : '';?>" placeholder="xxxxxxxxxx">
                                            </div>
                                            <div class = "form-group col-md-4">
                                                <label class="form-label mt-2">Fecha de vencimiento del pasaporte</label>
                                                <input type="date" class="form-control" name="fecha_ven_pas" id="fecha_ven_pas" value="<?php echo isset($_POST['fecha_ven_pas']) ? $_POST['fecha_ven_pas'] : '';?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: center;">Volver</button>
                                        <button type="submit" name="decision" value="guardar" class="btn btn-primary" style="float: center;">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de pagina -->

<!--
--- Pagina[nuevoDocente] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:44 hrs)]
-->