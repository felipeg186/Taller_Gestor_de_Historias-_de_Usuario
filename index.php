<?php
session_start();

define('BASE_CSS', '');

spl_autoload_register(function ($class) {
    $paths = ['models/', 'controllers/'];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

$controller = $_GET['controller'] ?? 'sprint';
$action     = $_GET['action']     ?? 'index';
$id         = $_GET['id']         ?? null;

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

if (method_exists($ctrl, $action)) {
    $ctrl->$action($id);
} else {
    http_response_code(404);
    echo "<h1>Acción no encontrada</h1>";
}