<?php include("../template/cabecera.php"); ?>
<?php
include "../config/conexion.php";

if($_SESSION['tipo'] != 1)
{
    header("location: /SITA/sistema/index.php");
}

?>
<title>SITA - Usuarios</title>

			<div class="jumbotron">
				<h1 class="display-3">Lista de usuarios</h1>
                <hr class="my-2">
                <div class="container-fluid">
                    <?php
                    $busqueda = strtolower($_REQUEST['busqueda']);
                    if(empty($busqueda))
                    {
                        header("location: verUsuario.php");
                    }
                    ?>
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <div class="container-fluid">
                            <button type="button" onclick="location.href='nuevoUsuario.php'" class="btn btn-primary">Nuevo usuario</button>
                            <form action="buscarUsuario.php" method="get" class="d-flex">
                                <input class="form-control me-sm-2" type="text" name="busqueda" id="busqueda" placeholder="Nombre de usuario" value="<?php echo $busqueda; ?>">
                                <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Buscar">
                            </form>
                        </div>
                    </nav>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Clave del usuario</th>
                        <th scope="col">Tipo de usuario</th>
                        <th scope="col">Nombre del usuario</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <?php
                        //Paginador
                        $tipo = '';
                        if($busqueda == 'administrador'){
                            $tipo = " OR u.tipo LIKE '%1%' ";
                        }else if($busqueda == 'editor'){
                            $tipo = " OR u.tipo LIKE '%2%' ";
                        }else if($busqueda == 'consultor'){
                            $tipo = " OR u.tipo LIKE '%3%' ";
                        }else if($busqueda == 'academico'){
                            $tipo = " OR u.tipo LIKE '%4%' ";
                        }
                        $sql_registro = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro FROM usuario u WHERE (cve_usuario LIKE '%$busqueda%' OR usuario LIKE '%$busqueda%' $tipo ) AND activo = 1;");
                        $result_registro = mysqli_fetch_array($sql_registro);
                        $total_registro = $result_registro['total_registro'];

                        $por_pagina = 5;

                        if(empty($_GET['pagina']))
                        {
                            $pagina = 1;
                        }else{
                            $pagina = $_GET['pagina'];
                        }

                        $desde = ($pagina-1) * $por_pagina;
                        $total_pagina = ceil($total_registro / $por_pagina);

                        $query = mysqli_query($conexion, "SELECT u.cve_usuario, r.tipo, u.usuario FROM usuario u INNER JOIN tipo_usuario r ON u.tipo = r.cve_tipou WHERE (u.cve_usuario LIKE '%$busqueda%' OR u.usuario LIKE '%$busqueda%' OR r.tipo LIKE '%$busqueda%' ) AND u.activo = 1 ORDER BY cve_usuario ASC LIMIT $desde,$por_pagina;");

                        mysqli_close($conexion);
                        
                        $result = mysqli_num_rows($query);
                        if($result > 0){
                            while ($data = mysqli_fetch_array($query)){
                                ?>
                                <tbody>
                                    <tr class="table-active">
                                    <th scope="row"><?php echo $data ['cve_usuario']; ?></th>
                                    <td><?php echo $data ['tipo']; ?></td>
                                    <td><?php echo $data ['usuario']; ?></td>
                                    <td>
                                        <form method="post">
                                            <a role="button" class="btn btn-outline-warning" href="editarUsuario.php?id=<?php echo $data ['cve_usuario']; ?>">Editar</a>
                                            <?php if($data['cve_usuario'] != 1){ ?>
                                            <a role="button" class="btn btn-outline-danger" href="eliminarUsuario.php?id=<?php echo $data ['cve_usuario']; ?>" >Borrar</a>
                                            <?php } ?>
                                        </form>
                                    </td>
                                    </tr>
                                </tbody>
                                <?php
                            }
                        }
                    ?>
                </table>
                <?php
                    if($total_registro!= 0){
                ?>
                <div>
                    <ul class="pagination justify-content-end">
                        <?php
                            if($pagina != 1)
                            { ?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo 1; ?> &busqueda=<?php echo $busqueda; ?>">|<</a></li>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina-1; ?> &busqueda=<?php echo $busqueda; ?>"><<</a></li>
                        <?php } ?>
                        <?php
                            for ($i=1; $i <= $total_pagina; $i++){
                                if($i == $pagina){
                                    echo '<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
                                }else{
                                    echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                                }
                            }
                        ?>
                        <?php
                            if($pagina != $total_pagina)
                            { ?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina+1; ?> &busqueda=<?php echo $busqueda; ?>">>></a></li>
                                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $total_pagina; ?> &busqueda=<?php echo $busqueda; ?>">>|</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php }else{ ?>
                    <div class="alert alert-dismissible alert-warning mx-auto">
                        <h4 class="alert-heading text-center">Oh vaya...</h4>
                        <p class="mb-0 text-center">No se han encontrado similitudes :(</p>
                    </div>
                <?php } ?>
			</div>

<?php include("../template/pie.php"); ?>