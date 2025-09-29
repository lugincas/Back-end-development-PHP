<?php

// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

session_start(); // Comenzamos la sesión
if (
    isset($_POST['nombre']) && isset($_POST['tipo']) && isset($_POST['publica'])
    && !empty($_POST['nombre']) && strlen($_POST['nombre']) < 50 && preg_match('/^[a-zA-Z]+$/', $_POST['nombre']) && $_POST['publica'] !== 'err'
) { // Comprobamos que los datos introducidos sean correctos, con nombres admitidos y publicación válida

    $mascotaSesion['nombre'] = htmlspecialchars(trim(filter_input(INPUT_POST, 'nombre'))); // Saneamos los datos introducidos por el formulario
    $mascotaSesion['tipo'] = $_POST['tipo'];
    $mascotaSesion['publica'] = $_POST['publica'];

    if (!isset($_SESSION['mascota'])) { // Si no hay datos almacenados en la sesión, se almacenan los datos introducidos

        $_SESSION['mascota'] = $mascotaSesion;
        $resultadoSesion = SAVED_IN_SESSION;
        $notifs[] = 'Se han guardado los datos de la mascota por primera vez.';
    } else { // Si ya había datos almacenados en la sesión, se actualizan los datos introducidos

        $_SESSION['mascota'] = $mascotaSesion;
        $resultadoSesion = UPDATED_IN_SESSION;
        $notifs[] = 'Se han actualizado los datos de la mascota.';
    }
} else { // Si los datos introducidos no son válidos, se devuelve un error
    $resultadoSesion = ERROR_IN_FORM;
    $errors[] = 'Los datos introducidos no son válidos.';
}

return $resultadoSesion; // Devolvemos el resultado del procesamiento del formulario
