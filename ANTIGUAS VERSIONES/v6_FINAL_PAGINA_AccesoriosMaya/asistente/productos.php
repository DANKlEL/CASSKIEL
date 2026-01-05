<?php
// Catálogo Real usando la carpeta asistente/img/
$productos_maya = [
    "gatos" => [
        ["nombre" => "Torre Juguetero", "precio" => 850, "img" => "asistente/img/productosGatos/producto1Amarillo.png", "link" => "gatos.php"],
        ["nombre" => "Collar Elegante Azul", "precio" => 650, "img" => "asistente/img/productosGatos/producto1Azul.png", "link" => "gatos.php"],
        ["nombre" => "Poste Rascador", "precio" => 350, "img" => "asistente/img/productosGatos/producto2.png", "link" => "gatos.php"],
        ["nombre" => "Comedero Ergonomico", "precio" => 420, "img" => "asistente/img/productosGatos/producto3.png", "link" => "gatos.php"],
        ["nombre" => "Cama Confort Pro", "precio" => 550, "img" => "asistente/img/productosGatos/producto4.png", "link" => "gatos.php"]
    ],
    "perros" => [
        ["nombre" => "Hueso de Juguete", "precio" => 169, "img" => "asistente/img/productosPerros/producto1.png", "link" => "perros.php"],
        ["nombre" => "Casa Termica", "precio" => 1200, "img" => "asistente/img/productosPerros/producto2.png", "link" => "perros.php"],
        ["nombre" => "Collar de Cuero", "precio" => 350, "img" => "asistente/img/productosPerros/producto3.png", "link" => "perros.php"],
        ["nombre" => "Plato de Acero", "precio" => 280, "img" => "asistente/img/productosPerros/producto4.png", "link" => "perros.php"]
    ]
];

echo "<script>const CATALOGO_REAL = " . json_encode($productos_maya) . ";</script>";
?>