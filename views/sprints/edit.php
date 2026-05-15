<?php
/** @var array      $sprint        */
?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="form-page">
    <div class="form-container">
        <div class="form-header">
            <a href="index.php?controller=sprint&action=index" class="back-link">← Volver</a>
            <h1 class="form-title">Editar Sprint</h1>
        </div>

        <?php if (!empty($errores)): ?>
        <div class="alert alert--error">
            <ul><?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=sprint&action=edit&id=<?= $sprint['id'] ?>" class="form-card">
            <div class="form-group">
                <label for="nombre">Nombre del Sprint</label>
                <input type="text" id="nombre" name="nombre"
                       value="<?= htmlspecialchars($sprint['nombre']) ?>" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                           value="<?= htmlspecialchars($sprint['fecha_inicio']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin</label>
                    <input type="date" id="fecha_fin" name="fecha_fin"
                           value="<?= htmlspecialchars($sprint['fecha_fin']) ?>" required>
                </div>
            </div>
            <div class="form-actions">
                <a href="index.php?controller=sprint&action=index" class="btn btn--outline">Cancelar</a>
                <button type="submit" class="btn btn--primary">Actualizar Sprint</button>
            </div>
        </form>
    </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>