<?php
/* Smarty version 4.5.5, created on 2025-02-18 20:14:03
  from 'C:\xampp\htdocs\dwes04\plantillas\confirmarBorrarLibro.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67b4dbfb71d643_05860009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '16f1c00dcd6fba01034737606cd0e4deaa4d1cad' => 
    array (
      0 => 'C:\\xampp\\htdocs\\dwes04\\plantillas\\confirmarBorrarLibro.tpl',
      1 => 1739906040,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:encabezado.tpl' => 1,
  ),
),false)) {
function content_67b4dbfb71d643_05860009 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->
<!-- Plantilla para confirmar si queremos eliminar un libro de la base de datos -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    <?php $_smarty_tpl->_subTemplateRender("file:encabezado.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?> <!-- Incluimos el encabezado -->
    <h3><span style="color: red;"> ATENCIÓN: </span> ¿Estás seguro/a de eliminar el libro con ID <span
            style="color: chocolate;"><?php echo $_smarty_tpl->tpl_vars['idEliminar']->value;?>
</span>?</h3>
    <form action="index.php?accion=confirmar" method="post">
        <input type="hidden" name="idEliminar" value=<?php echo $_smarty_tpl->tpl_vars['idEliminar']->value;?>
>
        <input type="checkbox" name="confirmar" value="confirmar">
        <input style="font-size:15px; background-color: red; color:white;" type="submit" value="Confirmar eliminación">
        <!-- Si seleccionamos la casilla, enviaremos datos con el ID y la confirmación -->
    </form>
    <br>
    <form action="index.php?accion=volver" method="post">
        <input style="font-size:15px; background-color: rgb(0, 191, 255);" type="submit" value="Volver a la página principal">
    </form>
</body><?php }
}
