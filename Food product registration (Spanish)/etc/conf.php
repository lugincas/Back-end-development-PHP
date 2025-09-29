<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

define("HOST",$_SERVER["SERVER_NAME"]); // Nombre del host
define("NOMBRE_BD","dwesproducto"); // Nombre de la base de datos en phpMyAdmin
define("USUARIO","root");  // Nombre del usuario de la base de datos
define("PASS","");  // Contraseña
define("PUERTO","3307");  // Puerto (en mi caso 3307, el predeterminado suele ser 3306)

define("DSN",'mysql:host=' . HOST . ';port='. PUERTO .';dbname=' . NOMBRE_BD .';');