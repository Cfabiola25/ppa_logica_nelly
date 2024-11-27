<?php
// Iniciar sesión
session_start();

// Conectar a la base de datos
include 'db.php';

// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

// Manejo de formulario de nueva solicitud
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario
    $documento_identidad = $_POST['documento_identidad'];
    $nombre = $_POST['Nombre'];
    $tipo_permiso = $_POST['tipo_permiso'];
    $motivo = $_POST['motivo'];
    $fecha_permiso = $_POST['fecha_permiso'];
    $fecha_inicio = $_POST['fecha_inicio']; // Nueva fecha de inicio
    $fecha_fin = $_POST['fecha_fin']; // Nueva fecha de fin
    $email_usuario = $_POST['email']; // Suponiendo que el email se envía desde el formulario

    // Manejo de archivo subido (si corresponde)
    $documento = $_FILES['documento']['name'] ?? null;
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($documento);

    if ($documento && move_uploaded_file($_FILES['documento']['tmp_name'], $target_file)) {
        // Insertar la solicitud en la base de datos
        $sql = "INSERT INTO permisos (documento_identidad, Nombre, tipo_permiso, motivo, fecha_permiso, fecha_inicio, fecha_fin, estado, documento)
                VALUES ('$documento_identidad', '$nombre', '$tipo_permiso', '$Motivo', '$fecha_permiso', '$fecha_inicio', '$fecha_fin', 'Pendiente', '$documento')";

        if ($conn->query($sql) === TRUE) {
            echo "Solicitud creada con éxito.";
            
            // Enviar correo electrónico al usuario
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Especifica el servidor SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'nellycao800@gmail.com'; // Tu correo electrónico
                $mail->Password = ''; // Coloca aquí la contraseña de tu correo
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Destinatarios
                $mail->setFrom('tu-email@dominio.com', 'Nombre de tu Empresa');
                $mail->addAddress($email_usuario); // Email del usuario

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Confirmación de Solicitud de Permiso';
                $mail->Body    = "Hola, <br> Su solicitud de permiso para <strong>$tipo_permiso</strong> ha sido creada con éxito. <br> Motivo: $motivo <br> Fecha del permiso: $fecha_permiso <br> Fecha de inicio: $fecha_inicio <br> Fecha de fin: $fecha_fin <br> ¡Gracias!";
                $mail->AltBody = "Hola, Su solicitud de permiso para $tipo_permiso ha sido creada con éxito.";

                $mail->send();
                echo 'Correo enviado correctamente.';
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error al crear la solicitud: " . $conn->error;
        }
    } else {
        echo "Error al cargar el archivo. Asegúrate de que el archivo sea correcto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Solicitudes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Crear nueva solicitud de permiso</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="documento_identidad">Documento de Identidad:</label>
        <input type="text" id="documento_identidad" name="documento_identidad" required><br>

        <label for="Nombre">Nombre:</label>
        <input type="text" id="Nombre" name="Nombre" required><br>

        <label for="tipo_permiso">Tipo de Permiso:</label>
        <input type="text" id="tipo_permiso" name="tipo_permiso" required><br>

        <label for="motivo">Motivo:</label>
        <textarea id="motivo" name="motivo" required></textarea><br>

        <label for="fecha_permiso">Fecha Solicitud Permiso:</label>
        <input type="date" id="fecha_permiso" name="fecha_permiso" required><br>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required><br>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="documento">Adjuntar Documento (opcional):</label>
        <input type="file" name="documento" accept=".pdf,.doc,.docx,.jpg,.png"><br>

        <button type="submit">Enviar Solicitud</button>
    </form>

    <!-- Enlace para recuperación de contraseña -->
    <p><a href="recuperar.php">¿Olvidaste tu contraseña?</a></p>

    <!-- Mostrar solicitudes pendientes -->
    <h2>Solicitudes Pendientes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Documento de Identidad</th>
            <th>Nombre</th>
            <th>Tipo de Permiso</th>
            <th>Motivo</th>
            <th>Fecha del Permiso</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
        </tr>
        <?php 
        $result_pendientes = $conn->query("SELECT * FROM permisos WHERE estado='Pendiente'");
        while ($row = $result_pendientes->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['documento_identidad']) ?></td>
                <td><?= htmlspecialchars($row['Nombre']) ?></td>
                <td><?= htmlspecialchars($row['tipo_permiso']) ?></td>
                <td><?= htmlspecialchars($row['motivo']) ?></td>
                <td><?= $row['fecha_permiso'] ?></td>
                <td><?= $row['fecha_inicio'] ?></td>
                <td><?= $row['fecha_fin'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Mostrar historial de solicitudes -->
    <h2>Historial de Solicitudes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Documento de Identidad</th>
            <th>Nombre</th>
            <th>Tipo de Permiso</th>
            <th>Motivo</th>
            <th>Fecha de Solicitud</th>
            <th>Estado</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
        </tr>
        <?php 
        $result_historial = $conn->query("SELECT * FROM permisos WHERE estado != 'Pendiente'");
        while ($row = $result_historial->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['documento_identidad']) ?></td>
                <td><?= htmlspecialchars($row['Nombre']) ?></td>
                <td><?= htmlspecialchars($row['tipo_permiso']) ?></td>
                <td><?= htmlspecialchars($row['motivo']) ?></td>
                <td><?= $row['fecha_permiso'] ?></td>
                <td><?= $row['estado'] ?></td>
                <td><?= $row['fecha_inicio'] ?></td>
                <td><?= $row['fecha_fin'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
