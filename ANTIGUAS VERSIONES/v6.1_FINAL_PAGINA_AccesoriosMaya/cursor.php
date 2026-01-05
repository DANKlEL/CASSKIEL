<?php
// Obtenemos el nombre del archivo actual
$pagina_actual = basename($_SERVER['PHP_SELF']);

// Definimos el cursor por defecto
$ruta_cursor = 'img/cursor.png';

// Cambiamos según la página
if ($pagina_actual == 'gatos.php') {
    $ruta_cursor = 'img/cursorgato.png';
} elseif ($pagina_actual == 'perros.php') {
    $ruta_cursor = 'img/cursorperro.png';
}
?>

<style>
    /* Aplicamos el cursor a todo el cuerpo de la página y elementos interactivos */
    html, body {
        /* La sintaxis requiere la ruta y luego un cursor genérico (auto) */
        cursor: url('<?php echo $ruta_cursor; ?>'), auto !important;
    }

    /* Si quieres que en los botones y enlaces también cambie o se mantenga */
    a, button, #btn-asistente, #maya-launcher {
        cursor: url('<?php echo $ruta_cursor; ?>'), pointer !important;
    }
</style>