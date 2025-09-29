{* Smarty *}
<!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->
<!-- Plantilla para comprobar el éxito a la hora de añadir un libro a la base de datos -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    {include file="encabezado.tpl"} <!-- Incluimos el encabezado -->
    <br>
    {if strlen($mensajeError)===0}
        <!-- Si la variable $mensajeError recibida por el controlador está vacía, se muestra el mensaje de éxito. Si no, se muestra el mensaje de error recibido -->
        <h3>¡El libro <span style="color: chocolate;">{$tituloLibro}</span> ha sido añadido con éxito, su ID es <span
                style="color: chocolate;">{$idNuevoLibro}</span>!</h3>
    {else}
        <h3 style="color: crimson;">{$mensajeError}</h3>
    {/if}
    
    <form action="index.php?accion=nuevo_libro_form_LCU" method="post">
        <input style="font-size:15px; background-color: rgb(249, 192, 37);" type="submit" value="¡Añadir otro libro!">
    </form>
    <br>
    <form action="index.php?accion=volver" method="post">
        <input style="font-size:15px; background-color: rgb(0, 191, 255);" type="submit" value="Volver a la página principal">
    </form>
</body>