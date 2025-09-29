<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

function eliminarDatos (&$conexionPDO, $idProducto){ // Función requerida para eliminar los datos de la base de datos
    
    $resultado = false; // establecemos en false la variable que devolveremos con la función

    require_once __DIR__ .'/conectarBd.php'; // conectamos con la base de datos
    $conexionPDO = conectarBd(); // ERROR ESTO NO SE USA DENTRO DE UNA FUNCIÓN QUE YA PIDE LA CONEXIÓN A BASE DE DATOS. MIRAR MEJOR EL EJEMPLOEXAMEN 
    try {
        $conexionPDO->beginTransaction(); // empezamos la transacción, para un mejor mantenimiento de la integridad de los datos
          
        $stmt = $conexionPDO->prepare('DELETE FROM productos WHERE id = :id');
        $stmt->execute([':id' => $idProducto]);  // pasamos el parámetro directamente al método execute al momento de ejecutar la consulta
        
        $conexionPDO->commit(); // confirmamos todas las operaciones de la transacción con commit()

    } catch (Exception $e) {
        $conexionPDO->rollBack(); // si existe algún error, se revierte la transacción con rollBack para asegurar que los datos permanezcan consistentes
        echo "Fallo en la transacción: " . $e->getMessage();
    }

    print_r('Número de filas eliminadas: ' . $stmt->rowCount() . '<br />'); // comprobamos cuantas filas se ven afectadas después de ejecutar la consulta
    
    if($stmt->rowCount() > 0){ // si el número de filas modificadas es mayor que 0, devuelve true como resultado
        $resultado = true;
    }

    return $resultado; // devolvemos true si se han modificado filas y false si no ha sido así
}