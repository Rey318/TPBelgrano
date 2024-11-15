<?php



verificarAutenticacion();
session_start();

/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

// Función para verificar la autenticación del usuario
function verificarAutenticacion()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? null;
    $usuario = $_SESSION['usuario'] ?? null; // Verifica si 'usuario' está configurado

    // Verificar si $usuario es un array y si existe 'tipo'
    if (!$auth || !is_array($usuario) || !isset($usuario['tipo']) || $usuario['tipo'] != 1) {
        header('Location: /index.php');
        exit();
    }
}


// Importar la conexión a la base de datos
require '../includes/configuracion/database.php';
$baseDatos = conectarDB();

// Consulta para obtener productos
$query = "SELECT * FROM productos";
$resultadoConsulta = mysqli_query($baseDatos, $query);

// Mensaje condicional
$resultado = $_GET['resultado'] ?? null;

// Manejo del formulario de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($id) {
        // Obtener la imagen para eliminarla
        $query = "SELECT imagen FROM productos WHERE id_producto = $id"; // Asegúrate de usar el nombre de columna correcto

        $resultado = mysqli_query($baseDatos, $query);

        $imagePath = 'imagenes/taza.png';
        if (file_exists($imagePath)) {
            echo '<img src="' . $imagePath . '" alt="Taza">';
        } else {
            echo '<img src="imagenes/default.png" alt="Imagen no disponible">';
        }



        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $producto = mysqli_fetch_assoc($resultado);
            unlink('../imagenes2' . $producto['imagen']); // Verifica que la ruta sea correcta

            // Eliminar el producto
            $query = "DELETE FROM productos WHERE id_producto = $id";
            $resultado = mysqli_query($baseDatos, $query);

            if ($resultado) {
                header('Location: /admin?resultado=3');
                exit();
            } else {
                header('Location: /index.php');
                exit();
            }
        } else {
            header('Location: /admin/pan/info.php'); // Maneja error si no se encuentra el producto
            exit();
        }
    }
}



// Incluir la plantilla de encabezado
include '../includes/templates/adminHeader.php'; // Ajusta la ruta si es necesario
?>

<main class="contenedor">
    <h1 class="centrar-texto">Administrador de Panadería</h1>
    <?php if ($resultado == 1) : ?>
        <p class="alerta exito">Publicación creada correctamente</p>
    <?php elseif ($resultado == 2) : ?>
        <p class="alerta exito">Publicación Actualizada Correctamente</p>
    <?php elseif ($resultado == 3) : ?>
        <p class="alerta error">Publicación Eliminada Correctamente</p>
    <?php endif; ?>
    <div class="container d-flex justify-content-between mt-4">
    <a href="/admin/pan/crear.php" class="btn btn-primary btn-lg me-3 shadow-sm">Agregar Producto</a>
    <a href="/admin/pan/info.php" class="btn btn-outline-primary btn-lg shadow-sm">Mostrar Producto</a>
</div>



    <table class="productosAgregados">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($producto = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                    <td>
                        <img src="/imagenes2/<?php echo htmlspecialchars($producto['imagen']); ?>" style="max-width: 100px; max-height: 100px;">
                    </td>
                    <td>$ <?php echo htmlspecialchars($producto['precio']); ?></td>
                    <td>
                        <form method="POST" onsubmit="mostrarModalConfirmacion(event)">
                            <a class="btnActualizar" href="/admin/pan/actualizar.php?id=<?php echo htmlspecialchars($producto['id_producto']); ?>">Actualizar</a>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">
                            <input class="btnAccion btnEliminar" type="submit" value="Eliminar">
                        </form>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
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

<script>
function mostrarModalConfirmacion(event) {
    event.preventDefault(); // Evita el envío automático del formulario
    const modal = document.getElementById("modalConfirmacion");
    modal.style.display = "flex"; // Muestra el modal

    // Botón "Sí, eliminar"
    document.getElementById("confirmar").onclick = function() {
        event.target.submit(); // Envía el formulario si el usuario confirma
        modal.style.display = "none"; // Oculta el modal
    };

    // Botón "Cancelar"
    document.getElementById("cancelar").onclick = function() {
        modal.style.display = "none"; // Oculta el modal
    };
}
</script>





<?php
// Cerrar la conexión a la base de datos
mysqli_close($baseDatos);

// Incluir la plantilla de pie de página
include '../includes/templates/footer.php'; // Ajusta la ruta si es necesario
?>