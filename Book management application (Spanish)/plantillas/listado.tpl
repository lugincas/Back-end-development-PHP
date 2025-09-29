{* Smarty *}
<!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    {include file="encabezado.tpl"}
    <!-- Incluimos el encabezado -->
    <form action="index.php?accion=nuevo_libro_form_LCU" method="post">
        <!-- Formulario para empezar el proceso de adición de libros a la base de datos -->
        <input style="font-size:20px; background-color: rgb(0, 196, 10); color:white;" type="submit"
            value="¡Añadir nuevo libro!">
    </form>
    {if $error}
        <!-- Si $error es true, mostramos el mensaje, si no no -->
        <h3 style="color: red;">----------- ¡No hay registros!¡Añade algún libro! -----------</h3>
        <h4 style="color: red;">---- Si no, puede ser un error relacionado con la base de datos.</h4>
    {else}
        <hr />
        <form action="index.php?accion=ordenar" method="post">
            <!-- El formulario actúa directamente en el enrutador y envía una acción llamada ordenar, donde el controlador por defecto identificará los datos recibidos por POST correspondientes al orden -->
            <h3>¿Cómo deseas ordenar los registros?</h3>
            <label><input type="radio" name="orden" value="1">Por fecha de creación</label><br>
            <!-- Aquí recibimos un valor u otro en función de la elección -->
            <label><input type="radio" name="orden" value="0">Por fecha de actualización</label><br><br>
            <input type="submit" value="¡Enviar!">
        </form>
        
        <br>
        <table border="2">
            <!-- Tabla con el listado de libros con todos sus datos -->
            <thead background-color="black" style="background-color:rgb(233, 175, 50);">
                <tr>
                    <th>ID</th>
                    <th>ISBN</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año de publicación</th>
                    <th>Páginas</th>
                    <th>Ejemplares disponibles</th>
                    <th>Fecha de creación</th>
                    <th>Fecha de actualización</th>
                </tr>
            </thead>
            <tbody align="center">
                {foreach $listadoLibros as $libro}
                    <!-- Iteramos el listado de instancias y obtenemos sus valores mediante los getters -->
                    <tr>
                        <td>{$libro->getId()}</td>
                        <td>{$libro->getIsbn()}</td>
                        <td>{$libro->getTitulo()}</td>
                        <td>{$libro->getAutor()}</td>
                        <td>{$libro->getAnioPublicacion()}</td>
                        <td>{$libro->getPaginas()}</td>
                        <td>{$libro->getEjemplaresDisponibles()}</td>
                        <td>{$libro->getFechaCreacion()}</td>
                        <td>{$libro->getFechaActualizacion()}</td>
                        <td>
                            <form action="index.php?accion=borrar_libro_LCU" method="post">
                                <!-- Añadimos un botón de eliminar que envíe tanto datos para identificar que se ha pulsado (y se quiere eliminar) como el ID del registro en el que se encuentra el botón -->
                                <input type="hidden" name="borrar" value={$libro->getId()}>
                                <input style="font-size:15px; background-color: red; color:white;" type="submit"
                                    value="Eliminar libro">
                            </form>
                        </td>
                    </tr>
                {/foreach}

            </tbody>
        </table>
    {/if}
</body>

</html>