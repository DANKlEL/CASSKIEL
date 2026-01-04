<?php include 'estructura/head.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include 'estructura/header.php'; ?>

<div class="container" style="padding: 50px; font-family: 'Poppins', sans-serif;">
    <h2 style="color: #2c656d; text-align: center; font-family: 'Fredoka One';">Gestión de Usuarios Locales</h2>
    <p style="text-align: center;">Datos almacenados en el LocalStorage de este navegador</p>

    <div style="overflow-x: auto; margin-top: 30px;">
        <table id="tablaUsuarios" style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background-color: #2c656d; color: white; text-align: left;">
                    <th style="padding: 15px;">Nombre</th>
                    <th style="padding: 15px;">Correo</th>
                    <th style="padding: 15px;">Contraseña</th>
                    <th style="padding: 15px;">Acciones</th>
                </tr>
            </thead>
            <tbody id="listaUsuarios">
                </tbody>
        </table>
    </div>
    
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="borrarTodo()" style="background: #d9534f; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Borrar Toda la Base de Datos</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', cargarUsuarios);

function cargarUsuarios() {
    const tabla = document.getElementById('listaUsuarios');
    const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
    
    tabla.innerHTML = ""; // Limpiar tabla

    if (usuarios.length === 0) {
        tabla.innerHTML = "<tr><td colspan='4' style='text-align:center; padding: 20px;'>No hay usuarios registrados.</td></tr>";
        return;
    }

    usuarios.forEach((user, index) => {
        tabla.innerHTML += `
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 15px;">${user.nombre}</td>
                <td style="padding: 15px;">${user.email}</td>
                <td style="padding: 15px;"><code>${user.password}</code></td>
                <td style="padding: 15px;">
                    <button onclick="eliminarUsuario(${index})" style="background: #f0ad4e; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Eliminar</button>
                </td>
            </tr>
        `;
    });
}

function eliminarUsuario(index) {
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2c656d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            let usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
            usuarios.splice(index, 1); // Borra el elemento en esa posición
            localStorage.setItem('usuarios', JSON.stringify(usuarios));
            cargarUsuarios(); // Recarga la tabla
            Swal.fire('Eliminado', 'El usuario ha sido borrado.', 'success');
        }
    });
}

function borrarTodo() {
    Swal.fire({
        title: '¿BORRAR TODO?',
        text: "Se eliminarán todos los registros de la base de datos local",
        icon: 'danger',
        showCancelButton: true,
        confirmButtonText: 'BORRAR TODO'
    }).then((result) => {
        if (result.isConfirmed) {
            localStorage.removeItem('usuarios');
            cargarUsuarios();
        }
    });
}
</script>

