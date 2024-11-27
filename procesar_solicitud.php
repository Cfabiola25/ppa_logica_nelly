<?php
include 'db.php';

/* @var mysqli $conn */
if (!isset($_GET['id']) || !isset($_GET['accion'])) {
    echo "Solicitud inválida.";
    exit;
}

$id_permiso = intval($_GET['id']);
$accion = $_GET['accion'];

if ($accion !== 'aprobar' && $accion !== 'rechazar') {
    echo "Acción inválida.";
    exit;
}

// Consulta los detalles de la solicitud
$sql = "SELECT * FROM permisos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_permiso);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No se encontró la solicitud.";
    exit;
}

$permiso = $result->fetch_assoc();
?>

<h1><?php echo ucfirst($accion); ?> Solicitud</h1>

<p>Solicitud de: <?php echo htmlspecialchars($permiso['nombre']); ?></p>
<p>Motivo: <?php echo htmlspecialchars($permiso['motivo']); ?></p>
<p>Fecha de solicitud: <?php echo htmlspecialchars($permiso['fecha_solicitud']); ?></p>

<form action="guardar_solicitud.php" method="POST">
    <input type="hidden" name="id_permiso" value="<?php echo $id_permiso; ?>">
    <input type="hidden" name="accion" value="<?php echo $accion; ?>">
    <label for="comentario_admin">Comentario (opcional):</label><br>
    <textarea name="comentario_admin" id="comentario_admin" rows="4" cols="50"></textarea><br><br>
    <button type="submit">Guardar</button>
    <a href="solicitudes_pendientes.php"><button type="button">Cancelar</button></a>
</form>
