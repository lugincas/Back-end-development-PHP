<html lang="es">
<!-- Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
     DAW 2024 - 2025-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; chartset=utf-8">
        <title> Listar productos (Ejercicio 2, Tarea 2 - DWES) </title>
    </head>

    <body>
    <?php require_once __DIR__.'/funciones/obtenerLista.php'; ?>

        <form action="productos.php" method="post"> <!-- formulario mediante SELECT-->
            <h3>Selección de categoría con SELECT</h3>
                <select name="categorias"> 
                    <option value="lacteos">Lacteos</option>
                    <option value="conservas">Conservas</option>
                    <option value="bebidas">Bebidas</option>
                    <option value="snacks">Snacks</option>
                    <option value="dulces">Dulces</option>
                    <option value="otros">Otros</option>
                    <option value="chuches">Chuches</option>                    
                </select><br><br>
                <input type="submit" value="¡Elegir categoría!">
        </form>

        <table border="2">
            <tr>
                <th style="background-color: black; color: white;">Nombre</th>
                <th style="background-color: black; color: white;">Código EAN</th>
                <th style="background-color: black; color: white;">Categoría</th>
                <th style="background-color: black; color: white;">Propiedades</th>
                <th style="background-color: black; color: white;">Unidades</th>
                <th style="background-color: black; color: white;">Precio</th>
                <th style="background-color: yellow; color: black;">Operaciones</th>
            </tr>

            <?php
            $lista = obtenerLista(); // mostramos el listado completo

            define('OPCIONES', ["lacteos", "conservas", "bebidas", "snacks", "dulces", "otros"]); // declaramos nuestro array de opciones

            if (isset($_POST['categorias'])) // comprobamos si hemos podido pasar datos a traves de nuestro filtrado con SELECT 
            {
                    if (in_array($_POST['categorias'],OPCIONES)){ // comprobamos que el dato se encuentra entre nuestras opciones
                        $lista = obtenerLista($_POST['categorias']); // almacenamos en el array que mostraremos por HTML sólo la categoría filtrada
                    }else{
                        echo '¡La opción no es válida! Elige otra.';
                    }
            }
            else
            {
                  $lista = obtenerLista(); // Creamos el array y pasamos su filtro, en este caso es el año a partir del cuál se buscarán las publicaciones
            }
            // Creamos el array y pasamos su filtro, en este caso es el año a partir del cuál se buscarán las publicaciones
            
            foreach ($lista as $key => $value):?>
                <tr>       
                    <td style="color: black; text-align: center;"><?=$value["nombre"]?></td>
                    <td style="color: black; text-align: center;"><?=$value["codigo_ean"]?></td>
                    <td style="color: black; text-align: center;"><?=$value["categoria"]?></td>
                    <td style="color: black;">
                        <ul> 
                            <?php // Aquí jugamos con las secciones de script y html, para controlar que, en caso de que no haya propiedades, ponga "No descritas", y si las hay,
                                  // salga en formato de lista desordenada
                            if (empty($value["propiedades"])){
                                $value["propiedades"] = "No descritas";
                            ?>
                            <?=$value["propiedades"]?>
                            <?php
                            }else{
                                $valoresSeparados = explode(",",$value["propiedades"]); // utilizamos la función explode para generar un nuevo array separado por comas y mostrar ese
                                foreach ($valoresSeparados as $key => $propiedadesSeparadas):
                            ?>
                            <li><?=$propiedadesSeparadas?></li>
                            <?php
                            endforeach;
                            }
                            ?>
                        </ul>
                    </td>
                    <td style="color: black; text-align: center;"><?=$value["unidades"]?></td>
                    <td style="color: black; text-align: center;"><?=$value["precio"]?></td>
                    <td style="color: black;">
                        <form action="modificarProducto.php" method="post"> <!-- formulario para modificación de productos-->
                            <label for='modificacion'>Incremento o decremento:</label> 
                            <input type='text' id='unidadesMod' name='unidadesMod' />
                            <br><br>
                            <input type="submit" value="Modificar" />
                            <input type="hidden" name="idProductoMod" value = <?=$value["id"]?>/> <!-- mediante un input de tipo "hidden", obtenemos el id del registro en el que nos encontramos-->
                        </form>
                        <form action="eliminar.php" method="post"> <!-- formulario para eliminación de productos-->
                            <input type="submit" value="Eliminar" />
                            <input type="hidden" name="idProductoEliminar" value = <?=$value["id"]?>/> <!-- mediante un input de tipo "hidden", obtenemos el id del registro en el que nos encontramos-->
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>