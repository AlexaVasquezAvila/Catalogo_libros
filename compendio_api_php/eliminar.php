<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");   // 1️⃣  cabecera CORS extra
header("Content-Type: application/json; charset=UTF-8");

require_once 'db.php';

/* 2️⃣  Asegúrate de que realmente llegó un DELETE
       (por si alguien entra por navegador y hace GET) */
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);            // Método no permitido
    exit(json_encode(["error"=>"Método no permitido"]));
}

/* 3️⃣  Lee el cuerpo (form‑urlencoded) y valida el id */
parse_str(file_get_contents("php://input"), $data);
$id = intval($data['id'] ?? 0);

if ($id <= 0) {                         // id ausente o inválido
    http_response_code(400);            // Bad Request
    exit(json_encode(["error"=>"Id inválido o faltante"]));
}

/* 4️⃣  Ejecuta el DELETE con manejo de errores */
$stmt = $conn->prepare("DELETE FROM libros WHERE id = ?");
if (!$stmt) {                           // fallo al preparar
    http_response_code(500);
    exit(json_encode(["error"=>"Error al preparar la consulta"]));
}

$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows) {
    http_response_code(201);            // éxito
    echo json_encode(["mensaje"=>"Libro eliminado"]);
} else {
    http_response_code(404);            // no existe
    echo json_encode(["error"=>"Libro no encontrado"]);
}

$stmt->close();
$conn->close();
?>
