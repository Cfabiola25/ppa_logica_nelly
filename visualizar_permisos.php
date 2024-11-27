<?php
include 'db.php';

// Consulta para obtener todas las solicitudes de permisos sin el tiempo transcurrido en horas
$sql = "SELECT id, documento_identidad, Nombre, tipo_permiso, motivo, fecha_permiso, fecha_inicio, fecha_fin, estado, fecha_solicitud
        FROM permisos 
        ORDER BY estado, fecha_solicitud ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Estado de Solicitudes de Permisos</h2>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
    echo "<thead>
            <tr>
                <th>ID</th>
                <th>Documento de Identidad</th>
                <th>Nombre</th>
                <th>Tipo de Permiso</th>
                <th>Motivo</th>
                <th>Fecha de Solicitud</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Estado</th>
            </tr>
          </thead>";
    echo "<tbody>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["documento_identidad"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Nombre"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["tipo_permiso"]) . "</td>";
        echo "<td>" . htmlspecialchars(substr($row["motivo"], 0, 25)) . "</td>"; // Limitar a 25 caracteres
        echo "<td>" . htmlspecialchars($row["fecha_solicitud"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["fecha_inicio"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["fecha_fin"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["estado"]) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No hay solicitudes de permisos en el sistema.</p>";
}

$conn->close();
?>
