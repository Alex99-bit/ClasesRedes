<?php

require('conexion.php');

// Configurar encabezados CORS para permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Verificar el método de solicitud
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Obtener datos
        if (isset($_GET['id'])) {
            // Obtener un registro por ID
            $id = $_GET['id'];
            $result = $conn->query("SELECT * FROM players WHERE id = $id");
        } else {
            // Obtener todos los registros
            $result = $conn->query("SELECT * FROM players");
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    case 'POST':
        // Crear un nuevo registro
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $score = $data['score'];
        $age = $data['age'];
        $conn->query("INSERT INTO players (name, score, age) VALUES ('$name', $score, $age)");
        echo json_encode(['message' => 'Registro creado con éxito']);
        break;

    case 'PUT':
        // Actualizar un registro por ID
        $id = $_GET['id'];
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $score = $data['score'];
        $age = $data['age'];
        $conn->query("UPDATE players SET name='$name', score=$score, age=$age WHERE id=$id");
        echo json_encode(['message' => 'Registro actualizado con éxito']);
        break;

    case 'DELETE':
        // Eliminar un registro por ID
        $id = $_GET['id'];
        $conn->query("DELETE FROM players WHERE id=$id");
        echo json_encode(['message' => 'Registro eliminado con éxito']);
        break;

    default:
        // Método no permitido
        header("HTTP/1.1 405 Method Not Allowed");
        echo json_encode(['error' => 'Método no permitido']);
        break;
}

// Cerrar la conexión a la base de datos
$conn->close();
