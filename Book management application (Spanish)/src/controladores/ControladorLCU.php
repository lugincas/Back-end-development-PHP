<?php

namespace ClasesLuis\controladores;

use ClasesLuis\modelo\Libro;
use ClasesLuis\modelo\Libros;

/**
 * Clase que representa un ejemplo de documentación en PHP.
 *
 * La clase ControladorLCU aglutina todos los controladores a utilizar 
 *
 * @author Luis Ginés Casanova
 */
class ControladorLCU
{

    /**
     * Controlador por defecto. Se muestra un listado de libros ordenado donde se incluirán todos los datos de la base de datos para cada libro.
     *
     * @param \PDO $pdo Conexión a base de datos.
     * @param \Smarty $smarty Instancia de Smarty
     */
    public static function controladorDefecto(\PDO $pdo, \Smarty $smarty)
    { 
        $listadoLibros = Libros::listarLCU($pdo, false);

        if ($listadoLibros !== false) { // Comprobamos si podemos listar los libros o si devuelve false
            $error = false; // El valor de la variable $error es false por defecto
            if (isset($_POST['orden'])) // Comprobamos que haya datos recibidos por el formulario con respecto al orden
            {
                $orden = intval(filter_input(INPUT_POST, 'orden')); // con intval, transformamos el texto recibido en un entero a la vez que eliminamos los espacios al principio y al final

                switch ($orden) {
                    case 1: // Si el valor recibido es 1, significa que el listado se ordena con true (descendente por fecha de creación)
                        $listadoLibros = Libros::listarLCU($pdo, true);
                        break;
                    case 0: // Si el valor recibido es 0, significa que el listado se ordena con false (descendente por fecha de actualización)
                        $listadoLibros = Libros::listarLCU($pdo, false);
                        break;
                    default: // En cualquier otro caso, se ordenaría con false (descendente por fecha de actualización)
                        $listadoLibros = Libros::listarLCU($pdo, false);
                        break;
                }

            } else { // En cualquier otro caso, listamos con orden descendente por fecha de actualización

                $listadoLibros = Libros::listarLCU($pdo, false);
            }
            
        } else {
            $error=true;
        }
        $smarty->assign('error', $error); // Asignamos el valor a la variable para operar con ella en la plantilla (Si error es true, se desplegará un mensaje de error)
        $smarty->assign('listadoLibros', $listadoLibros); // Asignamos el valor a la variable para operar con ella en la plantilla
        $smarty->display('listado.tpl'); // Desplegamos la plantilla principal con el listado de libros
    }

    /**
     * Controlador para mostrar un formulario con los datos necesarios para rellenar un nuevo libro.
     *
     * @param \Smarty $smarty Instancia de Smarty
     */
    public static function aniadirLibro(\Smarty $smarty)
    {
        $smarty->display('aniadirLibro.tpl');
    }

    /**
     * Controlador que comprueba que los datos recibidos del formulario para añadir libros son correctos y conforme a lo esperado, para dar de alta el libro y mostrar el ID del mismo.
     *
     * @param \PDO $pdo Conexión a base de datos.
     * @param \Smarty $smarty Instancia de Smarty
     */
    public static function crearLibro(\PDO $pdo, \Smarty $smarty)
    {
        if (isset($_POST) && is_array($_POST) && count($_POST) === 6) { // Comprobamos si se encuentran datos $_POST['accion'] y estos corresponden a "crear_libro_LCU"
            $mensajeError = ""; // Declaramos un mensaje de error, vacío en principio porque no habría ninguno

            $isbn = htmlspecialchars(trim(filter_input(INPUT_POST, 'isbn'))); // Formateamos el ISBN para que no tenga espacios al principio ni al final, ni carácteres especiales. También aplicamos esto al título y al autor
            $titulo = htmlspecialchars(trim(filter_input(INPUT_POST, 'titulo')));
            $autor = htmlspecialchars(trim(filter_input(INPUT_POST, 'autor')));
            $anioPublicacion = intval(filter_input(INPUT_POST, 'anioPublicacion')); // Con intval, transformamos el texto recibido en un entero a la vez que eliminamos los espacios al principio y al final. Lo aplicamos al año de publicación, a las páginas y a los ejemplares disponibles
            $paginas = intval(filter_input(INPUT_POST, 'paginas'));
            $ejemplaresDisponibles = intval(filter_input(INPUT_POST, 'ejemplaresDisponibles'));

            if ( // Realizamos todas las comprobaciones (si hay campos vacíos, si las cadenas y números son de la longitud que queremos, si el año es inferior o igual al actual, etc.)
                !empty($isbn) && strlen($isbn) == 13 &&
                !empty($titulo) && !empty($autor) && !empty($anioPublicacion) && is_integer($anioPublicacion) && $anioPublicacion > 0 && $anioPublicacion <= date("Y") && !empty($paginas) && is_integer($paginas) && $paginas > 0 && !empty($ejemplaresDisponibles) && is_integer($ejemplaresDisponibles) && $ejemplaresDisponibles > 0
            ) {

                $nuevoLibro = new Libro(null, $isbn, $titulo, $autor, $anioPublicacion, $paginas, $ejemplaresDisponibles); // Si los datos son correctos, cremos una instancia de la clase Libro, pasando por parámetro los datos que hemos extraido del formulario, ya filtrados

                $idNuevoLibro = $nuevoLibro->guardar($pdo); // Almacenamos en una variable el ID que retorna nuestro método guardar()

                if (is_integer($idNuevoLibro)) { // Si nuestra variable es un entero, asignamos el ID a la instancia de Smarty, así como el título del libro (lo he hecho para comprobar que funcionaba, pero creo que queda bien en la plantilla, así que lo he dejado) para mostrarlos por la plantilla exito.tpl
                    $smarty->assign('tituloLibro', $nuevoLibro->getTitulo());
                    $smarty->assign('idNuevoLibro', $idNuevoLibro);
                } else { // Si nuestra variable no es int, significa que es false (que es el otro valor que puede devolver el método guardar()). En ese caso, indicamos que el error ha sido porque el ISBN ya existe en la base de datos (ya que ha de ser único) o que existe otra razón relacionada con el método.
                    $mensajeError = "¡El libro no ha podido guardarse o el ISBN ya existe en la base de datos!";
                }
            } else { // Si los datos no son correctos, el mensaje que sacamos por la plantilla es ese mismo y hacemos un recordatorio de los requisitos para que estos sean correctos
                $mensajeError = "¡Los datos no son correctos! Recuerda:<ul>
                <li>No puedes dejar ningún campo vacío.</li>
                <li>El ISBN ha de tener 13 dígitos y el año de publicación no puede ser superior al año actual.</li>
                <li>Las páginas y ejemplares disponibles tienen que ser mayor de cero.</li> </ul>";
            }

            $smarty->assign('mensajeError', $mensajeError);
            $smarty->display('exitoAniadirLibro.tpl'); // Desplegamos nuestra plantilla
        }
    }

    /**
     * Controlador que envía el ID del libro a eliminar desde una plantilla a otra, para pedir confirmación y proceder, en caso afirmativo, a la eliminación del registro.
     *
     * @param \PDO $pdo Conexión a base de datos.
     * @param \Smarty $smarty Instancia de Smarty
     */
    public static function confirmarBorrado(\PDO $pdo, \Smarty $smarty)
    {
        if (isset($_POST['borrar'])) { // Comprobamos si se encuentran datos $_POST['accion'] del input oculto que hemos implementado para rescatar el ID del libro que queremos eliminar

            $idEliminar = $_POST['borrar']; // Almacenamos el ID que obtenemos a través del formulario

            $smarty->assign('idEliminar', $idEliminar); // Asignamos el valor a la variable para utilizarla en la plantilla de confirmación
            $smarty->display('confirmarBorrarLibro.tpl'); // Desplegamos nuestra plantilla de confirmación

        } elseif (isset($_POST['idEliminar']) && isset($_POST['confirmar'])) { // Si encontramos datos correspondientes al ID y la casilla de confirmación se marca, procedemos a la eliminación
            $mensajeErrorEliminar = ""; // Declaramos la cadena del mensaje de error como vacía
            $libroEliminado = $_POST['idEliminar']; // Almacenamos de nuevo el ID del libro que queremos eliminar en una variable

            $eliminacion = Libro::borrar($pdo, $libroEliminado); // Eliminamos el libro utilizando nuestro método para borrar libros desde la clase Libro y almacenamos el número de registros afectados en una variable

            if ($eliminacion < 1) { // Si no hay registros, asignamos un nuevo valor a la cadena del mensaje de error
                $mensajeErrorEliminar = "¡El libro con ID {$libroEliminado} ya no se encuentra en el listado!"; // Utilizamos la variable con el ID del libro que queríamos eliminar para informar al usuario
            }

            $smarty->assign('mensajeErrorEliminar', $mensajeErrorEliminar); // Asignamos los valores a las variables de la plantilla
            $smarty->assign('libroEliminado', $libroEliminado);
            $smarty->display('borrarLibro.tpl'); // Desplegamos nuestra plantilla con la información de la operación de eliminación
        }
    }
}
