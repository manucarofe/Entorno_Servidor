<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('root', 'root');
define('Contraseña_BD', '');
define('CV', 'generador_cv');

// Crear conexión
function getConnection() {
    $conn = new mysqli(DB_HOST, root, Contraseña_BD, CV);
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}
?>
