<?php 
include 'db.php';

// Verificar si se ha pasado el ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener los detalles de la solicitud
    $sql = "SELECT * FROM permisos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró la solicitud
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detalles de la Solicitud</title>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
            <style>
                /* Estilos generales */
                body {
                    font-family: Times, serif;
                    background-color: #f4f4f9;
                    color: #333;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }

                h2 {
                    color: #4a90e2;
                    font-size: 24px;
                    margin-bottom: 20px;
                    text-align: center;
                }

                /* Estilos para el contenedor */
                .container {
                    background-color: #ffffff;
                    border-radius: 8px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                    width: 90%;
                    max-width: 400px;
                    text-align: left;
                }

                /* Estilos para el formato en vertical */
                .container p {
                    font-size: 16px;
                    line-height: 1.6;
                    margin: 10px 0;
                }

                .container p span {
                    font-weight: bold;
                    color: #4a90e2;
                }

                /* Contenedor de los botones */
                .buttons-container {
                    display: flex;
                    justify-content: center; /* Centra los botones */
                    gap: 10px; /* Espacio entre los botones */
                    margin-top: 20px;
                }

                /* Estilos para los botones */
                button {
                    background-color: #4a90e2;
                    color: #ffffff;
                    border: none;
                    border-radius: 5px;
                    padding: 10px 15px;
                    font-size: 16px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                    width: auto;
                    max-width: 200px;
                }

                button:hover {
                    background-color: #357ab8;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>Detalles de la Solicitud</h2>
                <p><span>ID:</span> <?php echo htmlspecialchars($row['id']); ?></p>
                <p><span>Documento de Identidad:</span> <?php echo htmlspecialchars($row['documento_identidad']); ?></p>
                <p><span>Nombre:</span> <?php echo htmlspecialchars($row['nombre']); ?></p>
                <p><span>Tipo de Permiso:</span> <?php echo htmlspecialchars($row['tipo_permiso']); ?></p>
                <p><span>Motivo:</span> <?php echo htmlspecialchars($row['motivo']); ?></p>
                <p><span>Fecha de Solicitud:</span> <?php echo htmlspecialchars($row['fecha_solicitud']); ?></p>
                <p><span>Fecha de Inicio:</span> <?php echo htmlspecialchars($row['fecha_inicio']); ?></p>
                <p><span>Fecha de Fin:</span> <?php echo htmlspecialchars($row['fecha_fin']); ?></p>
                <p><span>Comentario de Administrador:</span> <?php echo htmlspecialchars($row['comentario_admin']); ?></p>
                <p><span>Estado:</span> <?php echo htmlspecialchars($row['estado']); ?></p>

                <!-- Contenedor para los botones -->
                <div class="buttons-container">
                    <button onclick="generarPDF()">Generar PDF</button>
                    <button onclick="javascript: history.go(-1)">Volver</button>
                </div>
            </div>

            <script type="text/javascript">
                function generarPDF() {
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF({
                        orientation: "portrait",
                        unit: "mm",
                        format: "A4"
                    });

                    // Título y estilo general
                    doc.setFontSize(18);
                    doc.setTextColor(0, 63, 127);
                    doc.text('Detalles de la Solicitud', 105, 20, null, null, 'center');
                    
                    // Establecer un estilo de línea para separar secciones
                    doc.setFontSize(12);
                    doc.setTextColor(0, 0, 0);
                    doc.text('--------------------------------------------', 105, 30, null, null, 'center');
                    
                    // Texto en formato de párrafo cordial
                    doc.setFontSize(12);
                    let texto = `
Cordial saludo,

A continuación se presentan los detalles de la solicitud de permiso:

ID: ${<?php echo json_encode(htmlspecialchars($row['id'])); ?>}
Documento de Identidad: ${<?php echo json_encode(htmlspecialchars($row['documento_identidad'])); ?>}
Nombre: ${<?php echo json_encode(htmlspecialchars($row['nombre'])); ?>}
Tipo de Permiso: ${<?php echo json_encode(htmlspecialchars($row['tipo_permiso'])); ?>}
Motivo: ${<?php echo json_encode(htmlspecialchars($row['motivo'])); ?>}
Fecha de Solicitud: ${<?php echo json_encode(htmlspecialchars($row['fecha_solicitud'])); ?>}
Fecha de Inicio: ${<?php echo json_encode(htmlspecialchars($row['fecha_inicio'])); ?>}
Fecha de Fin: ${<?php echo json_encode(htmlspecialchars($row['fecha_fin'])); ?>}
Comentario de Administrador: ${<?php echo json_encode(htmlspecialchars($row['comentario_admin'])); ?>}
Estado: ${<?php echo json_encode(htmlspecialchars($row['estado'])); ?>}

Firma del Supervisor: __________________________

Generado por: Nelly Fabiola Cano Oviedo
                    `;
                    doc.text(texto, 20, 40);

                    // Guardar PDF
                    doc.save('detalles_solicitud.pdf');
                }
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "No se encontró la solicitud.";
    }
    $stmt->close();
} else {
    echo "ID no proporcionado.";
}

$conn->close();
?>