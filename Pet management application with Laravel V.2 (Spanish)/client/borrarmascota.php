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

    <title>Eliminar mascota</title>
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

} else { // Si hay un token registrado en la sesión, desplegamos nuestro formulario de eliminación de mascotas y posibilitamos la realización de nuestra solicitud
?>

    <body>
        <fieldset class="estiloFormulario" id="formularioEliminar">
            <form method="POST" action="borrarmascota.php">
                <label class="tituloFormulario" for="idMascota">ID de la mascota a eliminar</label><br /><br />
                <input type='text' name='idMascota'><br /><br />
                <input class="enlaceBotonEliminar" type='submit' value='Eliminar'>
            </form>
        </fieldset>
    </body>

    </html>

    <?php
    $cliente = new Client( // Instanciamos un nuevo objeto Client
        [
            'http_errors' => false // Incluimos 'http_errors'=>false para indicar que no salte una excepción en caso de que el código de estado no sea 200, para así, poder tratar cada caso de forma adecuada.
        ]
    );
    if (isset($_POST['idMascota'])) { // Controlamos que los datos de la solicitud sólo se esperen en caso de enviar el id de la mascota (Aunque envíemos el formulario vacío, también recibiremos los errores puesto que identificará que se está enviando una cadena de texto como id)

        $response = $cliente->delete( // Realizamos nuestra solictud DELETE a la ruta API de nuestra aplicación para borrar la mascota escogida con los datos que hemos obtenido del formulario de eliminación
            'http://127.0.0.1:8080/api/mascotaLCU/' . $_POST['idMascota'], // Añadimos como variable a la ruta DELETE el id de la mascota recibido del formulario
            [
                'headers' => ['Authorization' => 'Bearer ' . $_SESSION['token']] // Enviamos en la solicitud el token requerido para la autorización en una cabecera, para poder pasar el middleware necesario para acceder a la ruta
            ]
        );

        $codigoEstado = $response->getStatusCode(); // Almacenamos en una variable el código de estado recibido, resultado de nuestra solicitud

        $arrayRespuesta = json_decode($response->getBody(), true); // Almacenamos en una variable el array (añadiendo true como segundo parámetro) compuesto por la información recibida, resultado de nuestra solicitud. Como la información se halla en formato JSON, la convertimos a array con json_decode()

    ?>

        <body>

            <?php

            if ($codigoEstado === 200) { // Si el código de estado es 200, informamos al usuario del éxito de la eliminación de la mascota. Mostramos el código de respuesta obtenido y el mensaje correspondiente
            ?>
                <h2 class="exito">¡Mascota eliminada con éxito!</h2>
                <h3>Código de respuesta obtenido: <span class="exito"><?= $codigoEstado ?></span></h3>
                <span class="exito"><?= $arrayRespuesta['mensaje'] ?></span>
                <br>
            <?php
            } else { // Si el código de estado es cualquiera diferente de 200, informamos al usuario de que la eliminación de la mascota no se ha llevado a cabo con éxito. Mostramos el código de respuesta y los mensajes de error si los hubiera. Como el formulario se mantiene desplegado, puede intentarlo de nuevo

            ?>
                <h2 class="error">Ha ocurrido algún error...</h2>
                <h3>Código de respuesta obtenido: <span class="error"><?= $codigoEstado ?></span></h3>
                <?php
                if (isset($arrayRespuesta)) {
                ?>
                    <h3>Errores: <span class="error"><?= $arrayRespuesta['mensaje'] ?></span>
                    <?php
                } ?>
                    </h3>

            <?php

            }
        }
            ?>
            <br>

            <a class="enlaceBoton" href="./mascotas.php">Volver al listado de mascotas del usuario</a>
        </body>

        </html>

    <?php
}
