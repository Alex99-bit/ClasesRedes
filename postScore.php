<?php
// Encabezados necesarios para hacer las solicitudes
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Conexión a la base de datos
require('conexion.php');

// Manejo de solicitudes GET y POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Consulta para seleccionar todos los registros de la tabla player
    $sql = "SELECT * FROM `player` ORDER BY `player`.`playerExp` DESC";
    $result = $conn->query($sql);

    // Crear un array para almacenar los datos
    $data = array();

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Agregar fila al array
            $data[] = $row;
        }
    }

    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si se proporcionaron los datos necesarios
    if(isset($data['playerName']) && isset($data['playerExp']) && isset($data['playerEdad'])) {
        // Obtener los valores del jugador
        $playerName = $data['playerName'];
        $playerExp = $data['playerExp'];
        $playerEdad = $data['playerEdad'];

        // Insertar el nuevo jugador en la base de datos
        $sql = "INSERT INTO player (playerName, playerExp, playerEdad) VALUES ('$playerName', '$playerExp', '$playerEdad')";
        if ($conn->query($sql) === TRUE) {
            $response = array("message" => "Nuevo jugador insertado correctamente");
            echo json_encode($response);
        } else {
            $response = array("message" => "Error al insertar el nuevo jugador: " . $conn->error);
            http_response_code(500); // Error del servidor
            echo json_encode($response);
        }
    } else {
        $response = array("message" => "Faltan datos requeridos para insertar el nuevo jugador");
        http_response_code(400); // Solicitud incorrecta
        echo json_encode($response);
    }
} else {
    // Manejar otros tipos de solicitudes aquí si es necesario
    http_response_code(405); // Método no permitido
    echo json_encode(array("message" => "Método no permitido"));
}

// Cerrar la conexión
    $conn->close();
?>
