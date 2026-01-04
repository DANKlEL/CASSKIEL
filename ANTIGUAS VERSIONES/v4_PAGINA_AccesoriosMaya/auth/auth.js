function ejecutarRegistro() {
    // 1. Capturar los valores manualmente
    const nombre = document.getElementById('regNombre').value;
    const email = document.getElementById('regEmail').value;
    const pass = document.getElementById('regPassword').value;
    const passConfirm = document.getElementById('regPasswordConfirm').value;

    // 2. Validar que los campos no estén vacíos (HTML5 ya no lo hace automático con type="button")
    if (!nombre || !email || !pass || !passConfirm) {
        Swal.fire({
            title: 'Campos vacíos',
            text: 'Por favor, rellena todos los campos.',
            icon: 'warning',
            confirmButtonColor: '#2c656d'
        });
        return;
    }

    // 3. Validación de contraseñas (Lo que buscabas)
    if (pass !== passConfirm) {
        Swal.fire({
            title: '¡Error!',
            text: 'Las contraseñas no coinciden. Por favor, verifica.',
            icon: 'error',
            confirmButtonColor: '#2c656d',
            confirmButtonText: 'Corregir'
        });
        
        // Marcamos en rojo el campo de confirmación (usando tu CSS)
        document.getElementById('regPasswordConfirm').classList.add('input-error');
        return; // Aquí se detiene todo, no hay refresh.
    }

    // 4. Lógica de guardado en LocalStorage
    const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];

    // Verificar si el correo ya existe
    const existe = usuarios.some(user => user.email === email);
    if (existe) {
        Swal.fire({
            title: 'Correo ocupado',
            text: 'Este correo ya está registrado.',
            icon: 'info',
            confirmButtonColor: '#2c656d'
        });
        return;
    }

    // 5. Guardar y finalizar
    usuarios.push({
        nombre: nombre,
        email: email,
        password: pass
    });

    localStorage.setItem('usuarios', JSON.stringify(usuarios));

    Swal.fire({
        title: '¡Éxito!',
        text: 'Tu cuenta ha sido creada.',
        icon: 'success',
        confirmButtonColor: '#2c656d'
    }).then(() => {
        window.location.href = 'login.php';
    });
}