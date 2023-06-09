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
    <link href="styles.css" rel="stylesheet">
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
        <a class="btn btn-success" style="background-color: #5c8c2c; color:#FFFFFF;" href="./panel.php">Panel</a>
    </div>


    <!--- Lista de actividades --->
    <div class="table-responsive mx-auto p-2" style="width: 75%">
        <table class="table table-hover text-center" style="background-color: F5F5F5;">
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Agregar Sub actividad</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>

            <!--- Agrega el cuerpo de la tabla --->
            <tbody class="activity" id="listaPanel">
                <?php
                include '../db_conn.php';

                $atributos = $saml->getAttributes();
                $nocuenta = $atributos["uCuenta"][0];

                $sql = "SELECT * FROM ACTIVIDADES WHERE num_cuenta = '$nocuenta' AND tipo = 0";
                $result = $conn->query($sql);
                
                // Verificar si hay resultados
                if ($result->num_rows > 0) {
                    // Iterar sobre los resultados y generar las filas de la tabla
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo '<td><div><a class="btn btn-outline-success" data-id="'.$row['id_usuario'].'" href="./agregaPanelSubact.php?id='.$row['id_usuario'].'">Agregar subactividad</a></div></td>';                
                        echo '<td><div><a class="btn btn-outline-success" href="verActividad.php?id='.$row['id_usuario'].' ">Ver</a></div></td>';
                        echo '<td><div><a class="btn btn-outline-primary" href="editarActividad.php?id='.$row['id_usuario'].' ">Editar</a></div></td>';
                        echo '
                            <td>
                                <form action="eliminarActividad.php" method="post">
                                    <input type="hidden" name="id" value="'.$row['id_usuario'].'">
                                    <button class="btn btn-danger" type="submit" onclick="return confirm(\'Si eliminas esta actividad tambien se eliminaran sus subactividades y tareas asociadas. ¿Deseas continuar?\');">Eliminar</button>
                                </form>
                            </td>';

                        // Hace la consulta para traer las subactividades
                        $idActividad = $row['id_usuario'];
                        $subsql = "SELECT * FROM ACTIVIDADES WHERE num_cuenta='$nocuenta' AND tipo = 1 AND actividad_asociada = '$idActividad'";
                        $subresult = $conn->query($subsql);
                        if ($subresult->num_rows > 0) {
                            while ($row = $subresult->fetch_assoc()) {
                                echo "<tr style='background-color: #e7ffc2;'>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                echo "<td>Esto es una subactividad</td>";
                                echo '<td><div><a class="btn btn-outline-success" href="verActividad.php?id='.$row['id_usuario'].' ">Ver</a></div></td>';
                                echo '<td><div><a class="btn btn-outline-primary" href="editarActividad.php?id='.$row['id_usuario'].' ">Editar</a></div></td>';
                                echo '<td>
                                            <form action="eliminarActividad.php" method="post">
                                                <input type="hidden" name="id" value="'.$row['id_usuario'].'">
                                                <button class="btn btn-danger" type="submit" onclick="return confirm(\'Si eliminas esta subactividad tambien se eliminaran las tareas asociadas. ¿Deseas continuar?\');">Eliminar</button>
                                            </form>
                                        </td>';
                            }
                        }

                    }
                
                    echo "</table>";
                } else 
                ?>
            </tbody>
        </table>
        
        <a class="btn btn-success" href="./agregaPanelAct.php">Agregar nueva actividad</a>
    </div>

    <!--- Formulario para reporte de excel--->

     <div class="mx-auto p-2" style="width: 75%;">
        <form action="generar_reporte.php" method="post" >
            <fieldset>
                <center>
                    <legend for="reporteExcel" style="font-size: 200%">Reporte Excel</legend><br>
                </center>
                <br>
                <label for="actividadExcel">Actividad: </label>
                <select name="actividadExcel" id="actividadExcel">
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
                    <label for="inicioExcel">Fecha inicio</label>
                    <input type="date" name="inicioExcel">
                </div><br>
                <div>
                    <label for="finExcel">Fecha fin</label>
                    <input type="date" name="finExcel">
                </div>
                <br>
                <div class="text-end">
                    <button class="btn btn-success" name="generarReporte">Generar reporte excel</button>
                </div>
                
            </fieldset>
        
        
        
        <br><br>

        </form>

    </div>

    <script type="text/javascript" async="" src="https://www.ucol.mx/cms/apps/lib/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
</div>
<br><br><br>
</body>
