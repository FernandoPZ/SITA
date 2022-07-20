<?php
include ("../config/conexion.php"); // Realiza la conexion con la bd
if(empty($_GET['id'])) // Valida si la clave del usuario no esta vacia
{
    header('location: verDocente.php'); // Redirecciona a la lista de usuarios
    mysqli_close($conexion); // Cierra la conexion con la bd
}
$idDoc = $_GET['id']; // Almacena la clave del docente
// Consulta todos los datos de la clave del docente
$sql_docente = mysqli_query($conexion,"SELECT * FROM docente WHERE cve_docente = $idDoc");
$result_sql_docente = mysqli_num_rows($sql_docente); // Almacena la cantidad todal de registros

if($result_sql_docente == 0){ // Verifica que la cantidad no este vacia
    $datos = 0;
}else{
    $datos = 1;
    while ($data_docente = mysqli_fetch_array($sql_docente))
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
    // Consulta todos los datos de la tabla informacion
    $sql_informacion = mysqli_query($conexion,"SELECT * FROM informacion WHERE cve_docente = $idDoc");
    while ($data_informacion = mysqli_fetch_array($sql_informacion))
    {
        $cve_info = $data_informacion['cve_info']; // Guarda la clave de informacion
        $fecha_nac = $data_informacion['fecha_nac']; // Guarda la fecha de nacimiento del docente
        $doc_naca = $data_informacion['doc_nac']; // Guarda el nombre del archivo del acta de nacimiento
        $genero = $data_informacion['genero']; // Guarda el genero del docente
        $estado_civil = $data_informacion['estado_civil']; // Guarda el estado civil del docente
        $nacionalidad = $data_informacion['nacionalidad']; // Guarda la nacionalidad del docente
        $curp = $data_informacion['curp']; // Guarda el CURP del docente
        $doc_curpa = $data_informacion['doc_curp']; // Guarda el nombre del archivo CURP del docente
        $rfc = $data_informacion['rfc']; // Guarda el RFC del docente
        $doc_rfca = $data_informacion['doc_rfc']; // Guarda el archivo RFC del docente
        $nss = $data_informacion['nss']; // Guarda el numero de seguridad social del docente
    }
    // Consulta todos los datos de la tabla contacto
    $sql_contacto = mysqli_query($conexion,"SELECT * FROM contacto WHERE cve_docente = $idDoc");
    while ($data_contacto = mysqli_fetch_array($sql_contacto))
    {
        $cve_contacto = $data_contacto['cve_contacto']; // Guarda la clave de contacto
        $correo_ins = $data_contacto['correo_ins']; // Guarda el correo institucional del docente
        $correo_per = $data_contacto['correo_per']; // Guarda el correo personal del docente
        $telefono = $data_contacto['telefono']; // Guarda el numero de telefono del docente
    }
    // Consulta todos los datos de la tabla domicilio
    $sql_domicilio = mysqli_query($conexion,"SELECT * FROM domicilio WHERE cve_docente = $idDoc");
    while ($data_domicilio = mysqli_fetch_array($sql_domicilio))
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
        $doc_doma = $data_domicilio['doc_dom']; // Guarda el nombre del comprobante de domicilio
    }
    // Consulta todos los datos de la tabla viaje
    $sql_viaje = mysqli_query($conexion,"SELECT * FROM viaje WHERE cve_docente = $idDoc");
    while ($data_viaje = mysqli_fetch_array($sql_viaje))
    {
        $cve_viaje = $data_viaje['cve_viaje']; // Guarda la clave de viaje
        $disp_viaje = $data_viaje['disp_viaje']; // Guarda la disponibilidad de viaje
        $num_pasaporte = $data_viaje['num_pasaporte']; // Guarda el numero de pasaporte del docente
        $fecha_ven_pas = $data_viaje['fecha_ven_pas']; // Guarda la fecha de vencimiento del pasaporte
    }
}

// Almacena los datos en un arreglo(array)
$array = Array (
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
    "activo" => "$activo",
    "formacion" => Array (
        "id" => "02",
        "name" => "Jennifer Laurence",
        "designation" => "Senior Programmer"
    ),
    "experiencia" => Array(
        "id" => "03",
        "name" => "Medona Oliver",
        "designation" => "Office Manager"
    )
);
// Transforma el arreglo en el archivo JSON
$json = json_encode($array);
$bytes = file_put_contents("".$num_empleado.".json", $json);
// Mueve el archivo a la locacion correcta
$archivo = "".$num_empleado.".json";
$lugarActual = $archivo;
$lugarNuevo = "../files/docente/json/".$archivo;
$mover = rename($lugarActual, $lugarNuevo);
if(!$mover)
{
    echo "No se movio el archivo";
}

$rutaArchivo = "../files/docente/json/";
$path = $rutaArchivo.$archivo;
$type = '';

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
?>
<?php
// --- Pagina[expDocente] (Prototipo) ---
// Ultima modificacion -- [13/07/2022 (12:00 hrs)]
?>