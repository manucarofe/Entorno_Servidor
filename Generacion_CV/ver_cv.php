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

function formatearFecha($fecha) {
    if (empty($fecha)) return 'Actualidad';
    $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    $partes = explode('-', $fecha);
    return $meses[(int)$partes[1] - 1] . ' ' . $partes[0];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - <?php echo htmlspecialchars($cv['nombre'] . ' ' . $cv['apellidos']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Barra de navegación (no se imprime) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom no-print">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-file-earmark-person"></i> Generador de CV
            </a>
            <div class="ms-auto">
                <a href="listar.php" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="bi bi-list"></i> Ver Todos
                </a>
                <a href="editar.php?id=<?php echo $cv_id; ?>" class="btn btn-outline-primary btn-sm me-2">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="bi bi-printer"></i> Imprimir/PDF
                </button>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="cv-container">
            <!-- Cabecera del CV -->
            <div class="cv-header">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <h1 class="cv-name"><?php echo htmlspecialchars($cv['nombre'] . ' ' . $cv['apellidos']); ?></h1>
                        <div class="cv-contact">
                            <?php if (!empty($cv['email'])): ?>
                                <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($cv['email']); ?>
                            <?php endif; ?>
                            <?php if (!empty($cv['telefono'])): ?>
                                <span class="ms-3"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($cv['telefono']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($cv['direccion'])): ?>
                                <span class="ms-3"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($cv['direccion']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($cv['foto']) && file_exists($cv['foto'])): ?>
                        <div class="col-md-3 text-end">
                            <img src="<?php echo htmlspecialchars($cv['foto']); ?>" alt="Foto" class="cv-photo">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Perfil Profesional -->
            <?php if (!empty($cv['perfil_profesional'])): ?>
                <div class="cv-section">
                    <h2 class="cv-section-title">Perfil Profesional</h2>
                    <p class="cv-item-description"><?php echo nl2br(htmlspecialchars($cv['perfil_profesional'])); ?></p>
                </div>
            <?php endif; ?>

            <!-- Experiencia Laboral -->
            <?php if (!empty($experiencias)): ?>
                <div class="cv-section">
                    <h2 class="cv-section-title">Experiencia Laboral</h2>
                    <?php foreach ($experiencias as $exp): ?>
                        <div class="cv-item">
                            <div class="cv-item-title"><?php echo htmlspecialchars($exp['puesto']); ?></div>
                            <div class="cv-item-subtitle"><?php echo htmlspecialchars($exp['empresa']); ?></div>
                            <div class="cv-item-date">
                                <?php echo formatearFecha($exp['fecha_inicio']); ?> - <?php echo formatearFecha($exp['fecha_fin']); ?>
                            </div>
                            <?php if (!empty($exp['descripcion'])): ?>
                                <div class="cv-item-description"><?php echo nl2br(htmlspecialchars($exp['descripcion'])); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Formación Académica -->
            <?php if (!empty($formaciones)): ?>
                <div class="cv-section">
                    <h2 class="cv-section-title">Formación Académica</h2>
                    <?php foreach ($formaciones as $form): ?>
                        <div class="cv-item">
                            <div class="cv-item-title"><?php echo htmlspecialchars($form['titulo']); ?></div>
                            <div class="cv-item-subtitle"><?php echo htmlspecialchars($form['institucion']); ?></div>
                            <div class="cv-item-date">
                                <?php echo formatearFecha($form['fecha_inicio']); ?> - <?php echo formatearFecha($form['fecha_fin']); ?>
                            </div>
                            <?php if (!empty($form['descripcion'])): ?>
                                <div class="cv-item-description"><?php echo nl2br(htmlspecialchars($form['descripcion'])); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Habilidades -->
            <?php if (!empty($habilidades)): ?>
                <div class="cv-section">
                    <h2 class="cv-section-title">Habilidades</h2>
                    <div>
                        <?php foreach ($habilidades as $hab): ?>
                            <span class="skill-item">
                                <?php echo htmlspecialchars($hab['habilidad']); ?>
                                <span class="skill-level">(<?php echo htmlspecialchars($hab['nivel']); ?>)</span>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Idiomas -->
            <?php if (!empty($idiomas)): ?>
                <div class="cv-section">
                    <h2 class="cv-section-title">Idiomas</h2>
                    <div>
                        <?php foreach ($idiomas as $idioma): ?>
                            <span class="language-item">
                                <?php echo htmlspecialchars($idioma['idioma']); ?>
                                <span class="language-level">(<?php echo htmlspecialchars($idioma['nivel']); ?>)</span>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="text-muted text-center mt-5 small no-print">
                <p>Versión <?php echo $cv['version']; ?> - Creado el <?php echo date('d/m/Y H:i', strtotime($cv['fecha_creacion'])); ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
