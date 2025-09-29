{* Smarty *}
<!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->
<!-- Plantilla para confirmar si queremos eliminar un libro de la base de datos -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    {include file="encabezado.tpl"} <!-- Incluimos el encabezado -->
    <h3><span style="color: red;"> ATENCIÓN: </span> ¿Estás seguro/a de eliminar el libro con ID <span
            style="color: chocolate;">{$idEliminar}</span>?</h3>
    <form action="index.php?accion=confirmar" method="post">
        <input type="hidden" name="idEliminar" value={$idEliminar}>
        <input type="checkbox" name="confirmar" value="confirmar">
        <input style="font-size:15px; background-color: red; color:white;" type="submit" value="Confirmar eliminación">
        <!-- Si seleccionamos la casilla, enviaremos datos con el ID y la confirmación -->
    </form>
    <br>
    <form action="index.php?accion=volver" method="post">
        <input style="font-size:15px; background-color: rgb(0, 191, 255);" type="submit" value="Volver a la página principal">
    </form>
</body>