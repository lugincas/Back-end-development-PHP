<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

   try {

        require_once __DIR__.'/funciones/modificarDatos.php'; 
     
        if (!isset($_POST['idProductoMod'])) { // primero, comprobamos que todos los campos introducidos sean los esperados, y que no queden vacíos
        
        die("¡Datos no esperados!");
        
        }else{

            if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Comprobamos que el método de solicitud sea POST
                
                $idProductoModificado = intval(filter_input(INPUT_POST, 'idProductoMod'));
                $unidadMod = intval(filter_input(INPUT_POST, 'unidadesMod')); // con intval, transformamos el texto recibido en un número entero a la vez que eliminamos los espacios al principio y al final
                
                if(is_numeric($unidadMod) && $unidadMod != 0 ){ // comprobamos que el número introducido para incrementar o disminuir la cantidad de productos sea numérico y distinto de 0

                    modificarDatos($conexionNueva,$idProductoModificado,$unidadMod); // insertamos los datos en la base de datos utilizando nuestra función modificarDatos y pasándole por parámetro
                                                                                     // una conexión PDO a la base de datos, el id del producto a modificar y el número para incrementar o disminuir la cantidad del producto en cuestión
                    
                    echo 'La cantidad del producto se ha modificado con éxito'; // Comprobación de que el producto se ha modificado con éxito
                }else{
                    echo 'Tipo de dato introducido no válido. El producto no puede modificarse.';
                }

            } else {
                echo 'Datos inválidos.';
            }
        }

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    } 

   
