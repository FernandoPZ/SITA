<?php include("../template/cabecera.php"); ?> <!-- Cabecera de la pagina -->

<?php
if($_SESSION['tipo'] == 4) //Validacion de tipo de usuario
{
    header("location: /SITA/sistema/index.php"); //Regresa a la pagina principal
}

include "../config/conexion.php"; //Conexion a la base de datos

//Validacion de las variables
//Seccion Docente
$tipou=(isset($_POST['tipou']))?$_POST['tipou']:""; //tipo de usuario
$nombre=(isset($_POST['nombre']))?$_POST['nombre']:""; //Nombre
$apellido1=(isset($_POST['apellido1']))?$_POST['apellido1']:""; //Primer apellido
$apellido2=(isset($_POST['apellido2']))?$_POST['apellido2']:""; //Segundo apellido
$foto=(isset($_FILES['foto']['name']))?$_FILES['foto']['name']:""; //Foto
$numEmpleado=(isset($_POST['numEmpleado']))?$_POST['numEmpleado']:""; //Numero de empleado
$instiActual=(isset($_POST['instiActual']))?$_POST['instiActual']:""; //Instituto
$puesto=(isset($_POST['puesto']))?$_POST['puesto']:""; //Puesto
//Seccion Generales
$email=(isset($_POST['email']))?$_POST['email']:""; //Correo electronico
$fecha_nac=(isset($_POST['fecha_nac']))?$_POST['fecha_nac']:""; //Fecha de nacimiento
$estado_civil=(isset($_POST['estado_civil']))?$_POST['estado_civil']:""; //Estado civil
$genero=(isset($_POST['genero']))?$_POST['genero']:""; //Genero
$curp=(isset($_POST['curp']))?$_POST['curp']:""; //Curp
$curp_doc=(isset($_FILES['curp_doc']['name']))?$_FILES['curp_doc']['name']:""; //Documento del curp
$rfc=(isset($_POST['rfc']))?$_POST['rfc']:""; //rfc
$rfc_doc=(isset($_FILES['rfc_doc']['name']))?$_FILES['rfc_doc']['name']:""; //Documento del rfc
$iste=(isset($_POST['iste']))?$_POST['iste']:""; //Numero de seguridad social
$num_infonavit=(isset($_POST['num_infonavit']))?$_POST['num_infonavit']:""; //Numero de infonavit
$disponibilidad=(isset($_POST['disponibilidad']))?$_POST['disponibilidad']:""; //Disponibilidad
$fecha_vig_pas=(isset($_POST['fecha_vig_pas']))?$_POST['fecha_vig_pas']:""; //Fecha de vigencia del pasaporte
//Personales
$tipoc=(isset($_POST['tipoc']))?$_POST['tipoc']:""; //Tipo de calle
$calle=(isset($_POST['calle']))?$_POST['calle']:""; //Nombre de calle
$num_ext=(isset($_POST['num_ext']))?$_POST['num_ext']:""; //Numero exterior
$num_int=(isset($_POST['num_int']))?$_POST['num_int']:""; //Numero interior
$edificio=(isset($_POST['edificio']))?$_POST['edificio']:""; //Nombre o numero de edificio
$colonia=(isset($_POST['colonia']))?$_POST['colonia']:""; //Nombre de colonia
$codigo_postal=(isset($_POST['codigo_postal']))?$_POST['codigo_postal']:""; //Codigo postal
$tipo_linea=(isset($_POST['tipo_linea']))?$_POST['tipo_linea']:""; //Tipo de linea telefonica
$telefono=(isset($_POST['telefono']))?$_POST['telefono']:""; //Numero de telefono
//Experiencias
$act_puesto=(isset($_POST['act_puesto']))?$_POST['act_puesto']:""; //Puesto actual
$institucion=(isset($_POST['institucion']))?$_POST['institucion']:""; //Intitucion
$periodo=(isset($_POST['periodo']))?$_POST['periodo']:""; //Periodo
$intereses=(isset($_POST['intereses']))?$_POST['intereses']:""; //Intereses
//Formacion
$asignaturas=(isset($_POST['asignaturas']))?$_POST['asignaturas']:""; //Lista de asignaturas
$periodo_estudio=(isset($_POST['periodo_estudio']))?$_POST['periodo_estudio']:""; //Periodo de estudio
$hras_teoricas=(isset($_POST['hras_teoricas']))?$_POST['hras_teoricas']:""; //Horas teoricas impartidas
$hras_practicas=(isset($_POST['hras_practicas']))?$_POST['hras_practicas']:""; //rfc
$periodo_impartido=(isset($_POST['periodo_impartido']))?$_POST['periodo_impartido']:""; //Periodo impartido
//Logros
$nombre_logro=(isset($_POST['nombre_logro']))?$_POST['nombre_logro']:""; //Nombre del logro
$fecha_logro=(isset($_POST['fecha_logro']))?$_POST['fecha_logro']:""; //Fecha del logro
$rfc=(isset($_POST['rfc']))?$_POST['rfc']:""; //rfc
$rfc=(isset($_POST['rfc']))?$_POST['rfc']:""; //rfc
$rfc=(isset($_POST['rfc']))?$_POST['rfc']:""; //rfc
$rfc=(isset($_POST['rfc']))?$_POST['rfc']:""; //rfc
$rfc=(isset($_POST['rfc']))?$_POST['rfc']:""; //rfc


$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision

?>

<?php
switch($decision){

    case "guardar":

        // Asignacion de nombre unico a la foto
        $fecha= new DateTime();
        //$nombreFoto=($foto!="")?$fecha->getTimestamp()."_".$_FILES["foto"]["name"]:"default.png";
        $nombreFoto=($foto!="")?$numEmpleado."_".$fecha->getTimestamp()."_".$foto:"default.png";

        $archivoFoto=$_FILES["foto"]["tmp_name"];

        if($archivoFoto!=""){
            move_uploaded_file($archivoFoto,"../files/upload/fotos/".$nombreFoto);
        }
        
        echo "-Tipo de usuario:( $tipou )-";
        echo "-Nombre:( $nombre )-";
        echo "-Foto:( $nombreFoto )-";
        echo "-Foto:( $foto )-";

        break;

        if(!empty($_POST))
        {
            $alert='';
            if(empty($_POST['usuario']) || empty($_POST['tipou']) || empty($_POST['contra01']) || empty($_POST['contra02']))
            {
                $alert='
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                ';
            }else{
                $usuario = $_POST['usuario'];
                $tipou = $_POST['tipou'];
                $contra1 = $_POST['contra01'];
                $contra2 = $_POST['contra02'];

                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$usuario'");
                $result = mysqli_fetch_array($query);
                
                //
                $sentenciaSQL= $conexion->prepare("INSERT INTO elementos(nombre,imagen) VALUES (:nombre,:imagen);");
                $sentenciaSQL->bindParam(':nombre',$txtNombre);
                
                $fecha= new DateTime();
                $nombreFoto=($foto!="")?$fecha->getTimestamp()."_".$_FILES["foto"]["name"]:"imagen.jpg";
        
                $archivoFoto=$_FILES["foto"]["tmp_name"];
        
                if($archivoFoto!=""){
                    move_uploaded_file($archivoFoto,"../../img/".$nombreFoto);
                }
        
                $sentenciaSQL->bindParam(':imagen',$nombreFoto);
                $sentenciaSQL->execute();
                //

                if($result > 0){
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el nombre de usuario introducido ya esta ocupado, escoge otro.
                    </div>
                    ';
                }else{
                    if($contra1 != $contra2){
                        $alert='
                        <div class="alert alert-dismissible alert-danger">
                            <strong>Oh vaya...</strong> las contraseñas no coinciden.
                        </div>
                        ';
                    }else{
                        $query_insert = mysqli_query($conexion,"INSERT INTO usuario(tipo,usuario,pass,activo) VALUES ('$tipou','$usuario',md5('$contra1'),1)");
                        if($query_insert){
                            $alert='
                                <div class="alert alert-dismissible alert-success">
                                    <strong>Listo!</strong> El usuario se guardo correctamente.
                                </div>
                            ';
                        }else{
                            $alert='
                                <div class="alert alert-dismissible alert-danger">
                                    <strong>Algo salio mal...</strong> El usuario no se pudo guardar.
                                </div>
                            ';
                        }
                    }
                }
            }
            mysqli_close($conexion);
        }
    break;

    case "cancelar":
        header('Location:/SITA/sistema/secciones/verDocente.php');
        mysqli_close($conexion);
    break;
}
?>

<title>SITA - Registrar docente</title>

			<div class="jumbotron">
				<h1 class="display-3">Registrar nuevo docente</h1>
                <hr class="my-2">
                <br>
                <form action="" method="POST" enctype="multipart/form-data">

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#docente">Docente</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#generales">Generales</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#personales">Personales</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#experiencias">Experiencias</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#formacion">Formacion</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#logros">Logros</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#premios">Premios</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#publicaciones">Publicaciones</a> <!-- boton del tab -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#documentos">Documentos</a> <!-- boton del tab -->
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content"> <!-- Tablas de contenido -->
                        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div> <!-- Espacio para las alertas -->
                        <div class="tab-pane fade active show" id="docente"> <!-- Tabla de datos primcipales -->
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Tipo</label>
                                        <?php
                                            include "../config/conexion.php";
                                            $query_tipou = mysqli_query($conexion,"SELECT * FROM tipo_usuario");
                                            mysqli_close($conexion);
                                            $result_tipou = mysqli_num_rows($query_tipou);
                                        ?>
                                        <select class="form-select" name="tipou" id="tipou">
                                            <?php
                                                if($result_tipou > 0)
                                                {
                                                    while ($tipou = mysqli_fetch_array($query_tipou)){
                                                        ?>
                                                        <option value="" hidden>Selecciona una opción</option>
                                                        <option value="<?php echo $tipou["cve_tipou"]; ?>"><?php echo $tipou["tipo"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <label class="form-label mt-2">Nombre o nombres</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre(s)">
                                        <label class="form-label mt-2">Primer apellido</label>
                                        <input type="text" class="form-control" name="apellido1" id="apellido1" placeholder="Primer apellido">
                                        <label class="form-label mt-2">Segundo apellido</label>
                                        <input type="text" class="form-control" name="apellido2" id="apellido2" placeholder="Segundo apellido">
                                        <label class="form-label mt-2">Fotografia</label>
                                        <input type="file" class="form-control" name="foto" id="foto">
                                        <output id="previsual"></output>
                                        <script>
                                            function archivo(evt) {
                                                var foto = evt.target.files; // Espacio donde se sube la imagen
                                                for (var i = 0, f; f = foto[i]; i++) { // Obtenemos la imagen del campo "foto"
                                                if (!f.type.match('image.*')) { //Solo admitimos imágenes.
                                                    continue;
                                                }
                                                var reader = new FileReader();
                                                reader.onload = (function(theFile) {
                                                    return function(e) {
                                                    document.getElementById("previsual").innerHTML = ['<img class="img-rounded" height=100px src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join(''); // Insertamos la imagen
                                                    };
                                                })(f);
                                                reader.readAsDataURL(f);
                                                }
                                            }
                                            document.getElementById('foto').addEventListener('change', archivo, false);
                                        </script>
                                        <label class="form-label mt-2">Numero de empleado</label>
                                        <input type="text" class="form-control" name="numEmpleado" id="numEmpleado" placeholder="xxxxxxxxx">
                                        <label class="form-label mt-2">Institucion actual</label>
                                        <input type="text" class="form-control" name="instiActual" placeholder="Nombre de la institucion">
                                        <label class="form-label mt-2">Puesto</label>
                                        <input type="text" class="form-control" name="puesto" placeholder="Nombre del puesto">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="generales">
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Correo electronico</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@correo.com">
                                        <label class="form-label mt-2">fecha de nacimiento</label>
                                        <input type="date" class="form-control" name="fecha_nac" id="fecha_nac">
                                        <label class="form-label mt-2">Estado civil</label>
                                        <select class="form-select" name="estado_civil" id="estado_civil">
                                            <option value="" hidden>Selecciona una opción</option>
                                            <option value="soltero">Soltero</option>
                                            <option value="casado">Casado</option>
                                            <option value="divorciado">Divorciado</option>
                                            <option value="union_libre">Union libre</option>
                                        </select>
                                        <label class="form-label mt-2">Genero</label>
                                        <select class="form-select" name="genero" id="genero">
                                            <option value="" hidden>Selecciona una opción</option>
                                            <option value="femenino">Femenino</option>
                                            <option value="masculino">Masculino</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                        <label class="form-label mt-2">CURP</label>
                                        <input type="text" class="form-control" name="curp" id="curp" placeholder="18 caracteres">
                                        <label class="form-label mt-2">Documento del Curp</label>
                                        <input type="file" class="form-control" name="curp_doc" id="curp_doc">
                                        <label class="form-label mt-2">RFC</label>
                                        <input type="text" class="form-control" name="rfc" id="rfc" placeholder="10 caracteres">
                                        <label class="form-label mt-2">Documento del RFC</label>
                                        <input type="file" class="form-control" name="rfc_doc" id="rfc_doc">
                                        <label class="form-label mt-2">Numero de seguro social</label>
                                        <input type="text" class="form-control" name="iste" id="iste" placeholder="10 caracteres">
                                        <label class="form-label mt-2">Numero de infonavit</label>
                                        <input type="text" class="form-control" name="num_infonavit" id="num_infonavit" placeholder="10 caracteres">
                                        <label class="form-label mt-2">disponibilidad</label>
                                        <input type="text" class="form-control" name="disponibilidad" id="disponibilidad" placeholder="pendiente">
                                        <label class="form-label mt-2">fecha de vigencial del pasaporte</label>
                                        <input type="date" class="form-control" name="fecha_vig_pas" id="fecha_vig_pas">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="personales">
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Tipo de calle</label>
                                        <?php
                                            include "../config/conexion.php";
                                            $query_tipoc = mysqli_query($conexion,"SELECT * FROM tipo_calle");
                                            mysqli_close($conexion);
                                            $result_tipoc = mysqli_num_rows($query_tipoc);
                                        ?>
                                        <select class="form-select" name="tipoc" id="tipoc">
                                            <?php
                                                if($result_tipoc > 0)
                                                {
                                                    while ($tipoc = mysqli_fetch_array($query_tipoc)){
                                                        ?>
                                                        <option value="" hidden>Selecciona una opción</option>
                                                        <option value="<?php echo $tipou["cve_tipoc"]; ?>"><?php echo $tipoc["nombre"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <label class="form-label mt-2">Calle</label>
                                        <input type="text" class="form-control" name="calle" id="calle" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Numero exterior</label>
                                        <input type="text" class="form-control" name="num_ext" id="num_ext" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Numero interior</label>
                                        <input type="text" class="form-control" name="num_int" id="num_int" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Edificio</label>
                                        <input type="text" class="form-control" name="edificio" id="edificio" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Colonia</label>
                                        <input type="text" class="form-control" name="colonia" id="colonia" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Codigo postal</label>
                                        <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Tipo de linea telefonica</label>
                                        <input type="text" class="form-control" name="tipo_linea" id="tipo_linea" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Telefono</label>
                                        <input type="text" class="form-control" name="telefono" id="telefono" placeholder="10 digitos">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="experiencias">
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Puesto actual</label>
                                        <input type="text" class="form-control" name="act_puesto" id="act_puesto" placeholder="El puesto actual que ejerce">
                                        <label class="form-label mt-2">Nombre del instituto</label>
                                        <input type="text" class="form-control" name="institucion" id="institucion" placeholder="El nombre de la institucion">
                                        <label class="form-label mt-2">Periodo</label>
                                        <input type="text" class="form-control" name="periodo" id="periodo" placeholder="El periodo que curza">
                                        <label class="form-label mt-2">Intereses</label>
                                        <input type="text" class="form-control" name="intereses" id="intereses" placeholder="Mencione que intereses tiene">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="formacion">
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Asignaturas</label>
                                        <input type="text" class="form-control" name="asignaturas" id="asignaturas" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Periodo de estudio</label>
                                        <input type="text" class="form-control" name="periodo_estudio" id="periodo_estudio" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Horas teoricas</label>
                                        <input type="text" class="form-control" name="hras_teoricas" id="hras_teoricas" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Horas practicas</label>
                                        <input type="text" class="form-control" name="hras_practicas" id="hras_practicas" placeholder="ejemplo de campo">
                                        <label class="form-label mt-2">Periodo impartido</label>
                                        <input type="text" class="form-control" name="periodo_impartido" id="periodo_impartido" placeholder="ejemplo de campo">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="logros">
                            <p>Contenido pendiente.</p>
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Campo</label>
                                        <input type="text" class="form-control" name="ejemplo" placeholder="ejemplo de campo">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="premios">
                            <p>Contenido pendiente.</p>
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Campo</label>
                                        <input type="text" class="form-control" name="ejemplo" placeholder="ejemplo de campo">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="publicaciones">
                            <p>Contenido pendiente.</p>
                            <div class="card">
                                <div class="card-header text-center">
                                    No deje campos vacios
                                </div>
                                <div class="card-body">
                                    <div class = "form-group">
                                        <label class="form-label mt-2">Campo</label>
                                        <input type="text" class="form-control" name="ejemplo" placeholder="ejemplo de campo">
                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="documentos">
                            <div class="tab-pane fade active show" id="docente">
                                <div class="card">
                                    <div class="card-header text-center">
                                        No deje campos vacios
                                    </div>
                                    <div class="card-body">
                                        <div class = "form-group">
                                            <label class="form-label mt-2">Campo</label>
                                            <input type="text" class="form-control" name="ejemplo" placeholder="ejemplo de campo" required>
                                        </div>
                                        <div class="text-center">
                                            <br>
                                            <button type="submit" name="decision" value="guardar" class="btn btn-primary" style="float: right;">Guardar</button>
                                            <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: left;">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?>