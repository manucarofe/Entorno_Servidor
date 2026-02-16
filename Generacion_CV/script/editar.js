// Cargar datos existentes cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Cargar experiencias existentes
    if (experienciasData && experienciasData.length > 0) {
        experienciasData.forEach(function(exp) {
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
                            <input type="text" class="form-control" name="exp_empresa[]" value="${escapeHtml(exp.empresa)}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Puesto</label>
                            <input type="text" class="form-control" name="exp_puesto[]" value="${escapeHtml(exp.puesto)}" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" name="exp_fecha_inicio[]" value="${exp.fecha_inicio}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" name="exp_fecha_fin[]" value="${exp.fecha_fin || ''}">
                            <small class="text-muted">Dejar vacío si es empleo actual</small>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="exp_descripcion[]" rows="2">${escapeHtml(exp.descripcion || '')}</textarea>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });
    }
    
    // Cargar formaciones existentes
    if (formacionesData && formacionesData.length > 0) {
        formacionesData.forEach(function(form) {
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
                            <input type="text" class="form-control" name="form_institucion[]" value="${escapeHtml(form.institucion)}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control" name="form_titulo[]" value="${escapeHtml(form.titulo)}" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" name="form_fecha_inicio[]" value="${form.fecha_inicio}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" name="form_fecha_fin[]" value="${form.fecha_fin || ''}">
                            <small class="text-muted">Dejar vacío si está en curso</small>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="form_descripcion[]" rows="2">${escapeHtml(form.descripcion || '')}</textarea>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });
    }
    
    // Cargar habilidades existentes
    if (habilidadesData && habilidadesData.length > 0) {
        habilidadesData.forEach(function(hab) {
            const container = document.getElementById('habilidadesContainer');
            const div = document.createElement('div');
            div.className = 'row mb-2 dynamic-item';
            div.innerHTML = `
                <div class="col-md-7">
                    <input type="text" class="form-control" name="habilidad[]" value="${escapeHtml(hab.habilidad)}" required>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="hab_nivel[]">
                        <option value="Básico" ${hab.nivel === 'Básico' ? 'selected' : ''}>Básico</option>
                        <option value="Intermedio" ${hab.nivel === 'Intermedio' ? 'selected' : ''}>Intermedio</option>
                        <option value="Avanzado" ${hab.nivel === 'Avanzado' ? 'selected' : ''}>Avanzado</option>
                        <option value="Experto" ${hab.nivel === 'Experto' ? 'selected' : ''}>Experto</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeElement(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
        });
    }
    
    // Cargar idiomas existentes
    if (idiomasData && idiomasData.length > 0) {
        idiomasData.forEach(function(idioma) {
            const container = document.getElementById('idiomasContainer');
            const div = document.createElement('div');
            div.className = 'row mb-2 dynamic-item';
            div.innerHTML = `
                <div class="col-md-7">
                    <input type="text" class="form-control" name="idioma[]" value="${escapeHtml(idioma.idioma)}" required>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="idioma_nivel[]">
                        <option value="Básico" ${idioma.nivel === 'Básico' ? 'selected' : ''}>Básico</option>
                        <option value="Intermedio" ${idioma.nivel === 'Intermedio' ? 'selected' : ''}>Intermedio</option>
                        <option value="Avanzado" ${idioma.nivel === 'Avanzado' ? 'selected' : ''}>Avanzado</option>
                        <option value="Nativo" ${idioma.nivel === 'Nativo' ? 'selected' : ''}>Nativo</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeElement(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
        });
    }
});

// Función para escapar HTML y evitar XSS
function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
}
