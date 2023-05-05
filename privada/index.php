<?php
 //Se asegura que el usuario este autenticado
 require_once("login.php"); 
 $atributos = $saml->getAttributes(); //Obtiene sus atributos
 echo "Bienvenido ";
  //Imprime los atributos
 foreach ($atributos as $clave => $valor) {
    echo "<br><b>".$clave."</b>:".$valor[0];
}
 echo "<br><br>Usted se encuentra en la secci&oacute;n privada de esta aplicaci&oacute;n<br><a href='../'>Ir a secci&oacute;n p&uacute;blica</a><br><a href='logout.php'>[Cerrar sesi&oacute;n]</a>";
?>