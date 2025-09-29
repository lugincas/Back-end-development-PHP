<?php

namespace ClasesLuis\modelo;

/**
 * Clase que representa un ejemplo de documentación en PHP.
 *
 * La clase Libro aglutina las características y datos de los libros de nuestra base de datos.
 * También implementa los métodos de la interfaz IGuardableLCU
 *
 * @author Luis Ginés Casanova
 */

class Libro implements IGuardableLCU
{
    private $id;
    private $isbn;
    private $titulo;
    private $autor;
    private $anioPublicacion;
    private $paginas;
    private $ejemplaresDisponibles;
    private $fechaCreacion;
    private $fechaActualizacion;

    public function __construct($id = null, $isbn = null, $titulo = null, $autor = null, $anioPublicacion = null, $paginas = null, $ejemplaresDisponibles = null, $fechaCreacion = null, $fechaActualizacion = null) // Establecemos los valores null por defecto
    {
        $this->id = $id;
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
        $this->paginas = $paginas;
        $this->ejemplaresDisponibles = $ejemplaresDisponibles;
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaActualizacion = $fechaActualizacion;
    }

    // MÉTODOS

    /**
    * Guarda el contenido asociado al libro en la base de datos, excepto fecha_creacion y fecha_actualización, que se modifican automáticamente por la base de datos
    * y el id, que se genera automáticamente.
    *
    * @param \PDO $pdo Conexión a base de datos.
    * @return int|false Devuelve el id del nuevo registro, y si no false.
    */
    public function guardar(\PDO $pdo): int|false
    {
        $SQL = "INSERT INTO libros (isbn, titulo, autor, anio_publicacion, paginas, ejemplares_disponibles) values (:isbn, :titulo, :autor, :anio_publicacion, :paginas, :ejemplares_disponibles)"; // CONSULTA INSERT
        try {
            $stmt = $pdo->prepare($SQL); // Preparamos la consulta y asignamos cada valor a la variable de la propia instancia de la clase Libro
            $stmt->bindValue(':isbn', $this->isbn);
            $stmt->bindValue(':titulo', $this->titulo);
            $stmt->bindValue(':autor', $this->autor);
            $stmt->bindValue(':anio_publicacion', $this->anioPublicacion);
            $stmt->bindValue(':paginas', $this->paginas);
            $stmt->bindValue(':ejemplares_disponibles', $this->ejemplaresDisponibles);
            
            if ($stmt->execute()) {
                
                $registrosInsertados = $stmt->rowCount(); // Contamos el número de registros insertados
                
                if ($registrosInsertados > 0) {
                    $id_nuevo_registro = $pdo->lastInsertId(); // Obtenemos el último ID insertado si se ha insertado algo nuevo

                    $this->id = $id_nuevo_registro;
                    
                    $consulta = "SELECT fecha_creacion, fecha_actualizacion FROM libros WHERE id=:ultimoId"; // CONSULTA SELECT

                    try {
                        $stmt = $pdo->prepare($consulta); // Preparamos la consulta que teníamos arriba. Esto genera un objeto tipo PDOStatment que guardamos en una variable 
                        $stmt->bindValue(':ultimoId', $id_nuevo_registro);
                        if ($stmt->execute()) { // Si es posible ejecutar, 
                            $fechas = $stmt->fetchAll(\PDO::FETCH_ASSOC); // Obtenemos los datos en un array asociativo y devolvemos el array
                            $this->fechaCreacion = $fechas[0]['fecha_creacion'];
                            $this->fechaActualizacion = $fechas[0]['fecha_actualizacion'];
                        }

                    } catch (\PDOException $ex) {
                        return false; // Este false será consecuencia de un fallo al ejecutrar el SELECT
                    }

                    return $id_nuevo_registro; // Si todo se ejecuta con éxito, devolvemos el ID

                }else{
                    return false; // Este false será consecuencia de un fallo en la ejecución
                }
            }
        } catch (\PDOException $ex) {
            
            return false; // Este false será consecuencia de un fallo en al ejecutar el INSERT
        }
        
        return false; // Cualquier otro tipo de fallo
    }

    /**
    * Rescata un registro con el id indicado y, además, rellena y retorna una instancia de la clase Libro con los datos rescatados
    *
    * @param \PDO $pdo Conexión a base de datos.
    * @param int $id id del libro que queremos rescatar.
    * @return Libro|false Devuelve una instancia de la clase Libro o false.
    */
    public static function rescatar(\PDO $pdo, int $id): Libro|false
    {
        $SQL = "SELECT * FROM libros WHERE id=:id"; // CONSULTA SELECT

        try {
            $stmt = $pdo->prepare($SQL); // Preparamos la consulta que teníamos arriba. Esto genera un objeto tipo PDOStatment que guardamos en una variable 
            $stmt->bindValue(':id', $id);
            if ($stmt->execute()) { // Si es posible ejecutar, 
                $registro = $stmt->fetchAll(\PDO::FETCH_ASSOC); // Obtenemos los datos en un array asociativo y devolvemos el array
                
                return new Libro($registro[0]['id'], $registro[0]['isbn'], $registro[0]['titulo'], $registro[0]['autor'], $registro[0]['anio_publicacion'], $registro[0]['paginas'], $registro[0]['ejemplares_disponibles'], $registro[0]['fecha_creacion'], $registro[0]['fecha_actualizacion']);
            }
        } catch (\PDOException $ex) {
            return false; // Este false será consecuencia de un fallo a la hora de ejecutar el SELECT
        }

        return false; // Cualquier otro tipo de fallo
    }

    /**
    * Borra el registro con el id indicado de la base de datos
    *
    * @param \PDO $pdo Conexión a base de datos.
    * @param int $id id del libro que queremos borrar.
    * @return int|false Devuelve el número de filas eliminadas de la base de datos o false.
    */
    public static function borrar(\PDO $pdo, int $id): int|false
    {
        $SQL = "DELETE FROM libros WHERE id=:id"; // CONSULTA DELETE

        try {
            $stmt = $pdo->prepare($SQL);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            if ($stmt->execute()) {
                $registrosEliminados = $stmt->rowCount(); // Contamos el número de registros eliminados
                if ($registrosEliminados === 1) { 
                    return $registrosEliminados; // Si existe el registro, devolvemos el número
                }
            }
        } catch (\PDOException $ex) {
            return false; // Este false será consecuencia de un fallo a la hora de ejecutar el DELETE
        }

        return false; // Cualquier otro tipo de fallo
    }

    // GETTERS (los colocamos después de los métodos para que actualice el valor del get si se utiliza guardar())
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function getAnioPublicacion(): ?int
    {
        return $this->anioPublicacion;
    }

    public function getPaginas(): ?int
    {
        return $this->paginas;
    }

    public function getEjemplaresDisponibles():?int
    {
        return $this->ejemplaresDisponibles;
    }

    public function getFechaCreacion(): ?string
    {
        return $this->fechaCreacion;
    }

    public function getFechaActualizacion(): ?string
    {
        return $this->fechaActualizacion;
    }

    // SETTERS 
    public function setIsbn(?string $isbn)
    {
        $this->isbn = $isbn;
    }

    public function setTitulo(?string $titulo)
    {
        $this->titulo = $titulo;
    }

    public function setAutor(?string $autor)
    {
        $this->autor = $autor;
    }

    public function setAnioPublicacion(?int $anioPublicacion)
    {
        $this->anioPublicacion = $anioPublicacion;
    }

    public function setPaginas(?int $paginas)
    {
        $this->paginas = $paginas;
    }

    public function setEjemplaresDisponibles(?int $ejemplaresDisponibles)
    {
        $this->ejemplaresDisponibles = $ejemplaresDisponibles;
    }
}
