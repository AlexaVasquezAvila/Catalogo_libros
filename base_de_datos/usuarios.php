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
            $resultado = $conexion->query("SELECT * FROM Usuarios WHERE id = $id");
            echo json_encode($resultado->fetch_assoc());
        } else {
            $resultado = $conexion->query("SELECT * FROM Usuarios");
            $usuarios = [];
            while ($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }
            echo json_encode($usuarios);
        }
        break;

    case 'POST':
        $datos = json_decode(file_get_contents("php://input"), true);
        if (!isset($datos['nombre']) || !isset($datos['correo'])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios"]);
            break;
        }

        $nombre = $conexion->real_escape_string($datos['nombre']);
        $correo = $conexion->real_escape_string($datos['correo']);
        $query = "INSERT INTO Usuarios (nombre, correo) VALUES ('$nombre', '$correo')";

        if ($conexion->query($query)) {
            http_response_code(201);
            echo json_encode(["mensaje" => "Usuario creado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al crear usuario"]);
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
        $nombre = $conexion->real_escape_string($datos['nombre']);
        $correo = $conexion->real_escape_string($datos['correo']);

        $query = "UPDATE Usuarios SET nombre='$nombre', correo='$correo' WHERE id=$id";
        if ($conexion->query($query)) {
            echo json_encode(["mensaje" => "Usuario actualizado"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar usuario"]);
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
  
          // 💡 Verificar si el usuario tiene favoritos relacionados
          $verificar = $conexion->query("SELECT COUNT(*) AS total FROM favoritos WHERE usuario_id = $id");
          $conteo = $verificar->fetch_assoc()['total'];
  
          if ($conteo > 0) {
              http_response_code(409); // Conflicto
              echo json_encode(["error" => "No se puede eliminar el usuario porque tiene favoritos asociados"]);
              break;
          }
  
          $query = "DELETE FROM Usuarios WHERE id=$id";
          if ($conexion->query($query)) {
              echo json_encode(["mensaje" => "Usuario eliminado"]);
          } else {
              http_response_code(500);
              echo json_encode(["error" => "Error al eliminar usuario"]);
          }
          break;
    

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
