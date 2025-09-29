<?php
/* Smarty version 4.5.5, created on 2025-02-11 17:24:12
  from 'C:\xampp\htdocs\dwes04\plantillas\vista1.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67ab79acbc29c9_18829661',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84c305b4fd017264ecdb08b0f3454f21fed7ab53' => 
    array (
      0 => 'C:\\xampp\\htdocs\\dwes04\\plantillas\\vista1.tpl',
      1 => 1739291024,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67ab79acbc29c9_18829661 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="es">

<body>
<?php echo $_smarty_tpl->tpl_vars['datosProducto']->value->nombre;?>
<BR>
<?php echo $_smarty_tpl->tpl_vars['datosProducto']->value->precio;?>

</body>

</html><?php }
}
