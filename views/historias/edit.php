<?php
/** @var array      $sprints        */
/** @var array|null $historia      */
?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="form-page">
    <div class="form-container form-container--wide">
        <div class="form-header">
            <a href="index.php?controller=historia&action=index" class="back-link">← Volver</a>
            <h1 class="form-title">Editar Historia</h1>
        </div>

        <?php if (!empty($errores)): ?>
        <div class="alert alert--error">
            <ul><?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=historia&action=edit&id=<?= $historia['id'] ?>" class="form-card">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo"
                       value="<?= htmlspecialchars($historia['titulo']) ?>" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($historia['descripcion']) ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="responsable">Responsable</label>
                    <input type="text" id="responsable" name="responsable"
                           value="<?= htmlspecialchars($historia['responsable']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="sprint_id">Sprint</label>
                    <select id="sprint_id" name="sprint_id" required>
                        <?php foreach ($sprints as $s): ?>
                        <option value="<?= $s['id'] ?>"
                            <?= ($historia['sprint_id'] == $s['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" required>
                        <?php foreach (['nueva','activa','finalizada','impedimento'] as $e): ?>
                        <option value="<?= $e ?>" <?= ($historia['estado'] === $e) ? 'selected' : '' ?>>
                            <?= ucfirst($e) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="puntos">Puntos de Complejidad</label>
                    <input type="number" id="puntos" name="puntos" min="1" max="100"
                           value="<?= htmlspecialchars($historia['puntos']) ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_creacion">Fecha de Creación</label>
                    <input type="date" id="fecha_creacion" name="fecha_creacion"
                           value="<?= htmlspecialchars($historia['fecha_creacion']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fecha_finalizacion">Fecha de Finalización <span class="label-opt">(opcional)</span></label>
                    <input type="date" id="fecha_finalizacion" name="fecha_finalizacion"
                           value="<?= htmlspecialchars($historia['fecha_finalizacion'] ?? '') ?>">
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php?controller=historia&action=index" class="btn btn--outline">Cancelar</a>
                <button type="submit" class="btn btn--primary">Actualizar Historia</button>
            </div>
        </form>
    </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>