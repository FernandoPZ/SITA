<?php include("../template/cabecera.php"); ?> <!-- Llama al encabezado de pagina -->

<?php
if(($_SESSION['tipo'] == 3) || ($_SESSION['tipo'] == 4))// Identifica si el usuario tiene permisos
{
    header("location: /SITA/sistema/index.php"); // Redirecciona a la pagina principal
}

include "../config/conexion.php"; //Conexion con la base de datos

$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision

switch($decision){
    case "eliminar": // Eliminar
        if(!empty($_POST)) // Revisa si el arreglo no este vacio
        {
            $idDoc = $_POST['cve_docente']; // Almacena la clave del usuario seleccionado
            $query_delete = mysqli_query($conexion,"UPDATE docente SET activo = 0 WHERE cve_docente = $idDoc");// Desactiva el registro
            mysqli_close($conexion); // Cierra la conexion con la bd
            if($_SESSION['cve_docente'] == $idDoc){ // Identifica que el usuario acrual se elimina a si mismo
                header("location: /SITA/sistema/config/salir.php"); // Cierra sesion si es el mismo usuario
            }else{
                header("location: verDocente.php"); // Redirecciona a la lista de los usuarios
            }
        }
    break;
    case "volver": // Volver
        header('Location:/SITA/sistema/secciones/verDocente.php'); // Redirecciona a la lista de los usuarios
        mysqli_close($conexion); // Cierra la conexion con la bd
    break;
}

if(empty($_REQUEST['id'])) // Verifica que la clave del usuario no este vacio
{
    header("location: verDocente.php"); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra conexion con la bd
}else{
    $idDoc = $_REQUEST['id']; // Almacena la clade del usuario
    $query = mysqli_query($conexion,"SELECT p.puesto, d.nombre, d.apellido1, d.apellido2, d.foto, d.num_empleado, d.cuenta FROM docente d INNER JOIN puesto p ON d.puesto = p.cve_puesto WHERE cve_docente = $idDoc"); // Consulta la informacion de la clave del docente
    $result = mysqli_num_rows($query); // Almacena los registros encontrados
    if($result > 0){ // Verifica si hay registros
        while ($data = mysqli_fetch_array($query)){
            $puesto = $data['puesto']; // Almacena el ID del usuario
            $nombre = $data['nombre']; // Almacena la foto del usuario
            $apellido1 = $data['apellido1']; // Almacena el tipo del usuario
            $apellido2 = $data['apellido2']; // Almacena el ID del usuario
            $foto = $data['foto']; // Almacena la foto del usuario
            $num_empleado = $data['num_empleado']; // Almacena el tipo del usuario
            $cuenta = $data['cuenta']; // Almacena el ID del usuario
        }
    }else{
        header("location: verDocente.php"); // Redirecciona a la lista de usuarios
        echo 'No hay registro';
        mysqli_close($conexion); // Cierra conexion con la bd
    }
}

if($_SESSION['cve_usuario'] == $_REQUEST['id']){ // Identifica que el usuario acrual se elimina a si mismo
    $alert = '
    <div class="alert alert-dismissible alert-danger">
        <strong>¡Atencion!</strong>
        <br>
        <a>Estas a punto de eliminar tu propia cuenta.</a>
    </div>
    '; // Alerta de eliminarse a si mismo
}else{
    $alert = '';
}

?>

<title>SITA - Eliminar usuario</title> <!-- Nombre de la pagina -->

			<div class="jumbotron">
				<h1 class="display-3">Eliminar usuario</h1>
				<hr class="my-2">
			</div>
            <div class="container">
                <div class="row">
                    <?php
                    if($idDoc != 1) // Valida que no se intente eliminar el master
                    {?>
                    <div class="col-md-5 mx-auto">
                        <div class="card">
                            <div class="card-header text-center">
                                ¿Esta seguro de eliminar este usuario?
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div><?php echo $alert; ?></div> <!-- Advertencia de auto-eliminacion -->
                                    <p><img src="/SITA/sistema/files/docente/foto/<?php echo $foto; ?>" style="width: 200px; height:200px;"></p> <!-- Muestra la imagen del usuario -->
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Nombre: </label>
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $nombre; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">1er Apellido: </label>
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $apellido1; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">2do Apellido: </label>
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $apellido2; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Puesto: </label>
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $puesto; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Numero: </label>
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $num_empleado; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Cuenta: </label>
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $cuenta; ?>" readonly="">
                                        </div>
                                    </div>
                                    <form method="post" action="">
                                        <input type="hidden" name="cve_docente" value="<?php echo $idDoc; ?>"> <!-- Verificacion de la clave del docente -->
                                        <button type="submit" name="decision" value="eliminar" class="btn btn-danger" style="float: left;">Eliminar</button> <!-- Desactiva al usuario -->
                                        <button type="submit" name="decision" value="volver" class="btn btn-primary" style="float: right;">Volver</button> <!-- Regresa a la lista de usuarios -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="col-md-5 mx-auto">
                        </br>
                            <div class="alert alert-dismissible alert-warning"> <!-- Alerta de que el usuario no se puede eliminar -->
                                <h4 class="alert-heading">Lo sentimos</h4>
                                <p class="mb-0"> Este usuario no se puede eliminar </p>
                            </div>
                        </div>
                        <div class="text-center">
                        <button type="submit" name="decision" value="volver" class="btn btn-primary">Volver</button>
                        </div>
                    <?php } ?>
                </div>
            </div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[eliminarDocente] (Prototipo) ---
Ultima modificacion -- [03/08/2022 (14:57 hrs)]
-->