<?php 
 //Se asegura que el usuario este autenticado
 include '../db_conn.php';
 require_once("login.php"); 

 // Verificar si se envió el ID del registro a eliminar
if (isset($_POST['id'])) {
$id = $_POST['id'];
$sql = "SELECT * FROM ACTIVIDADES WHERE id_usuario = $id";
$resultado = $conn->query($sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $tipo = $fila['tipo'];

    //Consulta si el registro es una actividad o subactividad
        if($tipo == 0){
            $query = "DELETE FROM TAREAS WHERE actividad = $id";
            $result = mysqli_query($conn, $query);
            $query = "DELETE FROM ACTIVIDADES WHERE actividad_asociada = $id";
            $result2 = mysqli_query($conn, $query);
            $query = "DELETE FROM ACTIVIDADES WHERE id_usuario = $id";
            $result3 = mysqli_query($conn, $query);
            if ($result) {
                    echo "Registro eliminado correctamente";
                    header("Location: panel.php");
                } else {
                    echo "Error al eliminar el registro: " . mysqli_error($conn);
                }
        } else if ($tipo == 1){
            $query = "DELETE FROM TAREAS WHERE actividad = $id";
            $result = mysqli_query($conn, $query);
            $query = "DELETE FROM ACTIVIDADES WHERE id_usuario = $id";
            $result2 = mysqli_query($conn, $query);
            if ($result) {
                    echo "Registro eliminado correctamente";
                    header("Location: panel.php");
                } else {
                    echo "Error al eliminar el registro: " . mysqli_error($conn);
                }

        }



    
} else {
    echo "No se encontraron resultados";
}

    


    
}

exit;
?>