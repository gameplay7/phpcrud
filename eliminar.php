<?php
/** Borrado seguro: solo por POST y con sentencia preparada. */
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id_libro', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['mensaje'] = ['danger', 'ID de libro inválido.'];
} else {
    try {
        $stmt = $pdo->prepare('DELETE FROM libro WHERE id_libro = :id');
        $stmt->execute([':id' => $id]);
        $_SESSION['mensaje'] = $stmt->rowCount()
            ? ['success', 'Libro eliminado correctamente.']
            : ['warning', 'El libro no existe.'];
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['mensaje'] = ['danger', 'No se pudo eliminar el libro.'];
    }
}
header('Location: index.php');
exit;
