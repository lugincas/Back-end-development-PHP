<?php

/* 
 * Luis Ginés Casanova de Utrilla
 * Desarrollo Web en Entorno Cliente - 2025 
 */

require 'vendor/autoload.php'; // Cargamos el autoload

use GuzzleHttp\Client; // Iniciamos la sesión

session_start(); // Iniciamos la sesión
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/estilo.css" />
    <title>Finalizar sesión</title>
</head>
<?php
if (!isset($_SESSION['token'])) { // Si no hay un token registrado en la sesión, informamos al usuario de que no hay ningún usuario autenticado y lo redirigimos al formulario de inicio de sesión
?>

    <body>
        <h2>¡No hay usuario autenticado!</h2>
        <a class="enlaceBoton" href="./login.php">Iniciar sesión</a>
    </body>

<?php
} else { // Si hay un token registrado en la sesión, posibilitamos al usuario realizar la solicitud pertinente para abandonar la sesión activa

    $cliente = new Client( // Instanciamos un nuevo objeto Client
        [
            'http_errors' => false // Incluimos 'http_errors'=>false para indicar que no salte una excepción en caso de que el código de estado no sea 200, para así, poder tratar cada caso de forma adecuada.
        ]
    );

    $response = $cliente->post( // Realizamos nuestra solictud POST a la ruta API de nuestra aplicación relacionada con la finalización de la sesión
        'http://127.0.0.1:8080/api/logout',
        [
            'headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']] // Enviamos en la solicitud el token requerido para la autorización en una cabecera, para poder pasar el middleware necesario para acceder a la ruta
        ]
    );

    $codigoEstado = $response->getStatusCode(); // Almacenamos en una variable el código de estado recibido, resultado de nuestra solicitud
    $arrayRespuesta = json_decode($response->getBody(), true); // Almacenamos en una variable el array (añadiendo true como segundo parámetro) compuesto por la información recibida, resultado de nuestra solicitud. Como la información se halla en formato JSON, la convertimos a array con json_decode()
    
    unset($_SESSION['token']); // Eliminamos el token de la sesión

?>

    <body> <!-- Informamos al usuario de que la sesión ha finalizado con éxito -->
        <h2 class="exito">¡Hasta pronto!</h2>
        <!-- Mostramos el código de respuesta y los mensajes -->
        <h3>Código de respuesta obtenido: <span class="exito"><?= $codigoEstado ?></span></h3>
        <h3 class="exito"><?= $arrayRespuesta['mensaje'] ?></h3> 
        <br>
        <a class="enlaceBoton" href="./login.php">Volver a iniciar sesión</a>
    </body>

<?php
}
?>

</html>