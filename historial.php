<?php
include 'db.php';

$documento_identidad = $_SESSION['documento_identidad'];
$isAdmin = $_SESSION['role'] === 'admin';

$sql = $isAdmin ? 
    "SELECT id, documento_identidad, nombre, tipo_permiso, descripcion, fecha_permiso, fecha_inicio, fecha_fin, estado FROM permisos ORDER BY fecha_permiso DESC" :
    "SELECT id, documento_identidad, nombre, tipo_permiso, descripcion, fecha_permiso, fecha_inicio, fecha_fin, estado FROM permisos WHERE documento_identidad = '$documento_identidad' ORDER BY fecha_permiso DESC";

$result = $conn->query($sql);
?>