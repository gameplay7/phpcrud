<?php
/** Procesa el formulario POST: crea o actualiza según el campo "accion". */
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$accion = $_POST['accion'] ?? '';
$id     = filter_var($_POST['id_libro'] ?? null, FILTER_VALIDATE_INT);

$datos = [
    'titulo'          => trim($_POST['titulo'] ?? ''),
    'isbn'            => trim($_POST['isbn'] ?? ''),
    'ano_publicacion' => trim($_POST['ano_publicacion'] ?? ''),
    'idioma'          => trim($_POST['idioma'] ?? ''),
    'numero_paginas'  => trim($_POST['numero_paginas'] ?? ''),
];

// ---------- Validaciones ----------
$errores = [];
if ($datos['titulo'] === '')  $errores[] = 'El título es obligatorio.';
if ($datos['isbn'] === '')    $errores[] = 'El ISBN es obligatorio.';
if ($datos['idioma'] === '')  $errores[] = 'El idioma es obligatorio.';
if (mb_strlen($datos['titulo']) > 150) $errores[] = 'El título no puede superar 150 caracteres.';
if (mb_strlen($datos['isbn']) > 50)    $errores[] = 'El ISBN no puede superar 50 caracteres.';
if (mb_strlen($datos['idioma']) > 50)  $errores[] = 'El idioma no puede superar 50 caracteres.';

$ano = filter_var($datos['ano_publicacion'], FILTER_VALIDATE_INT);
if ($ano === false || $ano <= 1500 || $ano > (int)date('Y') + 1) {
    $errores[] = 'El año debe ser un número entero mayor a 1500 y no futuro.';
}
$pag = filter_var($datos['numero_paginas'], FILTER_VALIDATE_INT);
if ($pag === false || $pag <= 0) {
    $errores[] = 'El número de páginas debe ser un entero mayor a 0.';
}
if (!in_array($accion, ['crear', 'actualizar'], true)) $errores[] = 'Acción no válida.';
if ($accion === 'actualizar' && !$id) $errores[] = 'ID de libro inválido.';

$volver = $accion === 'actualizar' ? 'editar.php?id_libro=' . (int)$id : 'crear.php';

if ($errores) {
    $_SESSION['errores'] = $errores;
    $_SESSION['old'] = $datos + ['id_libro' => $id];
    header("Location: $volver");
    exit;
}

// ---------- Persistencia con sentencias preparadas ----------
try {
    if ($accion === 'crear') {
        $sql = 'INSERT INTO libro (titulo, isbn, ano_publicacion, idioma, numero_paginas)
                VALUES (:titulo, :isbn, :ano, :idioma, :paginas)';
        $params = [];
    } else {
        $sql = 'UPDATE libro SET titulo = :titulo, isbn = :isbn, ano_publicacion = :ano,
                idioma = :idioma, numero_paginas = :paginas WHERE id_libro = :id';
        $params = [':id' => $id];
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params + [
        ':titulo'  => $datos['titulo'],
        ':isbn'    => $datos['isbn'],
        ':ano'     => $ano,
        ':idioma'  => $datos['idioma'],
        ':paginas' => $pag,
    ]);
    $_SESSION['mensaje'] = ['success', $accion === 'crear' ? 'Libro registrado correctamente.' : 'Libro actualizado correctamente.'];
    header('Location: index.php');
} catch (PDOException $e) {
    // 23000 = MySQL, 23505 = PostgreSQL (violación de UNIQUE)
    if (in_array($e->getCode(), ['23000', '23505'], true)) {
        $_SESSION['errores'] = ['Ya existe un libro con ese ISBN.'];
    } else {
        error_log($e->getMessage());
        $_SESSION['errores'] = ['Ocurrió un error al guardar. Intenta de nuevo.'];
    }
    $_SESSION['old'] = $datos + ['id_libro' => $id];
    header("Location: $volver");
}
exit;
