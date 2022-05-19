<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Login | SITA</title>
</head>
<body>
    <form>
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
                                <label>Correo electronico</label>
                                <input type="email" class="form-control" id="correo" placeholder="ejemplo@correo.com">
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control" id="contra" placeholder="*******">
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
