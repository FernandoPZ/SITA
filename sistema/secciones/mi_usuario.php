<?php include("../template/cabecera.php"); ?>

<?php include ("../config/conexion.php"); ?>

<?php
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
        $idtipo = $data['idtipo']; // Guarda la clave del tipo de usuario
        $tipo = $data['tipo']; // Guarda el nombre del tipo de usuario
        $nombre = $data['nombre']; // Guarda el nombre del usuario
        $apellido1 = $data['apellido1']; // Guarda el primer apellido del usuario
        $apellido2 = $data['apellido2']; // Guarda el segundo apellido del usuario
        $fotoa = $data['foto']; // Guarda el nombre de la fotografia del usuario
        $usuario = $data['usuario']; // Guarda el ID del usuario
        $correo = $data['correo']; // Guarda el correo del usuario
    }
}
?>

<title>SITA - Mi usuario</title> <!-- Nombre de la pagina -->

			<div class="jumbotron">
				<h1 class="display-3">Mi usuario</h1>
				<hr class="my-2">
			</div>
            <div class="container">
                <div class="row">
                    <div class="col-md-7 mx-auto">
                        <br>
                        <div class="card">
                            <div class="card-header text-center">
                                Perfil del usuario <?php echo $usuario; ?>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <p><img src="/sistema/files/usuario/<?php echo $fotoa; ?>" style="width: 200px; height:200px;"></p> <!-- Muestra la imagen del usuario -->
                                </div>
                                    <div class="row">
                                        <input type="hidden" name="cve_usuario" value="<?php echo $iduser; ?>">
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Nombre</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $nombre; ?>" readonly="">
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Primer apellido</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $apellido1; ?>" readonly="">
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Segundo apellido</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $apellido2; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Correo electronico</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $correo; ?>" readonly="">
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Usuario</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $usuario; ?>" readonly="">
                                        </div>
                                        <div class = "form-group col-md-4">
                                            <label class="form-label mt-2">Tipo de usuario</label>
                                            <input type="text" class="form-control form-control-sm" value="<?php echo $tipo; ?>" readonly="">
                                        </div>
                                    </div>
                                </div>
                            <div class="text-center">
                                <a role="button" class="btn btn-warning" href="../index.php">Volver al inicio</a> <!-- Redirecciona al inicio -->
                                <div><br></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php include("../template/pie.php"); ?>

<!--
--- Pagina[mi_usuario] (Prototipo) ---
Ultima modificacion -- [31/08/2022 (14:43 hrs)]
-->