<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/* @var mysqli $conn */
include 'db.php';

// Verificar si se ha enviado el formulario
if (isset($_POST['enviar'])) {

    // Obtener datos del formulario
    $documento_identidad = $_POST['documento_identidad'];
    $tipo_permiso = $_POST['tipo_permiso'];
    $fecha_permiso = date("Y-m-d"); // Fecha actual como ejemplo
    $estado = "pendiente"; // Estado inicial de la solicitud
    $nombre = $_POST['nombre'];
    $celular = $_POST['celular'];
    $riesgo = $_POST['riesgo'];
    $fecha_solicitud = $_POST['fecha_solicitud'];
    $duracion = $_POST['duracion'];
    $unidad_duracion = $_POST['unidad_duracion'];
    $email = $_POST['email'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $motivo = $_POST['motivo'];
    $comentario_admin = null; // Inicialmente vacío
    $usuario_id = null; // No especificado en el formulario
    $otro_motivo = $_POST['descripcion'] ?? null; // En caso de que no exista

    // Subir archivo (si existe)
    $documento = null;
    if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Crear directorio si no existe
        }
        $documento = $uploadDir . basename($_FILES['documento']['name']);
        if (!move_uploaded_file($_FILES['documento']['tmp_name'], $documento)) {
            $documento = null; // Si falla la subida
        }
    }

    // Consulta preparada
    $sql = "INSERT INTO permisos 
        (documento_identidad, tipo_permiso, fecha_permiso, estado, nombre, celular, riesgo, documento, fecha_solicitud, duracion, unidad_duracion, email, fecha_inicio, fecha_fin, usuario_id, Motivo, comentario_admin, otro_motivo, motivo_otro) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // Si falla la preparación de la consulta, mostramos el error
        echo "<script>alert('Error en la preparación de la consulta: " . $conn->error . "');</script>";
        exit;
    }

    // Asignar los parámetros
    $stmt->bind_param(
        "ssssssssissssssssss",
        $documento_identidad,
        $tipo_permiso,
        $fecha_permiso,
        $estado,
        $nombre,
        $celular,
        $riesgo,
        $documento,
        $fecha_solicitud,
        $duracion,
        $unidad_duracion,
        $email,
        $fecha_inicio,
        $fecha_fin,
        $usuario_id,
        $motivo,
        $comentario_admin,
        $otro_motivo,
        $motivo_otro
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>
                alert('Permiso registrado exitosamente.');
                permisos_backend.php = window.location.href; // Recargar la página actual
              </script>";
    } else {
        echo "<script>
                alert('Error al registrar el permiso: " . $stmt->error . "');
                permisos_backend.php = window.location.href; // Recargar la página actual
              </script>";
    }

    // Cerrar la consulta y conexión
    $stmt->close();
    $conn->close();
}

?>
