<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="form-page">
    <div class="form-container">
        <div class="form-header">
            <a href="index.php?controller=sprint&action=index" class="back-link">← Volver</a>
            <h1 class="form-title">Nuevo Sprint</h1>
        </div>

        <?php if (!empty($errores)): ?>
        <div class="alert alert--error">
            <ul><?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=sprint&action=create" class="form-card">
            <div class="form-group">
                <label for="nombre">Nombre del Sprint</label>
                <input type="text" id="nombre" name="nombre"
                       value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                       placeholder="Ej: Sprint 1 – Autenticación" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                           value="<?= htmlspecialchars($_POST['fecha_inicio'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin</label>
                    <input type="date" id="fecha_fin" name="fecha_fin"
                           value="<?= htmlspecialchars($_POST['fecha_fin'] ?? '') ?>" required>
                </div>
            </div>
            <div class="form-actions">
                <a href="index.php?controller=sprint&action=index" class="btn btn--outline">Cancelar</a>
                <button type="submit" class="btn btn--primary">Guardar Sprint</button>
            </div>
        </form>
    </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>