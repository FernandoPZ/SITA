<?php include("../template/cabecera.php"); ?> <!-- Llama a la cabecera -->

<?php
include "../config/conexion.php"; // Realiza la coneccion de la bd
if(empty($_GET['id_d'])) // Valida si la clave del usuario no esta vacia
{
    header('location: infDocente.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id_d']; // Almacena la clave del docente
$sql_docente = mysqli_query($conexion,"SELECT * FROM docente WHERE cve_docente = $idDoc");
while ($data_docente = mysqli_fetch_array($sql_docente)){
    $cuenta = $data_docente['cuenta']; // Guarda la cuenta asociada
}
if($_SESSION['tipo'] != 1) // Valida si el usuario es nivel administrador
{
    if($_SESSION['cve_usuario'] != $cuenta){
        header("location: /sistema/index.php"); // Redirecciona a la pagina pricipal
    }
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
$user = $_SESSION['cve_usuario']; // Guarda la clave de usuario con la que entra
?>

<?php
switch($decision){
    case "guardar": // Guargar
        if(!empty($_POST)) // Valida si los campos no esten vacios
        {
            $alert='';
            if(empty($_POST['actividad']) // Nivel de estudio
            || empty($_POST['institucion']) // Siglas del estudio
            || empty($_POST['periodo']) // Nombre de la institucion
            || empty($_POST['intereses'])) // area correspondiente
            {
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                $actividad = $_POST['actividad']; // Guarda el tipo de usuario
                $institucion = $_POST['institucion']; // Guarda el nombre del usuario
                $periodo = $_POST['periodo']; // Guarda el primer apellido del usuario
                $intereses = $_POST['intereses']; // Guarda el segundo apellido del usuario
                // Inserta los datos en la tabla 
                $query_insert = mysqli_query($conexion,"INSERT INTO experiencia(actividad, institucion, periodo, intereses, cve_docente, user_cve)
                                                                        VALUES ('$actividad','$institucion','$periodo','$intereses','$idDoc','$user')");
                if($query_insert){
                    $alert='
                    <div class="alert alert-dismissible alert-success">
                        <strong>Listo!</strong> El registro se guardó correctamente.
                    </div>
                    '; // Alerta de que se guardo correctamente
                }else{
                    $alert='
                        <div class="alert alert-dismissible alert-danger">
                            <strong>Algo salio mal...</strong> El registro no se pudo guardar.
                        </div>
                    '; // Alerta de algun problema al guardar el registro
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

<title>SITA - Registrar experiencia</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Registrar experiencia</h1>
                <hr class="my-2">
                <a><?php echo isset($alert) ? $alert : ''; ?></a> <!-- Espacio para las alertas -->
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Llene el siguiente formulario</h4>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la actividad</label>
                                        <input type="text" class="form-control" name="actividad" value="<?php echo isset($_POST['actividad']) ? $_POST['actividad'] : '';?>" placeholder="Indique el nombre de la actividad">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la institución</label>
                                        <input type="text" class="form-control" name="institucion" value="<?php echo isset($_POST['institucion']) ? $_POST['institucion'] : '';?>" placeholder="Nombre de la institución de la actividad">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Periodo aplicable</label>
                                        <input type="text" class="form-control" name="periodo" value="<?php echo isset($_POST['periodo']) ? $_POST['periodo'] : '';?>" placeholder="Periodo aplicable">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-10 mx-auto">
                                        <label class="form-label mt-2">Describa sus intereses</label>
                                        <textarea class="form-control" name="intereses" id="habilidades" rows="3" placeholder="Aqui sus intereses"><?php echo isset($_POST['intereses']) ? $_POST['intereses'] : '';?></textarea>
                                    </div>
                                </div>
                            <div class="text-center">
                                <br>
                                <button type="submit" name="decision" value="guardar" class="btn btn-primary" style="float: left;">Guardar</button> <!-- Guarda el registro -->
                                <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: right;">Volver</button> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[nuevoUsuarios] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:44 hrs)]
-->