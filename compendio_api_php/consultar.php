<?php
// Encabezados básicos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Conexión reutilizando db.php
require_once 'db.php';

// Si viene un parámetro id, filtramos; si no, listamos todo
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
} else {
    $stmt = $conn->prepare("SELECT * FROM libros");
}

// Ejecutar y obtener resultados
$stmt->execute();
$resultado = $stmt->get_result();
$libros = $resultado->fetch_all(MYSQLI_ASSOC);

// Responder en JSON
echo json_encode($libros ?: []);

$stmt->close();
$conn->close();
?>
