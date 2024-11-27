<?php
include 'db.php';

// Consulta SQL para obtener las solicitudes aprobadas con 'comentario_admin'
$sql = "SELECT id, documento_identidad, nombre, tipo_permiso, motivo, otro_motivo, fecha_solicitud, fecha_inicio, fecha_fin, estado
        FROM permisos 
        WHERE estado = 'Aprobado' 
        ORDER BY fecha_solicitud DESC";

$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
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
          </tr>";

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
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No hay solicitudes aprobadas.";
}

$conn->close();
?>
