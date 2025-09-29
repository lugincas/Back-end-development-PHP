<?php
/* Smarty version 4.5.5, created on 2025-02-18 20:14:07
  from 'C:\xampp\htdocs\dwes04\plantillas\borrarLibro.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67b4dbffe45215_94297481',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7ef045e0f5cbd0e5217b00be5714cec0c353874e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\dwes04\\plantillas\\borrarLibro.tpl',
      1 => 1739905939,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:encabezado.tpl' => 1,
  ),
),false)) {
function content_67b4dbffe45215_94297481 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->
<!-- Plantilla para comprobar el éxito a la hora de eliminar un libro de la base de datos -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    <?php $_smarty_tpl->_subTemplateRender("file:encabezado.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?> <!-- Incluimos el encabezado -->
    <?php if (strlen($_smarty_tpl->tpl_vars['mensajeErrorEliminar']->value) === 0) {?>
        <!-- Si la variable $mensajeError recibida por el controlador está vacía, se muestra el mensaje de éxito. Si no, se muestra el mensaje de error recibido -->
        <h3>¡El libro con ID <span style="color: chocolate;"><?php echo $_smarty_tpl->tpl_vars['libroEliminado']->value;?>
</span> ha sido eliminado con éxito. </h3>
    <?php } else { ?>
        <h3 style="color: crimson;"><?php echo $_smarty_tpl->tpl_vars['mensajeErrorEliminar']->value;?>
</h3>
    <?php }?>
    <form action="index.php?accion=volver" method="post">
        <input style="font-size:15px; background-color: rgb(0, 191, 255);" type="submit" value="Volver a la página principal">
    </form>
</body><?php }
}
