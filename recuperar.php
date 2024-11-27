<!-- recuperar.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <h2>Recuperar Contraseña</h2>
    <form action="procesar_recuperacion.php" method="post">
        <label for="documento_identidad">Documento de Identidad:</label>
        <input type="text" id="documento_identidad" name="documento_identidad" required>
        <button type="submit">Recuperar</button>
    </form>
</body>
</html>
