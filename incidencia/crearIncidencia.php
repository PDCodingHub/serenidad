<?php
require_once('../common/DB.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

//var_dump($_POST);

if (isset($_POST['crear'])) {

    $mensaje = "";
    $error = "";

    $fechaDate = date("Y-m-d");
    $fecha = date("Y-m-d", strtotime($fechaDate));
    $descripcion = $_POST['descripcion'];
    $usuario = $_SESSION['usuario'];
    $id = DB::obtieneIdTrabajador($usuario);
    $id_trabajador = $id['0'];
    if (isset($_POST['id_dependiente'])){
        $id_dependiente = $_POST['id_dependiente'];
    } else{
        $error .= "<h5>No se ha seleccionado ningún residente.</h5>";
    }


    if (isset($id_dependiente) && isset($descripcion) && isset($id_trabajador)) {
        $inserta = DB::crearIncidencia($fecha, $descripcion, $id_trabajador, $id_dependiente);
        if ($inserta > 0) {
            $mensaje .= "<h5>Incidencia creada correctamente</h5>";
        } else {
            $error .= "<h5>No se ha insertado ninguna fila.</h5>";
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
                    <a class="nav-link" href="../incidencias.php">Incidencias</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="modificarIncidencia.php">Modificar/Borrar incidencia</a>
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
        echo "<h3>No ha sido posible crear la incidencia debido a los siguientes errores:</h3>";
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
    <div id='crearIncidencia'>
        <form action='' method='post' class="container">

            <legend class="text-center border border-warning p-3 mb-3">Inserta la información para la nueva incidencia
            </legend>

            <div id="selectDependiente">
                <div class="row justify-content-center">
                    <div class="col-md-1 text-align-center">
                        <label for="id_dependiente" class="negrita">Dependiente:</label>
                    </div>
                    <div class="col-md-4">
                        <select id="id_dependiente" name="id_dependiente" class="form-control">
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

                <div class="container">
                    <div class="form-group">
                        <label for="exampleTextarea" class="negrita">Descripción de la incidencia:</label>
                        <textarea class="form-control" id="exampleTextarea" name="descripcion" rows="5"
                                  required></textarea>
                    </div>
                </div>
                <br>
                <div class="row mb-5">
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <input type='submit' name='crear' value='Crear' class="btn btn-primary">
                    </div>
                </div>
            </div>
        </form>
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
