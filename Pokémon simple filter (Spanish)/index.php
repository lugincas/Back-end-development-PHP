<html>
<!-- Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
     DAW 2024 - 2025-->
    <head>
        <title> Ejercicio de la sección 3 (Tarea 1) </title>
    </head>

    <body>
        <form action="datos.php" method="post">
            Introduce el nivel mínimo del Pokémon que quieres:<br><br>
            <input type="text" id="nivel" name="nivel"><br><br>
            Selecciona el tipo de tu Pokémon:<br><br>
            <input type="checkbox" name="tipos[]" value="electrico"> Eléctrico<br>
            <input type="checkbox" name="tipos[]" value="dragon"> Dragón<br>
            <input type="checkbox" name="tipos[]" value="fuego"> Fuego<br>
            <input type="checkbox" name="tipos[]" value="fantasma"> Fantasma<br>
            <input type="checkbox" name="tipos[]" value="agua"> Agua<br>
            <input type="checkbox" name="tipos[]" value="hielo"> Hielo<br>
            <input type="checkbox" name="tipos[]" value="planta"> Planta<br><br>
            <input type="submit" value="Buscar Pokémon">
        </form>
    </body>
</html>