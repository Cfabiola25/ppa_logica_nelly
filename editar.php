<?php
include 'db.php';

// Mostrar errores para depurar
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los detalles actuales
    $sql = "SELECT * FROM permisos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('No se encontró la solicitud.');</script>";
        exit;
    }

    // Validar datos existentes
    $documento_identidad = $row['documento_identidad'] ?? '';
    $nombre = $row['nombre'] ?? '';
    $tipo_permiso = $row['tipo_permiso'] ?? '';
    $motivo = $row['motivo'] ?? '';
    $otro_motivo = $row['otro_motivo'] ?? '';
    $fecha_inicio = $row['fecha_inicio'] ?? '';
    $fecha_fin = $row['fecha_fin'] ?? '';

    // Procesar el formulario de edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento_identidad = $_POST['documento_identidad'];
        $nombre = $_POST['nombre'];
        $tipo_permiso = $_POST['tipo_permiso'];
        $motivo = $_POST['motivo'];
        $otro_motivo = ($motivo === "otro" && !empty($_POST['otro_motivo_input'])) ? $_POST['otro_motivo_input'] : NULL;
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        // Validar campos
        if (empty($documento_identidad) || empty($nombre) || empty($tipo_permiso) || empty($motivo) || empty($fecha_inicio) || empty($fecha_fin)) {
            echo "<script>alert('Por favor, complete todos los campos obligatorios.');</script>";
            exit;
        }

        // Actualizar la solicitud
        $sql = "UPDATE permisos SET documento_identidad = ?, nombre = ?, tipo_permiso = ?, motivo = ?, otro_motivo = ?, fecha_inicio = ?, fecha_fin = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("sssssssi", $documento_identidad, $nombre, $tipo_permiso, $motivo, $otro_motivo, $fecha_inicio, $fecha_fin, $id);

        if ($stmt->execute()) {
            echo "<script>
                alert('Solicitud actualizada con éxito.');
                window.location.href = ''; // Redirigir al listado
            </script>";
            exit;
        } else {
            echo "<script>alert('Error al actualizar la solicitud: " . $stmt->error . "');</script>";
        }
    }
} else {
    echo "<script>alert('ID no proporcionado.');</script>";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitud</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 10cm;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }
        .container h2 {
            font-size: 24px;
            color: #4a90e2;
            text-align: center;
            margin-bottom: 20px;
        }
        .forms {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .forms label {
            text-align: left;
            font-weight: bold;
        }
        .forms input[type="text"],
        .forms input[type="date"],
        .forms select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .forms button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .forms button:hover {
            background-color: #357ab8;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            padding: 10px;
            font-size: 16px;
            background-color: #ccc;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #bbb;
        }
        #motivo_otro {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" class="forms">
            <h2>Editar Solicitud</h2>
            <label>Documento de Identidad:</label>
            <input type="text" name="documento_identidad" value="<?php echo htmlspecialchars($documento_identidad); ?>" required>
            
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            
            <label>Tipo de Permiso:</label>
            <select name="tipo_permiso" required>
                <option value="" disabled <?php echo ($tipo_permiso === '') ? 'selected' : ''; ?>>Seleccione</option>
                <option value="remunerado" <?php echo ($tipo_permiso === 'remunerado') ? 'selected' : ''; ?>>Remunerado</option>
                <option value="no_remunerado" <?php echo ($tipo_permiso === 'no_remunerado') ? 'selected' : ''; ?>>No Remunerado</option>
            </select>
            
            <label>Motivo:</label>
            <select name="motivo" id="motivo" onchange="mostrarMotivoOtro()">
                <option value="" disabled <?php echo ($motivo === '') ? 'selected' : ''; ?>>Seleccione</option>
                <option value="familiar" <?php echo ($motivo === 'familiar') ? 'selected' : ''; ?>>Familiar</option>
                <option value="salud" <?php echo ($motivo === 'salud') ? 'selected' : ''; ?>>Salud</option>
                <option value="estudio" <?php echo ($motivo === 'estudio') ? 'selected' : ''; ?>>Estudio</option>
                <option value="otro" <?php echo ($motivo === 'otro') ? 'selected' : ''; ?>>Otro</option>
            </select>
            
            <div id="otro_motivo_div" style="display: <?php echo ($motivo === 'otro') ? 'block' : 'none'; ?>;">
    <label for="otro_motivo_input">Especifique el motivo:</label>
    <input name="otro_motivo_input" id="otro_motivo_input" type="text" value="<?php echo htmlspecialchars($otro_motivo); ?>">
</div>
            
            <label>Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" value="<?php echo htmlspecialchars($fecha_inicio); ?>" required>
            
            <label>Fecha de Fin:</label>
            <input type="date" name="fecha_fin" value="<?php echo htmlspecialchars($fecha_fin); ?>" required>

            <button type="submit">Actualizar Solicitud</button>
        </form>
        
        <a href="javascript: history.go(-1)" class="back-button">Volver</a>
    </div>

   <script>
    function mostrarMotivoOtro() {
        var motivoSelect = document.getElementById("motivo");
        var otroMotivoDiv = document.getElementById("otro_motivo_div");
        var otroMotivoInput = document.getElementById("otro_motivo_input");

        if (motivoSelect.value === "otro") {
            otroMotivoDiv.style.display = "block";
            otroMotivoInput.required = true;
        } else {
            otroMotivoDiv.style.display = "none";
            otroMotivoInput.required = false;
            otroMotivoInput.value = "";
        }
    }
</script>
</body>
</html>
