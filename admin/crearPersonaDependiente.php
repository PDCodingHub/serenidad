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
            $nivel_dependencia = $_POST['nivel_dependencia'];
            $num_habitacion = intval($_POST['num_habitacion']);
            $familiar_referencia = $_POST['familiar_referencia'];
            $nombre_fam_referencia = $_POST['nombre_fam_referencia'];
            $telefono_fam_referencia = $_POST['telefono_fam_referencia'];

            // comprueba que el trabajador sea mayor de edad
            $compruebaFecha = isMayorEdad($fecha_nacimiento);
            // comprueba que el dni no exista en la base de datos
            $compruebaDni = encuentraDniBbdd($dni);
            // comprueba que el número de habitación exista en la base de datos
            $compruebaHabitacion = encuentraNumHabitacion($num_habitacion);

            $mensaje = "";
            $error = "";
            //Si es mayor de edad y no existe la habitación ni el dni en la base de datos, inserta la persona dependiente
            if ($compruebaFecha) {
                if ($compruebaHabitacion == 1) {
                    if (!$compruebaDni) {

                        $inserta = DB::creaPersonaDependiente($dni, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email, $nivel_dependencia, $num_habitacion, $familiar_referencia, $nombre_fam_referencia, $telefono_fam_referencia);

                        if ($inserta > 0) {
                            $mensaje .= "<h3>Persona dependiente insertada correctamente</h3>";
                        } else {
                            $mensaje .= "<h3>No se ha insertado ninguna fila.</h3>";
                        }
                    } else $error .= "<h3>El DNI ya existe en la base de datos</h3>";
                } else $error .= "<h3>El número de habitación ya existe en la base de datos</h3>";
            } else $error .= "<h3>No se admiten menores de edad en la residencia</h3>";
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
                            <a class="nav-link active" href="crearTrabajador.php">Crear Trabajador</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../logoff.php">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <body>
        <?php
        //Imprime los errores encontrados
        if (!empty($error)) {
            echo "<div class='container'>";
            echo "<div class='p-5 my-3 border border-danger rounded text-center'>";
            echo "<h3>No ha sido posible crear el nuevo residente debido a los siguientes errores:</h3>";
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
        <div id='crearDependiente'>
            <form action='' method='post' class="container">
                <!-- TITULO -->
                <div class="row pb-3">
                    <h2 class="col-12 p-3 my-3 border border-warning rounded text-dark text-center">Inserta los datos del nuevo residente</h2>
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
                    <div class="col-md-3 m-auto">
                        <label for='nivel_dependencia'>*Nivel de dependencia:</label>
                    </div>
                    <div class="col-md-9 d-flex align-content-center">

                        <div class="col text-center">
                            <input type='radio' id='grado1' name='nivel_dependencia' value='Grado 1'
                                   class="form-check-input" required>
                            <label for='grado1' class="form-check-label">Grado 1</label>
                        </div>
                        <div class="col text-center">
                            <input type='radio' id='grado2' name='nivel_dependencia' value='Grado 2'
                                   class="form-check-input"
                                   required>
                            <label for='grado2' class="form-check-label">Grado 2</label>
                        </div>
                        <div class="col text-center">
                            <input type='radio' id='grado3' name='nivel_dependencia' value='Grado 3'
                                   class="form-check-input"
                                   required>
                            <label for='grado3' class="form-check-label">Grado 3</label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 m-auto">
                        <label for='num_habitacion'>*Número de habitación:</label>
                    </div>
                    <div class="col-md-4">
                        <input type='number' name="num_habitacion" id="num_habitacion" min="1" max="99"
                               class="form-control" required>
                    </div>
                    <div class="col-md-2 m-auto">
                        <label for='familiar_referencia'>Familiar de referencia:</label>
                    </div>
                    <div class="col-md-4">
                        <input type='text' name="familiar_referencia" id="familiar_referencia" maxlength="50"
                               placeholder="Padre, madre, hermano, hermana, hijo..." class="form-control">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 m-auto">
                        <label for='nombre_fam_referencia'>Nombre y apellidos del familiar:</label>
                    </div>
                    <div class="col-md-4">
                        <input type='text' name="nombre_fam_referencia" id="nombre_fam_referencia" maxlength="50"
                               pattern="^([A-Za-zÀ-ÿ]{3,} ){2,3}[A-Za-zÀ-ÿ]{3,}$"
                               title="Puede haber 1 o 2 nombres y 2 apellidos separados por un espacio. No puede haber números"
                               class="form-control">
                    </div>
                    <div class="col-md-2 m-auto">
                        <label for='telefono_fam_referencia'>Teléfono del familiar de referencia:</label>
                    </div>
                    <div class="col-md-4">
                        <input type='text' name="telefono_fam_referencia" id="telefono_fam_referencia"
                               title="Debe comenzar por 6,7,9, seguido de 8 números" pattern="^[679]\d{8}$"
                               maxlength="9" class="form-control">
                    </div>
                </div>
                <br>
                <div class="row mb-5">
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <input type='submit' name='crear' value='Crear' class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <div class="container d-grid gap-2 d-md-block">
            <!--            <button class="btn btn-primary" type="button">Button</button>-->
            <input type="button" value="Volver" onclick="window.location.href='../admin.php'" class="btn btn-warning">
        </div>
        <?php include "../common/footer.php" ?>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>

        <?php
        //En caso que el usuario no sea administrador, salta un mensaje y un botón para volver a incidencias
    } else {
        echo '<div class="container">';
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