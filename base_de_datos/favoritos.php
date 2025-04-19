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
            $resultado = $conexion->query("SELECT * FROM Favoritos WHERE id = $id");
            echo json_encode($resultado->fetch_assoc());
        } else {
            $resultado = $conexion->query("SELECT * FROM Favoritos");
            $favoritos = [];
            while ($fila = $resultado->fetch_assoc()) {
                $favoritos[] = $fila;
            }
            echo json_encode($favoritos);
        }
        break;

    case 'POST':
        $datos = json_decode(file_get_contents("php://input"), true);
        if (!isset($datos['usuario_id']) || !isset($datos['libro_id'])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios"]);
            break;
        }

        $usuario_id = (int)$datos['usuario_id'];
        $libro_id = (int)$datos['libro_id'];

        // Verifica que el usuario y el libro existan
        $validar_usuario = $conexion->query("SELECT id FROM Usuarios WHERE id = $usuario_id");
        $validar_libro = $conexion->query("SELECT id FROM Libros WHERE id = $libro_id");

        if ($validar_usuario->num_rows == 0 || $validar_libro->num_rows == 0) {
            http_response_code(404);
            echo json_encode(["error" => "Usuario o libro no encontrado"]);
            break;
        }

        $query = "INSERT INTO Favoritos (usuario_id, libro_id) VALUES ($usuario_id, $libro_id)";
        if ($conexion->query($query)) {
            http_response_code(201);
            echo json_encode(["mensaje" => "Favorito registrado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar favorito"]);
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
        $usuario_id = (int)$datos['usuario_id'];
        $libro_id = (int)$datos['libro_id'];

        $query = "UPDATE Favoritos SET usuario_id=$usuario_id, libro_id=$libro_id WHERE id=$id";
        if ($conexion->query($query)) {
            echo json_encode(["mensaje" => "Favorito actualizado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar favorito"]);
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
        $query = "DELETE FROM Favoritos WHERE id=$id";
        if ($conexion->query($query)) {
            echo json_encode(["mensaje" => "Favorito eliminado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar favorito"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
