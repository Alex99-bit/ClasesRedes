<?php
// Encabezados necesarios para hacer las solicitudes
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require("conexion.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}

// Manejar solicitud GET para obtener todos los suscriptores
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM `suscriptores` ORDER BY `suscriptores`.`name` ASC");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Configurar el encabezado para indicar que la respuesta es JSON
    header('Content-Type: application/json');
    echo json_encode($result);
}

// Manejar solicitud POST para añadir un nuevo suscriptor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si se proporcionaron todos los datos necesarios y que no están vacíos
    if (!empty($data['name']) && !empty($data['email']) && !empty($data['nacimiento'])) {
        // Verificar si el email ya existe en la base de datos
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `suscriptores` WHERE `email` = :email");
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // El email ya existe, devolver un mensaje de error
            header('Content-Type: application/json');
            echo json_encode(array("message" => "El email ya está registrado"));
        } else {
            // Convertir la fecha a un objeto DateTime con la zona horaria correcta
            $nacimiento = new DateTime($data['nacimiento'], new DateTimeZone('America/Mexico_City'));
            // Obtener la fecha formateada para MySQL
            $nacimiento_mysql = $nacimiento->format('Y-m-d');

            // Insertar nuevo suscriptor en la base de datos
            $stmt = $conn->prepare("INSERT INTO suscriptores (name, email, nacimiento) VALUES (:name, :email, :nacimiento)");
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':nacimiento', $nacimiento_mysql);
            
            if ($stmt->execute()) {
                // Configurar el encabezado para indicar que la respuesta es JSON
                header('Content-Type: application/json');
                echo json_encode(array("message" => "Suscriptor añadido correctamente"));
            } else {
                // Configurar el encabezado para indicar que la respuesta es JSON
                header('Content-Type: application/json');
                echo json_encode(array("message" => "Error al añadir suscriptor"));
            }
        }
    } else {
        // Configurar el encabezado para indicar que la respuesta es JSON
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Se requieren name, email y nacimiento para añadir un nuevo suscriptor"));
    }
}
?>
