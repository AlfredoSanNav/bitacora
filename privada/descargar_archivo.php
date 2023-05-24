<?php
// Conexión a la base de datos
include '../db_conn.php';
require_once("login.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT archivo, nombre_archivo FROM TAREAS WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($archivo, $nombre_archivo);

    if ($stmt->fetch()) {
        // Decodifica la cadena base64 para obtener el contenido del archivo
        $contenido_archivo = base64_decode($archivo);

        // Descargar el archivo
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . strlen($contenido_archivo));
        header("Content-Disposition: attachment; filename=\"" . $nombre_archivo . "\"");

        echo $contenido_archivo;
        exit();
    } else {
        // Mostrar un mensaje de error o redireccionar si no se encuentra el archivo en la base de datos
        exit("Archivo no encontrado");
    }

    $stmt->close();
}
?>