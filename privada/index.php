<?php
 //Se asegura que el usuario este autenticado
 include '../db_conn.php';
 require_once("login.php"); 
// $atributos = $saml->getAttributes(); //Obtiene sus atributos
 //echo "Bienvenido ";
//Imprime los atributos
// foreach ($atributos as $clave => $valor) {
//  echo "<br><b>".$clave."</b>:".$valor[0];
//}
// echo "<br><br>Usted se encuentra en la secci&oacute;n privada de esta aplicaci&oacute;n<br><a href='../'>Ir a secci&oacute;n p&uacute;blica</a><br><a href='logout.php'>[Cerrar sesi&oacute;n]</a>";
if (isset($_POST['submit'])) {
    $atributos = $saml->getAttributes();
    $variable_a_buscar = $atributos["uCorreo"][0];
    $sql = "SELECT id FROM USUARIOS WHERE email = '$variable_a_buscar'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
  
    $id_usr = $row['id'];
    $tarea = $_POST['tarea'];
    $actividad = $_POST['actividades'];
    $fecha = $_POST['fechact'];
    $archivos = $_FILES['archivo']['name'];
  
    $sql = "INSERT INTO TAREAS (id, id_usr, tarea, act, fecha, archivos)
              VALUES (NULL, '$id_usr', '$tarea', '$actividad', '$fecha', '$archivos')";
  
    $result = mysqli_query($conn, $sql);
  
    if ($result) {
      header("Location: index.php?msg=Registro creado exitosamente");
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

<?php include 'funciones.php'; ?>
<body onload="registrarUsuario()">

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
    <nav class="border mx-auto p-2 text-end" style="width: 75%;"><a href='logout.php'>[Cerrar sesi&oacute;n]</a></nav>
    <br><br>
    <div class="mx-auto p-2" style="width: 75%;">
        <button id="mostrarBitacora">Bitácora</button>
        <button id="mostrarPanel">Panel</button>
    </div>
    <br>

    
    
    <div id="bitacora" class="mx-auto p-2" style="width: 75%;">
        <div>
            <div><label for="">Tarea a registrar</label></div>
            
            <textarea id="tarea" name="tarea"></textarea>
        </div>
        <br>
        <div>
            <label for="tipoActividad">Actividad</label>
            <select name="actividades" id="actividades">
                <option value="0">Privada</option>
            </select>
            <label>Fecha</label>
            <input type="date" id="fechact" name="fechact">

            
        </div>
        <br>
        <input type="file" id="archivo" name="archivo">
        <input type="submit" name="guardar" value="Guardar tarea">
        
        <!--- Pendiente: Mostrar las tareas y con sus respectivos filtros-->

        <script src="registrarUsuario.php"></script>
        <script type="text/javascript" async="" src="https://www.ucol.mx/cms/apps/lib/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
    </div>

    
</body>