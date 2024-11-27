<?php
// procesar_recuperacion.php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $documento_identidad = $_POST['documento_identidad'];

    // Buscar el usuario en la base de datos
    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE documento_identidad = ?");
    $stmt->bind_param("s", $documento_identidad);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $email_usuario = $user['email'];

        // Generar token y expiración
        $token = bin2hex(random_bytes(50));
        $token_expiracion = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Guardar el token y la expiración en la base de datos
        $stmt = $conn->prepare("UPDATE usuarios SET token = ?, token_expiracion = ? WHERE documento_identidad = ?");
        $stmt->bind_param("sss", $token, $token_expiracion, $documento_identidad);
        $stmt->execute();

        // Enviar correo de recuperación
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nellycano800@gmail.com';
            $mail->Password = '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('nellycano800@gmail.com', 'Nombre de la Empresa');
            $mail->addAddress($email_usuario);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body    = "Haz clic en el enlace para restablecer tu contraseña: 
                              <a href='http://tu-dominio.com/restablecer.php?token=$token'>Restablecer contraseña</a>";
            $mail->AltBody = "Haz clic en el enlace para restablecer tu contraseña: http://tu-dominio.com/restablecer.php?token=$token";

            $mail->send();
            echo "Correo de recuperación enviado.";
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "No se encontró un usuario con ese documento de identidad.";
    }
}
?>
