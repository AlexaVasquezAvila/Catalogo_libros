<?php
// Configuración de conexión
$host = 'localhost';
$usuario = 'root';          // Usuario por defecto en XAMPP
$contraseña = '';           // Contraseña por defecto en blanco
$base_de_datos = 'compendio_literario';

// Crear conexión
$conn = new mysqli($host, $usuario, $contraseña, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    http_response_code(500); // Código HTTP de error interno
    die("Error de conexión: " . $conn->connect_error);
}
?>
