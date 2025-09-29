<?php
// Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor
// DAW 2024 - 2025

    // Array bidimensional con los datos, asociados a las 'key': nombre, nivel, descripcion y tipo
    $arrayPokemon = [
        ['nombre'=>'Jolteon','nivel'=>27,'descripcion'=>'Perro eléctrico','tipo'=>'electrico'],
        ['nombre'=>'Ampharos','nivel'=>75,'descripcion'=>'Dragón oveja','tipo'=>'electrico'],
        ['nombre'=>'Joltik','nivel'=>6,'descripcion'=>'Araña eléctrica','tipo'=>'electrico'],
        ['nombre'=>'Salamance','nivel'=>59,'descripcion'=>'Salamandra voladora','tipo'=>'dragon'],
        ['nombre'=>'Dratini','nivel'=>8,'descripcion'=>'Dragón serpiente','tipo'=>'dragon'],
        ['nombre'=>'Rayquaza','nivel'=>100,'descripcion'=>'Dragón de aire','tipo'=>'dragon'],
        ['nombre'=>'Charizard','nivel'=>36,'descripcion'=>'Lagarto de fuego','tipo'=>'fuego'],
        ['nombre'=>'Growlithe','nivel'=>24,'descripcion'=>'Perrito de fuego','tipo'=>'fuego'],
        ['nombre'=>'Magmar','nivel'=>83,'descripcion'=>'Pato de fuego','tipo'=>'fuego'],
        ['nombre'=>'Gengar','nivel'=>45,'descripcion'=>'Espectro sonriente','tipo'=>'fantasma'],
        ['nombre'=>'Dusclops','nivel'=>95,'descripcion'=>'Momia oscura','tipo'=>'fantasma'],
        ['nombre'=>'Starmie','nivel'=>50,'descripcion'=>'Estrella de mar gigante','tipo'=>'agua'],
        ['nombre'=>'Horsea','nivel'=>13,'descripcion'=>'Caballito de mar','tipo'=>'agua'],
        ['nombre'=>'Wailord','nivel'=>77,'descripcion'=>'Ballena','tipo'=>'agua'],
        ['nombre'=>'Bayleef','nivel'=>60,'descripcion'=>'Planta cuellilarga','tipo'=>'planta'],
        ['nombre'=>'Cacnea','nivel'=>31,'descripcion'=>'Cactus luchador','tipo'=>'planta'],
        ['nombre'=>'Rillaboom','nivel'=>81,'descripcion'=>'Gorila arbusto','tipo'=>'planta']
    ];

    $nivel=$_POST['nivel']??null; // Recibimos el dato introducido en el formulario para saber el nivel mínimo desde el que buscaremos Pokémon
    settype($nivel,"integer"); // Establecemos el dato introducido en el formulario como entero, para especificarlo y poder controlar errores más adelante

    for($i = 0; $i<count($arrayPokemon); $i++){  // Creamos un array sólo con los tipos de nuestro array completo de datos, para comprobar si están permitidos o no;
        $tipos_permitidos [$i] = $arrayPokemon [$i]['tipo'];  
    }
    
    if ($nivel==null||is_integer($nivel)==false) // Si no especificamos el nivel o este no es un número entero, este tomará el valor de 1 por defecto
    {
        $nivel = 1;
        echo 'No se ha especificado el nivel. Se mostrarán todos los Pokémon desde el nivel 1.';
        echo "<br/>";
        
    } else { // De lo contrario, se tomará el valor pasado por el formulario
        echo "El nivel mínimo escogido es $nivel. Se mostrarán todos los Pokémon que tienes a partir de ese.";
        echo "<br/>";       
    }
    
    if (isset($_POST['tipos']) && is_array($_POST['tipos'])) { // Comprobamos si hemos podido pasar datos a traves de los checkbox y si se han almacenado en un array adecuadamente en nuestra variable
        
        if (empty(array_diff($_POST['tipos'], $tipos_permitidos))) { // Si encontramos el tipo escogido entre los tipos existentes en nuestros datos, los mostramos

            echo "<br/>";     
            echo 'Las tipos escogidos son: '.implode(', ',$_POST['tipos']); 
            echo "<br/>";

        } else { // Si no lo encontramos, es que son de tipo hielo (no tenemos), y por tanto mostramos la elección pero sólo mostraremos aquellos tipos que sí existan en nuestro array de datos
            echo "<br/>";     
            echo 'Las tipos escogidos son: '.implode(', ',$_POST['tipos']); 
            echo "<br/>";
            echo 'No tienes Pokémon de tipo Hielo. Se mostrarán los otros tipos si los has escogido.';
            echo "<br/>";
        }
        
        for($i = 0; $i<count($arrayPokemon); $i++){ // Recorremos nuestro array de datos

            if(($nivel <= $arrayPokemon[$i]['nivel'])){  // Comprobación de que el nivel es mayor que el parámetro introducido en nuestro formulario, para sólo retornar esos valores

                for ($j = 0; $j<count($_POST['tipos']); $j++){ // Recorremos el array de tipos que hemos generado a raíz de nuestra selección múltiple

                    if($_POST['tipos'][$j] === $arrayPokemon[$i]['tipo']){

                        $tiposFiltrados [$i] = $arrayPokemon[$i]; // Almacenamos las posiciones de nuestro array de datos en un array filtrado con los tipos y el nivel mínimo especificado
                        /* print_r ($tiposFiltrados[$i]); // impresión del array para probar que se almacenan los resultados correctamente
                        echo "<br/>";  */
                    }
        
                }

            }
        }

        if(isset($tiposFiltrados)){ // Si sólo elegimos el tipo Hielo, no almacenaremos ningún dato en tiposFiltrados, con lo que controlamos que sólo genere nuestro HTML si esa variable se declaró y no es nula
        ?> 
            <html>
            <!-- Generamos el HTML con los tipos filtrados-->
                <head>
                    <title> Ejercicio de la sección 3 (Tarea 1) </title>
                </head>
            
                <body>
                    <table border="2">
                        <tr>
                            <th style="background-color: #355FAC; color: #FFCC01;">Nombre</th>
                            <th style="background-color: #355FAC; color: #FFCC01;">Nivel</th>
                            <th style="background-color: #355FAC; color: #FFCC01;">Descripción</th>
                            <th style="background-color: #355FAC; color: #FFCC01;">Tipo</th>
                        </tr>
            
                        <?php foreach ($tiposFiltrados as $key => $value): // Recorremos nuestro array con los tipos pasados por el filtro aplicado y accedemos a cada valor para generar la tabla en nuestro HTML
                        
                        ?>
                        <tr>       
                            <td style="background-color: #FFCC01; color: #355FAC;"><?=$value['nombre']?></td>
                            <td style="background-color: #FFCC01; color: #355FAC;"><?=$value['nivel']?></td>
                            <td style="background-color: #FFCC01; color: #355FAC;"><?=$value['descripcion']?></td>
                            <td style="background-color: #FFCC01; color: #355FAC;"><?=$value['tipo']?></td>
                        </tr>
                        <?php endforeach;?>
                        
                    </table>
                </body>
            </html>

        <?php
        }

    } else {
        echo 'No has elegido un tipo. Se mostrarán todos los Pokemon y tipos.';

        ?> 
        <html>
        <!-- Generamos el HTML con todos los datos -->
            <head>
                <title> Ejercicio de la sección 3 (Tarea 1) </title>
            </head>
        
            <body>
                <table border="2">
                    <tr>
                        <th style="background-color: #355FAC; color: #FFCC01;">Nombre</th>
                        <th style="background-color: #355FAC; color: #FFCC01;">Nivel</th>
                        <th style="background-color: #355FAC; color: #FFCC01;">Descripción</th>
                        <th style="background-color: #355FAC; color: #FFCC01;">Tipo</th>
                    </tr>
        
                    <?php foreach ($arrayPokemon as $key => $value): // En este caso, el array que recorremos es el que tiene todos los datos, sin filtrar
                        
                    ?> 
                    <tr>       
                        <td style="background-color: #FFCC01;"><?=$value['nombre']?></td>
                        <td style="background-color: #FFCC01;"><?=$value['nivel']?></td>
                        <td style="background-color: #FFCC01;"><?=$value['descripcion']?></td>
                        <td style="background-color: #FFCC01;"><?=$value['tipo']?></td>
                    </tr>
                    <?php endforeach; ?>
                    
                </table>
            </body>
        </html>
        
    <?php
    }
    ?>



    


