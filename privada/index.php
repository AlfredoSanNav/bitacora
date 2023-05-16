<?php
 //Se asegura que el usuario este autenticado
 include '../db_conn.php';
 include './registrarUsuario.php';
 require_once("login.php"); 
// $atributos = $saml->getAttributes(); //Obtiene sus atributos
 //echo "Bienvenido ";
//Imprime los atributos
// foreach ($atributos as $clave => $valor) {
//  echo "<br><b>".$clave."</b>:".$valor[0];
//}
// echo "<br><br>Usted se encuentra en la secci&oacute;n privada de esta aplicaci&oacute;n<br><a href='../'>Ir a secci&oacute;n p&uacute;blica</a><br><a href='logout.php'>[Cerrar sesi&oacute;n]</a>";

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
    <br><br>
    <div class="mx-auto p-2" style="width: 75%;">
        <button id="mostrarBitacora">Bitácora</button>
        <button id="mostrarPanel">Panel</button>
    </div>
    <br>

    
    
    <div id="bitacora" class="mx-auto p-2" style="width: 75%;">
    <form method="POST" enctype="multipart/form-data">
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
        <input type="submit" name="submit" value="Guardar tarea">
    </form>

    <!--- Pendiente: Mostrar las tareas y con sus respectivos filtros-->

    <script src="registrarUsuario.php"></script>
    <script type="text/javascript" async="" src="https://www.ucol.mx/cms/apps/lib/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
</div>
    
</body>