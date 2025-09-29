<?php
/* Smarty version 4.5.5, created on 2025-02-18 20:11:20
  from 'C:\xampp\htdocs\dwes04\plantillas\aniadirLibro.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67b4db58577582_55216254',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a876b031c51553ad132e177c02f4223a1d70dcfd' => 
    array (
      0 => 'C:\\xampp\\htdocs\\dwes04\\plantillas\\aniadirLibro.tpl',
      1 => 1739905877,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:encabezado.tpl' => 1,
  ),
),false)) {
function content_67b4db58577582_55216254 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    <?php $_smarty_tpl->_subTemplateRender("file:encabezado.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?> <!-- Incluimos el encabezado -->
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

</html><?php }
}
