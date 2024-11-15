<?php
session_start();

$auth = $_SESSION['login'];
if(!$auth) {
    header('Location: /');
}

// Validar URL
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: /admin');
}

// Base de Datos
require '../../includes/configuracion/database.php';
$baseDatos = conectarDB();

// Otra consulta para obtener los datos del producto en la actualización
$consulta = "SELECT * FROM productos WHERE id = $id";
$resultado = mysqli_query($baseDatos, $consulta);
$producto = mysqli_fetch_assoc($resultado);

// Verificar si la conexión fue exitosa
if (!$baseDatos) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
    exit; // Salir del script si la conexión falla
}

// Mensajes de errores
$errores = [];

$nombre = $producto['nombre'];
$descripcion = $producto['descripcion'];
$imagenProducto = $producto['imagen'];
$precio = $producto['precio'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($baseDatos, $_POST['nombre']);
    $precio = mysqli_real_escape_string($baseDatos, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($baseDatos, $_POST['descripcion']);

    // Asignar las files a una variable
    $imagen = $_FILES['imagen'];

    // Validaciones
    if (!$nombre) {
        $errores[] = "Debes añadir un nombre";
    }
    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }
    if (!$descripcion) {
        $errores[] = "Debes añadir una descripción";
    }
    
    // Validar tamaño 100 kb como mucho
    $medidabits = 1000 * 1000;

    if ($imagen['size'] > $medidabits) {
        $errores[] = 'La imagen es muy pesada';
    }

    if (empty($errores)) {
        // Subir las imágenes

        // Crear carpeta donde se almacenan las nuevas imágenes
        $carpetaImagenes = '../../imagenes2/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreUnico = '';

        if ($imagen['name']) {
            // Eliminar la imagen previa
            unlink($carpetaImagenes . $producto['imagen']);

            // Generar nombre único
            $nombreUnico = md5(uniqid(rand(), true)) . ".jpg";
            
            // Subir las imágenes a la nueva carpeta creada
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreUnico); 
        } else {
            $nombreUnico = $producto['imagen'];
        }

        $query = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion'  imagen = '$nombreUnico', precio = '$precio', WHERE id = $id";
         
        $resultado = mysqli_query($baseDatos, $query);

        if ($resultado) {
            header('Location: /admin?resultado=2');
        }
    }
}

// Header
include '../../includes/templates/adminHeader.php';
?>

<main class="contenedor">
    <h1 class="centrar-texto">Actualizar Producto</h1>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>
    <!-- Mensajes de Errores -->
    <a href="/admin" class="boton-amarillo">Volver</a>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!-- Formulario -->
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" 
                name="nombre" 
                id="nombre" 
                placeholder="Nombre del Producto" 
                value="<?php echo $nombre; ?>">

                <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" 
                id="descripcion" 
                cols="30" 
                rows="10"><?php echo $descripcion; ?>
            </textarea>


            <label for="imagen">Imagen:</label>
            <input type="file" 
                name="imagen" 
                id="imagen" 
                accept="image/jpeg, image/png">
            <img src="/imagenes2/<?php echo $producto['imagen']; ?>" class="imagen-small">

            <label for="precio">Precio:</label>
            <input type="number" 
                name="precio" 
                id="precio"
                placeholder="Precio del Producto" 
                value="<?php echo $precio; ?>">

            

            
        </fieldset>

        <input type="submit" value="Actualizar Producto" class="boton">
    </form>
</main>

<!-- Footer -->
<?php
include '../../includes/templates/footer.php';
?>
