<?php

// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

function logear(PDO $conexion, $usuario, $password)
{
    try { // Realizamos una consulta a nuestra base de datos para obtener el id del usuario que se ha autenticado
        $sth = $conexion->prepare("SELECT id FROM usuarios WHERE login=:usuario AND hash_contraseña=SHA2(CONCAT(REVERSE(:usuario), :contrasenia, '_28381TXF'), 256)");
        $sth->bindValue(":usuario", $usuario); // Vinculamos el valor de $usuario a la variable :usuario
        $sth->bindValue(":contrasenia", $password); // Vinculamos el valor de $password a la variable :contrasenia

        if ($sth->execute()) { // Si la consulta se ejecuta correctamente, obtenemos los resultados en un array
           
            $id = $sth->fetchColumn(); // Obtenemos el valor de la columna "id" del primer registro que se devuelve con fetchColumn()
           
        } else { // Si la consulta no se ejecuta correctamente, devolvemos 0 como valor del id, para indicar que no se ha autenticado correctamente
            $id = 0;
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    return $id; // Devolvemos el valor de $id
}
