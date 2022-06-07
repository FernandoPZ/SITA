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
$rfc=(isset($_POST['rfc']))?$_POST['rfc']:""; //rfc
$fecha_vig_pas=(isset($_POST['fecha_vig_pas']))?$_POST['fecha_vig_pas']:""; //Fecha de vigencia del pasaporte
//Personales


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
                            <p>Contenido pendiente.</p>
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

                                    </div>
                                    <div class="text-center">
                                        <br>
                                        <button type="submit" name="decision" value="cancelar" class="btn btn-danger" style="float: center;">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="personales">
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
                        <div class="tab-pane fade" id="experiencias">
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
                        <div class="tab-pane fade" id="formacion">
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