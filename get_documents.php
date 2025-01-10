<?php
$host = '/cloudsql/calidad-447308:us-central1:documentmanagement';
$user = 'root';       // Usuario configurado
$password = 'n0m3l03101'; // Contraseña
$dbname = 'documentmanagement';    // Nombre de la base de datos

$conn = new mysqli($host, $user, $password, $dbname);

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
