<?php
require 'conexion.php';

$libros = $pdo->query('SELECT id_libro, titulo, isbn, ano_publicacion, idioma, numero_paginas
                       FROM libro ORDER BY id_libro')->fetchAll();

require 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Catálogo de libros</h1>
    <a href="crear.php" class="btn btn-success">+ Nuevo libro</a>
</div>

<div class="table-responsive">
<table class="table table-striped table-hover bg-white align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th><th>Título</th><th>ISBN</th><th>Año</th>
            <th>Idioma</th><th>Páginas</th><th class="text-end">Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!$libros): ?>
        <tr><td colspan="7" class="text-center text-muted">No hay libros registrados.</td></tr>
    <?php endif; ?>
    <?php foreach ($libros as $l): ?>
        <tr>
            <td><?= (int)$l['id_libro'] ?></td>
            <td><?= htmlspecialchars($l['titulo']) ?></td>
            <td><?= htmlspecialchars($l['isbn']) ?></td>
            <td><?= (int)$l['ano_publicacion'] ?></td>
            <td><?= htmlspecialchars($l['idioma']) ?></td>
            <td><?= (int)$l['numero_paginas'] ?></td>
            <td class="text-end">
                <a href="editar.php?id_libro=<?= (int)$l['id_libro'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <form action="eliminar.php" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar este libro?');">
                    <input type="hidden" name="id_libro" value="<?= (int)$l['id_libro'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php require 'footer.php'; ?>
