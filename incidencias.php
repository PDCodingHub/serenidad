<?php
require_once('common/DB.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

function filtro()
{
    if (isset($_POST['filtrar'])) {

        $id = null;
        $fecha = null;

        if (isset($_POST['id_dependiente']))
            $id = $_POST['id_dependiente'];
        if (!empty($_POST['fecha']))
            $fecha = $_POST['fecha'];

        $incidencias = DB::paginacionIncidencias($id, $fecha);
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
                <!-- <li class="nav-item mx-4"> -->
                <!--                <li class="nav-item">-->
                <!--                    <a class="nav-link active" href="../incidencias.php">Incidencias</a>-->
                <!--                </li>-->
                <li class="nav-item mx-3">
                    <a class="nav-link" href="incidencia/crearIncidencia.php">Crear nueva incidencia</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="incidencia/modificarIncidencia.php">Modificar/Borrar incidencia</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link active" href="citas.php">Citas</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link active" href="persona_dependiente.php">Residentes</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link active" href="perfil.php">Perfil trabajador</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link active" href="logoff.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>
    <div class="container text-center my-5 border border-warning">
        <h1>INCIDENCIAS</h1>
    </div>

    <form action="incidencias.php" method="post" class="container">
        <div id="selectId" class="row m-auto justify-content-center">
            <div class="col-md-1">
                <label for="id">ID:</label>
            </div>
            <div class="col-md-5">
                <select id="id_dependiente" name="id_dependiente" class="form_control">
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
            <div class="col-md-1">
                <label for="fecha">Fecha:</label>
            </div>
            <div class="col-md-5">
                <input type="date" name="fecha" id="fecha" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center my-3">
                <input type="submit" name="filtrar" value="Filtrar" class="btn btn-success">
            </div>
        </div>
    </form>

    <div id="tablaIncidencias" class="container">
        <?php
        if (isset($_POST['filtrar']))
            echo filtro();
        else
            echo DB::paginacionIncidencias(null, null);
        ?>
    </div>
</main>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

<?php include "common/footer.php"; ?>
</body>
</html>