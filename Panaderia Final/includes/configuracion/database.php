<?php

function conectarDB() : mysqli {
    $baseDatos = mysqli_connect('localhost', 'root', 'Rooot', 'panaderia');
   
    if (!$baseDatos) {
        echo "Error de conexion";
        exit;
    }

    return $baseDatos;
}