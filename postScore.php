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
    $sql = "SELECT * FROM player";
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

    // Cerrar la conexión
    $conn->close();

    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Manejar otros tipos de solicitudes aquí si es necesario
    http_response_code(405); // Método no permitido
    echo json_encode(array("message" => "Método no permitido"));
}
?>
