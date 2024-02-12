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

    // Verificar si se proporcionó el correo electrónico
    if (!empty($data['email'])) {
        // Eliminar suscriptor de la base de datos por su correo electrónico
        $stmt = $conn->prepare("DELETE FROM suscriptores WHERE email = :email");
        $stmt->bindParam(':email', $data['email']);
        
        if ($stmt->execute()) {
            // Configurar el encabezado para indicar que la respuesta es JSON
            header('Content-Type: application/json');
            echo json_encode(array("message" => "Suscriptor eliminado correctamente"));
        } else {
            // Configurar el encabezado para indicar que la respuesta es JSON
            header('Content-Type: application/json');
            echo json_encode(array("message" => "Error al eliminar suscriptor"));
        }
    } else {
        // Configurar el encabezado para indicar que la respuesta es JSON
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Se requiere el correo electrónico para eliminar un suscriptor"));
    }
}
?>
