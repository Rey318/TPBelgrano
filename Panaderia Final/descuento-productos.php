<?php
require 'includes/configuracion/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$idProducto = $data['id'];
$cantidad = $data['cantidad'] ?? 1;

$response = [];

function descontarProducto($idProducto, $cantidad) {
    $baseDatos = conectarDB();

    // Preparar y ejecutar la consulta para actualizar la cantidad del producto
    $query = "UPDATE productos SET cantidad = cantidad - ? WHERE id_producto = ? AND cantidad > 0";
    $stmt = mysqli_prepare($baseDatos, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $cantidad, $idProducto);

    $resultado = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $resultado;
}

if (descontarProducto($idProducto, $cantidad)) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);
?>
