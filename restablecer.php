<?php
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar el token y la expiración
    $stmt = $conn->prepare("SELECT documento_identidad FROM usuarios WHERE token = ? AND token_expiracion > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $documento_identidad = $user['documento_identidad'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nueva_contrasena = password_hash($_POST['nueva_contrasena'], PASSWORD_DEFAULT);

            // Actualizar contraseña y limpiar el token
            $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ?, token = NULL, token_expiracion = NULL WHERE documento_identidad = ?");
            $stmt->bind_param("ss", $nueva_contrasena, $documento_identidad);
            $stmt->execute();

            echo "Contraseña restablecida con éxito.";
        }
    } else {
        echo "Enlace de recuperación inválido o expirado.";
    }
} else {
    echo "Token de recuperación no válido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <h2>Restablecer Contraseña</h2>
    <form method="post">
        <label for="nueva_contrasena">Nueva Contraseña:</label>
        <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
        <button type="submit">Restablecer</button>
    </form>
</body>
</html>
