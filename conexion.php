<?php
    $servername = "localhost"; // Puede ser "localhost" si estás utilizando XAMPP en tu máquina
    $username = "id19429032_alexco"; // Nombre de usuario de la base de datos en XAMPP (por defecto es "root")
    $password = "*Alexco99*"; // Contraseña de la base de datos en XAMPP (por defecto es "")
    $database = "id19429032_redesbd"; // Nombre de la base de datos

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    //echo "Conexión exitosa";
?>
