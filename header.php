<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioExpress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">📚 BiblioExpress</a>
    </div>
</nav>
<div class="container">
<?php
if (!empty($_SESSION['mensaje'])) {
    [$tipo, $texto] = $_SESSION['mensaje'];
    echo '<div class="alert alert-' . htmlspecialchars($tipo) . '">' . htmlspecialchars($texto) . '</div>';
    unset($_SESSION['mensaje']);
}
