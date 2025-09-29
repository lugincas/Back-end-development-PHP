<?php

// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

try{
    $con = conectar(); // Conectamos a la base de datos
} catch (PDOException $e) {
    $errors[] = "Error en la conexión a la base de datos.";
    $errors[] = $e->getMessage();
    $resultadoLogin = LOGIN_FAIL_DB; // En caso de error, devolvemos el mensaje pertinente
}

if (isset($_POST['login']) && isset($_POST['contraseña']) && (!empty($_POST['login'])
    && !empty($_POST['contraseña']))) { // Comprobamos si los datos introducidos a través del formulario son correctos. Si lo son, procedemos a intentar autenticar al usuario
    $usuario = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Saneamos los datos introducidos y los almacenamos en una variable
    $password = filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $logeo = logear($con, $usuario, $password); // Utilizamos la función logear creada en el script "funcionlogin.php" con los datos que hemos introducido en el formulario

    if ($logeo) { // Si la autenticación es correcta (id de usuario no es falso), procedemos a guardar los datos del usuario en la sesión
        session_start(); // Comenzamos la sesión
        if (isset($_SESSION['usuario']) && isset($_SESSION['id_usuario'])) { // Si ya existe un usuario en la sesión, devolvemos un mensaje notificando que ese usuario ya está autenticado
            $notifs[] = "El usuario $_SESSION[usuario] ya está autenticado.";
            $notifs[] = "Su último acceso fue hace " . (time() - $_SESSION['ultimo_acceso']) . " segundos.";
            $resultadoLogin = LOGIN_PREV; // Devolvemos el mensaje que informa de que ya hay un login activo
        } else { // Si no existe un usuario en la sesión, procedemos a guardar los datos del usuario en la sesión
            $_SESSION['usuario'] = $usuario; // Guardamos el usuario autenticado
            $_SESSION['id_usuario'] = $logeo; // Guardamos su id de usuario
            $_SESSION['ultimo_acceso'] = time(); // Guardamos el momento del acceso

            $notifs[] = "Usuario $usuario autenticado correctamente."; // Notificamos al usuario que se ha autenticado correctamente
            $resultadoLogin = LOGIN_OK; // Devolvemos el mensaje de confirmación de autenticación correcta
        }
    } else { // Si la autenticación no es correcta, procedemos a notificar al usuario
        $errors[] = "Usuario o contraseña incorrectos.";
        $resultadoLogin = LOGIN_ERR; // Devolvemos el mensaje de error de autenticación incorrecta
    }
} else { // Si no se han introducido datos en el formulario, también notificamos al usuario
    $errors[] = "Datos vacíos, por favor, rellene los campos.";
    $resultadoLogin = LOGIN_ERR; // Devolvemos el mensaje de error de autenticación incorrecta
}

return $resultadoLogin; // Devolvemos el mensaje necesario en función del resultado de la autenticación
