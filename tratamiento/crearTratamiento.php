<?php
require_once('../common/DB.php');
require_once('../common/validaciones.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

global $mensaje;
global $error;

function imprimeCitasPasadas()
{
    if (isset($_POST['id_dependiente'])) {
        $id_dependiente = $_POST['id_dependiente'];
        //var_dump($_POST);


        $citas = DB::obtieneCitasPasadasPorId($id_dependiente);

        if (!empty($citas)) {
            echo "<div class='container mb-5 border-bottom border-warning'>";
            echo "<h2 class='text-center'>Selecciona la cita a la que quieres añadir un tratamiento</h2>";
            echo "</div>";

            echo "<div class='container'>";
            echo "<table class='table table-hover'>";
            echo "<tr>";
            echo "<th scope='col'>Fecha</th>";
            echo "<th scope='col'>Hora</th>";
            echo "<th scope='col'>Centro</th>";
            echo "<th scope='col'>Localidad</th>";
            echo "<th scope='col'>Provincia</th>";
            echo "<th scope='col'>Direccion</th>";
            echo "<th scope='col'>Planta</th>";
            echo "<th scope='col'>Especialidad</th>";
            echo "<th scope='col'>Residente</th>";
            echo "<th scope='col'>Añadir tto</th>";
            echo "</tr>";
            echo "<tbody></tbody>";

            echo "<form action='' method='post'>";
            foreach ($citas as $cita) {
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
                echo "</form>";

                echo "<form action='' method='post'>";
                echo "<td>";
                echo "<input type='hidden' name='id_cita' value='" . $cita['id_cita'] . "'>";
                echo "<input type='submit' name='anadir' value='Añadir' class='btn btn-primary'>";
                echo "</td>";
                echo "</form>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            //En caso de que no encuentre ninguna cita anterior, muestra un mensaje y un botón para crear una nueva cita
            echo "<div class='container'>";
            echo "<h2 class='text-center'>No hay ningún registro de citas pasadas para este dependiente</h2>";
            echo "<p class='text-center'>Crea una nueva cita para añadir un tratamiento</p>";
            echo "</div>";
            echo "<br>";

            echo "<form action='../cita/crearCita.php' method='post' class='row justify-content-center'>";
            echo "<input type='hidden' name='id_dependiente' value='" . $id_dependiente . "'>";
            echo "<div class='col-1'>";
            echo "<input type='submit' name='crearCita' value='Crear cita' class='btn btn-primary'>";
            echo "</div>";
            echo "</form>";

        }
    }
}

function creaTratamiento()
{
    if (isset($_POST['anadir'])) {
        $id_cita = $_POST['id_cita'];

//Comprueba si ya existe una consulta para esa cita
        $consulta = DB::obtieneConsultasPorIdCita($id_cita);

//Si la consulta no existe, crea una consulta en primer lugar
        if (!$consulta) {

            echo "<div class='container'>";
            echo "<h2 class='text-center'>No existe ninguna consulta creada para esta cita</h2>";
            echo "<p class='text-center'>Procederemos a crear una y posteriormente podremos agregar tratamientos</p>";
            echo "<hr>";
            echo "</div>";
            echo "<br>";

            echo "<div class='container'>";
            echo "<h3 class='text-center border border-warning p-3'>Introduce los datos para la nueva consulta</h3>";
            echo "</div>";

            echo "<form action='' method='post'>";
            echo "<fieldset>";
            echo "<legend>Inserta los datos de la consulta</legend>";

            echo "<div class='campo'>";
            echo "<label for='nombre_medico'>Nombre del médico:</label><br/>";
            echo "<input type='text' name='nombre_medico' id='nombre_medico' required/><br/>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='motivo_visita'>Motivo de la visita:</label><br/>";
            echo "<input type='text' name='motivo_visita' id='motivo_visita' required/><br/>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='descripcion'>Descripción de la consulta:</label><br/>";
            echo "<input type='text' name='descripcion' id='descripcion' required/><br/>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='diagnostico'>Diagnóstico:</label><br/>";
            echo "<input type='text' name='diagnostico' id='diagnostico' required/><br/>";
            echo "</div>";

            echo "<br>";
            echo "<div class='campo'>";
            echo "<input type='hidden' name='id_cita' value='" . $id_cita . "'>";
            echo "<input type='submit' name='crearConsulta' value='Crear'/>";
            echo "</div>";

            echo "</fieldset>";
            echo "</form>";


            //todo PENDIENTE **************************Si no existe, crea una consulta

            // en caso que exista, crea el tratamiento
        } else {

            $id_consulta = $consulta['id_consulta'];
            $id_cita = $consulta['id_cita'];

            echo "<h2>Datos de la consulta seleccionada</h2>";
            echo "<table class='table table-hover'>";
            echo "<tr>";
            echo "<th scope='col'>Nombre médico</th>";
            echo "<th scope='col'>Motivo de la visita</th>";
            echo "<th scope='col'>Descripción</th>";
            echo "<th scope='col'>Diagnóstico</th>";
            echo "<th scope='col'>Modificar</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>" . $consulta['nombre_medico'] . "</td>";
            echo "<td>" . $consulta['motivo_visita'] . "</td>";
            echo "<td>" . $consulta['descripcion'] . "</td>";
            echo "<td>" . $consulta['diagnostico'] . "</td>";
            echo "<td>";
            echo "<form action='../cita/modificaConsulta.php' method='post'>";
            echo "<input type='hidden' name='id_consulta' value='" . $id_consulta . "'>";
            echo "<input type='hidden' name='id_cita' value='" . $id_cita . "'>";
            echo "<input type='hidden' name='nombre_medico' value='" . $consulta['nombre_medico'] . "'>";
            echo "<input type='hidden' name='motivo_visita' value='" . $consulta['motivo_visita'] . "'>";
            echo "<input type='hidden' name='descripcion' value='" . $consulta['descripcion'] . "'>";
            echo "<input type='hidden' name='diagnostico' value='" . $consulta['diagnostico'] . "'>";
            echo "<input type='submit' name='modificar' value='Modificar'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";

//Ahora comprueba si ya existen tratamientos para esa consulta
            $tratamientos = DB::obtieneTratamientosPorIdConsulta($id_consulta);

            if ($tratamientos) {
                echo "<h2>Para esta consulta se han añadido los siguientes tratamientos</h2>";

                echo "<table class='table table-hover'>";
                echo "<tr>";
                echo "<th scope='col'>Síntoma</th>";
                echo "<th scope='col'>Pauta de medicación completa</th>";
                echo "<th scope='col'>Pauta reducida</th>";
                echo "<th scope='col'>Tipo</th>";
                echo "<th scope='col'>Fecha inicio</th>";
                echo "<th scope='col'>Fecha fin</th>";
                echo "<th scope='col'>ID Tratamiento</th>";
                echo "<th scope='col'>ID Medicamento</th>";
                echo "</tr>";
                foreach ($tratamientos as $tratamiento) {
                    echo "<tr>";
                    echo "<td>" . $tratamiento['sintoma'] . "</td>";
                    echo "<td>" . $tratamiento['pauta_medicacion'] . "</td>";
                    echo "<td>" . $tratamiento['pauta_reducida'] . "</td>";
                    echo "<td>" . $tratamiento['tipo'] . "</td>";
                    echo "<td>" . $tratamiento['fecha_inicio'] . "</td>";
                    echo "<td>" . $tratamiento['fecha_fin'] . "</td>";
                    echo "<td>" . $tratamiento['id_tratamiento'] . "</td>";
                    echo "<td>" . $tratamiento['id_medicamento'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }

            echo "<hr>";
            echo "<br>";
            echo "<div>";
            echo "<h2>Nuevo tratamiento:</h2>";
            echo "</div>";
            echo "<form action='' method='post'>";
            echo "<fieldset>";
            echo "<legend>Inserta los datos del tratamiento</legend>";

            echo "<div class='campo'>";
            echo "<label for='sintoma'>Síntoma:</label><br/>";
            echo "<input type='text' name='sintoma' id='sintoma' required/><br/>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='pauta_medicacion'>Pauta de medicación completa:</label><br/>";
            echo "<input type='text' name='pauta_medicacion' id='pauta_medicacion' required/><br/>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='pauta_reducida'>Pauta reducida:</label><br/>";
            echo "<input type='text' name='pauta_reducida' id='pauta_reducida'/><br/>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='tipo'>Tipo:</label><br/>";
            echo "<input type='radio' id='somatica' name='tipo' value='somatica' required>";
            echo "<label for='somatica'>Somática</label><br/>";
            echo "<input type='radio' id='psiquiatrica' name='tipo' value='psiquiatrica' required>";
            echo "<label for='psiquiatrica'>Psiquiátrica</label><br/>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='fecha_inicio'>Fecha inicio tratamiento:</label><br/>";
            echo "<input type='date' name='fecha_inicio' id='fecha_inicio' value='' required/><br/>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='fecha_fin'>Fecha fin del tratamiento:</label><br/>";
            echo "<input type='date' placeholder='2000-01-01' name='fecha_fin' id='fecha_fin' value='' required/><br/>";
            echo "</div>";

            echo "<div id='selectMedicacion'>";
            echo "<label for='id_medicamento'>Medicación:</label><br>";
            echo "<select id='id_medicamento' name='id_medicamento'>";
            echo "<option selected disabled>Medicación...</option>";
            $medicacion = DB::selectMedicacion();
            // recorremos el array e imprimimos cada opción del mismo
            for ($i = 0; $i < count($medicacion); $i++) {
                //introducimos como valor el código e imprimimos el nombre
                echo "<option value='" . $medicacion[$i]["id_medicamento"] . "'>" . $medicacion[$i]["nombre_comercial"] . ' ' . $medicacion[$i]["concentracion"] . "</option>";
            }
            echo "</select>";
            echo "</div>";

            echo "<br>";
            echo "<div class='campo'>";
            echo "<input type='hidden' name='id_consulta' value='" . $id_consulta . "'>";
            echo "<input type='submit' name='crearTratamiento' value='Crear'/>";
            echo "</div>";
            echo "</fieldset>";
            echo "</form>";
        }
    }
}

if (isset($_POST['crearConsulta'])) {

    $nombre_medico = $_POST['nombre_medico'];
    $motivo_visita = $_POST['motivo_visita'];
    $descripcion = $_POST['descripcion'];
    $diagnostico = $_POST['diagnostico'];
    $id_cita = $_POST['id_cita'];

    $insertaConsulta = DB::creaConsulta($nombre_medico, $motivo_visita, $descripcion, $diagnostico, $id_cita);

    if (!$insertaConsulta) {
        $error .= "<h2>Ha ocurrido un error al crear la consulta</h2>";
    } else {
        $mensaje .= "<h2>Consulta creada correctamente</h2>";
        $mensaje .= "<div>";
        $mensaje .= "<input type='button' value='Volver' class='btn btn-warning' onclick='window.location.href=\"../persona_dependiente.php\"'>";
        $mensaje .= "</div>";
    }

}

if (isset($_POST['crearTratamiento'])) {

    $sintoma = $_POST['sintoma'];
    $pauta_medicacion = $_POST['pauta_medicacion'];
    $pauta_reducida = $_POST['pauta_reducida'];
    $tipo = $_POST['tipo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $id_consulta = $_POST['id_consulta'];
    $id_medicamento = $_POST['id_medicamento'];


    $comparacion = comparaFechas($fecha_inicio, $fecha_fin);
    if ($comparacion) {

        echo "<br>";
        $inserta = DB::creaTratamiento($sintoma, $pauta_medicacion, $pauta_reducida, $tipo, $fecha_inicio, $fecha_fin, $id_consulta, $id_medicamento);

        if ($inserta) {
            $mensaje .= "<h2>Tratamiento creado correctamente</h2>";
        } else $error .= "<h2>Ha ocurrido un error al crear el tratamiento</h2>";
    } else $error .= "la fecha fin no puede ser menor que la fecha inicio";

    echo "<div>";
    echo "<input type='button' value='Volver' class='btn btn-warnign' onclick='window.location.href=\"../persona_dependiente.php\"'>";
    echo "</div>";
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
                    <a class="nav-link active" href="../incidencias.php">Incidencias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../citas.php">Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../persona_dependiente.php">Residentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../perfil.php">Perfil trabajador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../logoff.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>
    <?php
    //Imprime los errores encontrados
    if (!empty($error)) {
        echo "<div class='container'>";
        echo "<div class='p-5 my-3 border border-danger rounded text-center'>";
        echo "<h3>No ha sido posible crear la cita debido a los siguientes errores:</h3>";
        echo $error;
        echo "</div>";
        echo "</div>";
    }
    if (!empty($mensaje)) {
        echo "<div class='container'>";
        echo "<div class='p-5 my-3 border border-success rounded text-center'>";
        echo $mensaje;
        echo "</div>";
        echo "</div>";
    }
    ?>
<main>
<div>
    <?= imprimeCitasPasadas(); ?>
</div>
<div>
    <?= creaTratamiento(); ?>
</div>
</main>
<?php include "../common/footer.php"; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
