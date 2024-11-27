<?php
include 'db.php';

// Verificar si se ha pasado el ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar la solicitud
    $sql = "DELETE FROM permisos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Solicitud eliminada con éxito.";
    } else {
        echo "Error al eliminar la solicitud: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID no proporcionado.";
}

$conn->close();
?>
