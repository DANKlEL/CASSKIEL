<?php include 'estructura/head.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="css/registro/registro.css">
<?php include 'estructura/header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Crear Cuenta</h2>
        <p>Únete a la familia de Accesorios Maya</p>
        
        <form id="formRegistro" onsubmit="event.preventDefault(); return false;">
            <div class="input-group">
                <input type="text" id="regNombre" placeholder="Nombre completo" required>
            </div>
            
            <div class="input-group">
                <input type="email" id="regEmail" placeholder="Correo electrónico (ejemplo@mail.com)" required>
            </div>
            
            <div class="input-group">
                <input type="password" id="regPassword" placeholder="Contraseña" required>
            </div>
            
            <div class="input-group">
                <input type="password" id="regPasswordConfirm" placeholder="Confirmar contraseña" required>
            </div>
            
            <button type="button" id="btnRegistrar" class="btn-auth">Registrarse</button>
        </form>
        
        <p class="auth-footer">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</div>

<?php include 'estructura/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const boton = document.getElementById('btnRegistrar');
    
    boton.onclick = function() {
        // 1. Captura de elementos
        const inputNombre = document.getElementById('regNombre');
        const inputEmail = document.getElementById('regEmail');
        const inputPass = document.getElementById('regPassword');
        const inputPassConfirm = document.getElementById('regPasswordConfirm');

        // 2. Valores limpios
        const nombre = inputNombre.value.trim();
        const email = inputEmail.value.trim();
        const pass = inputPass.value;
        const passConfirm = inputPassConfirm.value;

        // 3. Reset de estilos de error (clase de tu CSS)
        inputNombre.classList.remove('input-error');
        inputEmail.classList.remove('input-error');
        inputPass.classList.remove('input-error');
        inputPassConfirm.classList.remove('input-error');

        // --- VALIDACIÓN DE CAMPOS VACÍOS ---
        if (!nombre || !email || !pass || !passConfirm) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, llena todos los espacios obligatorios.',
                confirmButtonColor: '#2c656d'
            });
            return;
        }

        // --- VALIDACIÓN DE FORMATO DE EMAIL (@ Y DOMINIO) ---
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Correo inválido',
                text: 'Ingresa un correo electrónico real (ejemplo@dominio.com).',
                confirmButtonColor: '#2c656d'
            });
            inputEmail.classList.add('input-error');
            return;
        }

        // --- VALIDACIÓN DE COINCIDENCIA DE CONTRASEÑAS ---
        if (pass !== passConfirm) {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Las contraseñas no coinciden. Por favor verifica.',
                confirmButtonColor: '#2c656d'
            });
            inputPassConfirm.classList.add('input-error');
            return;
        }

        // --- VALIDACIÓN DE USUARIO EXISTENTE Y GUARDADO ---
        try {
            const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
            
            if (usuarios.some(u => u.email === email)) {
                Swal.fire({
                    icon: 'info',
                    title: 'Usuario registrado',
                    text: 'Este correo electrónico ya tiene una cuenta con nosotros.',
                    confirmButtonColor: '#2c656d'
                });
                return;
            }

            // Guardamos el objeto
            usuarios.push({ 
                nombre: nombre, 
                email: email, 
                password: pass 
            });
            
            localStorage.setItem('usuarios', JSON.stringify(usuarios));

            // ÉXITO FINAL
            Swal.fire({
                icon: 'success',
                title: '¡Bienvenido!',
                text: 'Tu cuenta en Accesorios Maya ha sido creada.',
                confirmButtonColor: '#2c656d'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                }
            });

        } catch (e) {
            console.error("Error al acceder a LocalStorage", e);
        }
    };
});
</script>