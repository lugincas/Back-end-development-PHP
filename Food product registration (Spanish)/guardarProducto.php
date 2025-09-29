<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

   try {

    require_once __DIR__.'/funciones/insertarDatos.php';

    // arrays con los campos esperados de la tabla, así como de las categorías y propiedades posibles
    $camposEsperados=['nombre','codigo_ean','categoria','propiedades','unidades','precio'];
    $categoriasEsperadas=['lacteos','conservas','bebidas','snacks','dulces','otros'];
    $propiedadesEsperadas = ['sin gluten', 'sin lactosa', 'vegano', 'organico', 'sin conservantes', 'sin colorantes'];    
        
    if ($_POST && count($_POST)!=count($camposEsperados) || !empty(array_diff(array_keys($_POST),$camposEsperados))) { // primero, comprobamos que todos los campos introducidos sean los esperados, y que no queden vacíos
        
            die("¡Datos no esperados!");
        
        }else{

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                $nombre = htmlspecialchars(strtolower(trim(filter_input(INPUT_POST, 'nombre')))); // formateamos el dato introducido por el formulario para que esté en minúsculas, no tenga espacios al principio ni al final, ni carácteres especiales
                $codigo_ean = trim(filter_input(INPUT_POST, 'codigo_ean')); // eliminamos los posibles espacios al principio y al final
                $unidades = intval(filter_input(INPUT_POST, 'unidades')); // con intval, transformamos el texto recibido en un entero a la vez que eliminamos los espacios al principio y al final
                $precio = floatval(filter_input(INPUT_POST, 'precio')); // con floatval, transformamos el texto recibido en un número decimal a la vez que eliminamos los espacios al principio y al final
                $propiedades = implode(',', $_POST['propiedades']); // transformamos el array generado por elegir múltiples propiedades para un producto en una cadena con los valores separados por comas

                // realizamos todas las comprobaciones necesarias para ver si los datos son correctos
                if (!empty($nombre) && strlen($nombre) <= 50 &&
                    !empty($codigo_ean) && is_numeric($codigo_ean) && strlen($codigo_ean)>=8 && strlen($codigo_ean) <= 13 &&
                    $unidades > 0 &&
                    $precio >= 0 &&
                    in_array($_POST['categoria'], $categoriasEsperadas) &&
                    empty(array_diff($_POST['propiedades'],$propiedadesEsperadas)) && isset($_POST['propiedades']) && is_array($_POST['propiedades']))
                     {
                    
                    // si todos los datos son correctos, se recogen en un array que será el que pasemos por parametro a nuestra función insertarDatos
                    $arrayDatos = 
                        ['nombre'=>$nombre,
                        'codigo_ean'=>$codigo_ean,
                        'categoria'=>$_POST['categoria'],
                        'propiedades'=>$propiedades,
                        'unidades'=>$unidades,
                        'precio'=>$precio];
                    
                    // print_r($arrayDatos); // prueba para comprobar si los datos se almacenan correctamente en el array
                    
                    insertarDatos($conexionNueva,$arrayDatos); // insertamos los datos en la base de datos utilizando nuestra función insertarDatos y pasándole por parámetro una conexión PDO a la base de datos así como el array con los datos a insertar

                    echo 'Producto añadido con éxito'; // Comprobación de que el producto se ha añadido con éxito
                } else {
                    echo 'Datos inválidos.';
                }
            }
        }

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    } 

   
