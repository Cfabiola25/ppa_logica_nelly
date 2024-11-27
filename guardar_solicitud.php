<?php
include 'db.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Caso 1: Solicitud desde imprimir.html
    if (isset($_POST['desde_imprimir']) && $_POST['desde_imprimir'] == 'true') {
        // Mostrar los datos recibidos por AJAX para depuración
        echo "Datos recibidos: ";
        print_r($_POST);

        // Variables del formulario
        $nombre = $_POST['nombre'];
        $documento = $_POST['documento'];
        $tipo_permiso = $_POST['tipo_permiso'];
        $descripcion = $_POST['descripcion'];
        $fecha_solicitud = $_POST['fecha_solicitud'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $duracion = $_POST['duracion'];
        $unidad_duracion = $_POST['unidad_duracion'];
        $estado = 'Aprobado'; // Estado por defecto para solicitudes desde imprimir.html

        // Inserción de datos en la base de datos
        $sql = "INSERT INTO solicitudes (nombre, documento, tipo_permiso, descripcion, fecha_solicitud, fecha_inicio, fecha_fin, duracion, unidad_duracion, estado) 
                VALUES ('$nombre', '$documento', '$tipo_permiso', '$descripcion', '$fecha_solicitud', '$fecha_inicio', '$fecha_fin', $duracion, '$unidad_duracion', '$estado')";

        if (mysqli_query($conn, $sql)) {
            echo "Solicitud guardada exitosamente.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        exit; // Detener el script para evitar más ejecución
    }

    // Caso 2: Actualización del estado de una solicitud por parte del administrador
    if (isset($_POST['id_permiso']) && isset($_POST['accion'])) {
        $id_permiso = intval($_POST['id_permiso']);
        $accion = $_POST['accion'];
        $comentario_admin = isset($_POST['comentario_admin']) ? trim($_POST['comentario_admin']) : null;

        // Validar la acción
        if ($accion !== 'aprobar' && $accion !== 'rechazar') {
            echo "Acción inválida.";
            exit;
        }

        // Determinar el estado según la acción
        $estado = ($accion === 'aprobar') ? 'Aprobado' : 'Rechazado';

        // Actualizar la solicitud en la base de datos
        $sql = "UPDATE permisos SET estado = ?, comentario_admin = ?, fecha_respuesta = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $estado, $comentario_admin, $id_permiso);

        if ($stmt->execute()) {
            echo "<p>La solicitud ha sido " . htmlspecialchars($estado) . " correctamente.</p>";
            echo "<a href='solicitudes_pendientes.php'>Volver a Solicitudes Pendientes</a>";
        } else {
            echo "Error al actualizar la solicitud: " . $stmt->error;
        }
        exit; // Detener el script
    }

    // Caso 3: Actualización del estado con validación de acción
    if (isset($_POST['id_permiso']) && isset($_POST['estado']) && isset($_POST['comentario_admin'])) {
        $id_permiso = $_POST['id_permiso']; // ID de la solicitud
        $estado = $_POST['estado']; // Estado: aceptado o rechazado
        $comentario_admin = $_POST['comentario_admin']; // Comentario opcional del admin

        // Verificar que el estado sea válido
        if ($estado !== "aceptado" && $estado !== "rechazado") {
            die("Estado inválido. Solo se permiten los valores 'aceptado' o 'rechazado'.");
        }

        // Actualizar la solicitud en la base de datos
        $sql = "UPDATE permisos 
                SET estado = ?, comentario_admin = ?, fecha_respuesta = NOW() 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $estado, $comentario_admin, $id_permiso);

        if ($stmt->execute()) {
            echo "La solicitud ha sido actualizada correctamente.";
        } else {
            echo "Error al actualizar la solicitud: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>
