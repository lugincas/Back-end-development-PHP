<?php

// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

session_start(); // Comenzamos la sesión 
if (isset($_SESSION['usuario']) && isset($_SESSION['id_usuario'])) { // Si hay datos almacenados en la sesión, procedemos a conformar el array de datos que retornaremos
    $arrayUsuario = array(
        'login' => $_SESSION['usuario'],
        'id_usuario'=> $_SESSION['id_usuario'],        
        'ultimo_acceso' => $_SESSION['ultimo_acceso'],
        'tiempo_trascurrido' => time() - $_SESSION['ultimo_acceso']
    );

    if ($arrayUsuario['tiempo_trascurrido'] >600) { // Habiendo datos en la sesión, comprobamos si ha superado el tiempo de inactividad (10 minutos). Si es así, borramos los datos de la sesión
        unset($_SESSION['usuario']);
        unset($_SESSION['id_usuario']);
        unset($_SESSION['ultimo_acceso']);

        $notifs[] = "Se ha superado el tiempo de inactividad. La sesión ha expirado.";
    }else{ // Si no se ha superado el tiempo de inactividad, renovamos el último acceso
        $_SESSION['ultimo_acceso'] = time();
        $notifs[] = "Se ha renovado el tiempo de acceso.";
    }
} else {
    $arrayUsuario = array(); // Si no hay datos en la sesión, devolvemos un array vacío
}

return $arrayUsuario; // Devolvemos el array de datos del usuario