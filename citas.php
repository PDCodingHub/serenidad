<?php
require_once('common/DB.php');
require_once('common/validaciones.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("<p>Debe <a href='login.php'>identificarse</a> para poder acceder a esta página.</p><br />");


function obtieneTabla($citas)
{
    echo "<table class='table table-striped table-hover caption-top'>";
    echo "<tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Centro</th>
                    <th>Localidad</th>
                    <th>Provincia</th>
                    <th>Dirección</th>
                    <th>Planta</th>
                    <th>Especialidad</th>
                    <th>Nombre Residente</th>
                </tr>";
    echo "<tbody></tbody>";
    foreach ($citas as $cita) {

        //Cambio el formato de visualización de la fecha y la hora en la tabla

        echo "<tr>";
        echo "<td>" . formatoFecha($cita['fecha']) . "</td>";
        echo "<td>" . formatoHora($cita['hora']) . "</td>";
        echo "<td>" . $cita['centro'] . "</td>";
        echo "<td>" . $cita['localidad'] . "</td>";
        echo "<td>" . $cita['provincia'] . "</td>";
        echo "<td>" . $cita['direccion'] . "</td>";
        echo "<td>" . $cita['planta'] . "</td>";
        echo "<td>" . $cita['especialidad'] . "</td>";
        echo "<td>" . $cita['nombre'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
    <link rel="icon" type="image/x-icon" href="/img/ideogram.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/css/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@700&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary mb-5">
    <div class="container-fluid navbarSerenidad">
        <a class="navbar-brand" href="#"><img src="/img/ideogram2.jpg" alt="" class="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-fill me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <!-- <li class="nav-item mx-4"> -->
                    <a class="nav-link active" href="incidencias.php">Incidencias</a>
                </li>
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link active" href="citas.php">Citas</a>-->
<!--                </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="cita/crearCita.php">Añadir nueva cita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cita/modificaCita.php">Modificar / Borrar alguna cita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="persona_dependiente.php">Residentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="perfil.php">Perfil trabajador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="logoff.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>
    <div class="container m-5 mt-5 m-auto">
        <h1 class="text-center mb-4 border-bottom border-warning">Citas para hoy</h1>
        <?php
        $fecha = date("Y-m-d");
        $citas = DB::obtieneCitasHoy();
        // Comprueba si existen citas para el día actual
        if (empty($citas)) {
            echo "<h4 class='text-center'>No hay citas para hoy</h4>";
        } else {
            echo obtieneTabla($citas);
        }
        ?>
    </div>
    <div class="container m-5 mt-5 m-auto">
        <h1 class="text-center mb-4 border-bottom border-warning">Citas más próximas</h1>
        <?php
        //obtenemos la fecha del día actual
        $fecha = date("Y-m-d");

        $citas = DB::obtieneCitasProximas();
        echo obtieneTabla($citas);
        ?>
    </div>
</main>

<?php include "common/footer.php"; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>

