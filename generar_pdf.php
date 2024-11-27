<?php
require_once __DIR__ . '/mpdf/vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

// Conectar a la base de datos
include 'db.php';

// Consultar las solicitudes
$sql = "SELECT * FROM permisos";
$result = $conn->query($sql);

$html = '<h1>Listado de Solicitudes</h1>';
$html .= '<table border="1" cellpadding="5">';
$html .= '<tr>
            <th>Documento Identidad</th>
            <th>Nombre</th>
            <th>Celular</th>
            <th>Riesgo</th>
            <th>Tipo Permiso</th>
            <th>Motivo</th>
            <th>Fecha Permiso</th>
            <th>Duración</th>
            <th>Unidad Duración</th>
            <th>Email</th>
            <th>Estado</th>
          </tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['documento_identidad']) . '</td>
                    <td>' . htmlspecialchars($row['Nombre']) . '</td>
                    <td>' . htmlspecialchars($row['celular']) . '</td>
                    <td>' . htmlspecialchars($row['riesgo']) . '</td>
                    <td>' . htmlspecialchars($row['tipo_permiso']) . '</td>
                    <td>' . htmlspecialchars($row['motivo']) . '</td>
                    <td>' . htmlspecialchars($row['fecha_permiso']) . '</td>
                    <td>' . htmlspecialchars($row['duracion']) . '</td>
                    <td>' . htmlspecialchars($row['unidad_duracion']) . '</td>
                    <td>' . htmlspecialchars($row['email']) . '</td>
                    <td>' . htmlspecialchars($row['estado']) . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="11">No hay solicitudes disponibles.</td></tr>';
}

$html .= '</table>';

// Crear una instancia de mPDF
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('solicitudes.pdf', 'D'); // 'D' para descargar, 'I' para mostrar en el navegador
exit;
?>
