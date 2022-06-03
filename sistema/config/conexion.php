<?php

$host = 'localhost'; //Guarda el nombre del host
$user = 'root'; //Guarda el nombre del usuario
$password = ''; //Guarda la contraseña
$db = 'sita'; //Guarda el nombre de la base de datos

$conexion = @mysqli_connect($host,$user,$password,$db); //Realiza la coneccion

//mysqli_close($conexion);

if(!$conexion){ //Sentencia "IF" para saber si se conecta
    //echo "Error en la coneccion :("; 
}else{
    //echo "Coneccion exitosa :D";
}

?>