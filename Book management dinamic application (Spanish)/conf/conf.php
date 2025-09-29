<?php

/* 
 * Luis Ginés Casanova de Utrilla
 * Desarrollo Web en Entorno Servidor - 2025 
 */

define ('DB_HOSTNAME','localhost');
define ('DB_PORT',3307);
define ('DB_SCHEMA','2425_dwes07');

define ('DB_DSN','mysql:host='.DB_HOSTNAME.';port='.DB_PORT.';dbname='.DB_SCHEMA);

define ('DB_USER','root');
define ('DB_PASSWD','');

if (!defined('DB_USER') || !defined('DB_PASSWD'))
{
    die("<H1>Configura en ".__FILE__." las constantes DB_USER y DB_PASSWD");
}