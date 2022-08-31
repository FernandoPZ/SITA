<?php
include ("../config/conexion.php"); // Realiza la conexion con la bd
if(empty($_GET['id'])) // Valida si la clave del usuario no esta vacia
{
    header('location: verDocente.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id']; // Almacena la clave del docente
$sql_docente = mysqli_query($conexion,"SELECT * FROM docente WHERE cve_docente = $idDoc"); // Consulta todos los datos de la clave del docente
$result_sql_docente = mysqli_num_rows($sql_docente); // Almacena la cantidad todal de registros de la tabla docente
if($result_sql_docente == 0){ // Verifica que la cantidad no este vacia
    $datos = 0; // Indicador de que no hay datos
}else{
    $datos = 1; // Identificador de que si hay datos
    while ($data_docente = mysqli_fetch_array($sql_docente)) // Bucle para almacenar los datos de la tabla docente
    {
        $idDoc = $data_docente['cve_docente']; // Guarda la clave del docente
        $puesto = $data_docente['puesto']; // Guarda el puesto del docente
        $nombre = $data_docente['nombre']; // Guarda el nombre del docente
        $apellido1 = $data_docente['apellido1']; // Guarda el primer apellido del docente
        $apellido2 = $data_docente['apellido2']; // Guarda el segundo apellido del docente
        $foto = $data_docente['foto']; // Guarda el nombre de la fotografia del docente
        $institucion = $data_docente['institucion']; // Guarda el nombre de la institucion
        $tipo_contratacion = $data_docente['tipo_contratacion']; // Guarda el tipo de contratacion
        $fecha_ingreso = $data_docente['fecha_ingreso']; // Guarda la fecha de ingreso a la institucion
        $num_empleado = $data_docente['num_empleado']; // Guarda el numero de empleado del docente
        $cuenta = $data_docente['cuenta']; // Guarda la cuenta asociada
        $fecha_add = $data_docente['fecha_add']; // Guarda la fecha de ingreso al sistema
        $user_cve = $data_docente['user_cve']; // Guarda la clave del usuario que lo agrego
        $activo = $data_docente['activo']; // Guarda el estatus del registro
    }
    $sql_informacion = mysqli_query($conexion,"SELECT * FROM informacion WHERE cve_docente = $idDoc");// Consulta todos los datos de la tabla informacion
    while ($data_informacion = mysqli_fetch_array($sql_informacion)) // Bucle para almacenar los datos de la tabla informacion
    {
        $cve_info = $data_informacion['cve_info']; // Guarda la clave de informacion
        $fecha_nac = $data_informacion['fecha_nac']; // Guarda la fecha de nacimiento del docente
        $doc_nac = $data_informacion['doc_nac']; // Guarda el nombre del archivo del acta de nacimiento
        $genero = $data_informacion['genero']; // Guarda el genero del docente
        $estado_civil = $data_informacion['estado_civil']; // Guarda el estado civil del docente
        $nacionalidad = $data_informacion['nacionalidad']; // Guarda la nacionalidad del docente
        $curp = $data_informacion['curp']; // Guarda el CURP del docente
        $doc_curp = $data_informacion['doc_curp']; // Guarda el nombre del archivo CURP del docente
        $rfc = $data_informacion['rfc']; // Guarda el RFC del docente
        $doc_rfc = $data_informacion['doc_rfc']; // Guarda el nombre del archivo RFC del docente
        $nss = $data_informacion['nss']; // Guarda el numero de seguridad social del docente
        $cve_docente = $data_informacion['cve_docente']; // Guarda la clave del docente vinculado
    }
    $sql_contacto = mysqli_query($conexion,"SELECT * FROM contacto WHERE cve_docente = $idDoc"); // Consulta todos los datos de la tabla contacto
    while ($data_contacto = mysqli_fetch_array($sql_contacto)) // Bucle para almacenar los datos de la tabla contacto
    {
        $cve_contacto = $data_contacto['cve_contacto']; // Guarda la clave de contacto
        $correo_ins = $data_contacto['correo_ins']; // Guarda el correo institucional del docente
        $correo_per = $data_contacto['correo_per']; // Guarda el correo personal del docente
        $telefono = $data_contacto['telefono']; // Guarda el numero de telefono del docente
    }
    $sql_domicilio = mysqli_query($conexion,"SELECT * FROM domicilio WHERE cve_docente = $idDoc"); // Consulta todos los datos de la tabla domicilio
    while ($data_domicilio = mysqli_fetch_array($sql_domicilio)) // Bucle para almacenar los datos de la tabla domicilio
    {
        $cve_domicilio = $data_domicilio['cve_domicilio']; // Guarda la clave de domicilio
        $calle = $data_domicilio['calle']; // Guarda el nombre de la calle
        $num_ext = $data_domicilio['num_ext']; // Guarda el numero exterior
        $num_int = $data_domicilio['num_int']; // Guarda el numero interior
        $codigo_postal = $data_domicilio['codigo_postal']; // Guarda el codigo postal
        $colonia = $data_domicilio['colonia']; // Guarda el nombre de la colonia
        $municipio = $data_domicilio['municipio']; // Guarda el nombre del municipio
        $ciudad = $data_domicilio['ciudad']; // Guarda el nombre de la ciudad
        $estado = $data_domicilio['estado']; // Guarda el nombre del estado
        $pais = $data_domicilio['pais']; // Guarda el nombre del pais
        $doc_dom = $data_domicilio['doc_dom']; // Guarda el nombre del comprobante de domicilio
    }
    $sql_viaje = mysqli_query($conexion,"SELECT * FROM viaje WHERE cve_docente = $idDoc"); // Consulta todos los datos de la tabla viaje
    while ($data_viaje = mysqli_fetch_array($sql_viaje)) // Bucle para almacenar los datos de la tabla viaje
    {
        $cve_viaje = $data_viaje['cve_viaje']; // Guarda la clave de viaje
        $disp_viaje = $data_viaje['disp_viaje']; // Guarda la disponibilidad de viaje
        $num_pasaporte = $data_viaje['num_pasaporte']; // Guarda el numero de pasaporte del docente
        $fecha_ven_pas = $data_viaje['fecha_ven_pas']; // Guarda la fecha de vencimiento del pasaporte
    }
    // Consulta todos los datos de Formacion
    $sql_formacion = mysqli_query($conexion, "SELECT * FROM formacion WHERE activo = 1 AND cve_docente = $idDoc");
    $contadorFO = 1; // Contador de Formacion
    // Consulta todos los datos de Experiencia
    $sql_experiencia = mysqli_query($conexion, "SELECT * FROM experiencia WHERE activo = 1 AND cve_docente = $idDoc");
    $contadorEX = 1; // Contador de Experiencia
    // Consulta todos los datos de Premios
    $sql_premio = mysqli_query($conexion, "SELECT * FROM premios WHERE activo = 1 AND cve_docente = $idDoc");
    $contadorPR = 1; // Contador de Premios
    // Consulta todos los datos de Publicaciones
    $sql_publicacion = mysqli_query($conexion, "SELECT * FROM publicaciones WHERE activo = 1 AND cve_docente = $idDoc");
    $contadorPU = 1; // Contador de Publicaciones
}
// Almacena los datos en un arreglo(array)
$arrayDA = Array (
    "Datos" => Array (
        "cve_docente" => "$idDoc",
        "puesto" => "$puesto",
        "nombre" => "$nombre",
        "apellido1" => "$apellido1",
        "apellido2" => "$apellido2",
        "foto" => "$foto",
        "institucion" => "$institucion",
        "tipo_contratacion" => "$tipo_contratacion",
        "fecha_ingreso" => "$fecha_ingreso",
        "num_empleado" => "$num_empleado",
        "cuenta" => "$cuenta",
        "fecha_add" => "$fecha_add",
        "user_cve" => "$user_cve",
        "activo" => "$activo"
    ),
    "Informacion" => Array (
        "cve_info" => "$cve_info",
        "fecha_nac" => "$fecha_nac",
        "doc_nac" => "$doc_nac",
        "genero" => "$genero",
        "estado_civil" => "$estado_civil",
        "nacionalidad" => "$nacionalidad",
        "curp" => "$curp",
        "doc_curp" => "$doc_curp",
        "rfc" => "$rfc",
        "doc_rfc" => "$doc_rfc",
        "nss" => "$nss",
        "cve_docente" => "$cve_docente"
    ),
    "Contacto" => Array (
        "cve_contacto" => "$cve_contacto",
        "correo_ins" => "$correo_ins",
        "correo_per" => "$correo_per",
        "telefono" => "$telefono",
        "cve_docente" => "$cve_docente"
    ),
    "Domicilio" => Array (
        "cve_domicilio" => "$cve_domicilio",
        "calle" => "$calle",
        "num_ext" => "$num_ext",
        "num_int" => "$num_int",
        "codigo_postal" => "$codigo_postal",
        "colonia" => "$colonia",
        "municipio" => "$municipio",
        "ciudad" => "$ciudad",
        "estado" => "$estado",
        "pais" => "$pais",
        "doc_dom" => "$doc_dom",
        "cve_docente" => "$cve_docente"
    ),
    "Viaje" => Array (
        "cve_viaje" => "$cve_viaje",
        "disp_viaje" => "$disp_viaje",
        "num_pasaporte" => "$num_pasaporte",
        "fecha_ven_pas" => "$fecha_ven_pas",
        "cve_docente" => "$cve_docente"
    )
);
// Almacena la formacion en un arreglo(array)
$arrayFO = Array (); // El arreglo vacio donde se almacenaran los ciclos del bucle
while ($data_formacion = mysqli_fetch_array($sql_formacion)) // Crea un bucle para mostrar los resultados
{
    array_push($arrayFO,
        array("Formacion" => Array (
            "$contadorFO" => Array (
                'cve_formacion'=>$data_formacion['cve_formacion'],
                'nivel_estudio'=>$data_formacion['nivel_estudio'],
                'siglas_estudio'=>$data_formacion['siglas_estudio'],
                'institucion'=>$data_formacion['institucion'],
                'area'=>$data_formacion['area'],
                'disciplina'=>$data_formacion['disciplina'],
                'pais'=>$data_formacion['pais'],
                'fecha_inicio'=>$data_formacion['fecha_inicio'],
                'fecha_fin'=>$data_formacion['fecha_fin'],
                'fecha_titulacion'=>$data_formacion['fecha_titulacion'],
                'habilidades'=>$data_formacion['habilidades'],
                'cve_docente'=>$data_formacion['cve_docente'],
                'fecha_add'=>$data_formacion['fecha_add'],
                'user_cve'=>$data_formacion['user_cve'],
                'activo'=>$data_formacion['activo']
            )
        ))
    );
    $contadorFO = $contadorFO + 1; // Incrementa el contador
}
// Almacena la experiencia en un arreglo(array)
$arrayEX = Array (); // El arreglo vacio donde se almacenaran los ciclos del bucle
while ($data_experiencia = mysqli_fetch_array($sql_experiencia)) // Crea un bucle para mostrar los resultados
{
    array_push($arrayEX,
        array("Experiencia" => Array (
            "$contadorEX" => Array (
                'cve_experiencia'=>$data_experiencia['cve_experiencia'],
                'actividad'=>$data_experiencia['actividad'],
                'institucion'=>$data_experiencia['institucion'],
                'periodo'=>$data_experiencia['periodo'],
                'intereses'=>$data_experiencia['intereses'],
                'cve_docente'=>$data_experiencia['cve_docente'],
                'fecha_add'=>$data_experiencia['fecha_add'],
                'user_cve'=>$data_experiencia['user_cve'],
                'activo'=>$data_experiencia['activo']
            )
        ))
    );
    $contadorEX = $contadorEX + 1; // Incrementa el contador
}
// Almacena los premios en un arreglo(array)
$arrayPR = Array (); // El arreglo vacio donde se almacenaran los ciclos del bucle
while ($data_premio = mysqli_fetch_array($sql_premio)) // Crea un bucle para mostrar los resultados
{
    array_push($arrayPR,
        array("Premios" => Array (
            "$contadorPR" => Array (
                'cve_premio'=>$data_premio['cve_premio'],
                'nombre'=>$data_premio['nombre'],
                'fecha'=>$data_premio['fecha'],
                'institucion'=>$data_premio['institucion'],
                'motivo'=>$data_premio['motivo'],
                'descripcion'=>$data_premio['descripcion'],
                'cve_docente'=>$data_premio['cve_docente'],
                'fecha_add'=>$data_premio['fecha_add'],
                'user_cve'=>$data_premio['user_cve'],
                'activo'=>$data_premio['activo']
            )
        ))
    );
    $contadorPR = $contadorPR + 1; // Incrementa el contador
}
// Almacena las publicaciones en un arreglo(array)
$arrayPU = Array (); // El arreglo vacio donde se almacenaran los ciclos del bucle
while ($data_publicacion = mysqli_fetch_array($sql_publicacion)) // Crea un bucle para mostrar los resultados
{
    array_push($arrayPU,
        array("Publicaciones" => Array (
            "$contadorPU" => Array (
                'cve_publicacion'=>$data_publicacion['cve_publicacion'],
                'tipo'=>$data_publicacion['tipo'],
                'autor'=>$data_publicacion['autor'],
                'titulo_articulo'=>$data_publicacion['titulo_articulo'],
                'titulo_revista'=>$data_publicacion['titulo_revista'],
                'pagina_inicio'=>$data_publicacion['pagina_inicio'],
                'pagina_fin'=>$data_publicacion['pagina_fin'],
                'pais'=>$data_publicacion['pais'],
                'editorial'=>$data_publicacion['editorial'],
                'volumen'=>$data_publicacion['volumen'],
                'fecha_publicacion'=>$data_publicacion['fecha_publicacion'],
                'proposito'=>$data_publicacion['proposito'],
                'estado'=>$data_publicacion['estado'],
                'cve_docente'=>$data_publicacion['cve_docente'],
                'fecha_add'=>$data_publicacion['fecha_add'],
                'user_cve'=>$data_publicacion['user_cve'],
                'activo'=>$data_publicacion['activo']
            )
        ))
    );
    $contadorPU = $contadorPU + 1; // Incrementa el contador
}
// Almacena el conjunto de arreglos dentro de otro arreglo
$array = Array(
    $arrayDA,
    $arrayFO,
    $arrayEX,
    $arrayPR,
    $arrayPU
);
//echo json_encode($array, JSON_FORCE_OBJECT);
// Transforma el arreglo en el archivo JSON
$json = json_encode($array);
$bytes = file_put_contents("".$num_empleado.".json", $json);
// Mueve el archivo a la locacion correcta
$archivo = "".$num_empleado.".json"; // Nombre del archivo
$lugarActual = $archivo;
$lugarNuevo = "../files/docente/json/".$archivo;
$mover = rename($lugarActual, $lugarNuevo);
// Apartado de descarga
$rutaArchivo = "../files/docente/json/"; // Almacena la ruta del archivo
$path = $rutaArchivo.$archivo; // Direccion completa del archivo
$type = '';
// Condiciones para descargar
if (is_file($path)) {
    $size = filesize($path);
    if (function_exists('mime_content_type')) {
        $type = mime_content_type($path);
    } else if (function_exists('finfo_file')) {
        $info = finfo_open(FILEINFO_MIME);
        $type = finfo_file($info, $path);
        finfo_close($info);
    }
    if ($type == '') {
        $type = "application/force-download";
    }
    // Definir headers
    header("Content-Type: $type");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Disposition: attachment; filename=".$archivo."");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $size);
    // Descargar archivo
    readfile($path);
} else {
    die("El archivo no existe.");
}
//header("location: /sistema/index.php"); // Redirecciona a la pagina principal
?>
<?php
// --- Pagina[expDocente] (Prototipo) ---
// Ultima modificacion -- [31/08/2022 (14:41 hrs)]
?>