<?php 

//Importar la conexion
require './includes/configuracion/database.php' ;
$baseDatos = conectarDB();


// Crear un Email y un Password
$email = "marianela@correo.com";
$password = "123456";
$tipo = 1;

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
// Consulta de la cuenta
$query = "INSERT INTO usuarios (email, password, tipo) VALUES ('$email', '$passwordHash', '$tipo')";




/* echo $query;
exit; */
mysqli_query($baseDatos, $query);