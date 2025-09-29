<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025
require_once ('etc/conf.php'); // Archivo con datos de la configuración

function conectarBd (){
    
    try {
        $pdo = new PDO(DSN , USUARIO , PASS); // Nueva conexión creada a nuestra base de datos
        $arrayErrores = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
       // echo 'Conexión realizada con éxito'; // Mensaje de prueba para comprobar que la conexión se realiza con éxito (borrar las dos barras del principio de la línea)
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    return $pdo;
}
