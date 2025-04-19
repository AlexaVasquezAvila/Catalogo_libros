<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode(["mensaje" => "POST recibido"]);
} else {
    echo json_encode(["mensaje" => "GET recibido"]);
}
?>
