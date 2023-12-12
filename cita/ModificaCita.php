<?php
require_once('../common/DB.php');
require_once('../common/validaciones.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");


global $mensaje;

function obtieneCitas()
{
    if ((isset($_POST['buscar'])) || (isset($_POST['fecha']))) {
        $fech = $_POST['fecha'];
        $citas = DB::obtieneCitas($fech);

        if (!empty($citas)) {

            echo "<table class='table table-striped table-hover caption-top'>";
            echo "<caption class='text-center'>LISTA DE CITAS PARA LA FECHA SELECCIONADA</caption>";
            echo "<tr>";
            echo "<th>FECHA</th>";
            echo "<th>HORA</th>";
            echo "<th>CENTRO</th>";
            echo "<th>LOCALIDAD</th>";
            echo "<th>PROVINCIA</th>";
            echo "<th>DIRECCIÓN</th>";
            echo "<th>PLANTA</th>";
            echo "<th>ESPECIALIDAD</th>";
            echo "<th>NOMBRE RESIDENTE</th>";
            echo "<th>MODIFICAR</th>";
            echo "<th>BORRAR</th>";
            echo "</tr>";
            echo "<tbody></tbody>";

            foreach ($citas as $cita) {

                echo "<form action='' method='post'>";
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

                echo "<td>";
                echo "<input type='hidden' name='id_cita' value='" . $cita['id_cita'] . "'>";
                echo "<input type='hidden' name='fecha' value='" . $cita['fecha'] . "'>";
                echo "<input type='hidden' name='hora' value='" . $cita['hora'] . "'>";
                echo "<input type='hidden' name='centro' value='" . $cita['centro'] . "'>";
                echo "<input type='hidden' name='localidad' value='" . $cita['localidad'] . "'>";
                echo "<input type='hidden' name='provincia' value='" . $cita['provincia'] . "'>";
                echo "<input type='hidden' name='direccion' value='" . $cita['direccion'] . "'>";
                echo "<input type='hidden' name='planta' value='" . $cita['planta'] . "'>";
                echo "<input type='hidden' name='especialidad' value='" . $cita['especialidad'] . "'>";
                echo "<input type='hidden' name='nombre' value='" . $cita['nombre'] . "'>";
                echo "<input type='hidden' name='id_dependiente' value='" . $cita['id_dependiente'] . "'>";

                echo "<input type='submit' name='editar' value='Editar' class='btn border border-success'>";
                echo "</td>";
                echo "</form>";

                echo "<td>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='id_cita' value='" . $cita['id_cita'] . "'>";
                echo "<input type='submit' name='borrar' value='Borrar' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de que quieres borrar esta cita?\");'>";
                echo "</form>";
                echo "</td>";
            }
            echo "</table>";
        } else {
            echo "<h5 class='text-center'>No hay citas para la fecha seleccionada</h5>";
        }
    }
}

function modificaCita()
{
    $id_cita = $_POST['id_cita'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $centro = $_POST['centro'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];
    $direccion = $_POST['direccion'];
    $planta = $_POST['planta'];
    $especialidad = $_POST['especialidad'];
    $nombre = $_POST['nombre'];
    $id_dependiente = $_POST['id_dependiente'];
    ?>
    <form action="" method="post" class="container">
        <div class="row campo">
            <div class="negrita col-12">
                <h5 class="text-center my-4 border border-success rounded p-3">Introduce la información para modificar
                    la cita</h5>
            </div>
        </div>
        <br>
        <div class="row campo m-auto justify-content-center">
            <div class="col-md-2 text-center">
                <label for="fecha" class="negrita">Fecha</label>
            </div>
            <div class="col-md-4">
                <input type="date" name="fecha" class="form-control" value="<?php echo $fecha ?>">
            </div>
            <div class="col-md-2 text-center">
                <label for="hora" class="negrita">Hora</label>
            </div>
            <div class="col-md-4">
                <input type="time" name="hora" class="form-control" value="<?php echo $hora ?>">
            </div>
        </div>
        <br>
        <div class="row campo m-auto justify-content-center">
            <div class="col-md-2 text-center">
                <label for="centro" class="negrita">Centro</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="centro" class="form-control" value="<?php echo $centro ?>">
            </div>
            <div class="col-md-2 text-center">
                <label for="localidad" class="negrita">Localidad</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="localidad" class="form-control" value="<?php echo $localidad ?>">
            </div>
        </div>
        <br>
        <div class="row campo m-auto justify-content-center">
            <div class="col-2 text-center">
                <label for="provincia" class="negrita">Provincia</label>
            </div>
            <div class="col-4">
                <input type="text" name="provincia" class="form-control" value="<?php echo $provincia ?>">
            </div>
            <div class="col-2 text-center">
                <label for="direccion" class="negrita">Dirección</label>
            </div>
            <div class="col-4">
                <input type="text" name="direccion" class="form-control" value="<?php echo $direccion ?>">
            </div>
        </div>
        <br>
        <div class="row campo m-auto justify-content-center">
            <div class="col-2 text-center">
                <label for="planta" class="negrita">Planta</label>
            </div>
            <div class="col-4">
                <input type="text" name="planta" class="form-control" value="<?php echo $planta ?>">
            </div>
            <div class="col-2 text-center">
                <label for="especialidad" class="negrita">Especialidad</label>
            </div>
            <div class="col-4">
                <input type="text" name="especialidad" class="form-control" value="<?php echo $especialidad ?>">
            </div>
        </div>
        <br>
        <div class="row campo m-auto text-center">
            <div class="negrita col-12">
                <label for="id_dependiente2" class="negrita">El residente actual es: <?php echo $nombre ?></label>
            </div>
        </div>
        <div class="row campo m-auto text-center">
            <div class="negrita col-12">
                <label for="id_dependiente2" class="negrita">Selecciona otro residente si deseas
                    modificarlo:</label>
            </div>
        </div>
        <div class="row campo m-auto justify-content-center">
            <div class="col-5">
                <select id="id_dependiente2" name="id_dependiente2" class="form-select">
                    <option selected disabled>Seleccione el nombre del residente</option>
                    <?php
                    $dependiente = DB::selectDependiente();
                    // recorremos el array e imprimimos cada opción del mismo
                    for ($i = 0; $i < count($dependiente); $i++) {
                        //introducimos como valor el código e imprimimos el nombre
                        echo "<option value='" . $dependiente[$i]["id_dependiente"] . "'>" . $dependiente[$i]["nombre"] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <br><br>
        <div class="row mb-5">
            <div class="d-grid gap-2 col-6 mx-auto">
                <input type="hidden" name="id_cita" value="<?php echo $id_cita ?>">
                <input type="hidden" name="id_dependiente" value="<?php echo $id_dependiente ?>">
                <input type='submit' name='modificar' value='Modificar' class="btn btn-success">
            </div>
        </div>
    </form>
    <?php
}

// SI SE PULSA EL BOTÓN MODIFICAR
if (isset($_POST['modificar'])) {
    $error = "";

    $hora = $_POST['hora'];
    $centro = $_POST['centro'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];
    $direccion = $_POST['direccion'];
    $planta = $_POST['planta'];
    $especialidad = $_POST['especialidad'];
    $id_cita = $_POST['id_cita'];
    // comprobamos si se ha actualizado el residente o no
    if (isset($_POST['id_dependiente2'])) {
        $id_dependiente = $_POST['id_dependiente2'];
    } else {
        $id_dependiente = $_POST['id_dependiente'];
    }
    $fecha = $_POST['fecha'];
    // pasamos la fecha a Date y comparamos con la fecha actual
    $compruebaFecha = isFechaIgualoMayorActual($fecha);

    // si las variables necesarias no están vacías, procede
    if (!empty($fecha) && !empty($hora) && !empty($centro) && !empty($localidad) && !empty($provincia) && !empty($direccion) && !empty($especialidad) && isset($id_cita) && isset($id_dependiente)) {
        //si la fecha es igual o superior a la actual, procede a modificar la cita
        if ($compruebaFecha) {

            $filas = DB::actualizaCita($fecha, $hora, $centro, $localidad, $provincia, $direccion, $planta, $especialidad, $id_dependiente, $id_cita);

            if ($filas > 0) {
                $mensaje .= "<h3>La cita ha sido modificada correctamente</h3";
            } else $error .= "<h3>La cita no ha sido modificada</h3>";
        } else $error .= "<h3>La fecha no puede ser anterior a la actual</h3><br>";
    } else $error .= "<h3>Por favor, rellena correctamente la información necesaria</h3><br>";
}

// SI SE PULSA EL BOTÓN BORRAR
if (isset($_POST['borrar'])) {
    $id_cita = $_POST['id_cita'];
    DB::borraCita($id_cita);
    $mensaje .= "<h3>La cita ha sido borrada</h3>";
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
            <div class="row campo">
                <div class="negrita col-12">
                    <h3 class="text-center my-4 border border-warning rounded p-3">MODIFICAR CITA</h3>
                </div>
            </div>
            <div class="row campo m-auto justify-content-center">
                <div class="col-2 text-center">
                    <label for="fecha" class="negrita">Selecciona la fecha</label>
                </div>
                <div class="col-4">
                    <input type="date" name="fecha" class="form-control">
                </div>
                <div class='col-3'>
                    <input type='submit' name='buscar' value='Buscar' class="btn btn-primary"/>
                </div>
                <div>
        </form>
    </div>
    <br>
    <div class="container">
        <?php
        echo obtieneCitas();
        ?>
    </div>
    <div class="container">
        <?php
        if (isset($_POST['editar'])) {
            echo modificaCita();
        }
        ?>
    </div>
    <br>
    <div class="container d-grid gap-2 d-md-block">
        <input type="button" value="Volver" onclick="window.location.href='../citas.php'" class="btn btn-warning">
    </div>
</main>

<?php include "../common/footer.php"; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>