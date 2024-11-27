<?php
session_start();
include 'db.php';

// Verificar si el usuario ha iniciado sesión
$documento_identidad = $_SESSION['documento_identidad'] ?? '';

if (!$documento_identidad) {
    header("Location: login.php");
    exit;
}

// Comprobar si se ha solicitado cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Obtener el nombre del usuario desde la base de datos
$query = "SELECT Nombre FROM usuarios WHERE Documento_identidad = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $documento_identidad);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$nombre_usuario = $user['Nombre'] ?? 'Usuario';

// Recuperar estadísticas de permisos desde la base de datos
$stats = [
    'solicitados' => 0,
    'aprobados' => 0,
    'pendientes' => 0,
    'rechazados' => 0
];

if ($isAdmin) {
    // Si es admin, obtener estadísticas generales
    $query = "SELECT 
                COUNT(*) AS total, 
                SUM(Estado = 'Aprobado') AS aprobados,
                SUM(Estado = 'Pendiente') AS pendientes,
                SUM(Estado = 'Rechazado') AS rechazados
              FROM permisos";
} else {
    // Si es usuario, obtener estadísticas específicas
    $query = "SELECT 
                COUNT(*) AS total, 
                SUM(Estado = 'Aprobado') AS aprobados,
                SUM(Estado = 'Pendiente') AS pendientes,
                SUM(Estado = 'Rechazado') AS rechazados
              FROM permisos
              WHERE Documento_identidad = ?";
}

$stmt = $conn->prepare($query);
if (!$isAdmin) {
    $stmt->bind_param("s", $documento_identidad);
}
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$stats['solicitados'] = $data['total'] ?? 0;
$stats['aprobados'] = $data['aprobados'] ?? 0;
$stats['pendientes'] = $data['pendientes'] ?? 0;
$stats['rechazados'] = $data['rechazados'] ?? 0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Barra lateral -->
        <nav class="sidebar">
            <h2>Panel de Control</h2>
            <ul>
                <li><a href="dashboard.php">Inicio</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="?section=historial">Historial de Solicitudes</a></li>
                    <li><a href="?section=solicitudes_aprobadas">Solicitudes Aprobadas</a></li>
                    <li><a href="?section=solicitudes_rechazadas">Solicitudes Rechazadas</a></li>
                    <li><a href="?section=solicitudes_pendientes">Solicitudes Pendientes</a></li>
                    <li><a href="?section=admin">Admin</a></li>
                <?php else: ?>
                    <li><a href="?section=mis_solicitudes">Mis Solicitudes</a></li>
                    <li><a href="?section=nueva_solicitud">Solicitar Permiso</a></li>
                <?php endif; ?>
                <li><a href="?section=graficos">Gráficos en Tiempo Real</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="?section=imprimir">Imprimir</a></li>
                <?php endif; ?>
                <li><a href="?logout=true">Cerrar Sesión</a></li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <div class="content">
            <?php
            $section = $_GET['section'] ?? 'inicio';
            switch ($section) {
                case 'historial':
                    if ($isAdmin) include 'historial_solicitudes.php';
                    else header("Location: login.php");
                    break;
                case 'solicitudes_aprobadas':
                    if ($isAdmin) include 'solicitudes_aprobadas.php';
                    else header("Location: login.php");
                    break;
                case 'solicitudes_rechazadas':
                    if ($isAdmin) include 'solicitudes_rechazadas.php';
                    else header("Location: login.php");
                    break;
                case 'solicitudes_pendientes':
                    if ($isAdmin) include 'solicitudes_pendientes.php';
                    else header("Location: login.php");
                    break;
                case 'admin':
                    if ($isAdmin) include 'gestion.php';
                    else header("Location: login.php");
                    break;
                case 'mis_solicitudes':
                    include 'mis_solicitudes.php';
                    break;
                case 'nueva_solicitud':
                    include 'permisos.php';
                    break;
                case 'graficos':
                    include 'graficos.php';
                    break;
                case 'imprimir':
                    include "imprimir.html";
                    break;
                default:
                    echo "<h1>¡Bienvenid@, $nombre_usuario!</h1>";
                    echo "<p>Al programa de gestión de permisos. Selecciona una sección del menú para ver los detalles.</p>";
                    break;
            }

            // Mostrar estadísticas solo en la página de inicio
            if ($section === 'inicio'): ?>
                <div class="stats">
                    <div class="card">
                        <h3>Permisos Solicitados</h3>
                        <p><?= $stats['solicitados'] ?></p>
                    </div>
                    <div class="card">
                        <h3>Permisos Aprobados</h3>
                        <p><?= $stats['aprobados'] ?></p>
                    </div>
                    <div class="card">
                        <h3>Permisos Pendientes</h3>
                        <p><?= $stats['pendientes'] ?></p>
                    </div>
                    <div class="card">
                        <h3>Permisos Rechazados</h3>
                        <p><?= $stats['rechazados'] ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
