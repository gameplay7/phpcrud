<?php
require 'header.php';

$accion  = 'crear';
$errores = $_SESSION['errores'] ?? [];
$libro   = $_SESSION['old'] ?? ['titulo' => '', 'isbn' => '', 'ano_publicacion' => '', 'idioma' => '', 'numero_paginas' => ''];
unset($_SESSION['errores'], $_SESSION['old']);
?>
<h1 class="h3 mb-3">Registrar nuevo libro</h1>
<?php require '_form.php'; require 'footer.php'; ?>
