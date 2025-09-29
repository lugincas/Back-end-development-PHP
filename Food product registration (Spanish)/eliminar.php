<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

   try {

        require_once __DIR__.'/funciones/eliminarDatos.php'; 
     
        if (!isset($_POST['idProductoEliminar'])) { // primero, comprobamos que todos los campos introducidos sean los esperados, y que no queden vacíos
        
        die("¡Datos no esperados!");
        
        }else{

            if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Comprobamos que el método de solicitud sea POST
                
                $idProductoEliminar = intval(filter_input(INPUT_POST, 'idProductoEliminar'));

                eliminarDatos($conexionNueva,$idProductoEliminar); // insertamos los datos en la base de datos utilizando nuestra función eliminarDatos y pasándole por parámetro
                                                                   // una conexión PDO a la base de datos así como el id del producto a eliminar
                echo 'El producto se ha eliminado con éxito'; // Comprobación de que el producto se ha eliminado con éxito
            
            } else {
                echo 'Datos inválidos.';
            }
        }

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    } 

   
