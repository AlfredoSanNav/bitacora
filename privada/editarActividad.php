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

  if (isset($_POST['btnEditarAct'])) {
    // Obtén los valores de los campos del formulario
    $nombreAct = $_POST['nombreAct'];
    $descripcionAct = $_POST['descripcionAct'];
    $correoInvitar = $_POST['correoInvitar'];
    $id = $_GET['id'];
    
    // Envía la petición update a la base de datos
    $sql = "UPDATE ACTIVIDADES SET nombre = '$nombreAct', descripcion = '$descripcionAct', invitados = '$correoInvitar' WHERE id_usuario = $id";
    $result = mysqli_query($conn, $sql);

    //Comprueba el exito de la petición 
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
        <a class="btn btn-light" href="./panel.php">Panel</a>
    </div>
 

    <!--- Formulario para añadir actividades --->
    <div class="card mx-auto p-2" style="width: 75%; background-color: F5F5F5;">
        <form action="" method="post"> 
            <fieldset>
                <legend>Editar actividad</legend>

                <!--- Trae la información de la actividad--->
                <?php
                include '../db_conn.php';

                $id = $_GET['id'];
                $sql = "SELECT * FROM ACTIVIDADES WHERE id_usuario = '$id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                echo '
                <p>
                    <label for="nombreAct">Nombre:</label>
                    <input type="text" name="nombreAct" value="'.$row[nombre].'" >
                </p><br>
                <p>
                    <label for="descripcionAct">Descripción:</label>
                    <input type="text" name="descripcionAct" value="'.$row[descripcion].'">
                </p> <br>
                <p>
                    <label for="correoInvitar">Invitar:</label><br>
                    <input type="email" multiple name="correoInvitar" value="'.$row[invitados].'">
                </p><br>
                <a class="btn btn-danger" name="btnCalcelarAct" href="./panel.php">Cancelar</a>
                <button class="btn btn-success" name="btnEditarAct" type="submit" >Editar</button>
                '
                ?>                
            </fieldset>
            <br>
        </form>
    </div>

    <script type="text/javascript" async="" src="https://www.ucol.mx/cms/apps/lib/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
</div>
<br><br><br>

</body>