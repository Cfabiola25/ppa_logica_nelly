<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if (!isset($_SESSION['documento_identidad'])) {
    echo "Por favor inicie sesión para ver sus solicitudes.";
    exit();
}

$documento_identidad = $_SESSION['documento_identidad'];

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Asegura que la conexión esté activa
$conn->query("SET SESSION wait_timeout=28800;");

// Consulta para obtener los datos incluyendo 'comentario_admin'
$sql = "SELECT id, documento_identidad, nombre, tipo_permiso, motivo, otro_motivo, fecha_solicitud, fecha_inicio, fecha_fin, estado, comentario_admin
        FROM permisos 
        WHERE documento_identidad = ? 
        ORDER BY fecha_solicitud DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $documento_identidad);

if (!$stmt->execute()) {
    die("Error en la ejecución de la consulta: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
    echo "<thead>
            <tr>
                <th>ID</th>
                <th>Documento de Identidad</th>
                <th>Nombre</th>
                <th>Tipo de Permiso</th>
                <th>Motivo</th>
                <th>Otro Motivo</th>
                <th>Fecha de Solicitud</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Estado</th>
                <th>Comentario Administrador</th>
                <th>Acciones</th>
            </tr>
          </thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['documento_identidad'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['nombre'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['tipo_permiso'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['motivo'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['otro_motivo'] ?? '') . "</td>";
        echo "<td>" . date('Y-m-d H:i:s', strtotime($row['fecha_solicitud'])) . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_inicio'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_fin'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['estado'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['comentario_admin'] ?? 'Sin comentario') . "</td>";
        echo "<td>
                <a href='ver_Detalles.php?id=" . htmlspecialchars($row['id'] ?? '') . "'>
                    <button class='btn'>Ver Detalles</button>
                </a> 
                <a href='editar.php?id=" . htmlspecialchars($row['id'] ?? '') . "'> 
                    <button class='btn'>Editar</button> 
                </a> 
                <a href='eliminar.php?id=" . htmlspecialchars($row['id'] ?? '') . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar esta solicitud?\")'> 
                    <button class='btn'>Eliminar</button>
                </a> 
                <a href='ver_documento.php?id=" . htmlspecialchars($row['id'] ?? '') . "'>
                    <button class='btn'>Ver Documento</button>
                </a>
              </td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "No hay solicitudes realizadas por usted.";
}

$stmt->close();
$conn->close();
?>
