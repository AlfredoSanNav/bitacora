<?php 
require_once("login.php");

function registrarUsuario(){

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

    if ($result->num_rows > 0) {
        // El usuario está registrado, no hace nada.
      } else {

        // El usuario no está registrado así que guarda la información de este.
        $sql = "INSERT INTO USUARIOS (nombre, email, contraseña) VALUES (NULL,'$nombre', '$email', '$contraseña')";

        if ($conn->query($sql) === TRUE) {
            echo "Usuario registrado exitosamente";
        } else {
            echo "Error al registrar al usuario: " . $conn->error;
        }

      };


    }

  ?>