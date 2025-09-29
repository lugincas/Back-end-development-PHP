<?php
// Configuración de la Base de datos mediante constantes, para que el enrutador quede más limpio

define("HOST",$_SERVER["SERVER_NAME"]); // Nombre del host
define("NOMBRE_BD","2425_dwes07"); // Nombre de la base de datos en phpMyAdmin
define("USUARIO","root");  // Nombre del usuario de la base de datos
define("PASS","");  // Contraseña
define("PUERTO","3307");  // Puerto (en mi caso 3307, el predeterminado suele ser 3306)

define("DSN",'mysql:host=' . HOST . ';port='. PUERTO .';dbname=' . NOMBRE_BD .';');
