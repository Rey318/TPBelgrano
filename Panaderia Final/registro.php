<?php 


// Conexion 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Datos de conexión
    $nombreServidor = "localhost";
    $usuario = "root";
    $password = "Rooot";
    $dataBase = "panaderia";

    // Variable que almacena nuestros datos de conexión
    $conexion = new mysqli($nombreServidor, $usuario, $password, $dataBase);

    // Validación por si falla la base de datos que no continúe la inserción
    if ($conexion->connect_error) {
        die("Fallo la conexión: " . $conexion->connect_error);
    }

    // Recuperar los datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $password = $_POST["password"];

    try {
        // Validación de campos obligatorios
        if (empty($nombre) || empty($email) || empty($telefono)) {
            
            echo "Todos los campos son obligatorios";

        } else {
            
            // Validación del formato del correo electrónico
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "El formato del correo electrónico no es válido.";
            } else {
                
                // Crear la consulta preparada para prevenir inyección SQL
                $stmt = $conexion->prepare("INSERT INTO clientes (nombre, email, telefono, password) VALUES (?, ?, ?, ?)");
                
                $stmt->bind_param("ssss", $nombre, $email, $telefono, $password);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Registro exitoso, redirigir
                    sleep(rand(2, 4));
                    header("Location: productos.php");

                    exit(); 
                    
                } else {

                    // Error en la base de datos
                    echo "Error en la base de datos: " . $stmt->error;
                }

                // Cerrar la consulta preparada
                $stmt->close();
                
            }
        }
    } catch (\Exception $e) {
        // Manejar otras excepciones si es necesario
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conexion->close();
    }
}


include 'includes/templates/header.php';
?>


<form action="registro.php" class="formulario" method="post">
    
    <fieldset>
        <legend>Información Personal</legend>

        <label for="nombre">Nombre</label>
        <input type="text" placeholder="Tu Nombre" name="nombre" id="nombre" pattern="[a-zA-Z' ]+" required>

        <label for="email">E-mail</label>
        <input type="email" placeholder="Tu Email" name="email" id="email">

        <label for="telefono">Teléfono</label>
        <input type="tel" placeholder="Tu Teléfono" name="telefono" pattern="\+?[0-9]{1,4}?[-.\s]?([0-9]{3})[-.\s]?([0-9]{3})[-.\s]?([0-9]{4})" required id="telefono">
         
        <label for="password">Contraseña</label>
        <input type="password" placeholder="Tu password" name="password" id="password">
        <div class="formulario-boton">
        <button class="boton-amarillo" type="submit" name="enviar" id="enviar">Enviar</button>
        </div>
        
    </fieldset>
    
</form>



<?php  
include 'includes/templates/footer.php';
?>