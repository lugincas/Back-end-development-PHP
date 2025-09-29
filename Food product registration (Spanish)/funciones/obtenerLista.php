<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

require_once __DIR__.'/conectarBd.php';

function obtenerLista($categoria=null){
        
        $conexionLista = conectarBd(); // realizamos conexión a la base de datos
        
    if(is_null($categoria)){ 
        try {
            $sth = $conexionLista->prepare("SELECT * FROM productos"); // hacemos un select para todos los productos de la tabla si no se recibe categoria por parámetro o no es la esperada
            $sth->execute(); // ejecutamos la consulta
            $listaProductos = $sth->fetchAll(PDO::FETCH_ASSOC); // con fetchAll obtenemos el conjunto de resultados en un array bidimensional

            // print_r($listaProductos); // prueba para comprobar qué productos se están listando
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    } else {
        
        try {         
            $sth = $conexionLista->prepare("SELECT * FROM productos WHERE categoria = '$categoria'"); // hacemos un select sólo donde coincida la categoría con la que pasamos por parámetro
            $sth->execute(); // ejecutamos la consulta
            $listaProductos = $sth->fetchAll(PDO::FETCH_ASSOC); // con fetchAll obtenemos el conjunto de resultados en un array bidimensional

            // print_r($listaProductos); // prueba para comprobar qué productos se están listando
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    return $listaProductos; // devolvemos el array bidimensional que corresponda en función de si el parámetro recibido es null o coincide con las categorías existentes
}

