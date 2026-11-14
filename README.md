# BiblioExpress – CRUD en PHP puro + PDO

## Puesta en marcha
1. Ejecuta `database.sql` en MySQL (o adapta a PostgreSQL según los comentarios).
2. Ajusta credenciales en `conexion.php` o con variables de entorno:
   `DB_DRIVER` (mysql|pgsql), `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`.
3. Copia la carpeta a `htdocs` (XAMPP) o ejecuta dentro de ella:
   `php -S localhost:8000` y abre http://localhost:8000
   (PostgreSQL requiere la extensión `pdo_pgsql` habilitada).

## Archivos
- conexion.php – conexión PDO modular (excepciones, sin exponer credenciales)
- index.php – listado (Read)
- crear.php / guardar.php – alta (Create); guardar.php también procesa la edición
- editar.php – formulario cargado por GET `id_libro` (Update)
- eliminar.php – borrado por POST (Delete)
- header.php, footer.php, _form.php – piezas compartidas
