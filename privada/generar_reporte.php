<?php
// Conexión a la base de datos e inicio de sesión
include '../db_conn.php';
require_once("login.php");
// Librería de PhpSpreadsheet desde la CDN

if (isset($_POST['generarReporte'])) {
    if ($saml->isAuthenticated()) {
        $atributos = $saml->getAttributes();
    }
    
    //Obtener información número de cuenta del usuario
    $nocuenta = $atributos["uCuenta"][0];

    // Obtener los datos del formulario
    $actividad = $_POST['actividadExcel'];
    $fechaInicio = $_POST['inicioExcel'];
    $fechaFin = $_POST['finExcel'];

    // Validar si se relleno todos los campos 
    if ($actividad == 0 && empty($fechaInicio) && empty($fechaFin)) {
        echo "Favor de rellenar todos los campos";
        exit;
    } 

    // Realizar la consulta y obtener los datos de las tareas
    $sql = "SELECT * FROM tareas WHERE num_cuenta = '$nocuenta' AND actividad = '$actividad' AND fecha > '$fechaInicio' AND fecha < '$fechaFin'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {

        // Iterar resultados        
        while ($row = $result->fetch_assoc()) {
            //  Crear registro

        }


        
    } else {
        echo "No se encontraron tareas que cumplan los criterios de búsqueda.";
    }

    header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
    header("Content-Disposition: attachment; filename='Reporte de usuario".$nocuenta.".xls'");
}


?>