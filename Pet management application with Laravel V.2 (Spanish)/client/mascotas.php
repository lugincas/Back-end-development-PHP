<?php

/* 
 * Luis Ginés Casanova de Utrilla
 * Desarrollo Web en Entorno Cliente - 2025 
 */

require 'vendor/autoload.php'; // Cargamos el autoload

use GuzzleHttp\Client;

session_start(); // Iniciamos la sesión

if (!isset($_SESSION['token'])) { // Si no hay un token registrado en la sesión, informamos al usuario de que no está autenticado y lo redirigimos al formulario de inicio de sesión
?>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Listado de mascotas</title>
        <link rel="stylesheet" type="text/css" href="./css/estilo.css"/>
    </head>

    <body>
        <h2>¡No hay usuario autenticado!</h2>
        <a class="enlaceBoton" href="./login.php">Iniciar sesión</a>
    </body>

    </html>

<?php

} else { // Si hay un token registrado en la sesión, realizamos nuestra solicitud para obtener la lista de mascotas

    $cliente = new Client( // Instanciamos un nuevo objeto Client
        [
            'http_errors' => false // Incluimos 'http_errors'=>false para indicar que no salte una excepción en caso de que el código de estado no sea 200, para así, poder tratar cada caso de forma adecuada.
        ]
    );

    $response = $cliente->get( // Realizamos nuestra solictud GET a la ruta API de nuestra aplicación para obtener un listado de mascotas
        'http://127.0.0.1:8080/api/mascotasLCU',
        [
            'headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']] // Enviamos en la solicitud el token requerido para la autorización en una cabecera, para poder pasar el middleware necesario para acceder a la ruta
        ]
    );

    $arrayRespuesta = json_decode($response->getBody(), true); // Almacenamos en una variable el array (añadiendo true como segundo parámetro) compuesto por la información recibida, resultado de nuestra solicitud. Como la información se halla en formato JSON, la convertimos a array con json_decode()
    
    ?>

    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Listado de mascotas</title>
        <link rel="stylesheet" type="text/css" href="./css/estilo.css"/>
    </head>

    <body>
    <h2>Listado de mascotas del usuario autenticado:</h2>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Tipo</th>
                <th>¿Pública?</th>
                <th>#MeGusta</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($arrayRespuesta as $key => $value):?> <!-- Desplegamos un listado con las mascotas recibidas en el array de respuesta que hemos obtenido al realizar nuestra solicitud -->
            <tr>
                <td><?=$value['id']?></td>
                <td><?=$value['nombre']?></td>
                <td><?=$value['descripcion']?></td>
                <td><?=$value['tipo']?></td>
                <td><?=$value['publica']?></td>
                <td><?=$value['megusta']?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a class="enlaceBoton" href="./nuevamascota.html">¡Añade una mascota nueva!</a>
    <a class="enlaceBoton" href="./cambiarmascota.php">Modificar una mascota</a>
    <a class="enlaceBotonEliminar" href="./borrarmascota.php">Borrar una mascota</a>
    <br>
    <br>
    <br>
    <a class="enlaceBotonLogout" href="./logout.php">Cerrar sesión</a>
    </body>

    </html>

<?php

}
