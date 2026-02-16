<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getConnection();
    
    // Iniciar transacción
    $conn->begin_transaction();
    
    try {
        // Procesar foto si se subió
        $foto_path = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['foto']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed) && $_FILES['foto']['size'] <= 2097152) { // 2MB
                $new_filename = uniqid() . '.' . $ext;
                $upload_dir = 'uploads/';
                
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_dir . $new_filename)) {
                    $foto_path = $upload_dir . $new_filename;
                }
            }
        }
        
        // Determinar si es una edición (nueva versión)
        $cv_original_id = isset($_POST['cv_id']) ? intval($_POST['cv_id']) : null;
        $version = 1;
        
        if ($cv_original_id) {
            // Obtener la última versión
            $stmt = $conn->prepare("SELECT MAX(version) as max_version FROM cvs WHERE cv_original_id = ? OR id = ?");
            $stmt->bind_param("ii", $cv_original_id, $cv_original_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $version = $row['max_version'] + 1;
            $stmt->close();
        }
        
        // Insertar datos personales
        $stmt = $conn->prepare("INSERT INTO cvs (nombre, apellidos, email, telefono, direccion, perfil_profesional, foto, version, cv_original_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssssssiii",
            $_POST['nombre'],
            $_POST['apellidos'],
            $_POST['email'],
            $_POST['telefono'],
            $_POST['direccion'],
            $_POST['perfil_profesional'],
            $foto_path,
            $version,
            $cv_original_id
        );
        $stmt->execute();
        $cv_id = $conn->insert_id;
        $stmt->close();
        
        // Insertar experiencia laboral
        if (isset($_POST['exp_empresa']) && is_array($_POST['exp_empresa'])) {
            $stmt = $conn->prepare("INSERT INTO experiencia_laboral (cv_id, empresa, puesto, fecha_inicio, fecha_fin, descripcion, orden) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            for ($i = 0; $i < count($_POST['exp_empresa']); $i++) {
                if (!empty($_POST['exp_empresa'][$i])) {
                    $fecha_fin = !empty($_POST['exp_fecha_fin'][$i]) ? $_POST['exp_fecha_fin'][$i] : null;
                    $stmt->bind_param(
                        "isssssi",
                        $cv_id,
                        $_POST['exp_empresa'][$i],
                        $_POST['exp_puesto'][$i],
                        $_POST['exp_fecha_inicio'][$i],
                        $fecha_fin,
                        $_POST['exp_descripcion'][$i],
                        $i
                    );
                    $stmt->execute();
                }
            }
            $stmt->close();
        }
        
        // Insertar formación académica
        if (isset($_POST['form_institucion']) && is_array($_POST['form_institucion'])) {
            $stmt = $conn->prepare("INSERT INTO formacion_academica (cv_id, institucion, titulo, fecha_inicio, fecha_fin, descripcion, orden) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            for ($i = 0; $i < count($_POST['form_institucion']); $i++) {
                if (!empty($_POST['form_institucion'][$i])) {
                    $fecha_fin = !empty($_POST['form_fecha_fin'][$i]) ? $_POST['form_fecha_fin'][$i] : null;
                    $stmt->bind_param(
                        "isssssi",
                        $cv_id,
                        $_POST['form_institucion'][$i],
                        $_POST['form_titulo'][$i],
                        $_POST['form_fecha_inicio'][$i],
                        $fecha_fin,
                        $_POST['form_descripcion'][$i],
                        $i
                    );
                    $stmt->execute();
                }
            }
            $stmt->close();
        }
        
        // Insertar habilidades
        if (isset($_POST['habilidad']) && is_array($_POST['habilidad'])) {
            $stmt = $conn->prepare("INSERT INTO habilidades (cv_id, habilidad, nivel) VALUES (?, ?, ?)");
            
            for ($i = 0; $i < count($_POST['habilidad']); $i++) {
                if (!empty($_POST['habilidad'][$i])) {
                    $stmt->bind_param(
                        "iss",
                        $cv_id,
                        $_POST['habilidad'][$i],
                        $_POST['hab_nivel'][$i]
                    );
                    $stmt->execute();
                }
            }
            $stmt->close();
        }
        
        // Insertar idiomas
        if (isset($_POST['idioma']) && is_array($_POST['idioma'])) {
            $stmt = $conn->prepare("INSERT INTO idiomas (cv_id, idioma, nivel) VALUES (?, ?, ?)");
            
            for ($i = 0; $i < count($_POST['idioma']); $i++) {
                if (!empty($_POST['idioma'][$i])) {
                    $stmt->bind_param(
                        "iss",
                        $cv_id,
                        $_POST['idioma'][$i],
                        $_POST['idioma_nivel'][$i]
                    );
                    $stmt->execute();
                }
            }
            $stmt->close();
        }
        
        // Confirmar transacción
        $conn->commit();
        
        // Redirigir a la visualización del CV
        header("Location: ver_cv.php?id=" . $cv_id);
        exit();
        
    } catch (Exception $e) {
        $conn->rollback();
        die("Error al guardar el CV: " . $e->getMessage());
    }
    
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>
