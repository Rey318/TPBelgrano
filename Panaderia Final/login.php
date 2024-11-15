<?php
session_start();

require 'includes/configuracion/database.php';
$baseDatos = conectarDB();

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($baseDatos, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = mysqli_real_escape_string($baseDatos, filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS));

    //Validaciones
    if (!$email) {
        $errores[] = "El correo es obligatorio";
    }
    if (!$password) {
        $errores[] = "El password es obligatorio";
    }

    if (empty($errores)) {
        // Usar prepared statement para prevenir inyecciones SQL
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($baseDatos, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        // Comprobar los resultados
        if ($resultado->num_rows) {
            $usuario = mysqli_fetch_assoc($resultado);

            // Verificar contraseña
            $auth = password_verify($password, $usuario['password']);

            if ($auth) {
                // Usuario autenticado
                $_SESSION['usuario'] = [
                    'email' => $usuario['email'],
                    'tipo' => $usuario['tipo']
                ];
                $_SESSION['login'] = true;

                // Verificar tipo de usuario
                if ($usuario['tipo'] == 1) {
                    header('Location: /admin/index.php');
                    exit;
                } else {
                    header('Location: /productos.php');
                    exit;
                }
            } else {
                $errores[] = "El password es incorrecto";
            }
        } else {
            $errores[] = "El usuario no existe";
        }

        // Cerrar statement
        mysqli_stmt_close($stmt);
    }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('imagenes/premium_photo-1665669263531-cdcbe18e7fe4.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="titulo">Login de Usuarios</h2>
        
        <!-- Mostrar el error si existe -->
        
<?php if (!empty($errores)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($errores as $error) : ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


        <!-- Formulario de login -->
        <form action="login.php" method="post" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email o Usuario</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" pattern="[a-zA-Z' ]+" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
        
        <!-- Botón de registro -->
        <div class="mt-3">
            <a href="registro.php" class="btn btn-secondary w-100">Registrar Usuario</a>
        </div>
    </div>
</body>

</html>
