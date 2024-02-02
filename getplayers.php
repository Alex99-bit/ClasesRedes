<?php
$servername = "";   //localhost
$username = "tusuariodedatabase";
$password = "contraseñadedatabase";
$dbname = "nombrededatabase";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your SQL query to select data from a table
$sql = "SELECT * FROM Players";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
   
    // Mostrar data en en ciclo de filas
  //  while ($row = $result->fetch_assoc()) {
     //   echo "ID: " . $row['id'] . " | Name: " . $row['name'] . " | HIghscore: " . $row['highscore'] . "<br>";
  //  }
    
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
   
    // Output the data as JSON
    //echo json_encode($rows);
    
    

    // Free the result set
    $result->free();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>