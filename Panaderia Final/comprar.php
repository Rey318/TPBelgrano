<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

require './includes/configuracion/database.php';
$baseDatos = conectarDB();

$usuario_id = $_SESSION['usuario_id']; // Suponiendo que se guarda el ID del usuario en la sesión
$producto_id = $_POST['producto_id'];
$cantidad = $_POST['cantidad'];

// Insertar la compra en la tabla compras
$query = "INSERT INTO compras (usuario_id, producto_id, cantidad) VALUES ('$usuario_id', '$producto_id', '$cantidad')";
mysqli_query($baseDatos, $query);

echo "Compra realizada con éxito";
?>
