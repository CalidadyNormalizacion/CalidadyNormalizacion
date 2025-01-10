<?php

$conn = new mysqli(
    '127.0.0.1',
    'root',                  // Usuario de la base de datos
    'n0m3l03101',         // Contraseña
    'documentmanagement',       // Nombre de la base de datos
    null,
    '/cloudsql/calidad-447308:us-central1:documentmanagement'
);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM documents";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
