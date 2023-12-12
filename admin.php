<?php

require_once('common/DB.php');

// Recuperamos la información de la sesión
session_start();

// Comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario'])) {
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");
}

// Comprobamos que el usuario sea administrador
if (isset($_SESSION['rol'])) {
    $rol = $_SESSION['rol'];
    if ($rol == 'Administrador' || $rol == 'Administradora') {

        if (isset($_POST['borrar'])) {
            $dni = $_POST['dni'];
            DB::borraPersona($dni);
            //echo "<h3>Persona borrada correctamente</h3>";
        }

        function mostrarTrabajadores()
        {
            //llamo a la función de getFamilia()
            $trabajadores = DB::obtieneListaTrabajadores();
            // recorremos el array e imprimimos cada elemento


            for ($i = 0; $i < count($trabajadores); $i++) {
                $elemento = $trabajadores[$i];
                //introducimos como valor el código e imprimimos el nombre corto del producto
                echo "<form method='post' action='admin/actualizaTrabajador.php'>";
                echo "<tr>";
                echo "<td name='nombre'>" . $elemento['nombre'] . "</td>";
                echo "<td name='apellidos' value='" . $elemento['apellidos'] . "'>" . $elemento['apellidos'] . "</td>";
                echo "<td name='dni_persona'>" . $elemento['dni_persona'] . "</td>";
                echo "<td name='rol'>" . $elemento['rol'] . "</td>";
                echo "<td>";
                echo "<input type='hidden' name='nombre' value='" . $elemento['nombre'] . "'>";
                echo "<input type='hidden' name='apellidos' value='" . $elemento['apellidos'] . "'>";
                echo "<input type='hidden' name='dni' value='" . $elemento['dni_persona'] . "'>";
                echo "<input type='hidden' name='rol' value='" . $elemento['rol'] . "'>";
                echo "<input type='submit' name='editar' value='Editar' class='btn border border-success'>";
                echo "</td>";
                echo "</form>";
                echo "<td>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='dni' value='" . $elemento['dni_persona'] . "'>";
                echo "<input type='submit' name='borrar' value='Borrar' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de que quieres borrar esta persona?\");'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        }

        function mostrarDependientes()
        {
            //llamo a la función de getFamilia()
            $dependientes = DB::obtieneListapeqDependientes();
            // recorremos el array e imprimimos cada elemento
            for ($i = 0; $i < count($dependientes); $i++) {
                $elemento = $dependientes[$i];

                echo "<form method='post' action='admin/actualizaPersonaDependiente.php'>";
                echo "<tr>";
                echo "<td name='nombre'>" . $elemento['nombre'] . "</td>";
                echo "<td name='apellidos' value='" . $elemento['apellidos'] . "'>" . $elemento['apellidos'] . "</td>";
                echo "<td name='dni_persona'>" . $elemento['dni_persona'] . "</td>";
                echo "<td name='habitacion'>" . $elemento['num_habitacion'] . "</td>";
                echo "<td>";
                echo "<input type='hidden' name='nombre' value='" . $elemento['nombre'] . "'>";
                echo "<input type='hidden' name='apellidos' value='" . $elemento['apellidos'] . "'>";
                echo "<input type='hidden' name='habitacion' value='" . $elemento['num_habitacion'] . "'>";
                echo "<input type='hidden' name='dni' value='" . $elemento['dni_persona'] . "'>";
                echo "<input type='submit' name='editar' value='Editar' class='btn border border-success'>";
                echo "</td>";
                echo "</form>";
                echo "<td>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='dni' value='" . $elemento['dni_persona'] . "'>";
                echo "<input type='submit' name='borrar' value='Borrar' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de que quieres borrar esta persona?\");'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
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
                            <a class="nav-link active" href="admin/crearTrabajador.php">Crear trabajador</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="admin/crearPersonaDependiente.php">Crear residente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="logoff.php">Desconectar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>

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
                <div class="row">
                    <div class="col-12">
                        <table class='table table-striped table-hover caption-top'>
                            <caption class="text-center">LISTA DE TRABAJADORES</caption>
                            <tr>
                                <th>NOMBRE</th>
                                <th>APELLIDOS</th>
                                <th>DNI</th>
                                <th>ROL</th>
                                <th>EDITAR</th>
                                <th>BORRAR</th>
                            </tr>
                            <tbody></tbody>
                            <?= mostrarTrabajadores(); ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container my-5">
                <div class="row">
                    <div class="col-12">
                        <table class='table table-striped table-hover caption-top'>
                            <caption class="text-center">LISTA DE RESIDENTES</caption>
                            <tr>
                                <th>NOMBRE</th>
                                <th>APELLIDOS</th>
                                <th>DNI</th>
                                <th>HABITACIÓN</th>
                                <th>EDITAR</th>
                                <th>BORRAR</th>
                            </tr>
                            <tbody></tbody>
                            <?= mostrarDependientes(); ?>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?php include "common/footer.php" ?>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
        </body>
        </body>
        </html>

        <?php
        //En caso que el usuario no sea administrador, salta un mensaje y un botón para volver a incidencias
    } else {
        echo '<div class="container">';
        echo "<div class='p-5 my-3 border border-danger rounded text-center'>";
        echo "<h1>No tienes permisos para ver el contenido de esta página</h1><br>";
        echo '<div>';
        echo "<form action='incidencias.php' method='post'>";
        echo "<input type='submit' name='volver' value='Volver a Incidencias' class='btn btn-warning'>";
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>