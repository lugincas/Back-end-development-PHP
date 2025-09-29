<?php
/* Smarty version 4.5.5, created on 2025-02-13 20:36:12
  from 'C:\xampp\htdocs\dwes04\plantillas\exito.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67ae49ac06c7c0_80018985',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1569050c784feba3212708799c9a9468515aeb52' => 
    array (
      0 => 'C:\\xampp\\htdocs\\dwes04\\plantillas\\exito.tpl',
      1 => 1739475326,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67ae49ac06c7c0_80018985 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    <br>
<?php if (strlen($_smarty_tpl->tpl_vars['mensajeError']->value) === 0) {?>
    <h3>¡El libro <span style="color: chocolate;"><?php echo $_smarty_tpl->tpl_vars['tituloLibro']->value;?>
</span> ha sido añadido con éxito, su ID es <span style="color: chocolate;"><?php echo $_smarty_tpl->tpl_vars['idNuevoLibro']->value;?>
</span>!</h3>
<?php } else { ?>
    <h3 style="color: crimson;"><?php echo $_smarty_tpl->tpl_vars['mensajeError']->value;?>
</h3>
<?php }?>
    <br>
</body><?php }
}
