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

  if (isset($_POST['btnAgregaAct'])) {
    // Se ha enviado el formulario y se hizo clic en el botón de enviar
    $atributos = $saml->getAttributes();
    $nocuenta = $atributos["uCuenta"][0];
    // Obtén los valores de los campos del formulario
    $nombreAct = $_POST['nombreAct'];
    $descripcionAct = $_POST['descripcionAct'];
    $correoInvitar = $_POST['correoInvitar'];
  
    // Haz algo con los datos recibidos, como guardarlos en la base de datos o enviar un correo electrónico
    $sql = "INSERT INTO ACTIVIDADES (id_usuario, num_cuenta, nombre, descripcion, invitados, tipo)
    VALUES (NULL, '$nocuenta', '$nombreAct', '$descripcionAct', '$correoInvitar', 1)";
    // Redirige a otra página o muestra un mensaje de éxito
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        header("Location: panel.php");
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
    <nav class="border mx-auto p-2 text-end" style="width: 75%;"><a href='logout.php'>[Cerrar sesi&oacute;n]</a></nav>
    <br>
    <div class="mx-auto p-2" style="width: 75%;">
        <a class="btn btn-light" href="./index.php">Bitácora</a>
        <a class="btn btn-light" href="./panel.php">Panel</a>
    </div>
 

    <!--- Formulario para añadir actividades --->
    <div class="mx-auto p-2" style="width: 75%; background-color: F5F5F5;">
        <form action="" method="post"> 
            <fieldset>
                <legend>Agregar Subctividad</legend>
                <p>
                    <label for="nombreAct">Nombre:</label>
                    <input type="text" name="nombreAct" >
                </p>
                <p>
                    <label for="descripcionAct">Descripción:</label>
                    <input type="text" name="descripcionAct" >
                </p> 
                <p>
                    <label for="correoInvitar">Invitar:</label>
                    <input type="email" multiple  name="correoInvitar" >
                </p>
                <a class="btn btn-danger" name="btnCalcelarAct" href="./panel.php">Cancelar</a>
                <button class="btn btn-success" name="btnAgregaAct" type="submit" >Guardar</button>
            </fieldset>

            
            <br>
        </form>
    </div>

    
    
   

    <script type="text/javascript" async="" src="https://www.ucol.mx/cms/apps/lib/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
</div>
<br><br><br>

</body>