<?php include("../template/cabecera.php"); ?> <!-- Llama al encabezado de pagina -->

<?php
if($_SESSION['tipo'] != 1) // Identifica si el usuario no sea el Master
{
    header("location: /sistema/index.php"); // Redirecciona a la pagina principal
}

include "../config/conexion.php"; //Conexion con la base de datos

$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision

switch($decision){
    case "eliminar": // Eliminar
        if(!empty($_POST)) // Revisa si el arreglo no este vacio
        {
            if($_POST['cve_usuario'] == 1){ // Verifica que el usuario seleccionado no sea el Master
                header("location: verUsuario.php"); // Redirecciona a la lista de los usuarios
                mysqli_close($conexion); // Cierra la conexion a la bd
                exit; // Sale del script
            }
            $iduser = $_POST['cve_usuario']; // Almacena la clave del usuario seleccionado
            $query_delete = mysqli_query($conexion,"UPDATE usuario SET activo = 0 WHERE cve_usuario = $iduser");// Desactiva el registro
            mysqli_close($conexion); // Cierra la conexion con la bd
            if($_SESSION['cve_usuario'] == $iduser){ // Identifica que el usuario acrual se elimina a si mismo
                header("location: /sistema/config/salir.php"); // Cierra sesion si es el mismo usuario
            }else{
                header("location: verUsuario.php"); // Redirecciona a la lista de los usuarios
            }
        }
    break;
    case "volver": // Volver
        header('Location:/sistema/secciones/verUsuario.php'); // Redirecciona a la lista de los usuarios
        mysqli_close($conexion); // Cierra la conexion con la bd
    break;
}

if(empty($_REQUEST['id'])) // Verifica que la clave del usuario no este vacio
{
    header("location: verUsuario.php"); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra conexion con la bd
}else{
    $iduser = $_REQUEST['id']; // Almacena la clade del usuario
    $query = mysqli_query($conexion,"SELECT u.cve_usuario,
                                            u.nombre,
                                            u.apellido1,
                                            u.apellido2,
                                            u.foto,
                                            u.usuario,
                                            u.pass,
                                            u.correo,
                                            (u.tipo) as idtipo,
                                            (r.tipo) as tipo
                                            FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipo_usu WHERE u.cve_usuario = $iduser"); // Consulta la informacion de la clave del usuario
    $result = mysqli_num_rows($query); // Almacena los registros encontrados
    if($result > 0){ // Verifica si hay registros
        while ($data = mysqli_fetch_array($query)){
            $idtipo = $data['idtipo']; // Guarda la clave del tipo de usuario
            $tipo = $data['tipo']; // Guarda el nombre del tipo de usuario
            $nombre = $data['nombre']; // Guarda el nombre del usuario
            $apellido1 = $data['apellido1']; // Guarda el primer apellido del usuario
            $apellido2 = $data['apellido2']; // Guarda el segundo apellido del usuario
            $fotoa = $data['foto']; // Guarda el nombre de la fotografia del usuario
            $usuario = $data['usuario']; // Guarda el ID del usuario
            $correo = $data['correo']; // Guarda el correo del usuario
        }
    }else{
        header("location: verUsuario.php"); // Redirecciona a la lista de usuarios
        mysqli_close($conexion); // Cierra conexion con la bd
    }
}

if($_SESSION['cve_usuario'] == $_REQUEST['id']){ // Identifica que el usuario acrual se elimina a si mismo
    $alert = '
    <div class="alert alert-dismissible alert-danger">
        <strong>¡Atención!</strong>
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
                    if($iduser != 1) // Valida que no se intente eliminar el master
                    {?>
                    <div class="col-md-5 mx-auto">
                        <div class="card">
                            <div class="card-header text-center">
                                ¿Esta seguro de eliminar este usuario?
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div><?php echo $alert; ?></div> <!-- Advertencia de auto-eliminacion -->
                                    <p><img src="/sistema/files/usuario/<?php echo $fotoa; ?>" style="width: 200px; height:200px;"></p> <!-- Muestra la imagen del usuario -->
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Usuario: </label>
                                        </div>
                                        <div class = "form-group col-md-7">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $usuario; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Tipo: </label>
                                        </div>
                                        <div class = "form-group col-md-7">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $tipo; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <div class = "form-group col-md-3">
                                            <label class="form-label mt-2">Correo: </label>
                                        </div>
                                        <div class = "form-group col-md-7">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $correo; ?>" readonly="">
                                        </div>
                                    </div>
                                    <form method="post" action="">
                                        <input type="hidden" name="cve_usuario" value="<?php echo $iduser; ?>"> <!-- Verificacion de la clave del usuario -->
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
                            <form method="post" action="">
                                <button type="submit" name="decision" value="volver" class="btn btn-primary">Volver</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[eliminarUsuario] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:40 hrs)]
-->