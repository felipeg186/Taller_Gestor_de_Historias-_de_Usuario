<?php
// Punto de entrada principal - Front Controller
session_start();

// Ruta base para CSS (relativa al index.php)
define('BASE_CSS', '');

// Autoload de clases
spl_autoload_register(function ($class) {
    $paths = ['models/', 'controllers/'];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Leer parámetros de la URL
$controller = $_GET['controller'] ?? 'sprint';
$action     = $_GET['action']     ?? 'index';
$id         = $_GET['id']         ?? null;

// Enrutamiento simple
switch ($controller) {
    case 'sprint':
        $ctrl = new SprintController();
        break;
    case 'historia':
        $ctrl = new HistoriaController();
        break;
    case 'reporte':
        $ctrl = new ReporteController();
        break;
    default:
        $ctrl = new SprintController();
        $action = 'index';
}

// Llamar acción
if (method_exists($ctrl, $action)) {
    $ctrl->$action($id);
} else {
    http_response_code(404);
    echo "<h1>Acción no encontrada</h1>";
}