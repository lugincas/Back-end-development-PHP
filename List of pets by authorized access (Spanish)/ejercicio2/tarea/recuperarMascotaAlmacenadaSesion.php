<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

// NOTA: No he utilizado $notifs[] ni $errors[] en este script, porque no me aparecía ninguna información que se puediera mostrar al usuario así

session_start(); // Comenzamos la sesión
if (!isset($_SESSION['mascota'])) { // Comprobamos si hay datos almacenados en la sesión. Si no es así, devolvemos un array vacío
        $mascota = [];
        
} else { // Si hay datos en la sesión, devolvemos un array con los datos almacenados
        $mascota['nombre'] = $_SESSION['mascota']['nombre'];
        $mascota['tipo'] = $_SESSION['mascota']['tipo'];
        $mascota['publica'] = $_SESSION['mascota']['publica'];
}

return $mascota;
