<?php

require_once('../common/DB.php');
require_once('../common/validaciones.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='../login.php'>identificarse</a>.<br />");

// Comprobamos que el usuario sea administrador
if (isset($_SESSION['rol'])) {
    $rol = $_SESSION['rol'];
    if ($rol == 'Administrador' || $rol == 'Administradora') {

        // Si se pulsa el botón CREAR
        if (isset($_POST['crear'])) {
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $direccion = $_POST['direccion'];
            $localidad = $_POST['localidad'];
            $provincia = $_POST['provincia'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];
            $rol = $_POST['rol'];
            // el usuario será el nombre y apellidos sin espacios y con un número aleatorio de 3 cifras al final
            $creaUsuario = str_replace(' ', '', $nombre) . "." . str_replace(' ', '', $apellidos) . "." . random_int(0, 9) . random_int(0, 9) . random_int(0, 9);
            $usuario = strtolower($creaUsuario);
            // La contraseña será el dni, que luego podrá cambiar el trabajador
            $contraseña = "$dni";

            // comprueba que el trabajador sea mayor de edad
            $compruebaFecha = isMayorEdad($fecha_nacimiento);
            // comprueba que el dni no exista en la base de datos
            $compruebaDni = encuentraDniBbdd($dni);

            $mensaje = "";
            $error = "";
            // si el trabajador es mayor de edad y el dni no existe en la base de datos, se inserta
            if ($compruebaFecha) {
                if (!$compruebaDni) {
                    $inserta = DB::creaTrabajador($dni, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email, $rol, $usuario, $contraseña);

                    if ($inserta > 0) {
                        $mensaje .= "<h2>Trabajador insertado correctamente</h2>";
                    } else
                        $mensaje .= "<h2>No se ha insertado ninguna fila.</h2>";
                } else {
                    $error .= "El DNI ya existe en la base de datos";
                }
            } else {
                $error .= "No puede haber un trabajador menor de edad en la residencia";
            }

        }

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Crear Trabajador</title>
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
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <!-- <li class="nav-item mx-4"> -->
                            <a class="nav-link active" href="../admin.php">Administrador</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="crearPersonaDependiente.php">Crear residente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../logoff.php">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
        //Imprime los errores encontrados
        if (!empty($error)) {
            echo "<div class='container'>";
            echo "<div class='p-5 my-3 border border-danger rounded text-center'>";
            echo "<h3>No ha sido posible crear el trabajador debido a los siguientes errores:</h3>";
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
                        <h2 class="col-12 p-3 my-3 border border-warning rounded text-dark text-center">Inserta los datos del nuevo trabajador</h2>
                    </div>

                    <div class="row">
                        <div class="col-md-1 m-auto">
                            <label for="dni" class="negrita">*DNI:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="text" id="dni" name="dni" placeholder="" class="form-control"
                                   maxlength="9"
                                   pattern="^\d{8}[a-hj-np-tv-zA-HJ-NP-TV-Z]" class="form-control" required>
                        </div>
                        <div class="col-md-1 m-auto">
                            <label for="fecha_nacimiento" class="negrita">*Fecha de nacimiento:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="date" id="fecha_nacimiento" class="form-control" name="fecha_nacimiento"
                                   required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-1 m-auto">
                            <label for='nombre'>*Nombre:</label>
                        </div>
                        <div class="col-md-5">
                            <input type='text' name="nombre" id="nombre" maxlength="50"
                                   pattern="^[A-zÀ-ÿ]{3,}(( [A-zÀ-ÿ]{3,})?)" class="form-control"
                                   title="Puede haber 1 o 2 nombres separados por un espacio. No puede haber números"
                                   required>
                        </div>
                        <div class="col-md-1 m-auto">
                            <label for='apellidos'>*Apellidos:</label>
                        </div>
                        <div class="col-md-5">
                            <input type='text' name="apellidos" id="apellidos" maxlength="50"
                                   pattern="^[A-zÀ-ÿ]{3,} [A-zÀ-ÿ ]{3,}$" class="form-control"
                                   title="Debe haber 2 apellidos separados por un espacio. Debe haber al menos 3 letras en cada uno. No puede haber números"
                                   required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-1 m-auto">
                            <label for='direccion'>*Dirección:</label>
                        </div>
                        <div class="col-md-5">
                            <input type='text' name="direccion" id="direccion" maxlength="50"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="col-md-1 m-auto">
                            <label for='localidad'>*Localidad:</label>
                        </div>
                        <div class="col-md-5">
                            <input type='text' name="localidad" id="localidad" maxlength="50"
                                   class="form-control"
                                   required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-1 m-auto">
                            <label for='provincia'>*Provincia:</label>
                        </div>
                        <div class="col-md-5">
                            <input type='text' name="provincia" id="provincia" maxlength="50"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="col-md-1 m-auto">
                            <label for='telefono'>*Teléfono:</label>
                        </div>
                        <div class="col-md-5">
                            <input type='text' name="telefono" id="telefono" maxlength="9"
                                   title="Debe comenzar por 6,7,9, seguido de 8 números" pattern="^[679]\d{8}$"
                                   class="form-control" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 m-auto">
                            <label for='email'>*Email:</label>
                        </div>
                        <div class="col-md-10">
                            <input type='email' name="email" id="email" maxlength="50" class="form-control"
                                   required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 m-auto">
                            <label for='rol'>*Rol:</label>
                        </div>
                        <div class="col-md-10 d-flex align-content-center">

                            <div class="col text-center">
                                <input type='radio' id='administrador' name='rol' value='Administrador'
                                       class="form-check-input" required>
                                <label for='administrador' class="form-check-label">Administrador</label>
                            </div>
                            <div class="col text-center">
                                <input type='radio' id='educador' name='rol' value='Educador'
                                       class="form-check-input"
                                       required>
                                <label for='educador' class="form-check-label">Educador</label>
                            </div>
                            <div class="col text-center">
                                <input type='radio' id='psicologo' name='rol' value='Psicologo'
                                       class="form-check-input"
                                       required>
                                <label for='psicologo' class="form-check-label">Psicólogo</label>
                            </div>

                            <div class="col text-center">
                                <input type='radio' id='terapeuta' name='rol' value='Terapeuta'
                                       class="form-check-input"
                                       required>
                                <label for='terapeuta' class="form-check-label">Terapeuta</label>
                            </div>
                        </div>
                    </div>
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
            <input type="button" value="Volver" onclick="window.location.href='../admin.php'" class="btn btn-warning">
        </div>
        <div>

        </div>
        <?php include "../common/footer.php" ?>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
        </body>
        </html>

        <?php
        //En caso que el usuario no sea administrador, salta un mensaje y un botón para volver a incidencias
    } else {
        echo '<div class="container">';
//        echo "<div class='p-5 my-3 bg-danger rounded text-center'>";
        echo "<div class='p-5 my-3 border border-danger rounded text-center'>";
        echo "<h1>No tienes permisos para ver el contenido de esta página</h1><br>";
        echo '<div>';
        echo "<form action='../incidencias.php' method='post'>";
        echo "<input type='submit' name='volver' value='Volver a Incidencias' class='btn btn-warning'>";
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>