<html lang="es">
<!-- Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
     DAW 2024 - 2025-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; chartset=utf-8">
        <title> Registrar un nuevo producto (Ejercicio 3, Tarea 2 - DWES)</title>
    </head>
  </head>
  <body>
  
    <h1>Registrar un nuevo producto</h1>

    <form action='guardarProducto.php' method='post'> <!-- Formulario con datos enviados a guardarProducto.php -->
      <label for='nombre'>Nombre:</label> 
      <input type='text' id='nombre' name='nombre' /> <!-- Caja de texto para recoger el nombre del producto -->

      <br /><br />

      <label for='codigo_ean'>Código EAN:</label>
      <input type='text' id='codigo_ean' name='codigo_ean' /> <!-- Caja de texto para recoger el código EAN del producto -->

      <br /><br />

      <label for='categoria'>Categoría:</label> <!-- Opciones select para elegir categoría (sólo es posible elegir una) -->
      <select name="categoria"> 
        <option value="lacteos">Lacteos</option>
        <option value="conservas">Conservas</option>
        <option value="bebidas">Bebidas</option>
        <option value="snacks">Snacks</option>
        <option value="dulces">Dulces</option>
        <option value="otros">Otros</option>
        <option value="chuches">Chuches</option> <!-- opción no recogida, para comprobar que no reconozca datos inválidos -->                   
      </select>
      
      <br><br>

      <label for='propiedades'>Propiedades:</label><br><br> <!-- Opciones tipo checkbox para elegir propiedades (pueden elegirse más de una) -->
        <input type="checkbox" name="propiedades[]" value="sin gluten"> sin gluten
        <input type="checkbox" name="propiedades[]" value="sin lactosa"> sin lactosa
        <input type="checkbox" name="propiedades[]" value="vegano"> vegano
        <input type="checkbox" name="propiedades[]" value="organico"> orgánico
        <input type="checkbox" name="propiedades[]" value="sin conservantes"> sin conservantes
        <input type="checkbox" name="propiedades[]" value="sin colorantes"> sin colorantes
        <input type="checkbox" name="propiedades[]" value="sin nada"> sin nada (TEST) <!-- opción no recogida, para comprobar que no reconozca datos inválidos -->

      <br /><br />

      <label for='unidades'>Unidades:</label>
      <input type='text' id='unidades' name='unidades' /> <!-- Caja de texto para recoger el número de unidades del producto -->

      <br /><br />

      <label for='precio'>Precio:</label>
      <input type='text' id='precio' name='precio' /> <!-- Caja de texto para recoger el precio del producto -->

      <br /><br />

      <input type='submit' value='Añadir' /> <!-- Botón para enviar los datos del formulario -->
    </form>
  </body>
</html>