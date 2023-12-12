<?php
require_once('common/DB.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

global $error;
global $mensaje;

function muestraInfo()
{
    $trabajador = DB::obtieneInfoTrabajador($_SESSION['usuario']);
    //var_dump($trabajador);
    if (isset($trabajador)) {
        //var_dump($trabajador);
        $nombre = $trabajador['nombre'];
        $apellidos = $trabajador['apellidos'];
        $dni = $trabajador['dni_persona'];
        $fecha_nacimiento = $trabajador['fecha_nacimiento'];
        $direccion = $trabajador['direccion'];
        $provincia = $trabajador['provincia'];
        $localidad = $trabajador['localidad'];
        $telefono = $trabajador['telefono'];
        $email = $trabajador['email'];
        $rol = $trabajador['rol'];
        $usuario = $trabajador['usuario'];
        $contraseña = $trabajador['pass'];
        $id = $trabajador['id_trabajador'];


        ?>

        <form action='' method='post' class="container">
            <div class="row">
                <div class="col-md-1 m-auto">
                    <label for="dni" class="negrita">*DNI:</label>
                </div>
                <div class="col-md-5">
                    <input type="text" id="dni" name="dni_trabajador" placeholder="" class="form-control"
                           maxlength="9"
                           pattern="^\d{8}[a-hj-np-tv-zA-HJ-NP-TV-Z]" class="form-control"
                           value='<?= $dni ?>'
                           readonly>
                </div>
                <div class="col-md-1 m-auto">
                    <label for="fecha_nacimiento" class="negrita">*Fecha de nacimiento:</label>
                </div>
                <div class="col-md-5">
                    <input type="date" id="fecha_nacimiento" class="form-control" name="fecha_nacimiento"
                           value='<?= $fecha_nacimiento ?>' readonly>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1 m-auto">
                    <label for='nombre' class="negrita">*Nombre:</label>
                </div>
                <div class="col-md-5">
                    <input type='text' name="nombre" id="nombre" maxlength="50"
                           pattern="^[A-zÀ-ÿ]{3,}(( [A-zÀ-ÿ]{3,})?)" class="form-control"
                           title="Puede haber 1 o 2 nombres separados por un espacio. No puede haber números"
                           value='<?= $nombre ?>' readonly>
                </div>
                <div class="col-md-1 m-auto">
                    <label for='apellidos' class="negrita">*Apellidos:</label>
                </div>
                <div class="col-md-5">
                    <input type='text' name="apellidos" id="apellidos" maxlength="50"
                           pattern="^[A-zÀ-ÿ]{3,} [A-zÀ-ÿ ]{3,}$" class="form-control"
                           title="Debe haber 2 apellidos separados por un espacio. Debe haber al menos 3 letras en cada uno. No puede haber números"
                           value='<?= $apellidos ?>' readonly>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1 m-auto">
                    <label for='direccion' class="negrita">*Dirección:</label>
                </div>
                <div class="col-md-5">
                    <input type='text' name="direccion" id="direccion" maxlength="50"
                           class="form-control"
                           value='<?= $direccion ?>' readonly>
                </div>
                <div class="col-md-1 m-auto">
                    <label for='localidad' class="negrita">*Localidad:</label>
                </div>
                <div class="col-md-5">
                    <input type='text' name="localidad" id="localidad" maxlength="50"
                           class="form-control"
                           value='<?= $localidad ?>' readonly>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1 m-auto">
                    <label for='provincia' class="negrita">*Provincia:</label>
                </div>
                <div class="col-md-5">
                    <input type='text' name="provincia" id="provincia" maxlength="50"
                           class="form-control"
                           value='<?= $provincia ?>' readonly>
                </div>
                <div class="col-md-1 m-auto">
                    <label for='telefono' class="negrita">*Teléfono:</label>
                </div>
                <div class="col-md-5">
                    <input type='text' name="telefono" id="telefono" maxlength="9"
                           title="Debe comenzar por 6,7,9, seguido de 8 números" pattern="^[679]\d{8}$"
                           class="form-control" value='<?= $telefono ?>' readonly>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 m-auto">
                    <label for='email' class="negrita">*Email:</label>
                </div>
                <div class="col-md-10">
                    <input type='email' name="email" id="email" maxlength="50" class="form-control"
                           value='<?= $email ?>' readonly>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <p>El rol actual es: <span class="negrita"><?= $rol ?></span></p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1 m-auto">
                    <label for='usuario' class="negrita">*Usuario:</label>
                </div>
                <div class="col-md-5">
                    <input type='text' name="usuario" id="usuario" maxlength="50"
                           class="form-control"
                           value='<?= $usuario ?>' readonly>
                </div>
                <div class="col-md-1 m-auto">
                    <label for='pass' class="negrita">*Contraseña:</label>
                </div>
                <div class="col-md-5">
                    <input type='password' name="pass" id="pass" maxlength="50"
                           class="form-control" value='<?= $contraseña ?>' readonly>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <label for='id_trabajador'>*ID Trabajador:</label>
                </div>
                <div class="col-md-3">
                    <input type='text' name="id_trabajador" id="id_trabajador" maxlength="50"
                           class="form-control"
                           value='<?= $id ?>' title='No modificable' readonly required>
                </div>
            </div>
            <input type='hidden' name="rol" value='<?= $rol ?>'>
            <br>
            <div class="row mb-5">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <input type='submit' name='actualizar' value='Actualizar' class="btn btn-primary">
                </div>
            </div>
        </form>

        <?php
    } else echo "No se ha podido recuperar la información del trabajador";
}

function actualizaInfo()
{

if (isset($_POST['actualizar'])) {

//****** ocultos
$dni_trabajador = $_POST['dni_trabajador'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$rol = $_POST['rol'];
$usuario = $_POST['usuario'];
$id_trabajador = $_POST['id_trabajador'];
//****** ocultos
$direccion = $_POST['direccion'];
$localidad = $_POST['localidad'];
$provincia = $_POST['provincia'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$contraseña = $_POST['pass'];

?>
<form action='' method='post' class="container">
    <div class='container'>
        <div class='p-2 my-3 border border-success rounded text-center'>
            <h5>Esta es la información que puedes cambiar</h5>
        </div>

        <div class="row">
            <div class="col-md-1 m-auto">
                <label for='direccion' class="negrita">*Dirección:</label>
            </div>
            <div class="col-md-5">
                <input type='text' name="direccion" id="direccion" maxlength="50"
                       class="form-control"
                       value='<?= $direccion ?>' required>
            </div>
            <div class="col-md-1 m-auto">
                <label for='localidad' class="negrita">*Localidad:</label>
            </div>
            <div class="col-md-5">
                <input type='text' name="localidad" id="localidad" maxlength="50"
                       class="form-control"
                       value='<?= $localidad ?>' required>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-1 m-auto">
                <label for='provincia' class="negrita">*Provincia:</label>
            </div>
            <div class="col-md-5">
                <input type='text' name="provincia" id="provincia" maxlength="50"
                       class="form-control"
                       value='<?= $provincia ?>' required>
            </div>
            <div class="col-md-1 m-auto">
                <label for='telefono' class="negrita">*Teléfono:</label>
            </div>
            <div class="col-md-5">
                <input type='text' name="telefono" id="telefono" maxlength="9"
                       title="Debe comenzar por 6,7,9, seguido de 8 números" pattern="^[679]\d{8}$"
                       class="form-control" value='<?= $telefono ?>' required>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-1">
                <label for='email' class="negrita">*Email:</label>
            </div>
            <div class="col-md-6">
                <input type='email' name="email" id="email" maxlength="50" class="form-control"
                       value='<?= $email ?>' required>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <hr>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <p>Si deseas cambiar la contraseña, rellena los siguientes campos</p>
            </div>
        </div>

        <br>
        <div class="row justify-content-center">
            <div class="col-md-3">
                <label for='pass' class="negrita">*Nueva contraseña:</label>
            </div>
            <div class="col-md-3">
                <input type='password' name="pass2" id="pass2" maxlength="50"
                       class="form-control" value=''>
            </div>
            <div class="col-md-3">
                <label for='pass' class="negrita">*Repite contraseña:</label>
            </div>
            <div class="col-md-3">
                <input type='password' name="pass3" id="pass3" maxlength="50"
                       class="form-control" value=''>
            </div>
        </div>
        <?php
        echo '<br>';
        echo '<br>';
        echo "<div class='row mb-5'>";
        echo "<div class='d-grid gap-2 col-6 mx-auto'>";
        echo "<input type='hidden' name='pass' value='" . $contraseña . "'>";
        echo "<input type='hidden' name='dni_trabajador' value='" . $dni_trabajador . "'>";
        echo "<input type='hidden' name='nombre' value='" . $nombre . "'>";
        echo "<input type='hidden' name='apellidos' value='" . $apellidos . "'>";
        echo "<input type='hidden' name='fecha_nacimiento' value='" . $fecha_nacimiento . "'>";
        echo "<input type='hidden' name='rol' value='" . $rol . "'>";
        echo "<input type='hidden' name='usuario' value='" . $usuario . "'>";
        echo "<input type='hidden' name='id_trabajador' value='" . $id_trabajador . "'>";
        echo "<input type ='submit' name='modificar' value='Modificar' class='btn btn-success'/>";
        echo "</div>";
        echo "</fieldset>";
        echo "</form>";

        }
        }

        if (isset($_POST['modificar'])) {

            //****** ocultos
            $dni_trabajador = $_POST['dni_trabajador'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $rol = $_POST['rol'];
            $usuario = $_POST['usuario'];
            $id_trabajador = $_POST['id_trabajador'];
            //****** ocultos
            $direccion = $_POST['direccion'];
            $localidad = $_POST['localidad'];
            $provincia = $_POST['provincia'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];
            $contraseña1 = $_POST['pass'];
            $contraseña2 = $_POST['pass2'];
            $contraseña3 = $_POST['pass3'];


            //Si los huecos de la contraseña se han dejado en blanco, la contraseña no se ha cambiado

            if (empty($contraseña2) && empty($contraseña3)) {
                $pass = $contraseña1;
                //Si se han rellenado los huecos de la contraseña, se comprueba que coincidan
            } else if (!empty($contraseña2) && !empty($contraseña3)) {
                if ($contraseña2 == $contraseña3) {
                    $pass = $contraseña2;
                } else {
                    $pass = null;
                    $error .= "<h5>Las contraseñas no coinciden</h5>";
                }
            } else if ((empty($contraseña2) && !empty($contraseña3)) || (!empty($contraseña2) && empty($contraseña3))) {
                $pass = null;
                $error .= "<h5>Debes rellenar los dos huecos de la contraseña si deseas modificarla</h5>";
            }

            if (isset($pass)) {

                //esta variable sirve para reutilizar la consulta de actualizar trabajador
                $dniInicial = $dni_trabajador;

                $inserta = DB::actualizaTrabajador($dniInicial, $dni_trabajador, $nombre, $apellidos, $fecha_nacimiento, $direccion, $localidad, $provincia, $telefono, $email, $rol, $usuario, $pass, $id_trabajador);

                if (isset($inserta)) {
                    $mensaje .= "<h5>Los datos se han actualizado correctamente</h5>";
                } else $error .= "<h5>No se ha actualizado ningún dato</h5>";

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
                            <a class="nav-link active" href="citas.php">Citas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="persona_dependiente.php">Residentes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="perfil.php">Perfil trabajador</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="logoff.php">Cerrar sesión</a>
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
            <div class="container text-center border border-warning p-3 mb-5">
                <h2>Información del trabajador con usuario: <?= $_SESSION['usuario'] ?></h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <?php echo muestraInfo() ?>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php echo actualizaInfo() ?>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="container d-grid gap-2 d-md-block">
                <form action="" method="post">
                    <input type="submit" name="volver" value="Cancelar" class="btn btn-warning">
                </form>
            </div>
        </main>

        <?php include "common/footer.php"; ?>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
        </body>
        </html>