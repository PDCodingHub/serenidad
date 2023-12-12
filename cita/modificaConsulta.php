<?php
require_once('../common/DB.php');
require_once('../common/validaciones.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

function editarConsulta()
{
    if (isset($_POST['modificar'])) {

        $id_consulta = $_POST['id_consulta'];
        $id_cita = $_POST['id_cita'];
        $nombre_medico = $_POST['nombre_medico'];
        $motivo_visita = $_POST['motivo_visita'];
        $descripcion = $_POST['descripcion'];
        $diagnostico = $_POST['diagnostico'];
        echo "<h2>Modificar consulta seleccionada</h2>";
        echo "<hr>";
        echo "<br>";
        echo "<div>";
        echo "<form action='' method='post'>";
        echo "<fieldset>";
        echo "<legend>Modifica los datos que desees de la consulta</legend>";
        echo "</fieldset>";

        echo "<div class='campo'>";
        echo "<label for='nombre_medico'>Nombre del médico:</label>";
        echo "<input type='text' name='nombre_medico' value='" . $nombre_medico . "'><br>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='motivo_visita'>Motivo de la visita:</label>";
        echo "<textarea type='text' name='motivo_visita' required>" . $motivo_visita . " </textarea><br>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='descripcion'>Descripción de la visita:</label>";
        echo "<textarea type='text' name='descripcion' required>" . $descripcion . " </textarea><br>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='diagnostico'>Diagnostico:</label>";
        echo "<input type='text' name='diagnostico' value='" . $diagnostico . "' required><br>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<input type='hidden' name='id_consulta' value='" . $id_consulta . "'>";
        echo "<input type='hidden' name='id_cita' value='" . $id_cita . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<input type='submit' name='modificarConsulta' value='Modificar consulta'>";
        echo "</div>";

        echo "</form>";
    }
}

if (isset($_POST['modificarConsulta'])) {

    $id_consulta = $_POST['id_consulta'];
    //$id_cita = $_POST['id_cita'];
    $nombre_medico = $_POST['nombre_medico'];
    $motivo_visita = $_POST['motivo_visita'];
    $descripcion = $_POST['descripcion'];
    $diagnostico = $_POST['diagnostico'];

    $actualiza = DB::modificaConsulta($nombre_medico, $motivo_visita, $descripcion, $diagnostico, $id_consulta);

    if ($actualiza) {
        echo "<h3>Consulta modificada correctamente</h3>";
    } else {
        echo "<h3>No se ha modificado ningún dato</h3>";
    }

    echo "<form action='../persona_dependiente.php' method='post'>";
    echo "<input type='submit' name='volver' value='Volver a Perfil Residentes'>";
    echo "</form>";

//        $db = new DB();
//        $db->conectar();
//
//        $consulta = "UPDATE consulta SET nombre_medico = '$nombre_medico', motivo_visita = '$motivo_visita', descripcion = '$descripcion', diagnostico = '$diagnostico' WHERE id_consulta = '$id_consulta'";
//
//        $db->ejecutar($consulta);
//
//        $db->desconectar();
//
//        header("Location: ../paciente/consulta.php?id_cita=$id_cita");
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
<div>
    <?php echo editarConsulta() ?>
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