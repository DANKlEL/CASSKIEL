<?php 
// CORRECCIÓN: Salimos de la carpeta 'auth' para encontrar 'estructura'
include '../estructura/head.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="/AccesoriosMaya/css/login/login.css">

<?php 
// CORRECCIÓN: Subimos un nivel para el header
include '../estructura/header.php'; 
?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Bienvenido</h2>
        <p>Inicia sesión en Accesorios Maya</p>
        
        <form onsubmit="event.preventDefault(); ejecutarLogin();">
            <div class="input-group">
                <input type="email" id="logEmail" placeholder="Correo electrónico" required>
            </div>
            
            <div class="input-group">
                <input type="password" id="logPassword" placeholder="Contraseña" required>
            </div>
            
            <button type="submit" class="btn-auth">Entrar</button>
        </form>
        
        <p class="auth-footer">¿No tienes cuenta? <a href="/AccesoriosMaya/auth/registro.php">Regístrate gratis</a></p>
    </div>
</div>

<?php 
// CORRECCIÓN: Subimos un nivel para el footer
include '../estructura/footer.php'; 
?>

<script>
function ejecutarLogin() {
    const email = document.getElementById('logEmail').value.trim();
    const pass = document.getElementById('logPassword').value;
    const inputEmail = document.getElementById('logEmail');
    const inputPass = document.getElementById('logPassword');

    // Limpiar errores visuales previos
    inputEmail.classList.remove('input-error');
    inputPass.classList.remove('input-error');

    if (!email || !pass) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, ingresa tus credenciales.',
            confirmButtonColor: '#2c656d'
        });
        return;
    }

    // 1. Traer usuarios de LocalStorage
    const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];

    // 2. Buscar si el correo existe y la contraseña coincide
    const usuarioEncontrado = usuarios.find(u => u.email === email && u.password === pass);

    if (usuarioEncontrado) {
        // --- LOGIN EXITOSO ---
        localStorage.setItem('usuarioActivo', JSON.stringify(usuarioEncontrado));

        Swal.fire({
            icon: 'success',
            title: '¡Hola de nuevo!',
            text: `Bienvenido(a), ${usuarioEncontrado.nombre}`,
            confirmButtonColor: '#2c656d',
            timer: 2000,
            showConfirmButton: false
        });

        // CORRECCIÓN: Redirigir al inicio usando ruta absoluta para salir de la carpeta /auth/
        setTimeout(() => {
            window.location.href = '/AccesoriosMaya/index.php';
        }, 2000);

    } else {
        // --- ERROR DE CREDENCIALES ---
        Swal.fire({
            icon: 'error',
            title: 'Acceso Denegado',
            text: 'Correo o contraseña incorrectos.',
            confirmButtonColor: '#2c656d'
        });
        inputEmail.classList.add('input-error');
        inputPass.classList.add('input-error');
    }
}
</script>