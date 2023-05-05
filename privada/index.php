<?php
 //Se asegura que el usuario este autenticado
 require_once("login.php"); 
 $atributos = $saml->getAttributes(); //Obtiene sus atributos
 //echo "Bienvenido ";
//Imprime los atributos
// foreach ($atributos as $clave => $valor) {
//  echo "<br><b>".$clave."</b>:".$valor[0];
//}
// echo "<br><br>Usted se encuentra en la secci&oacute;n privada de esta aplicaci&oacute;n<br><a href='../'>Ir a secci&oacute;n p&uacute;blica</a><br><a href='logout.php'>[Cerrar sesi&oacute;n]</a>";
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de bitácora</title>
    <link rel="icon" type="image/x-icon" href="./img/Escudo_UdeC.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="p-3 mb-2 bg-success"></div>
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
    <div class="mx-auto p-2">
        <button id="mostrarBitacora">Bitácora</button>
        <button id="mostrarPanel">Panel</button>
    </div>

    
    
    <div id="bitacora" class="border mx-auto p-2">
        <div>
            <div><label for="">Tarea a registrar</label></div>
            
            <textarea id="tarea"></textarea>
        </div>
        <div>
            <label for="tipoActividad">Actividad</label>
            <select name="actividades" id="actividades">
                <option value="0">Privada</option>
            </select>
            <label>Fecha</label>
            <input type="date">

            
        </div>
        <br>
        <input type="file">
        <button type="file">Adjuntar archivo</button>
        <button id="guardar">Guardar</button>
        
        <!--- Pendiente: Mostrar las tareas y con sus respectivos filtros-->
    </div>
    
    
</body>