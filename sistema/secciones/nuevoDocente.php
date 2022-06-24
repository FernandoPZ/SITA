<?php include("../template/cabecera.php"); ?> <!-- Cabecera de la pagina -->

<?php
if($_SESSION['tipo'] == 3) // Validacion de tipo de usuario
{
    header("location: /SITA/sistema/index.php"); //Regresa a la pagina principal
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
include "../config/conexion.php"; // Realiza la coneccion de la bd
?>

<?php
switch($decision){
    case "guardar": // Guargar
        if(!empty($_POST)) // Valida si los campos no esten vacios
        {
            $alert='';
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
            || empty($_POST['calle']) // Nombre del docente
            || empty($_POST['num_ext']) // Primer apellido del docente
            || empty($_POST['num_int']) // Segundo apellido del docente
            || empty($_POST['codigo_postal']) // Nombre de la institucion
            || empty($_POST['colonia']) // Tipo de contratacion
            || empty($_POST['municipio']) // Fecha de ingreso a la institucion
            || empty($_POST['ciudad']) // Numero de empleado asignado
            || empty($_POST['estado']) // Numero de empleado asignado
            || empty($_POST['pais']) // Numero de empleado asignado
            || empty($_FILES['doc_dom']) // Foto del docente
            // Tabla viaje
            || empty($_POST['disp_viaje']) // Correo institucional
            || empty($_POST['num_pasaporte']) // Correo personal
            || empty($_POST['fecha_ven_pas'])) // Numero de telefono
            {
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                //Tabla docente
                $puesto = $_POST['puesto']; // Guarda el tipo de usuario
                $nombre = $_POST['nombre']; // Guarda el nombre del usuario
                $apellido1 = $_POST['apellido1']; // Guarda el primer apellido del usuario
                $apellido2 = $_POST['apellido2']; // Guarda el segundo apellido del usuario
                $foto = $_FILES['foto']['name']; // Guarda la foto del usuario
                $institucion = $_POST['institucion']; // Guarda el nombre de la institucion
                $tipo_contratacion = $_POST['tipo_contratacion']; // Guarda el tipo de contratacion
                $fecha_ingreso = $_POST['fecha_ingreso']; // Guarda la fecha de ingreso
                $num_empleado = $_POST['num_empleado']; // Guarda el numero de empleado
                // Tabla domicilio
                // Asignacion de nombre unico a la foto
                $fecha= new DateTime(); // Determina la fecha actual
                $nombreFoto=($foto!="")?$num_empleado."_".$fecha->getTimestamp()."_".$foto:"default.png"; // Nuevo nombre
                $query = mysqli_query($conexion,"SELECT * FROM docente WHERE num_empleado = '$num_empleado'"); // Verifica que el usuario introducido este en la bd
                $result = mysqli_fetch_array($query); // Almacena cuantas coincidencias existen
                if($result > 0){ // Si hay alguna coincidencia con el numero de empleado, muestra la alerta
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el numero de empleado introducido ya esta registrado.
                    </div>
                    '; // Alerta de coincidencia de usuario
                }else{
                    //$query_insert = mysqli_query($conexion,"INSERT INTO docente(puesto,nombre,apellido1,apellido2,foto,institucion,tipo_contratacion,fecha_ingreso,num_empleado)
                    //                                                    VALUES ('$puesto','$nombre','$apellido1','$apellido2','$nombreFoto','$institucion','$tipo_contratacion','$fecha_ingreso','$num_empleado')");
                    if($query_insert){
                        $alert='
                            <div class="alert alert-dismissible alert-success">
                                <strong>Listo!</strong> El usuario se guardo correctamente.
                            </div>
                        '; // Alerta de que se guardo correctamente
                        //$archivoFoto=$_FILES["foto"]["tmp_name"]; // Almacena la imagen subida
                        //if($archivoFoto!=""){ // Verifica que el campo de subida no este vacio
                        //    move_uploaded_file($archivoFoto,"../files/upload/fotos/".$nombreFoto); // Mueve la imagen subida a otra carpeta dentro del sistema
                        //}
                    }else{
                        $alert='
                            <div class="alert alert-dismissible alert-danger">
                                <strong>Algo salio mal...</strong> El usuario no se pudo guardar.
                            </div>
                        '; // Alerta de algun problema al guardar el registro
                    }
                }
            }
        }
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
    case "cancelar": // Cancelar
        header('Location:/SITA/sistema/secciones/verDocente.php'); // Redirecciona a la lista de los docentes
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
}
?>

<title>SITA - Registrar docente</title> <!-- Nombre de la pagina --> 

            <div class="jumbotron">
                <h1 class="display-3">Registrar nuevo docente</h1>
                <hr class="my-2">
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
                            <a class="nav-link" data-bs-toggle="tab" href="#documentos">Documentos</a> <!-- boton del tab -->
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content"> <!-- Tablas de contenido -->
                        <a><?php echo isset($alert) ? $alert : ''; ?></a> <!-- Espacio para las alertas -->
                        <div class="tab-pane fade active show" id="docente"> <!-- Tabla de datos principales -->
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Nombre o nombres</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre(s)">
                                        <label class="form-label mt-2">Primer apellido</label>
                                        <input type="text" class="form-control" name="apellido1" id="apellido1" placeholder="Primer apellido">
                                        <label class="form-label mt-2">Segundo apellido</label>
                                        <input type="text" class="form-control" name="apellido2" id="apellido2" placeholder="Segundo apellido">
                                        <label class="form-label mt-2">Fotografia</label>
                                        <input type="file" class="form-control" name="foto" id="foto">
                                        <output id="previsual"></output>
                                        <script> <?php include("../js/scripts.js"); ?> </script> <!-- llama al script necesario para poder previsualizar -->
                                        <label class="form-label mt-2">Institucion</label>
                                        <input type="text" class="form-control" name="institucion" id="institucion" placeholder="Nombre de la institucion">
                                        <label class="form-label mt-2">Tipo de contratacion</label>
                                        <input type="text" class="form-control" name="tipo_contratacion" id="tipo_contratacion" placeholder="Nombre de la institucion">
                                        <label class="form-label mt-2">Fecha de ingreso</label>
                                        <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso">
                                        <label class="form-label mt-2">Numero de empleado</label>
                                        <input type="text" class="form-control" name="num_empleado" id="num_empleado" placeholder="Numero de 10 digitos">
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
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="informacion"> <!-- Tabla de Informacion -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Formulario pendiente
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Nombre del campo</label>
                                        <input type="email" class="form-control" name="ejemplo" id="ejemplo" placeholder="ejemplo de texto">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contacto"> <!-- Tabla de Contacto -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Formulario pendiente
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Nombre del campo</label>
                                        <input type="email" class="form-control" name="ejemplo" id="ejemplo" placeholder="ejemplo de texto">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="domicilio"> <!-- Tabla de Domicilio -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Formulario pendiente
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Nombre del campo</label>
                                        <input type="email" class="form-control" name="ejemplo" id="ejemplo" placeholder="ejemplo de texto">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="viaje"> <!-- Tabla de Viaje -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Formulario pendiente
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Nombre del campo</label>
                                        <input type="email" class="form-control" name="ejemplo" id="ejemplo" placeholder="ejemplo de texto">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="documentos"> <!-- Apartado donde se muestran los documentos subidos -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Formulario pendiente
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Nombre del campo</label>
                                        <input type="email" class="form-control" name="ejemplo" id="ejemplo" placeholder="ejemplo de texto">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                        <button type="submit" name="decision" value="guardar" class="btn btn-primary" style="float: center;">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de pagina -->