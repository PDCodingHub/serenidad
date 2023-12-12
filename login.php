<?php
require_once('./common/DB.php');

// Comprobamos si ya se ha enviado el formulario
$error = "";

if (isset($_POST['enviar'])) {

    if (empty($_POST['usuario']) || empty($_POST['contraseña']))
        $error = "Debes introducir un nombre de usuario y una contraseña";
    else {
        // Comprobamos las credenciales con la base de datos
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];

        $verificado = DB::verificaUsuario($usuario, $contraseña);

        if ($verificado) {
            session_start();
            $_SESSION['usuario'] = $usuario;

            //obtiene el rol del usuario y lo guarda en la sesión
            $rol = DB::obtieneRol($usuario);
            $_SESSION['rol'] = $rol[0];

            //si es administrador, se dirige a la página correspondiente
            if (($rol[0] == "Administrador") || ($rol[0] == "Administradora")) {
                header("Location: admin.php");
            } // en caso contrario, entra en la página de incidencias
            else {
                header("Location: incidencias.php");
            }
        } else {
            // Si las credenciales no son válidas, se vuelven a pedir
            $error .= "Usuario o contraseña no válidos!";
        }
    }

    if (!empty($error)) {

    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERENIDAD</title>
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
                    <a class="nav-link active" href="index.php">Inicio</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>
    <div id='login'>
        <form action='login.php' method='post'>
            <fieldset>
                <legend>Login</legend>
                <div><span class='error'><?php echo $error; ?></span></div>
                <div class='campo'>
                    <label for='usuario'>Usuario:</label><br/>
                    <input type='text' name='usuario' id='usuario' maxlength="50"/><br/>
                </div>
                <div class='campo'>
                    <label for='contraseña'>Contraseña:</label><br/>
                    <input type='password' name="contraseña" id="contraseña" maxlength="50"/><br/>
                </div>
                <div class='campo'>
                    <input type='hidden' name="rol" id="rol"/>
                </div>

                <div class='campo'>
                    <input type='submit' name='enviar' value='Enviar'/>
                </div>
            </fieldset>
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
