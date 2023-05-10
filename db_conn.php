<?php
// Establecer conexión con la base de datos
$host = "localhost";
$username = "a_20167255";
$password = "TGF3KGNJLjK";
$dbname = "a_20167255";

// Crear conexión
$conn = mysqli_connect($host, $username, $password, $dbname);
// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
} else {
    //echo "Conexión exitosa";
}
?>