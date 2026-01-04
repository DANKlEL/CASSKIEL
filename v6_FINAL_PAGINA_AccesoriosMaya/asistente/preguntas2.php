<?php
// Diccionario de Intenciones Vol. 2: Logística y Detalles Técnicos
$preguntas_v2 = [
    "pagos" => [
        "keywords" => ["pagar", "tarjeta", "efectivo", "oxxo", "transferencia", "deposito", "mercado pago", "paypal", "pago"],
        "respuesta" => "Aceptamos tarjetas de crédito, débito, transferencias y pagos en OXXO. ¿Te gustaría saber cómo finalizar tu compra en perros o gatos?"
    ],
    "envios_detalles" => [
        "keywords" => ["cuanto tarda", "llega hoy", "tiempo entrega", "envio gratis", "paqueteria", "estafeta", "fedex", "dhl", "seguimiento"],
        "respuesta" => "Nuestros envíos tardan de 1 a 3 días hábiles. ¡En compras mayores a $999 el envío es gratis! ¿Deseas ver productos para alcanzar el envío gratis?"
    ],
    "tallas_colores" => [
        "keywords" => ["talla", "grande", "chico", "mediano", "color", "rojo", "azul", "negro", "medida", "cm", "centimetros"],
        "respuesta" => "Contamos con variedad de tallas y colores en collares y casas. En la descripción de cada producto verás las medidas exactas. ¿Para qué mascota buscas?"
    ],
    "horarios_tienda" => [
        "keywords" => ["abierto", "cerrado", "horario", "puedo ir", "sucursal", "fisica", "visitar", "donde estan"],
        "respuesta" => "Nuestra tienda en línea opera 24/7. Nuestra ubicación física en Av. Té 950 abre de Lunes a Sábado de 9:00 AM a 6:00 PM. ¿Te ayudo a llegar?"
    ],
    "seguridad" => [
        "keywords" => ["seguro", "estafa", "confiable", "garantia", "devolucion", "cambio", "calidad"],
        "respuesta" => "Tu compra es 100% segura con encriptación SSL. Además, tenemos garantía de satisfacción. ¿Hay algún producto que te preocupe?"
    ],
    "contacto_humano" => [
        "keywords" => ["hablar con alguien", "whatsapp", "telefono", "correo", "ayuda real", "asesor", "persona"],
        "respuesta" => "Si prefieres hablar con un humano, llámanos al 55-4920-1863 o escríbenos a AccesoriosMaya@outlook.com. ¿Puedo ayudarte con algo más mientras tanto?"
    ]
];

// Inyectamos este segundo diccionario en una constante diferente
echo "<script>const BASE_PREGUNTAS_V2 = " . json_encode($preguntas_v2) . ";</script>";
?>