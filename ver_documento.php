<?php
include 'db.php';

// Verificar si se ha pasado el ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener los detalles de la solicitud
    $sql = "SELECT documento FROM permisos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró la solicitud
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar si el campo 'documento' tiene valor
        if (empty($row['documento'])) {
            echo "No se ha adjuntado ningún documento.";
        } else {
            // Si hay un documento, verificamos si el archivo existe
            $documento = 'uploads/' . $row['documento'];  // Prependemos 'uploads/' a la ruta
            echo "Ruta del documento: " . htmlspecialchars($documento) . "<br>";  // Depuración
            if (file_exists($documento)) {
                echo "<h2>Documento de la Solicitud</h2>";  "<br>";
                echo "<iframe src='" . htmlspecialchars($documento) . "' width='100%' height='600px'></iframe>";
            } else {
                echo "El documento no existe o no se puede acceder.";
            }
        }
    } else {
        echo "No se encontró la solicitud.";
    }
    $stmt->close();
} else {
    echo "ID no proporcionado.";
}

$conn->close();
?>

<html>
    <head>
        <body>
            <style>
                /* Estilo general para el cuerpo */
body {
    font-family: Times, serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Contenedor principal */
.container {
    width: 80%;
    max-width: 900px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Título */
h2 {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Estilo para los mensajes */
.message {
    text-align: center;
    font-size: 18px;
    color: #d9534f; /* Rojo para mensajes de error */
    margin-top: 20px;
}

/* Estilo para los iframes */
iframe {
    width: 100%;
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Mensajes cuando no hay documentos */
.no-document {
    font-size: 18px;
    color: #5bc0de; /* Azul para mensajes informativos */
    text-align: center;
    margin-top: 20px;
}

/* Mensajes cuando el documento no se puede acceder */
.error-message {
    font-size: 18px;
    color: #f0ad4e; /* Naranja para mensajes de advertencia */
    text-align: center;
    margin-top: 20px;
}
            </style>
        </body>
    </head>
</html>