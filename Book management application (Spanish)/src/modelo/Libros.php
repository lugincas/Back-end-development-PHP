<?php

namespace ClasesLuis\modelo;

/**
 * Clase que representa un ejemplo de documentación en PHP.
 *
 * La clase Libros implementa un método para manejar el conjunto de libros
 *
 * @author Luis Ginés Casanova
 */
class Libros
{
    public static function listarLCU(\PDO $pdo, bool $orden): array|false
    {
        $SQL = "SELECT * FROM libros"; // CONSULTA SELECT

        try {
            $stmt = $pdo->prepare($SQL); // Preparamos la consulta que teníamos arriba. Esto genera un objeto tipo PDOStatment que guardamos en una variable 

            if ($stmt->execute()) {
                $libros = $stmt->fetchAll(\PDO::FETCH_ASSOC); // Si se ejecuta con éxito, obtenemos los datos en un array asociativo y los almacenamos en una variable
                if (count($libros) > 0) { // Nos aseguramos de que tengamos datos en la base dedatos para poder ordenar las instancias
                    foreach ($libros as $registro) {
                        $instancias[] = Libro::rescatar($pdo, $registro['id']); // Recorremos el array de datos y guardamos cada instancia en el array que retornaremos ($instancias[])
                    }

                    if ($orden) { // Si el parámetro $orden es true, ordenamos de forma descendente por fecha de creación
                        usort($instancias, function ($a, $b) { // Utilizamos usort para ordenar el array
                            return strcmp($b->getFechaCreacion(), $a->getFechaCreacion()); // Como queremos ordenarlo de forma descendente, comparamos de B hacia A
                        });
                    } else { // Si el parámetro $orden es false, ordenamos de forma descendente por fecha de actualización
                        usort($instancias, function ($a, $b) { // Utilizamos usort para ordenar el array
                            return strcmp($b->getFechaActualizacion(), $a->getFechaActualizacion()); // Como queremos ordenarlo de forma descendente, comparamos de B hacia A
                        });
                    }

                    return $instancias; // Devolvemos el array de instancias
                }else{ // Si no hay libros en la base de datos, devolvemos false
                    return false;
                }
            }
        } catch (\PDOException $ex) {
            return false; // Este false será consecuencia de un fallo al ejecutar el SELECT
        }

        return false;
    }
}
