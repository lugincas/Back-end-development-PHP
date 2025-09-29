<?php

// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

session_start(); // Comenzamos la sesión
if (isset($_SESSION['usuario']) && isset($_SESSION['id_usuario'])) { // Si hay datos existentes en la sesión, los borramos y devolvemos un mensaje de confirmación
    unset($_SESSION['usuario']);
    unset($_SESSION['id_usuario']);
    $mensajeLogout = LOGOUT_OK;
} else { // Si no hay datos en la sesión, devolvemos el mensaje que lo indica
    $mensajeLogout = LOGOUT_ERR;
}

return $mensajeLogout; // Devolvemos un mensaje u otro según si había datos en la sesión o no
