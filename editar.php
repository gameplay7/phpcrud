<?php
require 'conexion.php';
session_start();

$id = filter_input(INPUT_GET, 'id_libro', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['mensaje'] = ['danger', 'ID de libro inválido.'];
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM libro WHERE id_libro = :id');
$stmt->execute([':id' => $id]);
$libro = $stmt->fetch();

if (!$libro) {
    $_SESSION['mensaje'] = ['danger', 'El libro no existe.'];
    header('Location: index.php');
    exit;
}


$errores = $_SESSION['errores'] ?? [];
if (!empty($_SESSION['old'])) {
    $libro = array_merge($libro, $_SESSION['old']);
    $libro['id_libro'] = $id;
}
unset($_SESSION['errores'], $_SESSION['old']);

$accion = 'actualizar';
require 'header.php';
?>
<h1 class="h3 mb-3">Editar libro #<?= (int)$id ?></h1>
<?php require '_form.php'; require 'footer.php'; ?>
