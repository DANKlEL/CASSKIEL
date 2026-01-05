/**
 * Busca en el DOM (mini-carrito) la cantidad actual de un producto específico
 */
function obtenerCantDesdeCarrito(nombreCompleto) {
    const items = document.querySelectorAll('.mini-cart-item');
    let cantidadEncontrada = 1; // Por defecto 1 si no existe
    
    items.forEach(item => {
        const nombreItem = item.querySelector('div[style*="font-weight:bold"]').innerText.trim();
        if (nombreItem === nombreCompleto) {
            cantidadEncontrada = parseInt(item.querySelector('.qty-value').innerText);
        }
    });
    return cantidadEncontrada;
}

function enviarAlCarritoGlobal(nom, pre, img, cant) {
    const formData = new FormData();
    formData.append('nombre', nom);
    formData.append('precio', pre);
    formData.append('img', img);
    formData.append('cantidad', cant);
    formData.append('sustituir', 'true'); // Indicamos que debe reemplazar la cantidad

    fetch('/AccesoriosMaya/logica/gestionar_carrito.php', { method: 'POST', body: formData })
    .then(() => {
        if (typeof actualizarMiniCarrito === 'function') { actualizarMiniCarrito(); }
        Swal.fire({ 
            toast: true, position: 'top-end', icon: 'success', 
            title: 'Carrito actualizado', showConfirmButton: false, timer: 1500 
        });
    });
}

function configurarModalDinamico(precioBase, nombreBase) {
    const input = document.querySelector('.swal2-input');
    const totalText = document.getElementById('total-price-modal');
    
    const actualizarTotal = () => {
        totalText.innerText = (precioBase * parseInt(input.value)).toFixed(2);
    };

    window.cambiarColorModal = (color, idImg, idLabel, rutaBase) => {
        const nuevaRuta = `productosGatos/${rutaBase}${color}.png`;
        document.getElementById(idImg).src = "/AccesoriosMaya/img/" + nuevaRuta;
        document.getElementById(idLabel).innerText = "Color: " + color;
        
        // SINCRONIZACIÓN AL CAMBIAR COLOR:
        const nombreCompleto = `${nombreBase} (${color})`;
        input.value = obtenerCantDesdeCarrito(nombreCompleto);
        actualizarTotal();
        
        return { color, nuevaRuta };
    };

    if(input && totalText) {
        input.addEventListener('input', actualizarTotal);
    }
}