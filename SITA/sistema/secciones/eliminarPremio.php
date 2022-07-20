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
    header("location: /SITA/sistema/index.php"); // Redirecciona a la pagina pricipal
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
?>

<?php
switch($decision){
    case "eliminar": // Eliminar
        if(!empty($_POST)) // Revisa si el arreglo no este vacio
        {
            if(($_SESSION['tipo'] != 1) || ($_SESSION['tipo'] != 2)) // Identifica el tipo de usuario actual
            {
                if($idDoc != $cve_docente){ // Verifica que el docente acceda a sus propios registros
                    header("Location:/SITA/sistema/secciones/infDocente.php"); // Redirecciona a la informacion del docente
                    mysqli_close($conexion); // Cierra la conexion a la bd
                    exit; // Sale del script
                }
            }
            $query_delete = mysqli_query($conexion,"UPDATE premios SET activo = 0 WHERE cve_premio = $idPre");// Desactiva el registro
            mysqli_close($conexion); // Cierra la conexion con la bd
            header('Location:/SITA/sistema/secciones/infDocente.php'); // Redirecciona a la informacion del docente
        }
    break;
    case "volver": // volver
        header('Location:/SITA/sistema/secciones/infDocente.php'); // Redirecciona a la informacion del docente
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
}
?>

<title>SITA - Registrar premio</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Registrar premio</h1>
                <hr class="my-2">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-7 mx-auto">
                        <br>
                        <div class="card">
                            <div class="card-header text-center">
                                ¿Esta seguro de querer eliminar este registro?
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="row"> <!-- Primera fila -->
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Nombre del premio</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $nombre; ?>" readonly="">
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Fecha de optencion</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $fecha; ?>" readonly="">
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Nombre de la institucion</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $institucion; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="row"> <!-- Cuarta fila -->
                                        <div class = "form-group col-md-6">
                                            <label class="form-label mt-2">Motivo del premio</label>
                                            <textarea class="form-control" rows="3" readonly=""><?php echo $motivo; ?></textarea>
                                        </div>
                                        <div class = "form-group col-md-6">
                                            <label class="form-label mt-2">Descripcion del premio</label>
                                            <textarea class="form-control" rows="3" readonly=""><?php echo $descripcion; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <form method="post" action=""> <!-- Botones de acicon -->
                                    <button type="submit" name="decision" value="eliminar" class="btn btn-danger" style="float: left;">Eliminar</button> <!-- Desactiva al usuario -->
                                    <button type="submit" name="decision" value="volver" class="btn btn-primary" style="float: right;">Volver</button> <!-- Regresa a la lista de usuarios -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[eliminarPremio] (Prototipo) ---
Ultima modificacion -- [29/06/2022 (14:45 hrs)]
-->