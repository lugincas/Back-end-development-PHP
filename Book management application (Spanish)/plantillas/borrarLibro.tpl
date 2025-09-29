{* Smarty *}
<!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->
<!-- Plantilla para comprobar el éxito a la hora de eliminar un libro de la base de datos -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    {include file="encabezado.tpl"} <!-- Incluimos el encabezado -->
    {if strlen($mensajeErrorEliminar)===0}
        <!-- Si la variable $mensajeError recibida por el controlador está vacía, se muestra el mensaje de éxito. Si no, se muestra el mensaje de error recibido -->
        <h3>¡El libro con ID <span style="color: chocolate;">{$libroEliminado}</span> ha sido eliminado con éxito. </h3>
    {else}
        <h3 style="color: crimson;">{$mensajeErrorEliminar}</h3>
    {/if}
    <form action="index.php?accion=volver" method="post">
        <input style="font-size:15px; background-color: rgb(0, 191, 255);" type="submit" value="Volver a la página principal">
    </form>
</body>