<?php
require_once 'config.php';

$conn = getConnection();

// Obtener todos los CVs ordenados por fecha
$query = "SELECT * FROM cvs ORDER BY fecha_creacion DESC";
$result = $conn->query($query);
$cvs = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CVs Guardados - Generador de CV</title>
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
                        <a class="nav-link active" href="listar.php">Ver CVs Guardados</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="bi bi-folder2-open"></i> CVs Guardados</h2>
                    <a href="index.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Crear Nuevo CV
                    </a>
                </div>

                <?php if (empty($cvs)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay CVs guardados todavía. 
                        <a href="index.php" class="alert-link">Crear tu primer CV</a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($cvs as $cv): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card cv-card shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="card-title mb-0">
                                                <?php echo htmlspecialchars($cv['nombre'] . ' ' . $cv['apellidos']); ?>
                                            </h5>
                                            <span class="badge bg-secondary version-badge">
                                                v<?php echo $cv['version']; ?>
                                            </span>
                                        </div>
                                        
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-envelope"></i> <?php echo htmlspecialchars($cv['email']); ?>
                                        </p>
                                        
                                        <?php if (!empty($cv['telefono'])): ?>
                                            <p class="card-text text-muted small">
                                                <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($cv['telefono']); ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i> 
                                                <?php echo date('d/m/Y H:i', strtotime($cv['fecha_creacion'])); ?>
                                            </small>
                                        </p>
                                    </div>
                                    
                                    <div class="card-footer bg-white border-top-0">
                                        <div class="d-flex justify-content-between btn-group-actions">
                                            <a href="ver_cv.php?id=<?php echo $cv['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Ver
                                            </a>
                                            <a href="editar.php?id=<?php echo $cv['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                            <button onclick="confirmarEliminar(<?php echo $cv['id']; ?>)" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script/listar.js"></script>
</body>
</html>
