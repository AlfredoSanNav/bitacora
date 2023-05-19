<?php
 //Se asegura que el usuario este autenticado
 include '../db_conn.php';
 include './registrarUsuario.php';
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
    <nav class="border mx-auto p-2 text-end" style="width: 75%;"><a href='logout.php'>[Cerrar sesi&oacute;n]</a></nav>
    <br>
    <div class="mx-auto p-2" style="width: 75%;">
        <a class="btn btn-light" href="./index.php">Bitácora</a>
        <a class="btn btn-light" href="./panel.php">Panel</a>
    </div>


    <!--- Lista de actividades --->
    <div class="table-responsive mx-auto p-2" style="width: 75%">
        <table class="table table-hover">
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

                $sql = "SELECT * FROM ACTIVIDADES WHERE num_cuenta = '$nocuenta'";
                $result = $conn->query($sql);
                
                // Verificar si hay resultados
                if ($result->num_rows > 0) {
                    // Iterar sobre los resultados y generar las filas de la tabla
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        if($row['tipo']==0){
                            echo '<td><div><button class="btn btn-light" data-id="'.$row['id_usuario'].'" href="./agregaPanelAct.php">Agregar subactividad</button></div></td>';
                        } else {
                            echo "<td>Esto es una subactividad</td>";
                        };                        
                        echo '<td><div><button class="btn btn-light" data-id="'.$row['id_usuario'].'">Ver</button></div></td>';
                        echo '<td><div><button class="btn btn-light" data-id="'.$row['id_usuario'].'">Editar</button></div></td>';
                        echo '<td><div><button class="btn btn-light" data-id="'.$row['id_usuario'].'">Eliminar</button></div></td>';
                    }
                
                    echo "</table>";
                } else {
                    echo "No se encontraron resultados.";
                }
                ?>
            </tbody>
        </table>
        <br>
        <a class="btn btn-success" href="./agregaPanelAct.php">Agregar nueva actividad</a>
    </div>
    <br>

    <!--- Pendiente: Reporte de excel--->


    
    
   

    <script type="text/javascript" async="" src="https://www.ucol.mx/cms/apps/lib/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
</div>
<br><br><br>

</body>
