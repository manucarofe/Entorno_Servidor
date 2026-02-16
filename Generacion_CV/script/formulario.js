// Contadores para los campos dinámicos
let experienciaCount = 0;
let formacionCount = 0;
let habilidadCount = 0;
let idiomaCount = 0;

// Función para añadir experiencia laboral
function addExperiencia() {
    const container = document.getElementById('experienciaContainer');
    const div = document.createElement('div');
    div.className = 'card mb-3 dynamic-item';
    div.innerHTML = `
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-outline-danger float-end remove-btn" onclick="removeElement(this)">
                <i class="bi bi-trash"></i>
            </button>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label">Empresa</label>
                    <input type="text" class="form-control" name="exp_empresa[]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Puesto</label>
                    <input type="text" class="form-control" name="exp_puesto[]" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" name="exp_fecha_inicio[]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" name="exp_fecha_fin[]">
                    <small class="text-muted">Dejar vacío si es empleo actual</small>
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="exp_descripcion[]" rows="2"></textarea>
            </div>
        </div>
    `;
    container.appendChild(div);
    experienciaCount++;
}

// Función para añadir formación académica
function addFormacion() {
    const container = document.getElementById('formacionContainer');
    const div = document.createElement('div');
    div.className = 'card mb-3 dynamic-item';
    div.innerHTML = `
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-outline-danger float-end remove-btn" onclick="removeElement(this)">
                <i class="bi bi-trash"></i>
            </button>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label">Institución</label>
                    <input type="text" class="form-control" name="form_institucion[]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Título</label>
                    <input type="text" class="form-control" name="form_titulo[]" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" name="form_fecha_inicio[]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" name="form_fecha_fin[]">
                    <small class="text-muted">Dejar vacío si está en curso</small>
                </div>
            </div>
            <div class="mb-2">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="form_descripcion[]" rows="2"></textarea>
            </div>
        </div>
    `;
    container.appendChild(div);
    formacionCount++;
}

// Función para añadir habilidad
function addHabilidad() {
    const container = document.getElementById('habilidadesContainer');
    const div = document.createElement('div');
    div.className = 'row mb-2 dynamic-item';
    div.innerHTML = `
        <div class="col-md-7">
            <input type="text" class="form-control" name="habilidad[]" placeholder="Nombre de la habilidad" required>
        </div>
        <div class="col-md-4">
            <select class="form-select" name="hab_nivel[]">
                <option value="Básico">Básico</option>
                <option value="Intermedio" selected>Intermedio</option>
                <option value="Avanzado">Avanzado</option>
                <option value="Experto">Experto</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeElement(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    habilidadCount++;
}

// Función para añadir idioma
function addIdioma() {
    const container = document.getElementById('idiomasContainer');
    const div = document.createElement('div');
    div.className = 'row mb-2 dynamic-item';
    div.innerHTML = `
        <div class="col-md-7">
            <input type="text" class="form-control" name="idioma[]" placeholder="Nombre del idioma" required>
        </div>
        <div class="col-md-4">
            <select class="form-select" name="idioma_nivel[]">
                <option value="Básico">Básico</option>
                <option value="Intermedio" selected>Intermedio</option>
                <option value="Avanzado">Avanzado</option>
                <option value="Nativo">Nativo</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeElement(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
    idiomaCount++;
}

// Función para eliminar elementos
function removeElement(button) {
    const item = button.closest('.dynamic-item');
    item.remove();
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Botón añadir experiencia
    document.getElementById('addExperiencia').addEventListener('click', addExperiencia);
    
    // Botón añadir formación
    document.getElementById('addFormacion').addEventListener('click', addFormacion);
    
    // Botón añadir habilidad
    document.getElementById('addHabilidad').addEventListener('click', addHabilidad);
    
    // Botón añadir idioma
    document.getElementById('addIdioma').addEventListener('click', addIdioma);
    
    // Añadir al menos un campo de cada uno al inicio
    addExperiencia();
    addFormacion();
    addHabilidad();
    addIdioma();
});
