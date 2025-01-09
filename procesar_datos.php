<?php
// Configuración de conexión a la base de datos
$host = "localhost";
$dbname = "comercio_internacional";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del formulario
    $docType = $_POST['doc_type'];
    $docDate = $_POST['doc_date'];
    $docNumber = $_POST['doc_number'];
    $prodType = $_POST['prod_type'];
    $originCountry = $_POST['origin_country'];
    $prodQty = $_POST['prod_qty'];

    // Insertar en la tabla DOCUMENTOS
    $sqlDoc = "INSERT INTO DOCUMENTOS (tipo_documento, estado, fecha_validacion) 
               VALUES (:docType, 'pendiente', NULL)";
    $stmt = $conn->prepare($sqlDoc);
    $stmt->bindParam(':docType', $docType);
    $stmt->execute();
    $idDocumento = $conn->lastInsertId();

    if ($docType === "export") {
        // Insertar en EXPORTACIONES
        $sqlExport = "INSERT INTO EXPORTACIONES (numero_pedido, fecha_envio, destino, id_documento) 
                      VALUES (:docNumber, :docDate, :originCountry, :idDocumento)";
        $stmtExport = $conn->prepare($sqlExport);
        $stmtExport->bindParam(':docNumber', $docNumber);
        $stmtExport->bindParam(':docDate', $docDate);
        $stmtExport->bindParam(':originCountry', $originCountry);
        $stmtExport->bindParam(':idDocumento', $idDocumento);
        $stmtExport->execute();
    } else {
        // Insertar en IMPORTACIONES
        $sqlImport = "INSERT INTO IMPORTACIONES (numero_factura, fecha_recepcion, origen, id_documento) 
                      VALUES (:docNumber, :docDate, :originCountry, :idDocumento)";
        $stmtImport = $conn->prepare($sqlImport);
        $stmtImport->bindParam(':docNumber', $docNumber);
        $stmtImport->bindParam(':docDate', $docDate);
        $stmtImport->bindParam(':originCountry', $originCountry);
        $stmtImport->bindParam(':idDocumento', $idDocumento);
        $stmtImport->execute();
    }

    echo "Datos insertados correctamente.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>