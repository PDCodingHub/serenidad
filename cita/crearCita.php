<?php
require_once('../common/DB.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

if (isset($_POST['crear'])) {

    $mensaje = "";
    $error = "";
    if (isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['centro']) && isset($_POST['localidad']) && isset($_POST['provincia']) && isset($_POST['direccion']) && isset($_POST['especialidad']) && isset($_POST['id_dependiente2'])) {
        $hora = $_POST['hora'];
        $centro = $_POST['centro'];
        $localidad = $_POST['localidad'];
        $provincia = $_POST['provincia'];
        $direccion = $_POST['direccion'];
        $planta = $_POST['planta'];
        $especialidad = $_POST['especialidad'];
        $id_dependiente = $_POST['id_dependiente2'];
        $fecha = $_POST['fecha'];
        // pasamos la fecha a Date y comparamos con la fecha actual
        $fechaDate = strtotime($fecha);
        $fechaActual = date("Y-m-d");
        $fechaActualDate = strtotime($fechaActual);


        if ($fechaDate >= $fechaActualDate) {

            $inserta = DB::creaCitas($fecha, $hora, $centro, $localidad, $provincia, $direccion, $planta, $especialidad, $id_dependiente);

            if ($inserta > 0) {
                $mensaje .= "<h3>Cita creada correctamente</h3>";
            } else {
                $mensaje .= "<h3>No se ha creado ninguna cita.</h3>";
            }
        } else {
            $error .= "<h3>La fecha almacenada no puede ser anterior a la fecha actual.</h3>";
        }
    } else {
        $error .= "<h3>No puede quedar vacío el campo del residente</h3>";
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
                    <a class="nav-link active" href="incidencias.php">Incidencias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../citas.php">Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="modificaCita.php">Modificar / Borrar alguna cita</a>
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
    <div id='crearTrabajador'>
        <form action='' method='post' class="container">
            <div class="row pb-3">
                <h2 class="col-12 p-3 my-3 border border-warning rounded text-dark text-center">Inserta los datos de la
                    cita que quieres crear</h2>
            </div>

            <div class="row">
                <div class="col-md-2 m-auto text-center">
                    <label for='fecha' class="negrita">*Fecha de la cita:</label>
                </div>
                <div class="col-md-4 p-0">
                    <input type='date' name="fecha" id="fecha" class="form-control" required/>
                </div>
                <div class="col-md-2 m-auto text-center">
                    <label for="fecha_nacimiento" class="negrita">*Hora de la cita:</label>
                </div>
                <div class="col-md-4">
                    <input type='time' name="hora" id="hora" min="08:00" max="21:00" class="form-control" required/>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 m-auto text-center">
                    <label for='centro' class="negrita">*Centro:</label>
                </div>
                <div class="col-md-4">
                    <input type='text' name='centro' id='centro' placeholder="Hospital / Centro de salud..."
                           class="form-control" required/>
                </div>
                <div class="col-md-2 m-auto text-center">
                    <label for='localidad' class="negrita">*Localidad:</label>
                </div>
                <div class="col-md-4">
                    <input type='text' name='localidad' id='localidad' class="form-control" required/>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 m-auto text-center">
                    <label for='provincia' class="negrita">*Provincia:</label>
                </div>
                <div class="col-md-4">
                    <input type='text' name='provincia' id='provincia' placeholder="Cáceres" class="form-control"
                           required/>
                </div>
                <div class="col-md-2 m-auto text-center">
                    <label for='direccion' class="negrita">*Dirección:</label>
                </div>
                <div class="col-md-4">
                    <input type='text' name='direccion' id='direccion' class="form-control" required/>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 m-auto text-center">
                    <label for='planta' class="negrita">Planta:</label>
                </div>
                <div class="col-md-4">
                    <input type='text' name='planta' id='planta' placeholder="Semisótano, Planta Baja, 1º..."
                           class="form-control"/>
                </div>
                <div class="col-md-2 m-auto text-center">
                    <label for='especialidad' class="negrita">*Especialidad:</label>
                </div>
                <div class="col-md-4">
                    <input type='text' name='especialidad' id='especialidad'
                           placeholder="Cabecera, Psiquiatría, Neumología..." class="form-control" required/>
                </div>
            </div>
            <br>
            <?php
            //Comprueba si se ha pasado el id del dependiente por POST desde la página persona_dependiente.php
            if (isset($_POST['id_dependiente'])) {
                echo "<input type='hidden' name='id_dependiente2' value='" . intval($_POST['id_dependiente']) . "'>";

            } else {
                //Si se crea una nueva cita general, se muestra un select con todos los residentes
                echo "<div class='row justify-content-center'>";
                echo "<div class='col-md-4 text-center'>";
                echo "<label for='id_dependiente2' class='negrita'>Selecciona el nombre del residente:</label>";
                echo "</div>";
                echo "<div class='col-md-4'>";
                echo "<select id='id_dependiente2' name='id_dependiente2' class='form-control'>";
                echo "<option selected disabled>Selecciona residente</option>";
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
            }
            ?>
            <br><br>
            <div class="row mb-5">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <input type='submit' name='crear' value='Crear' class="btn btn-primary">
                </div>
            </div>
        </form>
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