<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

session_start(); // Comenzamos la sesión
if (!isset($_SESSION['mascota'])) { // Comprobamos si hay datos almacenados en la sesión. Si no es así, devolvemos un array vacío

    $resultadoDelete = NOT_IN_SESSION;
    $notifs[] = 'No había datos almacenados en la sesión.';
} else { // Si hay datos en la sesión, los borramos

    unset($_SESSION['mascota']);
    $resultadoDelete = DELETED_FROM_SESSION;
    $notifs[] = 'Datos de la mascota borrados de la sesión.';
}

return $resultadoDelete; // Devolvemos el resultado de la operación de borrado
