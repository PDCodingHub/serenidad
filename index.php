<?php
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
                    <a class="nav-link active" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>
    <section id="bienvenida" class="d-flex flex-column text-center align-items-center justify-content-center bg-opacity-10">

        <h2 class="mb-5 display-1">Bienvenidos</h2>

        <p class="lead px-5">La Residencia Serenidad es un centro privado especializado en la atención integral a personas
            con problemas de salud mental. Nuestro objetivo es proporcionar a nuestros residentes un entorno seguro,
            acogedor y rehabilitador que les permita alcanzar su máximo nivel de autonomía y bienestar.</p>
    </section>

    <section id="bondades" class="d-flex flex-column align-items-center justify-content-center">

        <h2 class="display-4">Nuestras bondades</h2>

        <ul class="lead d-flex flex-column flex-md-row items-center justify-content-center text-center">
            <li><b>Profesionalidad:</b></br>Nuestro equipo de profesionales está formado por especialistas en salud mental
                con amplia experiencia en el trabajo con personas con trastornos mentales graves.
            </li>
            <li><b>Personalización:</b></br>Ofrecemos un servicio personalizado adaptado a las necesidades individuales de
                cada residente.
            </li>
            <li><b>Integración:</b></br>Trabajamos para promover la integración de nuestros residentes en la sociedad,
                facilitándoles la participación en actividades sociales y culturales.
            </li>
        </ul>
    </section>

    <section id="servicios" class="d-flex flex-column align-items-center justify-content-center">

        <h2 class="display-4">Nuestros servicios</h2>
        <ul class="lead d-flex flex-column flex-md-row align-items-center justify-content-center text-center">
            <li><b>Alojamiento:</b></br>Ofrecemos alojamiento en habitaciones </br>individuales, todas ellas
                equipadas con todo </br>lo necesario para garantizar el confort y la seguridad de nuestros residentes.
            </li>
            <li><b>Manutención:</b></br>Ofrecemos una dieta equilibrada </br>y adaptada a las necesidades de nuestros residentes.
            </li>
            <li><b>Rehabilitación psicosocial:</b></br>Ofrecemos un programa de rehabilitación </br>psicosocial personalizado que
                ayuda a nuestros residentes a mejorar su autonomía personal y social.
            </li>
        </ul>
    </section>

    <section id="contacto" class="d-flex text-center flex-column align-items-center justify-content-center">

        <h2>Contacto</h2>
        <p class="lead py-2">Si estás interesado en conocer más sobre nuestra residencia, no dudes en ponerte en contacto con
            nosotros.</p>

        <ul class="d-flex flex-column flex-md-row">
            <li class="px-4"><b>Nombre de la residencia</b></li>
            <li class="px-4"><b>Dirección</b></li>
            <li class="px-4"><b>Teléfono</b></li>
            <li class="px-4"><b>Correo electrónico</b></li>
        </ul>

    </section>

</main>
    <?php include "common/footer.php"; ?>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
