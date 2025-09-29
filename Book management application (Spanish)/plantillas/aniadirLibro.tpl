{* Smarty *}
<!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    {include file="encabezado.tpl"} <!-- Incluimos el encabezado -->
    <form action="index.php?accion=crear_libro_LCU" method="post">
        <!-- El formulario actúa directamente en el enrutador y comprobamos si se han recibido los datos mediante POST-->
        <h3>¡Añade un nuevo libro!</h3>
        <label for="isbn">ISBN: </label>
        <input type="text" name="isbn" id="isbn"> <br>
        <label for="titulo">Título: </label>
        <input type="text" name="titulo" id="titulo"> <br>
        <label for="autor">Autor: </label>
        <input type="text" name="autor" id="autor"> <br>
        <label for="anioPublicacion">Año de publicación: </label>
        <input type="text" name="anioPublicacion" id="anioPublicacion"> <br>
        <label for="paginas">Páginas: </label>
        <input type="text" name="paginas" id="paginas"> <br>
        <label for="ejemplaresDisponibles">Ejemplares disponibles: </label>
        <input type="text" name="ejemplaresDisponibles" id="ejemplaresDisponibles">
        <br>
        <br>
        <!-- Enviamos el dato que indica que la acción que queremos efectuar es la de crear un libro -->
        <input style="font-size:15px; background-color: rgb(0, 196, 10); color:white;" type="submit" value="¡Añadir!">
    </form>
    <br>
    <form action="index.php?accion=volver" method="post">
        <input style="font-size:15px; background-color: rgb(0, 191, 255);" type="submit" value="Volver a la página principal">
    </form>
    <hr />

</body>

</html>