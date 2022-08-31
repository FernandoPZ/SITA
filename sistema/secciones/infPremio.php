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
?>

<title>SITA - Ver premio</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Ver premio</h1>
                <hr class="my-2">
                <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Información del premio</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class = "form-group col-md-4">
                                    <label class="form-label mt-2">Nombre del premio</label>
                                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" readonly="">
                                </div>
                                <div class = "form-group col-md-4">
                                    <label class="form-label mt-2">Fecha de obtención</label>
                                    <input type="date" class="form-control" name="fecha" value="<?php echo $fecha; ?>" readonly="">
                                </div>
                                <div class = "form-group col-md-4">
                                    <label class="form-label mt-2">Nombre de la institución</label>
                                    <input type="text" class="form-control" name="institucion" value="<?php echo $institucion; ?>" readonly="">
                                </div>
                            </div>
                            <div class="row">
                                <div class = "form-group col-md-6">
                                    <label class="form-label mt-2">Motivo del premio</label>
                                    <textarea class="form-control" name="motivo" id="motivo" rows="3" readonly=""><?php echo $motivo; ?></textarea>
                                </div>
                                <div class = "form-group col-md-6">
                                    <label class="form-label mt-2">Descripción del premio</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3" readonly=""><?php echo $descripcion; ?></textarea>
                                </div>
                            </div>
                            <div class="text-center">
                                <br>
                                <a role="button" class="btn btn-primary" href="editarPremio.php?id_d=<?php echo $idDoc; ?>&id_pr=<?php echo $idPre; ?>">Editar</a> <!-- Redirecciona a editar el registro -->
                                <a role="button" class="btn btn-danger" href="infDocente.php">Volver</a> <!-- Redirecciona al listado de usuarios -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[nuevoPremio] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:43 hrs)]
-->