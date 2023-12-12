<?php
// Recuperamos la información de la sesión
session_start();

// Y la eliminamos
//session_unset();
session_destroy();
$tiempo = 1000000; // 1 segundo en microsegundos
usleep($tiempo);
header('Location: login.php');
?>
