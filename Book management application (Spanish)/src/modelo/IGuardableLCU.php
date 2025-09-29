<?php

namespace ClasesLuis\modelo;

use PDO;

/**
 * Clase que representa un ejemplo de documentación en PHP.
 *
 * La interfaz IGuardableLCU unifica los métodos que se utilizan para gestionar los datos almacenados en la base de datos
 *
 * @author Luis Ginés Casanova
 */

interface IGuardableLCU {
    public function guardar (PDO $pdo);
    public static function rescatar (PDO $pdo,int $id);
    public static function borrar (PDO $pdo,int $id);
}