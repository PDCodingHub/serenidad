<?php
require_once('common/DB.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

function imprimeInfoPersonal()
{
    if (isset($_POST['consultar'])) {

        if (isset($_POST['id_dependiente'])) {
            $id_dependiente = $_POST['id_dependiente'];
            echo "<div class='text-center my-3 mt-3'>";
            echo "<h2 class='border-bottom border-warning'>Información personal</h2>";
            echo "</div>";
            $infoPersonal = DB::obtieneDependienteId($id_dependiente);

            echo "<br>";
            echo "<table class='table table-striped table-bordered table-hover'>";

            echo "<tr>";
            echo "<th>DNI</th>";
            echo "<th>Nombre</th>";
            echo "<th>Fecha nacimiento</th>";
            echo "<th>Dirección</th>";
            echo "<th>Localidad</th>";
            echo "<th>Provincia</th>";
            echo "<th>Teléfono</th>";
            echo "<th>Email</th>";
            echo "<th>Nivel dependencia</th>";
            echo "<th>Número habitación</th>";
            echo "<th>Familiar referencia</th>";
            echo "<th>Nombre familiar referencia</th>";
            echo "<th>Teléfono familiar referencia</th>";
            echo "</tr>";
            echo "<tbody class='table-group-divider'/>";

            foreach ($infoPersonal as $info) {

                echo "<tr>";
                echo "<td>" . $info['dni_persona'] . "</td>";
                echo "<td><strong>" . $info['nombre'] . "</strong></td>";
                echo "<td>" . $info['fecha_nacimiento'] . "</td>";
                echo "<td>" . $info['direccion'] . "</td>";
                echo "<td>" . $info['localidad'] . "</td>";
                echo "<td>" . $info['provincia'] . "</td>";
                echo "<td>" . $info['telefono'] . "</td>";
                echo "<td>" . $info['email'] . "</td>";
                echo "<td>" . $info['nivel_dependencia'] . "</td>";
                echo "<td><strong>" . $info['num_habitacion'] . "</strong></td>";
                echo "<td>" . $info['familiar_referencia'] . "</td>";
                echo "<td>" . $info['nombre_fam_referencia'] . "</td>";
                echo "<td>" . $info['telefono_fam_referencia'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
}

function imprimeTratamientos()
{
    if (isset($_POST['consultar'])) {

        if (isset($_POST['id_dependiente'])) {
            $id_dependiente = $_POST['id_dependiente'];
            echo "<div class='text-center my-3 mt-3'>";
            echo "<h2 class='border-bottom border-warning'>Tratamientos actuales</h2>";
            echo "</div>";
            $tratamientos = DB::obtieneTratamientosDependiente($id_dependiente);

            if (empty($tratamientos)) {
                echo "<h3>No tiene tratamientos actualmente</h3>";
            } else {

                echo "<br>";
                echo "<table class='table table-striped table-bordered table-hover'>";

                echo "<tr>";
                echo "<th scope='col'>Diagnostico</th>";
                echo "<th scope='col'>Nombre medicación</th>";
                echo "<th scope='col'>Pauta medicación</th>";
                echo "<th scope='col'>Pauta simplificada</th>";
                echo "<th scope='col'>Tipo</th>";
                echo "<th scope='col'>Fecha inicio tratamiento</th>";
                echo "<th scope='col'>Fecha fin</th>";
                echo "</tr>";

                foreach ($tratamientos as $tratamiento) {

                    echo "<tr>";
                    echo "<td class='col'>" . $tratamiento['diagnostico'] . "</td>";
                    echo "<td class='col'>" . $tratamiento['nombre_medicamento'] . "</td>";
                    echo "<td class='col'>" . $tratamiento['pauta_medicacion'] . "</td>";
                    echo "<td class='col'>" . $tratamiento['pauta_reducida'] . "</td>";
                    echo "<td class='col'>" . $tratamiento['tipo'] . "</td>";
                    echo "<td class='col'>" . $tratamiento['fecha_inicio'] . "</td>";
                    echo "<td class='col'>" . $tratamiento['fecha_fin'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            echo "<br>";
            echo "<form action='tratamiento/crearTratamiento.php' method='post'>";
            echo "<input type='hidden' name='id_dependiente' value='" . $id_dependiente . "'>";
            echo "<input type='submit' name='anadirTratamiento' value='Añadir tratamiento' class='btn btn-primary'>";
            echo "</form>";
        }
    }
}

function imprimeCitas()
{
    if (isset($_POST['consultar'])) {

        if (isset($_POST['id_dependiente'])) {
            $id_dependiente = $_POST['id_dependiente'];
            echo "<div class='text-center my-3 mt-3'>";
            echo "<h2 class='border-bottom border-warning'>Citas próximas</h2>";
            echo "</div>";

            $citas = DB::obtieneCitasProximasPorId($id_dependiente);

            if (empty($citas)) {
                echo "<h4>No tiene citas próximas</h4>";

            } else {

                echo "<br>";
                echo "<table class='table table-striped table-bordered table-hover'>";
                echo "<tr>";
                echo "<th>Fecha</th>";
                echo "<th>Hora</th>";
                echo "<th>Centro</th>";
                echo "<th>Localidad</th>";
                echo "<th>Provincia</th>";
                echo "<th>Dirección</th>";
                echo "<th>Planta</th>";
                echo "<th>Especialidad</th>";
                echo "<th>Modificar</th>";
                echo "</tr>";

                foreach ($citas as $cita) {

                    echo "<tr>";
                    echo "<td>" . $cita['fecha'] . "</td>";
                    echo "<td>" . $cita['hora'] . "</td>";
                    echo "<td>" . $cita['centro'] . "</td>";
                    echo "<td>" . $cita['localidad'] . "</td>";
                    echo "<td>" . $cita['provincia'] . "</td>";
                    echo "<td>" . $cita['direccion'] . "</td>";
                    echo "<td>" . $cita['planta'] . "</td>";
                    echo "<td>" . $cita['especialidad'] . "</td>";
                    echo "<td>";
                    echo "<form action='cita/ModificaCita.php' method='post'>";
                    echo "<input type='hidden' name='fecha' value='" . $cita['fecha'] . "'>";
                    echo "<input type='submit' name='mod' value='Modificar' class='btn btn-success'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            echo "<br>";
            echo "<div>";
            echo "<form action='cita/crearCita.php' method='post'>";
            echo "<input type='hidden' name='id_dependiente' value='" . $id_dependiente . "'>";
            echo "<input type='submit' name='crearCitaPorId' value='Añadir cita' class='btn btn-primary'>";
            echo "</form>";
        }
    }
}

function imprimeIncidencias()
{
    if (isset($_POST['consultar'])) {

        if (isset($_POST['id_dependiente'])) {
            $id_dependiente = $_POST['id_dependiente'];
            echo "<div class='text-center my-3 mt-3'>";
            echo "<h2 class='border-bottom border-warning'>Incidencias</h2>";
            echo "</div>";
            $incidencias = DB::obtieneIncidenciasIdDependiente($id_dependiente);

            if (!empty($incidencias)) {
                echo "<br>";
                echo "<table class='table table-striped table-bordered table-hover'>";
                echo "<tr>";
                echo "<th>Fecha</th>";
                echo "<th>Descripción</th>";
                echo "<th>Nombre Trabajador</th>";
                echo "</tr>";

                foreach ($incidencias as $incidencia) {

                    echo "<tr>";
                    echo "<td>" . $incidencia['fecha'] . "</td>";
                    echo "<td>" . $incidencia['descripcion'] . "</td>";
                    echo "<td>" . $incidencia['nombre_trabajador'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                //echo "<hr>";
            }
        }
    }
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
                    <a class="nav-link" href="../citas.php">Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="crearCita.php">Añadir nueva cita</a>
                </li>
                <!--                <li class="nav-item">-->
                <!--                    <a class="nav-link" href="cita/modificaCita.php">Modificar / Borrar alguna cita</a>-->
                <!--                </li>-->
                <li class="nav-item">
                    <a class="nav-link active" href="../persona_dependiente.php">Residentes</a>
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
    <div class="modal" tabindex="-1" id="messageModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="messageText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <form action="" method="post" class="container">
            <div id="selectId">
                <div class="text-center border-bottom border-warning my-5">
                    <h1>Perfil Residentes</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <label for="id">Selecciona al residente que quieres consultar:</label>
                    </div>
                    <div class="col-md-4">
                        <select id="id_dependiente" name="id_dependiente" class="form-control">
                            <option selected disabled>Selecciona...</option>
                            <?php
                            $nombre = "";
                            $dependiente = DB::selectDependiente();
                            // recorremos el array e imprimimos cada opción del mismo
                            for ($i = 0; $i < count($dependiente); $i++) {
                                //introducimos como valor el código e imprimimos el nombre
                                echo "<option value='" . $dependiente[$i]["id_dependiente"] . "'>" . $dependiente[$i]["nombre"] . "</option>";
                                $nombre = $dependiente[$i]["nombre"];
                            }
                            echo "<input type='hidden' name='nombre' value='" . $nombre . "'>";
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" name="consultar" value="Consultar" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </form>

        <div class="container p-0">
            <br><hr>
            <div>
                <?php echo imprimeInfoPersonal() ?>
            </div>
            <div>
                <?php echo imprimeTratamientos() ?>
            </div>
            <div>
                <?php echo imprimeCitas() ?>
            </div>
            <div>
                <?php echo imprimeIncidencias() ?>
            </div>
        </div>
</main>
<?php include "common/footer.php"; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
