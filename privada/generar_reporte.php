<?php
// Conexión a la base de datos e inicio de sesión
include '../db_conn.php';
require_once("login.php");
// Librería de PhpSpreadsheet desde la CDN

use PhpSpreadsheet\src\PhpSpreadsheet;
use PhpSpreadsheet\src\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['generarReporte'])) {

    // Obtener los datos del formulario
    $actividad = $_POST['actividadExcel'];
    $fechaInicio = $_POST['inicioExcel'];
    $fechaFin = $_POST['finExcel'];

    // Validar si se seleccionó una actividad
    if ($actividad == 0) {
        echo "Por favor, selecciona una actividad.";
        exit;
    }

    // Crear el objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Configurar el encabezado
    $sheet->setCellValue('A1', 'Actividad');
    $sheet->setCellValue('B1', 'Fecha de inicio');
    $sheet->setCellValue('C1', 'Fecha de fin');

    // Realizar la consulta y obtener los datos de las tareas
    $sql = "SELECT actividad, fecha_inicio, fecha_fin FROM tareas WHERE actividad = '$actividad'";

    // Añadir condiciones adicionales si se seleccionaron fechas
    if (!empty($fechaInicio)) {
        $sql .= " AND fecha_inicio >= '$fechaInicio'";
    }

    if (!empty($fechaFin)) {
        $sql .= " AND fecha_fin <= '$fechaFin'";
    }

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        // Iterar sobre los resultados y añadirlos al archivo Excel
        $rowNumber = 2;
        while ($row = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $rowNumber, $row['actividad']);
            $sheet->setCellValue('B' . $rowNumber, $row['fecha_inicio']);
            $sheet->setCellValue('C' . $rowNumber, $row['fecha_fin']);
            $rowNumber++;
        }

        // Crear el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'reporte_excel.xlsx';
        $writer->save($fileName);

        // Descargar el archivo Excel al navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $file = fopen($fileName, 'rb');
        fpassthru($file);
        fclose($file);

        // Eliminar el archivo temporal
        unlink($fileName);
    } else {
        echo "No se encontraron tareas que cumplan los criterios de búsqueda.";
    }
}


?>