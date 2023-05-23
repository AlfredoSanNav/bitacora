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
    $archivo = $_FILES['archivo']['name'];
    
    // Test para añadir archivo (pendiente jeje)

    // Fin del test
    $sql = "INSERT INTO TAREAS (id, num_cuenta, descripcion, actividad, fecha, archivo)
              VALUES (NULL, '$noCuenta', '$tarea', '$actividad', '$fecha', '$archivo')";
  
    $result = mysqli_query($conn, $sql);
  
    if ($result) {
      header("Location: index.php");
    } else {
      echo "Error al crear registro: " . mysqli_error($conn);
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
<br>

    <!--- Pendiente: Mostrar las tareas y con sus respectivos filtros-->
    <div  class="mx-auto p-2" style="width: 75%;">
        <center><h2>Tareas</h2></center>
        <?php 
        include '../db_conn.php';

        $atributos = $saml->getAttributes();
        $nocuenta = $atributos["uCuenta"][0];
        $nombre = $atributos["sn"][0];
        $apellido = $atributos["givenName"][0];
        $email = $atributos["uCorreo"][0];

        $sql = "SELECT * FROM TAREAS WHERE num_cuenta = '$nocuenta'";
        $result = $conn->query($sql);
        
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Iterar sobre los resultados y generar las filas de la tabla
            while ($row = $result->fetch_assoc()) {
                $date = new DateTime($row[fecha]);
                $dateText = date_format($date, 'l, F d, Y');
                echo '
                <article class="well act186 actividadArticle">
                    <header class="pull-left"><h5>'.$nombre." ".$apellido.'</h5></header>
					<span class="pull-right"><em class="cursiva">'.$dateText.'</em></span>
                    <span class="pull-right cursiva"><a href="#" class="actClic" nact="186">Act2</a>|</span><div class="clearer"></div>
				<p>Tarea prueba</p><p class="archivo pull-right"><a id="8671" href="../descargar/228/8671/">Descargar</a></p><div class="clearfix"></div></article>
                ';
                
            }
        
            echo "</table>";
        } 
        ?>
        ?>
    </div>

<script type="text/javascript" async="" src="https://www.ucol.mx/cms/apps/lib/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
</body>
