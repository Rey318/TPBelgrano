<?php

session_start();

$auth = $_SESSION['login'];
if (!$auth) {
    header('Location: /');
}

// Base de Datos
require '../../includes/configuracion/database.php';
$baseDatos = conectarDB();

// Verificar si la conexión fue exitosa
if (!$baseDatos) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
    exit; // Salir del script si la conexión falla
}

// Mensajes de errores
$errores = [];

$nombre = '';
$descripcion = '';
$precio = '';
$cantidad = '';
$imagen = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = mysqli_real_escape_string($baseDatos, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($baseDatos, $_POST['descripcion']);
    $precio = mysqli_real_escape_string($baseDatos, $_POST['precio']);    
    $cantidad = mysqli_real_escape_string($baseDatos, $_POST['cantidad']);


    // Asignar las files a una variable
    $imagen = $_FILES['imagen'];

    // Validaciones
    if (!$nombre) {
        $errores[] = "Debes añadir un nombre";
    }
    if (!$descripcion) {
        $errores[] = "Debes añadir una descripción";
    }
    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }
    if (!$imagen['name']) {
        $errores[] = "Debes añadir una imagen";
    }
    if (!$cantidad) {
        $errores[] = "Debes añadir la cantidad";
    }

    // Validar tamaño 100 kb como mucho
    $medidabits = 1000 * 1000; // 1 MB
    if ($imagen['size'] > $medidabits) {
        $errores[] = 'La imagen es muy pesada';
    }

    if (empty($errores)) {
        // Crear carpeta donde se almacenan las nuevas imágenes
        $carpetaImagenes = '../../imagenes2/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        // Generar nombre único
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        // Subir las imágenes a la nueva carpeta creada
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

        $query = "INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen ) VALUES ('$nombre', '$descripcion', '$precio', '$cantidad', '$nombreImagen')";

        $resultado = mysqli_query($baseDatos, $query);

        if ($resultado) {
            header('Location: /admin?resultado=1');
        }
    }
}

/* echo $query; */

// Header
include '../../includes/templates/adminHeader.php';
?>

<main class="contenedor">
    <h1 class="centrar-texto">Crear Producto</h1>
    
    <!-- Boton volver -->
    <a href="/admin" class="btn btn-secondary w-100">Volver</a>
    <!-- Mensajes de Errores -->
    
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!-- Formulario -->
    <form class="formulario" method="POST" action="/admin/pan/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Datos del producto</legend>

            <label for="nombre">Nombre:</label>
            <input type="text"
                name="nombre"
                id="nombre"
                placeholder="Nombre del Producto"
                value="<?php echo $nombre; ?>">

            <label for="precio">Precio:</label>
            <input type="number"
                name="precio"
                id="precio"
                placeholder="Precio del Producto"
                value="<?php echo $precio; ?>">
            <label for="cantidad">Cantidad:</label>
            <input type="number"
                name="cantidad"
                id="cantidad"
                placeholder="Cantidad del Producto"
                value="<?php echo $cantidad; ?>">


            <label for="imagen">Imagen:</label>
            <input type="file"
                name="imagen"
                id="imagen"
                accept="image/jpeg, image/png">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>

        <input type="submit" value="Crear Producto" class="btn btn-secondary w-100 margen-boton">
    </form>
</main>

<!-- Modal de confirmación -->
<div id="modalConfirmacion" class="modal">
    <div class="modal-contenido">
        <p>¿Estás seguro de que deseas eliminar este producto?</p>
        <button id="confirmar" class="btnModal">Sí, eliminar</button>
        <button id="cancelar" class="btnModal">Cancelar</button>
    </div>
</div>

<style>
.modal {
    display: none; /* Oculto por defecto */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}
.modal-contenido {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    max-width: 300px;
}
.btnModal {
    margin: 10px;
    padding: 10px 20px;
    cursor: pointer;
}
</style>

<!-- Footer -->
<?php
include '../../includes/templates/footer.php';
?>