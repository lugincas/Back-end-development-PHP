<?php

/* 
 * Luis Ginés Casanova de Utrilla
 * Desarrollo Web en Entorno Cliente - 2025 
 */

require 'vendor/autoload.php'; // Cargamos el autoload

use GuzzleHttp\Client;

session_start(); // Iniciamos la sesión

if (!isset($_SESSION['token'])) { // Si no hay un token registrado en la sesión, desplegamos el formulario de inicio de sesión

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/estilo.css" />
        <title>Formulario de Inicio de Sesión</title>
    </head>

    <body>
        <fieldset class="estiloLogin">
            <form method="POST" action="login.php">
                <label for="email">Correo Electrónico</label>
                <br>
                <input type="email" id="email" name="email">
                <hr>
                <label for="password">Contraseña</label>
                <br>
                <input type="password" id="password" name="password">
                <hr>
                <input class="enlaceBoton" type="submit" value="Login">
            </form>
        </fieldset>

        <?php
        if (isset($_POST["email"]) && isset($_POST["password"])) { // Si recibimos los datos del formulario, podemos realizar nuestra solicitud

            $cliente = new Client( // Instanciamos un nuevo objeto Client
                [
                    'http_errors' => false // Incluimos 'http_errors'=>false para indicar que no salte una excepción en caso de que el código de estado no sea 200, para así, poder tratar cada caso de forma adecuada.
                ]
            );

            $response = $cliente->post( // Realizamos nuestra solictud POST a la ruta API de nuestra aplicación relacionada con el inicio de sesión
                'http://127.0.0.1:8080/api/login',
                [
                    'form_params' => [ // Enviamos en la solicitud los datos recibidos a través de nuestro formulario para iniciar sesión desde nuestro cliente
                        'email' => $_POST["email"],
                        'password' => $_POST["password"]
                    ]
                ]
            );

            $codigoEstado = $response->getStatusCode(); // Almacenamos en una variable el código de estado recibido, resultado de nuestra solicitud
            $arrayRespuesta = json_decode($response->getBody(), true); // Almacenamos en una variable el array (añadiendo true como segundo parámetro) compuesto por la información recibida, resultado de nuestra solicitud. Como la información se halla en formato JSON, la convertimos a array con json_decode()

            if ($codigoEstado === 200) { // Si el código de estado es 200, almacenamos el token recibido en la sesión e informamos al usuario del éxito de la autenticación
                $_SESSION['token'] = $arrayRespuesta['token'];
        ?>
                <h2>¡Usuario autenticado correctamente!</h2>
                <h3>Código de respuesta obtenido: <span class="exito"><?= $codigoEstado ?></span></h3> <!-- Mostramos el código de respuesta -->
                <a class="enlaceBoton" href="./mascotas.php">Ver listado de mascotas del usuario</a>
                <a class="enlaceBotonLogout" href="./logout.php">Cerrar sesión</a>
            <?php

            } else { // Si el código de estado es cualquiera diferente de 200, no almacenamos nada en la sesión e informamos al usuario de que la autenticación no se ha llevado a cabo con éxito. Como el formulario sigue desplegado, puede intentarlo de nuevo sin problema

            ?>
                <h2 class="error">Ha ocurrido algún error...</h2>
                <h3>Código de respuesta obtenido: <span class="error"><?= $codigoEstado ?></span></h3> <!-- Mostramos el código de respuesta -->
                <?php
                if (isset($arrayRespuesta)) { // Si existe algún mensaje almacenado en nuestro array, lo mostramos también
                ?>
                    <h3 class="error"><?= $arrayRespuesta['mensaje'] ?></h3>
        <?php
                }
            }
        }
        ?>
    </body>

    </html>
<?php
} else { // Si ya hay un token registrado en la sesión, lanzamos un mensaje recordando que el usuario ya está autenticado

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/estilo.css" />
        <title>Formulario de Inicio de Sesión</title>
    </head>

    <body>
        <h2>¡Este usuario ya está autenticado!</h2>
        <a class="enlaceBoton" href="./mascotas.php">Ver listado de mascotas del usuario</a>
        <a class="enlaceBotonLogout" href="./logout.php">Cerrar sesión</a>
    </body>

    </html>

<?php
}
