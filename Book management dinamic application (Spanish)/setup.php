<?php

/* 
 * Luis Ginés Casanova de Utrilla
 * Desarrollo Web en Entorno Servidor - 2025 
 */

require_once __DIR__ . '/comun.php';

use Jaxon\Jaxon;
use Jaxon\Response\Response;

$jaxon = jaxon();
$jaxon->setOption("js.lib.uri", BASE_URL . "jaxon-dist");
$jaxon->setOption('core.request.uri', BASE_URL . 'backend.php');

/* Conexión a la base de datos para utilizarla en nuestras consultas */
function conexion_bd()
{ 
    try {
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function logMessage(Response $r, mixed $dato)
{
    $r->append('log', 'innerHTML', '<div>' . print_r($dato, true) . '</div>');
}

function funcion1($fechaYhora)
{
    $response = new Response();
    logMessage($response, "La fecha y la hora es: $fechaYhora");
    return $response;
}

function funcion2($nombre)
{
    $response = new Response();
    logMessage($response, "El nombre del autor o autora es $nombre");
    return $response;
}


/* Función que se encarga de mostrar el listado de libros de nuestra base de datos */
function listarLibrosLCU()
{

    $pdo = conexion_bd(); // Instanciamos una conexión a la base de datos
    $response = new Response(); // Declaramos una nueva instancia de la clase Response(), que encapsula la respuesta HTTP que la aplicación envía al cliente para desencadenar determinados eventos en la interfaz del usuario
    $response->clear('listaLibros'); // Limpiamos el contenido del div 'listaLibros' antes de listar los libros

    $SQL = "SELECT * FROM libros"; // Consulta para seleccionar todos los elementos de la tabla libros
    try {
        $stmt = $pdo->prepare($SQL); // Preparamos la consulta que teníamos arriba. Esto genera un objeto tipo PDOStatment que guardamos en una variable 

        if ($stmt->execute()) {
            $libros = $stmt->fetchAll(\PDO::FETCH_ASSOC); // Si se ejecuta con éxito, obtenemos los datos en un array asociativo y los almacenamos en una variable

            $response->append('listaLibros', 'innerHTML', '<table>'); // Añadimos contenido al div 'listaLibros', en este caso la etiqueta de inicio de una tabla
            $response->append('listaLibros', 'innerHTML', '<thead>'); // Añadimos contenido al div 'listaLibros', en este caso la etiqueta de inicio de la cabecera de la tabla
            $response->append( // Añadimos la fila de encabezados de cada columna
                'listaLibros',
                'innerHTML',
                '<tr>
                    <td>ID</td>
                    <td>ISBN</td>
                    <td>TÍTULO</td>
                    <td>AUTOR</td>
                    <td>AÑO DE PUBLICACIÓN</td>
                    <td>PÁGINAS</td>
                    <td>EJEMPLARES</td>
                    <td>FECHA CREACIÓN</td>
                    <td>FECHA ACTUALIZACIÓN</td>
                </tr>'
            );
            $response->append('listaLibros', 'innerHTML', '</thead>'); // Cerramos la cabecera de la tabla
            $response->append('listaLibros', 'innerHTML', '<tbody>'); // Abrimos el cuerpo de la tabla
            foreach ($libros as $registro) { // Recorremos el array asociativo que hemos obtenido de la consulta con los datos de los libros y rellenamos cada fila con los valores utilizando $response->append()
                $response->append('listaLibros', 'innerHTML', '<tr>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['id'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['isbn'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['titulo'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['autor'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['anio_publicacion'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['paginas'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['ejemplares_disponibles'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['fecha_creacion'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '<td>' . $registro['fecha_actualizacion'] . '</td>');
                $response->append('listaLibros', 'innerHTML', '</tr>');
            }
            $response->append('listaLibros', 'innerHTML', '</tbody>'); // Cerramos el cuerpo de la tabla
            $response->append('listaLibros', 'innerHTML', '</table>'); // Cerramos la tabla
            return $response; // Devolvemos la respuesta al llamar a esta función
        }
    } catch (\PDOException $ex) { // Si hay problemas con la conexión a la base de datos, informamos de ello
        $response->assign('listaLibros', 'innerHTML', " Ha ocurrido un problema con la base de datos y no se han podido mostrar los libros..."); // Utilizamos assign para sustituir el contenido por este mensaje
        return $response;
    }

    return $response;
}

/* Función que se encarga de registrar un nuevo libro en nuestra base de datos */
function registrarLibroLCU($valoresFormulario) // Los datos pasados por parámetro los recibimos desde el formulario que hemos desplegado en el lado del cliente, al hacer click en el botón que dispara esta función en el propio formulario
{
    $pdo = conexion_bd(); // Instanciamos una conexión a la base de datos
    $response = new Response(); // Declaramos una nueva instancia de la clase Response(), que encapsula la respuesta HTTP que la aplicación envía al cliente para desencadenar determinados eventos en la interfaz del usuario
    $mensajesError = []; // Declaramos un mensaje de error, vacío en principio porque no habría ninguno

    /* Consultas para realizar a la base de datos */
    $consultaInsert = "INSERT INTO libros (isbn, titulo, autor, anio_publicacion, paginas, ejemplares_disponibles) values (:isbn, :titulo, :autor, :anio_publicacion, :paginas, :ejemplares_disponibles)"; // Consulta para insertar el ejemplar una vez se hayan saneado y comprobado los datos
    $consultaIsbn = "SELECT isbn FROM libros"; // Consulta para obtener todos los ISBN de la tabla y poder comprobar que el libro que añadimos no lo repite

    $isbn = htmlspecialchars(trim(intval($valoresFormulario['isbn']))); // Formateamos el ISBN para que no tenga espacios al principio ni al final, ni carácteres especiales. También aplicamos esto al título y al autor. Además, con intval transformamos el texto recibido en un entero. Lo aplicamos al año de publicación, a las páginas y a los ejemplares disponibles
    $titulo = htmlspecialchars(trim($valoresFormulario['titulo']));
    $autor = htmlspecialchars(trim($valoresFormulario['autor']));
    $anioPublicacion = intval($valoresFormulario['anio']); 
    $paginas = intval($valoresFormulario['paginas']);
    $ejemplaresDisponibles = intval($valoresFormulario['ejemplares']);

    try {
        $stmtIsbn = $pdo->prepare($consultaIsbn); // Preparamos la consulta para obtener todos los ISBN. Esto genera un objeto tipo PDOStatment que guardamos en una variable 

        if ($stmtIsbn->execute()) {
            $arrayIsbn = $stmtIsbn->fetchAll(\PDO::FETCH_COLUMN); // Si se ejecuta con éxito, obtenemos los datos de la columna correspondiente al ISBN y los almacenamos en un array
            if (in_array($isbn, $arrayIsbn)) { // Comprobamos si el ISBN que introducimos en el formulario se encuentra en el array que contiene los ISBN de la tabla
                logMessage($response, "El ISBN $isbn ya existe en la base de datos. Por favor, introduce uno diferente."); // Si es así, informamos de ello mediante un mensaje de log y devolvemos la respuesta
                return $response;
            }
        }
    } catch (\PDOException $ex) { // Si ocurre algún tipo de error con esta conexión, informamos de que ha sido a la hora de consultar el ISBN (para identificar entre otros posibles errores derivados de conexiones a bases de datos)
        logMessage($response, "¡Fallo a la hora de consultar el ISBN en la base de datos!");
        return $response;
    }

    try {
        $stmt = $pdo->prepare($consultaInsert); // Preparamos la consulta para insertar valores en la tabla y llevamos a cabo cada comprobación de manera unitaria para, en caso de que no se resuelvan con éxito, podamos ir almacenando los errores recibidos en nuestro array de errores. Si los datos cumplen los requisitos comprobados, vinculamos ese dato específico al valor de la consulta preparada

        if (!empty($isbn) && strlen($isbn) <= 13) { // ISBN: Longitud máxima 13, no vacío (intval ya comprueba que se devuelven carácteres numéricos)
            $stmt->bindValue(':isbn', $isbn);
        } else {
            $mensajesError[] = "El ISBN es incorrecto. No puede estar vacío, su longitud no puede superar los 13 caracteres y estos han de ser numéricos.";
        }

        if (!empty($titulo) && strlen($titulo) < 255) { // Título: Longitud máxima 255, no vacío
            $stmt->bindValue(':titulo', $titulo);
        } else {
            $mensajesError[] = "El título es incorrecto. No puede estar vacío y su longitud no puede superar los 255 caracteres.";
        }

        if (!empty($autor) && strlen($autor) < 255) { // Autor: Longitud máxima 255, no vacío
            $stmt->bindValue(':autor', $autor);
        } else {
            $mensajesError[] = "El nombre del autor o de la autora es incorrecto. No puede estar vacío y su longitud no puede superar los 255 caracteres.";
        }

        if (is_integer($anioPublicacion) && $anioPublicacion > 0 && $anioPublicacion <= date("Y")) { // Año de publicación: Número entero (aunque intval ya los transforma), mayor de cero y menor (o igual) al año actual
            $stmt->bindValue(':anio_publicacion', $anioPublicacion);
        } else {
            $mensajesError[] = "El año de la publicación es incorrecto. Ha de ser un número entero, mayor que cero y menor o igual al año actual.";
        }

        if (is_integer($paginas) && $paginas > 0) { // Páginas: Número entero (aunque intval ya los transforma) y mayor de cero
            $stmt->bindValue(':paginas', $paginas);
        } else {
            $mensajesError[] = "El número de páginas es incorrecto. Ha de ser un número entero mayor que cero.";
        }

        if (is_integer($ejemplaresDisponibles) && $ejemplaresDisponibles > 0) { // Ejemplares: Número entero (aunque intval ya los transforma) y mayor de cero
            $stmt->bindValue(':ejemplares_disponibles', $ejemplaresDisponibles);
        } else {
            $mensajesError[] = "El número de ejemplares disponibles es incorrecto. Ha de ser un número entero mayor que cero.";
        }

        if (!empty($mensajesError)) { // Si existe algún error en el array, desplegamos los mensajes y devolvemos la respuesta
            foreach ($mensajesError as $mensaje) {
                logMessage($response, $mensaje . "<br/>");
            }
            return $response;

        } else { // Si no existe ningún error, pasamos a la comprobación de la ejecución de la consulta
            if ($stmt->execute()) {

                $registrosInsertados = $stmt->rowCount(); // Si el insert se ejecuta con éxito, contamos el número de registros insertados y los almacenamos en una variable

                if ($registrosInsertados > 0) { // Comprobamos si hay un nuevo registro insertado (si el recuento devuelve un número mayor que cero)
                    $id_nuevo_registro = $pdo->lastInsertId(); // Si es así, obtenemos el último ID insertado si se ha insertado algo nuevo
                    logMessage($response, "¡El libro se añadió con éxito! Su ID es $id_nuevo_registro | Luis Ginés Casanova de Utrilla"); // Devolvemos ese ID junto a mi nombre y apellidos
                    $response->call('jaxon_listarLibrosLCU'); // Llamamos a la función que lista los libros de la tabla, para obtener la lista actualizada
                    return $response;
                } else { // Si no hay un registro nuevo, informamos de ello al usuario
                    logMessage($response, "¡No se ha registrado nuevo libro!");
                    return $response;
                }
            }
        }
    } catch (\PDOException $ex) { // Si ocurre algún tipo de error con esta conexión, informamos de que ha sido un fallo general a la hora de introducir los datos (para identificar entre otros posibles errores derivados de conexiones a bases de datos)
        logMessage($response, "¡Fallo general en la base de datos!");
        return $response;
    }

    logMessage($response, "Parece que se ha producido algún tipo de error..."); // Si llegasemos por cualquier motivo a aquí, informamos de que ha ocurrido algún tipo de error no identificado
    return $response;
}

/* Función que, a partir del ISBN de un libro, crea una lista con autores y autoras que tienen un nombre similar al autor del libro cuyo ISBN hemos introducido */
function listarLibrosAutor($isbnAutor) // El ISBN lo recibimos por parámetro desde el lado del cliente, al introducirlo en su input correspondiente, que llama a esta función
{
    $isbn = htmlspecialchars(trim(intval($isbnAutor))); // Formateamos el ISBN para que no tenga espacios al principio ni al final, ni carácteres especiales. Además, con intval transformamos el texto recibido en un entero
    if (!empty($isbn) && strlen($isbn) <= 13 && $isbn > 0) { // Comprobamos que no esté vacío, que el ISBN sea mayor a 0 y que la longitud máxima sea 13. Si es así, procedemos a realizar las operaciones
        $pdo = conexion_bd(); // Instanciamos una conexión a la base de datos
        $clienteHTTP = new GuzzleHttp\Client(); // Creamos un cliente HTTP con Guzzle
        $response = new Response(); // Declaramos una nueva instancia de la clase Response(), que encapsula la respuesta HTTP que la aplicación envía al cliente para desencadenar determinados eventos en la interfaz del usuario

        $response->clear('otros_libros_autor'); // Limpiamos el contenido del div 'otros_libros_autor' antes de listar los libros

        /* Consultas para realizar a la base de datos */
        $consultaIsbn = "SELECT isbn FROM libros"; // Consulta para obtener todos los ISBN de la tabla y poder comprobar que el libro que añadimos existe en ella
        $consultaAutor = "SELECT autor FROM libros WHERE isbn=:isbn"; // Consulta para obtener el nombre del autor que coincide con el ISBN introducido a través del input

        try {
            $stmtIsbn = $pdo->prepare($consultaIsbn); // Preparamos la consulta para el ISBN

            if ($stmtIsbn->execute()) {
                $arrayIsbn = $stmtIsbn->fetchAll(\PDO::FETCH_COLUMN); // Si se ejecuta con éxito, obtenemos los datos de la columna correspondiente al ISBN y los almacenamos en un array
                if (!in_array($isbn, $arrayIsbn)) { // Comprobamos si el ISBN que introducimos en el formulario se encuentra en el array que contiene los ISBN de la tabla
                    logMessage($response, "El ISBN $isbn no existe en la base de datos. Por favor, introduce uno que exista en nuestra base de datos."); // Si no es así, informamos de ello mediante un mensaje de log y devolvemos la respuesta
                    return $response;
                }
            }
        } catch (\PDOException $ex) { // Si ocurre algún tipo de error con esta conexión, informamos de que ha sido a la hora de consultar el ISBN (para identificar entre otros posibles errores derivados de conexiones a bases de datos)
            logMessage($response, "¡Fallo a la hora de consultar el ISBN en la base de datos!");
            return $response;
        }

        try {
            $stmt = $pdo->prepare($consultaAutor); // Preparamos la consulta para localizar al autor que coincide con el ISBN proporcionado
            $stmt->bindValue(':isbn', $isbn); // Vinculamos el ISBN proporcionado a la consulta
            if ($stmt->execute()) { // Si es posible ejecutar, procedemos a lo siguiente:
                $autorEncontrado = $stmt->fetch(PDO::FETCH_COLUMN); // Almacenamos el nombre del autor en una variable
                logMessage($response, "¡$autorEncontrado está en la base de datos!"); // Informamos de que el autor o la autora se encuentra en la base de datos mediante un mensaje de log

                $divisionNombre = explode(" ", $autorEncontrado); // Generamos un array a partir del nombre encontrado, separado por espacios
                $apellidoAutor = $divisionNombre[count($divisionNombre) - 1]; // Obtenemos el apellido del autor o autora para obtener coincidencias más allá del nombre completo

                /* Asignamos algunos estilos al div 'otros_libros_autor' */
                $response->assign('otros_libros_autor', 'style.display', 'block');
                $response->assign('otros_libros_autor', 'style.border', '2px dotted blue');
                $response->assign('otros_libros_autor', 'style.padding', '10px');

                try {
                    $peticionClaveAutor = $clienteHTTP->request('GET', 'https://openlibrary.org/search/authors.json?q=' . $apellidoAutor); // Enviamos una solicitud GET a la API de openlibrary.org proporcionada para conseguir los datos del nombre consultado (añadimos el apellido obtenido a la solicitud después de la 'q' porque es el parámetro de consulta de esta API)
                    $body = $peticionClaveAutor->getBody()->getContents(); // Obtenemos el contenido en texto recibido desde el servidor y accedemos al mismo con getContents()

                    $arrayDatosAutores = json_decode($body, true); // Decodificamos la cadena de texto JSON y la transformamos en un array asociativo (poniendo true como segundo parámetro)

                    foreach ($arrayDatosAutores['docs'] as $autor) { // Recorremos, dentro del array obtenido, el array de 'docs'
                        if (isset($autor['top_work'])) { // Si la entrada consta del título principal ('top_work' que es el que queremos consultar), procedemos a mostrarlo en el HTML
                            $response->append('otros_libros_autor', 'innerHTML', 'Título: <i>' . $autor['top_work'] . '</i> | Autor/a: <strong>' . $autor['name'] . '</strong><br/><br/>'); // Añadimos el par libro | autor/a al div 'otros_libros_autor' para generar la lista
                        }
                    }
                } catch (GuzzleHttp\Exception\RequestException $e) { //Tratamos posibles errores al realizar la petición

                    logMessage($response, "Se ha producido un error al realizar la petición a la API...");
                    return $response;
                }

                return $response; // Devolvemos la respuesta
            }
        } catch (\PDOException $ex) { // Si ocurre algún tipo de error con esta conexión, informamos de que ha sido un fallo general (para identificar entre otros posibles errores derivados de conexiones a bases de datos)
            logMessage($response, "¡Fallo general en la base de datos!");
            return $response;
        }
    }
}

/* Registramos las funciones */
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'funcion1');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'funcion2');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'listarLibrosAutor');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'listarLibrosLCU');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'registrarLibroLCU');
