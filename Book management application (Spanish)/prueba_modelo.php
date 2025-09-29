<?php
// Luis Ginés Casanova de Utrilla - DAW (DWES)

use ClasesLuis\modelo\Libro;
use ClasesLuis\modelo\Libros;

require_once __DIR__ . '/vendor/autoload.php'; // Usamos el autoloading PSR-4 para cargar todas las clases
require_once __DIR__ . '/etc/configBd.php'; // Utilizamos la configuración a la base de datos 

// Conexión a la base de datos
try {
    $pdo = new PDO(DSN, USUARIO, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

$libroPruebaGetter = new Libro(null, '9780140449136', 'El Quijote', 'Miguel de Cervantes', 1605, 863, 5, null, null);

$libroPruebaDos = new Libro(null, '9780747532743', 'Harry Potter and the Philosophers Stone', 'J.K. Rowling', 1997, 223, 7, null, null);

$libroPruebaTres = new Libro(null, '9780807281918', 'The Hobbit', 'J.R.R. Tolkien', 1937, 310, 8, null, null);

$libroPruebaSetter = new Libro(null, '9780451524935', '1984', 'George Orwell', 1949, 328, 4, null, null);

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Prueba del modelo</title>
</head>

<body>
    <header>
        <h1>Pruebas del modelo</h1>
        <h2>Por Luis Ginés Casanova de Utrilla</h2>
        <hr />
    </header>
    <main>
        <h3>Pruebas de Getters (antes de guardar el libro)</h3>
        <ul>
            <li>ID: <?= $libroPruebaGetter->getId() ?> </li>
            <li>ISBN: <?= $libroPruebaGetter->getIsbn() ?> </li>
            <li>TÍTULO: <?= $libroPruebaGetter->getTitulo() ?> </li>
            <li>AUTOR: <?= $libroPruebaGetter->getAutor() ?> </li>
            <li>AÑO PUBLICACIÓN: <?= $libroPruebaGetter->getAnioPublicacion() ?> </li>
            <li>PÁGINAS: <?= $libroPruebaGetter->getPaginas() ?> </li>
            <li>EJEMPLARES DISPONIBLES: <?= $libroPruebaGetter->getEjemplaresDisponibles() ?> </li>
            <li>FECHA CREACIÓN: <?= $libroPruebaGetter->getFechaCreacion() ?> </li>
            <li>FECHA ACTUALIZACIÓN: <?= $libroPruebaGetter->getFechaActualizacion() ?> </li>
        </ul>
        <hr />
        <h3>Guardamos en la base de datos y lo rescatamos...</h3>
        <p style="color: red;">¡Por favor, cambie el ID de $libroPruebaGetterRescatado en el código por el que se haya creado en la base de datos!</p>
        <?php
        try {
            $libroPruebaGetter->guardar($pdo);
            $libroPruebaGetterRescatado = Libro::rescatar($pdo, 124); // Poner en el parámetro del ID el ID correspondiente en la base de datos al guardar el libro. Tener en cuenta que si se borra, habrá que poner el nuevo ID al crearlo u otro existente
        } catch (Exception $e) {
            var_dump($e);
        }
        ?>
        <hr />
        <h3>Segunda prueba de Getter (despues de guardar el libro)</h3>
        <ul>
            <?php
            try { ?>
                <li>ID: <?= $libroPruebaGetterRescatado->getId() ?> </li>
                <li>ISBN: <?= $libroPruebaGetterRescatado->getIsbn() ?> </li>
                <li>TÍTULO: <?= $libroPruebaGetterRescatado->getTitulo() ?> </li>
                <li>AUTOR: <?= $libroPruebaGetterRescatado->getAutor() ?> </li>
                <li>AÑO PUBLICACIÓN: <?= $libroPruebaGetterRescatado->getAnioPublicacion() ?> </li>
                <li>PÁGINAS: <?= $libroPruebaGetterRescatado->getPaginas() ?> </li>
                <li>EJEMPLARES DISPONIBLES: <?= $libroPruebaGetterRescatado->getEjemplaresDisponibles() ?> </li>
                <li>FECHA CREACIÓN: <?= $libroPruebaGetterRescatado->getFechaCreacion() ?> </li>
                <li>FECHA ACTUALIZACIÓN: <?= $libroPruebaGetterRescatado->getFechaActualizacion() ?> </li>
            <?php  } catch (Exception $e) {
                var_dump($e);
            }
            ?>
        </ul>
        <hr />
        <h3>Probamos los setters en nuestro libro de prueba...</h3>
        <?php
        try {
            $libroPruebaSetter->setIsbn('9780451524936');
            $libroPruebaSetter->setTitulo('1984: El regreso.');
            $libroPruebaSetter->setAutor('Jorge Obien');
            $libroPruebaSetter->setAnioPublicacion(2005);
            $libroPruebaSetter->setPaginas(200);
            $libroPruebaSetter->setEjemplaresDisponibles(10);
        } catch (Exception $e) {
            var_dump($e);
        }
        ?>
        <hr />
        <h3>Guardamos más libros...</h3>
        <?php
        try {
            $libroPruebaDos->guardar($pdo);
            $libroPruebaTres->guardar($pdo);
            $libroPruebaSetter->guardar($pdo);
        } catch (Exception $e) {
            var_dump($e);
        }
        ?>
        <hr />
        <h3>Listado de todos los libros</h3>
        <?php
        try {
            $listadoLibros = Libros::listarLCU($pdo, true);
        ?>
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
                    <?php foreach ($listadoLibros as $libro): ?>
                        <!-- Iteramos el listado de instancias y obtenemos sus valores mediante los getters -->
                        <tr>
                            <td><?= $libro->getId() ?></td>
                            <td><?= $libro->getIsbn() ?></td>
                            <td><?= $libro->getTitulo() ?></td>
                            <td><?= $libro->getAutor() ?></td>
                            <td><?= $libro->getAnioPublicacion() ?></td>
                            <td><?= $libro->getPaginas() ?></td>
                            <td><?= $libro->getEjemplaresDisponibles() ?></td>
                            <td><?= $libro->getFechaCreacion() ?></td>
                            <td><?= $libro->getFechaActualizacion() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        } catch (Exception $e) {
            var_dump($e);
        }
        ?>
        <hr />
        <h3>Borramos el libro de Harry Potter...</h3>
        <p style="color: red;">¡Por favor, cambie el ID en el método Libro::borrar en el código por el que tenga el libro de Harry Potter y actualice la página para probarlo!</p>
        <?php
        try {
            Libro::borrar($pdo,165);
        } catch (Exception $e) {
            var_dump($e);
        }
        ?>
        <hr />
        <h3>Volvemos a listar</h3>
        <?php
        try {
            $listadoLibrosDos = Libros::listarLCU($pdo, true);
        ?>
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
                    <?php foreach ($listadoLibrosDos as $libro): ?>
                        <!-- Iteramos el listado de instancias y obtenemos sus valores mediante los getters -->
                        <tr>
                            <td><?= $libro->getId() ?></td>
                            <td><?= $libro->getIsbn() ?></td>
                            <td><?= $libro->getTitulo() ?></td>
                            <td><?= $libro->getAutor() ?></td>
                            <td><?= $libro->getAnioPublicacion() ?></td>
                            <td><?= $libro->getPaginas() ?></td>
                            <td><?= $libro->getEjemplaresDisponibles() ?></td>
                            <td><?= $libro->getFechaCreacion() ?></td>
                            <td><?= $libro->getFechaActualizacion() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        } catch (Exception $e) {
            var_dump($e);
        }
        ?>
        
    </main>
</body>