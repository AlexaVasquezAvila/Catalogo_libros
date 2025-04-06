<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); // Permite llamadas desde cualquier origen
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';

// Si el método es GET, obtener libros
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM libros";
    $result = $conn->query($sql);

    $libros = [];

    while ($row = $result->fetch_assoc()) {
        $libros[] = $row;
    }

    echo json_encode($libros);
    exit;
}

// Si el método es POST, agregar un nuevo libro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['titulo'], $data['autor'])) {
        http_response_code(400);
        echo json_encode(['mensaje' => 'Datos incompletos']);
        exit;
    }

    $titulo = $conn->real_escape_string($data['titulo']);
    $autor = $conn->real_escape_string($data['autor']);
    $genero = $conn->real_escape_string($data['genero'] ?? '');
    $anio = intval($data['anio_publicacion'] ?? 0);

    $sql = "INSERT INTO libros (titulo, autor, genero, anio_publicacion)
            VALUES ('$titulo', '$autor', '$genero', $anio)";

    if ($conn->query($sql)) {
        http_response_code(201);
        echo json_encode(['mensaje' => 'Libro agregado correctamente']);
    } else {
        http_response_code(500);
        echo json_encode(['mensaje' => 'Error al guardar el libro']);
    }

    exit;
}
?>
