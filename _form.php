<?php
/** Formulario compartido por crear.php y editar.php. Espera: $libro (array), $accion, $errores (array) */
?>
<?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="guardar.php" method="POST" class="card card-body shadow-sm" novalidate>
    <input type="hidden" name="accion" value="<?= htmlspecialchars($accion) ?>">
    <?php if ($accion === 'actualizar'): ?>
        <input type="hidden" name="id_libro" value="<?= (int)$libro['id_libro'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Título *</label>
        <input type="text" name="titulo" maxlength="150" class="form-control" required
               value="<?= htmlspecialchars($libro['titulo']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">ISBN *</label>
        <input type="text" name="isbn" maxlength="50" class="form-control" required
               value="<?= htmlspecialchars($libro['isbn']) ?>">
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Año de publicación * (&gt; 1500)</label>
            <input type="number" name="ano_publicacion" class="form-control" required
                   value="<?= htmlspecialchars((string)$libro['ano_publicacion']) ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Idioma *</label>
            <input type="text" name="idioma" maxlength="50" class="form-control" required
                   value="<?= htmlspecialchars($libro['idioma']) ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Número de páginas * (&gt; 0)</label>
            <input type="number" name="numero_paginas" class="form-control" required
                   value="<?= htmlspecialchars((string)$libro['numero_paginas']) ?>">
        </div>
    </div>
    <div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
