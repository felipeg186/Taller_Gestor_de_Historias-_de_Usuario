<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Historias de Usuario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_CSS ?>views/css/styles.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a href="index.php?controller=sprint&action=index" class="brand">
            <span class="brand-icon">◈</span>
            <span class="brand-text">SprintBoard</span>
        </a>
        <nav class="main-nav">
            <a href="index.php?controller=sprint&action=index"   class="nav-link <?= (($_GET['controller'] ?? '') === 'sprint')  ? 'active' : '' ?>">Sprints</a>
            <a href="index.php?controller=historia&action=index" class="nav-link <?= (($_GET['controller'] ?? '') === 'historia') ? 'active' : '' ?>">Historias</a>
            <a href="index.php?controller=reporte&action=index"  class="nav-link <?= (($_GET['controller'] ?? '') === 'reporte')  ? 'active' : '' ?>">Reportes</a>
        </nav>
    </div>
</header>

<main class="site-main">
<?php
// Mensajes flash
$mensajes = [
    'sprint_creado'       => ['tipo' => 'ok',   'texto' => 'Sprint creado correctamente.'],
    'sprint_actualizado'  => ['tipo' => 'ok',   'texto' => 'Sprint actualizado correctamente.'],
    'sprint_eliminado'    => ['tipo' => 'warn',  'texto' => 'Sprint eliminado.'],
    'historia_creada'     => ['tipo' => 'ok',   'texto' => 'Historia creada correctamente.'],
    'historia_actualizada'=> ['tipo' => 'ok',   'texto' => 'Historia actualizada correctamente.'],
    'historia_eliminada'  => ['tipo' => 'warn',  'texto' => 'Historia eliminada.'],
];
if (!empty($_GET['msg']) && isset($mensajes[$_GET['msg']])) {
    $m = $mensajes[$_GET['msg']];
    echo "<div class=\"flash flash--{$m['tipo']}\">{$m['texto']}</div>";
}
?>