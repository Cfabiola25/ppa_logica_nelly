<?php
session_start();
include 'db.php'; // Asegúrate de tener conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_solicitud = $_POST['id_solicitud']; // ID de la solicitud
    $accion = $_POST['accion']; // "aceptar" o "rechazar"
    $comentario_admin = $_POST['comentario_admin']; // Comentario del admin (puede estar vacío)

    // Verifica que la solicitud existe
    $query = "SELECT * FROM solicitudes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_solicitud);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Actualiza el estado de la solicitud y guarda el comentario
        $nuevo_estado = ($accion === 'aceptar') ? 'Aceptado' : 'Rechazado';

        $update = "UPDATE solicitudes 
                   SET estado = ?, comentario_admin = ?
                   WHERE id = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param('ssi', $nuevo_estado, $comentario_admin, $id_solicitud);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "La solicitud ha sido $nuevo_estado exitosamente.";
        } else {
            $_SESSION['error'] = "Hubo un error al procesar la solicitud.";
        }
    } else {
        $_SESSION['error'] = "Solicitud no encontrada.";
    }

    $stmt->close();
    $conn->close();

    // Redirige al dashboard del administrador
    header('Location: gestion.php');
    exit;
}
?>
