<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php'; // Asegúrate de incluir la conexión a la base de datos aquí

// Ejemplo de manejo de solicitudes
if (isset($_POST['aprobar']) || isset($_POST['rechazar'])) {
    $id_permiso = $_POST['id_permiso'];
    $estado = isset($_POST['aprobar']) ? 'Aprobado' : 'Rechazado'; // Determina el estado según el botón presionado
    
    // Obtener el correo del usuario desde la base de datos
    $query = "SELECT email, Nombre FROM permisos WHERE id = '$id_permiso'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $nombre_usuario = $row['Nombre'];

        // Actualizar el estado en la base de datos
        $sql_update = "UPDATE permisos SET estado = '$estado' WHERE id = '$id_permiso'";
        if ($conn->query($sql_update) === TRUE) {
            // Enviar correo de notificación
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'nellycano800@gmail.com';
                $mail->Password = '';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('nellycano800@gmail.com', 'Nombre de tu Empresa');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Estado de Solicitud de Permiso';
                $mail->Body    = "Hola $nombre,<br> Su solicitud de permiso ha sido <strong>$estado</strong>.<br> ¡Gracias!";
                $mail->send();

                echo 'Correo de notificación enviado correctamente.';
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error al actualizar el estado: " . $conn->error;
        }
    } else {
        echo "No se encontró el correo del usuario.";
    }
}

// Verifica el tipo de usuario
$tipo = $_SESSION['role'] ?? null;
$email_usuario = $_SESSION['documento_identidad'] ?? null;

// Verifica si el usuario tiene acceso a esta página
if (!$tipo || ($tipo !== 'admin' && $tipo !== 'usuario')) {
    echo "Acceso no autorizado";
    exit;
}

if ($tipo === 'admin') {
    $sql = "SELECT * FROM permisos"; // Asegúrate de que la tabla sea permisos y no solicitudes
} else {
    $sql = "SELECT * FROM permisos WHERE documento_identidad = '$email_usuario'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Documento de Identidad</th>
            <th>Nombre</th>
            <th>Tipo de Permiso</th>
            <th>Motivo</th>
            <th>Fecha de Solicitud</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['documento_identidad']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Nombre']) . "</td>"; // Mostrar Nombre
        echo "<td>" . htmlspecialchars($row['tipo_permiso']) . "</td>";
        echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_solicitud']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_inicio']) . "</td>"; // Campo Fecha de Inicio
        echo "<td>" . htmlspecialchars($row['fecha_fin']) . "</td>"; // Campo Fecha de Fin
        echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
        
        // Acciones para aprobar o rechazar
        echo "<td>
            <a href='procesar_solicitud.php?id=" . htmlspecialchars($row['id']) . "&accion=aprobar'>
        <button>Aprobar</button>
            </a>
            <a href='procesar_solicitud.php?id=" . htmlspecialchars($row['id']) . "&accion=rechazar'>
        <button>Rechazar</button>
            </a>
              </td>";
        
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay solicitudes para mostrar.";
}

$conn->close();
?>
