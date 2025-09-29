<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

function insertarDatos (&$conexionPDO, $arrayInsertado){ // Función requerida para guardar los datos y vincularlos a la base de datos
    
    require_once __DIR__ .'/conectarBd.php'; // conectamos con la base de datos
    $conexionPDO = conectarBd(); // utilizamos la función conectarBd para crear una conexión a la base de datos configurada
    
    try {
        $conexionPDO->beginTransaction(); // empezamos la transacción, para un mejor mantenimiento de la integridad de los datos

        $query = 'INSERT INTO productos (nombre, codigo_ean, categoria, propiedades, unidades, precio) VALUES (:nombre, :codigo_ean, :categoria, :propiedades, :unidades, :precio)'; // elaboramos nuestra consulta con varios parametros para prepararla más adelante
        $stmt = $conexionPDO->prepare($query); // preparamos la consulta

        // vinculamos los parámetros recibidos por el array con bindParam
        $stmt->bindParam(':nombre', $arrayInsertado['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':codigo_ean', $arrayInsertado['codigo_ean'], PDO::PARAM_STR);
        $stmt->bindParam(':categoria', $arrayInsertado['categoria'], PDO::PARAM_STR);
        $stmt->bindParam(':propiedades', $arrayInsertado['propiedades'], PDO::PARAM_STR);
        $stmt->bindParam(':unidades', $arrayInsertado['unidades'], PDO::PARAM_STR);
        $stmt->bindParam(':precio', $arrayInsertado['precio'], PDO::PARAM_STR);
        
        $stmt->execute(); // ejecutamos la consulta
        
        echo 'ID: ' . $conexionPDO->lastInsertId() . '<br />'; // comprobamos qué ID está devolviendo la función

        $conexionPDO->commit(); // confirmamos todas las operaciones de la transacción con commit()
         
    } catch (Exception $e) {
        $conexionPDO->rollBack(); // si existe algún error, se revierte la transacción con rollBack para asegurar que los datos permanezcan consistentes
        echo "Fallo en la transacción: " . $e->getMessage();
    }
  
    print_r('Número de filas insertadas: ' . $stmt->rowCount() . '<br />'); // comprobamos cuantas filas se ven afectadas después de ejecutar la consulta
    
    return $conexionPDO->lastInsertId(); // devolvemos el id de la nueva fila insertada
}