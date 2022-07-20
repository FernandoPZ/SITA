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
    header("location: /SITA/sistema/index.php"); // Redirecciona a la pagina pricipal
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
?>

<title>SITA - Registrar formacion</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Registrar formacion</h1>
                <hr class="my-2">
                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div> <!-- Espacio para las alertas -->
                    <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                        <div class="card">
                            <div class="card-header text-center">
                                <h4>Llene el siguiente formulario</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la actividad</label>
                                        <input type="text" class="form-control" name="actividad" value="<?php echo $actividad; ?>" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Nombre de la institucion</label>
                                        <input type="text" class="form-control" name="institucion" value="<?php echo $institucion; ?>"" readonly="">
                                    </div>
                                    <div class = "form-group col-md-4">
                                        <label class="form-label mt-2">Periodo aplicable</label>
                                        <input type="text" class="form-control" name="periodo" value="<?php echo $periodo; ?>" readonly="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class = "form-group col-md-10 mx-auto">
                                        <label class="form-label mt-2">Describa sus intereses</label>
                                        <textarea class="form-control" rows="3" readonly=""><?php echo $intereses; ?></textarea>
                                    </div>
                                </div>
                            <div class="text-center">
                                <br>
                                <a role="button" class="btn btn-primary" href="editarExperiencia.php?id_d=<?php echo $idDoc; ?>&id_e=<?php echo $idExp; ?>">Editar</a> <!-- Redirecciona a editar el registro -->
                                <a role="button" class="btn btn-danger" href="infDocente.php">Volver</a> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[infExperiencia] (Prototipo) ---
Ultima modificacion -- [18/07/2022 (09:57 hrs)]
-->