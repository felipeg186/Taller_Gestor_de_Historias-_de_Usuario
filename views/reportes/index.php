<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-hero">
    <div class="page-hero__inner">
        <h1 class="page-title">Reportes de Sprint</h1>
    </div>
</section>

<section class="reporte-page">

    
    <form method="GET" action="index.php" class="reporte-selector">
        <input type="hidden" name="controller" value="reporte">
        <input type="hidden" name="action" value="index">
        <div class="selector-row">
            <label for="sprint_id">Selecciona un Sprint:</label>
            <select name="sprint_id" id="sprint_id" onchange="this.form.submit()">
                <option value="">— Elige un sprint —</option>
                <?php foreach ($sprints as $s): ?>
                <option value="<?= $s['id'] ?>" <?= ($sprintId == $s['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['nombre']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if ($sprintSel && $resumen): ?>
    <div class="reporte-titulo">
        <h2>📊 <?= htmlspecialchars($sprintSel['nombre']) ?></h2>
        <p class="reporte-fechas">
            <?= date('d/m/Y', strtotime($sprintSel['fecha_inicio'])) ?>
            — <?= date('d/m/Y', strtotime($sprintSel['fecha_fin'])) ?>
        </p>
    </div>

    
    <div class="stats-row">
        <div class="stat-card stat-card--total">
            <span class="stat-card__num"><?= $resumen['total'] ?></span>
            <span class="stat-card__label">Total Historias</span>
        </div>
        <div class="stat-card stat-card--ok">
            <span class="stat-card__num"><?= $resumen['finalizadas'] ?></span>
            <span class="stat-card__label">Finalizadas</span>
        </div>
        <div class="stat-card stat-card--warn">
            <span class="stat-card__num"><?= $resumen['pendientes'] ?></span>
            <span class="stat-card__label">Pendientes</span>
        </div>
        <div class="stat-card stat-card--danger">
            <span class="stat-card__num"><?= $resumen['impedimentos'] ?></span>
            <span class="stat-card__label">Impedimentos</span>
        </div>
        <div class="stat-card stat-card--pts">
            <span class="stat-card__num"><?= $resumen['puntos_completados'] ?> / <?= $resumen['puntos_totales'] ?></span>
            <span class="stat-card__label">Puntos Completados</span>
        </div>
    </div>

    
    <?php
        $pct = $resumen['total'] > 0
            ? round(($resumen['finalizadas'] / $resumen['total']) * 100)
            : 0;
    ?>
    <div class="reporte-progress">
        <div class="reporte-progress__header">
            <span>Progreso general del sprint</span>
            <strong><?= $pct ?>%</strong>
        </div>
        <div class="progress-bar progress-bar--lg">
            <div class="progress-bar__fill" style="width: <?= $pct ?>%"></div>
        </div>
    </div>

    <?php if (!empty($porResponsable)): ?>
    <div class="reporte-seccion">
        <h3 class="reporte-seccion__titulo">Desglose por Responsable</h3>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Responsable</th>
                        <th>Total</th>
                        <th>Finalizadas</th>
                        <th>Pendientes</th>
                        <th>Impedimentos</th>
                        <th>Puntos</th>
                        <th>% Completado</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($porResponsable as $r): ?>
                    <?php $pctR = $r['total'] > 0 ? round(($r['finalizadas'] / $r['total']) * 100) : 0; ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($r['responsable']) ?></strong></td>
                        <td class="td-center"><?= $r['total'] ?></td>
                        <td class="td-center"><span class="badge badge--finalizada"><?= $r['finalizadas'] ?></span></td>
                        <td class="td-center"><span class="badge badge--activa"><?= $r['pendientes'] ?></span></td>
                        <td class="td-center"><span class="badge badge--impedimento"><?= $r['impedimentos'] ?></span></td>
                        <td class="td-center"><span class="puntos-chip"><?= $r['puntos_totales'] ?></span></td>
                        <td>
                            <div class="mini-bar">
                                <div class="mini-bar__fill" style="width: <?= $pctR ?>%"></div>
                            </div>
                            <span class="mini-pct"><?= $pctR ?>%</span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <?php elseif (isset($sprintId) && $sprintId > 0): ?>
        <div class="empty-state">
            <span class="empty-icon">📭</span>
            <p>Este sprint no tiene historias registradas.</p>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <span class="empty-icon">📊</span>
            <p>Selecciona un sprint arriba para ver su reporte.</p>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>