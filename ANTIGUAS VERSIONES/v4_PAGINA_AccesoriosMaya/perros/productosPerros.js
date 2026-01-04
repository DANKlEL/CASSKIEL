/**
 * Busca en el DOM (mini-carrito) la cantidad actual de un producto de perros específico
 */
function obtenerCantDesdeCarrito(nombreCompleto) {
    const items = document.querySelectorAll('.mini-cart-item');
    let cantidadEncontrada = 1; 
    
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
    formData.append('sustituir', 'true'); 

    fetch('/AccesoriosMaya/logica/gestionar_carrito.php', { method: 'POST', body: formData })
    .then(() => {
        if (typeof actualizarMiniCarrito === 'function') { actualizarMiniCarrito(); }
        Swal.fire({ 
            toast: true, position: 'top-end', icon: 'success', 
            title: 'Carrito actualizado (Perros)', showConfirmButton: false, timer: 1500 
        });
    });
}

function configurarModalDinamico(precioBase, nombreBase) {
    const input = document.querySelector('.swal2-input');
    const totalText = document.getElementById('total-price-modal');
    
    const actualizarTotal = () => {
        if(input.value < 1) input.value = 1;
        totalText.innerText = (precioBase * parseInt(input.value)).toFixed(2);
    };

    window.cambiarColorModal = (color, idImg, idLabel, rutaBase) => {
        // Ajustamos la ruta para que apunte a la carpeta de perros
        const nuevaRuta = `productosPerros/${rutaBase}${color}.png`;
        document.getElementById(idImg).src = "/AccesoriosMaya/img/" + nuevaRuta;
        document.getElementById(idLabel).innerText = "Color: " + color;
        
        const nombreCompleto = `${nombreBase} (${color})`;
        input.value = obtenerCantDesdeCarrito(nombreCompleto);
        actualizarTotal();
        
        return { color, nuevaRuta };
    };

    if(input && totalText) {
        input.addEventListener('input', actualizarTotal);
    }
}