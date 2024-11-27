<?php
include 'db.php';

// Manejo de las solicitudes de aprobación o rechazo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_permiso = $_POST['id_permiso'] ?? null;

    if (isset($_POST['aprobar'])) {
        // Actualiza el estado a "Aprobado"
        $sql = "UPDATE permisos SET estado = 'Aprobado' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_permiso);
        $stmt->execute();

        // Puedes agregar aquí el código para enviar notificación por correo si es necesario

        echo "<p>Solicitud aprobada.</p>";
    } elseif (isset($_POST['rechazar'])) {
        // Actualiza el estado a "Rechazado"
        $sql = "UPDATE permisos SET estado = 'Rechazado' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_permiso);
        $stmt->execute();

        // Puedes agregar aquí el código para enviar notificación por correo si es necesario

        echo "<p>Solicitud rechazada.</p>";
    }
}

// Consulta SQL para obtener las solicitudes pendientes
$sql = "SELECT id, documento_identidad, nombre, tipo_permiso, motivo, otro_motivo, fecha_solicitud, fecha_inicio, fecha_fin, estado 
        FROM permisos 
        WHERE estado = 'Pendiente' 
        ORDER BY fecha_solicitud DESC";

$result = $conn->query($sql);

// Verificar si hay resultados y crear la tabla
echo "<table border='1'>";
echo "<tr>
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
        <th>Acciones</th>
        <th>Accion Admin</th>
      </tr>";

if ($result->num_rows > 0) {
    // Mostrar cada fila de resultados
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['documento_identidad']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tipo_permiso']) . "</td>";
        echo "<td>" . htmlspecialchars($row['motivo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['otro_motivo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_solicitud']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_inicio']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fecha_fin']) . "</td>";
        echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
        echo "<td>
        <a href='ver_Detalles.php?id=" . htmlspecialchars($row['id']) . "'>
            <button class='btn'>Ver Detalles</button>
        </a> 
        <a href='editar.php?id=" . htmlspecialchars($row['id']) . "'> 
            <button class='btn'>Editar</button> 
        </a> 
        <a href='eliminar.php?id=" . htmlspecialchars($row['id']) . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar esta solicitud?\")'> 
            <button class='btn'>Eliminar</button>
        </a> 
        <a href='ver_documento.php?id=" . htmlspecialchars($row['id']) . "'>
            <button class='btn'>Ver Documento</button>
        </a>
      </td>";
        echo "<td>
                <form method='POST'>
                    <input type='hidden' name='id_permiso' value='" . htmlspecialchars($row['id']) . "'>
                    <button type='submit' name='aprobar'>Aprobar</button>
                    <button type='submit' name='rechazar'>Rechazar</button>
                </form>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No hay solicitudes pendientes.</td></tr>";
}

echo "</table>";

// Si no hay resultados, mostrar un mensaje
if ($result->num_rows === 0) {
    echo "No hay solicitudes para mostrar.";
}

$conn->close();
?>