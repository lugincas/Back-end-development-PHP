<?php
/* Smarty version 4.5.5, created on 2025-02-18 20:13:32
  from 'C:\xampp\htdocs\dwes04\plantillas\exitoAniadirLibro.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67b4dbdc48afa2_42347389',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ba25c4df1aba20be1570c034609eae19e5ef97a6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\dwes04\\plantillas\\exitoAniadirLibro.tpl',
      1 => 1739906007,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:encabezado.tpl' => 1,
  ),
),false)) {
function content_67b4dbdc48afa2_42347389 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->
<!-- Plantilla para comprobar el éxito a la hora de añadir un libro a la base de datos -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    <?php $_smarty_tpl->_subTemplateRender("file:encabezado.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?> <!-- Incluimos el encabezado -->
    <br>
    <?php if (strlen($_smarty_tpl->tpl_vars['mensajeError']->value) === 0) {?>
        <!-- Si la variable $mensajeError recibida por el controlador está vacía, se muestra el mensaje de éxito. Si no, se muestra el mensaje de error recibido -->
        <h3>¡El libro <span style="color: chocolate;"><?php echo $_smarty_tpl->tpl_vars['tituloLibro']->value;?>
</span> ha sido añadido con éxito, su ID es <span
                style="color: chocolate;"><?php echo $_smarty_tpl->tpl_vars['idNuevoLibro']->value;?>
</span>!</h3>
    <?php } else { ?>
        <h3 style="color: crimson;"><?php echo $_smarty_tpl->tpl_vars['mensajeError']->value;?>
</h3>
    <?php }?>
    
    <form action="index.php?accion=nuevo_libro_form_LCU" method="post">
        <input style="font-size:15px; background-color: rgb(249, 192, 37);" type="submit" value="¡Añadir otro libro!">
    </form>
    <br>
    <form action="index.php?accion=volver" method="post">
        <input style="font-size:15px; background-color: rgb(0, 191, 255);" type="submit" value="Volver a la página principal">
    </form>
</body><?php }
}
