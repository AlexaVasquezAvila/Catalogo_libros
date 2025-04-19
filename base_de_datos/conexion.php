<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "compendio_literario"; // 👈 cambia esto por el nombre real de tu base

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    http_response_code(500);
    die(json_encode(["error" => "Error de conexión: " . $conexion->connect_error]));
}
?>
