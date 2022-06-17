<?php

$alert1 = '';
$alert2 = '';

session_start();
if(!empty($_SESSION['active']))
{
    header('location: sistema/index.php');
}else{
    if(!empty($_POST))
    {
        if(empty($_POST['usuario']) || empty($_POST['contra']))
        {
            $alert1="Inserte su usuario y/o contraseña";
        } else {
            require_once "sistema/config/conexion.php";
            $user = mysqli_real_escape_string($conexion,$_POST['usuario']); //protegido contra inyeccion de comandos sql
            $pass = md5(mysqli_real_escape_string($conexion,$_POST['contra'])); //protegido contra inyeccion de comandos sql y encriptado de contraseña
            $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$user' AND pass = '$pass'");
            mysqli_close($conexion);
            $result = mysqli_num_rows($query);

            if($result > 0)
            {
                $data = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['cve_usuario'] = $data['cve_usuario'];
                $_SESSION['tipo'] = $data['tipo'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['foto'] = $data['foto'];
                $_SESSION['activo'] = $data['activo'];

                header('location: sistema/index.php');
            } else {
                $alert2 = "El usuario y/o la contraseña son incorrectos";
                session_destroy();
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
    <title>SITA | login</title>
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
                            <img src="sistema/img/elementos/avatar.png" alt="Login" style="width: 100px; height: 100px;">
                            </br>
                            Iniciar sesion
                        </div>
                        <div class="card-body">
                            <div class = "form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="usuario">
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control" name="contra" placeholder="*******">
                            </div>
                            <div class="text-center">
                                <div class="text-warning"><strong><?php echo isset($alert1)? $alert1 : ''; ?></strong></div>
                                <div class="text-danger"><strong><?php echo isset($alert2)? $alert2 : ''; ?></strong></div>
                                <button type="submit" name="accion" value="entrar" class="btn btn-lg btn-primary">Entrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html> <!-- Listo -->