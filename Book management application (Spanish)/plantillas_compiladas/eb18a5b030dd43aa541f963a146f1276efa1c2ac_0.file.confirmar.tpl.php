<?php
/* Smarty version 4.5.5, created on 2025-02-14 16:20:23
  from 'C:\xampp\htdocs\dwes04\plantillas\confirmar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67af5f37392fd0_17108913',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb18a5b030dd43aa541f963a146f1276efa1c2ac' => 
    array (
      0 => 'C:\\xampp\\htdocs\\dwes04\\plantillas\\confirmar.tpl',
      1 => 1739546417,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67af5f37392fd0_17108913 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    <hr />
    <h3><span style="color: red;"> ATENCIÓN: </span> ¿Estás seguro/a de eliminar el libro con ID <span style="color: chocolate;"><?php echo $_smarty_tpl->tpl_vars['idEliminar']->value;?>
</span>?</h3>
    <form action="http://localhost/dwes04/index.php" method="post">
        <input type="hidden" name="idEliminar" value=<?php echo $_smarty_tpl->tpl_vars['idEliminar']->value;?>
>  
        <input type="checkbox" name="confirmar" value="confirmar">
        <input style="background-color: red; color:white;" type="submit" value="Confirmar eliminación">
    </form>
    <br>
    <br>
</body><?php }
}
