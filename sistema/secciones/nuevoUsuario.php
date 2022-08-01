<?php include("../template/cabecera.php"); ?> <!-- Llama a la cabecera -->

<?php
if($_SESSION['tipo'] != 1) // Valida si el usuario es nivel administrador
{
    header("location: /SITA/sistema/index.php"); // Redirecciona a la pagina pricipal
}
$decision=(isset($_POST['decision']))?$_POST['decision']:""; // Boton de decision
include "../config/conexion.php"; // Realiza la coneccion de la bd
?>

<?php
switch($decision){
    case "guardar": // Guargar
        if(!empty($_POST)) // Valida si los campos no esten vacios
        {
            $alert='';
            if(empty($_POST['tipo']) // Tipo de usuario
            || empty($_POST['nombre']) // Nombre del usuario
            || empty($_POST['apellido1']) // Primer apellido del usuario
            || empty($_POST['apellido2']) // Segundo apellido del usuario
            || empty($_FILES['foto']) // Foto del usuario
            || empty($_POST['usuario']) // ID del usuario
            || empty($_POST['pass1']) // Contraseña
            || empty($_POST['pass2']) // Contaseña (verificacion)
            || empty($_POST['correo'])) // Correo del usuario
            {
                $alert=' 
                <div class="alert alert-dismissible alert-warning">
                    <strong>Se te olvida algo...</strong> debes de llenar todos los campos.
                </div>
                '; // Alerta de algun campo vacio
            }else{
                $tipo = $_POST['tipo']; // Guarda el tipo de usuario
                $nombre = $_POST['nombre']; // Guarda el nombre del usuario
                $apellido1 = $_POST['apellido1']; // Guarda el primer apellido del usuario
                $apellido2 = $_POST['apellido2']; // Guarda el segundo apellido del usuario
                $foto = $_FILES['foto']['name']; // Guarda la foto del usuario
                $usuario = $_POST['usuario']; // Guarda el ID del usuario
                $pass1 = $_POST['pass1']; // Guarda la contraseña del usuario
                $pass2 = $_POST['pass2']; // Guarda la verificacion de contraseña del usuario
                $correo = $_POST['correo']; // Guarda el correo del usuario
                // Asignacion de nombre unico a la foto
                $fecha= new DateTime(); // Determina la fecha actual
                $nombreFoto=($foto!="")?$usuario."_".$fecha->getTimestamp()."_".$foto:"default.png"; // Nuevo nombre
                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$usuario'"); // Verifica que el usuario introducido este en la bd
                $result_usu = mysqli_fetch_array($query); // Almacena cuantas coincidencias existen
                $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE correo = '$correo'"); // Verifica que el correo introducido este en la bd
                $result_cor = mysqli_fetch_array($query); // Almacena cuantas coincidencias existen
                if($result_usu > 0){ // Si hay alguna coincidencia con el usuario, muestra la alerta
                    $alert='
                    <div class="alert alert-dismissible alert-warning">
                        <strong>Oh vaya...</strong> el nombre de usuario introducido ya esta registrado, escoge otro.
                    </div>
                    '; // Alerta de coincidencia de usuario
                }else{
                    if($result_cor > 0){ // Si hay alguna coincidencia con el correo, muestra la alerta
                        $alert='
                        <div class="alert alert-dismissible alert-warning">
                            <strong>Oh vaya...</strong> el correo introducido ya esta registrado, escoge otro.
                        </div>
                        '; // Alerta de coincidencia de correo
                    }else{
                        if($pass1 != $pass2){ // Si las contraseñas no son las mismas
                            $alert='
                            <div class="alert alert-dismissible alert-danger">
                                <strong>Oh vaya...</strong> las contraseñas no coinciden.
                            </div>
                            '; // Muestra la alerta de contraseñas diferentes
                        }else{
                            // Inserta los datos en la tabla 
                            $query_insert = mysqli_query($conexion,"INSERT INTO usuario(tipo,nombre,apellido1,apellido2,foto,usuario,pass,correo)
                                                                                VALUES ('$tipo','$nombre','$apellido1','$apellido2','$nombreFoto','$usuario',md5('$pass1'),'$correo')");
                            if($query_insert){
                                $alert='
                                    <div class="alert alert-dismissible alert-success">
                                        <strong>Listo!</strong> El usuario se guardo correctamente.
                                    </div>
                                '; // Alerta de que se guardo correctamente
                                $archivoFoto=$_FILES["foto"]["tmp_name"]; // Almacena la imagen subida
                                if($archivoFoto!=""){ // Verifica que el campo de subida no este vacio
                                    move_uploaded_file($archivoFoto,"../files/usuario/".$nombreFoto); // Mueve la imagen subida a otra carpeta dentro del sistema
                                }
                            }else{
                                $alert='
                                    <div class="alert alert-dismissible alert-danger">
                                        <strong>Algo salio mal...</strong> El usuario no se pudo guardar.
                                    </div>
                                '; // Alerta de algun problema al guardar el registro
                            }
                        }
                    }
                }
                mysqli_close($conexion); // Cierra conexion con la bd
            }
            break;
        }

    case "volver": // volver
        header('Location:/SITA/sistema/secciones/verUsuario.php'); // Redirecciona a la lista de los usuarios
        mysqli_close($conexion); // Cierra conexion con la bd
    break;
}
?>

<title>SITA - Registrar usuario</title> <!-- Llama al encabezado -->

            <div class="jumbotron">
                <h1 class="display-3">Registrar nuevo usuario</h1>
                <hr class="my-2">
            </div>
            <a><?php echo isset($alert) ? $alert : ''; ?></a> <!-- Espacio para las alertas -->
            <form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Llene el siguiente formulario</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class = "form-group col-md-4">
                                <label class="form-label mt-2">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : '';?>" placeholder="Nombre(s)">
                            </div>
                            <div class = "form-group col-md-4">
                                <label class="form-label mt-2">Primer apellido</label>
                                <input type="text" class="form-control" name="apellido1" value="<?php echo isset($_POST['apellido1']) ? $_POST['apellido1'] : '';?>" placeholder="Primer apellido">
                            </div>
                            <div class = "form-group col-md-4">
                                <label class="form-label mt-2">Segundo apellido</label>
                                <input type="text" class="form-control" name="apellido2" value="<?php echo isset($_POST['apellido2']) ? $_POST['apellido2'] : '';?>" placeholder="Segundo apellido">
                            </div>
                        </div>
                        <div class="row">
                            <div class = "form-group col-md-4 mb-3">
                                <label class="form-label mt-2">Usuario</label>
                                <input type="text" class="form-control" name="usuario" value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : '';?>" placeholder="Usuario">
                            </div>
                            <div class = "form-group col-md-4 mb-3">
                                <label class="form-label mt-2">Tipo de usuario</label>
                                <?php
                                    include "../config/conexion.php"; // Realiza la conexion con la bd
                                    $query_tipou = mysqli_query($conexion,"SELECT * FROM tipo_usuario"); // Consulta todos los tipos de usuarios
                                    mysqli_close($conexion); // Cierra conexion
                                    $result_tipou = mysqli_num_rows($query_tipou); // Almacena la cantidad de registros en la consulta
                                ?>
                                <select class="form-select" name="tipo" id="tipo">
                                    <?php
                                        if($result_tipou > 0) // Valida si hay registros
                                        {
                                            while ($tipou = mysqli_fetch_array($query_tipou)){ // Bucle para mostrar todos los registros
                                                ?>
                                                <option value="" hidden>Selecciona una opción</option>
                                                <option value="<?php echo $tipou["cve_tipo_usu"]; ?>"><?php echo $tipou["tipo"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class = "form-group col-md-4 mb-3">
                                <label class="form-label mt-2">Correo personal</label>
                                <input type="text" class="form-control" name="correo" value="<?php echo isset($_POST['correo']) ? $_POST['correo'] : '';?>" placeholder="ejemplo@correo.com">
                            </div>
                        </div>
                        <div class="row">
                            <div class = "form-group col-md-6">
                                <label class="form-label mt-2">Fotografía</label>
                                <input type="file" class="form-control" name="foto" id="foto">
                                <label class="form-label mt-2">Escriba su contraseña</label>
                                <input type="password" class="form-control" name="pass1" placeholder="*******">
                                <label class="form-label mt-2">Escriba de nuevo su contraseña</label>
                                <input type="password" class="form-control" name="pass2" placeholder="*******">
                            </div>
                            <div class = "form-group col-md-3 mx-auto">
                                <div class="m-0 vh-50 row justify-content-center align-items-center">
                                    <div class="col-auto">
                                        <br>
                                        <output id="previsual"></output> <!-- Espacio para previsualizar la foto subida -->
                                        <script> <?php include("../js/scripts.js"); ?> </script> <!-- llama al script necesario para poder previsualizar -->
                                    </div>
                                </div>
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

<?php include("../template/pie.php"); ?> <!-- Llama al pie de la pagina -->

<!--
--- Pagina[nuevoUsuarios] (Prototipo) ---
Ultima modificacion -- [01/08/2022 (13:24 hrs)]
-->