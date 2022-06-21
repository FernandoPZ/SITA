<?php

$alert1 = ''; // Declaracion de la alerta #1
$alert2 = ''; // Declaracion de la alerta #2

session_start(); // Inicia la sesion para almacenar datos introducidos
if(!empty($_SESSION['active'])) // Verifica si la sesion esta activa o no
{
    header('location: sistema/index.php'); // Si ya esta activa manda a la pagina principal
}else{ // Si no lo mantiene en esta pagina
    if(!empty($_POST)) // Valida si el "post" no este vacio
    {
        if(empty($_POST['usuario']) || empty($_POST['contra'])) // Valida si los campos fueron llenados cuando da clic en entrar
        {
            $alert1="Inserte su usuario y/o contraseña"; // Alerta de campos vacios
        } else {
            require_once "sistema/config/conexion.php"; // Hace la conexio a la bd
            $user = mysqli_real_escape_string($conexion,$_POST['usuario']); //protegido contra inyeccion de comandos sql
            $pass = md5(mysqli_real_escape_string($conexion,$_POST['contra'])); //protegido contra inyeccion de comandos sql y encriptado de contraseña
            $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$user' AND pass = '$pass'"); // Verifica que lo introducido coincide con algun usuario registrado
            mysqli_close($conexion); // Cierra la conexion
            $result = mysqli_num_rows($query); // Almacena los resultados en una variable

            if($result > 0) // Valida si hay coincidencias
            {
                $data = mysqli_fetch_array($query); // Guarda la informacion dentro de un arreglo para futuras consultas
                $_SESSION['active'] = true; // Validacion de la sesion activa
                $_SESSION['cve_usuario'] = $data['cve_usuario']; // Clave principal del usuario
                $_SESSION['tipo'] = $data['tipo']; // Tipo del usuario
                $_SESSION['usuario'] = $data['usuario']; // Id del usuario
                $_SESSION['foto'] = $data['foto']; // El nombre de la fotografia
                $_SESSION['activo'] = $data['activo']; // Identificador del estado de la cuenta (Activo o desactivado[Borrado])

                header('location: sistema/index.php'); // Redirecciona a la pagina principal del sistema
            } else {
                $alert2 = "El usuario y/o la contraseña son incorrectos"; // Alerta de usuario y/o contraseña incorrectos
                session_destroy(); // Destruye la sesion creada para iniciar una nueva
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITA | login</title> <!-- Titulo de la pagina -->
    <link rel="stylesheet" href="sistema/css/bootstrap.css"/> <!-- Referencia a la hoja de estilos -->
</head>
<body>
    <form action="" method="POST">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mx-auto">
                    <br>
                    <div class="card">
                        <div class="card-header text-center">
                            <img src="sistema/img/elementos/avatar.png" alt="Login" style="width: 100px; height: 100px;"> <!-- Imagen default de usuario -->
                            </br>
                            <h1> Iniciar sesion </h1> <!-- Titulo -->
                        </div>
                        <div class="card-body">
                            <div class = "form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="usuario"> <!-- Campo del id usuario -->
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control" name="contra" placeholder="*******"> <!-- Campo de la contraseña -->
                            </div>
                            <div class="text-center">
                                <div class="text-warning"><strong><?php echo isset($alert1)? $alert1 : ''; ?></strong></div> <!-- Espacio de la alerta #1 -->
                                <div class="text-danger"><strong><?php echo isset($alert2)? $alert2 : ''; ?></strong></div> <!-- Espacio de la alerta #2 -->
                                <button type="submit" name="accion" value="entrar" class="btn btn-lg btn-primary">Entrar</button> <!-- Boton de entrada -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>

<!--
--- Login (Prototipo) ---
Codificacion final -- [21/06/2022 (13:16 hrs)]
Comentario final ---- [21/06/2022 (13:16 hrs)]
-->