<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 1</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles/github.css"> <!-- Asegúrate de tener el archivo github.css en la carpeta styles -->
    <script src="highlight.js"></script> <!-- Asegúrate de tener el archivo highlight.js en el mismo directorio -->
    <script>hljs.initHighlightingOnLoad();</script>
</head>
<body>
    <div class="container">
        <h2>Tabla players</h2>
        <?php 
            require('conexion.php');

            // Consulta para seleccionar todos los registros de la tabla player
            $sql = "SELECT * FROM player";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Imprimir encabezados de la tabla con estilo neon
                echo "<table class='neon-border'><tr><th class='neon-text'>ID</th><th class='neon-text'>Nombre</th><th class='neon-text'>Puntos</th><th class='neon-text'>Edad</th></tr>";

                // Crear un array para almacenar los datos
                $data = array();

                // Imprimir datos de cada fila con estilo neon y agregar al array
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["playerId"]. "</td><td>" . $row["playerName"]. "</td><td>" . $row["playerExp"]. "</td><td>" . $row["playerEdad"] . "</td></tr>";

                    // Agregar fila al array
                    $data[] = $row;
                }

                // Cerrar la tabla
                echo "</table>";

                // Convertir el array a formato JSON
                $json_data = json_encode($data);

                // Guardar el JSON en un archivo
                file_put_contents('data.json', $json_data);
            } else {
                echo "<p class='neon-text'>No se encontraron resultados</p>";
            }

            // Cerrar la conexión
            $conn->close();
        ?>

        <h2>Datos en formato JSON</h2>
        <pre><code id="json-data"></code></pre>

        <h2>Tabla desde JSON</h2>
        <div id="json-table"></div>

        <script>
            // Cargar el archivo JSON usando JavaScript
            fetch('data.json')
                .then(response => response.json())
                .then(data => {
                    // Crear un nuevo elemento pre para el JSON
                    const jsonElement = document.createElement('pre');
                    // Utilizar la librería para formatear el JSON
                    jsonElement.innerText = JSON.stringify(data, null, 2);
                    // Agregar el elemento al div
                    document.getElementById('json-data').appendChild(jsonElement);

                    // Crear la tabla dinámicamente
                    const table = document.createElement('table');
                    table.className = 'neon-border';

                    // Crear la fila de encabezados
                    const headerRow = document.createElement('tr');
                    Object.keys(data[0]).forEach(key => {
                        const th = document.createElement('th');
                        th.className = 'neon-text';
                        th.textContent = key;
                        headerRow.appendChild(th);
                    });
                    table.appendChild(headerRow);

                    // Crear las filas de datos
                    data.forEach(rowData => {
                        const tr = document.createElement('tr');
                        Object.values(rowData).forEach(value => {
                            const td = document.createElement('td');
                            td.textContent = value;
                            tr.appendChild(td);
                        });
                        table.appendChild(tr);
                    });

                    // Agregar la tabla al div
                    document.getElementById('json-table').appendChild(table);
                })
                .catch(error => console.error('Error al cargar el archivo JSON:', error));
        </script>
    </div>
</body>
</html>
