<?php 
// CORRECCIÓN: Salimos de la carpeta 'auth' para encontrar 'estructura'
include '../estructura/head.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="/AccesoriosMaya/css/login/login.css">

<?php 
// CORRECCIÓN: Salimos de la carpeta 'auth' para el header
include '../estructura/header.php'; 
?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Crear Cuenta</h2>
        <p>Únete a Accesorios Maya</p>
        
        <form id="registroForm" onsubmit="event.preventDefault(); ejecutarRegistro();">
            <div class="input-group">
                <input type="text" id="regNombre" placeholder="Nombre completo" required>
            </div>

            <div class="input-group">
                <input type="email" id="regEmail" placeholder="Correo electrónico" required>
            </div>
            
            <div class="input-group">
                <input type="password" id="regPassword" placeholder="Contraseña" required>
            </div>

            <div class="input-group">
                <input type="password" id="regConfirmPassword" placeholder="Confirmar contraseña" required>
            </div>
            
            <button type="submit" class="btn-auth">Registrarse</button>
        </form>
        
        <p class="auth-footer">¿Ya tienes cuenta? <a href="/AccesoriosMaya/auth/login.php">Inicia sesión</a></p>
    </div>
</div>

<?php 
// CORRECCIÓN: Salimos de la carpeta 'auth' para el footer
include '../estructura/footer.php'; 
?>

<script>
function ejecutarRegistro() {
    const nombre = document.getElementById('regNombre').value.trim();
    const email = document.getElementById('regEmail').value.trim();
    const pass = document.getElementById('regPassword').value;
    const confirmPass = document.getElementById('regConfirmPassword').value;

    if (!nombre || !email || !pass || !confirmPass) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, llena todos los datos.',
            confirmButtonColor: '#2c656d'
        });
        return;
    }

    if (pass !== confirmPass) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden.',
            confirmButtonColor: '#2c656d'
        });
        return;
    }

    // 1. Obtener lista de usuarios actual
    let usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];

    // 2. Verificar si el correo ya está registrado
    if (usuarios.find(u => u.email === email)) {
        Swal.fire({
            icon: 'error',
            title: 'Correo duplicado',
            text: 'Este correo ya está registrado.',
            confirmButtonColor: '#2c656d'
        });
        return;
    }

    // 3. Guardar el nuevo usuario (con estructura para direcciones y pagos)
    const nuevoUsuario = {
        id: Date.now(),
        nombre: nombre,
        email: email,
        password: pass,
        direcciones: [],
        pagos: {}
    };

    usuarios.push(nuevoUsuario);
    localStorage.setItem('usuarios', JSON.stringify(usuarios));

    Swal.fire({
        icon: 'success',
        title: '¡Registro exitoso!',
        text: 'Ahora puedes iniciar sesión.',
        confirmButtonColor: '#2c656d',
        timer: 2000,
        showConfirmButton: false
    });

    // CORRECCIÓN: Redirigir al login usando ruta absoluta
    setTimeout(() => {
        window.location.href = '/AccesoriosMaya/auth/login.php';
    }, 2000);
}
</script>