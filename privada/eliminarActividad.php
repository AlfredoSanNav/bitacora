<?php 
 //Se asegura que el usuario este autenticado
 include '../db_conn.php';
 require_once("login.php"); 

 // Verificar si se envió el ID del registro a eliminar
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Consulta para eliminar el registro de la tabla
    $query = "DELETE FROM ACTIVIDADES WHERE id_usuario = $id";
    $result = mysqli_query($conn, $query);


    if ($result) {
        echo "Registro eliminado correctamente";
        header("Location: panel.php");
    } else {
        echo "Error al eliminar el registro: " . mysqli_error($conn);
    }
}

exit;
?>