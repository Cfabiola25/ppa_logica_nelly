<?php
session_start();
require 'db.php';

$tipo = $_GET['tipo'] ?? 'usuario';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento_identidad = $_POST['documento_identidad'];
    $password = $_POST['password'];

    // Usar consultas preparadas para mayor seguridad
    if ($tipo == 'admin') {
        $sql = "SELECT * FROM admin WHERE Documento_identidad = ? AND Contraseña = ?";
    } else {
        $sql = "SELECT * FROM usuarios WHERE Documento_identidad = ? AND Contraseña = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $documento_identidad, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Almacenar el documento de identidad en la sesión
        $_SESSION['role'] = $tipo;
        $_SESSION['documento_identidad'] = $documento_identidad;

        // Redirigir a la página de dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
    /* Centralizar el contenedor del formulario */
    .containerLogin {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f4f4f9;
    }

    /* Cuadro del formulario */
    form {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 400px; /* Ajusta el ancho del cuadro */
        text-align: center; /* Centra el contenido */
    }

    /* Estilos para los campos del formulario */
    label, input, .button-container {
        width: 100%; /* Asegura que todo ocupe el mismo ancho */
        max-width: 360px; /* Controla el ancho máximo de los elementos */
        margin: 0 auto 10px; /* Centra los elementos y agrega espacio inferior */
        display: block;
    }

    input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Botones alineados horizontalmente y centrados */
    .button-container {
        display: flex;
        gap: 10px; /* Espacio entre botones */
    }

    button, .button-link {
        flex: 1;
        padding: 12px;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }

    /* Estilo para el botón Iniciar Sesión */
    button[type="submit"] {
        background-color: #4CAF50;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    /* Estilo para el enlace/botón Volver */
    .button-link {
        background-color: #f44336;
    }

    .button-link:hover {
        background-color: #d32f2f;
    }
    </style>
</head>
<body>
    <div class="containerLogin">
        <form method="post">
            <h2>Iniciar Sesión como <?= ucfirst($tipo) ?></h2>
            <label>Documento de Identidad:</label>
            <input type="text" name="documento_identidad" required>
            
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            
            <div class="button-container">
                <button type="submit">Iniciar Sesión</button>
                <a href="index.php" class="button-link">Volver</a>
            </div>
        </form>
    </div>
</body>
</html>
