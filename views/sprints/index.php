<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-hero">
    <div class="page-hero__inner">
        <h1 class="page-title">Sprints</h1>
        <a href="index.php?controller=sprint&action=create" class="btn btn--primary">+ Nuevo Sprint</a>
    </div>
</section>

<section class="cards-grid">
<?php if (empty($sprints)): ?>
    <div class="empty-state">
        <span class="empty-icon">📋</span>
        <p>No hay sprints registrados aún.</p>
        <a href="index.php?controller=sprint&action=create" class="btn btn--primary">Crear primer sprint</a>
    </div>
<?php else: ?>
    <?php foreach ($sprints as $sprint): ?>
    <div class="card sprint-card">
        <div class="card__header">
            <span class="sprint-badge">Sprint</span>
            <h2 class="card__title"><?= htmlspecialchars($sprint['nombre']) ?></h2>
        </div>
        <div class="card__body">
            <div class="sprint-dates">
                <div class="date-item">
                    <span class="date-label">Inicio</span>
                    <span class="date-value"><?= date('d/m/Y', strtotime($sprint['fecha_inicio'])) ?></span>
                </div>
                <span class="date-sep">→</span>
                <div class="date-item">
                    <span class="date-label">Fin</span>
                    <span class="date-value"><?= date('d/m/Y', strtotime($sprint['fecha_fin'])) ?></span>
                </div>
            </div>

            <div class="sprint-stats">
                <div class="stat">
                    <span class="stat__num"><?= $sprint['total_historias'] ?></span>
                    <span class="stat__label">Historias</span>
                </div>
                <div class="stat">
                    <span class="stat__num"><?= $sprint['finalizadas'] ?></span>
                    <span class="stat__label">Finalizadas</span>
                </div>
                <div class="stat">
                    <span class="stat__num"><?= $sprint['total_puntos'] ?? 0 ?></span>
                    <span class="stat__label">Puntos</span>
                </div>
            </div>

            <?php
                $total = (int)$sprint['total_historias'];
                $fin   = (int)$sprint['finalizadas'];
                $pct   = $total > 0 ? round(($fin / $total) * 100) : 0;
            ?>
            <div class="progress-bar">
                <div class="progress-bar__fill" style="width: <?= $pct ?>%"></div>
            </div>
            <p class="progress-label"><?= $pct ?>% completado</p>
        </div>
        <div class="card__actions">
            <a href="index.php?controller=historia&action=verSprint&id=<?= $sprint['id'] ?>" class="btn btn--sm btn--ghost">Ver historias</a>
            <a href="index.php?controller=sprint&action=edit&id=<?= $sprint['id'] ?>" class="btn btn--sm btn--outline">Editar</a>
            <a href="index.php?controller=sprint&action=delete&id=<?= $sprint['id'] ?>"
               class="btn btn--sm btn--danger"
               onclick="return confirm('¿Eliminar este sprint y todas sus historias?')">Eliminar</a>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>