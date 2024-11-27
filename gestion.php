<?php
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Creación de usuarios y administradores
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
    $documento_identidad = $_POST['documento_identidad'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Nuevo campo para seleccionar el rol

    if ($role === 'admin') {
        // Si el rol es 'admin', insertamos en la tabla 'admin'
        $sql_admin = "INSERT INTO admin (Documento_identidad, Contraseña) 
                      VALUES ('$documento_identidad', '$password')";
        
        if ($conn->query($sql_admin) === TRUE) {
            echo "Administrador creado exitosamente.";
        } else {
            echo "Error al crear el administrador: " . $conn->error;
        }
    } else {
        // Si el rol es 'user', insertamos en la tabla 'usuarios'
        $sql_user = "INSERT INTO usuarios (Documento_identidad, Nombre, Email, Contraseña, role) 
                     VALUES ('$documento_identidad', '$nombre', '$email', '$password', '$role')";
        
        if ($conn->query($sql_user) === TRUE) {
            echo "Usuario creado exitosamente.";
        } else {
            echo "Error al crear el usuario: " . $conn->error;
        }
    }
}

// Aprobación o rechazo de solicitudes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['permiso_id'])) {
    $permiso_id = $_POST['permiso_id'];
    $accion = $_POST['accion'];

    $nuevo_estado = ($accion === 'aprobar') ? 'Aprobado' : 'Rechazado';

    $sql = "UPDATE permisos SET estado = '$nuevo_estado' WHERE id = '$permiso_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Solicitud actualizada exitosamente.";
    } else {
        echo "Error al actualizar la solicitud: " . $conn->error;
    }
}

// Obtener solicitudes pendientes con nombre y documento de identidad
$solicitudesPendientes = "SELECT p.*, u.Nombre, u.Documento_identidad 
                          FROM permisos p
                          JOIN usuarios u ON p.Documento_identidad = u.Documento_identidad
                          WHERE p.estado = 'Pendiente'";
$resultPendientes = $conn->query($solicitudesPendientes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Permisos - Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Bienvenido, Administrador</h1>

    <center><h2>Crear Usuario o Administrador</h2></center>
    <form method="post">
        <input type="hidden" name="create_user">
        <label>Documento de Identidad:</label>
        <input type="text" name="documento_identidad" required><br>
        <label>Nombre:</label>
        <input type="text" name="nombre"><br> <!-- Campo nombre es opcional para administrador -->
        <label>Email:</label>
        <input type="email" name="email"><br> <!-- Campo email es opcional para administrador -->
        <label>Contraseña:</label>
        <input type="password" name="password" required><br>
        <label>Rol:</label>
        <select name="role" required>
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
        </select><br>
        <button type="submit">Crear </button>
    </form>

    <center><h2>Solicitudes Pendientes</h2></center>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Documento de Identidad</th>
            <th>Nombre</th>
            <th>Tipo de Permiso</th>
            <th>Motivo</th>
            <th>Fecha de Solicitud</th>
            <th>Acción</th>
        </tr>
        <?php while ($row = $resultPendientes->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['Documento_identidad']) ?></td>
                <td><?= htmlspecialchars($row['Nombre']) ?></td>
                <td><?= htmlspecialchars($row['tipo_permiso']) ?></td>
                <td><?= htmlspecialchars($row['descripcion']) ?></td>
                <td><?= $row['fecha_solicitud'] ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="permiso_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="accion" value="aprobar">
                        <button type="submit">Aprobar</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="permiso_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="accion" value="rechazar">
                        <button type="submit">Rechazar</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
