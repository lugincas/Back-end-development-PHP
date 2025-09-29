<?php
// Luis Ginés Casanova de Utrilla - DAW (DWES)

require_once __DIR__ . '/vendor/autoload.php'; // Usamos el autoloading PSR-4 para cargar todas las clases
require_once __DIR__ . '/etc/configBd.php'; // Utilizamos la configuración a la base de datos
use ClasesLuis\controladores\ControladorLCU; // Usamos nuestro controlador 

// Conexión a la base de datos
try {
    $pdo = new PDO(DSN, USUARIO, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Instanciación e invación de las vistas mediante Smarty
$smarty = new Smarty;
$smarty->template_dir = __DIR__ . '/plantillas';
$smarty->compile_dir = __DIR__ . '/plantillas_compiladas';
$smarty->cache_dir = __DIR__ . '/cache';

// Invocación de los controladores 

switch ($_GET['accion']) {
    case 'nuevo_libro_form_LCU':
        ControladorLCU::aniadirLibro($smarty);
        break;
    case 'crear_libro_LCU':
        ControladorLCU::crearLibro($pdo, $smarty);
        break;
    case 'borrar_libro_LCU':
    case 'confirmar': // Incluimos también el caso confirmar para que siga usando el mismo controlador al completar el formulario de confirmación
        ControladorLCU::confirmarBorrado($pdo, $smarty);
        break;
    default:
        ControladorLCU::controladorDefecto($pdo, $smarty);
        break;
}

