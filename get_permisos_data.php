<?php
header('Content-Type: application/json');

include 'db.php';

// Consulta que cuenta las solicitudes agrupadas por estado
$sql = "SELECT estado, COUNT(*) as cantidad FROM permisos GROUP BY estado";
$result = $conn->query($sql);

// Inicializa el arreglo de datos en 0 para cada estado posible
$data = ["Aprobado" => 0, "Rechazado" => 0, "Pendiente" => 0];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $estado = $row['estado'];
        $data[$estado] = (int)$row['cantidad'];
    }
}

// Envía los datos en formato JSON
echo json_encode($data);
$conn->close();
?>

