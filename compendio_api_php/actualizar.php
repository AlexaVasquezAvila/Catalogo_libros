<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
require_once 'db.php';

parse_str(file_get_contents("php://input"), $data);
$id = intval($data['id'] ?? 0);

if ($id === 0) {
    http_response_code(400);
    exit(json_encode(["error"=>"Falta id"]));
}

$stmt = $conn->prepare(
  "UPDATE libros SET titulo=?, autor=?, genero=?, anio_publicacion=? WHERE id=?"
);
$stmt->bind_param(
  "sssii",
  $data['titulo'], $data['autor'], $data['genero'], $data['anio_publicacion'], $id
);

if ($stmt->execute() && $stmt->affected_rows) {
    http_response_code(201);             // ✅ actualizado
    echo json_encode(["mensaje"=>"Libro actualizado"]);
} else {
    http_response_code(404);             // ❌ no existe
    echo json_encode(["error"=>"Libro no encontrado"]);
}
