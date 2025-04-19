<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'conexion.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $resultado = $conexion->query("SELECT * FROM Libros WHERE id = $id");
            echo json_encode($resultado->fetch_assoc());
        } else {
            $resultado = $conexion->query("SELECT * FROM Libros");
            $libros = [];
            while ($fila = $resultado->fetch_assoc()) {
                $libros[] = $fila;
            }
            echo json_encode($libros);
        }
        break;

    case 'POST':
        $datos = json_decode(file_get_contents("php://input"), true);
        if (!isset($datos['titulo']) || !isset($datos['autor'])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios"]);
            break;
        }

        $titulo = $conexion->real_escape_string($datos['titulo']);
        $autor = $conexion->real_escape_string($datos['autor']);
        $query = "INSERT INTO Libros (titulo, autor) VALUES ('$titulo', '$autor')";

        if ($conexion->query($query)) {
            http_response_code(201);
            echo json_encode(["mensaje" => "Libro creado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al crear libro"]);
        }
        break;

    case 'PUT':
        parse_str($_SERVER['QUERY_STRING'], $params);
        if (!isset($params['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID no proporcionado"]);
            break;
        }

        $id = $params['id'];
        $datos = json_decode(file_get_contents("php://input"), true);
        $titulo = $conexion->real_escape_string($datos['titulo']);
        $autor = $conexion->real_escape_string($datos['autor']);

        $query = "UPDATE Libros SET titulo='$titulo', autor='$autor' WHERE id=$id";
        if ($conexion->query($query)) {
            echo json_encode(["mensaje" => "Libro actualizado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar libro"]);
        }
        break;

    case 'DELETE':
        parse_str($_SERVER['QUERY_STRING'], $params);
        if (!isset($params['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID no proporcionado"]);
            break;
        }

        $id = $params['id'];

        // Verificar si el libro está relacionado en favoritos
        $verificar = $conexion->query("SELECT COUNT(*) AS total FROM favoritos WHERE libro_id = $id");
        $conteo = $verificar->fetch_assoc()['total'];

        if ($conteo > 0) {
            http_response_code(409); // Conflicto
            echo json_encode(["error" => "No se puede eliminar el libro porque está en favoritos"]);
            break;
        }

        $query = "DELETE FROM Libros WHERE id=$id";
        if ($conexion->query($query)) {
            echo json_encode(["mensaje" => "Libro eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar libro"]);
        }
        break;

    default:
        http_response_code(405); // Método no permitido
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
