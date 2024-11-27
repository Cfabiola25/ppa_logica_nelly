<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <style>
        /* Estilo para centrar el contenedor en la pantalla */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
            height: 100vh; /* Altura total de la ventana */
            background-color: #f8f9fa; /* Fondo claro opcional */
            font-family: Arial, sans-serif; /* Fuente general */
        }

        #containerIndex {
            text-align: center; /* Centrar texto y elementos internos */
            background-color: #ffffff; /* Fondo blanco */
            padding: 30px;
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        #containerIndex h1 {
            font-size: 24px;
            margin-bottom: 20px; /* Separación entre el título y los botones */
        }

        .fbi {
            text-align: center; /* Centrar contenido dentro de la clase */
            margin-top: 10px;
        }

        .fbi a {
            display: inline-block; /* Hacer que los enlaces sean visualmente botones */
            padding: 20px 40px; /* Botones más grandes */
            font-size: 18px; /* Fuente más grande */
            text-decoration: none; /* Eliminar subrayado */
            color: #fff; /* Texto blanco */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer;
            margin: 10px; /* Separación entre botones */
            transition: background-color 0.3s ease; /* Suavizar cambio de color */
        }

        .fbi a.admin {
            background-color: #28a745; /* Color verde para Admin */
        }

        .fbi a.admin:hover {
            background-color: #1c7430; /* Verde más oscuro al pasar el cursor */
        }

        .fbi a.usuario {
            background-color: #007bff; /* Color azul para Usuario */
        }

        .fbi a.usuario:hover {
            background-color: #024185; /* Azul más oscuro al pasar el cursor */
        }
    </style>
</head>
<body>
    <div id="containerIndex">
        <h1>Bienvenido a la Plataforma de Gestión de Permisos</h1>
        <div class="fbi">
            <a href="login.php?tipo=admin" class="admin">Admin</a>
            <a href="login.php?tipo=usuario" class="usuario">Usuario</a>
        </div>
    </div>
</body>
</html>