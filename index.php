<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de bitacora</title>
    <link rel="icon" type="image/x-icon" href="./img/Escudo_UdeC.png">
    <link href="https://www.ucol.mx/cms/apps/assets/css/apps.min.css" rel="stylesheet">

</head>

<body>
    <div class="p-3 mb-2" style="background-color: #5c8c2c"></div>
    <div class="border-bottom">
        <div class="logo mx-auto p-2" style="width: 85%;">
            <a href="https://www.ucol.mx/"><img src="./img/Escudo_UdeC.png" alt="Escudo de la Universidad de Colima"
                    height="6%"></a>
            <a href="https://www.ucol.mx/"><img src="./img/Nombre_UdeC.png" alt="Universidad de Colima"
                    height="5%"></a>
        </div>
        <header class="mx-auto p-2" style="width: 75%;">Sistema de bitácora</header>
    </div>
    <br>
    <nav class="border mx-auto p-2 text-end" style="width: 75%;"><a href="./privada/index.php">Ingresar</a></nav>
    <br>

    <div class="border mx-auto p-2" style="width: 75%;">
        <header>
            <p><strong>Bienvenido</strong></p>
        </header>
        <p>Este es un sistema que permite a los miembros de la Coordinación General de Tecnologías de la Información de
            la Universidad de Colima, informar las actividades que han realizado durante el día.</p>
    </div>


<!-- <?php
        include 'db_conn.php';
        require_once('config.php');

        if ($saml->isAuthenticated()) {
            $atributos = $saml->getAttributes();
            ?>
            <br>
            <p>Existe sesión a nombre de
                <?= $atributos["uNombre"][0] ?>
            </p>
            <br>
            <a href='./privada/index.php'>Ir a sección privada</a>
            <?php
        } else {
            ?>
            <br>
            <p>Este es un sistema que permite informar las actividades que se han realizado durante el día.</p>
            <p>No hay sesión iniciada</p>
            <div>
                <a href='./privada/' class='btn btn-success'>Iniciar sesión</a>
            </div>
            <?php
        }
?> -->

<footer class="p-3 mb-2 bg-secondary text-white fixed-bottom ">
        <div class=" mx-auto p-2" style="width: 90%;">
            <div class="text-end">
                <p>Dirección: Av. Universidad No. 333, Las Víboras; CP 28040 Colima, Colima, México</p>
            </div>
            <div>
                <a href="https://www.gob.mx/sep">Sep</a>
                <a href="http://www.anuies.mx/">Anuies</a>
                <a href="https://www.cumex.org.mx/">Cumex</a>
                <a href="http://www.federaciondeestudiantescolimenses.com/">Fec</a>
                <a href="https://portal.ucol.mx/feuc/">Feuc</a>
            </div>
            <div class="text-end">
                <p>© Derechos Reservados Universidad de Colima</p>
            </div>
        </div>



  
</body>

</html>