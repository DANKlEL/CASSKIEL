<?php
// Diccionario expandido de intenciones y respuestas
$preguntas_base = [
    "juguetes" => [
        "keywords" => ["juguete", "pelota", "hueso", "rascador", "torre", "raton", "frisbee", "diversion", "morder", "jugar"],
        "respuesta" => "¡La diversión es nuestra especialidad! Tenemos desde pelotas resistentes hasta torres gigantes. ¿Es para un perro o para un gato?"
    ],
    "casas" => [
        "keywords" => ["casa", "cama", "casita", "dormir", "cucha", "hamaca", "cojin", "descanso", "hogar"],
        "respuesta" => "Un buen descanso es vital. Tenemos casas térmicas y camas confort. ¿Buscas para perro o gato?"
    ],
    "higiene" => [
        "keywords" => ["baño", "limpio", "cepillo", "dientes", "shampoo", "jabon", "aliento", "peine"],
        "respuesta" => "¡Mantenerlos guapos es importante! Contamos con cepillos y accesorios de aseo en ambas secciones. ¿Para qué mascota buscas?"
    ],
    "collares" => [
        "keywords" => ["collar", "correa", "pechera", "arnes", "identificacion", "placa", "paseo"],
        "respuesta" => "¡Seguridad y estilo ante todo! Tenemos pecheras y collares de todos los tamaños. ¿Quieres ver de perro o gato?"
    ],
    "precios" => [
        "keywords" => ["barato", "economico", "oferta", "descuento", "costo", "precio", "cuanto vale", "promocion"],
        "respuesta" => "Manejamos precios muy accesibles desde $120 MXN. ¿Te gustaría ver las ofertas de perros o de gatos?"
    ]
];

// Convertimos a JSON para que JavaScript pueda leerlo fácilmente
echo "<script>const BASE_PREGUNTAS_EXTENSA = " . json_encode($preguntas_base) . ";</script>";
?>