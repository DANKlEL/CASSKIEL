document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('header');

    // Detectar scroll para cambiar estilo del menú
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled'); // Cambia el estilo
        } else {
            header.classList.remove('scrolled'); // Restaura el estilo original
        }
    });
});
