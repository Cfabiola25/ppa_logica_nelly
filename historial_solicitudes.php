<?php
include 'db.php';

// Consulta para obtener los datos, incluyendo 'comentario_admin'
$sql = "SELECT id, documento_identidad, nombre, tipo_permiso, motivo, fecha_permiso, estado
        FROM permisos 
        ORDER BY fecha_permiso DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Documento de Identidad</th>
            <th>Nombre</th>
            <th>Tipo de Permiso</th>
            <th>Motivo</th>
            <th>Fecha de Solicitud</th>
            <th>Estado</th>
          </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['documento_identidad']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['tipo_permiso']}</td>
                <td>{$row['motivo']}</td>
                <td>{$row['fecha_permiso']}</td>
                <td>{$row['estado']}</td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "No hay solicitudes.";
}

?>
