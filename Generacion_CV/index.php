<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-file-earmark-person"></i> Generador de CV
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Crear CV</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar.php">Ver CVs Guardados</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-4">Crear Nuevo CV</h2>
                        
                        <form id="cvForm" action="procesar.php" method="POST" enctype="multipart/form-data">
                            <!-- Datos Personales -->
                            <div class="section-header mb-3">
                                <h5><i class="bi bi-person-circle"></i> Datos Personales</h5>
                                <hr>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellidos" class="form-label">Apellidos *</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>

                            <div class="mb-3">
                                <label for="perfil_profesional" class="form-label">Perfil Profesional</label>
                                <textarea class="form-control" id="perfil_profesional" name="perfil_profesional" rows="3" placeholder="Breve descripción sobre ti y tu trayectoria profesional"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label">Foto (opcional)</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <small class="text-muted">Formatos permitidos: JPG, PNG, GIF (máx. 2MB)</small>
                            </div>

                            <!-- Experiencia Laboral -->
                            <div class="section-header mb-3 mt-5">
                                <h5><i class="bi bi-briefcase"></i> Experiencia Laboral</h5>
                                <hr>
                            </div>

                            <div id="experienciaContainer">
                                <!-- Las experiencias se añadirán aquí dinámicamente -->
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addExperiencia">
                                <i class="bi bi-plus-circle"></i> Añadir Experiencia
                            </button>

                            <!-- Formación Académica -->
                            <div class="section-header mb-3 mt-4">
                                <h5><i class="bi bi-mortarboard"></i> Formación Académica</h5>
                                <hr>
                            </div>

                            <div id="formacionContainer">
                                <!-- Las formaciones se añadirán aquí dinámicamente -->
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addFormacion">
                                <i class="bi bi-plus-circle"></i> Añadir Formación
                            </button>

                            <!-- Habilidades -->
                            <div class="section-header mb-3 mt-4">
                                <h5><i class="bi bi-gear"></i> Habilidades</h5>
                                <hr>
                            </div>

                            <div id="habilidadesContainer">
                                <!-- Las habilidades se añadirán aquí dinámicamente -->
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addHabilidad">
                                <i class="bi bi-plus-circle"></i> Añadir Habilidad
                            </button>

                            <!-- Idiomas -->
                            <div class="section-header mb-3 mt-4">
                                <h5><i class="bi bi-translate"></i> Idiomas</h5>
                                <hr>
                            </div>

                            <div id="idiomasContainer">
                                <!-- Los idiomas se añadirán aquí dinámicamente -->
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addIdioma">
                                <i class="bi bi-plus-circle"></i> Añadir Idioma
                            </button>

                            <!-- Botones de acción -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Limpiar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Guardar y Generar CV
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script/formulario.js"></script>
</body>
</html>
