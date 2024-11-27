<?php
// Datos de conexión
$servername = "localhost";
$username = "u256984127_nelly";
$password = "Nose2008;";
$dbname = "u256984127_nelly";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el juego de caracteres a UTF-8
$conn->set_charset("utf8");

?>
