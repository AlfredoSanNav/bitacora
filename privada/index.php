<?php
 //Se asegura que el usuario este autenticado
 include '../db_conn.php';
 require_once("login.php"); 

//Registro de usuario

  if ($saml->isAuthenticated()) {
    $atributos = $saml->getAttributes();
}



//Obtener información del portal
$nocuenta = $atributos["uCuenta"][0];
$nombre = $atributos["sn"][0];
$apellido = $atributos["givenName"][0];
$email = $atributos["uCorreo"][0];

//Hace la consulta para saber si el correo ya está registrado
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows >= 1) {
    // El usuario está registrado, no hace nada.
  } else {

    // El usuario no está registrado así que guarda la información de este.
    $sql = "INSERT INTO USUARIOS (id, num_cuenta, nombre, apellidos, email) VALUES (NULL,'$nocuenta', '$nombre', '$givenName', '$email')";

    if ($conn->query($sql) === TRUE) {
        //echo "Usuario registrado exitosamente";
    } else {
        //echo "Error al registrar al usuario: " . $conn->error;
    }

  };

  // Botón para añadir tarea

  if (isset($_POST['submit'])) {
    $atributos = $saml->getAttributes();
    $noCuenta = $atributos["uCuenta"][0];

    $tarea = $_POST['tarea'];
    $actividad = $_POST['actividad'];
    $fecha = $_POST['fecha'];
    $archivo = $_FILES['archivo']['tmp_name'];
    $nombreArchivo = $_FILES['archivo']['name'];
    $contenido_archivo = base64_encode(file_get_contents($archivo));

      // Validación de campo vacío
      if (empty($tarea)) {
        echo '<script>alert("El campo de tarea no puede estar vacío.");</script>';
        
    } else {
     $sql = "INSERT INTO TAREAS (id, num_cuenta, descripcion, actividad, fecha, archivo, nombre_archivo)
              VALUES (NULL, '$noCuenta', '$tarea', '$actividad', '$fecha', '$contenido_archivo', '$nombreArchivo')";
  
    $result = mysqli_query($conn, $sql);
  
    if ($result) {
      header("Location: index.php");
    } else {
      echo "Error al crear registro: " . mysqli_error($conn);
    }
    }

   
  }

?>    



<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de bitácora</title>

    

    <link rel="icon" type="image/x-icon" href="../img/Escudo_UdeC.png">
    <link href="https://www.ucol.mx/cms/apps/assets/css/apps.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/phpoffice/phpspreadsheet@1.18.0/dist/phpspreadsheet.min.js"></script>


</head>
<body>

    <div class="p-3 mb-2" style="background-color: #5c8c2c"></div>
    <div class="border-bottom">
        <div class="logo mx-auto p-2" style="width: 85%;">
            <a href="https://www.ucol.mx/"><img src=".././img/Escudo_UdeC.png" alt="Escudo de la Universidad de Colima"
                    height="6%"></a>
            <a href="https://www.ucol.mx/"><img src=".././img/Nombre_UdeC.png" alt="Universidad de Colima"
                    height="5%"></a>
        </div>
        <header class="mx-auto p-2" style="width: 75%;">Sistema de bitácora</header>
    </div>
    <br>
    <nav class="border mx-auto p-2 text-end" style="width: 75%;"><?php echo $nombre." ".$apellido;?><a href='logout.php'>Cerrar sesión</a></nav>
    <br>
    <div class="mx-auto p-2" style="width: 75%;">

        <a class="btn btn-light" href="./index.php">Bitácora</a>
        <a class="btn btn-light" href="./panel.php">Panel</a>

    </div>

    
    <!--- Formulario de bitacora --->
    <div id="bitacora" class="card mx-auto p-2" style="width: 75%;background-color: F5F5F5">
    <form method="POST" enctype="multipart/form-data">
        <div>
            <div><label for="tarea">Tarea a registrar</label></div>
            <textarea id="tarea" name="tarea"></textarea>
        </div>
         <br>
        <div>
            <label for="tipoActividad">Actividad</label>
            <select name="actividad" id="actividad">
                <option value="0">Privada</option>
                <!--- Llama a las opciones registradas en la base de datos --->
                <?php 
                include '../db_conn.php';

                $atributos = $saml->getAttributes();
                $nocuenta = $atributos["uCuenta"][0];

                $sql = "SELECT * FROM ACTIVIDADES WHERE num_cuenta = '$nocuenta'";
                $result = $conn->query($sql);


                if ($result->num_rows > 0) {
                    // Iterar sobre los resultados y generar las filas de la tabla
                    while ($row = $result->fetch_assoc()) {
                      
                        echo '<option value="'.$row['id_usuario'].'">' . $row['nombre'] . '</option>';
                        
                    }
                
                } 
                ?>

            </select>
            <label>Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>">


        </div>
        <br>
        <input type="file" id="archivo" name="archivo">
        <input type="submit" name="submit" value="Guardar tarea" class="btn btn-success">
    </form>
</div>
<br><br>
    
    <!--- Sección de filtros ---> 
    <div class="mx-auto p-2" style="width: 75%;">
        <form action="" method="post" >
            <fieldset>
                <center>
                    <legend for="actividadFiltro" style="font-size: 125%">Filtrar tareas</legend><br>
                </center>
                
                <label for="actividadFiltro">Actividad: </label>
                <select name="actividadFiltro" id="actividadFiltro">
                    <option value="0">- Seleccione la actividad -</option>
                    <!--- Llama a las opciones registradas en la base de datos --->
                    <?php 
                    include '../db_conn.php';

                    $atributos = $saml->getAttributes();
                    $nocuenta = $atributos["uCuenta"][0];

                    $sql = "SELECT * FROM ACTIVIDADES WHERE num_cuenta = '$nocuenta'";
                    $result = $conn->query($sql);


                    if ($result->num_rows > 0) {
                        // Iterar sobre los resultados y generar las filas de la tabla
                        while ($row = $result->fetch_assoc()) {
                        
                            echo '<option value="'.$row['id_usuario'].'">' . $row['nombre'] . '</option>';
                            
                        }
                    
                    } 
                    ?>
                </select>
                <br><br>
                <div>
                    <label for="fechaInicio">Fecha inicio</label>
                    <input type="date" name="fechaInicio">
                </div>
                <div>
                    <label for="fechaFin">Fecha fin</label>
                    <input type="date" name="fechaFin">
                </div>
                <br>
                <div class="text-end">
                    <button class="btn btn-danger" name="btnQuitarFiltro" id="btnQuitarFiltro">Deshacer filtrado</button>
                    <button class="btn btn-success" name="btnFiltrar" id="btnFiltrar">Filtrar</button>
                </div>
                
            </fieldset>
        
        
        
        <br><br>

        </form>

    </div>
    

    <!--- Sección para mostrar tareas -->
    <div  class="mx-auto p-2" style="width: 75%;">
        <center><h2>Tareas</h2></center>
        <br>
        <?php 
        include '../db_conn.php';

        $atributos = $saml->getAttributes();
        $nocuenta = $atributos["uCuenta"][0];
        $nombre = $atributos["sn"][0];
        $apellido = $atributos["givenName"][0];
        $email = $atributos["uCorreo"][0];

        $sql = "SELECT * FROM TAREAS WHERE num_cuenta = '$nocuenta'";

        // Pruebas para el botón de filtros ------------------->>
        if(isset($_POST['btnFiltrar'])){
            $actividadFiltro = $_POST['actividadFiltro'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];

            

            // Verificar si se seleccionó un filtro de actividad
            if ($actividadFiltro > 0) {
                // Agregar condición de actividad a la consulta
                $sql .= " AND actividad = '$actividadFiltro'";
            }

            // Verificar si se seleccionó un filtro de fecha de inicio
            if (!empty($fechaInicio)) {
                // Agregar condición de fecha de inicio a la consulta
                $sql .= " AND fecha >= '$fechaInicio'";
            }

            // Verificar si se seleccionó un filtro de fecha de fin
            if (!empty($fechaFin)) {
                // Agregar condición de fecha de fin a la consulta
                $sql .= " AND fecha <= '$fechaFin'";
            }

        }
        if(isset($_POST['btnQuitarFiltro'])){
            $sql = "SELECT * FROM TAREAS WHERE num_cuenta = '$nocuenta'";
        }
        

        
        $result = $conn->query($sql);
        
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Iterar sobre los resultados y generar las filas de la tabla
            while ($row = $result->fetch_assoc()) {
                //Obtiene los valores de la actividad añadida
                $idActividad = $row['actividad'];
                $valoresAct = "SELECT * FROM ACTIVIDADES WHERE id_usuario = '$idActividad'";
                $resultValores = $conn->query($valoresAct);
                if ($resultValores->num_rows > 0) {
                    // Obtener el primer resultado de la subconsulta
                    $rowActividad = $resultValores->fetch_assoc();
                    $nombreActividad = $rowActividad['nombre'];
                }
    
                $date = new DateTime($row[fecha]);
                $dateText = date_format($date, 'l, F d, Y');
                echo '
                <article class="card mx-auto p-2" >
                    <br>
                    <header class=""><h5>'.$nombre." ".$apellido." ".'</h5></header>
                    ';
                if($row['actividad']>0){
                    echo '<span class="cursiva"><a href="#" >'.$nombreActividad.'</a> |
                    <br><br>';
                }
                echo '
                <span class="pull-right"><em class="cursiva">'.$dateText.'</em></span>
                <p>'.$row[descripcion].'</p>';
                    if (!empty($row['archivo'])) {
                        // La celda contiene un archivo y el archivo existe en la ubicación especificada
                         echo   '<p class="archivo pull-right"><a id="8671" href="descargar_archivo.php?id='.$row[id].'">Descargar</a></p><div class="clearfix"></div>';
                      } 
				
                echo '
                    </article>
                    <br>
                ';
                
            }
        
            echo "<br><br><br>";
        } 
        ?>
    </div>

<script type="text/javascript" async="" src="https://www.ucol.mx/cms/apps/lib/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
</body>
