<?php
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
session_start();


 $auth = $_SESSION['login'];
if(!$auth) {
   header('Location: /index.php');
} 
/*  echo "<pre>";
    var_dump($auth);
echo "</pre>";  */
 


require '../../includes/configuracion/database.php';
$baseDatos = conectarDB();

$consulta = "SELECT * FROM productos";
//Consultar toda la conexion
$resultadoConsulta = mysqli_query($baseDatos, $consulta);


include '../../includes/templates/adminHeader.php';
?>

<h1 class=" seccion-oscura centrar-texto">Estado actual de productos</h1>
<div class="contenedor">
<a href="/admin" class="btn btn-secondary w-100">Volver</a>
    <main >
        <table class="productosAgregados">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    
                </tr>
            </thead>
            <tbody >
                <?php while( $pers = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr class="tr">
                    <td class="tbody"><?php echo $pers['id_producto']; ?></td>
                    <td class="tbody"><?php echo $pers['nombre']; ?></td>
                    <td class="tbody"><?php echo $pers['descripcion']; ?></td>
                    <td class="tbody"><?php echo $pers['precio']; ?></td>
                    <td class="tbody"><?php echo $pers['cantidad']; ?></td>
                    <td>
                        <img src="../../imagenes2 <?php echo htmlspecialchars($pers['imagen']); ?>" >
                    </td>
                </tr>

                <?php endwhile; ?>
            </tbody>


        </table>

    </main>
</div>


<?php

include '../../includes/templates/footer.php';
?>