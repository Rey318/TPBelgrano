<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    header('Location: /login.php');
    exit;
}

// Verificar si el usuario es cliente
if ($_SESSION['usuario']['tipo'] != 2) {
    header('Location: /admin/index.php'); // O redirige a una página de error.
    exit;
}
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require 'includes/configuracion/database.php';
$baseDatos = conectarDB();
$query = "SELECT * FROM productos";
$resultado = mysqli_query($baseDatos, $query);

// Obtener todos los productos en un array
$productos = [];
while ($producto = mysqli_fetch_assoc($resultado)) {
    $productos[] = $producto;
}

// Verificar si hay productos antes de seleccionar un producto aleatorio
if (count($productos) > 0) {
    // Seleccionar un producto random para su notificación
    $productoModal = $productos[array_rand($productos)];
    $promoRandomId = $productoModal['id_producto'];
} else {
    $promoRandomId = null; // En caso de que no haya productos
}

include './includes/templates/header.php';
?>

<!-- JavaScript para mostrar el modal aleatorio -->
<script>
/*  Verificar si promoRandomId tiene un valor válido antes de usarlo en el selector */
var promoRandomId = <?php echo $promoRandomId ? "'#modal-" . $promoRandomId . "'" : "null"; ?>;

document.addEventListener("DOMContentLoaded", function() {
    // Asegurarse de que promoRandomId no sea null antes de intentar buscar el modal
    if (promoRandomId) {
        // Verificar si el modal existe antes de mostrarlo
        var promoModalElement = document.querySelector(promoRandomId);

        if (promoModalElement) {
            var promoModal = new bootstrap.Modal(promoModalElement);
            promoModal.show();  // Mostrar el modal aleatorio
        }
    }
});
</script>




<main class="contenedor-anuncios">
    <div class="container">
        <div class="row">
            <!-- Mostrar productos utilizando el array $productos -->
            <?php foreach ($productos as $producto) : ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img loading="lazy" src="imagenes2/<?php echo $producto['imagen']; ?>" class="card-img-top fixed-img" alt="imagen de la propiedad">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                            <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                            <p class="precio">$<?php echo $producto['precio']; ?></p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $producto['id_producto']; ?>">
                                Comprar
                            </button>
                        </div>
                    </div>
                </div>

                
                <!-- Modal para cada producto -->
<div class="modal fade" id="modal-<?php echo $producto['id_producto']; ?>" tabindex="-1" aria-labelledby="modalLabel-<?php echo $producto['id_producto']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Modificado para centrar el modal y hacerlo más grande -->
        <div class="modal-content">
            <div class="modal-header bg-success text-white"> <!-- Cambié el color de fondo de la cabecera -->
                <h5 class="modal-title" id="modalLabel-<?php echo $producto['id_producto']; ?>">¡Promoción Especial!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center"> <!-- Centré el texto del cuerpo -->
                <h4 class="text-primary">¡Compra con descuento!</h4>
                <p>Obtén un descuento del 20% en tu primer pedido. ¡No te lo pierdas!</p>
                <p><strong>Producto:</strong> <?php echo $producto['nombre']; ?></p>
                <p><strong>Precio Original:</strong> $<?php echo $producto['precio']; ?></p>
                <p><strong>Precio con Descuento:</strong> $<?php echo $producto['precio'] * 0.8; ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="descontarProducto(<?php echo $producto['id_producto']; ?>)">¡Ordena ahora!</button>
            </div>
        </div>
    </div>
</div>

            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include './includes/templates/footer.php'; ?>
