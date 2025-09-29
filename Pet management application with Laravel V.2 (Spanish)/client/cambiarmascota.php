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

    <title>Actualizar mascota</title>
    <link rel="stylesheet" type="text/css" href="./css/estilo.css" />
</head>

<?php

if (!isset($_SESSION['token'])) { // Si no hay un token registrado en la sesión, informamos al usuario de que no está autenticado y lo redirigimos al formulario de inicio de sesión
?>

    <body>
        <h2>¡No hay usuario autenticado!</h2>
        <a class="enlaceBoton" href="./login.php">Iniciar sesión</a>
    </body>

<?php

} else { // Si hay un token registrado en la sesión, desplegamos nuestro formulario de modificación de mascotas y posibilitamos la realización de nuestra solicitud
?>
    <body>
        <fieldset class="estiloFormulario">
            <form method="POST" action="cambiarmascota.php">
                <label class="tituloFormulario" for="idMascota">ID de la mascota a modificar</label><br/><br/>
                <input type='text' name='mascota'><br/><br/>
                <label for="descripcion">Nueva descripción</label>
                <br/><br/>
                <textarea name='descripcion' rows="5" cols="40" placeholder="Escribe aquí la descripción de tu mascota..."></textarea><br/>
                <hr>
                <label for="publica">¿Cambiar a pública?</label><br/><br/>
                <input type="radio" name="publica" value="Si" />Sí
                <input type="radio" name="publica" value="No" />No
                <br/>
                <br/>
                <input class="enlaceBoton" type='submit' value='¡Actualizar!'>
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

    if (isset($_POST['mascota'])) { // Controlamos que los datos de la solicitud sólo se esperen en caso de enviar el id de la mascota (Aunque enviemos el formulario vacío, también recibiremos los errores puesto que identificará que se está enviando una cadena de texto como id)

        /* Si no seleccionamos la privacidad, la posición correspondiente del array POST no llega siquiera a definirse, con lo que a la hora de enviar los parámetros del formulario a nuestra ruta api, genera un error de "Undefined key array". Para ello, realizamos esta comprobación y, en caso de no haberse definido, la declaramos como null */
        if (!isset($_POST['publica'])) {
            $_POST['publica'] = null;
        }

        $datosAEnviar = [ // Almacenamos en un array los datos recibidos por el formulario de modificación para enviarlos en la cabecera de nuestra solicitud. Estos tendrán la misma key que recibirá el controlador (si no, no funciona)
            'descripcion' => $_POST['descripcion'],
            'publica' => $_POST['publica'],
        ];

        $response = $cliente->put( // Realizamos nuestra solictud PUT a la ruta API de nuestra aplicación para modificar la mascota escogida con los datos que hemos obtenido del formulario de modificación
            'http://127.0.0.1:8080/api/mascotaLCU/' . $_POST['mascota'], // Añadimos como variable a la ruta PUT el id de la mascota recibido del formulario
            [
                'json' => $datosAEnviar, // De esta manera, realizamos la petición PUT enviando los datos en formato JSON
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

        if ($codigoEstado === 200) { // Si el código de estado es 200, informamos al usuario del éxito de la modificación de la mascota. Mostramos el código de respuesta obtenido y los nuevos datos si existen (ya que podrían ser los mismos y entonces no se envían)
        ?>
            <h2 class="exito">¡Mascota modificada con éxito!</h2>
            <h3>Código de respuesta obtenido: <span class="exito"><?= $codigoEstado ?></span></h3>
            <span class="exito"><?= $arrayRespuesta['mensaje'] ?></span>
            <?php
            
            if (isset($arrayRespuesta['datosModificados']['descripcion']) && isset($arrayRespuesta['datosModificados']['publica'])) {
            ?>
            <ul>
                <li>Nueva descripción: <span class="exito"><?= $arrayRespuesta['datosModificados']['descripcion'] ?></span></li>
                <li>¿Sigue siendo pública?: <span class="exito"><?= $arrayRespuesta['datosModificados']['publica'] ?></span></li>
            </ul>
                
            <?php
            }
            ?>
            
        <?php
        } else { // Si el código de estado es cualquiera diferente de 200, informamos al usuario de que la modificación de la mascota no se ha llevado a cabo con éxito. Mostramos el código de respuesta y los mensajes de error si los hubiera. Como el formulario se mantiene desplegado, puede intentarlo de nuevo

        ?>
            <h2 class="error">Ha ocurrido algún error...</h2>
            <h3>Código de respuesta obtenido: <span class="error"><?= $codigoEstado ?></span></h3>
            <?php
            if (isset($arrayRespuesta)) {
            ?>
                <h3>Errores: <span class="error"> <?= $arrayRespuesta['mensaje'] ?>
                        <?php
                        if (isset($arrayRespuesta['errores'])) {
                            foreach ($arrayRespuesta['errores'] as $key => $value): ?>
                                <ul>
                                    <li><?= implode($value) ?></li>
                                </ul>
                    <?php endforeach;
                        }
                    } ?>
                    </span>
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
