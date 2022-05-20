<?php

$alert1 = '';
$alert2 = '';
if(!empty($_POST))
{
    if(empty($_POST['usuario']) || empty($_POST['contra']))
    {
        $alert1="Inserte su usuario y/o contraseña";
    } else {
        require_once "conexion.php";
        $user = $_POST['usuario'];
        $pass = $_POST['contra'];
        $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$user' AND pass = '$pass'");
        $result = mysqli_num_rows($query);

        if($result > 0)
        {
            $data = mysqli_fetch_array($query);
            session_start();
            $_SESSION['active'] = true;
            $_SESSION['cve_usuario'] = $data['cve_usuario'];
            $_SESSION['cve_tipou'] = $data['cve_tipou'];
            $_SESSION['usuario'] = $data['usuario'];
            $_SESSION['activo'] = $data['activo'];

            header('location: sistema/index.php');
        } else {
            $alert2 = "El usuario y/o la contraseña son incorrectos";
            //session_destroy();
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>SITA | login</title>
</head>
<body>
    <form action="" method="POST">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mx-auto">
                    <br>
                    <div class="card">
                        <div class="card-header text-center">
                            <img src="img/avatar.png" alt="Login" style="width: 100px; height: 100px;">
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
</html>
