<?php include("../template/cabecera.php"); ?> <!-- Llama a la cabecera -->

<?php
include "../config/conexion.php"; // Realiza la coneccion de la bd
if((empty($_GET['id_d'])) || (empty($_GET['id_e']))) // Valida si la clave del usuario no esta vacia
{
    header('location: verUsuario.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id_d']; // Almacena la clave del docente
$idExp = $_GET['id_e']; // Almacena la clave del docente
$sql_experiencia = mysqli_query($conexion,"SELECT * FROM experiencia WHERE cve_experiencia = $idExp");
$result = mysqli_num_rows($sql_experiencia); // Almacena la cantidad todal de registros
if($result == 0){ // Verifica que la cantidad no este vacia
    header('Location: verUsuario.php'); // Redirecciona a la lista de usuarios
}else{
    while ($data = mysqli_fetch_array($sql_experiencia)){
        $cve_experiencia = $data['cve_experiencia']; // Guarda la clave del usuario
        $actividad = $data['actividad']; // Guarda la clave del tipo de usuario
        $institucion = $data['institucion']; // Guarda el nombre del usuario
        $periodo = $data['periodo']; // Guarda el primer apellido del usuario
        $intereses = $data['intereses']; // Guarda el segundo apellido del usuario
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
            if(empty($_POST['actividad']) // Nivel de estudio
            || empty($_POST['institucion']) // Nombre de la institucion
            || empty($_POST['periodo']) // periodo correspondiente
            || empty($_POST['intereses'])) // Disiplina del curso
            {
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                $actividad = $_POST['actividad']; // Guarda el tipo de usuario
                $institucion = $_POST['institucion']; // Guarda el primer apellido del usuario
                $periodo = $_POST['periodo']; // Guarda el segundo apellido del usuario
                $intereses = $_POST['intereses']; // Guarda la foto del usuario
                // Inserta los datos en la tabla 
                $sql_update = mysqli_query($conexion,"UPDATE experiencia SET actividad = '$actividad',
                                                                           institucion = '$institucion',
                                                                           periodo = '$periodo',
                                                                           intereses = '$intereses'
                                                                           WHERE cve_docente = '$idDoc'");
                if($sql_update){
                    $alert='
                    <div class="alert alert-dismissible alert-success">
                        <strong>Listo!</strong> La experiencia se actualizó correctamente.
                    </div>
                    '; // Alerta de que se guardo correctamente
                }else{
                    $alert='
                        <div class="alert alert-dismissible alert-danger">
                            <strong>Algo salió mal...</strong> La experiencia no se pudo actualizar.
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

<title>SITA - Editar experiencia</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Editar experiencia</h1>
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
                                    <label class="form-label mt-2">Nombre de la actividad</label>
                                    <input type="text" class="form-control" name="actividad" value="<?php echo $actividad; ?>" placeholder="Indique el nombre de la actividad">
                                </div>
                                <div class = "form-group col-md-4">
                                    <label class="form-label mt-2">Nombre de la institución</label>
                                    <input type="text" class="form-control" name="institucion" value="<?php echo $institucion; ?>"" placeholder="Nombre de la institución de la actividad">
                                </div>
                                <div class = "form-group col-md-4">
                                    <label class="form-label mt-2">Periodo aplicable</label>
                                    <input type="text" class="form-control" name="periodo" value="<?php echo $periodo; ?>" placeholder="Periodo aplicable">
                                </div>
                            </div>
                            <div class="row">
                                <div class = "form-group col-md-10 mx-auto">
                                    <label class="form-label mt-2">Describa sus intereses</label>
                                    <textarea class="form-control" name="intereses" id="habilidades" rows="3" placeholder="Aqui sus intereses"><?php echo $intereses; ?></textarea>
                                </div>
                            </div>
                        <div class="text-center">
                            <br>
                                <button type="submit" name="decision" value="actualizar" class="btn btn-primary" style="float: left;">actualizar</button> <!-- Guarda el registro -->
                                <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: right;">Volver</button> <!-- Redirecciona a la informacion del docente -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[editarExperiencia] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:36 hrs)]
-->