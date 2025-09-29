<?php
/* Smarty version 4.5.5, created on 2025-02-19 09:09:27
  from 'C:\xampp\htdocs\dwes04\plantillas\listado.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67b591b7717de6_61377284',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8cd2333a9b591f9001937bf6484695c0d6d018f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\dwes04\\plantillas\\listado.tpl',
      1 => 1739952563,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:encabezado.tpl' => 1,
  ),
),false)) {
function content_67b591b7717de6_61377284 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Luis Ginés Casanova de Utrilla - DAW (DWES) -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
</head>

<body>
    <?php $_smarty_tpl->_subTemplateRender("file:encabezado.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <!-- Incluimos el encabezado -->
    <form action="index.php?accion=nuevo_libro_form_LCU" method="post">
        <!-- Formulario para empezar el proceso de adición de libros a la base de datos -->
        <input style="font-size:20px; background-color: rgb(0, 196, 10); color:white;" type="submit"
            value="¡Añadir nuevo libro!">
    </form>
    <?php if ($_smarty_tpl->tpl_vars['error']->value) {?>
        <!-- Si $error es true, mostramos el mensaje, si no no -->
        <h3 style="color: red;">----------- ¡No hay registros!¡Añade algún libro! -----------</h3>
        <h4 style="color: red;">---- Si no, puede ser un error relacionado con la base de datos.</h4>
    <?php } else { ?>
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
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['listadoLibros']->value, 'libro');
$_smarty_tpl->tpl_vars['libro']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['libro']->value) {
$_smarty_tpl->tpl_vars['libro']->do_else = false;
?>
                    <!-- Iteramos el listado de instancias y obtenemos sus valores mediante los getters -->
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getId();?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getIsbn();?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getTitulo();?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getAutor();?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getAnioPublicacion();?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getPaginas();?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getEjemplaresDisponibles();?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getFechaCreacion();?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getFechaActualizacion();?>
</td>
                        <td>
                            <form action="index.php?accion=borrar_libro_LCU" method="post">
                                <!-- Añadimos un botón de eliminar que envíe tanto datos para identificar que se ha pulsado (y se quiere eliminar) como el ID del registro en el que se encuentra el botón -->
                                <input type="hidden" name="borrar" value=<?php echo $_smarty_tpl->tpl_vars['libro']->value->getId();?>
>
                                <input style="font-size:15px; background-color: red; color:white;" type="submit"
                                    value="Eliminar libro">
                            </form>
                        </td>
                    </tr>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

            </tbody>
        </table>
    <?php }?>
</body>

</html><?php }
}
