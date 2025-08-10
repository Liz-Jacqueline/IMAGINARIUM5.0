// Generar campos dinámicos para Estudiantes
document.getElementById('totalEstudiantes').addEventListener('input', function () {
    const total = parseInt(this.value);
    const contenedor = document.getElementById('contenedorNombresEstudiantes');
    contenedor.innerHTML = ''; // Limpiar contenido anterior

    if (!isNaN(total) && total > 0) {
        for (let i = 1; i <= total; i++) {
            const div = document.createElement('div');
            div.className = 'form-floating mb-2';
            div.innerHTML = `
                <input type="text" name="nombre_estudiante_${i}" class="form-control" id="nombreEstudiante${i}" placeholder="Nombre del estudiante ${i}" required>
                <label for="nombreEstudiante${i}">Nombre del estudiante ${i}</label>
            `;
            contenedor.appendChild(div);
        }
    }
});

// Generar campos dinámicos para Profesores
document.getElementById('totalProfesores').addEventListener('input', function () {
    const total = parseInt(this.value);
    const contenedor = document.getElementById('contenedorNombresProfesores');
    contenedor.innerHTML = ''; // Limpiar campos anteriores

    if (!isNaN(total) && total > 0) {
        for (let i = 1; i <= total; i++) {
            const div = document.createElement('div');
            div.className = 'form-floating mb-2';
            div.innerHTML = `
                <input type="text" name="nombre_profesor_${i}" class="form-control" id="nombreProfesor${i}" placeholder="Nombre del profesor ${i}" required>
                <label for="nombreProfesor${i}">Nombre del profesor ${i}</label>
            `;
            contenedor.appendChild(div);
        }
    }
});

// Generar campos dinámicos para Asignaturas
document.getElementById('totalAsignaturas').addEventListener('input', function () {
    const total = parseInt(this.value);
    const contenedor = document.getElementById('contenedorAsignaturasPE');
    contenedor.innerHTML = ''; // Limpiar campos anteriores

    if (!isNaN(total) && total > 0) {
        for (let i = 1; i <= total; i++) {
            const div = document.createElement('div');
            div.className = 'form-floating mb-2';
            div.innerHTML = `
                <input type="text" name="asignatura_pe_${i}" class="form-control" id="asignaturaPE${i}" placeholder="Asignatura ${i}" required>
                <label for="asignaturaPE${i}">Asignatura ${i}</label>
            `;
            contenedor.appendChild(div);
        }
    }
});

// Mostrar mensajes de alerta según parámetros en la URL
window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const status = params.get('status');
    const id = params.get('id');
    const msg = params.get('msg');

    const alertContainer = document.getElementById('alert-message');

    if (status === 'success') {
        alertContainer.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ Proyecto registrado exitosamente. ID generado: <strong>${id}. ANOTA O GUARDA TU ID, YA QUE SE TE PEDIRA PARA INGRESAR A LA SALA</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
    } else if (status === 'error') {
        alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ❌ Error al registrar: <strong>${decodeURIComponent(msg)}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
    }
});