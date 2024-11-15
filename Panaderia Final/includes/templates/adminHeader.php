<?php
if (!isset($_SESSION)) {
    session_start();
}
$auth = $_SESSION['login'] ?? null;

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Metadatos -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="MOVH">
    <meta name="description" content="Panaderia de MOVH">
    <meta name="keywords" content="HTML, CSS, JavaScript">

    <!-- Titulo -->
    <title>Panaderia | Practica Profesionalizante</title>

    <!-- Favicon -->
    <!-- <link rel="icon" href="../../imagenes/taza.png" type="image/x-icon"> -->
    <!-- Iconos bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--Bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="../../estilos/style.css">
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik+Dirt&family=Share:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
</head>

<body>
<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
?>
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-toggler"
                aria-controls="navbar-toggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-toggler">
                <a class="navbar-brand" href="#">
                    <img src="../../imagenes/taza.png" alt="icono empresa" width="50">
                </a>
                <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-navpills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
                    <!-- <li class="nav-item">
                        <a class="nav-link " href="#">Nosotros</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="/productos.php">Productos</a>
                    </li> -->
                    
                    <li class="nav-item">
                        <a class="nav-link" href="../../admin/pan/info.php">Información</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded-5" id="contact-tab2" role="tab" aria-selected="false" href="/logout.php">Cerrar Sesion</a>
                    </li>

                    <?php if (!$auth) : ?>
                    
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>