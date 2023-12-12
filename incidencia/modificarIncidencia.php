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

function imprimeIncidenciasTrabajador()
{
    $id = DB::obtieneIdTrabajador($_SESSION['usuario']);
    $id_trabajador = $id['0'];

    $incidencias = DB::obtieneIncidenciasTrabajador($id_trabajador);

    if ($incidencias == null) {
        echo "<h3>No hay incidencias para este trabajador</h3>";
    } else {

        echo "<table class='table table-striped table-hover caption-top'>";
        echo "<tr>";
        echo "<th>FECHA</th>";
        echo "<th>RESIDENTE</th>";
        echo "<th>INCIDENCIA</th>";
        echo "<th>TRABAJADOR</th>";
        echo " <th>EDITAR</th>";
        echo " <th>BORRAR</th>";
        echo "</tr>";
        echo "<tbody></tbody>";
        foreach ($incidencias as $incidencia) {
            //var_dump($incidencia, $id_trabajador);
            echo "<form method='post' action=''>";
            echo "<tr>";
            echo "<td name='fecha'>" . $incidencia['fecha'] . "</td>";
            echo "<td name='nombre_dependiente'>" . $incidencia['nombre_dependiente'] . "</td>";
            echo "<td name='descripcion'>" . $incidencia['descripcion'] . "</td>";
            echo "<td name='nombre_trabajador'>" . $incidencia['nombre_trabajador'] . "</td>";
            echo "<td>";
            echo "<input type='hidden' name='fecha' value='" . $incidencia['fecha'] . "'>";
            echo "<input type='hidden' name='nombre_dependiente' value='" . $incidencia['nombre_dependiente'] . "'>";
            echo "<input type='hidden' name='descripcion' value='" . $incidencia['descripcion'] . "'>";
            echo "<input type='hidden' name='nombre_trabajador' value='" . $incidencia['nombre_trabajador'] . "'>";
            echo "<input type='hidden' name='id_trabajador' value='" . $id_trabajador . "'>";
            echo "<input type='hidden' name='id_incidencia' value='" . $incidencia['id_incidencia'] . "'>";
            echo "<input type='submit' name='editar' value='Editar' class='btn btn-success'>";
            echo "</td>";
            echo "</form>";

            echo "<td>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='id_incidencia' value='" . $incidencia['id_incidencia'] . "'>";
            echo "<input type='submit' name='borrar' value='Borrar' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de que quieres borrar esta incidencia?\");'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br><hr><br>";
    }
}

//Si se ha pulsado el botón Editar, llama a esta función
function edita()
{
    $fecha = $_POST['fecha'];
    $nombre_dependiente = $_POST['nombre_dependiente'];
    $descripcion = $_POST['descripcion'];
    $nombre_trabajador = $_POST['nombre_trabajador'];
    $id_trabajador = $_POST['id_trabajador'];
    $id_incidencia = $_POST['id_incidencia'];
    $id_dependienteArray = DB::obtieneIdDependiente($id_incidencia);
    $id_dependiente = $id_dependienteArray['0'];

    echo "<form action='modificarIncidencia.php' method='post' class='container'>";
    echo "<legend class='text-center border border-success p-3 mb-3'>Modificar incidencia</legend>";

    echo "<div class='row justify-content-center'>";
    echo "<div class='col-md-1'>";
    echo "<label for='fecha'>Fecha:</label>";
    echo "</div>";
    echo "<div class='col-md-4'>";
    echo "<input type='date' name='fecha' value='" . $fecha . "' class='form-control'>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "<label for='id_dependiente2'>Selecciona otro residente si deseas modificarlo:</label><br>";
    echo "</div>";
    echo "<div class='col-md-5'>";
    echo "<select id='id_dependiente2' name='id_dependiente2' class='form-control'>";
    echo "<option selected disabled>Seleccione el nombre del residente</option>";

    $dependiente = DB::selectDependiente();
    // recorremos el array e imprimimos cada opción del mismo
    for ($i = 0; $i < count($dependiente); $i++) {
        //introducimos como valor el código e imprimimos el nombre
        echo "<option value='" . $dependiente[$i]["id_dependiente"] . "'>" . $dependiente[$i]["nombre"] . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "</div>";

    echo "<br>";
    echo "<div class='row justify-content-center'>";
    echo "<div class='col-md-4'>";
    echo "<label for=''>El residente actual es: <span class='negrita'>$nombre_dependiente</span></label>";
    echo "</div>";
    echo "</div>";

    ?>
    <div class="container">
        <div class="form-group">
            <label for="exampleTextarea" class="negrita">Descripción de la incidencia:</label>
            <textarea class="form-control" id="exampleTextarea" name="descripcion" rows="5"
                      required><?php echo $descripcion; ?></textarea>
        </div>
    </div>
    <?php

    echo "<br>";
    echo "<div class='row justify-content-center'>";
    echo "<div class='col-md-2'>";
    echo "<label for='nombre_trabajador'>Nombre del trabajador:</label>";
    echo "</div>";
    echo "<div class='col-md-4'>";
    echo "<input type='text' name='nombre_trabajador' class='form-control' value='" . $nombre_trabajador . "' readonly><br>";
    echo "</div>";
    echo "<br>";

    echo "<div class='row mb-5'>";
    echo "<div class='d-grid gap-2 col-6 mx-auto'>";
    echo "<input type='hidden' name='id_incidencia' value='" . $id_incidencia . "'>";
    echo "<input type='hidden' name='id_dependiente' value='" . $id_dependiente . "'>";
    echo "<input type='submit' name='modificar' value='Modificar' class='btn btn-primary'>";
    echo "</div>";
    echo "</div>";
    echo "</form>";
}

if (isset($_POST['modificar'])) {
    $fecha = $_POST['fecha'];
    if (isset($_POST['id_dependiente2'])) {
        $id_dependiente = $_POST['id_dependiente2'];
    } else {
        $id_dependiente = $_POST['id_dependiente'];
    }
    $descripcion = $_POST['descripcion'];
    $nombre_trabajador = $_POST['nombre_trabajador'];
    $id_incidencia = $_POST['id_incidencia'];

    $compruebaFecha = isFechaMayorActual($fecha);
    if ($compruebaFecha == false) {

        if (isset($fecha) && isset($id_dependiente) && isset($descripcion) && isset($id_incidencia)) {
            $filas = DB::actualizaIncidencia($fecha, $descripcion, $id_dependiente, $id_incidencia);

            if ($filas > 0) {
                $mensaje .= "<h5>La incidencia ha sido modificada</h5>";
            } else {
                $mensaje .= "<h5>No se ha cambiado ningún dato de la incidencia anterior</h5>";
            }
        } else {
            $error .= "<h5>Faltan datos. No se ha podido modificar la incidencia</h5>";
        }
    } else $error .= "<h5>La fecha de la incidencia no puede ser mayor que la actual</h5>";
}

if (isset($_POST['borrar'])) {
    $id_incidencia = $_POST['id_incidencia'];
    DB::borrarIncidencia($id_incidencia);
    $mensaje .= "<h3>La incidencia ha sido borrada</h3>";
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
                    <a class="nav-link" href="../incidencias.php">Incidencias</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="crearIncidencia.php">Crear incidencia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../citas.php">Citas</a>
                </li>
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
        echo "<h3>No ha sido posible modificar la incidencia debido a los siguientes errores:</h3>";
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

    <div class="container">
        <!--    <form action='login.php' method='post'>-->
        <fieldset class="row">
            <legend class="text-center border border-warning p-3 my-3">Lista de incidencias del usuario: <span
                        class="negrita"><?= $_SESSION['usuario'] ?></span></legend>
            <div class='campo'>
                <?= imprimeIncidenciasTrabajador(); ?>
            </div>
        </fieldset>
        <!--    </form>-->
    </div>
    <div>
        <?php
        if (isset($_POST['editar'])) {
            echo edita();
        }
        ?>
    </div>
    <br>
    <div class="container d-grid gap-2 d-md-block">
        <input type="button" value="Volver" onclick="window.location.href='../incidencias.php'" class="btn btn-warning">
    </div>
</main>

<?php include "../common/footer.php"; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>

