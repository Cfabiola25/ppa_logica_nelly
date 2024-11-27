<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Permiso</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <form id="solicitudForm" action="permisos_backend.php" method="POST" enctype="multipart/form-data" style="width: 600px;">
        <h1>Solicitar Permiso</h1>
        <div class="form-group">
            <label for="documento_identidad">Documento de Identidad</label>
            <!-- El campo estará prellenado y no se podrá editar -->
            <input type="text" id="documento_identidad" name="documento_identidad" value="<?php echo htmlspecialchars($documento_identidad); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="Correo Electrónico" required>
        </div>
        <div class="form-group">
            <label for="tipo_permiso">Tipo de Permiso</label>
            <select id="tipo_permiso" name="tipo_permiso" required>
                <option value="" disabled selected>Seleccione</option>
                <option value="remunerado">Remunerado</option>
                <option value="no_remunerado">No Remunerado</option>
            </select>
        </div>
        <div class="form-group">
            <label for="motivo">Motivo</label>
            <select id="motivo" name="motivo" required>
                <option value="" disabled selected>Seleccione</option>
                <option value="Familiar">Familiar</option>
                <option value="Salud">Salud</option>
                <option value="Estudios">Estudios</option>
                <option value="Otro">Otro (especificar)</option>
            </select>
        </div>
        <div class="form-group hidden" id="descripcion-group">
            <label for="descripcion">Especifique el motivo</label>
            <textarea id="descripcion" name="descripcion" placeholder="Describa el motivo aquí"></textarea>
        </div>
        <div class="form-group">
            <label for="riesgo">Riesgo</label>
            <select id="riesgo" name="riesgo" required>
                <option value="" disabled selected>Seleccione el nivel de riesgo</option>
                <option value="Alto">Alto</option>
                <option value="Medio">Medio</option>
                <option value="Bajo">Bajo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_solicitud">Fecha de Solicitud</label>
            <input type="date" id="fecha_solicitud" name="fecha_solicitud" required>
        </div>
        <div class="form-group">
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha de Fin</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>
        </div>
        <div class="form-group">
            <label for="duracion">Duración</label>
            <input type="number" id="duracion" name="duracion" placeholder="Duración en número" required>
        </div>
        <div class="form-group">
            <label for="unidad_duracion">Unidad de Duración</label>
            <select id="unidad_duracion" name="unidad_duracion" required>
                <option value="" disabled selected>Seleccione unidad</option>
                <option value="días">Días</option>
                <option value="horas">Horas</option>
                <option valie="meses">Meses</option>
            </select>
        </div>
        <div class="form-group">
            <label for="documento">Adjuntar Documento</label>
            <input type="file" id="documento" name="documento">
        </div>
        <button type="submit" name="enviar">Enviar Solicitud</button>
    </form>
    <script>
        document.getElementById('motivo').addEventListener('change', function () {
            var descripcionGroup = document.getElementById('descripcion-group');
            if (this.value === 'Otro') {
                descripcionGroup.classList.remove('hidden');
            } else {
                descripcionGroup.classList.add('hidden');
            }
        });
    </script>

    <script> 
        function generarPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Obtener los valores de los campos de entrada
            const nombre = document.getElementById('nombre').value;
            const documento = document.getElementById('documento').value;
            const tipoPermiso = document.getElementById('tipo_permiso').value;
            const motivo = document.getElementById('motivo').value;
            const descripcion = document.getElementById('descripcion').value || 'N/A';
            const fechaSolicitud = document.getElementById('fecha_solicitud').value;
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            const duracion = document.getElementById('duracion').value;
            const unidadDuracion = document.getElementById('unidad_duracion').value;

            // Agregar contenido al PDF con estilo
            doc.setFontSize(20);
            doc.setTextColor(0, 0, 139);
            doc.text('Detalles de la Solicitud', 105, 20, null, null, 'center');

            doc.setFontSize(12);
            doc.setTextColor(0, 0, 0);
            doc.text(Documento de Identidad: ${documento}, 20, 40);
            doc.text(Nombre: ${nombre}, 20, 50);
            doc.text(Tipo de Permiso: ${tipoPermiso}, 20, 60);
            doc.text(Motivo: ${motivo}, 20, 70);
            if (motivo === 'Otro') doc.text(Descripción: ${descripcion}, 20, 80);
            doc.text(Fecha de Solicitud: ${fechaSolicitud}, 20, 90);
            doc.text(Fecha de Inicio: ${fechaInicio}, 20, 100);
            doc.text(Fecha de Fin: ${fechaFin}, 20, 110);
            doc.text(Duración: ${duracion} ${unidadDuracion}, 20, 120);

            doc.save('detalles_solicitud.pdf');
        }
    </script>
</body>
</html>