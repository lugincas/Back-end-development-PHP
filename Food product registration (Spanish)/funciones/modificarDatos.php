<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

function modificarDatos (&$conexionPDO, $idProducto, $unidadIncrDecr){ // Función requerida para modificar los datos de la base de datos
    
    $resultado = false; // establecemos en false la variable que devolveremos con la función

    require_once __DIR__ .'/conectarBd.php'; // conectamos con la base de datos

    $conexionPDO = conectarBd(); // utilizamos la función conectarBd para crear una conexión a la base de datos configurada
    try {
        $conexionPDO->beginTransaction(); // empezamos la transacción, para un mejor mantenimiento de la integridad de los datos

        if ($unidadIncrDecr<0){
            $unidadIncrDecr = $unidadIncrDecr * -1; // una vez que hemos hecho la comprobación de que el número era negativo, lo multiplicamos por -1 para que vuelva a ser positivo, para poder hacer la resta en la consulta
            $stmt = $conexionPDO->prepare('UPDATE productos SET unidades = unidades - :unidades WHERE id = :id'); // si el número es negativo, la consulta que preparamos resta las unidades pasadas por parámetro a las unidades actuales de la entrada que coincide con el id
        }else{
            $stmt = $conexionPDO->prepare('UPDATE productos SET unidades = unidades + :unidades WHERE id = :id'); // si el número es positivo, la consulta que preparamos suma las unidades pasadas por parámetro a las unidades actuales de la entrada que coincide con el id
        }
    
        $stmt-> execute([':id' => $idProducto, ':unidades' => $unidadIncrDecr]); // pasamos un array de parámetros directamente al método execute al momento de ejecutar la consulta
    
        $conexionPDO->commit(); // confirmamos todas las operaciones de la transacción con commit()

    } catch (Exception $e) {
        $conexionPDO->rollBack(); // si existe algún error, se revierte la transacción con rollBack para asegurar que los datos permanezcan consistentes
        echo "Fallo en la transacción: " . $e->getMessage();
    }  

    print_r('Número de filas modificadas: ' . $stmt->rowCount() . '<br />'); // comprobamos cuantas filas se ven afectadas después de ejecutar la consulta
    
    if($stmt->rowCount() > 0){ // Si el número de filas modificadas es mayor que 0, devuelve true como resultado
        $resultado = true;
    }

    return $resultado; // devolvemos true si se han modificado filas y false si no ha sido así
}