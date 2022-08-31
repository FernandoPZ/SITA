<?php include("../template/cabecera.php"); ?> <!-- Llama a la cabecera -->

<?php
include "../config/conexion.php"; // Realiza la coneccion de la bd
if((empty($_GET['id_d'])) || (empty($_GET['id_pr']))) // Valida si la clave del usuario no esta vacia
{
    header('location: verUsuario.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id_d']; // Almacena la clave del docente
$idPre = $_GET['id_pr']; // Almacena la clave del docente
$sql_premio = mysqli_query($conexion,"SELECT * FROM premios WHERE cve_premio = $idPre");
$result = mysqli_num_rows($sql_premio); // Almacena la cantidad todal de registros
if($result == 0){ // Verifica que la cantidad no este vacia
    header('Location: verUsuario.php'); // Redirecciona a la lista de usuarios
}else{
    while ($data = mysqli_fetch_array($sql_premio)){
        $cve_premio = $data['cve_premio']; // Guarda la clave del usuario
        $nombre = $data['nombre']; // Guarda la clave del tipo de usuario
        $fecha = $data['fecha']; // Guarda el nombre del tipo de usuario
        $institucion = $data['institucion']; // Guarda el nombre del usuario
        $motivo = $data['motivo']; // Guarda el primer apellido del usuario
        $descripcion = $data['descripcion']; // Guarda el segundo apellido del usuario
        $cve_docente = $data['cve_docente']; // Guarda el nombre de la fotografia del usuario
        $fecha_add = $data['fecha_add']; // Guarda el ID del usuario
        $user_cve = $data['user_cve']; // Guarda el correo del usuario
        $activo = $data['activo']; // Guarda el correo del usuario
    }
}
if($_GET['id_d'] != $idDoc){
    header("location: /sistema/index.php"); // Redirecciona a la pagina pricipal
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
?>

<?php
switch($decision){
    case "actualizar": // Actualizar
        if(!empty($_POST)) // Valida si los campos no esten vacios
        {
            $alert='';
            if(empty($_POST['nombre']) // Nivel de estudio
            || empty($_POST['fecha']) // Siglas del estudio
            || empty($_POST['institucion']) // Nombre de la institucion
            || empty($_POST['motivo']) // motivo correspondiente
            || empty($_POST['descripcion'])) // Disiplina del curso
            {
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                $nombre = $_POST['nombre']; // Guarda el tipo de usuario
                $fecha = $_POST['fecha']; // Guarda el nombre del usuario
                $institucion = $_POST['institucion']; // Guarda el primer apellido del usuario
                $motivo = $_POST['motivo']; // Guarda el segundo apellido del usuario
                $descripcion = $_POST['descripcion']; // Guarda la foto del usuario
                // Inserta los datos en la tabla 
                $sql_update = mysqli_query($conexion,"UPDATE premios SET nombre = '$nombre',
                                                                           fecha = '$fecha',
                                                                           institucion = '$institucion',
                                                                           motivo = '$motivo',
                                                                           descripcion = '$descripcion',
                                                                           cve_docente = '$cve_docente',
                                                                           user_cve = '$user_cve'
                                                                           WHERE cve_docente = '$idDoc'");
                if($sql_update){
                    $alert='
                    <div class="alert alert-dismissible alert-success">
                        <strong>Listo!</strong> La información se actualizó correctamente.
                    </div>
                    '; // Alerta de que se guardo correctamente
                }else{
                    $alert='
                        <div class="alert alert-dismissible alert-danger">
                            <strong>Algo salio mal...</strong> La información no se pudo actualizar.
                        </div>
                    '; // Alerta de algun problema al actualizar el registro
                }
                mysqli_close($conexion); // Cierra conexion con la bd
            }
            break;
        }

    case "volver": // volver
        header('Location:/sistema/secciones/infDocente.php'); // Redirecciona a la lista de los usuarios
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
}
?>

<title>SITA - Editar premio</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Editar premio</h1>
                <hr class="my-2">
                <a><?php echo isset($alert) ? $alert : ''; ?></a> <!-- Espacio para las alertas -->
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>No deje campos vacíos</h4>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre del premio</label>
                                        <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" placeholder="Indique el nivel de estudio finalizado">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Fecha de obtención</label>
                                        <input type="date" class="form-control" name="fecha" value="<?php echo $fecha; ?>">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la institución</label>
                                        <input type="text" class="form-control" name="institucion" value="<?php echo $institucion; ?>" placeholder="Nombre de la institucion del estudio">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-6">
                                        <label class="form-label mt-2">Motivo del premio</label>
                                        <textarea class="form-control" name="motivo" id="motivo" rows="3" placeholder="Motivo aplicable"><?php echo $motivo; ?></textarea>
                                    </div>
                                    <div class = "form-group col-md-6">
                                        <label class="form-label mt-2">Descripción del premio</label>
                                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Descripcion del premio"><?php echo $descripcion; ?></textarea>
                                    </div>
                                </div>
                            <div class="text-center">
                                <br>
                                <button type="submit" name="decision" value="actualizar" class="btn btn-primary" style="float: left;">Actualizar</button> <!-- Guarda el registro -->
                                <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: right;">Volver</button> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[nuevoPremio] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:37 hrs)]
-->