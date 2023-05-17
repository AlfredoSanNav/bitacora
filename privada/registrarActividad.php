<?php
include '../db_conn.php'; 

// Recibimos los datos del formulario
$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$descripcion = $_POST['descripcion'];

// Validamos los datos recibidos (ejemplo)
if(empty($nombre) || empty($fecha) || empty($descripcion)) {
    echo "Por favor complete todos los campos";
    exit;
}


// Insertamos los datos en la base de datos
$query = "INSERT INTO actividades (nombre, fecha, descripcion) VALUES ('$nombre', '$fecha', '$descripcion')";

$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    echo "La actividad ha sido registrada correctamente";
} else {
    echo "Error al registrar la actividad: " . mysqli_error($conexion);
}

?>