<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-hero">
    <div class="page-hero__inner">
        <h1 class="page-title">
            <?php if (isset($sprint)): ?>
                Historias — <?= htmlspecialchars($sprint['nombre']) ?>
            <?php else: ?>
                Todas las Historias
            <?php endif; ?>
        </h1>
        <a href="index.php?controller=historia&action=create" class="btn btn--primary">+ Nueva Historia</a>
    </div>
</section>

<?php

$estadoClases = [
    'nueva'       => 'badge--nueva',
    'activa'      => 'badge--activa',
    'finalizada'  => 'badge--finalizada',
    'impedimento' => 'badge--impedimento',
];
?>

<?php if (isset($porSprint)): ?>
    
    <?php if (empty($porSprint)): ?>
        <div class="empty-state">
            <span class="empty-icon">📝</span>
            <p>No hay historias registradas.</p>
            <a href="index.php?controller=historia&action=create" class="btn btn--primary">Crear primera historia</a>
        </div>
    <?php else: ?>
        <?php foreach ($porSprint as $nombreSprint => $items): ?>
        <div class="sprint-section">
            <h2 class="sprint-section__title"><?= htmlspecialchars($nombreSprint) ?></h2>
            <?= renderTablaHistorias($items, $estadoClases) ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

<?php else: ?>
    
    <?php if (empty($historias)): ?>
        <div class="empty-state">
            <span class="empty-icon">📝</span>
            <p>Este sprint no tiene historias aún.</p>
            <a href="index.php?controller=historia&action=create" class="btn btn--primary">Agregar historia</a>
        </div>
    <?php else: ?>
        <div class="sprint-section">
            <?= renderTablaHistorias($historias, $estadoClases) ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php
function renderTablaHistorias(array $items, array $estadoClases): string {
    ob_start(); ?>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Responsable</th>
                    <th>Estado</th>
                    <th>Puntos</th>
                    <th>Fecha creación</th>
                    <th>Fecha fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $h): ?>
                <tr>
                    <td class="td-titulo">
                        <strong><?= htmlspecialchars($h['titulo']) ?></strong>
                        <p class="td-desc"><?= htmlspecialchars(mb_substr($h['descripcion'], 0, 80)) ?>…</p>
                    </td>
                    <td><?= htmlspecialchars($h['responsable']) ?></td>
                    <td><span class="badge <?= $estadoClases[$h['estado']] ?>"><?= ucfirst($h['estado']) ?></span></td>
                    <td class="td-center"><span class="puntos-chip"><?= $h['puntos'] ?></span></td>
                    <td><?= date('d/m/Y', strtotime($h['fecha_creacion'])) ?></td>
                    <td><?= $h['fecha_finalizacion'] ? date('d/m/Y', strtotime($h['fecha_finalizacion'])) : '—' ?></td>
                    <td class="td-actions">
                        <a href="index.php?controller=historia&action=edit&id=<?= $h['id'] ?>" class="btn btn--sm btn--outline">Editar</a>
                        <a href="index.php?controller=historia&action=delete&id=<?= $h['id'] ?>"
                           class="btn btn--sm btn--danger"
                           onclick="return confirm('¿Eliminar esta historia?')">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php return ob_get_clean();
}
?>

<?php require __DIR__ . '/../layout/footer.php'; ?>