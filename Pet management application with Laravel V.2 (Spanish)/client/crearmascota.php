<?php

/* 
 * Luis Ginés Casanova de Utrilla
 * Desarrollo Web en Entorno Cliente - 2025 
 */

require 'vendor/autoload.php'; // Cargamos el autoload

use GuzzleHttp\Client;

session_start(); // Iniciamos la sesión

?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Crear mascotas</title>
    <link rel="stylesheet" type="text/css" href="./css/estilo.css" />
</head>
<?php

if (!isset($_SESSION['token'])) { // Si no hay un token registrado en la sesión, informamos al usuario de que no está autenticado y lo redirigimos al formulario de inicio de sesión

?>

    <body>
        <h2>¡No hay usuario autenticado!</h2>
        <a class="enlaceBoton" href="./login.php">Iniciar sesión</a>
    </body>

</html>

<?php

} else { // Si hay un token registrado en la sesión, realizamos nuestra solicitud para crear una nueva mascota

    $cliente = new Client( // Instanciamos un nuevo objeto Client
        [
            'http_errors' => false // Incluimos 'http_errors'=>false para indicar que no salte una excepción en caso de que el código de estado no sea 200, para así, poder tratar cada caso de forma adecuada.
        ]
    );

    /* Si no seleccionamos el tipo o la privacidad, la posición correspondiente del array POST no llega siquiera a definirse, con lo que a la hora de enviar los parámetros del formulario a nuestra ruta api, genera un error de "Undefined key array". Para ello, realizamos esta comprobación y, en caso de no haberse definido, la declaramos como null */
    if (!isset($_POST['tipo'])) {
        $_POST['tipo'] = null;
    }

    if (!isset($_POST['publica'])) {
        $_POST['publica'] = null;
    }


    $response = $cliente->post( // Realizamos nuestra solictud POST a la ruta API de nuestra aplicación para crear una nueva mascota con los datos que hemos obtenido del formulario ubicado en nuevamascota.html
        'http://127.0.0.1:8080/api/crearmascotaLCU',
        [
            'form_params' => [ // Enviamos en la solicitud los datos recibidos a través de nuestro formulario para  crear una nueva mascota con los mismos desde el cliente
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'tipo' => $_POST['tipo'],
                'publica' => $_POST['publica']
            ],
            'headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']] // Enviamos en la solicitud el token requerido para la autorización en una cabecera, para poder pasar el middleware necesario para acceder a la ruta
        ]
    );

    $codigoEstado = $response->getStatusCode(); // Almacenamos en una variable el código de estado recibido, resultado de nuestra solicitud

    $arrayRespuesta = json_decode($response->getBody(), true); // Almacenamos en una variable el array (añadiendo true como segundo parámetro) compuesto por la información recibida, resultado de nuestra solicitud. Como la información se halla en formato JSON, la convertimos a array con json_decode()


?>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Mascota añadida</title>
        <link rel="stylesheet" type="text/css" href="./css/estilo.css" />
    </head>

    <body>

        <?php

        if ($codigoEstado === 200) { // Si el código de estado es 200, informamos al usuario del éxito de la creación de la mascota. Mostramos el código de respuesta obtenido, el id de la mascota y mi nombre y apellidos. También habilitamos un enlace para añadir una mascota de nuevo
        ?>
            <h2 class="exito">¡Mascota añadida con éxito!</h2>
            <h3>Código de respuesta obtenido: <span class="exito"><?= $codigoEstado ?></span></h3>
            <h3>Id de la mascota: <span class="exito"><?= $arrayRespuesta['idMascotaNueva'] ?></span></h3>
            <h3>Nombre y apellidos del alumno: <span class="exito"><?= $arrayRespuesta['nombreApellidos'] ?></span></h3>
            <a class="enlaceBoton" href="./nuevamascota.html">¡Añadir otra mascota!</a>
            <br>
            <br>
        <?php

        } else {
            // Si el código de estado es cualquiera diferente de 200, informamos al usuario de que la creación de la mascota no se ha llevado a cabo con éxito. Mostramos el código de respuesta, los mensajes de error y habilitamos un enlace para intentarlo de nuevo
        ?>

            <h2 class="error">Ha ocurrido algún error...</h2>
            <h3>Código de respuesta obtenido: <span class="error"><?= $codigoEstado ?></span></h3>
            <h3>Errores: <span class="error">
                    <?php foreach ($arrayRespuesta['errores'] as $key => $value): ?>
                        <ul>
                            <li><?= implode($value) ?></li>
                        </ul>
                    <?php endforeach; ?>
                </span>
            </h3>
            <a class="enlaceBoton" href="./nuevamascota.html">¡Inténtalo de nuevo!</a>
            <br>
            <br>
        <?php

        }
        ?>
        <br>
        <a class="enlaceBoton" href="./mascotas.php">Ver listado de mascotas del usuario</a>
        <a class="enlaceBotonLogout" href="./logout.php">Cerrar sesión</a>
    </body>

    </html>
<?php

}
