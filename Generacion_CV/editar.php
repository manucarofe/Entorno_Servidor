<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$cv_id = intval($_GET['id']);
$conn = getConnection();

// Obtener datos del CV
$stmt = $conn->prepare("SELECT * FROM cvs WHERE id = ?");
$stmt->bind_param("i", $cv_id);
$stmt->execute();
$cv = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cv) {
    header("Location: index.php");
    exit();
}

// Obtener experiencia laboral
$stmt = $conn->prepare("SELECT * FROM experiencia_laboral WHERE cv_id = ? ORDER BY orden");
$stmt->bind_param("i", $cv_id);
$stmt->execute();
$experiencias = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener formación académica
$stmt = $conn->prepare("SELECT * FROM formacion_academica WHERE cv_id = ? ORDER BY orden");
$stmt->bind_param("i", $cv_id);
$stmt->execute();
$formaciones = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener habilidades
$stmt = $conn->prepare("SELECT * FROM habilidades WHERE cv_id = ?");
$stmt->bind_param("i", $cv_id);
$stmt->execute();
$habilidades = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener idiomas
$stmt = $conn->prepare("SELECT * FROM idiomas WHERE cv_id = ?");
$stmt->bind_param("i", $cv_id);
$stmt->execute();
$idiomas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar CV - Generador de CV</title>
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
                        <a class="nav-link" href="index.php">Crear CV</a>
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
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="card-title mb-0">Editar CV</h2>
                            <span class="badge bg-info">Versión <?php echo $cv['version']; ?></span>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Al guardar se creará una nueva versión del CV (v<?php echo $cv['version'] + 1; ?>)
                        </div>
                        
                        <form id="cvForm" action="procesar.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="cv_id" value="<?php echo $cv_id; ?>">
                            
                            <!-- Datos Personales -->
                            <div class="section-header mb-3">
                                <h5><i class="bi bi-person-circle"></i> Datos Personales</h5>
                                <hr>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cv['nombre']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellidos" class="form-label">Apellidos *</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($cv['apellidos']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($cv['email']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cv['telefono']); ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($cv['direccion']); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="perfil_profesional" class="form-label">Perfil Profesional</label>
                                <textarea class="form-control" id="perfil_profesional" name="perfil_profesional" rows="3"><?php echo htmlspecialchars($cv['perfil_profesional']); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label">Foto (opcional)</label>
                                <?php if (!empty($cv['foto']) && file_exists($cv['foto'])): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo htmlspecialchars($cv['foto']); ?>" alt="Foto actual" style="max-width: 100px; height: auto;">
                                        <small class="text-muted d-block">Foto actual</small>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <small class="text-muted">Dejar vacío para mantener la foto actual</small>
                            </div>

                            <!-- Experiencia Laboral -->
                            <div class="section-header mb-3 mt-5">
                                <h5><i class="bi bi-briefcase"></i> Experiencia Laboral</h5>
                                <hr>
                            </div>

                            <div id="experienciaContainer">
                                <!-- Las experiencias existentes se cargarán aquí -->
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
                                <!-- Las formaciones existentes se cargarán aquí -->
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
                                <!-- Las habilidades existentes se cargarán aquí -->
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
                                <!-- Los idiomas existentes se cargarán aquí -->
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="addIdioma">
                                <i class="bi bi-plus-circle"></i> Añadir Idioma
                            </button>

                            <!-- Botones de acción -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                <a href="ver_cv.php?id=<?php echo $cv_id; ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Guardar Nueva Versión
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pasar datos PHP a JavaScript
        const experienciasData = <?php echo json_encode($experiencias); ?>;
        const formacionesData = <?php echo json_encode($formaciones); ?>;
        const habilidadesData = <?php echo json_encode($habilidades); ?>;
        const idiomasData = <?php echo json_encode($idiomas); ?>;
    </script>
    <script src="script/formulario.js"></script>
    <script src="script/editar.js"></script>
</body>
</html>
