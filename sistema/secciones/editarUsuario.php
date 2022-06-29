<?php include("../template/cabecera.php"); ?> <!-- Llama al encabezado -->

<?php
if($_SESSION['tipo'] != 1) // Valida si el usuario es administrador
{
    header("location: /SITA/sistema/index.php"); // Redirecciona a la pagina principal
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; //Boton de decision
include "../config/conexion.php"; //Conexion con la base de datos
?>

<?php
if(empty($_GET['id'])) // Valida si la clave del usuario no esta vacia
{
    header('location: verUsuario.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$iduser = $_GET['id']; // Almacena la clave del usuario

include "../config/conexion.php"; //Realiza la conexion con la bd
// Consulta todos los datos de la clave del usuario
$sql = mysqli_query($conexion,"SELECT u.cve_usuario,
                                      u.nombre,
                                      u.apellido1,
                                      u.apellido2,
                                      u.foto,
                                      u.usuario,
                                      u.pass,
                                      u.correo,
                                      (u.tipo) as idtipo,
                                      (r.tipo) as tipo
                                      FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipo_usu WHERE cve_usuario = $iduser");
$result_sql = mysqli_num_rows($sql); // Almacena la cantidad todal de registros
if($result_sql == 0){ // Verifica que la cantidad no este vacia
    header('Location: verUsuario.php'); // Redirecciona a la lista de usuarios
}else{
    while ($data = mysqli_fetch_array($sql)){
        $iduser = $data['cve_usuario']; // Guarda la clave del usuario
        $idtipo = $data['idtipo']; // Guarda la clave del tipo de usuario
        $tipo = $data['tipo']; // Guarda el nombre del tipo de usuario
        $nombre = $data['nombre']; // Guarda el nombre del usuario
        $apellido1 = $data['apellido1']; // Guarda el primer apellido del usuario
        $apellido2 = $data['apellido2']; // Guarda el segundo apellido del usuario
        $fotoa = $data['foto']; // Guarda el nombre de la fotografia del usuario
        $usuario = $data['usuario']; // Guarda el ID del usuario
        $correo = $data['correo']; // Guarda el correo del usuario
        if($idtipo == 1){ // Si la clave del tipo de usuario es 1 entonces es administrador
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }else if($idtipo == 2){ // Si la clave del tipo de usuario es 2 entonces es editor
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }else if($idtipo == 3){ // Si la clave del tipo de usuario es 3 entonces es consultor
            $option = '<option value="'.$idtipo.'"select>'.$tipo.'</option>';
        }
    }
}
?>

<?php
switch($decision){
    case "actualizar": // Actualizar
        if(!empty($_POST)) // Verifica que ningun campo este vacio
        {
            $alert=''; // Alerta en blanco
            if(empty($_POST['tipo']) // Tipo de usuario
            || empty($_POST['nombre']) // Nombre del usuario
            || empty($_POST['apellido1']) // Primer apellido del usuario
            || empty($_POST['apellido2']) // Segundo apellido del usuario
            || empty($_POST['usuario']) // ID del usuario
            || empty($_POST['correo'])) // Correo del usuario
            {
                $alert='
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar los campos necesarios.
                </div>
                '; // Alerta de que algun campo esta vacio
            }else{
                $iduser = $_POST['cve_usuario']; // Guarda la clave del usuario
                $tipo = $_POST['tipo']; // Guarda el tipo de usuario
                $nombre = $_POST['nombre']; // Guarda el nombre del usuario
                $apellido1 = $_POST['apellido1']; // Guarda el primer apellido del usuario
                $apellido2 = $_POST['apellido2']; // Guarda el segundo apellido del usuario
                $foto = $_FILES['foto']['name']; // Guarda la fotografia del usuario
                $usuario = $_POST['usuario']; // Guarda el ID del usuario
                $pass = $_POST['pass']; // Guarda la contraseña del usuario
                $correo = $_POST['correo']; // Guarda el correo del usuairo
                // Asignacion de nombre unico a la foto
                $fecha= new DateTime(); // Identifica la fecha actual
                $nombreFoto=($foto!="")?$usuario."_".$fecha->getTimestamp()."_".$foto:"$fotoa"; // Cambio de nombre
                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE (usuario = '$usuario' AND cve_usuario != $iduser)"); // Verifica si el ID del usuario no coincide con su clave
                $result_usu = mysqli_fetch_array($query); // Almacena los resultados totales
                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE (correo = '$correo' AND cve_usuario != $iduser)"); // Verifica si el correo del usuario no coincide con su clave
                $result_cor = mysqli_fetch_array($query); // Almacena los resultados totales
                if($result_usu > 0){ // Verifica que no haya coincidencias en el ID del usuario
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el nombre de usuario introducido ya esta ocupado, escoge otro.
                    </div>
                    '; // Alerta de que el ID del usuario esta en uso
                }else{
                    if($result_cor > 0){ // Verifica que no haya coincidencias en el correo del usuario
                        $alert='
                        <div class="alert alert-dismissible alert-warning">
                            <strong>Oh vaya...</strong> el correo introducido ya esta registrado, escoge otro.
                        </div>
                        '; // Alerta de que el correo del usuario esta en uso
                    }else{
                        if(empty($_POST['contra'])){ // Verifica si el campo de contraseña esta vacia
                            // Actualiza cada campo, excepto la contraseña
                            $sql_update = mysqli_query($conexion, "UPDATE usuario SET tipo = '$tipo',
                                                                                      nombre = '$nombre',
                                                                                      apellido1 = '$apellido1',
                                                                                      apellido2 = '$apellido2',
                                                                                      foto = '$nombreFoto',
                                                                                      usuario = '$usuario',
                                                                                      correo = '$correo'
                                                                                      WHERE cve_usuario = $iduser");
                            if($sql_update){
                                $alert='
                                    <div class="alert alert-dismissible alert-success">
                                        <strong>Listo!</strong> El usuario se actualizó correctamente.
                                    </div>
                                '; // Alerta que el usuario se actualizo correctamente
                                $archivoFoto=$_FILES["foto"]["tmp_name"]; // Prepara el archivo subido
                                    if($archivoFoto!=""){
                                        move_uploaded_file($archivoFoto,"../files/upload/fotos/".$nombreFoto); // Mueve la foto subida dentro del sistema
                                    }
                            }else{
                                $alert='
                                    <div class="alert alert-dismissible alert-danger">
                                        <strong>Algo salio mal...</strong> El usuario no se pudo actualizar.
                                    </div>
                                '; // Alerta que no se pudo actualizar al usuario
                            }
                        }else{
                            // Actualiza todos los campos con la contraseña
                            $sql_update = mysqli_query($conexion, "UPDATE usuario SET tipo = '$tipo',
                                                                                      nombre = '$nombre',
                                                                                      apellido1 = '$apellido1',
                                                                                      apellido2 = '$apellido2',
                                                                                      foto = '$nombreFoto',
                                                                                      usuario = '$usuario',
                                                                                      pass = md5('$contra'),
                                                                                      correo = '$correo'
                                                                                      WHERE cve_usuario = $iduser");
                            if($sql_update){
                                $alert='
                                    <div class="alert alert-dismissible alert-success">
                                        <strong>Listo!</strong> El usuario se actualizó correctamente.
                                    </div>
                                '; // Alerta que el usuario se actualizo correctamente
                                $archivoFoto=$_FILES["foto"]["tmp_name"];
                                    if($archivoFoto!=""){
                                        move_uploaded_file($archivoFoto,"../files/upload/fotos/".$nombreFoto);
                                    }
                            }else{
                                $alert='
                                    <div class="alert alert-dismissible alert-danger">
                                        <strong>Algo salio mal...</strong> El usuario no se pudo actualizar.
                                    </div>
                                '; // Alerta que no se pudo actualizar al usuario
                            }
                        }
                    }
                }
                mysqli_close($conexion); // Cierra la conexion con la bd
            }
        }
    break;
    case "cancelar":  // Cancelar
        header('Location:/SITA/sistema/secciones/verUsuario.php'); // Redirecciona a la lista de usuarios
        mysqli_close($conexion); // Cierra la conexion con la bd
    break;
}
?>

<?php
if($iduser == 1) // Valida si el usuario a editar sea el master
{
    $restriccion = 'disabled=""'; // Desactiva el selector de tipo de usuario
}else{
    $restriccion = ''; // Activa el selector de tipo de usuario
}
?>

<title>SITA - Editar usuario</title> <!-- Titulo de la pagina -->

            <div class="jumbotron">
                <h1 class="display-3">Editar informacion del usuario</h1>
                <hr class="my-2">
                <br>
                <?php
                if($iduser == 1)
                {
                    if($_SESSION['cve_usuario'] == $iduser)
                    {
                        include "../config/edit_user_form.php";
                    }else{ ?>
                        <div class="alert alert-dismissible alert-warning mx-auto">
                            <h4 class="alert-heading text-center">Oh, vaya...</h4>
                            <p class="mb-0 text-center">No tienes permiso de editar este usuario</p>
                        </div>
                    <?php }
                }else{
                    include "../config/edit_user_form.php";
                }
                ?>
            </div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[editarUsuarios] (Prototipo) ---
Codificacion final -- [21/06/2022 (13:50 hrs)]
Comentario final ---- [21/06/2022 (13:50 hrs)]
-->