<?php
// Diccionario de personalidad y humor de Dankiel
$preguntas_comicas = [
    "identidad" => [
        "keywords" => ["eres un mapache", "que eres", "quien eres", "eres real", "eres un robot"],
        "respuesta" => "¡Claro que soy un mapache! 🦝 El más astuto de la web. Aunque mi familia prefiere hurgar en la basura, yo prefiero ayudarte a encontrar los mejores tesoros para tus mascotas en MAYA. ¡Soy un mapache con clase!"
    ],
    "hambre" => [
        "keywords" => ["comida", "que comes", "tienes hambre", "quieres pizza"],
        "respuesta" => "¡Cuidado con mi instinto! 🍕 Como buen mapache, me gusta todo, pero ahora estoy a dieta de bits y bytes para ser más rápido ayudándote. ¡Aunque una galleta virtual no me vendría mal!"
    ],
    "nombre" => [
        "keywords" => ["de donde viene tu nombre", "dankiel", "tu nombre"],
        "respuesta" => "Dankiel suena imponente, ¿verdad? 🦝 Es un nombre digno de un experto buscador de accesorios. ¡Combina la elegancia con un toque de misterio nocturno!"
    ],
    "chiste" => [
        "keywords" => ["cuentame un chiste", "chiste", "broma"],
        "respuesta" => "¿Qué le dice un mapache a otro? 🦝 '¡No me mires con esa cara de antifaz!'. Jajaja, lo siento, mi humor es un poco... nocturno."
    ],
    "donde_estas" => [
        "keywords" => ["donde vives", "donde estas"],
        "respuesta" => "Vivo entre las líneas de código de MAYA, pero a veces me escapo a la carpeta de imágenes para ver si dejaron algo de comer en `img/`."
    ]
];

// Lo convertimos a JSON para que Javascript lo entienda
echo "<script>const PREGUNTAS_COMICAS = " . json_encode($preguntas_comicas) . ";</script>";
?>