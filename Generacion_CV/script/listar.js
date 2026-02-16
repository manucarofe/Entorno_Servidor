function confirmarEliminar(cvId) {
    if (confirm('¿Estás seguro de que deseas eliminar este CV? Esta acción no se puede deshacer.')) {
        // Redirigir al script de eliminación
        window.location.href = 'eliminar.php?id=' + cvId;
    }
}
