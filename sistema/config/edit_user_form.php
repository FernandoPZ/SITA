<form action="" method="POST" enctype="multipart/form-data"> <!-- "enctype" necesario para poder reconocer los archivos subidos -->
    <div class="card">
        <div class="card-header text-center">
            <h4>Llene el siguiente formulario</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <input type="hidden" name="cve_usuario" value="<?php echo $iduser; ?>">
                <div class = "form-group col-md-4">
                    <label class="form-label mt-2">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre(s)">
                </div>
                <div class = "form-group col-md-4">
                    <label class="form-label mt-2">Primer apellido</label>
                    <input type="text" class="form-control" name="apellido1" value="<?php echo $apellido1; ?>" placeholder="Primer apellido">
                </div>
                <div class = "form-group col-md-4">
                    <label class="form-label mt-2">Segundo apellido</label>
                    <input type="text" class="form-control" name="apellido2" value="<?php echo $apellido2; ?>" placeholder="Segundo apellido">
                </div>
            </div>
            <div class="row">
                <div class = "form-group col-md-4 mb-3">
                    <label class="form-label mt-2">Usuario</label>
                    <input type="text" class="form-control" name="usuario" value="<?php echo $usuario; ?>" placeholder="usuario">
                </div>
                <div class = "form-group col-md-4 mb-3">
                    <label class="form-label mt-2">Tipo de usuario</label>
                    <?php
                        include "../config/conexion.php"; // Hace la conexion con la bd
                        $query_tipou = mysqli_query($conexion,"SELECT * FROM tipo_usuario"); // Consulta todos los tipos de usuario
                        mysqli_close($conexion); // Cierra la conexion a la bd
                        $result_tipou = mysqli_num_rows($query_tipou); // Almacena el numero de registros
                    ?>
                    <select class="form-select" name="tipo" id="tipo" <?php echo $restriccion; ?>>
                        <?php
                            echo $option; // Muestra la opcion actual
                            if($result_tipou > 0)
                            {
                                while ($tipou = mysqli_fetch_array($query_tipou)){
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
                    <input type="text" class="form-control" name="correo" value="<?php echo $correo; ?>" placeholder="ejemplo@correo.com">
                </div>
            </div>
            <div class="row">
                <div class = "form-group col-md-4">
                    <label class="form-label mt-2">Fotografía</label>
                    <input type="file" class="form-control" name="foto" id="foto">
                    <p class="text-secondary">Dejar en blanco si no quiere cambiar de fotografía</p>
                    <label class="form-label mt-2">Escriba su nueva contraseña</label>
                    <input type="password" class="form-control" name="pass" placeholder="*******">
                    <p class="text-secondary">Dejar en blanco si no quiere cambiar de contraseña</p>
                </div>
                <div class = "form-group col-md-4 mx-auto">
                    <div class="m-0 vh-50 row justify-content-center align-items-center">
                        <div class="col-auto">
                            <p>Foto actual: </p>
                            <output><img src="/SITA/sistema/files/usuario/<?php echo $fotoa; ?>" style="width: 245px; height:245px;"></output>
                        </div>
                    </div>
                </div>
                <div class = "form-group col-md-4 mx-auto">
                    <div class="m-0 vh-50 row justify-content-center align-items-center">
                        <div class="col-auto">
                            <p>Nueva foto: </p>
                            <output id="previsual"></output>
                            <script> <?php include("../js/scripts.js"); ?> </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <div class="alert"><?php echo isset($alert) ? $alert : ""; ?></div>
                <button type="submit" name="decision" value="actualizar" class="btn btn-primary" style="float: left;">Actualizar</button> <!-- Actualiza la informacion -->
                <button type="submit" name="decision" value="volver" class="btn btn-danger" style="float: right;">Volver</button> <!-- Redirecciona a la lista de usuarios -->
            </div>
        </div>
    </div>
</form>
<!--
--- Formulario de editar usuario (Prototipo) ---
Ultima modificacion -- [03/08/2022 (12:34 hrs)]
-->