<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$cv_id = intval($_GET['id']);
$conn = getConnection();

// Obtener la foto antes de eliminar para borrarla del servidor
$stmt = $conn->prepare("SELECT foto FROM cvs WHERE id = ?");
$stmt->bind_param("i", $cv_id);
$stmt->execute();
$result = $stmt->get_result();
$cv = $result->fetch_assoc();
$stmt->close();

if ($cv && !empty($cv['foto']) && file_exists($cv['foto'])) {
    unlink($cv['foto']);
}

// Eliminar el CV (eliminación en cascada)
$stmt = $conn->prepare("DELETE FROM cvs WHERE id = ?");
$stmt->bind_param("i", $cv_id);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: listar.php?mensaje=eliminado");
exit();
?>
